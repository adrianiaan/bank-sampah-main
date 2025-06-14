<?php

namespace App\Http\Controllers;

use App\Models\Saldo;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\DataTables\SaldoDataTable;

class SaldoController extends Controller
{
    // Middleware to protect routes
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display the user's saldo.
     */
    public function showUserSaldo()
    {
        $user = Auth::user();
        $saldo = Saldo::where('user_id', $user->id)->first();

        return view('user.saldo.show', compact('saldo'));
    }

    /**
     * Display the specified user's saldo for admin.
     */
    public function showUserSaldoAdmin($user_id)
    {
        $user = User::findOrFail($user_id);
        $saldo = Saldo::where('user_id', $user->id)->first();

        // Ambil riwayat penarikan saldo user dari tabel riwayat_penarikan_saldos
        $riwayatPenarikan = \App\Models\RiwayatPenarikanSaldo::where('user_id', $user->id)
            ->orderBy('tanggal_penarikan', 'desc')
            ->get();

        return view('admin.saldos.show', compact('saldo', 'user', 'riwayatPenarikan'));
    }

    /**
     * Display the admin's saldo.
     */
    public function index(SaldoDataTable $dataTable)
    {
        return $dataTable->render('admin.saldos.index');
    }

    /**
     * Withdraw saldo from a user.
     */
    public function withdraw(Request $request, $user_id)
    {
        $validator = Validator::make($request->all(), [
            'jumlah_penarikan' => 'required|numeric|min:0',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $user = User::findOrFail($user_id);
        $saldo = Saldo::where('user_id', $user->id)->first();

        if (!$saldo) {
            return redirect()->back()->with('error', 'Saldo tidak ditemukan untuk pengguna ini.');
        }

        if ($request->jumlah_penarikan > $saldo->jumlah_saldo) {
            return redirect()->back()->with('error', 'Jumlah penarikan melebihi saldo yang tersedia.');
        }

        $saldoSebelum = $saldo->jumlah_saldo;
        $saldo->jumlah_saldo -= $request->jumlah_penarikan;
        $saldo->last_updated_at = now();
        $saldo->save();

        // Catat riwayat penarikan saldo
        \App\Models\RiwayatPenarikanSaldo::create([
            'user_id' => $user->id,
            'saldo_sebelum' => $saldoSebelum,
            'jumlah_penarikan' => $request->jumlah_penarikan,
            'saldo_setelah' => $saldo->jumlah_saldo,
            'tanggal_penarikan' => now(),
        ]);

        return redirect()->back()->with('success', 'Penarikan saldo berhasil.');
    }
}
