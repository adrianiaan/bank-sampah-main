<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use App\Models\Jenis_sampah;
use App\Models\Penjemputan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\DataTables\TransaksiDataTable;
use App\Models\User;
use Illuminate\Http\JsonResponse;

class TransaksiController extends Controller
{
    public function autocomplete(Request $request): JsonResponse
    {
        $search = $request->get('term');

        if (empty($search)) {
            return response()->json([]);
        }

        $users = User::select('id', 'name')
            ->where('name', 'like', '%' . $search . '%')
            ->get();

        return response()->json($users);
    }
    // Middleware to protect routes
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the transaksi.
     */
    public function index(TransaksiDataTable $dataTable)
    {
        return $dataTable->render('admin.transaksi.index');
    }

    /**
     * Show the form for creating a new transaksi.
     */
    public function create()
    {
        $jenis_sampahs = Jenis_sampah::all();
        $users = \App\Models\User::all();
        return view('admin.transaksi.create', compact('jenis_sampahs', 'users'));
    }

    /**
     * Store a newly created transaksi in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_name' => 'required',
            'jenis_sampah_id' => 'required|exists:jenis_sampahs,id',
            'berat_kg' => 'required|numeric',
           'catatan_verifikasi' => 'nullable|string'
       ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $user = User::where('name', $request->user_name)->first();

        if (!$user) {
            return redirect()->back()->withErrors(['user_name' => 'User tidak ditemukan'])->withInput();
        }

        // Get jenis sampah
        $jenis_sampah = Jenis_sampah::find($request->jenis_sampah_id);

        // Calculate nilai saldo
        $nilai_saldo = $request->berat_kg * $jenis_sampah->harga;
        
        $penjemputan = Penjemputan::where('user_id', $user->id)->where('status', 'Terjadwal')->first();

        // Create transaksi
        $transaksi = Transaksi::create([
            'penjemputan_id' => optional($penjemputan)->id,
            'user_id' => $user->id,
            'jenis_sampah_id' => $request->jenis_sampah_id,
            'berat_kg' => $request->berat_kg,
            'harga_per_kilo_saat_transaksi' => $jenis_sampah->harga,
            'nilai_saldo' => $nilai_saldo,
            'dicatat_oleh_user_id' => Auth::id(),
            'status_verifikasi' => null,
            'catatan_verifikasi' => null,
            'tanggal_transaksi' => now(),
            'catatan_verifikasi' => $request->catatan_verifikasi,
        ]);

        // TODO: Add notification logic here

        return redirect()->route('transaksi.index')->with('success', 'Transaksi berhasil dibuat');
    }

    /**
     * Display the specified transaksi.
     */
    public function show(Transaksi $transaksi)
    {
        return view('admin.transaksi.show', compact('transaksi'));
    }

    /**
     * Show the form for editing the specified transaksi.
     */
    public function edit(Transaksi $transaksi)
    {
        $jenis_sampahs = Jenis_sampah::all();
        $penjemputans = Penjemputan::where('status', 'Selesai')->get();
        return view('admin.transaksi.edit', compact('transaksi', 'jenis_sampahs', 'penjemputans'));
    }

    /**
     * Update the specified transaksi in storage.
     */
    public function update(Request $request, Transaksi $transaksi)
    {
         if (Auth::user()->role == 'kepala_dinas') {
            return redirect()->route('transaksi.index')->with('error', 'Kepala Dinas tidak memiliki akses untuk mengubah transaksi.');
        }
        $validator = Validator::make($request->all(), [
            'penjemputan_id' => 'nullable|exists:penjemputan,id',
            'user_id' => 'required|exists:users,id',
            'jenis_sampah_id' => 'required|exists:jenis_sampahs,id',
            'berat_kg' => 'required|numeric',
           'harga_per_kilo_saat_transaksi' => 'required|numeric',
           'nilai_saldo' => 'required|numeric',
           'tanggal_transaksi' => 'required|date',
           'dicatat_oleh_user_id' => 'nullable|exists:users,id',
           'status_verifikasi' => 'nullable|in:terverifikasi,ditolak',
           'catatan_verifikasi' => 'nullable|string',
       ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $transaksi->update($request->all());

        // TODO: Add notification logic here

        return redirect()->route('transaksi.index')->with('success', 'Transaksi berhasil diperbarui');
    }

    /**
     * Remove the specified transaksi from storage.
     */
    public function destroy(Transaksi $transaksi)
    {
        if (Auth::user()->role == 'kepala_dinas') {
            return redirect()->route('transaksi.index')->with('error', 'Kepala Dinas tidak memiliki akses untuk menghapus transaksi.');
        }
        $transaksi->delete();

        return redirect()->route('transaksi.index')->with('success', 'Transaksi berhasil dihapus');
    }
}
