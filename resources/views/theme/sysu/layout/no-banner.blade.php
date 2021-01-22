<section class="mt-4" style="display: @if(Route::current()->getName() == 'product.front.list') none @else block @endif;">
    <div class="container">
        <div class="row no-gutters">
            <div class="col-12">
                <div class="main-banner sub-banner">
                    <div class="banner-wrap border-top border-bottom py-5">
                        <div class="bannerCaption d-flex justify-content-center align-items-center">
                            <div class="jumbotron banner-welcome p-0 m-0 bg-transparent">
                              <h2 class="display-4 text-center text-dark">{{ $page->name }}</h2>
                                <nav aria-label="breadcrumb" class="d-flex justify-content-center">
                                    @if(isset($breadcrumb))
                                    <ol class="breadcrumb p-0 m-0">
                                        @foreach($breadcrumb as $link => $url)
                                            @if($loop->last)
                                                <li class="breadcrumb-item active text-dark" aria-current="page">{{$link}}</li>
                                            @else
                                                <li class="breadcrumb-item"><a href="{{$url}}">{{$link}}</a></li>
                                            @endif
                                        @endforeach
                                    </ol>
                                    @endif
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
