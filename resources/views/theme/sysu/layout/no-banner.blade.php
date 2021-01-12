<div class="banner-wrapper" style="display:none;">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12" style="padding:0;">
                <div>
                    <div class="hero-slide">
                        <div class="sub-banner-overlay"></div>
             
                        <div class="sub-banner-caption">
                            <div class="container">
                                <div class="sub-banner-flex">
                                    <h2>{{ $page->name }}</h2>
                                    @if(isset($breadcrumb))
                                        <div class="breadcrumb">
                                            @foreach($breadcrumb as $link => $url)
                                                @if($loop->last)
                                                    <span class="current">{{$link}}</span>
                                                @else
                                                    <a href="{{$url}}">{{$link}}</a>
                                                    <span class="fa default"></span>
                                                @endif
                                            @endforeach
                                        </div>
                                    @endif
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
