<?php

namespace App\Http\Controllers;

use App\DataTables\RiwayatDataTable;
use App\Models\Jenis_sampah;
use App\Models\Riwayat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RiwayatController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(RiwayatDataTable $datatable)
    {
        $title = 'Riwayat Transaksi';
        return $datatable->render('admin.riwayat', ['title' => $title]);
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
        $validatedData = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'no_telepon' => 'required|max:255',
            'jenis_sampah_id' => 'required',
            'jumlah_kg' => 'required|numeric|min:0',
            'total_biaya' => 'required',
            'lama_penyimpanan' => 'required|numeric|min:0',
        ]);

        if ($validatedData->fails()) {
            return response()->json(['status' => 0, 'error' => $validatedData->errors()]);
        }

        $riwayat =  Riwayat::create([
            'name' => $request->name,
            'no_telepon' => $request->no_telepon,
            'jenis_sampah_id' => $request->jenis_sampah_id,
            'jumlah_kg' => $request->jumlah_kg,
            'total_harga' => $request->total_biaya,
            'lama_penyimpanan' => $request->lama_penyimpanan,
            'status' => 'Belum Disetor'
        ]);

        $hasil = Riwayat::with(['jenis_sampah'])->where('id', '=', $riwayat->id)->first();

        return response()->json(['status' => 1, 'data' => $hasil, 'message' => 'Data Added successfully!']);
    }

    /**
     * Display the specified resource.
     */
    public function show(Riwayat $riwayat)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Riwayat $riwayat)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Riwayat $riwayat)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Riwayat $riwayat)
    {
        //
    }
}
