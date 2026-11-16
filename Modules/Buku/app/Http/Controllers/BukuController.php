<?php

namespace Modules\Buku\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Buku\Http\Requests\BukuRequest;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class BukuController extends Controller
{
    public function index(Request $request)
    {
        $books = DB::table('buku')->when($request->search, fn ($q, $s) => $q->where('judul', 'like', "%$s%")->orWhere('penulis', 'like', "%$s%"))
            ->orderBy('judul')->paginate(10)->withQueryString();
        return Inertia::render('Buku::index', ['books' => $books, 'filters' => $request->only('search')]);
    }

    public function store(BukuRequest $request)
    {
        $data = $request->validated();
        DB::table('buku')->insert($data + ['created_at'=>now(),'updated_at'=>now()]);
        return back()->with('success', 'Buku berhasil ditambahkan.');
    }

    public function update(BukuRequest $request, int $buku)
    {
        $data = $request->validated();
        DB::table('buku')->where('id',$buku)->update($data + ['updated_at'=>now()]);
        return back()->with('success', 'Buku berhasil diperbarui.');
    }

    public function destroy(int $buku)
    {
        DB::table('buku')->where('id',$buku)->delete();
        return back()->with('success', 'Buku berhasil dihapus.');
    }
}
