<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="flex flex-wrap gap-5 max-w-9xl mt-6 mx-auto sm:px-6 justify-center lg:px-8">
        <div class="min-w-sm w-[300px] h-[350px] p-6 border border-gray-200 flex flex-col justify-between rounded-lg shadow bg-sky-600">
            <p class="font-semibold text-5xl text-gray-100 text-center mt-10">{{ $activeRequests }}</p>
            <div>
                <h5 class="text-2xl font-bold tracking-tight text-gray-100">Your Blood Requests</h5>
                <p class="-mt-1 text-sm text-gray-100">Active requests</p>
                <a href="{{ route('blood-requests.get-all', ['id' => auth()->user()->id])}}" class="inline-flex items-center text-white py-1.5 px-2 mt-2 rounded-lg hover:bg-sky-500 focus:ring-4 focus:outline-none focus:ring-blue-300">
                    <svg class="rtl:rotate-180 w-3.5 h-3.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 5h12m0 0L9 1m4 4L9 9" />
                    </svg>
                </a>
            </div>
        </div>
        <div class="min-w-sm w-[300px] h-[350px] p-6 border border-gray-200 rounded-lg shadow flex flex-col justify-between bg-green-600">
            <p class="font-semibold text-gray-100 text-5xl text-center mt-10">{{ $newRequests }}</p>
            <div>
                <h5 class="text-2xl font-bold tracking-tight text-gray-100">New Blood Requests</h5>
                <p class="-mt-1 text-sm text-gray-100">From all over the pakistan</p>
                <a href="{{ route('blood-requests.new', ['id' => auth()->user()->id])}}" class="inline-flex items-center max-w-[31px] text-white py-1.5 px-2 mt-2 rounded-lg hover:bg-green-500 focus:ring-4 focus:outline-none focus:ring-blue-300">
                    <svg class="rtl:rotate-180 w-3.5 h-3.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 5h12m0 0L9 1m4 4L9 9" />
                    </svg>
                </a>
            </div>
        </div>

        <div class="min-w-sm w-[300px] h-[350px] p-6 border border-gray-200 rounded-lg shadow flex flex-col justify-between bg-gray-900">
            <p class="font-semibold text-gray-100 text-5xl text-center mt-10">{{ $fulfilledRequest }}</p>
            <div>
                <h5 class="text-2xl font-bold tracking-tight text-gray-90 text-gray-100">Donations</h5>
                <p class="-mt-1 text-sm text-gray-100">Received</p>
                <a href="{{ route('blood-request.donations', ['id' => auth()->user()->id])}}" class="inline-flex items-center max-w-[31px] mt-2 text-white py-1.5 px-2 rounded-lg hover:bg-gray-700 focus:ring-4 focus:outline-none focus:ring-blue-300">
                    <svg class="rtl:rotate-180 w-3.5 h-3.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 5h12m0 0L9 1m4 4L9 9" />
                    </svg>
                </a>
            </div>
        </div>
        <div class="min-w-sm w-[300px] h-[350px] p-6 border border-gray-200 rounded-lg shadow flex flex-col justify-between bg-orange-600">
            <p class="font-semibold text-gray-100 text-5xl text-center mt-10">{{ $givenDonations }}</p>
            <div>
                <h5 class="text-2xl font-bold tracking-tight text-gray-100">Donations</h5>
                <p class="-mt-1 text-sm text-gray-100">Given</p>
                <a href="{{ route('blood-request.donations', ['id' => auth()->user()->id])}}" class="inline-flex items-center max-w-[31px] text-white py-1.5 px-2 mt-2 rounded-lg hover:bg-orange-400 focus:ring-4 focus:outline-none focus:ring-blue-300">
                    <svg class="rtl:rotate-180 w-3.5 h-3.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 5h12m0 0L9 1m4 4L9 9" />
                    </svg>
                </a>
            </div>
        </div>
    </div>

    <div class="flex flex-wrap gap-5 px-12 max-w-9xl mt-6 mx-auto sm:px-6 justify-center lg:px-8">
        <a href="{{ route('blood.records', ['bid' => 1])}}" class="w-[140px] bg-white px-4 py-3 flex items-center justify-between border border-gray-300 rounded-lg shadow-lg">
            <p class="text-[22px] font-extrabold text-red-700">A+</p>
            <p class="text-md font-bold">{{ $aPositive ?? 0}} <strong class="text-xs">unit</strong></p>
        </a>
        <a href="{{ route('blood.records', ['bid' => 2])}}" class="w-[140px] bg-white px-4 py-3 flex items-center justify-between border border-gray-300 rounded-lg shadow-lg">
            <p class="text-[22px] font-extrabold text-red-700">A-</p>
            <p class="text-md font-bold">{{ $aNegative ?? 0}} <strong class="text-xs">unit</strong></p>
        </a>
        <a href="{{ route('blood.records', ['bid' => 3])}}" class="w-[140px] bg-white px-4 py-3 flex items-center justify-between border border-gray-300 rounded-lg shadow-lg">
            <p class="text-[22px] font-extrabold text-red-700">B+</p>
            <p class="text-md font-bold">{{ $bPositive ?? 0}} <strong class="text-xs">unit</strong></p>
        </a>
        <a href="{{ route('blood.records', ['bid' => 4])}}" class="w-[140px] bg-white px-4 py-3 flex items-center justify-between border border-gray-300 rounded-lg shadow-lg">
            <p class="text-[22px] font-extrabold text-red-700">B-</p>
            <p class="text-md font-bold">{{ $bNegative ?? 0}} <strong class="text-xs">unit</strong></p>
        </a>
        <a href="{{ route('blood.records', ['bid' => 5])}}" class="w-[140px] bg-white px-4 py-3 flex items-center justify-between border border-gray-300 rounded-lg shadow-lg">
            <p class="text-[22px] font-extrabold text-red-700">AB+</p>
            <p class="text-md font-bold">{{ $aBPositive ?? 0}} <strong class="text-xs">unit</strong></p>
        </a>
        <a href="{{ route('blood.records', ['bid' => 6])}}" class="w-[140px] bg-white px-4 py-3 flex items-center justify-between border border-gray-300 rounded-lg shadow-lg">
            <p class="text-[22px] font-extrabold text-red-700">AB-</p>
            <p class="text-md font-bold">{{ $aBNegative ?? 0}} <strong class="text-xs">unit</strong></p>
        </a>
        <a href="{{ route('blood.records', ['bid' => 7])}}" class="w-[140px] bg-white px-4 py-3 flex items-center justify-between border border-gray-300 rounded-lg shadow-lg">
            <p class="text-[22px] font-extrabold text-red-700">O+</p>
            <p class="text-md font-bold">{{ $oPositive ?? 0}} <strong class="text-xs">unit</strong></p>
        </a>
        <a href="{{ route('blood.records', ['bid' => 8])}}" class="w-[140px] bg-white px-4 py-3 flex items-center justify-between border border-gray-300 rounded-lg shadow-lg">
            <p class="text-[22px] font-extrabold text-red-700">O-</p>
            <p class="text-md font-bold">{{ $oNegative ?? 0}} <strong class="text-xs">unit</strong></p>
        </a>
    </div>
</x-app-layout>