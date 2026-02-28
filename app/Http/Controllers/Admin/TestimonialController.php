<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTestimonialRequest;
use App\Http\Requests\UpdateTestimonialRequest;
use App\Models\Testimonial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class TestimonialController extends Controller
{
    public function index(Request $request)
    {
        $query = Testimonial::query();

        // 1. Logika Pencarian (Search)
        if ($request->filled('search')) {
            $search = $request->search;
            // Gunakan closure agar "OR" tidak merusak kondisi filter status
            $query->where(function ($q) use ($search) {
                $q->where('client_name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('testimonial', 'like', "%{$search}%");
            });
        }

        // 2. Logika Filter Status
        if ($request->filled('status')) {
            if ($request->status === 'published') {
                $query->where('is_approved', 1);
            } elseif ($request->status === 'pending') {
                $query->where('is_approved', 0);
            }
        }

        // 3. Eksekusi Query + appends() agar parameter URL tetap menempel saat pindah page 2, 3, dst.
        $testimonials = $query->latest()->paginate(10)->appends($request->query());

        // Ambil nilai setting auto approve
        $autoApproveSetting = DB::table('settings')->where('key', 'auto_approve_testimonial')->value('value') ?? '0';

        return view('admin.testimonials.index', compact('testimonials', 'autoApproveSetting'));
    }

    public function create()
    {
        return view('admin.testimonials.create');
    }

    public function store(StoreTestimonialRequest $request)
    {
        $data = $request->validated();

        if ($request->hasFile('profile_image')) {
            $data['profile_image'] = $this->uploadImage($request->file('profile_image'));
        }

        // Jika admin yang menambahkan dari panel, otomatis ter-publish (tanpa antrean)
        $data['is_approved'] = 1;

        Testimonial::create($data);

        return redirect()->route('admin.testimonials.index')->with('success', 'Testimonial berhasil ditambahkan dan dipublikasikan.');
    }

    public function edit(Testimonial $testimonial)
    {
        return view('admin.testimonials.edit', compact('testimonial'));
    }

    public function update(UpdateTestimonialRequest $request, Testimonial $testimonial)
    {
        $data = $request->validated();

        if ($request->hasFile('profile_image')) {
            // Hapus gambar lama jika ada
            if ($testimonial->profile_image) {
                File::delete(public_path('uploads/testimonials/'.$testimonial->profile_image));
            }
            $data['profile_image'] = $this->uploadImage($request->file('profile_image'));
        }

        $testimonial->update($data);

        return redirect()->route('admin.testimonials.index')->with('success', 'Testimonial berhasil diperbarui.');
    }

    public function destroy(Testimonial $testimonial)
    {
        if ($testimonial->profile_image) {
            File::delete(public_path('uploads/testimonials/'.$testimonial->profile_image));
        }

        $testimonial->delete();

        return redirect()->route('admin.testimonials.index')->with('success', 'Testimonial berhasil dihapus.');
    }

    public function toggleStatus(Testimonial $testimonial)
    {
        $testimonial->update([
            'is_approved' => ! $testimonial->is_approved,
        ]);

        $statusMessage = $testimonial->is_approved ? 'dipublikasikan ke publik' : 'disembunyikan (Pending)';

        return back()->with('success', "Status testimonial berhasil {$statusMessage}.");
    }

    public function toggleSetting(Request $request)
    {
        // Pastikan nilai hanya 1 atau 0
        $autoApprove = $request->input('auto_approve') == '1' ? '1' : '0';

        // Update atau Insert ke tabel settings
        DB::table('settings')
            ->updateOrInsert(
                ['key' => 'auto_approve_testimonial'],
                ['value' => $autoApprove, 'updated_at' => now()]
            );

        $statusMessage = $autoApprove == '1' ? 'Aktif (Langsung Publish)' : 'Nonaktif (Harus ACC Admin)';

        return back()->with('success', "Pengaturan Guest Submission diubah menjadi: {$statusMessage}.");
    }

    public function bulkAction(Request $request)
    {
        $request->validate([
            'ids' => 'required|array',
            'action' => 'required|string|in:approve,hide,delete',
        ]);

        $ids = $request->ids;

        switch ($request->action) {
            case 'approve':
                Testimonial::whereIn('id', $ids)->update(['is_approved' => 1]);
                $message = count($ids).' data berhasil dipublikasikan.';
                break;
            case 'hide':
                Testimonial::whereIn('id', $ids)->update(['is_approved' => 0]);
                $message = count($ids).' data berhasil disembunyikan.';
                break;
            case 'delete':
                // Hapus file gambar dulu sebelum datanya dihapus
                $items = Testimonial::whereIn('id', $ids)->get();
                foreach ($items as $item) {
                    if ($item->profile_image) {
                        File::delete(public_path('uploads/testimonials/'.$item->profile_image));
                    }
                }
                Testimonial::whereIn('id', $ids)->delete();
                $message = count($ids).' data berhasil dihapus permanen.';
                break;
        }

        return back()->with('success', "Aksi massal berhasil: {$message}");
    }

    // METHOD ACTION ALL (Semua data di database)
    public function actionAll(Request $request)
    {
        $request->validate([
            'action' => 'required|string|in:approve,hide',
        ]);

        if ($request->action == 'approve') {
            Testimonial::query()->update(['is_approved' => 1]);
            $message = 'Semua data testimonial berhasil dipublikasikan.';
        } else {
            Testimonial::query()->update(['is_approved' => 0]);
            $message = 'Semua data testimonial berhasil disembunyikan.';
        }

        return back()->with('success', $message);
    }

    public function show(Testimonial $testimonial)
    {
        return view('admin.testimonials.show', compact('testimonial'));
    }

    // Private method untuk handle upload "Old School"
    private function uploadImage($file)
    {
        $fileName = time().'_'.$file->getClientOriginalName();
        $destinationPath = public_path('uploads/testimonials');
        $file->move($destinationPath, $fileName);

        return $fileName;
    }
}
