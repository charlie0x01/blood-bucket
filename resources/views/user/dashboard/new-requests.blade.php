<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight mb-2">
                    {{ __('New Blood Requests') }}
                </h2>
                @if(Auth::user()->type != 'admin')
                <p class="mb-2">All the blood requests from your city and matches your blood group. </p>
                <p class="-mt-3 text-sm font-semibold text-red-500">NOTE: You can make only 1 donation in 90 days.</p>
                @endif
            </div>
            @if(Auth::user()->type != 'admin')
            <div class="flex flex-col items-center justify-around">
                @if($days < 90)
                <p class="text-md font-semibold">Can Donate In</span></p>
                <p class="text-xl text-blue-600 font-semibold">{{ 90 - $days}} Days</p>
                @else
                <p class="text-md font-semibold text-green-600"><span class="text-xl">😇</span> You're good to go for donation</span></p>
                @endif
                <!-- <div class="min-w-[150px] bg-gray-200 rounded-full">
                    <div class="bg-blue-600 text-xs font-medium text-blue-100 text-center p-0.5 leading-none rounded-full" style="width: <?= (((90 - $days) * 90) / 100); ?>;"> {{ 90 - $days}} days</div>
                </div> -->
            </div>
            @endif
        </div>
    </x-slot>
    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <section class="bg-gray-50 text-medium rounded-lg">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
                    @if(count($bloodRequests) == 0)
                    <div class="mt-4 flex items-center justify-center p-16">
                        <p>There are no requests that matches your city and blood group.</p>
                    </div>
                    @else
                    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-4 p-4">
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
                                    @if($request->age != null)
                                    <p class="text-md font-semibold text-gray-600">{{ $request->age < 1 ? substr(strval($request->age), -1) : $request->age }} @if($request->age >= 1) Years @else Months @endif old, {{ ucfirst($request->gender) }}</p>
                                    @endif
                                    @if($request->hospital_name != null)
                                    <p class="text-xl text-gray-600">{{ $request->hospital_name."," }} {{ $request->city }}</p>
                                    @else
                                    <p class="text-xl text-gray-600">Blood Bucket, {{ $request->city }}</p>
                                    @endif
                                    @if($request->date)
                                    <p class="text-sm font-semibold text-gray-600 mb-1">Date: {{ $request->date }}</p>
                                    @endif
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
                </div>
            </section>
        </div>
    </div>
</x-app-layout>