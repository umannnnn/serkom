<?php

namespace App\Http\Controllers;

use App\Models\Beasiswa;
use App\Models\Semester;
use App\Models\Pendaftar;
use Illuminate\Http\Request;

class DaftarController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Menampilkan halaman daftar dengan data beasiswa dan semester
        return view('daftar', [
            'beasiswas' => Beasiswa::all(),
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
        // Validasi data yang diterima
        $request->validate([
            'nama' => 'required',
            'email' => 'required|email',
            'nomor_hp' => 'required',
            'semester' => 'required',
            'ipk' => 'required',
            'beasiswa' => 'required',
            'berkas' => 'required',
        ]);

        // Menyimpan data pendaftar ke dalam database
        Pendaftar::create([
            'nama' => $request->nama,
            'email' => $request->email,
            'nomor_hp' => $request->nomor_hp,
            'semester' => $request->semester,
            'ipk' => $request->ipk,
            'beasiswa' => $request->beasiswa,
            'berkas' => $request->berkas,
            'status_ajuan' => 'Menunggu',
        ]);

        // Redirect ke halaman daftar dengan pesan sukses
        $data = Pendaftar::latest()->first();
        return redirect()->route('hasil')->with('data', $data);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
