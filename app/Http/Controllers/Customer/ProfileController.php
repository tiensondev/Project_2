<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
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
    $user = User::findOrFail(Auth::id()); 

    $request->validate([
        'name'           => 'required|string|max:255',
        'phone'          => 'nullable|regex:/^([0-9\s\-\+\(\)]*)$/|min:10|max:15',
        'province'       => 'nullable|string',
        'district'       => 'nullable|string',
        'ward'           => 'nullable|string',
        'address_detail' => 'nullable|string|max:255',
        'avatar'         => 'nullable|image|mimes:jpg,jpeg,png,webp,gif|max:2048',
    ]);

    $data = $request->except('avatar');

    if ($request->hasFile('avatar')) {
        if ($user->avatar && File::exists(public_path('uploads/' . $user->avatar))) {
            File::delete(public_path('uploads/' . $user->avatar));
        }

        $file = $request->file('avatar');
        $fileName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
        
        $file->move(public_path('uploads'), $fileName);
        
        $data['avatar'] = $fileName;
    }

    $user->update($data);
    
    return redirect()->back()->with('success', 'Profile updated successfully!');
}
}