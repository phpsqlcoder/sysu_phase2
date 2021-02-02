<header class="page-head">
    <nav class="rd-navbar rd-navbar-original">
        <!-- RD Navbar Upper Panel -->
        <div class="rd-navbar-upper-panel">
            @if(Setting::info()->promo_is_displayed > 0 && Setting::info()->min_order > 0)
                <p class="rd-navbar-verbiage">Avail our FREE DELIVERY for a minimum purchase of ₱{{Setting::getFaviconLogo()->min_order}} only</p>
            @else
                <p class="rd-navbar-verbiage">&nbsp;</p>
            @endif
            <div class="rd-navbar-top-panel__left d-block d-lg-none mt-2">
                <ul class="rd-navbar-items-list e-options">
                    <li>
                        <!-- <a href="{{route('cart.front.show')}}"><i class="fa fa-shopping-cart"></i> <span>Shopping Cart</span></a> -->
                        <a href="{{route('cart.front.show')}}"><i class="fa fa-shopping-cart"></i><small class="counter">{!! Setting::EcommerceCartTotalItems() !!}</small></a>
                    </li>
                    @if(auth()->check())
                    <li><a  href="{{route('profile.sales')}}"><i class="fa fa-user"></i> <span>My Account</span></a></li>
                        <li><a  href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i class="fa fa-sign-out-alt"></i> <span>Log Out</span></a></li>
                        <form id="logout-form" action="{{ route('account.logout') }}" method="get" style="display: none;">
                            @csrf
                        </form>
                    @else
                        <li><a  href="{{route('customer-front.sign-up')}}" ><i class="fa fa-user-plus"></i> <span>Register</span></a></li>
                        <li><a  href="{{route('customer-front.login')}}" ><i class="fa fa-sign-in-alt"></i> <span>Log In</span></a></li>

                    @endif
                </ul>
            </div>

            <!-- <div class="rd-navbar-upper-panel__right d-none">
                <div class="rd-navbar-top-panel">
                    <div class="rd-navbar-top-panel__main toggle-original-elements">
                        <div class="rd-navbar-top-panel__toggle rd-navbar-fixed__element-1 rd-navbar-static--hidden toggle-original"
                        data-rd-navbar-toggle=".rd-navbar-top-panel__main"><span></span>
                        </div>
                        <div class="rd-navbar-top-panel__content">
                            <div class="rd-navbar-top-panel__left">
                                <ul class="rd-navbar-items-list text-right" style="width:400px;" >
                                    <li>
                                        <a href="{{route('cart.front.show')}}"><i class="fa fa-shopping-cart"></i> <span>Shopping Cart</span></a>
                                    </li>
                                    @if(auth()->check())
                                    <li><a  href="{{route('profile.sales')}}"><i class="fa fa-user"></i> <span>My Account</span></a></li>
                                        <li><a  href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i class="fa fa-user"></i> <span>Log Out</span></a></li>
                                        <form id="logout-form" action="{{ route('account.logout') }}" method="get" style="display: none;">
                                            @csrf
                                        </form>
                                    @else
                                         <li><a  href="{{route('customer-front.sign-up')}}" ><i class="fa fa-user-plus"></i> <span>Register</span></a></li>
                                        <li><a  href="{{route('customer-front.login')}}" ><i class="fa fa-user"></i> <span>Log In</span></a></li>
                                    @endif
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div> -->
        </div>       
        <!-- END RD Navbar Upper Panel -->

        <div class="rd-navbar-inner rd-navbar-static--hidden">
            <div class="rd-navbar-fixed__element-4">
                <button class="rd-navbar-n-search__toggle rd-navbar-n-search__toggle_additional"
                    data-rd-navbar-toggle=".rd-navbar-n-search-wrap">
                </button>
            </div>
            <div class="rd-navbar-panel rd-navbar-n-search-wrap">
                <div class="rd-navbar-n-search rd-navbar-n-search_not-collapsable">
                    <form class="rd-n-search" action="{{route('product.front.list')}}" method="GET" data-search-live="rd-search-results-live">
                        @csrf
                        <input type="hidden" name="search" value="on">
                        <div class="form-wrap">
                            <input class="form-input" id="rd-navbar-n-search-form-input" type="text" name="searchtxt" autocomplete="off">
                            <label class="form-label rd-input-label" for="rd-navbar-n-search-form-input">Enter keyword</label>
                            <div class="rd-n-search-results-live" id="rd-n-search-results-live"></div>
                        </div>
                        <button class="rd-n-search__submit" type="submit"></button>
                    </form>
                </div>
            </div>
        </div>

        <div class="rd-navbar-inner rd-navbar-fixed--hidden">
            <div class="rd-navbar-search-wrap">
                <div class="rd-navbar-search rd-navbar-search_not-collapsable">
                    <div class="container">
                        <div class="row no-gutters">
                            <div class="col-lg-12">
                                <form class="rd-search" action="{{route('product.front.list')}}" method="GET" data-search-live="rd-search-results-live">
                                    @csrf
                                    <input type="hidden" name="search" value="on">
                                    <div class="form-wrap">
                                        <input class="form-input" id="rd-navbar-search-form-input" type="text" name="searchtxt" autocomplete="off">
                                        <label class="form-label rd-input-label" for="rd-navbar-search-form-input">Enter keyword</label>
                                        <div class="rd-search-results-live" id="rd-search-results-live"></div>
                                    </div>
                                    <button class="rd-search__submit" type="submit"></button>
                                </form>
                            </div>
                        </div>
                        <button class="rd-navbar-close-search__toggle" data-custom-toggle=".rd-navbar-search-wrap"
                        data-custom-toggle-disable-on-blur="true"></button>
                    </div>
                </div>
            </div>
        </div>

        <div class="rd-navbar-inner">
            <!-- RD Navbar Panel -->
            <div class="rd-navbar-panel rd-navbar-n-search-wrap">
                <!-- RD Navbar Toggle -->
                <button class="rd-navbar-toggle" data-rd-navbar-toggle=".rd-navbar-nav-wrap"><span></span>
                </button>
                <!-- END RD Navbar Toggle -->

                <!-- RD Navbar Brand -->
                <div class="rd-navbar-brand">
                    <a href="{{route('home')}}" class="brand-name">
                        <img src="{{ asset('storage').'/logos/'.Setting::getFaviconLogo()->company_logo }}" alt="Sysu" />
                    </a>
                </div>
                <div class="rd-navbar-top-panel__content"> <!--desktop shopping icons-->
                    <div class="rd-navbar-top-panel__left">
                        <ul class="rd-navbar-items-list">
                        
                            <li>
                                <a href="{{route('cart.front.show')}}"><i class="fa fa-shopping-cart"></i> <span>Cart <span class="badge badge-danger cart-counter">{!! Setting::EcommerceCartTotalItems() !!}</span></span></a>
                            </li>
                            @if(auth()->check())
                            <li><a  href="{{route('profile.sales')}}"><i class="fa fa-user"></i> <span>My Account</span></a></li>
                                <li><a  href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i class="fa fa-sign-out-alt"></i> <span>Log Out</span></a></li>
                                <form id="auth-logout-form" action="{{ route('account.logout') }}" method="get" style="display: none;">
                                    @csrf
                                </form>
                            @else
                                 <li><a  href="{{route('customer-front.sign-up')}}" ><i class="fa fa-user-plus"></i> <span>Register</span></a></li>
                                <li><a  href="{{route('customer-front.login')}}" ><i class="fa fa-sign-in-alt"></i> <span>Log In</span></a></li>
                            @endif
                                 
                        </ul>
                    </div>
                </div>
                <!-- END RD Navbar Brand -->
            </div>
            @include('theme.sysu.layout.menu')

        </div>

    </nav>
<!-- END RD Navbar -->
</header>
<!-- @include('theme.sysu.layout.banner') -->