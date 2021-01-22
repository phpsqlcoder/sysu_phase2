@extends('theme.'.env('FRONTEND_TEMPLATE').'.main')
@section('content')
    <section class="mb-5">
        <div class="container pt-2">
            <div class="gap-20"></div>
            <div class="row">
                @if($parentPage)
                    <span onclick="closeNav()" class="dark-curtain"></span> 
                    <span onclick="openNav()" class="mb-4 btn btn-primary btn-bg open-nav rounded-0 d-block d-lg-none"><i class="fa fa-1x fa-th-list"></i></span>

                    <div class="col-md-3">
                        <div class="tablet-view">
                            <a href="javascript:void(0)" class="closebtn d-block d-lg-none mt-5" onclick="closeNav()">&times;</a>
                            <h3>{{ $parentPage->name }}</h3>
                            <ul class="quicklinks ul-none no-padding mb-3">
                                @foreach ($parentPage->sub_pages as $subPage)
                                    <li @if ($subPage->id == $page->id) class="active" @endif>
                                        <a href="{{ $subPage->get_url() }}">{{ $subPage->name }}</a>
                                        @if ($subPage->has_sub_pages())
                                            <ul class="ul-none">
                                                @foreach ($subPage->sub_pages as $subSubPage)
                                                    <li @if ($subSubPage->id == $page->id) class="active" @endif>
                                                        <a href="{{ $subSubPage->get_url() }}">{{ $subSubPage->name }}</a>
                                                        @if ($subSubPage->has_sub_pages())
                                                            <ul class="ul-none">
                                                                @foreach ($subSubPage->sub_pages as $subSubSubPage)
                                                                    <li @if ($subSubSubPage->id == $page->id) class="active" @endif>
                                                                        <a href="{{ $subSubSubPage->get_url() }}">{{ $subSubSubPage->name }}</a>
                                                                    </li>
                                                                @endforeach
                                                            </ul>
                                                        @endif
                                                    </li>
                                                @endforeach
                                            </ul>
                                        @endif
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-9">
                        {!! $page->contents !!}
                    </div>
                @else
                    <div class="col-lg-12">
                        {!! $page->contents !!}
                    </div>
                @endif
            </div>
        </div>
    </section>
@endsection
