<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Models\PointMember;
use App\Models\PointSetting;
use Illuminate\Http\Request;
use Storage;

class PengaturanController extends Controller
{
    public function index()
    {
        return view('pengaturan.index');
    }

    public function simpan(Request $request)
    {
        // Simpan pengaturan umum
    }

    public function poin()
    {
        $setting = PointSetting::first();
        return view('pengaturan.poin', compact('setting'));
    }

    public function updatePoin(Request $request)
    {
        $request->validate([
            'nominal' => 'required|integer|min:1',
            'point' => 'required|integer|min:1',
        ]);

        PointSetting::updateOrCreate(
            ['id' => 1], // hanya satu setting yang digunakan
            [
                'nominal' => $request->nominal,
                'point' => $request->point,
            ]
        );

        return redirect()->route('pengaturan.poin.index')->with('success', 'Pengaturan poin berhasil diperbarui.');
    }

    public function umum()
    {
        $data = \App\Models\Pengaturan::first(); // satu-satunya row
        return view('pengaturan.umum', compact('data'));
    }

    public function simpanUmum(Request $request)
    {
        $request->validate([
            'nama_perusahaan' => 'required|string|max:255',
            'alamat_1'        => 'nullable|string|max:255',
            'alamat_2'        => 'nullable|string|max:255',
            'logo'            => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'logo_bank'       => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $data = \App\Models\Pengaturan::firstOrNew();

        $data->nama_perusahaan = $request->nama_perusahaan;
        $data->alamat_1 = $request->alamat_1;
        $data->alamat_2 = $request->alamat_2;

        if ($request->hasFile('logo')) {
            // hapus file lama (jika ada)
            if ($data->logo && file_exists(public_path('logo/' . $data->logo))) {
                unlink(public_path('logo/' . $data->logo));
            }

            $file = $request->file('logo');
            $filename = uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('logo'), $filename);
            $data->logo = $filename;
        }

        if ($request->hasFile('logo_bank')) {
            if ($data->logo_bank && file_exists(public_path('logo/' . $data->logo_bank))) {
                unlink(public_path('logo/' . $data->logo_bank));
            }

            $file = $request->file('logo_bank');
            $filenameBank = uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('logo'), $filenameBank);
            $data->logo_bank = $filenameBank;
        }

        $data->save();

        return back()->with('success', 'Pengaturan umum berhasil disimpan.');
    }
}
