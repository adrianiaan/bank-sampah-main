<?php

namespace App\Http\Controllers;

use App\DataTables\JenisSampahDataTable;
use App\Models\Jenis_sampah;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use PDF;

class JenisSampahController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(JenisSampahDataTable $datatable)
    {
        $title = 'Jenis Sampah';
        return $datatable->render('admin.jenis-sampah', ['title' => $title]);
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
            'kategori' => 'required',
            'harga' => 'required|numeric',
        ]);

        if ($validatedData->fails()) {
            return response()->json(['status' => 0, 'error' => $validatedData->errors()]);
        }

        if ($request->file('foto')) {
            $files = $request->file('foto');
            $name = rand(1, 999);
            $extension = $files->getClientOriginalExtension();
            $newname = $name . '.' . $extension;
            Storage::disk('public')->putFileAs('foto', $files, $newname);
            $file = 'foto/' . $newname;
        } else {
            $file = null;
        }

        Jenis_sampah::create([
            'name' => $request->name,
            'kategori' => $request->kategori,
            'harga' => $request->harga,
            'deskripsi' => $request->deskripsi,
            'foto' => $file,
        ]);

        return response()->json(['status' => 1, 'message' => 'Data Added successfully!']);
    }

    /**
     * Display the specified resource.
     */
    public function show(Jenis_sampah $jenis_sampah)
    {
        $data = Jenis_sampah::all();
        return $data;
    }
    public function showByid($id)
    {
        $data = Jenis_sampah::find($id);
        return $data;
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $jenis_sampah = Jenis_sampah::findOrFail($id);
        return view('admin.jenis-sampah.edit', compact('jenis_sampah'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required|max:255',
            'kategori' => 'required',
            'harga' => 'required|numeric',
            'deskripsi' => 'nullable|string',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $jenis_sampah = Jenis_sampah::findOrFail($id);

        if ($request->hasFile('foto')) {
            // Hapus file foto lama jika ada
            if ($jenis_sampah->foto && Storage::disk('public')->exists($jenis_sampah->foto)) {
                Storage::disk('public')->delete($jenis_sampah->foto);
            }
            $file = $request->file('foto');
            $name = rand(1, 999);
            $extension = $file->getClientOriginalExtension();
            $newname = $name . '.' . $extension;
            Storage::disk('public')->putFileAs('foto', $file, $newname);
            $validated['foto'] = 'foto/' . $newname;
        }

        $jenis_sampah->update($validated);

        return redirect()->route('jenis_sampah.index')->with('success', 'Data berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        Jenis_sampah::where('id', '=', $id)->delete();
        return redirect()->route('jenis_sampah.index')->with('success', 'Data berhasil dihapus!');
    }

    /**
     * Generate PDF of jenis sampah list.
     */
    public function cetakPDF()
    {
        $user = auth()->user();
        if (!in_array($user->role, ['super_admin', 'kepala_dinas'])) {
            abort(403, 'Unauthorized action.');
        }
        $jenis_sampah = Jenis_sampah::all();
        $pdf = PDF::loadView('admin.jenis-sampah.jenis_sampah_pdf', compact('jenis_sampah'));
        $filename = 'jenis_sampah_' . date('Ymd_His') . '.pdf';
        return $pdf->download($filename);
    }
}
