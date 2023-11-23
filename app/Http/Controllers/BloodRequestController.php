<?php

namespace App\Http\Controllers;

use App\Models\BloodGroup;
use App\Models\BloodRequest;
use App\Models\City;
use App\Models\Donation;
use App\Models\User;
use GuzzleHttp\Psr7\Message;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Illuminate\Mail\Events\MessageSent;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class BloodRequestController extends Controller
{
    public function index()
    {

        $bloodRequests = BloodRequest::all();
        return view('blood_requests.index', compact('bloodRequests'));
    }

    public function create()
    {

        // blood groups
        $blood_groups = BloodGroup::all();
        // cities
        $cities = City::all();
        $bloodRequest = new BloodRequest();
        return view('blood_requests.create', [
            'cities' => $cities,
            'bloodGroups' => $blood_groups,
            'bloodRequest' => $bloodRequest,
            'id' => $bloodRequest->id,
            'recipient_name' => $bloodRequest->recipient_name,
            'blood_group_id' => $bloodRequest->blood_group_id,
            'city_id' => $bloodRequest->city_id,
            'age' => $bloodRequest->age,
            'gender' => $bloodRequest->gender,
            'contact_no' => $bloodRequest->contact_no,
            'address' => $bloodRequest->address,
            'hospital_name' => $bloodRequest->hospital_name,
            'emergency_flag' => $bloodRequest->emergency_flag,
            'need_on' => $bloodRequest->need_on,
            'update' => 0
        ]);
    }

    public function store(Request $request)
    {
        try {
            //code...
            $validator = Validator::make($request->all(), [
                'recipient_name' => 'required',
                'blood_group_id' => 'required|exists:blood_groups,id',
                'city_id' => 'required|exists:cities,id',
                'age' => 'required|numeric',
                'gender' => 'required|in:male,female',
                'contact_no' => 'required|numeric|digits:11',
                'hospital_name' => 'required',
                'need_on' => 'required|date|after_or_equal:today',
                // 'request_state' => 'required|in:pending,approved,fulfilled',
            ]);

            if ($validator->fails()) {
                return redirect()->route('blood-requests.create')
                    ->withErrors($validator)
                    ->withInput();
            }

            $ef = 0;
            if ($request->emergency_flag == true)
                $ef = 1;
            // BloodRequest::create($request->all());
            BloodRequest::create([
                'recipient_name' => $request->recipient_name,
                'blood_group_id' => $request->blood_group_id,
                'city_id' => $request->city_id,
                'age' => $request->age,
                'gender' => $request->gender,
                'contact_no' => $request->contact_no,
                'hospital_name' => $request->hospital_name,
                'need_on' => date('Y-m-d', strtotime($request->need_on)),
                'emergency_flag' => $ef,
                'request_state' => BloodRequest::REQ_PENDING,
                'sender_id' => Auth::id(),
            ]);

            Session::flash('success', 'Blood request created successfully');
            return redirect()->route('dashboard');
        } catch (\Exception $ex) {
            Session::flash('error', $ex->getMessage());
            return redirect()->route('blood-requests.create');
        }
    }


    public function show($id)
    {

        // $bloodRequest = BloodRequest::join('blood_groups as bg', 'bg.id', '=', 'blood_requests.blood_group_id')
        // ->join('cities', 'cities.id', '=', 'blood_requests.city_id')
        // ->get([
        //     'blood_requests.id',
        //     'bg.name as blood_group',
        //     'cities.name as city',
        //     'blood_requests.recipient_name',
        //     'blood_requests.age',
        //     'blood_requests.gender',
        //     'blood_requests.hospital_name',
        //     'blood_requests.emergency_flag',
        //     'blood_requests.request_state',
        // ]);
        // return view('blood_requests.show', compact('bloodRequest'));
    }
    public function user_requests($id)
    {
        $bloodRequest = BloodRequest::join('blood_groups as bg', 'bg.id', '=', 'blood_requests.blood_group_id')
            ->join('cities', 'cities.id', '=', 'blood_requests.city_id')
            ->where('sender_id', $id)
            ->where('blood_requests.request_state', '!=', BloodRequest::REQ_FULFILLED)
            ->orderBy('blood_requests.need_on', 'desc')
            ->orderBy('blood_requests.emergency_flag', 'desc')
            ->get([
                'blood_requests.id',
                'bg.name as blood_group',
                'cities.name as city',
                'blood_requests.recipient_name',
                'blood_requests.age',
                'blood_requests.gender',
                'blood_requests.hospital_name',
                'blood_requests.contact_no',
                'blood_requests.emergency_flag',
                'blood_requests.request_state',
                'blood_requests.sender_id',
            ]);
        return view('user.dashboard.user-requests', ['bloodRequests' => $bloodRequest]);
    }

    public function edit($id)
    {
        $bloodRequest = BloodRequest::findOrFail($id);
        // $bloodRequest = BloodRequest::join('blood_groups as bg', 'bg.id', '=', 'blood_requests.blood_group_id')
        //     ->join('cities', 'cities.id', '=', 'blood_requests.city_id')
        //     ->where('blood_requests.id', $id)
        //     ->get([
        //         'blood_requests.id as id',
        //         'blood_requests.recipient_name',
        //         'blood_requests.age',
        //         'blood_requests.gender',
        //         'blood_requests.contact_no',
        //         'bg.name as blood_group',
        //         'bg.id as blood_group_id',
        //         'cities.name as city',
        //         'cities.id as city_id',
        //         'blood_requests.hospital_name',
        //         'blood_requests.emergency_flag',
        //         'blood_requests.need_on',
        //         'blood_requests.address',
        //     ]);

        // // new object 
        // $blood_request = new BloodRequest();
        // // fill data
        // foreach ($bloodRequest as $br) {
        //     $blood_request->id = $br->id;
        //     $blood_request->recipient_name = $br->recipient_name;
        //     $blood_request->age = $br->age;
        //     $blood_request->gender = $br->gender;
        //     $blood_request->contact_no = $br->contact_no;
        //     $blood_request->blood_group_id = $br->blood_group_id;
        //     $blood_request->city_id = $br->city_id;
        //     $blood_request->hospital_name = $br->hospital_name;
        //     $blood_request->emergency_flag = $br->emergency_flag;
        //     $blood_request->need_on = $br->need_on;
        //     $blood_request->address = $br->address;
        // }

        // blood groups
        $blood_groups = BloodGroup::all();
        // cities
        $cities = City::all();

        return view('blood_requests.create', [
            'bloodGroups' => $blood_groups, 'cities' => $cities,
            'id' => $bloodRequest->id,
            'recipient_name' => $bloodRequest->recipient_name,
            'blood_group_id' => $bloodRequest->blood_group_id,
            'city_id' => $bloodRequest->city_id,
            'age' => $bloodRequest->age,
            'gender' => $bloodRequest->gender,
            'contact_no' => $bloodRequest->contact_no,
            'address' => $bloodRequest->address,
            'hospital_name' => $bloodRequest->hospital_name,
            'emergency_flag' => $bloodRequest->emergency_flag,
            'need_on' => $bloodRequest->need_on,
            'update' => 1
        ]);


        // return view('blood_requests.create', compact('bloodRequest'));
    }

    public function update(Request $request, $id)
    {

        $validator = Validator::make($request->all(), [
            'recipient_name' => 'required',
            'blood_group_id' => 'required|exists:blood_groups,id',
            'city_id' => 'required|exists:cities,id',
            'age' => 'required|numeric',
            'gender' => 'required|in:male,female',
            'contact_no' => 'required|numeric|digits:11',
            'hospital_name' => 'required',
            'need_on' => 'required|date|after_or_equal:today',
            // 'emergency_flag' => 'required|boolean',
        ]);

        if ($validator->fails()) {
            return redirect()->route('blood-requests.edit', $id)
                ->withErrors($validator)
                ->withInput();
        }

        $bloodRequest = BloodRequest::findOrFail($id);
        $bloodRequest->update($request->all());

        return redirect()->route('blood-requests.getAll', ['id' => auth()->user()->id])->with('success', 'Blood request updated successfully');
    }

    public function destroy($id)
    {
        $bloodRequest = BloodRequest::findOrFail($id);
        $bloodRequest->delete();
        return redirect()->route('blood-requests.getAll', ['id' => auth()->user()->id])->with('success', 'Blood request deleted successfully');
    }

    public function new($id)
    {
        if ($id == 1) {
            $bloodRequest = BloodRequest::join('blood_groups as bg', 'bg.id', '=', 'blood_requests.blood_group_id')
                ->join('cities', 'cities.id', '=', 'blood_requests.city_id')
                ->where('blood_requests.request_state', '=', 'pending')
                ->where('sender_id', '!=', $id)
                ->orderBy('blood_requests.emergency_flag', 'desc')
                ->get([
                    'blood_requests.id',
                    'bg.name as blood_group',
                    'cities.name as city',
                    'blood_requests.recipient_name',
                    'blood_requests.age',
                    'blood_requests.gender',
                    'blood_requests.hospital_name',
                    'blood_requests.emergency_flag',
                    'blood_requests.request_state',
                    'blood_requests.sender_id',
                ]);
            return view('user.dashboard.new-requests', ['bloodRequests' => $bloodRequest]);
        } else {
            $bloodRequest = BloodRequest::join('blood_groups as bg', 'bg.id', '=', 'blood_requests.blood_group_id')
                ->join('cities', 'cities.id', '=', 'blood_requests.city_id')
                ->where('blood_requests.request_state', '=', 'pending')
                ->where('blood_requests.blood_group_id', '=', auth()->user()->blood_group_id)
                ->where('blood_requests.city_id', '=', auth()->user()->city_id)
                ->where('sender_id', '!=', $id)
                ->orderBy('blood_requests.emergency_flag', 'desc')
                ->get([
                    'blood_requests.id',
                    'bg.name as blood_group',
                    'cities.name as city',
                    'blood_requests.recipient_name',
                    'blood_requests.age',
                    'blood_requests.gender',
                    'blood_requests.hospital_name',
                    'blood_requests.emergency_flag',
                    'blood_requests.request_state',
                    'blood_requests.sender_id',
                ]);
            return view('user.dashboard.new-requests', ['bloodRequests' => $bloodRequest]);
        }
    }

    public function donor_accepted($id)
    {
        $bloodRequest = BloodRequest::join('blood_groups as bg', 'bg.id', '=', 'blood_requests.blood_group_id')
            ->join('cities', 'cities.id', '=', 'blood_requests.city_id')
            ->where('donor_id', '=', $id)
            ->where('blood_requests.request_state', '!=', 'fulfilled')
            ->orderBy('blood_requests.need_on', 'desc')
            ->orderBy('blood_requests.emergency_flag', 'desc')
            ->get([
                'blood_requests.id',
                'bg.name as blood_group',
                'cities.name as city',
                'blood_requests.recipient_name',
                'blood_requests.age',
                'blood_requests.gender',
                'blood_requests.hospital_name',
                'blood_requests.emergency_flag',
                'blood_requests.request_state',
                'blood_requests.donor_id',
            ]);
        return view('user.dashboard.accepted-requests', ['bloodRequests' => $bloodRequest]);
    }

    public function accept($id)
    {
        $bloodRequest = BloodRequest::findOrFail($id);
        if (auth()->user()->type == 'admin') {
            $bloodRequest->update([
                'request_state' => BloodRequest::REQ_APPROVED,
                'approved_by' => Auth::id(),
                'donor_id' => Auth::id()
            ]);
        } else {
            $bloodRequest->update([
                'request_state' => BloodRequest::REQ_ACCEPTED,
                'donor_id' => Auth::id()
            ]);
        }
        Session::flash('success', 'Blood request accepted.');
        return redirect()->route('blood-requests.new', ['id' => Auth::id()]);
    }

    public function decline($id)
    {
        $bloodRequest = BloodRequest::findOrFail($id);
        if (Auth::id() == $bloodRequest->donor_id) {
            $bloodRequest->update([
                'request_state' => BloodRequest::REQ_PENDING,
                'approved_by' => null,
                'donor_id' => null
            ]);
        }
        Session::flash('success', 'Blood Request Declined.');
        return redirect()->route('blood-requests.accepted', ['id' => Auth::id()]);
    }

    public function fulfill($id)
    {
        $bloodRequest = BloodRequest::findOrFail($id);
        if ($bloodRequest->sender_id == Auth::id()) {
            $bloodRequest->request_state = BloodRequest::REQ_FULFILLED;
            $bloodRequest->update();

            // create donations
            $donation = Donation::create([
                'donation_date' => date('Y-m-d', strtotime(now())),
                'blood_request_id' => $bloodRequest->id
            ]);

            Session::flash('success', 'Blood Request Fulfilled');
            return redirect()->route('blood-requests.new', ['id' => Auth::id()]);
        } else {
            Session::flash('error', 'unauthorized request!');
            return redirect()->route('blood-requests.new', ['id' => Auth::id()]);
        }
    }

    public function fulfilled($id)
    {
        if (auth()->user()->type == User::TYPE_ADMIN) {
            $bloodRequest = Donation::join('blood_requests', 'blood_requests.id', '=', 'donations.blood_request_id')
                ->join('blood_groups as bg', 'bg.id', '=', 'blood_requests.blood_group_id')
                ->join('cities', 'cities.id', '=', 'blood_requests.city_id')
                ->join('users', 'users.id', '=', 'blood_requests.donor_id')
                ->where('request_state', '=', BloodRequest::REQ_FULFILLED)
                ->get([
                    'blood_requests.id',
                    'bg.name as blood_group',
                    'cities.name as city',
                    'blood_requests.recipient_name',
                    'blood_requests.age',
                    'blood_requests.gender',
                    'blood_requests.hospital_name',
                    'blood_requests.emergency_flag',
                    'blood_requests.request_state',
                    'users.name',
                    'users.type as user_type',
                    'donations.donation_date'
                ]);
            return view('user.dashboard.history', ['bloodRequests' => $bloodRequest]);
        } else if (auth()->user()->type == User::TYPE_RECIPIENT) {
            $bloodRequest = Donation::join('blood_requests', 'blood_requests.id', '=', 'donations.blood_request_id')
                ->join('blood_groups as bg', 'bg.id', '=', 'blood_requests.blood_group_id')
                ->join('cities', 'cities.id', '=', 'blood_requests.city_id')
                ->join('users', 'users.id', '=', 'blood_requests.donor_id')
                ->where('request_state', '=', BloodRequest::REQ_FULFILLED)
                ->where('blood_requests.sender_id', '=', $id)
                ->orWhere('blood_requests.sender_id', '=', $id)
                ->get([
                    'blood_requests.id',
                    'bg.name as blood_group',
                    'cities.name as city',
                    'blood_requests.recipient_name',
                    'blood_requests.age',
                    'blood_requests.gender',
                    'blood_requests.hospital_name',
                    'blood_requests.emergency_flag',
                    'blood_requests.request_state',
                    'users.name',
                    'users.type as user_type',
                    'donations.donation_date'
                ]);
            return view('user.dashboard.history', ['bloodRequests' => $bloodRequest]);
        } else if (auth()->user()->type == User::TYPE_DONOR) {
            $bloodRequest = Donation::join('blood_requests', 'blood_requests.id', '=', 'donations.blood_request_id')
                ->join('blood_groups as bg', 'bg.id', '=', 'blood_requests.blood_group_id')
                ->join('cities', 'cities.id', '=', 'blood_requests.city_id')
                ->join('users', 'users.id', '=', 'blood_requests.donor_id')
                ->where('request_state', '=', BloodRequest::REQ_FULFILLED)
                ->where('blood_requests.donor_id', '=', $id)
                ->orWhere('blood_requests.sender_id', '=', $id)
                ->get([
                    'blood_requests.id',
                    'bg.name as blood_group',
                    'cities.name as city',
                    'blood_requests.recipient_name',
                    'blood_requests.age',
                    'blood_requests.gender',
                    'blood_requests.hospital_name',
                    'blood_requests.emergency_flag',
                    'blood_requests.request_state',
                    'users.name',
                    'users.type as user_type',
                    'donations.donation_date'
                ]);
            return view('user.dashboard.history', ['bloodRequests' => $bloodRequest]);
        } else {
            Session::flash('error', 'unauthorized request!');
        }
    }

    // need approval
    public function need_approval()
    {
        if (auth()->user()->type == 'admin') {
            $bloodRequest = BloodRequest::join('blood_groups as bg', 'bg.id', '=', 'blood_requests.blood_group_id')
                ->join('cities', 'cities.id', '=', 'blood_requests.city_id')
                ->join('users', 'users.id', '=', 'blood_requests.donor_id')
                ->where('request_state', '=', BloodRequest::REQ_ACCEPTED)
                ->get([
                    'blood_requests.id',
                    'bg.name as blood_group',
                    'cities.name as city',
                    'blood_requests.recipient_name',
                    'blood_requests.age',
                    'blood_requests.gender',
                    'blood_requests.hospital_name',
                    'blood_requests.emergency_flag',
                    'blood_requests.request_state',
                    'users.name',
                    'users.type as user_type'
                ]);
            return view('admin.dashboard.need-approval', ['bloodRequests' => $bloodRequest]);
        }
    }
    
    public function approved()
    {
        if (auth()->user()->type == 'admin') {
            $bloodRequest = BloodRequest::join('blood_groups as bg', 'bg.id', '=', 'blood_requests.blood_group_id')
                ->join('cities', 'cities.id', '=', 'blood_requests.city_id')
                ->join('users', 'users.id', '=', 'blood_requests.donor_id')
                ->where('request_state', '=', BloodRequest::REQ_APPROVED)
                ->get([
                    'blood_requests.id',
                    'bg.name as blood_group',
                    'cities.name as city',
                    'blood_requests.recipient_name',
                    'blood_requests.age',
                    'blood_requests.gender',
                    'blood_requests.hospital_name',
                    'blood_requests.emergency_flag',
                    'blood_requests.request_state',
                    'users.name',
                    'users.type as user_type'
                ]);
            return view('admin.dashboard.approved', ['bloodRequests' => $bloodRequest]);
        }
    }

    public function i_approve($id)
    {
        if (auth()->user()->type == 'admin') {
            $bloodRequest = BloodRequest::findOrFail($id);
            $bloodRequest->request_state = BloodRequest::REQ_APPROVED;
            $bloodRequest->update();

            Session::flash('success', 'Blood Request Approved');
            return redirect()->route('blood-request.need.approval');
        } else {
            Session::flash('error', 'Unauthorized Request.');
            return redirect()->route('blood-request.need.approval');
        }
    }
}
