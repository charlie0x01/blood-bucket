<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Blood Group') }}
        </h2>
        <p class="-mt-1 text-sm">city vise records</p>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">


            <div class="relative overflow-x-auto">
                <table class="w-full text-sm text-left rtl:text-right text-gray-500">
                    <thead class="text-sm font-semibold text-gray-700 uppercase bg-gray-200 ">
                        <tr>
                            <th scope="col" class="px-6 py-3">
                                Blood Group
                            </th>
                            <th scope="col" class="px-6 py-3">
                                City
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Units
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @if(count($bloodRecords) == 0)
                        <tr aria-rowspan="2" class="bg-white border-b ">
                            <td class="text-md p-5">no records found for this blood group.</td>
                        </tr>
                        @endif
                        @foreach($bloodRecords as $br)
                        <tr class="bg-white border-b ">
                            <td scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                {{ $br->blood_group}}
                            </td>
                            <td class="px-6 py-4">
                                {{ $br->city}}
                            </td>
                            <td class="px-6 py-4">
                                {{ $br->units}}
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

        </div>
    </div>

</x-app-layout>