@extends('theme.'.env('FRONTEND_TEMPLATE').'.main')

@section('pagecss')
    <link rel="stylesheet" href="{{ asset('theme/sysu/plugins/jssocials/jssocials.css') }}" />
    <link rel="stylesheet" href="{{ asset('theme/sysu/plugins/jssocials/jssocials-theme-flat.min.css') }}" />
@endsection

@section('content')
    <section class="mb-5">
        <div class="container pt-2">
            <div class="gap-20"></div>
            <div class="row">
                <span onclick="closeNav()" class="dark-curtain"></span> 
                <span onclick="openNav()" class="mb-4 btn btn-primary btn-bg open-nav rounded-0 d-block d-lg-none openNav"><i class="fa fa-1x fa-th-list"></i></span>

                <div class="col-md-3">
                    <div class="tablet-view">
                        <a href="javascript:void(0)" class="closebtn d-block d-lg-none mt-5" onclick="closeNav()">&times;</a>

                        <div class="article-opt mb-5">
                            <p><a href="{{ route('news.front.index') }}"><span><i class="fa fa-arrow-left"></i></span>Back to news listing</a></p>
                            <p><a href="#" data-toggle="modal" data-target="#email-article"><span><i class="fa fa-envelope-open"></i></span>E-mail this article</a></p>
                        </div>
                        <div class="article-widget mb-5">
                            <h3 class="font-weight-bold">Search</h3>
                            <div class="article-widget-search">
                                <div class="search">
                                    <div class="input-group">
                                        <input type="text" class="form-control" placeholder="Search news" aria-label="Search news" aria-describedby="button-addon2" />
                                        <div class="input-group-append">
                                            <button class="btn btn-outline-secondary" type="button" id="button-addon2"><span class="fa fa-search"></span></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="article-widget">
                            <h3 class="font-weight-bold">Latest News</h3>
                            @foreach($latestArticles as $latest)
                            <div class="article-widget-news">
                                <p class="news-date">{{ date('F d, Y',strtotime($latest->date)) }}</p>
                                <p class="news-title">
                                    <a href="{{ route('news.front.show',$latest->slug) }}">{{ $latest->name }}</a>
                                </p>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <div class="col-lg-9">
                    <div class="article-meta-share">
                        <div class="article-meta">
                            <h2 class="h1 font-weight-bold secondary-title">{{ $news->name }}</h2>
                            <p class="small">Posted {{ Setting::date_for_news_list($news->date) }}, by<span class="article-meta-author"><strong> {{$news->user->name}}</strong></span></p>
                        </div>
                    </div>
                    <div class="article-content mb-5">
                        {!! $news->contents !!}
                    </div>

                    <div class="article-share">
                        <div class="article-share-text">Share:</div>
                        <div id="article-social"></div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    <div class="modal fade" id="email-article" tabindex="-1" role="dialog" aria-labelledby="email-article" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">E-mail this article</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
                <form id="shareEmailForm">
                    <div class="modal-body">
                        <div class="form-group">
                            <input id="form_email_to" type="email" name="email_to" class="form-control" placeholder="Email to" required="required" data-error="Valid email is required.">
                            <div class="help-block with-errors"></div>
                        </div>
                        <div class="form-group">
                            <input id="form_recipient_name" type="text" name="name" class="form-control" placeholder="Recipient's Name" required="required">
                            <div class="help-block with-errors"></div>
                        </div>
                        <div class="form-group">
                            <input id="form_email_from" type="email" name="email_from" class="form-control" placeholder="Your email address" required="required" data-error="Valid email is required.">
                            <div class="help-block with-errors"></div>
                        </div>
                        <div class="form-group">
                            <input id="form_name" type="text" name="sender_name" class="form-control" placeholder="Your name" >
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary" id="btnSendArticle"><span id="spanSendArticle">Send Article</span></button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="email-success" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">E-mail this article</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Article successfully sent!
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="email-failed" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
       <div class="modal-dialog modal-dialog-centered" role="document">
           <div class="modal-content">
               <div class="modal-header">
                   <h5 class="modal-title" id="exampleModalLabel">E-mail this article</h5>
                   <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                       <span aria-hidden="true">&times;</span>
                   </button>
               </div>
               <div class="modal-body">
                   Failed to share email. Try it again later.
               </div>
           </div>
       </div>
    </div>
@endsection

@section('pagejs')
    <script src="{{ asset('theme/sysu/plugins/jssocials/jssocials.js') }}"></script>
    <script src="{{ asset('theme/sysu/plugins/jssocials/jssocials-extension.js') }}"></script>
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

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $(function() {
        $('#frm_search').on('submit', function(e) {
            e.preventDefault();
            window.location.href = "/news?type=searchbox&criteria="+$('#searchtxt').val();
        });

        $('#shareEmailForm').submit(function(evt) {
            evt.preventDefault();
            let data = $('#shareEmailForm').serialize();

            $('#spanSendArticle').html('Sending...');
            $('#btnSendArticle').prop('disabled',true);
            
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
            return false;
        });
    });
</script>
@endsection
