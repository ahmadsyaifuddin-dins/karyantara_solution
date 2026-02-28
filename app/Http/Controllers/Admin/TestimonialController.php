<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTestimonialRequest;
use App\Http\Requests\UpdateTestimonialRequest;
use App\Models\Testimonial;
use Illuminate\Support\Facades\File;

class TestimonialController extends Controller
{
    public function index()
    {
        $testimonials = Testimonial::latest()->paginate(10);

        return view('admin.testimonials.index', compact('testimonials'));
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

        Testimonial::create($data);

        return redirect()->route('admin.testimonials.index')->with('success', 'Testimonial berhasil ditambahkan.');
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

    // Private method untuk handle upload "Old School"
    private function uploadImage($file)
    {
        $fileName = time().'_'.$file->getClientOriginalName();
        $destinationPath = public_path('uploads/testimonials');
        $file->move($destinationPath, $fileName);

        return $fileName;
    }
}
