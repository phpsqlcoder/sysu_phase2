<div class="banner-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12" style="padding:0;">
                <div id="banner" class="slick-slider">
                    @foreach ($page->album->banners as $banner)
                        <div class="hero-slide">
                            <div class="banner-overlay">
                                <div class="banner-overlay-img" style="background:url({{ $banner->image_path }})">
                                    <div class="banner-overlay-layer"></div>
                                </div>
                            </div>
                            <img src="{{ $banner->image_path }}">
                            <div class="banner-caption">
                                <div class="container">
                                    <div class="row">
                                        <div class="col-lg-5 col-md-5">
                                            <h2>{{ $banner->title }}</h2>
                                            <p>{{ $banner->description }}</p>
                                            @if($banner->url && $banner->button_text)                                                
                                                <a class="btn btn-md primary-btn mr-2" href="{{ $banner->url }}">{{ $banner->button_text }}</a>
                                            @endif
                                        </div>
                                        <div class="col-lg-7 col-md-7">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach                   
                </div>
            </div>
        </div>
    </div>
</div>
