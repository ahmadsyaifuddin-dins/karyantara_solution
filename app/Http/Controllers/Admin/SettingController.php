<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index()
    {
        // Ubah menjadi array asosiatif dengan key sebagai index-nya agar mudah dipanggil di Blade
        $settings = Setting::all()->keyBy('key');

        return view('admin.settings.index', compact('settings'));
    }

    public function toggle(Request $request, Setting $setting)
    {
        // Toggle antara '1' dan '0'
        $newValue = $setting->value === '1' ? '0' : '1';
        $setting->update(['value' => $newValue]);

        return response()->json([
            'success' => true,
            'message' => 'Pengaturan berhasil diperbarui!',
            'value' => $newValue,
        ]);
    }
}
