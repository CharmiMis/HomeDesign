<footer>
    <div class="ft-outer">
        <div class="container">
            @if (request()->is('real-estate-ai') || request()->is('interior-designers-ai') || request()->is('architects-ai'))
                <div class="bussiness-outer">
                    <div class="competitive-inner">
                        <div class="competitive-inner-left"> <img src="{{ asset('web/images/bussiness-img.png') }}"
                                alt="real estate ai"> </div>
                        <div class="competitive-inner-right">
                            <h2 class="title-outer">Grow & Scale<br>
                                <span>Your Business</span>
                            </h2>
                            <h3 class="sub-title">Get Started with HomeDesignsAI Today </h3>
                            <p>Stand out in the competitive market with our AI-powered design tool. Enhance
                                interiors, exteriors or gardens, visualize home transformations, and attract more
                                potential customers. Show
                                them not just what is, but what could be. Start today!</p>
                            <a href="https://homedesigns.ai/#buy" class="get-started">Start Now</a>
                        </div>
                    </div>
                </div>
            @elseif(request()->is('landscapers-ai'))
                <div class="bussiness-outer">
                    <div class="competitive-inner">
                        <div class="competitive-inner-left"> <img src="{{ 'web/images/bussiness-img3.png' }}"
                                alt="homedesignsai generate"> </div>
                        <div class="competitive-inner-right">
                            <h2 class="title-outer">Grow & Scale<br>
                                <span>Your Business</span>
                            </h2>
                            <h3 class="sub-title">Get Started with HomeDesigns AI Today </h3>
                            <p>Stand out in the competitive market with our AI-powered design tool. Enhance
                                interiors, exteriors or gardens, visualize home transformations, and attract more
                                potential customers. Show
                                them not just what is, but what could be. Start today!</p>
                            <a href="https://homedesigns.ai/#buy" class="get-started">Start Now</a>
                        </div>
                    </div>
                </div>
            @else
                <div class="floating-banner">
                    <div class="floating-bannerinr">
                        <div class="row">
                            <div class="col-md-4 col-sm-6">
                                <div class="floating-bximg">
                                    <img src="{{ asset('web/images/ft.png') }}" alt="before and after homedesignsai"
                                        loading="lazy">
                                </div>
                            </div>
                            <div class="col-md-8 col-sm-6">
                                <div class="flootiing-cnt">
                                    <h6 style="font-size:19px;">Bring your home to life with AI</h6>
                                    <p style="color:#fff;font-size:15px;padding-top:10px;line-height:1.6em;">Use
                                        HomeDesignsAI to redesign any home in seconds: AI decoration, AI Interior
                                        Design, Exterior AI, Landscaping AI, House AI.</p>
                                    <a class="ft-floating-btn" href="https://homedesigns.ai/#buy">Start Now</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
        <div class="footer-main">
            <div class="container">
                <div class="ft-top">
                    <div class="row">
                        <div class="col-lg-4 col-md-12">
                            <div class="ft-bx">
                                <ul class="contact-list">
                                    <li>
                                        <a href="#">
                                            <img src=" {{ asset('web/images/footer-logo.png') }}" loading="lazy"
                                                alt="homedesignsai logo footer">
                                        </a>
                                    </li>
                                    <li>
                                        <p style="color:#fff;">The Future of Home Design.</p>
                                    </li>
                                    <!--<li><a href="#"><img src="images/contact.svg" alt="contact homedesignsai" loading="lazy">+1 234 456 678 89</a></li>-->
                                </ul>
                            </div>
                        </div>
                        <div class="col-lg-2 col-md-3 col-sm-6">
                            <div class="ft-bx">
                                <h6 class="footer-title">Menu</h6>
                                <ul class="ftmain-list">
                                    <li><a href="https://homedesigns.ai/">home</a></li>
                                    <li><a href="https://homedesigns.ai/go/blog">Blog</a></li>
                                    <li><a href="https://homedesigns.ai/#buy">Pricing Plans</a></li>
                                    <li><a href="https://homedesigns.ai/affiliate-program">Affiliate Program</a></li>
                                    <li><a href="https://homedesigns.ai/api">API</a></li>
                                    <li><a href="https://homedesigns.ai/sitemap.xml">Sitemap</a></li>
                                    <li><a href="https://homedesignsai.reamaze.com/chat-with-us/72053">Help Desk</a>
                                    </li>


                                </ul>
                            </div>
                        </div>
                        <div class="col-lg-2 col-md-3 col-sm-6">
                            <div class="ft-bx">
                                <h6 class="footer-title">Use cases:</h6>
                                <ul class="ftmain-list">
                                    <li><a href="{{ route('interiorDesigners.ai') }}">Interior Design AI</a></li>
                                    <li><a href="{{ route('architects.ai') }}">Exterior AI
                                        </a></li>
                                    <li><a href="{{ route('landscapers.ai') }}">Landscaping AI
                                        </a></li>
                                    <li><a href="{{ route('real.estate') }}">Real Estate AI</a></li>
                                    <li><a href="{{ route('decorStaging.ai') }}">Decor staging</a></li>
                                    <li><a href="{{ route('objectRemoval.ai') }}">AI Furniture Removal</a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-lg-2 col-md-3 col-sm-6">
                            <div class="ft-bx">
                                <h6 class="footer-title">Company</h6>
                                <ul class="ftmain-list">
                                    <li>
                                        <a href="{{ route('aboutUs.index') }}">About Us</a>
                                    </li>
                                    <li>
                                        <a href="{{ route('press.index') }}">Press</a>
                                    </li>
                                    <li>
                                        <a href="{{ route('invest.index') }}">Investors</a>
                                    </li>
                                    <li>
                                        <a href="{{ route('careers.index') }}">Careers</a>
                                    </li>
                                </ul>
                            </div>
                            <br>
                            <div class="ft-bx">
                                <h6 class="footer-title">legal</h6>
                                <ul class="ftmain-list">
                                    <li>
                                        <a href="{{ route('terms-of-service') }}">terms of service</a>
                                    </li>
                                    <li>
                                        <a href="{{ route('privacy-policy') }}">privacy policy</a>
                                    </li>
                                    <li>
                                        <a href="{{ route('refund-policy') }}">refund policy</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-lg-2 col-md-3 col-sm-6">
                            <div class="ft-bx">
                                <h6 class="footer-title">Connect with us</h6>
                                <ul class="social-list">
                                    <li>
                                        <a href="https://www.facebook.com/homedesignsai">
                                            <img src=" {{ asset('web/images/facebook.png') }}" width="15px"
                                                loading="lazy" alt="facebook homedesignsai">
                                        </a>
                                    </li>
                                    <li>
                                        <a href="https://www.twitter.com/homedesignsai">
                                            <img src=" {{ asset('web/images/twitter.png') }}" width="15px"
                                                loading="lazy" alt="twitter homedesigns ai">
                                        </a>
                                    </li>
                                    <li>
                                        <a href="https://www.youtube.com/@homedesignsaiapp">
                                            <img src=" {{ asset('web/images/youtube.png') }}" width="15px"
                                                loading="lazy" alt="youtube homedesigns ai">
                                        </a>
                                    </li>
                                    <li>
                                        <a href="https://www.tiktok.com/@homedesignsai">
                                            <img src=" {{ asset('web/images/tiktok.png') }}" width="15px"
                                                loading="lazy" alt="tiktok homedesigns ai">
                                        </a>
                                    </li>
                                    <li>
                                        <a href="https://www.instagram.com/homedesignsai/">
                                            <img src=" {{ asset('web/images/instagram.png') }}" width="15px"
                                                loading="lazy" alt="homedesignsai instagram">
                                        </a>
                                    </li>
                                    <li>
                                        <a href="https://pinterest.com/homedesignsai/">
                                            <img src=" {{ asset('web/images/pinterest.png') }}" width="15px"
                                                loading="lazy" alt="homedesignsai pinterest">
                                        </a>
                                    </li>
                                    <li>
                                        <a href="https://www.linkedin.com/company/home-designs-ai">
                                            <img src=" {{ asset('web/images/linkedin.png') }}" width="18px"
                                                loading="lazy" alt="homedesignsai pinterest">
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="ft-btm">
                    @if (request()->is('terms-of-service'))
                        <p>Copyright 2024 Future Tech Flow SRL. All Rights Reserved</p>
                    @else
                        <p>Copyright 2024 HomeDesignsAI. All Rights Reserved</p>
                    @endif
                </div>
            </div>
            <span class="big-ai">AI</span>
        </div>
    </div>
</footer>
