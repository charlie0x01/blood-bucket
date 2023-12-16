<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Accept Blood Request') }}
        </h2>
    </x-slot>

    <div class="p-8">
        <div class="max-w-7xl mx-auto space-y-4">
            <p class="text-xl font-semibold text-gray-800">Blood Request Info</p>
            <div class="">
                <p class="text-md font-semibold text-gray-800">Recipient Name: {{ $bloodRequest->recipient_name }}</p>
                <p class="text-md font-semibold text-gray-800">Blood Group: {{ $bloodGroup }}</p>
                <p class="text-md font-semibold text-gray-800">City: {{ $city }}</p>
                @if($bloodRequest->age != null)
                <p class="text-md font-semibold text-gray-800">Age: {{ $bloodRequest->age }}</p>
                @endif
                @if($bloodRequest->age != null)
                <p class="text-md font-semibold text-gray-800">Gender: {{ $bloodRequest->gender }}</p>
                @endif
                @if($bloodRequest->hospital_name != null)
                <p class="text-md font-semibold text-gray-800">Hospital Name: {{ $bloodRequest->hospital_name }}</p>
                @endif
            </div>

            <form enctype="multipart/form-data" action="{{ route('blood-request.acceptwithdocs', ['id' => $bloodRequest->id]) }}" method="POST" class="">
                @csrf
                @method('POST')
                <label class="block mb-2 text-md font-semibold text-gray-900 " for="blood_report">Upload file</label>
                <input accept="image/png, image/gif, image/jpeg" class="block w-[200px] text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none" id="blood_report" name="blood_report" type="file">
                <div class="mt-1 text-sm text-gray-500">Kindly attach your blood test report to confirm your blood group and prevent any potential medical complications</div>
                <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm focus:outline-none px-3 py-2 mt-2 ">Accept Request</button>
            </form>

        </div>
    </div>
</x-app-layout>