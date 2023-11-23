<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    
    <div class="py-8">
        <div class="max-w-8xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="md:flex">
                    <ul class="flex-column min-w-fit space-y space-y-4 text-sm font-medium text-gray-500 md:me-4 mb-4 md:mb-0">
                        <li>
                            <a onclick="activeTab(1)" id="tab" href="{{ route('blood-requests.get-all', ['id' => auth()->user()->id]) }}" class="inline-flex items-center justify-center px-4 py-3 rounded-lg hover:text-gray-900 bg-gray-50 hover:bg-gray-100 w-full">
                                My Blood Requests
                            </a>
                        </li>
                        <li>
                            <a onclick="activeTab(2)" id="tab" href="{{ route('blood-requests.new', ['id' => auth()->user()->id]) }}" class="inline-flex items-center justify-center px-4 py-3 rounded-lg hover:text-gray-900 bg-gray-50 hover:bg-gray-100 w-full ">
                                Other Blood Requests
                            </a>
                        </li>
                        @if(auth()->user()->type == 'admin')
                        <li>
                            <a onclick="activeTab(3)" id="tab" href="{{ route('blood-request.need.approval') }}" class="inline-flex items-center justify-center px-4 py-3 rounded-lg hover:text-gray-900 bg-gray-50 hover:bg-gray-100 w-full ">
                                Need Your Approval
                            </a>
                        </li>
                        <li>
                            <a onclick="activeTab(4)" id="tab" href="{{ route('blood-requests.approved') }}" class="inline-flex items-center justify-center px-4 py-3 rounded-lg hover:text-gray-900 bg-gray-50 hover:bg-gray-100 w-full ">
                                Approved Requests
                            </a>
                        </li>
                        <li>
                            <a onclick="activeTab(5)" id="tab" href="{{ route('blood-request.donations', ['id' => auth()->user()->id]) }}" class="inline-flex items-center justify-center px-4 py-3 rounded-lg hover:text-gray-900 bg-gray-50 hover:bg-gray-100 w-full ">
                                Donations
                            </a>
                        </li>
                        @else
                        <li>
                            <a onclick="activeTab(6)" id="tab" href="{{ route('blood-requests.accepted', ['id' => auth()->user()->id]) }}" class="inline-flex items-center justify-center px-4 py-3 rounded-lg hover:text-gray-900 bg-gray-50 hover:bg-gray-100 w-full ">
                               Requests You Accepted
                            </a>
                        </li>
                        <li>
                            <a onclick="activeTab(7)" id="tab" href="{{ route('blood-request.donations', ['id' => auth()->user()->id]) }}" class="inline-flex items-center justify-center px-4 py-3 rounded-lg hover:text-gray-900 bg-gray-50 hover:bg-gray-100 w-full ">
                                History
                            </a>
                        </li>
                        @endif
                    </ul>
                    <div class="w-full">
                        @yield("tab")
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('components.model-box')
</x-app-layout>