<?php

namespace App\Http\Controllers;

use App\DataTables\JenisSampahDataTable;
use App\Models\Jenis_sampah;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

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
            Storage::putFileAs('foto', $files, $newname);
            $file = '/storage/foto/' . $newname;
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
    public function edit(Jenis_sampah $jenis_sampah)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        //
        $validated = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'kategori' => 'required',
            'harga' => 'required|numeric',
        ]);

        if ($validated->fails()) {
            return response()->json(['status' => 0, 'error' => $validated->errors()]);
        }

        $jenis_sampah = Jenis_sampah::where('id',  $request->id)->update([
            'name' => $request->name,
            'kategori' => $request->kategori,
            'harga' => $request->harga,
            'deskripsi' => $request->deskripsi,
        ]);

        return response()->json(['status' => 1, 'message' => 'Data Added successfully!']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        Jenis_sampah::where('id', '=', $id)->delete();
        return response()->json(['status' => true, 'message' => 'Delete data Successfully!']);
    }
}
