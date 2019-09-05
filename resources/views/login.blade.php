@extends('layouts.app')
@section('content')

    <link rel="stylesheet" href="css/login_form_style.css">
    <link rel="stylesheet" href="css/main_page.css">
    <!-- Main Wrapper Start -->
    <div class="main-wrapper" style="margin-top: -6rem">

        <!-- Header-area start -->
        <header class="header header-sticky">
            <div class="header-area inner-header">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-4">
                        </div>
                        <div class="col-lg-8">
                        </div>
                        <div class="col">
                            <!-- mobile-menu start -->
                            <div class="mobile-menu d-block d-lg-none"></div>
                            <!-- mobile-menu end -->
                        </div>
                    </div>
                </div>
            </div>
        </header>
        <!-- Header-area end -->

        <!-- Hero Slider start -->
        <div class="hero-slider hero-slider-1">
            <div class="single-slide" style="background-image: url('images/slider/slide-bg-1.png')">
                <div class="home-decor">
                    <div class="home-overlay-img-1">
                        <img src="images/slider/seomar02.png" alt="">
                    </div>
                </div>
                <!-- Hero Content One Start -->
                <div class="hero-content-one container">
                    <div class="row align-items-center">
                        <div class="col-xl-5 col-lg-6 col-md-6 order-md-1 order-2">
                            <!-- login-form Start -->

                            <div class="login-form">
                                <div class="close"> </div>
                                <div class="head-info text-dark" style="font-size: 14px">
                                    <label class="lbl-1"></label>
                                    <label class="lbl-2"></label>
                                    <label class="lbl-3"></label>
                                </div>
                                <div class="clear"> </div>
                                <div class="avatar">
                                    <img src="images/avtar.png" />
                                </div>
                                <form method="POST" action="{{ route('login') }}">
                                    @csrf

                                    <input name="username" type="text" class="text @error('username') border-danger @enderror" value="{{ old('username', 'Username') }}" onfocus="if (this.value==='Username') this.value = '';" onblur="if (this.value === '') {this.value = 'Username';}">
                                    @error('username')
                                    <span class="invalid-feedback" role="alert" style="display: block">
                                        <strong>{{$message}}</strong>
                                    </span>
                                    @enderror
                                    <input name="password" class="@error('password') border-danger @enderror" type="password" value="Password" onfocus="if (this.value === 'Password') this.value = '';" onblur="if (this.value === '') {this.value = 'Password';}">
                                    @error('password')
                                    <span class="invalid-feedback" role="alert" style="display: block">
                                        <strong>{{$message}}</strong>
                                    </span>
                                    @enderror
                                    <div style="margin-bottom: 3em;"></div>
                                    <div class="signin">
                                        <input type="submit" value="Login">
                                    </div>
                                </form>
                            </div><!--// login-form End -->
                        </div>
                        <div class="col-xl-7 col-lg-6 col-md-6 order-md-2 order-1">
                            <!-- slider-inner-image Start -->
                            <div class="slider-inner-image">
                                <img src="images/slider/slide-inner-1.png" alt="">
                            </div><!--// slider-inner-image End -->
                        </div>
                    </div>
                </div>
                <!-- Hero Content One End -->
            </div>
        </div>
        <!-- Hero Slider end -->

    </div>
    <!-- Main Wrapper End -->
@endsection
