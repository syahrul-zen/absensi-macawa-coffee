<?php

namespace App\Http\Controllers;

use App\Models\Shift;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ShiftController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('Admin.Shift.index', [
            'shifts' => Shift::latest()->get(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_shift' => 'required|max:100|unique:shifts',
            'jam_masuk' => 'required',
            'jam_pulang' => 'required',
        ]);

        Shift::create($validated);

        return back()->with('success', 'Berhasil menambahkan shift');

    }

    /**
     * Display the specified resource.
     */
    public function show(Shift $shift)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Shift $shift)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Shift $shift)
    {
        // Menggunakan Validator::make seperti struktur controller Anda sebelumnya
        $validator = Validator::make($request->all(), [
            // Mengabaikan ID saat ini agar tidak dianggap duplikat oleh dirinya sendiri
            'nama_shift' => 'required|max:100|unique:shifts,nama_shift,'.$shift->id,
            'jam_masuk' => 'required',
            'jam_pulang' => 'required',
        ], [
            'nama_shift.required' => 'Nama shift wajib diisi.',
            'nama_shift.max' => 'Nama shift maksimal 100 karakter.',
            'nama_shift.unique' => 'Nama shift sudah terdaftar, gunakan nama lain.',
            'jam_masuk.required' => 'Jam masuk wajib ditentukan.',
            'jam_pulang.required' => 'Jam pulang wajib ditentukan.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $shift->update([
            'nama_shift' => $request->nama_shift,
            'jam_masuk' => $request->jam_masuk,
            'jam_pulang' => $request->jam_pulang,
        ]);

        return redirect()->back()->with('success', 'Data shift kerja berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Shift $shift)
    {
        // Eksekusi hapus data
        $shift->delete();

        // Kembalikan ke halaman dengan alert sukses yang sudah kita buat sebelumnya
        return redirect()->back()->with('success', 'Shift '.$shift->nama_shift.' berhasil dihapus.');
    }
}
