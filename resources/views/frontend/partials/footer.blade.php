<!-- Start Footer Area -->
<footer class="footer" style="background-color: #1a1a2e;">
    <!-- Start Footer Top -->
    <div class="footer-top" style="padding: 60px 0 40px;">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 col-md-4 col-12">
                    <!-- Single Widget -->
                    <div class="single-footer f-about">
                        <div class="logo" style="margin-bottom: 20px;">
                            <a href="{{ route('home') }}" class="pmi-logo"
                                style="text-decoration: none; display: flex; align-items: center;">
                                <div class="logo-container" style="display: flex; align-items: center; gap: 15px;">
                                    <div class="logo-left" style="display: flex; align-items: center; gap: 12px;">
                                        <div class="pmi-icon"
                                            style="display: flex; align-items: center; justify-content: center;">
                                            <img src="{{ asset('assets/images/logo-pmi.jpeg') }}" alt="PMI Logo"
                                                style="margin-top:-10px; margin-bottom:-10px" width="100px"
                                                height="120px">
                                        </div>

                                    </div>
                                    <div class="logo-divider"
                                        style="width: 3px; height: 50px; background-color: #DC143C;"></div>
                                    <div class="logo-right"
                                        style="display: flex; flex-direction: column; line-height: 1.2;">
                                        <div class="text-line"
                                            style="color: #DC143C; font-size: 16px; font-weight: 600; margin: 0; padding: 0;">
                                            Kota</div>
                                        <div class="text-line"
                                            style="color: #DC143C; font-size: 16px; font-weight: 600; margin: 0; padding: 0;">
                                            Tangerang</div>
                                        <div class="text-line"
                                            style="color: rgba(255,255,255,0.8); font-style: italic; font-weight: 400; font-size: 14px; margin: 0; padding: 0;">
                                            Move For Humanity</div>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <p style="color: rgba(255,255,255,0.8); margin-bottom: 25px; line-height: 1.8;">Membantu sesama
                            melalui donasi untuk kemanusiaan. Bersama PMI, kita wujudkan kepedulian untuk mereka yang
                            membutuhkan.</p>
                        <ul class="social"
                            style="list-style: none; padding: 0; margin: 0 0 25px 0; display: flex; gap: 15px;">
                            <li><a href="javascript:void(0)"
                                    style="color: rgba(255,255,255,0.8); font-size: 20px; transition: color 0.3s;"
                                    onmouseover="this.style.color='#DC143C'"
                                    onmouseout="this.style.color='rgba(255,255,255,0.8)'"><i
                                        class="lni lni-facebook-filled"></i></a></li>
                            <li><a href="javascript:void(0)"
                                    style="color: rgba(255,255,255,0.8); font-size: 20px; transition: color 0.3s;"
                                    onmouseover="this.style.color='#DC143C'"
                                    onmouseout="this.style.color='rgba(255,255,255,0.8)'"><i
                                        class="lni lni-twitter-original"></i></a></li>
                            <li><a href="javascript:void(0)"
                                    style="color: rgba(255,255,255,0.8); font-size: 20px; transition: color 0.3s;"
                                    onmouseover="this.style.color='#DC143C'"
                                    onmouseout="this.style.color='rgba(255,255,255,0.8)'"><i
                                        class="lni lni-instagram"></i></a></li>
                            <li><a href="javascript:void(0)"
                                    style="color: rgba(255,255,255,0.8); font-size: 20px; transition: color 0.3s;"
                                    onmouseover="this.style.color='#DC143C'"
                                    onmouseout="this.style.color='rgba(255,255,255,0.8)'"><i
                                        class="lni lni-linkedin-original"></i></a></li>
                            <li><a href="javascript:void(0)"
                                    style="color: rgba(255,255,255,0.8); font-size: 20px; transition: color 0.3s;"
                                    onmouseover="this.style.color='#DC143C'"
                                    onmouseout="this.style.color='rgba(255,255,255,0.8)'"><i
                                        class="lni lni-youtube"></i></a></li>
                        </ul>
                        <p class="copyright-text" style="color: rgba(255,255,255,0.6); margin: 0; font-size: 14px;">©
                            {{ date('Y') }} Donasi PMI. All rights reserved.</p>
                    </div>
                    <!-- End Single Widget -->
                </div>
                <div class="col-lg-8 col-md-8 col-12">
                    <div class="row">
                        <div class="col-lg-3 col-md-6 col-12">
                            <!-- Single Widget -->
                            <div class="single-footer f-link">
                                <h3 style="color: #fff; font-size: 18px; font-weight: 600; margin-bottom: 25px;">Layanan
                                </h3>
                                <ul style="list-style: none; padding: 0; margin: 0;">
                                    <li style="margin-bottom: 12px;"><a href="#pricing"
                                            style="color: rgba(255,255,255,0.8); text-decoration: none; transition: color 0.3s; display: inline-block;"
                                            onmouseover="this.style.color='#DC143C'"
                                            onmouseout="this.style.color='rgba(255,255,255,0.8)'">Fitur</a></li>
                                    <li style="margin-bottom: 12px;"><a href="{{ route('donasi.create') }}"
                                            style="color: rgba(255,255,255,0.8); text-decoration: none; transition: color 0.3s; display: inline-block;"
                                            onmouseover="this.style.color='#DC143C'"
                                            onmouseout="this.style.color='rgba(255,255,255,0.8)'">Donasi</a></li>
                                    <li style="margin-bottom: 12px;"><a href="#about"
                                            style="color: rgba(255,255,255,0.8); text-decoration: none; transition: color 0.3s; display: inline-block;"
                                            onmouseover="this.style.color='#DC143C'"
                                            onmouseout="this.style.color='rgba(255,255,255,0.8)'">Tentang Kami</a></li>
                                    <li style="margin-bottom: 12px;"><a href="#contact"
                                            style="color: rgba(255,255,255,0.8); text-decoration: none; transition: color 0.3s; display: inline-block;"
                                            onmouseover="this.style.color='#DC143C'"
                                            onmouseout="this.style.color='rgba(255,255,255,0.8)'">Kontak</a></li>
                                </ul>
                            </div>
                            <!-- End Single Widget -->
                        </div>
                        <div class="col-lg-3 col-md-6 col-12">
                            <!-- Single Widget -->
                            <div class="single-footer f-link">
                                <h3 style="color: #fff; font-size: 18px; font-weight: 600; margin-bottom: 25px;">
                                    Bantuan</h3>
                                <ul style="list-style: none; padding: 0; margin: 0;">
                                    <li style="margin-bottom: 12px;"><a href="javascript:void(0)"
                                            style="color: rgba(255,255,255,0.8); text-decoration: none; transition: color 0.3s; display: inline-block;"
                                            onmouseover="this.style.color='#DC143C'"
                                            onmouseout="this.style.color='rgba(255,255,255,0.8)'">Cara Donasi</a></li>
                                    <li style="margin-bottom: 12px;"><a href="javascript:void(0)"
                                            style="color: rgba(255,255,255,0.8); text-decoration: none; transition: color 0.3s; display: inline-block;"
                                            onmouseover="this.style.color='#DC143C'"
                                            onmouseout="this.style.color='rgba(255,255,255,0.8)'">FAQ</a></li>
                                    <li style="margin-bottom: 12px;"><a href="javascript:void(0)"
                                            style="color: rgba(255,255,255,0.8); text-decoration: none; transition: color 0.3s; display: inline-block;"
                                            onmouseover="this.style.color='#DC143C'"
                                            onmouseout="this.style.color='rgba(255,255,255,0.8)'">Panduan</a></li>
                                    <li style="margin-bottom: 12px;"><a href="javascript:void(0)"
                                            style="color: rgba(255,255,255,0.8); text-decoration: none; transition: color 0.3s; display: inline-block;"
                                            onmouseover="this.style.color='#DC143C'"
                                            onmouseout="this.style.color='rgba(255,255,255,0.8)'">Kebijakan</a></li>
                                </ul>
                            </div>
                            <!-- End Single Widget -->
                        </div>
                        <div class="col-lg-3 col-md-6 col-12">
                            <!-- Single Widget -->
                            <div class="single-footer f-link">
                                <h3 style="color: #fff; font-size: 18px; font-weight: 600; margin-bottom: 25px;">
                                    Perusahaan</h3>
                                <ul style="list-style: none; padding: 0; margin: 0;">
                                    <li style="margin-bottom: 12px;"><a href="javascript:void(0)"
                                            style="color: rgba(255,255,255,0.8); text-decoration: none; transition: color 0.3s; display: inline-block;"
                                            onmouseover="this.style.color='#DC143C'"
                                            onmouseout="this.style.color='rgba(255,255,255,0.8)'">Tentang PMI</a></li>
                                    <li style="margin-bottom: 12px;"><a href="{{ route('frontend.berita') }}"
                                            style="color: rgba(255,255,255,0.8); text-decoration: none; transition: color 0.3s; display: inline-block;"
                                            onmouseover="this.style.color='#DC143C'"
                                            onmouseout="this.style.color='rgba(255,255,255,0.8)'">Berita</a></li>
                                    <li style="margin-bottom: 12px;"><a href="javascript:void(0)"
                                            style="color: rgba(255,255,255,0.8); text-decoration: none; transition: color 0.3s; display: inline-block;"
                                            onmouseover="this.style.color='#DC143C'"
                                            onmouseout="this.style.color='rgba(255,255,255,0.8)'">Karir</a></li>
                                    <li style="margin-bottom: 12px;"><a href="#contact"
                                            style="color: rgba(255,255,255,0.8); text-decoration: none; transition: color 0.3s; display: inline-block;"
                                            onmouseover="this.style.color='#DC143C'"
                                            onmouseout="this.style.color='rgba(255,255,255,0.8)'">Kontak</a></li>
                                </ul>
                            </div>
                            <!-- End Single Widget -->
                        </div>
                        <div class="col-lg-3 col-md-6 col-12">
                            <!-- Single Widget -->
                            <div class="single-footer f-link">
                                <h3 style="color: #fff; font-size: 18px; font-weight: 600; margin-bottom: 25px;">Legal
                                </h3>
                                <ul style="list-style: none; padding: 0; margin: 0;">
                                    <li style="margin-bottom: 12px;"><a href="javascript:void(0)"
                                            style="color: rgba(255,255,255,0.8); text-decoration: none; transition: color 0.3s; display: inline-block;"
                                            onmouseover="this.style.color='#DC143C'"
                                            onmouseout="this.style.color='rgba(255,255,255,0.8)'">Syarat &
                                            Ketentuan</a></li>
                                    <li style="margin-bottom: 12px;"><a href="javascript:void(0)"
                                            style="color: rgba(255,255,255,0.8); text-decoration: none; transition: color 0.3s; display: inline-block;"
                                            onmouseover="this.style.color='#DC143C'"
                                            onmouseout="this.style.color='rgba(255,255,255,0.8)'">Kebijakan Privasi</a>
                                    </li>
                                    <li style="margin-bottom: 12px;"><a href="javascript:void(0)"
                                            style="color: rgba(255,255,255,0.8); text-decoration: none; transition: color 0.3s; display: inline-block;"
                                            onmouseover="this.style.color='#DC143C'"
                                            onmouseout="this.style.color='rgba(255,255,255,0.8)'">Kebijakan Cookie</a>
                                    </li>
                                </ul>
                            </div>
                            <!-- End Single Widget -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--/ End Footer Top -->
</footer>
<!--/ End Footer Area -->
