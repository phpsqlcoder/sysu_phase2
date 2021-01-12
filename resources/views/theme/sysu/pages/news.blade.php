 @extends('theme.'.env('FRONTEND_TEMPLATE').'.main')
@section('pagecss')
    <link rel="stylesheet" href="{{ asset('theme/artemissalt/plugins/jssocials/jssocials.css') }}">
    <link rel="stylesheet" href="{{ asset('theme/artemissalt/plugins/jssocials/jssocials-theme-flat.css') }}">
    <style>
        
    </style>

@endsection
@section('content')
    <section id="default-wrapper">
        <div class="container">
            <div class="row row-article">
                <div class="col-lg-3">
                    <div class="article-opt">
                        <p>
                            <a href="news.htm"><span><i class="fas fa-long-arrow-alt-left"></i></span>Back to
                            news listing</a>
                        </p>
                        <p>
                            <a href="#"><span><i class="fa fa-share"></i></span>E-mail
                            this article</a>
                        </p>
                        <p>
                            <a href="#"><span><i class="fa fa-print"></i></span>Print this
                            article</a>
                        </p>
                    </div>
                    <div class="gap-20"></div>
                    <div class="article-widget">
                        <div class="article-widget-title">Tags</div>
                        <div class="article-widget-badge">
                            <span class="badge badge-secondary">lorem</span>
                            <span class="badge badge-secondary">ornare</span>
                            <span class="badge badge-secondary">bibendum</span>
                            <span class="badge badge-secondary">lorem</span>
                            <span class="badge badge-secondary">ornare</span>
                            <span class="badge badge-secondary">bibendum</span>
                            <span class="badge badge-secondary">lorem</span>
                            <span class="badge badge-secondary">bibendum</span>
                        </div>
                    </div>
                    <div class="gap-20"></div>
                    
                    <div class="article-widget">
                        <div class="article-widget-title">
                            Latest News
                        </div>
                        @foreach ($latestArticles as $article)
                            <div class="article-widget-news">
                                <p class="news-date">February 27, 2020</p>
                                <p class="news-title">
                                    <a href="article.html">We're divided land his creature which have evening subdue</a>
                                </p>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="col-lg-9">
                    <div class="breadcrumb dark" style="color:black;line-height: 1.8;">
                        <a href="{{route('home')}}" style="color:blue">Home</a>
                        <span class="fa default" style="color:black"></span>
                        <a href="{{route('news.front.index')}}" style="color:blue">News</a>
                        <span class="fa default" style="color:black"></span>
                        <span class="current" style="color:#EA891B !important">{{ $news->name }}</span>
                    </div>
                    <div class="article-meta-share">
                        <div class="article-meta">
                            <p>
                                Posted on {{ date('M d, Y h:i A', strtotime($news->created_at)) }} by
                                <span class="article-meta-author">{{ $news->user->name }}</span>
                            </p>
                        </div>
                        <div class="article-share">
                            <div id="article-social"></div>                           
                        </div>
                    </div>
                    <div class="article-content">
                        <img src="{{ $news->image_url }}" alt="" />
                        <div class="gap-10"></div>
                       
                        {!! $news->contents !!}

                    </div>
                </div>
            </div>
        </div>
    </section>
   
@endsection

@section('pagejs')
    <script src="{{ asset('theme/artemissalt/plugins/jssocials/jssocials.js') }}"></script>
    <script src="{{ asset('theme/artemissalt/plugins/jssocials/jssocials.extension.js') }}"></script>
@endsection

@section('customjs')
<script>
    var navikMenuListDropdown = $(".side-menu ul li:has(ul)");

    navikMenuListDropdown.each(function() {
        $(this).append('<span class="dropdown-append"></span>');
    });

    $(".side-menu .active").each(function() {
        $(this).parents("ul").css("display", "block");
        $(this).parents("ul").prev("a").css("color", "#00bfca");
        $(this).parents("ul").next(".dropdown-append").addClass("dropdown-open");
    });

    $(".dropdown-append").on("click", function() {
        $(this).prev("ul").slideToggle(300);
        $(this).toggleClass("dropdown-open");
    });
</script>
<script>
    $(function() {
        $('#frm_search').on('submit', function(e) {
            e.preventDefault();
            window.location.href = "/news?type=searchbox&criteria="+$('#searchtxt').val();
        });

        $('#shareEmailForm').submit(function(evt) {
            let data = $('#shareEmailForm').serialize();
            // console.log(data);

            $.ajax({
                data: data,
                type: "POST",
                url: "{{ route('news.front.share', $news->slug) }}",
                success: function(returnData) {
                    $('#email-success').modal('show');
                    $('#email-article').modal('hide');
                    $('#email-article input').val('');
                },
                error: function(){
                    $('#email-failed').modal('show');
                    $('#email-article').modal('hide');
                    $('#email-article input').val('');
                }
            });

            evt.preventDefault();
            return false;
        });
    });
</script>
@endsection
