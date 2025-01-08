<?php

namespace App\Http\Controllers;

use App\Models\Orang;
use Illuminate\Http\Request;

class OrangController extends Controller
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
    public function show(Orang $orang)
    {
        $orang = Orang::find($orang);
        $data['success'] = true;
        $data['message'] = "Detail data Orang";
        $data['result'] = $orang;
        return response()->json($data, 200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Orang $orang)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Orang $orang)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Orang $orang)
    {
        //
    }

    public function getOrang()
    {
        $response['data'] = Orang::all();
        $response['message'] = 'List data Orang ';
        $response['success'] = true;

        return response()->json($response, 200);
    }

    public function getOrangById($id)
    {
    // Cari orang berdasarkan ID
    $orang = Orang::find($id);

    // Jika tidak ditemukan, kembalikan respon error
    if (!$orang) {
        return response()->json([
            'message' => 'Orang tidak ditemukan',
        ], 404);
    }

    // Kembalikan data orang
    return response()->json($orang, 200);
}

    public function storeOrang(Request $request)
    {
        // validasi input
        $input = $request->validate([
            "nik"       => "required|unique:orangs",
            "nama"      => "required",
            "email"     => "required",
            "nohp"      => "required",
            "alamat"    => "required"
        ]);

        // simpan
        $hasil = Orang::create($input);
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

    public function destroyOrang($id)
    {
        // cari data di tabel Orang berdasarkan "id" Orang
        $orang = Orang::find($id);
        // dd($Orang);
        $hasil = $orang->delete();
        if ($hasil) { // jika data berhasil disimpan
            $response['success'] = true;
            $response['message'] = "Orang berhasil dihapus";
            return response()->json($response, 200);
        } else {
            $response['success'] = false;
            $response['message'] = "Orang gagal dihapus";
            return response()->json($response, 400);
        }
    }

    public function updateOrang(Request $request, $id)
    {
        $orang = Orang::find($id);

        // validasi input
        $input = $request->validate([
            "nik"       => "required",
            "nama"      => "required",
            "email"     => "required",
            "nohp"      => "required",
            "alamat"    => "required"
        ]);

        // update data
        $hasil = $orang->update($input);

        if ($hasil) { // jika data berhasil disimpan
            $response['success'] = true;
            $response['message'] = "Orang berhasil diubah";
            return response()->json($response, 200);
        } else {
            $response['success'] = false;
            $response['message'] = "Orang gagal diubah";
            return response()->json($response, 400);
        }
    }

}
