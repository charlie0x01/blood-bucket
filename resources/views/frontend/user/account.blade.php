@extends('frontend.layouts.app')

@section('title', __('My Account'))

@section('content')
@include('includes.partials.messages')
    <div class="container py-4">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <x-frontend.card>
                    <x-slot name="header">
                        @lang('My Account')
                    </x-slot>
                    
                    <x-slot name="body">
                        <div class="p-3">
                            <div class="m-3">
                                @include('frontend.user.account.tabs.information')
                            </div>
                            <div class="m-3">
                                <h5 class="mb-3">Update Password</h5>
                                @include('frontend.user.account.tabs.password')
                            </div>
                        </div>
                        <!-- <nav>
                            <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                    <x-utils.link
                                    :text="__('My Profile')"
                                    class="nav-link active"
                                    id="my-profile-tab"
                                    data-toggle="pill"
                                    href="#my-profile"
                                    role="tab"
                                    aria-controls="my-profile"
                                    aria-selected="true" />

                                <x-utils.link
                                    :text="__('Edit Information')"
                                    class="nav-link"
                                    id="information-tab"
                                    data-toggle="pill"
                                    href="#information"
                                    role="tab"
                                    aria-controls="information"
                                    aria-selected="false"/>

                                @if (! $logged_in_user->isSocial())
                                    <x-utils.link
                                        :text="__('Password')"
                                        class="nav-link"
                                        id="password-tab"
                                        data-toggle="pill"
                                        href="#password"
                                        role="tab"
                                        aria-controls="password"
                                        aria-selected="false" />
                                @endif

                                <x-utils.link
                                    :text="__('Two Factor Authentication')"
                                    class="nav-link"
                                    id="two-factor-authentication-tab"
                                    data-toggle="pill"
                                    href="#two-factor-authentication"
                                    role="tab"
                                    aria-controls="two-factor-authentication"
                                    aria-selected="false"/>
                            </div>
                        </nav> -->

                        <!-- <div class="tab-content" id="my-profile-tabsContent">
                            <!-- <div class="tab-pane fade pt-3 show active" id="my-profile" role="tabpanel" aria-labelledby="my-profile-tab">
                                @include('frontend.user.account.tabs.profile')
                            </div>

                            <div class="tab-pane fade pt-3" id="information" role="tabpanel" aria-labelledby="information-tab">
                            </div>

                            @if (! $logged_in_user->isSocial())
                                <div class="tab-pane fade pt-3" id="password" role="tabpanel" aria-labelledby="password-tab">
                                </div>
                            @endif

                            <div class="tab-pane fade pt-3" id="two-factor-authentication" role="tabpanel" aria-labelledby="two-factor-authentication-tab">
                                @include('frontend.user.account.tabs.two-factor-authentication')
                            </div>
                        </div> -->
                    </x-slot>
                </x-frontend.card>
            </div><!--col-md-10-->
        </div><!--row-->
    </div><!--container-->
@endsection
