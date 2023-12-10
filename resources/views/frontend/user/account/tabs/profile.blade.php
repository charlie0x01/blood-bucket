<div class="table-responsive">
    <table class="table table-striped table-hover table-bordered mb-0">
        
        <tr>
            <th>@lang('Avatar')</th>
            <td><img src="{{ $logged_in_user->avatar }}" class="user-profile-image" /></td>
        </tr>
        
        <tr>
            <th>@lang('User Type')</th>
            <td>{{ ucfirst($logged_in_user->type) }}</td>
        </tr>

        <tr>
            <th>@lang('Name')</th>
            <td>{{ $logged_in_user->name }}</td>
        </tr>

        <tr>
            <th>@lang('E-mail Address')</th>
            <td>{{ $logged_in_user->email }}</td>
        </tr>

        <tr>
            <th>@lang('Age')</th>
            <td>{{ $logged_in_user->age}}</td>
        </tr>

        <tr>
            <th>@lang('Gender')</th>
            <td>{{ $logged_in_user->gender }}</td>
        </tr>

        <tr>
            <th>@lang('Contact No.')</th>
            <td>{{ $logged_in_user->contact_no }}</td>
        </tr>
        <tr>
            <th>@lang('City')</th>
            @foreach($cities as $city)
            @if($city->id == $logged_in_user->city_id )
            <td>{{ $city->name }}</td>
            @endif
            @endforeach
        </tr>
        <tr>
            <th>@lang('Blood Group')</th>
            @foreach($blood_groups as $blood_group)
            @if($blood_group->id == $logged_in_user->blood_group_id )
            <td>{{ $blood_group->name }}</td>
            @endif
            @endforeach
        </tr>

    </table>
</div><!--table-responsive-->