
<footer class="footer light-bg">
    <div class="container">
        <div class="row">
            <div class="col-lg-3 col-md-6 col-6">
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
            <div class="col-lg-2 col-md-6">
                <aside class="widget">
                    <h3 class="widget-title">Quick Links</h3>
                    <ul>
                        <li><a href="#">Home</a></li>
                        <li><a href="#">About Us</a></li>
                        <li><a href="#">Testimonials</a></li>
                        <li><a href="#">Contact Us</a></li>
                        {{-- <li><a href="index.html">Home</a></li>
                        <li><a href="about.html">About Us</a></li>
                        <li><a href="testimonials.html">Testimonials</a></li>
                        <li><a href="contact.html">Contact Us</a></li> --}}
                    </ul>
                </aside>
            </div>
            <div class="col-lg-3 col-md-6 col-6">
                <aside class="widget">
                    <h3 class="widget-title">Products</h3>
                    <ul>
                        <li><a href="#">Flooring</a></li>
                        <li><a href="#">Laminates</a></li>
                        <li><a href="cat-product-page.html">PVC Membrane</a></li>
                        <li><a href="#">Artificial leather Cloth</a></li>
                        <li><a href="#">Pre Laminated MDF Board</a></li>
                    </ul>
                </aside>
            </div>
            <div class="col-lg-3 col-md-6 col-6">
                <aside class="widget widget_mc4wp_form_widget">
                    <h3 class="widget-title">Subscribe</h3>
                    <form class="mc4wp-form" method="post">
                        <input type="email" name="EMAIL" placeholder="Email" required="">
                        <input type="submit" value="Subscribe">
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