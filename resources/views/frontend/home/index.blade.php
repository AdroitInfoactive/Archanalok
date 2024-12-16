@extends('frontend.layouts.master')
@section('content')


<!-- Hero Banner Start -->
@include('frontend.home.components.banner')
<!-- Banner End -->
<!-- about Start -->
@include('frontend.home.components.about')
<!-- about End -->

<!-- counter Start -->
@include('frontend.home.components.counter')
<!-- counter End -->

@include('frontend.home.components.main-category')

<!-- testimonial Start -->
@include('frontend.home.components.testimonial')
<!-- testimonial End -->


<!-- social-media Start -->
@include('frontend.home.components.social-media')
<!-- social-media End -->



@endsection