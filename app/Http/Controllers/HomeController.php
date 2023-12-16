<?php

namespace App\Http\Controllers;

use App\Models\BloodBank;
use App\Models\BloodRequest;
use App\Models\Donation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    //
    public function index()
    {
        // no. of new requests
        $newRequests = count(BloodRequest::where('request_state', '=', 'pending')
            ->where('sender_id', '!=', Auth::id())
            ->get());
        // no. of fulfilled requests
        $fulfilledRequests = count(BloodRequest::where('request_state', '=', 'fulfilled')->where('sender_id', '=', Auth::id())->get());
        // active requests
        $activeRequests = count(BloodRequest::where('request_state', '!=', 'fulfilled')->where('sender_id', '=', Auth::id())->get());
        $givenDonations = count(BloodRequest::where('request_state', '=', 'fulfilled')->where('donor_id', '=', Auth::id())->get());
        return view('dashboard', [
            'newRequests' => $newRequests,
            'fulfilledRequest' => $fulfilledRequests,
            'activeRequests' => $activeRequests,
            'givenDonations' => $givenDonations
        ]);
    }
    public function admin()
    {
        // no. of new requests
        $newRequests = count(BloodRequest::where('request_state', '=', 'pending')->get());
        // no. of fulfilled requests
        $fulfilledRequests = count(BloodRequest::where('request_state', '=', 'fulfilled')->where('sender_id', '=', Auth::id())->get());
        // active requests
        $activeRequests = count(BloodRequest::where('request_state', '!=', 'fulfilled')->where('sender_id', '=', Auth::id())->get());
        $givenDonations = count(BloodRequest::where('request_state', '=', 'fulfilled')->where('donor_id', '=', Auth::id())->get());

        // blood record
        $aPositive = BloodBank::where('blood_group_id', '=', 1)->value('quantity');
        $aNegative = BloodBank::where('blood_group_id', '=', 2)->value('quantity');
        $bPositive = BloodBank::where('blood_group_id', '=', 3)->value('quantity');
        $bNegative = BloodBank::where('blood_group_id', '=', 4)->value('quantity');
        $aBPositive = BloodBank::where('blood_group_id', '=', 5)->value('quantity');
        $aBNegative = BloodBank::where('blood_group_id', '=', 6)->value('quantity');
        $oPositive = BloodBank::where('blood_group_id', '=', 7)->value('quantity');
        $oNegative = BloodBank::where('blood_group_id', '=', 8)->value('quantity');
        return view('admin.dashboard.dashboard', [
            'newRequests' => $newRequests,
            'fulfilledRequest' => $fulfilledRequests,
            'activeRequests' => $activeRequests,
            'givenDonations' => $givenDonations,
            'aPositive' => $aPositive,
            'aNegative' => $aNegative,
            'bPositive' => $bPositive,
            'bNegative' => $bNegative,
            'aBPositive' => $aBPositive,
            'aBNegative' => $aBNegative,
            'oPositive' => $oPositive,
            'oNegative' => $oNegative
        ]);
    }
}
