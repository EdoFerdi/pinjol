<?php

namespace App\Http\Controllers;

use App\Models\Pembayaran;
use Illuminate\Http\Request;

class PembayaranController extends Controller
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
    public function show(Pembayaran $pembayaran)
    {
        $pembayaran = Pembayaran::find($pembayaran);
        $data['success'] = true;
        $data['message'] = "Detail data pembayaran";
        $data['result'] = $pembayaran;
        return response()->json($data, 200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Pembayaran $pembayaran)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Pembayaran $pembayaran)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pembayaran $pembayaran)
    {
        //
    }
public function destroyPembayaran($id)
    {
        // cari data di tabel fakultas berdasarkan "id" fakultas
        $pembayaran = Pembayaran::find($id);
        // dd($fakultas);
        $hasil = $pembayaran->delete();
        if ($hasil) { // jika data berhasil disimpan
            $response['success'] = true;
            $response['message'] = "Pembayaran berhasil dihapus";
            return response()->json($response, 200);
        } else {
            $response['success'] = false;
            $response['message'] = "Pembayaran gagal dihapus";
            return response()->json($response, 400);
        }
    }

    public function getPembayaran()
    {
        // $response['data'] = Pembayaran::all();
        $response['data'] = Pembayaran::with('pinjamen.orang')->get();
        $response['message'] = 'List data Pembayaran';
        $response['success'] = true;

        return response()->json($response, 200);
    }

    public function storePembayaran(Request $request)
    {
        // validasi input
        $input = $request->validate([
            "tgl_bayar"     => "required",
            "jumlah_bayar"  => "required",
            "sisa_bayar"    => "required",
            "pinjaman_id"   => "required"
        ]);

        // simpan
        $hasil = Pembayaran::create($input);
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

    public function updatePembayaran(Request $request, $id)
    {
        $pembayaran = Pembayaran::find($id);

        // validasi input
        $input = $request->validate([
            "tgl_bayar"     => "required",
            "jumlah_bayar"  => "required",
            "sisa_bayar"   => "required",
            "pinjaman_id"   => "required"
        ]);

        // simpan
        $hasil = $pembayaran->update($input);

        if($hasil){ // jika data berhasil disimpan
            $response['success'] = true;
            $response['message'] = "Pembayaran berhasil diubah";
            return response()->json($response, 200);
        } else {
            $response['success'] = false;
            $response['message'] = "Pembayaran gagal diubah";
            return response()->json($response, 400);
        }

    }

}

