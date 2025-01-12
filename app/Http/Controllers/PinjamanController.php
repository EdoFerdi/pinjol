<?php

namespace App\Http\Controllers;

use App\Models\Pinjaman;
use Illuminate\Http\Request;

class PinjamanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Pinjaman $pinjaman)
    {
        $pinjaman = Pinjaman::find($pinjaman);
        $data['success'] = true;
        $data['message'] = "Detail data pinjaman";
        $data['result'] = $pinjaman;
        return response()->json($data, 200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Pinjaman $pinjaman)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Pinjaman $pinjaman)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pinjaman $pinjaman)
    {
        //
    }

    public function destroyPinjaman($id)
    {
        // cari data di tabel fakultas berdasarkan "id" fakultas
        $pinjaman = Pinjaman::find($id);
        // dd($fakultas);
        $hasil = $pinjaman->delete();
        if ($hasil) { // jika data berhasil disimpan
            $response['success'] = true;
            $response['message'] = "Pinjaman berhasil dihapus";
            return response()->json($response, 200);
        } else {
            $response['success'] = false;
            $response['message'] = "Pinjaman gagal dihapus";
            return response()->json($response, 400);
        }
    }

    public function getPinjaman()
    {
        // $response['data'] = Pinjaman::all();
        $response['data'] = Pinjaman::with('orang')->get();
        $response['message'] = 'List data Peminjaman';
        $response['success'] = true;

        return response()->json($response, 200);
    }

    public function getPinjamanById($id)
    {
        // Cari pinjaman berdasarkan ID
        $pinjaman = Pinjaman::find($id);

        // Jika tidak ditemukan, kembalikan respon error
        if (!$pinjaman) {
            return response()->json([
                'message' => 'pinjaman tidak ditemukan',
            ], 404);
        }

        // Kembalikan data pinjaman
        return response()->json($pinjaman, 200);
    }

    public function storePinjaman(Request $request)
    {
        // validasi input
        $input = $request->validate([
            "tgl_pinjam"     => "required",
            "jumlah_pinjam"  => "required",
            "jangka_waktu"   => "required",
            "orang_id"       => "required"
        ]);

        // simpan
        $hasil = Pinjaman::create($input);
        if ($hasil) { // jika data berhasil disimpan
            $response['success'] = true;
            $response['message'] = $request->nama . " berhasil disimpan";
            return response()->json($response, 201); // 201 Created
        } else {
            $response['success'] = false;
            $response['message'] = $request->nama . " gagal disimpan";
            return response()->json($response, 400); // 400 Bad Request
        }
    }

    public function updatePinjaman(Request $request, $id)
    {
        $pinjaman = Pinjaman::find($id);

        // validasi input
        $input = $request->validate([
            "tgl_pinjam"     => "required",
            "jumlah_pinjam"  => "required",
            "jangka_waktu"   => "required",
            "orang_id"       => "required"
        ]);

        // simpan
        $hasil = $pinjaman->update($input);

        if($hasil){ // jika data berhasil disimpan
            $response['success'] = true;
            $response['message'] = "Pinjaman berhasil diubah";
            return response()->json($response, 200);
        } else {
            $response['success'] = false;
            $response['message'] = "Pinjaman gagal diubah";
            return response()->json($response, 400);
        }

    }

}
