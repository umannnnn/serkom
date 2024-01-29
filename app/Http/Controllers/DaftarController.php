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
            'semesters' => Semester::all(),
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
        // Validasi data yang diinputkan oleh user
        $data = request()->validate([
            'nama' => 'required',
            'email' => 'required | email | email:rfc,dns',
            'nomor_hp' => 'required | numeric | digits_between:10,13',
            'semester' => 'required',
            'ipk' => 'required',
            'beasiswa' => 'required',
            'berkas' => 'required | file | mimes:pdf,jpg,png',
        ]);
        
        // Menyimpan berkas yang diupload oleh user
        if(request('berkas')){
            $berkas = request('berkas')->store('berkas','public');
            $data['berkas'] = basename($berkas);
        }

        // Mengubah id semester dan id beasiswa menjadi nama semester dan nama beasiswa
        $semester_nama = Semester::where('id', $data['semester'])->first();
        $semester_nama = $semester_nama->nama;
        $beasiswa_nama = Beasiswa::where('id', $data['beasiswa'])->first();
        $beasiswa_nama = $beasiswa_nama->nama;
        
        // Menyimpan data pendaftar ke dalam database
        Pendaftar::create([
            'nama' => $data['nama'],
            'email' => $data['email'],
            'nomor_hp' => $data['nomor_hp'],
            'ipk' => $data['ipk'],
            'semester' => $semester_nama,
            'beasiswa' => $beasiswa_nama,
            'berkas' => $data['berkas'],
            'status_ajuan' => 'Belum Diverifikasi',
        ]);

        // Mengambil data pendaftar terbaru untuk ditampilkan di halaman hasil
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
