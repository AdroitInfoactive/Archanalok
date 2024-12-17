@extends('frontend.layouts.master')

@section('content')
    <!-- Hero Banner Start -->
    <section class="page_banner" style="background-image: url(assets/images/banner.jpg);">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <h3 class="pb_title">Contact us</h3>
                    <div class="page_crumb">
                        <a href="{{ url('/') }}">Home</a> | <span>Contact us</span>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Banner End -->

       <!-- Contact Start -->
       <section class="contact-setion">
        <div class="container">
            <div class="row">

                <div class="col-md-6 col-lg-4">
                    <div class="contact-box cb3">
                        <i class="nss-map-marker-alt1"></i>
                        <h5>Address</h5>
                        <p>{!! @$contact->address !!}</p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4">
                    <div class="contact-box">
                        <i class="nss-phone1"></i>
                        <h5>Phone</h5>
                        <p>{{ @$contact->phone_one }}</p>
                            <p>{{ @$contact->phone_two }}</p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4">
                    <div class="contact-box cb2">
                        <i class="nss-envelope-open1"></i>
                        <h5>Email</h5>
                        <p>{{ @$contact->mail_one }}</p>
                            <p>{{ @$contact->mail_two }}</p>
                    </div>
                </div>
               
            </div>
            <div class="row mt-60">
                <div class="col-md-6">
                    <div class="ci-info">
                        <div class="sub_title">Get In Touch</div>
                        <h2 class="sec_titles" style="margin-bottom: 40px;">We love to hear from you feel free to get in touch</h2>
                        <p class="sec_desc">
                            At our company, we prioritize your needs and aim to provide exceptional service tailored to your specific requirements. Here are a few reasons to reach out to us:
                        </p>
                        <ul>
                            <li><strong>Expert Guidance:</strong> Our team of industry professionals is ready to assist you with expert advice and solutions to meet your challenges.</li>
                            <li><strong>Customized Solutions:</strong> We understand that every project is unique. Contact us to discuss your needs, and we’ll create a personalized plan that works for you.</li>
                            <li><strong>Quality Assurance:</strong> We are committed to delivering high-quality products and services. Your satisfaction is our top priority.</li>
                           
                        </ul>
                        <p>
                            Don't hesitate to reach out—your next project deserves our attention and expertise!
                        </p>
                        
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="contact-form">
                        <form action="#" method="post" id="contact-form">
                            <input type="text" name="con_name" class="required" placeholder="Your Name">
                            <input type="email" name="con_email" class="required" placeholder="Your E-mail">
                            <input type="text" name="con_subject" placeholder="Subject">
                            <textarea name="con_message" class="required" placeholder="Your Message"></textarea>
                            <input type="submit" value="Send Message">
                            <img src="assets/images/ajax.gif" alt="ajax" class="fisto_loader"/>
                            <div class="fisto_con_message"></div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Contact End -->
<!-- Gamps Start -->
<div class="fishto-map ">
<iframe src="{{ @$contact->map_link }}"></iframe>
</div>
@endsection
