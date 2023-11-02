<?php

namespace App\Http\Controllers\Frontend\User;

use App\Models\BloodGroup;
use App\Models\BloodRequest;
use App\Models\City;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Redirect;

/**
 * Class DashboardController.
 */
class DashboardController
{
    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        $blood_requests = BloodRequest::join('blood_groups', 'blood_groups.id', '=', 'blood_group_id')
            ->join('cities', 'cities.id', '=', 'blood_requests.city_id')
            ->where('blood_requests.blood_group_id', '=', auth()->user()->blood_group_id)
            ->where('blood_requests.city_id', '=', auth()->user()->city_id)
            ->where('blood_requests.sender_id', '!=', auth()->user()->id)
            ->get([
                'blood_requests.id',
                'recipient_name',
                'blood_groups.name as blood_group',
                'cities.name as city',
                'contact_no',
                'gender',
                'status',
                'age',
                'address',
                'hospital_name'
            ]);

        $user_blood_requests = BloodRequest::join('blood_groups', 'blood_groups.id', '=', 'blood_group_id')
            ->join('cities', 'cities.id', '=', 'blood_requests.city_id')
            ->where('sender_id', '=', auth()->user()->id)
            ->get([
                'blood_requests.id',
                'recipient_name',
                'blood_groups.name as blood_group',
                'cities.name as city',
                'contact_no',
                'gender',
                'age',
                'status',
                'address',
                'hospital_name'
            ]);
        // dd($blood_requests);
        // dd(auth()->user()->blood_group_id);

        return view('frontend.user.dashboard', ['user' => auth()->user(), 'blood_requests' => $blood_requests, 'user_blood_requests' => $user_blood_requests]);
    }

}
