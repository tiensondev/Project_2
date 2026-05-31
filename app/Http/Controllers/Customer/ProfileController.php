<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class ProfileController extends Controller
{
    public function show()
    {
        $user = Auth::user();
        return view('profile', compact('user'));
    }

    public function edit()
    {
        $user = Auth::user();
        return view('editprofile', compact('user'));
    }

    public function update(Request $request)
    {

        $user = \App\Models\User::findOrFail(Auth::id());

        $request->validate([
            'name'           => 'required|string|max:255',
            'phone'          => 'nullable|regex:/^([0-9\s\-\+\(\)]*)$/|min:10|max:15',
            'province'       => 'nullable|string',
            'district'       => 'nullable|string',
            'ward'           => 'nullable|string',
            'address_detail' => 'nullable|string|max:255',
        ]);

        $user->update($request->all());

        return redirect()->back()->with('success', 'Profile updated successfully!');
    }
}