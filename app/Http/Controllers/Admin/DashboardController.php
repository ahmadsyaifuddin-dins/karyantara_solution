<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Testimonial;

class DashboardController extends Controller
{
    public function index()
    {
        // Mengambil total data testimonial untuk ditampilkan di card dashboard
        $totalTestimonial = Testimonial::count();

        // Mengirim data ke view dashboard bawaan breeze yang nanti bisa kita custom
        return view('dashboard', compact('totalTestimonial'));
    }
}
