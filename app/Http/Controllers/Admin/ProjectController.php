<?php

namespace App\Http\Controllers\Admin;

use App\Exports\ProjectsExport;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProjectRequest;
use App\Http\Requests\UpdateProjectRequest;
use App\Models\Project;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;
use Maatwebsite\Excel\Facades\Excel;

class ProjectController extends Controller
{
    public function index(Request $request)
    {
        $query = $this->buildFilterQuery($request);

        $totalProjects  = (clone $query)->count();
        $totalNetIncome = (clone $query)->sum('net_income');
        $totalPaid      = (clone $query)->sum('paid_amount');
        $totalRemaining = $totalNetIncome - $totalPaid;

        $totalLunas = (clone $query)->whereColumn('paid_amount', '>=', 'net_income')->count();
        $totalBelumLunas = (clone $query)->whereColumn('paid_amount', '<', 'net_income')->count();

        $projects = $query->orderByRaw("CASE WHEN status = 'Selesai' THEN 1 ELSE 0 END ASC")
            ->orderBy('sort_order', 'asc')
            ->latest()
            ->paginate(10)
            ->appends($request->query());

        return view('admin.projects.index', compact(
            'projects', 'totalNetIncome', 'totalPaid', 'totalRemaining', 'totalProjects',
            'totalLunas', 'totalBelumLunas' // <-- Tambahkan ini
        ));
    }

    public function create()
    {
        $users = User::all();
        return view('admin.projects.create', compact('users'));
    }

    public function store(StoreProjectRequest $request)
    {
        $data = $request->validated();
        
        // Set Admin Pengelola
        $data['admin_id'] = auth()->id();
        
        // Format data penugasan dan harga menggunakan helper private
        $data = $this->formatProjectData($data, $request);

        Project::create($data);

        return redirect()->route('admin.projects.index')->with('success', 'Data Proyek/Klien berhasil ditambahkan.');
    }

    public function edit(Project $project)
    {
        $users = User::all();
        return view('admin.projects.edit', compact('project', 'users'));
    }

    public function update(UpdateProjectRequest $request, Project $project)
    {
        $data = $request->validated();
        
        // Format data penugasan dan harga menggunakan helper private
        $data = $this->formatProjectData($data, $request);

        $project->update($data);

        return redirect()->route('admin.projects.index')->with('success', 'Data Proyek/Klien berhasil diperbarui.');
    }

    public function destroy(Project $project)
    {
        $project->delete();
        return redirect()->route('admin.projects.index')->with('success', 'Data berhasil dihapus.');
    }

    public function show(Project $project)
    {
        $this->authorizeAccess($project);
        return view('admin.projects.show', compact('project'));
    }

    public function exportExcel()
    {
        $fileName = 'Laporan_Proyek_Karyantara_' . now()->format('d-m-Y_H-i-s') . '.xlsx';
        return Excel::download(new ProjectsExport, $fileName);
    }

    public function exportPdf()
    {
        $projects = Project::where('is_shared', 1)
            ->orWhere('admin_id', auth()->id())
            ->orderByRaw("CASE WHEN status = 'Selesai' THEN 1 ELSE 0 END ASC")
            ->orderBy('sort_order', 'asc')
            ->latest()
            ->get();

        $pdf = Pdf::loadView('admin.projects.pdf.export', compact('projects'))
            ->setOptions([
                'chroot'  => base_path(),              // Izinkan baca folder laravel (akses image/css lokal)
                'tempDir' => storage_path('app')       // Hindari folder /tmp server yang sering diblokir
            ])
            ->setPaper('A4', 'portrait');

        $fileName = 'Laporan_Proyek_Karyantara_' . now()->format('d-m-Y_H-i-s') . '.pdf';

        return $pdf->stream($fileName);
    }

    public function exportInvoice(Project $project)
    {
        $this->authorizeAccess($project);

        $pdf = Pdf::loadView('admin.projects.pdf.invoice', compact('project'))
            ->setOptions([
                'chroot'  => base_path(),              // Izinkan baca folder laravel
                'tempDir' => storage_path('app')       // Hindari folder /tmp server yang sering diblokir
            ])
            ->setPaper('A4', 'portrait');

        $fileName = 'Invoice_MoU_' . str_replace(' ', '_', $project->client_name) . '.pdf';

        return $pdf->stream($fileName);
    }

    public function priorityBoard()
    {
        $projects = Project::where('status', '!=', 'Selesai')
            ->where(function ($q) {
                $q->where('is_shared', 1)->orWhere('admin_id', auth()->id());
            })
            ->orderBy('sort_order', 'asc')
            ->latest()
            ->get();

        return view('admin.projects.priority', compact('projects'));
    }

    public function updatePriority(Request $request)
    {
        $orders = $request->input('orders'); 

        if ($orders) {
            foreach ($orders as $index => $id) {
                Project::where('id', $id)->update(['sort_order' => $index]);
            }
            return response()->json(['success' => true, 'message' => 'Prioritas berhasil diperbarui!']);
        }

        return response()->json(['success' => false, 'message' => 'Gagal memperbarui urutan.']);
    }

    
    // PRIVATE HELPER METHODS (Modularisasi Logika)
    /**
     * Membangun base query untuk filtering dan pencarian
     */
    private function buildFilterQuery(Request $request): Builder
    {
        $query = Project::query()->where(function ($q) {
            $q->where('is_shared', 1)->orWhere('admin_id', auth()->id());
        });

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('client_name', 'like', "%{$search}%")
                    ->orWhere('skripsi_title', 'like', "%{$search}%")
                    ->orWhere('npm', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

       if ($request->filled('payment_status')) {
        if ($request->payment_status === 'lunas') {
            $query->whereColumn('paid_amount', '>=', 'net_income');
        } elseif ($request->payment_status === 'belum_lunas') {
            $query->whereColumn('paid_amount', '<', 'net_income');
        }
    }

        return $query;
    }

    /**
     * Memformat logika harga dan penugasan yang tadinya berulang di store() & update()
     */
    private function formatProjectData(array $data, Request $request): array
    {
        if ($data['client_type'] === 'mahasiswa' && !empty($data['skripsi_package'])) {
            $pkg = $data['skripsi_package'];
            $data['app_price'] = $data['app_price'] ?? 0;
            $data['writer_price'] = $data['writer_price'] ?? 0;

            // Cek kebutuhan tim (Tambahkan paket sidang)
            $needsProgrammer = in_array($pkg, ['aplikasi', 'keduanya', 'sempro_keduanya', 'sidang_aplikasi', 'sidang_keduanya']);
            $needsWriter = in_array($pkg, ['naskah', 'keduanya', 'sempro_naskah', 'sempro_bab3', 'sempro_keduanya', 'sidang_naskah', 'sidang_keduanya', 'sidang_bab4']);

            // Assign ID Penanggung Jawab
            $data['programmer_id'] = $needsProgrammer ? $request->programmer_id : null;
            $data['writer_id'] = $needsWriter ? $request->writer_id : null;

            // Pastikan harga 0 jika paket tidak butuh role tersebut
            if (!$needsProgrammer) $data['app_price'] = 0;
            if (!$needsWriter) $data['writer_price'] = 0;

            $data['net_income'] = $data['app_price'] + $data['writer_price'];
            
        } else {
            $data = array_merge($data, [
                'skripsi_package' => null,
                'programmer_id'   => null,
                'writer_id'       => null,
                'npm'             => null,
                'class_name'      => null,
                'dospem_1'        => null,
                'dospem_2'        => null,
                'skripsi_title'   => null,
                'app_price'       => 0,
                'writer_price'    => 0,
                'net_income'      => $data['net_income'] ?? 0,
            ]);
        }

        return $data;
    }

    /**
     * Cek otorisasi agar tidak ada duplikasi kode di show() dan exportInvoice()
     */
    private function authorizeAccess(Project $project): void
    {
        if (!$project->is_shared && $project->admin_id !== auth()->id()) {
            abort(403, 'Akses Ditolak: Anda tidak memiliki akses ke data proyek private ini.');
        }
    }
}