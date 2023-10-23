<?php

namespace App\Http\Controllers\Frontend\User;

/**
 * Class DashboardController.
 */
class DashboardController
{
    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index(){

        return view('frontend.user.dashboard', ['user' => auth()->user()]);
    }

    public function requestBlood() {

        return view("frontend.pages.request-blood");
    }
}
