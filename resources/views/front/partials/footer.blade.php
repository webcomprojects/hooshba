<footer>
    <div class="footer__area-four">
        <div class="container">
            <div class="footer__top-three footer__top-four">
                <div class="row">
                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6">

                        <div class="row">
                            <div class="col-xl-6 col-lg-6 col-md-6">
                                <div class="footer-widget">
                                    <div class="fw-logo mb-25">
                                        <a href=''><img src="{{ asset(option('info_logo')) }}" alt="logo"></a>
                                    </div>
                                    {{-- <div class="footer-info-list mb-25">
                                        <ul class="list-wrap">
                                            <li>
                                                <div class="icon">
                                                    <i class="flaticon-phone-call"></i>
                                                </div>
                                                <div class="content">
                                                    <a href="tel:0123456789">+123 888 9999</a>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="icon">
                                                    <i class="flaticon-envelope"></i>
                                                </div>
                                                <div class="content">
                                                    <a href="mailto:info@test.com">info@test.com</a>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="icon">
                                                    <i class="flaticon-pin"></i>
                                                </div>
                                                <div class="content">
                                                    <p>شیراز بلوار چمران کوچه 12</p>
                                                </div>
                                            </li>
                                        </ul>
                                    </div> --}}

                                </div>
                            </div>


                            <div class="col-xl-6 col-lg-6 col-md-6">

                                <p class="text-justify font-s-14p ">{!! option('info_footer_text') !!}</p>

                                <div class="footer__social-three">
                                    <ul class="list-wrap">
                                        @if (option('social_telegram'))
                                            <li><a href="{{ option('social_telegram') }}"><i
                                                        class="fab fa-telegram"></i></a></li>
                                        @endif

                                        @if (option('social_instagram'))
                                            <li><a href="{{ option('social_instagram') }}"><i
                                                        class="fab fa-instagram"></i></a></li>
                                        @endif

                                        @if (option('social_whatsapp'))
                                            <li><a href="{{ option('social_whatsapp') }}"><i
                                                        class="fab fa-whatsapp"></i></a></li>
                                        @endif

                                        @if (option('social_facebook'))
                                            <li><a href="{{ option('social_facebook') }}"><i
                                                        class="fab fa-facebook-f"></i></a></li>
                                        @endif

                                        @if (option('social_youtube'))
                                            <li><a href="{{ option('social_youtube') }}"><i
                                                        class="fab fa-youtube"></i></a></li>
                                        @endif

                                        @if (option('social_aparat'))
                                            <li><a href="{{ option('social_aparat') }}"><i class="fab fa-video"></i></a>
                                            </li>
                                        @endif




                                    </ul>
                                </div>

                            </div>


                        </div>



                    </div>

                    @php
                        $footerlink_groups = option('footerlink_groups', []);

                        if (is_array($footerlink_groups)) {
                            // اگر آرایه است، نیازی به json_decode نیست
                        } elseif (is_string($footerlink_groups)) {
                            $footerlink_groups = json_decode($footerlink_groups, true);
                        } else {
                            $footerlink_groups = []; // مقدار پیش‌فرض در صورت بروز خطا
                        }

                        $footerLinks1 = App\Models\FooterLink::where('link_group_id', 0)->get();
                        $footerLinks2 = App\Models\FooterLink::where('link_group_id', 1)->get();
                        $footerLinks3 = App\Models\FooterLink::where('link_group_id', 2)->get();

                    @endphp


                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6">
                        <div class="row">
                            @if ($footerlink_groups[0])
                                <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6">
                                    <div class="footer-widget">
                                        <h4 class="fw-title">{{ $footerlink_groups[0] }}</h4>
                                        <div class="footer-link-list">
                                            <ul class="list-wrap">
                                                @if (count($footerLinks1))
                                                    @foreach ($footerLinks1 as $footerLink1)
                                                        <li><a
                                                                href='{{ $footerLink1->link }}'>{{ $footerLink1->title }}</a>
                                                        </li>
                                                    @endforeach
                                                @endif

                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            @endif

                            @if ($footerlink_groups[1])
                                <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6">
                                    <div class="footer-widget">
                                        <h4 class="fw-title"> {{ $footerlink_groups[1] }}</h4>
                                        <div class="footer-link-list">
                                            <ul class="list-wrap">
                                                @if (count($footerLinks2))
                                                    @foreach ($footerLinks2 as $footerLink2)
                                                        <li><a
                                                                href='{{ $footerLink2->link }}'>{{ $footerLink2->title }}</a>
                                                        </li>
                                                    @endforeach
                                                @endif
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            @endif


                            @if ($footerlink_groups[2])
                                <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6">
                                    <div class="footer-widget">
                                        <h4 class="fw-title"> {{ $footerlink_groups[2] }}</h4>
                                        <div class="footer-link-list">
                                            <ul class="list-wrap">
                                                @if (count($footerLinks3))
                                                    @foreach ($footerLinks3 as $footerLink3)
                                                        <li><a
                                                                href='{{ $footerLink3->link }}'>{{ $footerLink3->title }}</a>
                                                        </li>
                                                    @endforeach
                                                @endif
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            @endif



                        </div>
                    </div>




                </div>
            </div>
            <div class="footer__bottom-four">
                <div class="container">
                    <div class="row align-items-center">

                        <div class="col-lg-12">
                            <div class="copyright-text text-center ">
                                <p class="color-white">
                                    کلیه حقوق مادی و معنوی این سایت متعلق به شورای تخصصی هوش مصنوعی ایران می‌باشد.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</footer>
