
<footer class="footer light-bg">
    <div class="container">
        <div class="row">
            <div class="col-12 col-sm-6 col-md-3">
                <aside class="widget">
                    @if (@$footerInfo->short_info)
                    <h3 class="widget-title">{{ @$footerInfo->short_info }}</h3>
                    @endif
                    @if (@$footerInfo->address)
                    <p>
                        <i class="nss-map-marker-alt1 "></i>
                        {{ @$footerInfo->address }}
                    </p>
                    @endif
                    @if (@$footerInfo->phone)
                  
                    <p>
                        <i class="nss-phone1 flip-horizontal"></i>
                        {{-- <a href="+914024564223">+91 40 2456 4223</a> --}}
                        <a class="info" href="callto:{{ @$footerInfo->phone }}"> {{ @$footerInfo->phone }}</a>
                        <br>
                    </p>
                    @endif
                    @if (@$footerInfo->email)
                    <p>
                        <i class="nss-envelope-open1"></i>
                        <a href="mailto:{{ @$footerInfo->email }}">{{ @$footerInfo->email }}</a>
                    </p>
                    @endif
                </aside>
            </div>
            <div class="col-12 col-sm-6 col-md-2">
                <aside class="widget">
                    <h3 class="widget-title">Quick Links</h3>
                    <ul>
                        <li><a href="{{ url('/') }}">Home</a></li>
                        <li><a href="{{ route('about') }}">About Us</a></li>
                        <li><a href="{{ route('testimonials.index') }}">Testimonials</a></li>
                        <li><a href="{{ route('contact.index') }}">Contact Us</a></li>
                    </ul>
                </aside>
            </div>
            <div class="col-12 col-sm-6 col-md-2">
                <aside class="widget">
                    <h3 class="widget-title">Products</h3>
                    <ul>
                        @foreach ($categories as $category)
                        <li><a href="javascript:void(0);">{{ $category->category_name }}</a></li>
                    @endforeach
                    </ul>
                </aside>
            </div>
            <div class="col-12 col-sm-6 col-md-2">
                <aside class="widget">
                    <h3 class="widget-title">Policies</h3>
                    <ul>
                        <li><a href="{{ route('privacy-policy.index') }}">Privacy Policy</a></li>
                        <li><a href="{{ route('return-policy.index') }}">Return Policy</a></li>
                        <li><a href="{{ route('shipping-policy.index') }}">Shipping Policy</a></li>
                        <li><a href="{{ route('terms-and-conditions') }}">Terms and Conditions</a></li>   
                       
                    </ul>
                </aside>
            </div>
            <div class="col-12 col-sm-6 col-md-3">
                <aside class="widget widget_mc4wp_form_widget">
                    <h3 class="widget-title">Subscribe</h3>
                    <form class="mc4wp-form subscribe_form" method="post">
                        @csrf
                        <input type="email" name="email" placeholder="Email" >
                        <button type="submit" class="subscribe_btn">Subscribe</button>
                    </form>
                </aside>
                <p>Get the latest updates via email. Any time you may unsubscribe</p>
            </div>
        </div>
        <!-- Copryrgint Start -->
        <div class="row">
            <div class="col-lg-12">
                @if (@$footerInfo->copyright)
                <div class="copyright text-center">
                <p>{{ @$footerInfo->copyright }}</p>
                </div>
            @endif
                {{-- <div class="copyright text-center">
                    <p>© 2024 <a href="#">Archanalok. </a> All rights reserved. Developed by Adroit.</p>
                </div> --}}
            </div>
        </div>
        <!-- Copryrgint End -->
    </div>
</footer>

<div class="sbuttons">
    <a href="#" target="_blank" class="sbutton whatsapp" tooltip="WhatsApp"><i
            class="fab fa-whatsapp"></i></a>
    <a href="#" target="_blank" class="sbutton fb" tooltip="Facebook"><i
            class="fab fa-facebook-f"></i></a>
    <a href="#" target="_blank" class="sbutton twitt" tooltip="Twitter"><i
            class="fab fa-twitter"></i></a>
    <a href="#" target="_blank" class="sbutton pinteres" tooltip="Instagram"><i
            class="fab fa-instagram"></i></a>
    <a target="_blank" class="sbutton mainsbutton" tooltip="Share"><i class="fas fa-share-alt"></i></a>
</div>
@push('scripts')
    <script>
        $(document).ready(function(){
            $('.subscribe_form').on('submit', function(e) {
                e.preventDefault();
                let formData = $(this).serialize();
                $.ajax({
                    method: 'POST',
                    url: '{{ route("subscribe-newsletter") }}',
                    data: formData,
                    beforeSend: function(){
                        $('.subscribe_btn').attr('disabled', true);
                        $('.subscribe_btn').html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>');
                    },
                    success: function(response) {
                        $('.subscribe_form').trigger("reset");
                        $('.subscribe_btn').attr('disabled', false);
                        $('.subscribe_btn').html('Subscribe');
                        toastr.success(response.message);
                    },
                    error: function(xhr, status, error) {
                        let errors = xhr.responseJSON.errors;

                        $.each(errors, function(index, value){
                            toastr.error(value);
                        });

                        $('.subscribe_btn').attr('disabled', true);
                        $('.subscribe_btn').html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>');
                    },
                    complete: function(){
                        $('.subscribe_btn').attr('disabled', false);
                        $('.subscribe_btn').html('Subscribe');
                    }
                })
            })
        })
    </script>
    
@endpush
