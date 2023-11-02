@extends('frontend.layouts.app')

@section('title', __('Blood Request'))

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h4>@lang('Request Blood')</h4>
                </div>

                <div class="card-body">
                    <form action="/request-blood/send" method="POST">
                        @csrf
                        <div class="form-group row">
                            <label for="recipient_name" class="col-md-4 col-form-label text-md-right">@lang('Recipent Name')</label>

                            <div class="col-md-6">
                                <input type="text" name="recipient_name" id="recipient_name" class="form-control" value="{{ old('recipient_name') }}" placeholder="{{ __('Recipient Name') }}" maxlength="100" required autofocus />
                            </div>
                        </div><!--form-group-->

                        <div class="row mb-3">
                            <label for="gender" class="col-md-4 col-form-label text-md-right">{{ __('Gender') }}</label>

                            <div class="col-md-6">
                                <select name="gender" class="form-control" aria-label="">
                                    <option selected>-- Select Gender --</option>
                                    <option value="male">Male</option>
                                    <option value="female">Female</option>
                                </select>
                                @if($errors->has('gender'))
                                <span class="text-danger">You must select gender</span>
                                @endif
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="age" class="col-md-4 col-form-label text-md-right">{{ __('Age') }}</label>

                            <div class="col-md-6">
                                <input id="age" type="number" min="1" class="form-control" name="age" required value="{{ old('age') }}">
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="blood_group_id" class="col-md-4 col-form-label text-md-right">{{ __('Blood Group') }}</label>

                            <div class="col-md-6">
                                <select name="blood_group_id" class="form-control" aria-label="">
                                    <option selected>-- Select Blood Group --</option>
                                    @foreach($blood_groups as $blood_group)
                                    <option value="{{ $blood_group->id }}">{{ $blood_group->name }}</option>
                                    @endforeach
                                </select>
                                @if($errors->has('blood_group_id'))
                                <span class="text-danger">You must select blood group</span>
                                @endif
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="city_id" class="col-md-4 col-form-label text-md-right">{{ __('City') }}</label>

                            <div class="col-md-6">
                                <select name="city_id" class="form-control" aria-label="">
                                    <option selected>-- Select City --</option>
                                    @foreach($cities as $city)
                                    <option value="{{ $city->id }}">{{ $city->name }}</option>
                                    @endforeach
                                </select>
                                @if($errors->has('city_id'))
                                <span class="text-danger">You must select city</span>
                                @endif
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="contact_no" class="col-md-4 col-form-label text-md-right">{{ __('Contact No.') }}</label>

                            <div class="col-md-6">
                                <input id="contact_no" type="number" class="form-control" name="contact_no" required value="{{ old('contact_no') }}">
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="address" class="col-md-4 col-form-label text-md-right">{{ __('Address (where you need blood)') }}</label>

                            <div class="col-md-6">
                                <input id="address" type="text" class="form-control" name="address" required value="{{ old('address') }}">
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="hospital_name" class="col-md-4 col-form-label text-md-right">{{ __('Hospital Name (optional)') }}</label>

                            <div class="col-md-6">
                                <input id="hospital_name" type="text" class="form-control" name="hospital_name" value="{{ old('hospital_name') }}">
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button class="btn btn-primary" type="submit">@lang('Send Request')</button>
                            </div>
                        </div><!--form-group-->
                    </form>
                </div>
            </div>
        </div><!--col-md-8-->
    </div><!--row-->
</div><!--container-->
@endsection