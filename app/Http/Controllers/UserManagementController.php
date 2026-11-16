<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Inertia\Inertia;

class UserManagementController extends Controller
{
    public function index() { return Inertia::render('users/index', ['users'=>User::query()->select('id','name','email','role')->orderBy('name')->get()]); }
    public function store(Request $request) { $data=$request->validate(['name'=>'required|string|max:255','email'=>'required|email|unique:users,email','password'=>'required|string|min:8','role'=>'required|in:admin,user']); User::create(['name'=>$data['name'],'email'=>$data['email'],'password'=>Hash::make($data['password']),'role'=>$data['role']]); return back()->with('success','Pengguna berhasil ditambahkan.'); }
    public function update(Request $request, User $user) { abort_if($user->is($request->user()) && $request->role !== 'admin',403,'Role akun sendiri tidak dapat diturunkan.'); $data=$request->validate(['name'=>'required|string|max:255','email'=>'required|email|unique:users,email,'.$user->id,'role'=>'required|in:admin,user','password'=>'nullable|string|min:8']); $user->fill(collect($data)->except('password')->all()); if(!empty($data['password']))$user->password=Hash::make($data['password']); $user->save(); return back()->with('success','Pengguna berhasil diperbarui.'); }
    public function destroy(Request $request, User $user) { abort_if($user->is($request->user()),403,'Akun sendiri tidak dapat dihapus.'); $user->delete(); return back()->with('success','Pengguna berhasil dihapus.'); }
}
