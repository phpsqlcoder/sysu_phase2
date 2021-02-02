<div class="rd-navbar-nav-wrap">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-1"></div>
            <div class="col-lg-10">
                <!-- RD Navbar Nav -->
                <ul class="rd-navbar-nav">
                    <li><a href="{{route('product.front.list')}}">Shop</a></li>
                    
                        @php
                            $menu = \App\Menu::where('is_active', 1)->first();
                        @endphp
                        @foreach ($menu->parent_navigation() as $item)
                            @include('theme.sysu.layout.menu-item', ['item' => $item])
                        @endforeach
                    
                </ul>
                <!-- END RD Navbar Nav -->
            </div>
            <div class="col-lg-1 position-relative">
                <!-- <div class="rd-navbar-fixed--hidden float-right">
                    <button class="rd-navbar-search__toggle rd-navbar-search__toggle_additional toggle-original"
                    data-rd-navbar-toggle=".rd-navbar-search-wrap"></button>
                </div> -->
                <form class="search-form" action="{{route('product.front.list')}}" method="GET" data-search-live="rd-search-results-live">
                    @csrf
                    <input type="hidden" name="_method" value="POST">
                    <input type="hidden" name="search" value="on">
                    <div class="input-group search-group">
                        <input type="text" name="searchtxt" class="form-control search-control" placeholder="Enter your search term...">
                    </div>
                </form>
            </div>
        </div>
    </div>

</div>
