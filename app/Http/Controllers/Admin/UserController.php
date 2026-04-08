<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function index(Request $request)
    {
        // Search logic (biar input search di Blade Mas jalan)
        $searchStaff = $request->input('search_staff');
        $searchUser = $request->input('search_user');

        $staff = User::where('role', 'staff')
            ->when($searchStaff, function($query) use ($searchStaff) {
                $query->where('name', 'like', "%{$searchStaff}%")
                    ->orWhere('email', 'like', "%{$searchStaff}%");
            })
            ->latest()
            ->paginate(5, ['*'], 'staff_page');

        $users = User::where('role', 'user')
            ->when($searchUser, function($query) use ($searchUser) {
                $query->where('name', 'like', "%{$searchUser}%")
                    ->orWhere('email', 'like', "%{$searchUser}%");
            })
            ->latest()
            ->paginate(5, ['*'], 'user_page');

        return view('admin.users.index', compact('staff', 'users'));
    }

    public function create()
    {
        return view('admin.users.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => [
                'required',
                'string',
                'email',
                'max:255',
                // Tetap gunakan validasi unique untuk user yang AKTIF (bukan yang dihapus)
                Rule::unique('users', 'email')->whereNull('deleted_at'),
            ],
            'password'              => 'required|string|min:8|confirmed',
            'phone'                 => 'nullable|string|max:20',
            'password_confirmation' => 'required_with:password',
        ]);

        // CEK APAKAH USER SUDAH ADA DI TRASH (Soft Deleted)
        $existingUser = User::withTrashed()->where('email', $request->email)->first();

        if ($existingUser) {
            // Jika ada di trash, kita hidupkan lagi (Restore)
            $existingUser->restore();
            $existingUser->update([
                'name'     => $request->name,
                'password' => Hash::make($request->password),
                'phone'    => $request->phone,
                'role'     => 'staff', // Pastikan rolenya staff
            ]);
            
            return redirect()->route('admin.users.index')->with('success', 'Akun staff lama dengan email ini telah diaktifkan kembali.');
        }

        // Jika benar-benar baru, buat seperti biasa
        User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'phone'    => $request->phone,
            'role'     => 'staff',
        ]);

        return redirect()->route('admin.users.index')->with('success', 'Staff berhasil dibuat.');
    }

    public function show(User $user)
    {
        $ordersCount = $user->orders()->count();
        $totalSpending = $user->orders()->sum('total_price');

        return view('admin.users.show', compact('user', 'ordersCount', 'totalSpending'));
    }

    public function edit(User $user)
    {

        if ($user->role !== 'staff') {
            abort(403, 'Anda hanya bisa mengedit akun staff.');
        }

        return view('admin.users.edit', compact('user'));
    }


    public function update(Request $request, User $user)
    {
        if ($user->role !== 'staff') {
            abort(403);
        }

        $request->validate([
            'name'  => 'required|string|max:255',
            'email' => [
                'required', // Sebaiknya required kalau memang mau ada emailnya
                'string',
                'email',
                'max:255',
                // Abaikan user ini sendiri saat pengecekan unique
                Rule::unique('users', 'email')->ignore($user->id)->whereNull('deleted_at'), 
            ],
            'phone'    => 'nullable|string|max:20',
            'password' => 'nullable|string|min:8|confirmed',
            'is_active' => 'required|boolean',
        ]);

        $data = $request->only('name', 'email', 'phone', 'is_active');

        if($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

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

    public function updateAdmin(Request $request)
    {
        $user = auth()->user();

        $request->validate([
            'email' => 'required|email|unique:users,email,' . $user->id,
            'current_password' => 'required',
            'new_password' => 'nullable|min:8|confirmed',
        ]);

        // 1. Verifikasi password saat ini
        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Password saat ini tidak cocok.']);
        }

        // 2. Update Email
        $user->email = $request->email;

        // 3. Update Password jika diisi
        if ($request->filled('new_password')) {
            $user->password = Hash::make($request->new_password);
        }

        $user->save();

        return back()->with('success', 'Profil dan keamanan berhasil diperbarui!');
    }

}
