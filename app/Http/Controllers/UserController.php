<?php

namespace App\Http\Controllers;

use App\Models\User;
use Auth;
use Hash;
use Illuminate\Http\Request;

class UserController extends Controller
{
    protected function onlyAdmin()
    {
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Akses hanya untuk Admin.');
        }
    }

    public function index()
    {
        $this->onlyAdmin();

        $users = User::latest()->get();
        return view('user.index', compact('users'));
    }

    public function create()
    {
        $this->onlyAdmin();

        return view('user.create');
    }

    public function store(Request $request)
    {
        $this->onlyAdmin();

        $validated = $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
            'role'     => 'required|in:admin,user,kasir',
        ]);

        $validated['password'] = Hash::make($validated['password']);

        User::create($validated);

        return redirect()->route('user.index')->with('success', 'User berhasil ditambahkan.');
    }

    public function edit(User $user)
    {
        $this->onlyAdmin();

        return view('user.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $this->onlyAdmin();

        $validated = $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email,' . $user->id,
            'role'     => 'required|in:admin,user,kasir',
            'password' => 'nullable|string|min:6|confirmed',
        ]);

        if ($request->filled('password')) {
            $validated['password'] = Hash::make($request->password);
        } else {
            unset($validated['password']);
        }

        $user->update($validated);

        return redirect()->route('user.index')->with('success', 'User berhasil diperbarui.');
    }

    public function destroy(User $user)
    {
        $this->onlyAdmin();

        $user->delete();
        return redirect()->route('user.index')->with('success', 'User berhasil dihapus.');
    }
}
