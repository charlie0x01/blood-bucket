<x-guest-layout>
    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>


        <div class="mt-4">
            <label for="type" class="block font-medium text-sm text-gray-700">User Type</label>
            <select onchange="setAgeLimit(event)" id="usertype" name="type" class="block w-full mt-1 rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                <option selected class="rounded-md border-gray-300 bg-white text-gray-900 focus:ring-blue-200 focus:border-blue-300">-- Select User Type --</option>
                <option value="donor" @if (old('type')=='donor' ) selected @endif class="rounded-md border-gray-300 bg-white text-gray-900 focus:ring-blue-200 focus:border-blue-300">Donor</option>
                <option value="recipient" @if (old('type')=='recipient' ) selected @endif class="rounded-md border-gray-300 bg-white text-gray-900 focus:ring-blue-200 focus:border-blue-300">Recipient</option>
                <x-input-error :messages="$errors->get('type')" class="mt-2" />
            </select>
        </div>

        <div class="mt-4">
            <x-input-label for="age" :value="__('Age')" />
            <x-text-input :min="1" id="age" class="block mt-1 w-full" type="number" name="age" :value="old('age')" required autocomplete="age" />
            <x-input-error :messages="$errors->get('age')" class="mt-2" />
        </div>

        <div class="mt-4">
            <label for="gender" class="block font-medium text-sm text-gray-700">{{ __('Gender') }}</label>

            <div class="col-md-6">
                <select name="gender" class="block w-full mt-1 rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50" aria-label="">
                    <option selected>-- Select Gender --</option>
                    <option @if (old('gender')=='male' ) selected @endif value="male">Male</option>
                    <option @if (old('gender')=='female' ) selected @endif value="female">Female</option>
                </select>
                <x-input-error :messages="$errors->get('gender')" class="mt-2" />
            </div>
        </div>

        <div class="mt-4">
            <label for="blood_group_id" class="block font-medium text-sm text-gray-700">{{ __('Blood Group') }}</label>

            <div class="col-md-6">
                <select name="blood_group_id" class="block w-full mt-1 rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50" aria-label="">
                    <option selected>-- Select Blood Group --</option>
                    @foreach($blood_groups as $blood_group)
                    <option value="{{ $blood_group->id }}">{{ $blood_group->name }}</option>
                    @endforeach
                </select>
                <x-input-error :messages="$errors->get('blood_group_id')" class="mt-2" />
            </div>
        </div>

        <div class="mt-4">
            <label for="city_id" class="block font-medium text-sm text-gray-700">{{ __('City') }}</label>

            <div class="col-md-6">
                <select name="city_id" class="block w-full mt-1 rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50" aria-label="">
                    <option selected>-- Select City --</option>
                    @foreach($cities as $city)
                    <option value="{{ $city->id }}">{{ $city->name }}</option>
                    @endforeach
                </select>
                <x-input-error :messages="$errors->get('city_id')" class="mt-2" />
            </div>
        </div>

        <div class="mt-4">
            <label for="contact_no" class="block font-medium text-sm text-gray-700">{{ __('Contact No.') }}</label>

            <div class="col-md-6">
                <input id="contact_no" value="{{ old('contact_no') }}" type="number" class="block w-full mt-1 rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50" name="contact_no" required>
                <x-input-error :messages="$errors->get('contact_no')" class="mt-2" />
            </div>
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />

            <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500" href="{{ route('login') }}">
                {{ __('Already registered?') }}
            </a>

            <x-primary-button class="ml-4">
                {{ __('Register') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>