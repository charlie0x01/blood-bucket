<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\BloodGroup;
use App\Models\City;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        // blood groups
        $blood_groups = BloodGroup::all();
        // cities
        $cities = City::all();
        return view('profile.edit', [
            'user' => $request->user(),
            'cities' => $cities,
            'blood_groups' => $blood_groups,
        ]);
    }



    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $user = User::find(Auth::id());

        // check if user have upload avatar
        if ($request->avatar != null) {
            $destination = 'public/avatars';
            // update file name
            $filename = time() . '.' . $request->avatar->extension();
            // path
            $path = 'storage/avatars/' . $filename;
            // store
            $request->avatar->storeAs($destination, $filename);
            $user->avatar = $path ?? null;
        }

        // check if user wants to change user type
        // if user is recipient and changing to donor, set verified to null
        if($user->type == "recipient" && $request->type == "donor")
            $user->email_verified_at = null;
        
        // check if user in donor and changing to recipient
        else if($user->type == "donor" && $request->type == "recipient")
            $user->email_verified_at = now();
            

        // dd($user, $request);
        $user->name = $request->name ?? $user->name;
        $user->email = $request->email ?? $user->email;
        $user->type = $request->type ?? $user->type;
        $user->age = $request->age ?? $user->age;
        $user->gender = $request->gender ?? $user->gender;
        $user->blood_group_id = $request->blood_group_id ?? $user->blood_group_id;
        $user->city_id = $request->city_id ?? $user->city_id;
        $user->contact_no = $request->contact_no ?? $user->contact_no;

        $user->update();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    public function remove(Request $request): RedirectResponse
    {
        $user = User::find(Auth::id());
        // if ($user->avatar != null)
        //     if (Storage::disk('public')->exists(`$user->avatar`)) {
        //         Storage::disk('public')->delete(`$user->avatar`);
        //     }
        $user->avatar = null;
        $user->update();
        return Redirect::route('profile.edit')->with('status', 'avatar-removed');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current-password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
