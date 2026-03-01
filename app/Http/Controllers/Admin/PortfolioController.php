<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePortfolioRequest;
use App\Http\Requests\UpdatePortfolioRequest;
use App\Models\Portfolio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class PortfolioController extends Controller
{
    public function index(Request $request)
    {
        $query = Portfolio::query()->with('images'); // Load relasi gambar

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('client_name', 'like', "%{$search}%")
                    ->orWhere('category', 'like', "%{$search}%");
            });
        }

        $portfolios = $query->latest()->paginate(10)->appends($request->query());

        return view('admin.portfolios.index', compact('portfolios'));
    }

    public function create()
    {
        return view('admin.portfolios.create');
    }

    public function store(StorePortfolioRequest $request)
    {
        $data = $request->validated();

        // 1. Simpan Data Teks Portofolio
        $portfolio = Portfolio::create([
            'title' => $data['title'],
            'category' => $data['category'],
            'description' => $data['description'],
            'client_name' => $data['client_name'] ?? null,
            'project_url' => $data['project_url'] ?? null,
        ]);

        // 2. Simpan Multi-Gambar
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $index => $file) {
                // Buat nama file unik
                $fileName = time().'_'.uniqid().'.'.$file->getClientOriginalExtension();
                $file->move(public_path('uploads/portfolios'), $fileName);

                // Cek apakah gambar urutan ke-$index ini dipilih sebagai thumbnail
                $isThumbnail = ($data['thumbnail_index'] ?? 0) == $index;

                // Simpan ke tabel portfolio_images
                $portfolio->images()->create([
                    'image' => $fileName,
                    'is_thumbnail' => $isThumbnail,
                ]);
            }
        }

        return redirect()->route('admin.portfolios.index')->with('success', 'Portofolio beserta galeri berhasil ditambahkan.');
    }

    // METHOD BARU: Untuk Halaman Detail Show
    public function show(Portfolio $portfolio)
    {
        // Load relasi gambar agar lebih cepat dipanggil di view
        $portfolio->load('images');

        return view('admin.portfolios.show', compact('portfolio'));
    }

    public function edit(Portfolio $portfolio)
    {
        $portfolio->load('images');

        return view('admin.portfolios.edit', compact('portfolio'));
    }

    public function update(UpdatePortfolioRequest $request, Portfolio $portfolio)
    {
        $data = $request->validated();

        // 1. Update Data Teks
        $portfolio->update([
            'title' => $data['title'],
            'category' => $data['category'],
            'description' => $data['description'],
            'client_name' => $data['client_name'] ?? null,
            'project_url' => $data['project_url'] ?? null,
        ]);

        // 2. Hapus Gambar Lama yang Dicentang (Dihapus) User
        if (! empty($data['deleted_images'])) {
            $imagesToDelete = $portfolio->images()->whereIn('id', $data['deleted_images'])->get();
            foreach ($imagesToDelete as $img) {
                if (File::exists(public_path('uploads/portfolios/'.$img->image))) {
                    File::delete(public_path('uploads/portfolios/'.$img->image));
                }
                $img->delete(); // Hapus dari database
            }
        }

        // 3. Tambah Gambar Baru (Jika Ada)
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $index => $file) {
                $fileName = time().'_'.uniqid().'.'.$file->getClientOriginalExtension();
                $file->move(public_path('uploads/portfolios'), $fileName);

                // Jika existing_thumbnail_id kosong, berarti user memilih gambar BARU sebagai thumbnail
                $isThumbnail = empty($data['existing_thumbnail_id']) && ($data['thumbnail_index'] ?? 0) == $index;

                $portfolio->images()->create([
                    'image' => $fileName,
                    'is_thumbnail' => $isThumbnail,
                ]);
            }
        }

        // 4. Update Status Thumbnail untuk Gambar Lama
        // Jika user mencentang gambar LAMA sebagai utama
        if (! empty($data['existing_thumbnail_id'])) {
            // Reset semua gambar menjadi false dulu
            $portfolio->images()->update(['is_thumbnail' => false]);
            // Set gambar yang dipilih menjadi true
            $portfolio->images()->where('id', $data['existing_thumbnail_id'])->update(['is_thumbnail' => true]);
        }

        return redirect()->route('admin.portfolios.index')->with('success', 'Galeri Portofolio berhasil diperbarui.');
    }

    public function destroy(Portfolio $portfolio)
    {
        // Hapus fisik semua gambar di folder uploads
        foreach ($portfolio->images as $img) {
            if (File::exists(public_path('uploads/portfolios/'.$img->image))) {
                File::delete(public_path('uploads/portfolios/'.$img->image));
            }
        }

        // Hapus data portofolio (Otomatis menghapus data di portfolio_images jika pakai cascadeOnDelete di migration)
        $portfolio->delete();

        return redirect()->route('admin.portfolios.index')->with('success', 'Portofolio dan seluruh galerinya berhasil dihapus.');
    }
}
