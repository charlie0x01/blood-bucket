@extends('frontend.layouts.app')

@section('title', __('Dashboard'))

@section('content')
@include('includes.partials.messages')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <x-frontend.card>
                <x-slot name="header">
                    <h2>@lang(ucfirst($user->type).' Dashboard')</h2>
                </x-slot>

                <x-slot name="body">
                    <div class="d-flex flex-row-reverse">
                        <a href="/request-blood" role="button" class="btn btn-primary">Request Blood</a>
                    </div>
                    <div class="table-responsive">

                        <table class="table">
                            <h5 class="font-weight-bold">Blood Requests</h5>
                            <thead>
                                <tr>
                                    <th scope="col">Recipient Name</th>
                                    <th scope="col">Blood Group</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">City</th>
                                    <th scope="col">Contact No.</th>
                                    <th scope="col">Address</th>
                                    <th scope="col">Hospital Name</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($blood_requests as $br)
                                @if ($br->status != 'Received')
                                <tr>
                                    <th>{{ $br->recipient_name }}</th>
                                    <th>{{ $br->blood_group }}</th>
                                    <th class="text-primary">{{ ucfirst($br->status) }}</th>
                                    <th>{{ $br->city }}</th>
                                    <th>
                                        <a href="https://wa.me/{{ $br->contact_no }}" role="button" class="d-flex text-success">
                                            {{ $br->contact_no }}
                                            <img class="ml-1" src="http://localhost:8000/img/wa-icon.png" alt="whatsapp" width="20" height="20" />
                                        </a>
                                    </th>
                                    <th>{{ $br->address }}</th>
                                    <th>{{ $br->hospital_name }}</th>
                                    <th>
                                        <button class="btn btn-success btn-sm">Accept</button>
                                    </th>
                                </tr>
                                @endif
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-5 table-responsive">

                        <table class="table">
                            <h5 class="font-weight-bold">@lang(ucfirst($user->name).', Your Blood Request')</h5>
                            <thead>
                                <tr>
                                    <th scope="col">Recipient Name</th>
                                    <th scope="col">Blood Group</th>
                                    <th scope="col">Age</th>
                                    <th scope="col">Gender</th>
                                    <th scope="col">City</th>
                                    <th scope="col">Contact No.</th>
                                    <th scope="col">Address</th>
                                    <th scope="col">Hospital Name</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($user_blood_requests as $br)
                                <tr>
                                    <th>{{ ucfirst($br->recipient_name) }}</th>
                                    <th>{{ $br->blood_group }}</th>
                                    <th>{{ $br->age }}</th>
                                    <th>{{ ucfirst($br->gender) }}</th>
                                    <th>{{ $br->city }}</th>
                                    <th>
                                        <a href="https://wa.me/{{ $br->contact_no }}" role="button" class="d-flex text-success">
                                            {{ $br->contact_no }}
                                            <img class="ml-1" src="http://localhost:8000/img/wa-icon.png" alt="whatsapp" width="20" height="20" />
                                        </a>
                                    </th>
                                    <th>{{ $br->address }}</th>
                                    <th>{{ $br->hospital_name }}</th>
                                    <th class="d-flex flex-column">
                                        <a href="request-blood/{{ $br->id }}/edit" class="text-success text-sm">Edit</button>
                                        <a class="text-sm">Delete</button>
                                    </th>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </x-slot>
            </x-frontend.card>
        </div><!--col-md-10-->
    </div><!--row-->
</div><!--container-->
@endsection