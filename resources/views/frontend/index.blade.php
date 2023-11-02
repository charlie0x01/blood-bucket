<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ appName() }}</title>
    <meta name="description" content="@yield('meta_description', appName())">
    <meta name="author" content="@yield('meta_author', 'Anthony Rappa')">
    @yield('meta')

    @stack('before-styles')
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
    <link href="{{ mix('css/frontend.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        html,
        body {
            background-color: #fff;
            color: #636b6f;
            font-family: 'Nunito', sans-serif;
            font-weight: 200;
            height: 100vh;
            margin: 0;
        }

        .full-height {
            height: 100vh;
        }

        .flex-center {
            align-items: center;
            display: flex;
            justify-content: center;
        }

        .position-ref {
            position: relative;
        }

        .top-right {
            position: absolute;
            right: 10px;
            top: 18px;
        }

        .content {
            text-align: center;
        }

        .title {
            font-size: 84px;
        }

        .links>a {
            color: #636b6f;
            padding: 0 25px;
            font-size: 13px;
            font-weight: 600;
            letter-spacing: .1rem;
            text-decoration: none;
            text-transform: uppercase;
        }

        .m-b-md {
            margin-bottom: 30px;
        }
    </style>
    @stack('after-styles')
</head>

<body>
    <!-- @include('includes.partials.read-only')
        @include('includes.partials.logged-in-as') -->
    <!-- @include('includes.partials.announcements') -->

    <!-- Navigation Bar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-danger">
        <div class="container">
            <a class="navbar-brand" href="#">Blood Donation</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ml-auto">
                    @auth
                    @if ($logged_in_user->isDonor() || $logged_in_user->isUser() || $logged_in_user->isRecipient())
                    <li class="nav-item active">
                        <a class="nav-link" href="{{ route('frontend.user.dashboard') }}">@lang('Back to Dashboard')</a>
                    </li>
                    @else
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('frontend.auth.login') }}">@lang('Login')</a>
                    </li>
                    @endif
                    @endauth
                </ul>
            </div>
        </div>
    </nav>

    <div class="jumbotron">
        <div class="container">
            <h1 class="display-4">Blood Bucket</h1>
            <p class="lead">In a world filled with compassion, unity, and the desire to make a positive impact, our Blood Donation System stands as a beacon of hope. It's a place where ordinary individuals come together to perform an extraordinary act — saving lives through the gift of blood.</p>
            <p class="lead">Our mission is clear: to bridge the gap between those in need and the selfless heroes who generously donate their life-saving blood. This platform is where generosity and humanity intertwine, where you'll find information about the significance of blood donation, the stories of courageous donors, and the opportunity to become a part of a lifesaving community.</p>
            <p class="lead">With every drop of blood you share, you're not only donating a part of yourself but also the promise of health and hope for those in dire need. We invite you to explore the profound impact of your kindness and join us as we create a world that's healthier, safer, and filled with compassion.</p>
            <hr class="my-4">
            <p>Join us in making a difference, one life at a time. This is the Blood Donation System: Lifesaving Connections. Your journey as a donor, advocate, or supporter starts here. Together, we can save lives and bring brighter tomorrows to those in need.</p>
            <div class="">
                <a role="button" class="btn bg-danger text-white" href="{{ route('frontend.auth.login') }}">@lang('Login')</a>
                @if (config('boilerplate.access.user.registration'))
                <a role="button" class="btn bg-danger text-white" href="{{ route('frontend.auth.register') }}">@lang('Donate Now!')</a>
                @endif
                @if (config('boilerplate.access.user.registration'))
                <a role="button" class="btn bg-danger text-white" href="{{ route('frontend.auth.register') }}">@lang('Need Blood? Join Now')</a>
                @endif
            </div>
        </div>
    </div>

    @stack('before-scripts')
    <script src="{{ mix('js/manifest.js') }}"></script>
    <script src="{{ mix('js/vendor.js') }}"></script>
    <script src="{{ mix('js/frontend.js') }}"></script>
    @stack('after-scripts')
</body>

</html>