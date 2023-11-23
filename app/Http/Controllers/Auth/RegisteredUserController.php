<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\BloodGroup;
use App\Models\City;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        // blood groups
        $blood_groups = BloodGroup::all();
        // cities
        $cities = City::all();
        return view('auth.register', ['cities' => $cities, 'blood_groups' => $blood_groups]);
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {

        $request->validate([
            'type' => ['required', 'string', 'in:donor,recipient'],
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:'.User::class],
            'age' => ['required'],
            'contact_no' => ['required', 'digits:11'],
            'gender' => ['required', 'string', 'in:male,female'],
            'blood_group_id' => ['required'],
            'city_id' => ['required'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'type' => $request->type,
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'age' => $request->age,
            'contact_no' => $request->contact_no,
            'gender' => $request->gender,
            'city_id' => $request->city_id,
            'blood_group_id' => $request->blood_group_id,
        ]);

        event(new Registered($user));

        
        Auth::login($user);
        
        // set user verified if user type is recipient
        if($request->type == 'recipient') {
            $user = User::find(Auth::id());
            $user->email_verified_at = now();
            $user->update();
        }


        return redirect(RouteServiceProvider::HOME);
    }
}
