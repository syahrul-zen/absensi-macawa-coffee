<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cordiant;

class CordiantController extends Controller
{
    public function updateCordinat(Request $request) {

        $validated = $request->validate([
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric'
        ]);

        $koordinat = Cordiant::first();

        $koordinat->update($validated);

        return back()->with('success', "Berhasil merubah kordinat");
    }
}
