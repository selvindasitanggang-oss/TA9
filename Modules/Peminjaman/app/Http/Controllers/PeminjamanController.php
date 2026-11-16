<?php

namespace Modules\Peminjaman\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Peminjaman\Http\Requests\PeminjamanRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class PeminjamanController extends Controller
{
    public function index()
    {
        return Inertia::render('Peminjaman::index');
    }

    public function data()
    {
        return response()->json(['data'=>DB::table('peminjaman')->latest()->get()]);
    }

    public function bukti(int $peminjaman)
    {
        $path = DB::table('peminjaman')->where('id', $peminjaman)->value('path_berkas');
        abort_unless($path && Storage::disk('public')->exists($path), 404, 'Berkas bukti belum tersedia.');
        return response()->file(Storage::disk('public')->path($path));
    }

    public function store(PeminjamanRequest $request)
    {
        $data=$request->validated();
        $data['path_berkas']=$request->file('bukti')->store('peminjaman','public'); unset($data['bukti']);
        $id=DB::table('peminjaman')->insertGetId($data+['created_at'=>now(),'updated_at'=>now()]);
        return response()->json(['message'=>'Peminjaman berhasil ditambahkan.','data'=>DB::table('peminjaman')->find($id)],201);
    }

    public function update(PeminjamanRequest $request,int $peminjaman)
    {
        $data=$request->validated();
        if($request->hasFile('bukti')) { $old=DB::table('peminjaman')->where('id',$peminjaman)->value('path_berkas'); if($old) Storage::disk('public')->delete($old); $data['path_berkas']=$request->file('bukti')->store('peminjaman','public'); }
        unset($data['bukti']); DB::table('peminjaman')->where('id',$peminjaman)->update($data+['updated_at'=>now()]);
        return response()->json(['message'=>'Peminjaman berhasil diperbarui.','data'=>DB::table('peminjaman')->find($peminjaman)]);
    }

    public function destroy(int $peminjaman)
    {
        $row=DB::table('peminjaman')->where('id',$peminjaman)->first(); if($row?->path_berkas) Storage::disk('public')->delete($row->path_berkas);
        DB::table('peminjaman')->where('id',$peminjaman)->delete(); return response()->json(['message'=>'Peminjaman berhasil dihapus.']);
    }
}
