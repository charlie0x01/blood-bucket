<?php

namespace App\Http\Controllers;

use App\Http\Requests\BloodRR;
use App\Models\BloodGroup;
use App\Models\BloodRequest;
use App\Models\City;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Redirect;

class BloodRequestController extends Controller
{
    //
    public function requestBlood()
    {

        // get cities
        $cities = City::all();
        // get blood groups
        $blood_groups = BloodGroup::all();

        return view("frontend.pages.request-blood", ['cities' => $cities, 'blood_groups' => $blood_groups]);
    }

    public function send(BloodRR $request): RedirectResponse
    {

        try {

            $request->request->add(['sender_id' => auth()->user()->id]);
            $request->request->add(['status' => 'Waiting']);
            // dd($request->all());
            // get request blood form data

            BloodRequest::create($request->all());

            return redirect()->route('frontend.user.dashboard')
                        ->with('success','Request sent successfully.');

            
        } catch (\Exception $e) {
            return redirect::back()->withErrors($e->getMessage());
        }
    }

    public function editRequest($id) {
        dd($id);
    }
}
