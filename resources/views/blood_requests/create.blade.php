<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create Blood Request') }}
        </h2>
    </x-slot>
    <div class="py-12 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <form 
        @if($update==1 ) action="{{ route('blood-requests.update', ['id' => $id]) }}" @endif 
        @if($update==0 ) action="{{ route('blood-requests.store') }}" @endif 
        method="post">
            @csrf
            @if($update == 1)
                @method('PUT')
            @endif
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="mb-4">
                    <label for="recipient_name" class="block text-gray-700 font-medium mb-2">Recipient Name</label>
                    <input value="{{ old('recipient_name', $recipient_name) }}" type="text" name="recipient_name" id="recipient_name" class="block w-full mt-1 rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"" required>
                <x-input-error :messages=" $errors->get('recipient_name')" class="mt-2" />
                </div>
                <div class="mb-4">
                    <label for="age" class="block text-gray-700 font-medium mb-2">Age (years)</label>
                    <input step="0.1" value="{{ old('age', $age) }}" min="0.1" type="number" name="age" id="age" class="block w-full mt-1 rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"" required>
                <x-input-error :messages=" $errors->get('age')" class="mt-2" />
                </div>
                <div class="mb-4">
                    <label for="gender" class="block text-gray-700 font-medium mb-2">Gender</label>
                    <select value="{{ old('gender', $gender) }}" name="gender" id="gender" class="block w-full mt-1 rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"" required>
                        <option>-- Select Gender --</option>
                        <option @if($gender == 'male') selected @endif value=" male">Male</option>
                        <option @if($gender=='female' ) selected @endif value="female">Female</option>
                    </select>
                    <x-input-error :messages="$errors->get('gender')" class="mt-2" />
                </div>
                <div class="mb-4">
                    <label for="contact_no" class="block text-gray-700 font-medium mb-2">Contact No.</label>
                    <input value="{{ old('contact_no', $contact_no) }}" type="text" name="contact_no" id="contact_no" class="block w-full mt-1 rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"" required>
                    <x-input-error :messages=" $errors->get('contact_no')" class="mt-2" />
                </div>
                <div class="mb-4">
                    <label for="blood_group_id" class="block text-gray-700 font-medium mb-2">Blood Group</label>
                    <select value="{{ old('blood_group_id', $blood_group_id) }}" name="blood_group_id" id="blood_group_id" class="block w-full mt-1 rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"" required>
                    <option>-- Select Blood Group --</option>
                    @foreach($bloodGroups as $bloodGroup)
                        @if($bloodGroup->id == $blood_group_id)
                        <option selected value=" {{ $bloodGroup->id }}">{{ $bloodGroup->name }}</option>
                        @else
                        <option value="{{ $bloodGroup->id }}">{{ $bloodGroup->name }}</option>
                        @endif
                        @endforeach
                    </select>
                    <x-input-error :messages="$errors->get('blood_group_id')" class="mt-2" />
                </div>
                <div class="mb-4">
                    <label for="city_id" class="block text-gray-700 font-medium mb-2">City</label>
                    <select value="{{ old('city_id', $city_id) }}" name="city_id" id="city_id" class="block w-full mt-1 rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"" required>
                        <option>-- Select City --</option>
                        @foreach($cities as $city)
                        @if($city->id == $city_id)
                        <option selected value=" {{ $city->id }}">{{ $city->name }}</option>
                        @else
                        <option value="{{ $city->id }}">{{ $city->name }}</option>
                        @endif
                        @endforeach
                    </select>
                    <x-input-error :messages="$errors->get('city_id')" class="mt-2" />
                </div>
                <div class="mb-4">
                    <label for="hospital_name" class="block text-gray-700 font-medium mb-2">Hospital Name</label>
                    <input value="{{ old('hospital_name', $hospital_name) }}" type="text" name="hospital_name" id="hospital_name" class="block w-full mt-1 rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"" required>
            <x-input-error :messages=" $errors->get('hospital_name')" class="mt-2" />
                </div>
                <div class="mb-4">
                    <label for="need_on" class="block text-gray-700 font-medium mb-2">Date (when you need blood)</label>
                    <input value="{{ old('need_on', $need_on) }}" onchange="toggleEmergency(event)" type="date" name="need_on" id="need_on" class="block w-full mt-1 rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"" required>
            <x-input-error :messages=" $errors->get('need_on')" class="mt-2" />
                </div>
                <div class="mb-4 col-span-2">
                    <label for="address" class="block text-gray-700 font-medium mb-2">Address</label>
                    <textarea value="{{ old('address', $address) }}" name="address" id="address" class="block w-full mt-1 rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"" rows=" 4"></textarea>
                    <x-input-error :messages="$errors->get('address')" class="mt-2" />
                </div>
                <div id="emergency-block" class="mb-4 flex gap-2 items-center">
                    <input 
                    @if($emergency_flag==1) checked @endif
                    value="{{ old('emergency_flag', $emergency_flag) }}" type="checkbox" name="emergency_flag" id="emergency_flag" class="h-5 w-5 text-blue-450 border-gray-300 rounded focus:ring-blue-200">
                    <label for="emergency_flag" class="block text-gray-700 font-medium">Emergency Request</label>
                </div>
            </div>
            <div class="mt-6">
                <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-4 rounded">
                    @if($update == 0) Submit Request @endif
                    @if($update == 1) Save Changes @endif
                </button>
            </div>
        </form>
    </div>
</x-app-layout>