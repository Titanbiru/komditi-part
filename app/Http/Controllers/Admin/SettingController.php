<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Setting;

class SettingController extends Controller
{
    public function index()
    {
        $settings = Setting::all()->pluck('value', 'key')->toArray();
        return view('admin.settings.index', compact('settings'));
    }
    
    public function update(Request $request)
    {
        $data = $request->except(['_token', '_method']);

        foreach ($data as $key => $value) {
            // Logika jika yang diupload adalah FILE (Gambar)
            if ($request->hasFile($key)) {
                $file = $request->file($key);
                $path = $file->store('settings', 'public');
                
                \App\Models\Setting::updateOrCreate(['key' => $key], ['value' => $path]);
            } else {
                // Logika jika yang diisi adalah TEKS (Nama Bank/Alamat)
                \App\Models\Setting::updateOrCreate(['key' => $key], ['value' => $value]);
            }
            
            // Hapus Cache setiap kali ada update biar langsung berubah di User
            \Illuminate\Support\Facades\Cache::forget('setting_' . $key);
        }

        return back()->with('success', 'Pengaturan Toko Berhasil Diperbarui!');
    }
}
