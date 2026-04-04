<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Address;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class AddressController extends Controller
{
    public function index()
    {
        $addresses = Auth::user()->addresses;

        $breadcrumbs = [
            ['name' => 'Akun Saya', 'url' => route('user.account.addresses')],
            ['name' => 'Daftar Alamat', 'url' => null],
        ];

        return view('user.account.addresses.index', compact('addresses', 'breadcrumbs'));
    }

    public function create()
    {
        $breadcrumbs = [
            ['name' => 'Akun Saya', 'url' => route('user.account.addresses')],
            ['name' => 'Tambah Alamat', 'url' => null],
        ];

        return view('user.account.addresses.create.index', compact('breadcrumbs'));
    }

    public function store(Request $request)
    {
        $user = Auth::user();

        // Cek Limit Alamat (Maksimal 5)
        if ($user->addresses()->count() >= 5) {
            return back()->with('error', 'Maksimal alamat yang bisa disimpan adalah 5.');
        }

        $request->validate([
            'type' => 'required|string|max:50',
            'recipient_name' => 'required|string|max:255',
            'phone' => 'required|string',
            'address' => 'required|string',
            'city' => 'required|string',
            'province' => 'required|string',
            'postal_code' => 'required|string',
        ]);

        // Jika ini alamat pertama, otomatis jadi default
        $isFirst = $user->addresses()->count() == 0;
        $isDefault = $request->has('is_default') || $isFirst;

        if ($isDefault) {
            $user->addresses()->update(['is_default' => false]);
        }

        $user->addresses()->create([
            'recipient_name' => $request->recipient_name,
            'phone' => $request->phone,
            'address' => $request->address,
            'city' => $request->city,
            'province' => $request->province,
            'postal_code' => $request->postal_code,
            'is_default' => $isDefault,
        ]);

        return redirect()->route('user.account.addresses')->with('success', 'Alamat berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $address = Address::where('user_id', Auth::id())->findOrFail($id);

        $breadcrumbs = [
            ['name' => 'Akun Saya', 'url' => route('user.account.addresses')],
            ['name' => 'Edit Alamat', 'url' => null],
        ];

        return view('user.account.addresses.edit.index', compact('address', 'breadcrumbs'));
    }

    public function update(Request $request, $id)
    {
        $address = Address::where('user_id', Auth::id())->findOrFail($id);

        if ($request->is_default) {
            Address::where('user_id', Auth::id())
                ->update(['is_default' => false]);
        }

        $address->update($request->all());

        return redirect()->route('user.account.addresses')->with('success', 'Address updated');
    }

    public function destroy($id)
    {
        $address = Address::where('user_id', Auth::id())->findOrFail($id);
        $address->delete();

        return back()->with('success', 'Address deleted');
    }
}
