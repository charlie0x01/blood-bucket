<x-forms.patch :action="route('frontend.user.profile.update')">
    <div class="form-group row">
        <label for="name" class="col-md-3 col-form-label text-md-right">@lang('Name')</label>

        <div class="col-md-9">
            <input type="text" name="name" class="form-control" placeholder="{{ __('Name') }}" value="{{ old('name') ?? $logged_in_user->name }}" required autofocus autocomplete="name" />
        </div>
    </div><!--form-group-->

    @if ($logged_in_user->canChangeEmail())
    <div class="form-group row">
        <label for="email" class="col-md-3 col-form-label text-md-right">@lang('E-mail Address')</label>

        <div class="col-md-9">
            <x-utils.alert type="info" class="mb-3" :dismissable="false">
                <i class="fas fa-info-circle"></i> @lang('If you change your e-mail you will be logged out until you confirm your new e-mail address.')
            </x-utils.alert>

            <input type="email" name="email" id="email" class="form-control" placeholder="{{ __('E-mail Address') }}" value="{{ old('email') ?? $logged_in_user->email }}" required autocomplete="email" />
        </div>
    </div><!--form-group-->
    @endif

    <div class="row form-group">
        <label for="gender" class="col-md-3 col-form-label text-md-right">{{ __('Gender') }}</label>

        <div class="col-md-9">
            <select name="gender" class="form-control" aria-label="">
                @if ($logged_in_user->gender == 'male')
                <option>-- Select Gender --</option>
                <option selected value="male">Male</option>
                <option value="female">Female</option>
                @elseif ($logged_in_user->gender == 'female')
                <option selected>-- Select Gender --</option>
                <option value="male">Male</option>
                <option selected value="female">Female</option>
                @else
                <option selected>-- Select Gender --</option>
                <option value="male">Male</option>
                <option value="female">Female</option>
                @endif
            </select>
        </div>
    </div>
    <div class="row form-group">
        <label for="age" class="col-md-3 col-form-label text-md-right">{{ __('Age') }}</label>

        <div class="col-md-9">
            <input id="age" type="number" value="{{ $logged_in_user->age }}" placeholder="{{ $logged_in_user->age }}" min="18" max="60" class="form-control" name="age" required>
        </div>
    </div>

    <div class="row form-group">
        <label for="blood_group_id" class="col-md-3 col-form-label text-md-right">{{ __('Blood Type') }}</label>

        <div class="col-md-9">
            <select name="blood_group_id" class="form-control" aria-label="">
                @foreach($blood_groups as $blood_group)
                @if ($blood_group->id == $logged_in_user->blood_group_id)
                <option selected value="{{ $blood_group->id }}">{{ $blood_group->name }}</option>
                @else
                <option value="{{ $blood_group->id }}">{{ $blood_group->name }}</option>
                @endif
                @endforeach
            </select>
        </div>
    </div>

    <div class="row form-group">
        <label for="city_id" class="col-md-3 col-form-label text-md-right">{{ __('City') }}</label>

        <div class="col-md-9">
            <select name="city_id" class="form-control" aria-label="">
                <option selected>-- Select City --</option>
                @foreach($cities as $city)
                @if ($city->id == $logged_in_user->city_id)
                <option selected value="{{ $city->id }}">{{ $city->name }}</option>
                @else
                <option value="{{ $city->id }}">{{ $city->name }}</option>
                @endif
                @endforeach
            </select>
        </div>
    </div>

    <div class="row form-group">
        <label for="contact_no" class="col-md-3 col-form-label text-md-right">{{ __('Contact No.') }}</label>

        <div class="col-md-9">
            <input id="contact_no" value="{{ $logged_in_user->contact_no }}" type="number" class="form-control" name="contact_no" required placeholder="{{ $logged_in_user->contact_no }}">
        </div>
    </div>

    <div class="form-group row mb-0">
        <div class="col-md-12 text-right">
            <button class="btn btn-sm btn-primary float-right" type="submit">@lang('Update')</button>
        </div>
    </div><!--form-group-->
</x-forms.patch>