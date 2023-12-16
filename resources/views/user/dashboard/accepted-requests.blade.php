<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight mb-2">
            {{ __('Blood Requests you accepeted') }}
        </h2>
        <p class="mb-2">All the blood requests you accepted, now waiting for admin's approval. </p>
    </x-slot>
    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <section class="bg-gray-50 text-medium rounded-lg">
                @if(count($bloodRequests) == 0)
                <div class="mt-4 flex items-center justify-center p-16">
                    <p>You did not accpeted any requests yet.</p>
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
                            <p class="text-3xl font-extrabold text-red-700 mb-4">{{ $request->blood_group }}</p>
                            <div>
                                @if($request->age != null)
                                <p class="text-sm font-semibold text-gray-600">{{ $request->age < 1 ? substr(strval($request->age), -1) : $request->age }} @if($request->age >= 1) Years @else Months @endif old, {{ ucfirst($request->gender) }}</p>
                                @endif
                                @if($request->hospital_name != null)
                                <p class="text-xl text-gray-600 mb-1">{{ $request->hospital_name."," }} {{ $request->city }}</p>
                                @else
                                <p class="text-xl text-gray-600">Blood Bucket, {{ $request->city }}</p>
                                @endif
                                @if($request->date)
                                <p class="text-sm text-gray-600 mb-1">Date: {{ $request->date }}</p>
                                @endif
                            </div>
                        </div>
                        <div class="mt-4 flex justify-between items-center">
                            @if($request->request_state == 'accepted')
                            <span class="bg-blue-100 text-blue-800 text-sm font-medium px-2.5 py-1 rounded">Need Recipient Approval</span>
                            <a type="button" href="{{ route('blood-request.decline', ['id' => $request->id]) }}" class="text-red-700 text-sm font-medium px-2.5 py-1 rounded ring-1 ring-red-700 hover:bg-red-700 hover:text-white">Decline</a>
                            @elseif($request->request_state == 'approved')
                            <span class="bg-green-100 text-green-800 text-sm font-medium px-2.5 py-1 rounded">Approved by Recipient</span>
                            @endif
                        </div>
                    </div>
                    @endforeach
                </div>
                @endif
            </section>
        </div>
    </div>
</x-app-layout>