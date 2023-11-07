<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Profile Information') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __("Update your account's profile information and email address.") }}
        </p>
    </header>


    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>
    <form id="remove-avatar" method="post" action="{{ route('profile.remove.avatar') }}">
        @csrf
    </form>

    <form method="post" enctype="multipart/form-data" action="{{ route('profile.update') }}" class=" gap-4 mt-6 flex flex-col w-full">
        @csrf
        @method('PATCH')

        <div class="flex gap-4">
            <div class="w-40 h-40 flex items-center justify-center rounded-full">
                <img id="preview" src="{{ $user->avatar }}" alt="User Avatar" class="w-full h-full object-cover rounded-full" />
            </div>
            <div class="flex flex-col w-[100px] gap-4">
                <input id="avatar" onchange="loadImage(event)" name="avatar" type="file" accept="image/*" />
                <button form="remove-avatar" onclick="removeImage(event)" class="bg-red-500 hover:bg-red-600 text-white font-semibold py-2 px-4 rounded">
                    Remove
                </button>

            </div>
        </div>

        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $user->name)" required autocomplete="name" />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $user->email)" required autocomplete="username" />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
            <div>
                <p class="text-sm mt-2 text-gray-800">
                    {{ __('Your email address is unverified.') }}

                    <button form="send-verification" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        {{ __('Click here to re-send the verification email.') }}
                    </button>
                </p>

                @if (session('status') === 'verification-link-sent')
                <p class="mt-2 font-medium text-sm text-green-600">
                    {{ __('A new verification link has been sent to your email address.') }}
                </p>
                @endif
            </div>
            @endif
        </div>

        <div class="mt-4">
            <label for="type" class="block font-medium text-sm text-gray-700">User Type</label>
            <div class="bg-blue-100 border-blue-500 text-blue-700 my-1 px-4 py-3 rounded relative" role="alert">
                <strong class="font-bold">Info</strong>
                <span class="block sm:inline">if you change your user type to Donor, you'll be logout unitl you verify your email.</span>
            </div>

            <select id="type" name="type" class="block w-full mt-1 rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                <option selected class="rounded-md border-gray-300 bg-white text-gray-900 focus:ring-indigo-200 focus:border-indigo-300">-- Select User Type --</option>
                @if($user->type == 'donor')
                <option value="donor" selected="rounded-md border-gray-300 bg-white text-gray-900 focus:ring-indigo-200 focus:border-indigo-300">Donor</option>
                <option value="recipient" class="rounded-md border-gray-300 bg-white text-gray-900 focus:ring-indigo-200 focus:border-indigo-300">Recipient</option>
                @elseif($user->type == 'recipient')
                <option value="donor" class="rounded-md border-gray-300 bg-white text-gray-900 focus:ring-indigo-200 focus:border-indigo-300">Donor</option>
                <option value="recipient" selected class="rounded-md border-gray-300 bg-white text-gray-900 focus:ring-indigo-200 focus:border-indigo-300">Recipient</option>
                @endif
                <x-input-error :messages="$errors->get('type')" class="mt-2" />
            </select>
        </div>

        <div class="mt-4">
            <x-input-label for="age" :value="__('Age')" />
            <x-text-input id="age" class="block mt-1 w-full" type="number" name="age" :value="old('age', $user->age)" required autocomplete="age" />
            <x-input-error :messages="$errors->get('age')" class="mt-2" />
        </div>

        <div class="mt-4">
            <label for="gender" class="block font-medium text-sm text-gray-700">{{ __('Gender') }}</label>

            <div class="col-md-6">
                <select name="gender" class="block w-full mt-1 rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" aria-label="">
                    <option selected>-- Select Gender --</option>
                    @if($user->gender == 'male')
                    <option selected value="male">Male</option>
                    <option value="female">Female</option>
                    @else
                    <option value="male">Male</option>
                    <option selected value="female">Female</option>
                    @endif
                </select>
                <x-input-error :messages="$errors->get('gender')" class="mt-2" />
            </div>
        </div>

        <div class="mt-4">
            <label for="blood_group_id" class="block font-medium text-sm text-gray-700">{{ __('Blood Group') }}</label>

            <div class="col-md-6">
                <select name="blood_group_id" class="block w-full mt-1 rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" aria-label="">
                    <option selected>-- Select Blood Group --</option>
                    @foreach($blood_groups as $blood_group)
                    @if($user->blood_group_id == $blood_group->id)
                    <option selected value="{{ $blood_group->id }}">{{ $blood_group->name }}</option>
                    @else
                    <option value="{{ $blood_group->id }}">{{ $blood_group->name }}</option>
                    @endif
                    @endforeach
                </select>
                <x-input-error :messages="$errors->get('blood_group_id')" class="mt-2" />
            </div>
        </div>

        <div class="mt-4">
            <label for="city_id" class="block font-medium text-sm text-gray-700">{{ __('City') }}</label>

            <div class="col-md-6">
                <select name="city_id" class="block w-full mt-1 rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" aria-label="">
                    <option selected>-- Select City --</option>
                    @foreach($cities as $city)
                    @if($user->city_id == $city->id)
                    <option selected value="{{ $city->id }}">{{ $city->name }}</option>
                    @else
                    <option value="{{ $city->id }}">{{ $city->name }}</option>
                    @endif
                    @endforeach
                </select>
                <x-input-error :messages="$errors->get('city_id')" class="mt-2" />
            </div>
        </div>

        <div class="mt-4">
            <label for="contact_no" class="block font-medium text-sm text-gray-700">{{ __('Contact No.') }}</label>

            <div class="col-md-6">
                <input name="contact_no" id="contact_no" value="{{ old('contact_no', $user->contact_no) }}" type="number" class="block w-full mt-1 rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required>
                <x-input-error :messages="$errors->get('contact_no')" class="mt-2" />
            </div>
        </div>



        <!-- update button -->
        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Update') }}</x-primary-button>

            @if (session('status') === 'profile-updated')
            <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)" class="text-sm text-gray-600">{{ __('Saved.') }}</p>
            @endif
        </div>
    </form>
</section>