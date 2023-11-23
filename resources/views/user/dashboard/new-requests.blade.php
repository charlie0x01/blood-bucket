@extends('dashboard')
@section('tab')
<section class="p-6 bg-gray-50 text-medium rounded-lg">
    <h3 class="text-lg font-bold text-gray-900  mb-2">New Blood Request</h3>
    <p class="mb-2">All the blood requests from your city and matches your blood group. </p>
    @if(count($bloodRequests) == 0)
    <div class="mt-4 flex items-center justify-center p-16">
        <p>There are no requests that matches your city and blood group.</p>
    </div>
    @else
    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-4 p-4 mt-5">
        <!-- <div class="flex gap-4 flex-wrap "> -->
        @foreach($bloodRequests as $request)
        <div class="bg-white border border-gray-200 rounded p-5 shadow-md w-full">
            <div class="flex items-center justify-between">
                <h3 class="text-2xl font-semibold mb-2 cursor-pointer hover:underline">{{ $request->recipient_name }}</h3>
                @if($request->emergency_flag == true)
                <span class="bg-red-600 text-white text-xs font-medium mr-2 px-2.5 py-1 rounded">Emergency</span>
                @endif
            </div>
            <div class="">
                <p class="text-3xl font-extrabold text-red-600 mb-4">{{ $request->blood_group }}</p>
                <div>
                    <p class="text-sm font-semibold text-gray-600">{{ $request->age < 1 ? substr(strval($request->age), -1) : $request->age }}  @if($request->age >= 1) Years @else Months @endif old, {{ ucfirst($request->gender) }}</p>
                    <p class="text-xl text-gray-600 mb-1">{{ $request->hospital_name }}, {{ $request->city }}</p>
                </div>
            </div>
            <div class="mt-4 flex justify-between items-center">
                <span class="bg-indigo-100 text-indigo-800 text-sm font-medium px-2.5 py-1 rounded ">Pending</span>
                <div class="flex justify-end gap-3 items-center">
                    <a type="button" href="{{ route('blood-request.accept', ['id' => $request->id]) }}" class="text-green-800 text-sm font-medium px-2.5 py-1 rounded ring-1 ring-green-800 hover:bg-green-800 hover:text-white">Accept</a>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    @endif


</section>
@endsection