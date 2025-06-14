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
use App\Models\Saldo;

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
    public function index()
    {
        $user = Auth::user();
        $dataTable = new TransaksiDataTable();
        
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
        $user = Auth::user();

        $validator = Validator::make($request->all(), [
            'jenis_sampah_id' => 'required|exists:jenis_sampahs,id',
            'berat_kg' => 'required|numeric',
            'catatan_verifikasi' => 'nullable|string'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Validasi tambahan untuk memastikan End User hanya dapat membuat transaksi untuk diri mereka sendiri
        if ($user->role == 'end_user') {
            $request->merge(['user_name' => $user->name]);
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

        // Update user's saldo hanya jika user bukan end_user (misal superAdmin atau kepala_dinas)
        if ($user->role != 'end_user') {
            $saldo = Saldo::where('user_id', $user->id)->first();

            if ($saldo) {
                $saldo->jumlah_saldo += $nilai_saldo;
                $saldo->last_updated_at = now();
                $saldo->save();
            } else {
                Saldo::create([
                    'user_id' => $user->id,
                    'jumlah_saldo' => $nilai_saldo,
                    'last_updated_at' => now(),
                ]);
            }
        }

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
            'user_id' => 'required|exists:users,id',
            'jenis_sampah_id' => 'required|exists:jenis_sampahs,id',
            'berat_kg' => 'required|numeric',
            'status_verifikasi' => 'nullable|in:terverifikasi,ditolak',
            'catatan_verifikasi' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            \Log::error('Validation errors: ' . json_encode($validator->errors()->all()));
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Get jenis sampah
         $jenis_sampah = Jenis_sampah::find($request->jenis_sampah_id);

         // Calculate nilai saldo
         $nilai_saldo = $request->berat_kg * $jenis_sampah->harga;

        // Hitung selisih nilai saldo untuk update saldo user
        $selisih_nilai_saldo = $nilai_saldo - $transaksi->nilai_saldo;

        // Cek perubahan status_verifikasi
        $status_sebelumnya = $transaksi->status_verifikasi;
        $status_baru = $request->status_verifikasi;

        $transaksi->update([
            'user_id' => $request->user_id,
            'jenis_sampah_id' => $request->jenis_sampah_id,
            'berat_kg' => $request->berat_kg,
            'status_verifikasi' => $status_baru,
            'catatan_verifikasi' => $request->catatan_verifikasi,
            'nilai_saldo' => $nilai_saldo,
        ]);

        $saldo = Saldo::where('user_id', $request->user_id)->first();

        // Logika update saldo berdasarkan perubahan status_verifikasi
        if ($status_sebelumnya !== 'terverifikasi' && $status_baru === 'terverifikasi') {
            // Status berubah menjadi terverifikasi, tambahkan nilai saldo
            if ($saldo) {
                $saldo->jumlah_saldo += $nilai_saldo;
                $saldo->last_updated_at = now();
                $saldo->save();
            } else {
                Saldo::create([
                    'user_id' => $request->user_id,
                    'jumlah_saldo' => $nilai_saldo,
                    'last_updated_at' => now(),
                ]);
            }
        } elseif ($status_sebelumnya === 'terverifikasi' && $status_baru === 'ditolak') {
            // Status berubah dari terverifikasi ke ditolak, kurangi nilai saldo
            if ($saldo) {
                $saldo->jumlah_saldo -= $nilai_saldo;
                $saldo->last_updated_at = now();
                $saldo->save();
            }
        } elseif ($status_baru === 'terverifikasi') {
            // Status tetap terverifikasi, update saldo sesuai selisih nilai saldo
            if ($saldo) {
                $saldo->jumlah_saldo += $selisih_nilai_saldo;
                $saldo->last_updated_at = now();
                $saldo->save();
            }
        }

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

        // Kurangi saldo user sesuai nilai_saldo transaksi yang dihapus
        $saldo = Saldo::where('user_id', $transaksi->user_id)->first();
        if ($saldo) {
            $saldo->jumlah_saldo -= $transaksi->nilai_saldo;
            $saldo->last_updated_at = now();

            // Cek apakah user masih punya transaksi lain selain yang dihapus
            $transaksi_lain = Transaksi::where('user_id', $transaksi->user_id)
                ->where('id', '!=', $transaksi->id)
                ->exists();

            if (!$transaksi_lain || $saldo->jumlah_saldo <= 0) {
                // Hapus record saldo jika tidak ada transaksi lain atau saldo nol/kecil
                $saldo->delete();
            } else {
                $saldo->save();
            }
        }

        $transaksi->delete();

        return redirect()->route('transaksi.index')->with('success', 'Transaksi berhasil dihapus');
    }
}
