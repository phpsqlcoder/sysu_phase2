<div class="main-banner sub-banner">
    <div class="slick-slider" id="banner">
        @foreach ($page->album->banners as $banner)
            <div class="banner-wrapper">
                <div class="banner-image"><img src="{{ $banner->image_path }}" /></div>
                <div class="banner-text">
                </div>
            </div>
        @endforeach
    </div>
</div>
