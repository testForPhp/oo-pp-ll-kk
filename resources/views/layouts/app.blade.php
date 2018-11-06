<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ Cache::get('system')->website }}</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/css/bootstrap.min.css" integrity="sha256-eSi1q2PG6J7g7ib17yAaWMcrr5GrtohYChqibrV7PBE=" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@7.28.11/dist/sweetalert2.min.css" integrity="sha256-X27vANHzExvem97UJoop9ssWiExdnt99qxt0UhXiG3w=" crossorigin="anonymous">
    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}?v00022333" rel="stylesheet">
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-dark bg-primary navbar-laravel">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ Cache::get('system')->website }}
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">
                        <li class="nav-item @if(isset($homeMenu)) {{ $homeMenu }} @endif">
                            <a class="nav-link" href="/member/home">会员中心 <span class="sr-only">(current)</span></a>
                        </li>
                        <li class="nav-item @if(isset($linkMenu)) {{ $linkMenu }} @endif">
                            <a class="nav-link" href="/member/links">申请收录</a>
                        </li>
                        <li class="nav-item @if(isset($adsMenu)) {{ $adsMenu }} @endif">
                            <a class="nav-link" href="/member/ad">图片广告</a>
                        </li>
                        <li class="nav-item @if(isset($rechargeMenu)) {{ $rechargeMenu }} @endif">
                            <a class="nav-link" href="/member/recharge">充值</a>
                        </li>
                        <li class="nav-item @if(isset($linklogMenu)) {{ $linklogMenu }} @endif">
                            <a class="nav-link" href="/member/link/added/log">消费记录</a>
                        </li>
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>
                            <li class="nav-item">
                                @if (Route::has('register'))
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                @endif
                            </li>
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            @yield('content')
        </main>
    </div>
    <div class="loadmodal" style="display: none;">
        <div class="loading">
            <img src="https://ww1.sinaimg.cn/large/005YhI8igy1fwp81yvdtag30ia0dqdqa" style="width: 100%;height: 100%;" alt="">
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.3.1/dist/jquery.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/js/bootstrap.min.js" integrity="sha256-VsEqElsCHSGmnmHXGQzvoWjWwoznFSZc6hs7ARLRacQ=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@7.28.11/dist/sweetalert2.all.min.js" integrity="sha256-XrP9Q+1nFjuCit6icgPIvv/6unhVHzjTr9NrwTMZJyI=" crossorigin="anonymous"></script>
    <!-- Scripts -->
    <script src="{{ asset('js/public.js') }}?v.04543" defer></script>
    <script src="{{ asset('js/cline-min.js') }}?v.42342385675345" defer></script>
    @yield('script')
<script>
</script>
</body>
</html>