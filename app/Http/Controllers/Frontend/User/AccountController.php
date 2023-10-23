<?php

namespace App\Http\Controllers\Frontend\User;

use App\Models\BloodGroup;
use App\Models\City;

/**
 * Class AccountController.
 */
class AccountController
{
    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {

        // blood group
        $blood_groups = BloodGroup::all();
        // cities
        $cities = City::all();
        return view('frontend.user.account', ['cities' => $cities, 'blood_groups' => $blood_groups]);
    }
}
