<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::updateOrCreate(['email' => 'admin@sipustaka.test'], ['name' => 'Admin SiPustaka', 'password' => 'password', 'role' => 'admin']);
        User::updateOrCreate(['email' => 'user@sipustaka.test'], ['name' => 'Anggota SiPustaka', 'password' => 'password', 'role' => 'user']);
        foreach ([
            ['Pemrograman Laravel','Taylor Otwell','Penerbit Teknologi',2024,5],
            ['Dasar React','Adam Freeman','Informatika',2023,4],
            ['Basis Data','Abraham Silberschatz','Erlangga',2022,6],
            ['Rekayasa Perangkat Lunak','Ian Sommerville','Andi',2021,3],
            ['Jaringan Komputer','Andrew Tanenbaum','Pearson',2020,2],
        ] as [$judul,$penulis,$penerbit,$tahun,$stok]) {
            DB::table('buku')->updateOrInsert(['judul'=>$judul], ['penulis'=>$penulis,'penerbit'=>$penerbit,'tahun_terbit'=>$tahun,'stok'=>$stok,'created_at'=>now(),'updated_at'=>now()]);
        }
    }
}
