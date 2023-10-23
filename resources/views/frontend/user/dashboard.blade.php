@extends('frontend.layouts.app')

@section('title', __('Dashboard'))

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <x-frontend.card>
                <x-slot name="header">
                    <h2>@lang(ucfirst($user->type).' Dashboard')</h2>
                </x-slot>

                <x-slot name="body">
                    <div class="d-flex flex-row-reverse">
                        <a href="/request-blood" role="button" class="btn btn-primary">I Need Blood</a>
                    </div>
                    @lang($user->name)
                </x-slot>
            </x-frontend.card>
        </div><!--col-md-10-->
    </div><!--row-->
</div><!--container-->
@endsection