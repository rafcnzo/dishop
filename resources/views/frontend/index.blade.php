@extends('frontend.dashboard')
@section('main')

    {{-- @include('frontend.home.home_slider') --}}
    <!--End hero slider-->

    {{-- @include('frontend.home.home_banner') --}}
    <!--End banners-->

    @include('frontend.home.home_new_product')
    <!--Products Tabs-->

    <!--Vendor List -->
    {{-- @include('frontend.home.home_vendor_list') --}}
    <!--End Vendor List -->

@endsection
