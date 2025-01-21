<?php

namespace App\Http\Controllers;
use App\Models\Pinjaman;
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

    public function getPembayaranById($id)
    {
    // Cari pembayaran berdasarkan ID
    $pembayaran = Pembayaran::find($id);

    // Jika tidak ditemukan, kembalikan respon error
    if (!$pembayaran) {
        return response()->json([
            'message' => 'Pembayaran tidak ditemukan',
        ], 404);
    }

    // Kembalikan data Pembayaran
    return response()->json($pembayaran, 200);
}

    public function storePembayaran(Request $request)
    {
        $validatedData = $request->validate([
        'tgl_bayar' => 'required|date',
        'jumlah_bayar' => 'required|numeric',
        'pinjaman_id' => 'required|exists:pinjamen,id'
    ]);

    // Ambil data pinjaman terkait
    $pinjaman = Pinjaman::findOrFail($request->pinjaman_id);

    // Hitung sisa bayar
    $totalDibayar = Pembayaran::where('pinjaman_id', $pinjaman->id)->sum('jumlah_bayar');
    $sisaBayar = $pinjaman->jumlah_pinjam - ($totalDibayar + $request->jumlah_bayar);

    // Simpan pembayaran
    $pembayaran = Pembayaran::create([
        'tgl_bayar' => $validatedData['tgl_bayar'],
        'jumlah_bayar' => $validatedData['jumlah_bayar'],
        'pinjaman_id' => $validatedData['pinjaman_id'],
        'sisa_bayar' => $sisaBayar
    ]);

    return response()->json([
        'message' => 'Pembayaran berhasil ditambahkan',
        'data' => $pembayaran
    ], 201);
    }


    public function updatePembayaran(Request $request, $id)
    {
        // Cari data pembayaran berdasarkan ID
        $pembayaran = Pembayaran::findOrFail($id);

        // Validasi input
        $validatedData = $request->validate([
            "tgl_bayar"    => "required|date",
            "jumlah_bayar" => "required|numeric|min:1",
            "pinjaman_id"  => "required|exists:pinjamen,id"
        ]);

        // Ambil data pinjaman terkait
        $pinjaman = Pinjaman::findOrFail($validatedData['pinjaman_id']);

        // Hitung ulang sisa bayar
        $totalDibayarSebelumnya = Pembayaran::where('pinjaman_id', $pinjaman->id)
            ->where('id', '!=', $pembayaran->id) // Exclude pembayaran ini
            ->sum('jumlah_bayar');
        $sisaBayar = $pinjaman->jumlah_pinjam - ($totalDibayarSebelumnya + $validatedData['jumlah_bayar']);

        // Cek apakah jumlah bayar melebihi sisa pinjaman
        if ($sisaBayar < 0) {
            return response()->json([
                'success' => false,
                'message' => 'Jumlah bayar melebihi sisa pinjaman.'
            ], 400);
        }

        // Update data pembayaran
        $pembayaran->tgl_bayar = $validatedData['tgl_bayar'];
        $pembayaran->jumlah_bayar = $validatedData['jumlah_bayar'];
        $pembayaran->pinjaman_id = $validatedData['pinjaman_id'];
        $pembayaran->sisa_bayar = $sisaBayar;

        if ($pembayaran->save()) {
            return response()->json([
                'success' => true,
                'message' => 'Pembayaran berhasil diubah',
                'data' => $pembayaran
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Pembayaran gagal diubah'
            ], 400);
        }
    }

}

