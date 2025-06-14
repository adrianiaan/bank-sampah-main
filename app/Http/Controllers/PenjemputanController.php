<?php

namespace App\Http\Controllers;

use App\Models\Penjemputan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\DataTables\PenjemputanDataTable;

class PenjemputanController extends Controller
{
    // Middleware to protect routes
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the penjemputan.
     */
    public function index(PenjemputanDataTable $dataTable)
    {
        return $dataTable->render('admin.penjemputan.index');
    }

    /**
     * Show the form for editing the specified penjemputan.
     */
    public function edit($id)
    {
        $penjemputan = Penjemputan::findOrFail($id);
        return view('admin.penjemputan.edit', compact('penjemputan'));
    }

    /**
     * Store a newly created penjemputan in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'jadwal' => 'required|date',
            'lokasi_koordinat' => 'required|string',
            'alamat' => 'required|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Allow SuperAdmin and End_User to store penjemputan
        $user = Auth::user();
        if (!in_array($user->role, ['end_user', 'super_admin'])) {
            abort(403, 'Unauthorized action.');
        }

        $penjemputan = Penjemputan::create([
            'user_id' => $user->id,
            'jadwal' => $request->jadwal,
            'status' => 'Terjadwal',
            'lokasi_koordinat' => $request->lokasi_koordinat,
            'alamat' => $request->alamat,
        ]);

        // TODO: Add notification logic here

        return redirect()->route('penjemputan.index')->with('success', 'Penjemputan berhasil dibuat');
    }

    /**
     * Update the specified penjemputan.
     */
    public function update(Request $request, $id)
    {
        $penjemputan = Penjemputan::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'jadwal' => 'required|date',
            'status' => 'required|in:Terjadwal,Selesai,Batal',
            'lokasi_koordinat' => 'required|string',
            'alamat' => 'required|string',
        ]);

        if ($validator->fails()) {
            if ($request->ajax()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $penjemputan->jadwal = $request->jadwal;
        $penjemputan->status = $request->status;
        $penjemputan->lokasi_koordinat = $request->lokasi_koordinat;
        $penjemputan->alamat = $request->alamat;
        $penjemputan->save();

        // TODO: Add notification logic here

        if ($request->ajax()) {
            return response()->json(['message' => 'Status penjemputan berhasil diperbarui', 'data' => $penjemputan], 200);
        }

        return redirect()->route('penjemputan.index')->with('success', 'Penjemputan berhasil diperbarui');
    }

    /**
     * Remove the specified penjemputan from storage.
     */
    public function destroy($id)
    {
        $penjemputan = Penjemputan::findOrFail($id);
        $penjemputan->delete();

        if (request()->ajax()) {
            return response()->json(['message' => 'Penjemputan berhasil dihapus'], 200);
        }

        return redirect()->route('penjemputan.index')->with('success', 'Penjemputan berhasil dihapus');
    }

    /**
     * Generate PDF of penjemputan list.
     */
    public function cetakPDF()
    {
        $user = auth()->user();
        \Log::debug('User cetakPDF:', ['user_id' => $user->id, 'role' => $user->role]);
        if (!in_array($user->role, ['super_admin', 'kepala_dinas', 'end_user'])) {
            abort(403, 'Unauthorized action.');
        }
        if ($user->role === 'end_user') {
            $penjemputan = Penjemputan::where('user_id', $user->id)->get();
            \Log::debug('Penjemputan data for end_user:', ['count' => $penjemputan->count()]);
        } else {
            $penjemputan = Penjemputan::all();
            \Log::debug('Penjemputan data for admin:', ['count' => $penjemputan->count()]);
        }
        $pdf = \PDF::loadView('admin.penjemputan.penjemputan_pdf', compact('penjemputan'));
        $filename = 'penjemputan_' . date('Ymd_His') . '.pdf';
        return $pdf->download($filename);
    }
}
