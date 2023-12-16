<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight mb-2">
                    {{ __('My Blood Requests') }}
                </h2>
                <p class="mb-2">These are all your created blood requests.</p>
            </div>
            @if(auth()->user()->id == 1)
            <a href="{{ route('blood-requests.admin.create') }}" class=" mb-8 bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-4 rounded">Create Blood Request</a>
            @else
            <a href="{{ route('blood-requests.create') }}" class=" mb-8 bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-4 rounded">Create Blood Request</a>
            @endif
        </div>
    </x-slot>
    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <section class="bg-gray-50 text-medium rounded-lg">
                <div class="flex justify-between items-center max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
                </div>
                @if(count($bloodRequests) == 0)
                <div class="mt-4 flex items-center justify-center p-16">
                    <p>you don't have any blood requests yet!</p>
                </div>
                @else
                <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-4 p-4">
                    <!-- <div class="flex gap-4 flex-wrap "> -->
                    @foreach($bloodRequests as $request)
                    <div class="bg-white border border-gray-200 rounded p-5 shadow-md min-w-[300px]">
                        <div class="flex items-center justify-between">
                            <h3 class="text-2xl font-semibold mb-2 cursor-pointer hover:underline">{{ $request->recipient_name }}</h3>
                            <div class="flex flex-col gap-2">
                                @if($request->emergency_flag == true)
                                <span class="bg-red-600 text-white text-xs font-medium mr-2 px-2.5 py-1 rounded">Emergency</span>
                                @endif
                                @if($request->request_state == 'approved')
                                <a href="{{ route('chat.with.donor', ['bid' => $request->id ]) }}" type="button" class="block w-full md:w-auto text-white bg-green-600 hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded text-sm px-2 py-1 text-center">Chat with Donor</a>
                                @endif
                            </div>
                        </div>
                        <div class="">
                            <p class="text-3xl font-extrabold text-red-600 mb-4">{{ $request->blood_group }}</p>
                            <div>
                                @if($request->age != null)
                                <p class="text-md font-semibold text-gray-600">{{ $request->age < 1 ? substr(strval($request->age), -1) : $request->age }} @if($request->age >= 1) Years @else Months @endif old, {{ ucfirst($request->gender) }}</p>
                                @endif
                                <p class="text-md font-semibold text-gray-600">{{ $request->contact_no }}</p>
                                @if($request->hospital_name != null)
                                <p class="text-xl text-gray-600">{{ $request->hospital_name."," }} {{ $request->city }}</p>
                                @else
                                <p class="text-xl text-gray-600">Blood Bucket, {{ $request->city }}</p>
                                @endif
                                @if($request->date)
                                <p class="text-sm font-semibold text-gray-600 mb-1">Date: {{ $request->date }}</p>
                                @endif

                                @if($request->request_state == 'accepted' || $request->request_state == 'approved' )
                                <p class="text-md font-semibold text-gray-600 mb-1">Donor: {{ $request->donor == 'Super Admin' ? 'Blood Bucket' : $request->donor }}</p>
                                @if($request->blood_report != null)
                                <a target="_blank" href="{{ route('open.file', ['filename' => basename($request->blood_report)]) }}" class="text-md font-semibold text-blue-800 mb-1 hover:underline">View Blood Report</a>
                                @endif
                                @endif
                            </div>
                        </div>
                        <div class="mt-4 flex justify-between items-center">
                            <div>
                                <div class="flex gap-2 items-center">
                                    <!-- request state -->
                                    @if($request->request_state == 'pending')
                                    <span class="bg-indigo-100 text-indigo-800 text-sm font-medium px-2.5 py-1 rounded ">Pending</span>
                                    @elseif($request->request_state == 'accepted')
                                    <span class="bg-blue-100 text-blue-800 text-sm font-medium px-2.5 py-1 rounded">Accepted by Donor</span>
                                    <a type="button" href="{{ route('blood-requests.iapprove', ['id' => $request->id]) }}" class="text-green-700 text-sm font-medium px-2.5 py-1 rounded ring-1 ring-green-700 hover:bg-green-700 hover:text-white">I Approve</a>
                                    @elseif($request->request_state == 'approved')
                                    <span class="bg-green-100 text-green-800 text-sm font-medium px-2.5 py-1 rounded">Approved</span>
                                    <a href="{{ route('blood-request.fulfill', ['id' => $request->id]) }}" type="button" class="block w-full md:w-auto text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded text-sm px-2 py-1 text-center">Blood Received</a>
                                    @elseif($request->request_state == 'fulfilled')
                                    <span class="bg-green-100 text-green-800 text-sm font-medium px-2.5 py-1 rounded">Fulfilled</span>
                                    @else
                                    <span class="bg-red-100 text-red-800 text-sm font-medium px-2.5 py-1 rounded">Rejected</span>
                                    @endif
                                </div>
                            </div>
                            <div class="flex justify-end gap-3 items-center">
                                @if($request->sender_id == auth()->user()->id && $request->request_state != 'fulfilled')
                                <a href="/blood-requests/{{$request->id}}/edit" class="text-gray-600 hover:text-blue-600"><i class="fas fa-edit"></i></a>
                                <a href="/blood-request/{{$request->id}}/delete" class="text-gray-600 hover:text-red-600"><i class="fa-solid fa-trash"></i></a>
                                @endif
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                @endif
            </section>
        </div>
    </div>
</x-app-layout>