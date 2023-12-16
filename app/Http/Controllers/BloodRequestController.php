<?php

namespace App\Http\Controllers;

use App\Models\BloodBank;
use App\Models\BloodGroup;
use App\Models\BloodRequest;
use App\Models\City;
use App\Models\Donation;
use App\Models\User;
use Carbon\Carbon;
use GuzzleHttp\Psr7\Message;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Illuminate\Mail\Events\MessageSent;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Monolog\Handler\NullHandler;

class BloodRequestController extends Controller
{
    public function index()
    {
        $bloodRequests = BloodRequest::all();
        return view('blood_requests.index', compact('bloodRequests'));
    }

    public function bloodRecords($bid)
    {
        $bloodRecords = BloodBank::join('blood_groups as bg', 'bg.id', '=', 'bloodbank.blood_group_id')
            ->join('cities as city', 'city.id', '=', 'bloodbank.city_id')
            ->where('bloodbank.blood_group_id', '=', $bid)
            ->get([
                'bg.name as blood_group',
                'city.name as city',
                'bloodbank.quantity as units'
            ]);
        return view('admin.blood-record', ['bloodRecords' => $bloodRecords]);
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

    public function admin_create()
    {
        // blood groups
        $blood_groups = BloodGroup::all();
        // cities
        $cities = City::all();
        $bloodRequest = new BloodRequest();
        return view('admin.dashboard.create', [
            'bloodGroups' => $blood_groups,
            'cities' => $cities,
            'bloodRequest' => $bloodRequest,
            'id' => $bloodRequest->id,
            'recipient_name' => "Blood Bucket",
            'blood_group_id' => $bloodRequest->blood_group_id,
            'city_id' => $bloodRequest->city_id,
            'emergency_flag' => $bloodRequest->emergency_flag,
            'need_on' => $bloodRequest->need_on,
            'update' => 0
        ]);
    }

    public function store(Request $request)
    {
        try {

            if (Auth::id() == 1) {

                $validator = Validator::make($request->all(), [
                    'blood_group_id' => 'required|exists:blood_groups,id',
                    'city_id' => 'required|exists:cities,id',
                    'need_on' => 'required|date|after_or_equal:today',

                ]);

                if ($validator->fails()) {
                    return redirect()->route('blood-requests.admin.create')
                        ->withErrors($validator)
                        ->withInput();
                }
            } else {

                //code...
                $validator = Validator::make($request->all(), [
                    'recipient_name' => 'required',
                    'blood_group_id' => 'required|exists:blood_groups,id',
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
            }

            $ef = 0;
            if ($request->emergency_flag == true)
                $ef = 1;

            $recipient = 'Blood Bucket';
            if(Auth::user()->type != 'admin')
                $recipient = $request->recipient_name;

            // BloodRequest::create($request->all());
            BloodRequest::create([
                'recipient_name' => $recipient,
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
            return redirect()->route('blood-requests.get-all', ['id' => Auth::id()]);
        } catch (\Exception $ex) {
            Session::flash('error', $ex->getMessage());
            if (Auth::id() == 1)
                return redirect()->route('blood-requests.admin.create');
            else
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
            ->leftjoin('users', 'users.id', '=', 'blood_requests.donor_id')
            ->where('sender_id', '=', $id)
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
                'blood_requests.blood_report',
                'users.name as donor',
                'blood_requests.need_on as date'
            ]);
        return view('user.dashboard.user-requests', ['bloodRequests' => $bloodRequest]);
    }

    public function edit($id)
    {
        if (auth()->user()->type == 'admin') {
            $bloodRequest = BloodRequest::findOrFail($id);
            // blood groups
            $blood_groups = BloodGroup::all();
            // cities
            $cities = City::all();

            return view('admin.dashboard.create', [
                'bloodGroups' => $blood_groups, 'cities' => $cities,
                'id' => $bloodRequest->id,
                'recipient_name' => $bloodRequest->recipient_name,
                'blood_group_id' => $bloodRequest->blood_group_id,
                'city_id' => $bloodRequest->city_id,
                'emergency_flag' => $bloodRequest->emergency_flag,
                'need_on' => $bloodRequest->need_on,
                'update' => 1
            ]);
        } else {

            $bloodRequest = BloodRequest::findOrFail($id);
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
        }

        // return view('blood_requests.create', compact('bloodRequest'));
    }

    public function update(Request $request, $id)
    {
        if (auth()->user()->type == 'admin') {
            $validator = Validator::make($request->all(), [
                'blood_group_id' => 'required|exists:blood_groups,id',
                'city_id' => 'required|exists:cities,id',
                'need_on' => 'required|date|after_or_equal:today',
            ]);
            if ($validator->fails()) {
                return redirect()->route('blood-requests.edit', $id)
                    ->withErrors($validator)
                    ->withInput();
            }
        } else {

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
        }

        $bloodRequest = BloodRequest::findOrFail($id);
        $bloodRequest->update($request->all());

        Session::flash('success', 'Blood request updated successfully');
        return redirect()->route('blood-requests.get-all', ['id' => auth()->user()->id]);
    }

    public function destroy($id)
    {
        $bloodRequest = BloodRequest::findOrFail($id);
        $bloodRequest->delete();
        Session::flash('success', "Blood Request Deleted.");
        return redirect()->route('blood-requests.get-all', ['id' => auth()->user()->id]);
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
                    'blood_requests.need_on as date'
                ]);
            return view('user.dashboard.new-requests', ['bloodRequests' => $bloodRequest, 'days' => null]);
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

            // check user eligigbility for donation
            $lastDonation = Donation::join('blood_requests as br', 'br.id', '=', 'donations.blood_request_id')
                ->where('br.donor_id', '=', Auth::id())
                ->latest('donations.donation_date')
                ->select('donations.donation_date')
                ->value('donations.donation_date');

            $databaseDate = Carbon::parse($lastDonation);
            $currentDate = Carbon::now();

            // Calculate the difference in days
            $daysDifference = $currentDate->diffInDays($databaseDate);


            return view('user.dashboard.new-requests', ['bloodRequests' => $bloodRequest, 'days' => $daysDifference]);
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
                'blood_requests.need_on as date'
            ]);
        return view('user.dashboard.accepted-requests', ['bloodRequests' => $bloodRequest]);
    }

    public function accept($id)
    {
        $bloodRequest = BloodRequest::findOrFail($id);
        $bloodGroup = BloodGroup::where('id', '=', $bloodRequest->blood_group_id)->value('name');
        $city = City::where('id', '=', $bloodRequest->city_id)->value('name');
        if (auth()->user()->type == 'admin') {
            // check if admin can accept this blood request or not
            $quantity = BloodBank::where('city_id', '=', $bloodRequest->city_id)
                ->where('blood_group_id', '=', $bloodRequest->blood_group_id)
                ->value('quantity');
            if ($quantity > 0) {

                $bloodRequest->update([
                    'request_state' => BloodRequest::REQ_ACCEPTED,
                    'donor_id' => Auth::id()
                ]);

                Session::flash('success', 'Blood Request accepted and approved');
                return redirect()->route('blood-requests.accepted', ['id' => auth()->user()->id]);
            } else {
                Session::flash('error', 'Required Blood is not available in ' . $city);
                return redirect()->route('blood-requests.new', ['id' => Auth::id()]);
            }
        } else {
            // check last donation by user
            $lastDonation = Donation::join('blood_requests as br', 'br.id', '=', 'donations.blood_request_id')
                ->where('br.donor_id', '=', Auth::id())
                ->latest('donations.donation_date')
                ->select('donations.donation_date')
                ->value('donations.donation_date');

            $databaseDate = Carbon::parse($lastDonation);
            $currentDate = Carbon::now();

            // Calculate the difference in days
            $daysDifference = $currentDate->diffInDays($databaseDate);

            if ($daysDifference > 90) {

                $bloodRequest->update([
                    'request_state' => BloodRequest::REQ_ACCEPTED,
                    'donor_id' => Auth::id()
                ]);
                return view('user.accept', ['bloodRequest' => $bloodRequest, 'bloodGroup' => $bloodGroup, 'city' => $city]);
            } else {
                Session::flash('error', 'You\'re not eligible for any donation, for ' . (90 - $daysDifference) . ' days');
                return redirect()->route('blood-requests.new', ['id' => Auth::id()]);
            }
        }
    }

    public function decline($id)
    {
        $bloodRequest = BloodRequest::findOrFail($id);
        if (Auth::id() == $bloodRequest->donor_id) {
            $filename = basename($bloodRequest->blood_report);
            if (Storage::disk('public')->exists($filename)) {
                Storage::disk('public')->delete($filename);

                $bloodRequest->update([
                    'request_state' => BloodRequest::REQ_PENDING,
                    'approved_by' => null,
                    'donor_id' => null,
                    'blood_report' => null
                ]);
            } else {
                $bloodRequest->update([
                    'request_state' => BloodRequest::REQ_PENDING,
                    'approved_by' => null,
                    'donor_id' => null,
                    'blood_report' => null
                ]);
            }
        }
        Session::flash('success', 'Blood Request Declined.');
        return redirect()->route('blood-requests.accepted', ['id' => Auth::id()]);
    }

    public function fulfill($id)
    {
        $bloodRequest = BloodRequest::findOrFail($id);
        if ($bloodRequest->sender_id == Auth::id()) {
            try {
                DB::beginTransaction();

                // set request fulfilled
                DB::table('blood_requests')->where('blood_requests.id', '=', $id)->update(['request_state' => BloodRequest::REQ_FULFILLED]);

                // now add in donation
                DB::table('donations')->insert([
                    'donation_date' => date('Y-m-d', strtotime(now())),
                    'blood_request_id' => $bloodRequest->id
                ]);

                if (auth()->user()->type == 'admin') {
                    // now add blood to stock
                    $bupdate = BloodBank::where('blood_group_id', '=', $bloodRequest->blood_group_id)
                        ->where('city_id', '=', $bloodRequest->city_id)->get();

                    if (count($bupdate) == 0) {
                        DB::table('bloodbank')->insert([
                            'quantity' => 1,
                            'city_id' => $bloodRequest->city_id,
                            'blood_group_id' => $bloodRequest->blood_group_id
                        ]);
                    } else {
                        foreach ($bupdate as $b) {
                            DB::table('bloodbank')->update(['quantity' => $b->quantity + 1]);
                        }
                    }
                    // If all queries succeed, commit the transaction
                } else {
                    $bupdate = BloodBank::where('blood_group_id', '=', $bloodRequest->blood_group_id)
                    ->where('city_id', '=', $bloodRequest->city_id)->get();

                    foreach ($bupdate as $b) {
                        DB::table('bloodbank')->update(['quantity' => $b->quantity - 1]);
                    }
                }

                DB::commit();
                // Additional logic after a successful transaction
            } catch (\Exception $e) {
                // Something went wrong, rollback the transaction
                DB::rollBack();
                Session::flash('error', $e);
                return redirect()->route('blood-requests.get-all', ['id' => Auth::id()]);
            }

            Session::flash('success', 'Blood Request Fulfilled');
            return redirect()->route('blood-request.donations', ['id' => auth()->user()->id]);
        } else {
            Session::flash('error', 'unauthorized request!');
            return redirect()->route('blood-requests.get-all', ['id' => Auth::id()]);
        }
    }

    public function fulfilled($id)
    {
        if (auth()->user()->type == User::TYPE_ADMIN) {
            // admin history
            $bloodRequest = Donation::join('blood_requests', 'blood_requests.id', '=', 'donations.blood_request_id')
                ->join('blood_groups as bg', 'bg.id', '=', 'blood_requests.blood_group_id')
                ->join('cities', 'cities.id', '=', 'blood_requests.city_id')
                ->leftjoin('users as donorUser', 'donorUser.id', '=', 'blood_requests.donor_id')
                ->where('request_state', '=', BloodRequest::REQ_FULFILLED)
                ->get([
                    'blood_requests.id',
                    'bg.name as blood_group',
                    'cities.name as city',
                    'blood_requests.recipient_name as recipient',
                    'blood_requests.age',
                    'blood_requests.gender',
                    'blood_requests.hospital_name',
                    'blood_requests.emergency_flag',
                    'blood_requests.request_state',
                    'donorUser.name as donor',
                    'donorUser.type as user_type',
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
                    'blood_requests.recipient_name as recipient',
                    'blood_requests.age',
                    'blood_requests.gender',
                    'blood_requests.hospital_name',
                    'blood_requests.emergency_flag',
                    'blood_requests.request_state',
                    'users.name as donor',
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
                    'blood_requests.recipient_name as recipient',
                    'blood_requests.age',
                    'blood_requests.gender',
                    'blood_requests.hospital_name',
                    'blood_requests.emergency_flag',
                    'blood_requests.request_state',
                    'users.name as donor',
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
        $bloodRequest = BloodRequest::findOrFail($id);
        if ($bloodRequest->sender_id == Auth::id()) {

            $bloodRequest->request_state = BloodRequest::REQ_APPROVED;
            $bloodRequest->approved_by = Auth::id();
            $bloodRequest->update();

            Session::flash('success', 'Blood Request Approved');
            return redirect()->route('blood-requests.get-all', ['id' => Auth::id()]);
        } else {
            Session::flash('error', 'Unauthorized Request.');
            return redirect()->route('blood-requests.get-all', ['id' => Auth::id()]);
        }
    }

    public function acceptwithdocs(Request $request)
    {
        $bloodRequest = BloodRequest::findOrFail($request->id);

        // check if user have upload
        if ($request->blood_report != null) {
            $destination = 'public';
            // update file name
            $filename = time() . '.' . $request->blood_report->extension();
            // path
            $path = 'storage/' . $filename;
            // store
            $request->blood_report->storeAs($destination, $filename);
            $bloodRequest->blood_report = $path ?? null;
            $bloodRequest->donor_id = Auth::id();
            $bloodRequest->request_state = BloodRequest::REQ_ACCEPTED;
        }

        $bloodRequest->update();
        return redirect()->route('dashboard');
    }

    // In your controller
    public function openFile($filename)
    {
        $filePath = storage_path("app\public\\$filename");
        // Check if the file exists
        if (file_exists($filePath)) {
            // dd($filePath);
            // Open the file in a new window
            return response()->file($filePath, ['Content-Type' => 'image/jpeg, pdf']);
        } else {
            // File not found, handle accordingly (e.g., show an error message)
            abort(404, 'File not found');
        }
    }
}
