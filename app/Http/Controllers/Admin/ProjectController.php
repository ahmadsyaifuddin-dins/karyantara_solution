<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProjectRequest;
use App\Http\Requests\UpdateProjectRequest;
use App\Models\Project;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ProjectController extends Controller
{
    public function index(Request $request)
    {
        $query = Project::query();

        // LOGIKA VISIBILITAS (Shared atau Milik Sendiri)
        $query->where(function ($q) {
            $q->where('is_shared', 1)
                ->orWhere('admin_id', auth()->id());
        });

        // FILTER SEARCH
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('client_name', 'like', "%{$search}%")
                    ->orWhere('skripsi_title', 'like', "%{$search}%")
                    ->orWhere('npm', 'like', "%{$search}%");
            });
        }

        // FILTER STATUS
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // PERHITUNGAN REKAP KEUANGAN (Berdasarkan data yang difilter)
        // Clone query agar tidak mengganggu proses pagination di bawahnya
        $totalNetIncome = (clone $query)->sum('net_income');
        $totalPaid = (clone $query)->sum('paid_amount');
        $totalRemaining = $totalNetIncome - $totalPaid;

        // PAGINATION
        $projects = $query->latest()->paginate(10)->appends($request->query());

        return view('admin.projects.index', compact(
            'projects', 'totalNetIncome', 'totalPaid', 'totalRemaining'
        ));
    }

    public function create()
    {
        return view('admin.projects.create');
    }

    public function store(StoreProjectRequest $request)
    {
        $data = $request->validated();

        // Assign admin_id ke user yang sedang login
        $data['admin_id'] = auth()->id();

        // Bersihkan data mahasiswa jika client type = umum
        if ($data['client_type'] === 'umum') {
            $data['npm'] = null;
            $data['class_name'] = null;
            $data['dospem_1'] = null;
            $data['dospem_2'] = null;
            $data['skripsi_title'] = null;
        }

        Project::create($data);

        return redirect()->route('admin.projects.index')->with('success', 'Data Proyek/Klien berhasil ditambahkan.');
    }

    public function edit(Project $project)
    {
        return view('admin.projects.edit', compact('project'));
    }

    public function update(UpdateProjectRequest $request, Project $project)
    {
        $data = $request->validated();

        if ($data['client_type'] === 'umum') {
            $data['npm'] = null;
            $data['class_name'] = null;
            $data['dospem_1'] = null;
            $data['dospem_2'] = null;
            $data['skripsi_title'] = null;
        }

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
        // Fitur Keamanan Ekstra: Cek apakah project ini private milik admin lain
        if (! $project->is_shared && $project->admin_id !== auth()->id()) {
            abort(403, 'Akses Ditolak: Anda tidak memiliki akses ke data proyek private ini.');
        }

        return view('admin.projects.show', compact('project'));
    }

    public function exportExcel()
    {
        $fileName = 'Laporan_Proyek_Karyantara_'.now()->format('d-m-Y_H-i-s').'.xlsx';

        return Excel::download(new \App\Exports\ProjectsExport, $fileName);
    }

    public function exportPdf()
    {
        // Ambil data (sama seperti logic export Excel)
        $projects = Project::where('is_shared', 1)->orWhere('admin_id', auth()->id())->latest()->get();

        // Load View PDF
        $pdf = Pdf::loadView('admin.projects.pdf.export', compact('projects'));

        // Atur ukuran kertas ke A4 (Landscape atau Portrait terserah, kita pakai Portrait)
        $pdf->setPaper('A4', 'portrait');

        $fileName = 'Laporan_Proyek_Karyantara_'.now()->format('d-m-Y_H-i-s').'.pdf';

        return $pdf->stream($fileName);
    }

    public function exportInvoice(Project $project)
    {
        // Fitur Keamanan Ekstra
        if (! $project->is_shared && $project->admin_id !== auth()->id()) {
            abort(403, 'Akses Ditolak: Anda tidak memiliki akses ke data proyek ini.');
        }

        // Load View PDF khusus untuk 1 Invoice
        $pdf = Pdf::loadView('admin.projects.pdf.invoice', compact('project'));

        // Atur ukuran kertas ke A4 Portrait
        $pdf->setPaper('A4', 'portrait');

        // STREAM (Preview di browser) dengan nama file dinamis sesuai nama klien
        $fileName = 'Invoice_MoU_'.str_replace(' ', '_', $project->client_name).'.pdf';

        return $pdf->stream($fileName);
    }
}
