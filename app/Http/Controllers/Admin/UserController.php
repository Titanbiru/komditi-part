<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $staff = User::where('role', 'staff')->latest()->get();
        $users = User::where('role', 'user')->latest()->get();

        return view('admin.users.index', compact('staff', 'users'));
    }

    public function create(User $user)
    {
        return view('admin.users.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'staff',
        ]);

        return redirect()->route('admin.users.index')->with('success', 'Staff created successfully.');
    }

    public function show(User $user)
    {
        $ordersCount = $user->orders()->count();
        $totalSpending = $user->orders()->sum('total_amount');

        return view('admin.users.show', compact('user', 'ordersCount', 'totalSpending'));
    }

    public function edit(User $user)
    {
        if ($user->role !== 'staff') {
            abort(403);
        }
    
        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        if ($user->role !== 'staff') {
            abort(403);
        }
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,'
        ]);

        $user->update(request()->only('name', 'email'));

        return redirect()->route('admin.users.index')->with('success', 'Staff updated successfully.');
    }

    public function destroy(User $user)
    {
        if ($user->role !== 'staff') {
            abort(403);
        }

        $user->delete();
        return back()->with('success', 'User deleted successfully.');
    }

}
