@extends('theme.'.env('FRONTEND_TEMPLATE').'.main')
@section('content')
    <main>        
        <section id="default-wrapper">
            <div class="container">
                @if($parentPage)
                    <div class="row default-row">
                        <div class="col-lg-3">
                            <h3>{{ $parentPage->name }}</h3>
                            <div class="gap-20"></div>
                            <div class="side-menu">
                                <ul>
                                    @foreach ($parentPage->sub_pages as $subPage)
                                        <li @if ($subPage->id == $page->id) class="active" @endif>
                                            <a href="{{ $subPage->get_url() }}">{{ $subPage->name }}</a>
                                            @if ($subPage->has_sub_pages())
                                                <ul>
                                                    @foreach ($subPage->sub_pages as $subSubPage)
                                                        <li @if ($subSubPage->id == $page->id) class="active" @endif>
                                                            <a href="{{ $subSubPage->get_url() }}">{{ $subSubPage->name }}</a>
                                                            @if ($subSubPage->has_sub_pages())
                                                                <ul>
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
                            <div class="article-content">
                                {!! $page->contents !!}
                            </div>
                        </div>
                    </div>
                @else
                    <div class="row default-row">
                        <div class="col-lg-12">
                            {!! $page->contents !!}
                        </div>                    
                    </div>
                @endif

            </div>
        </section>

    </main>
@endsection
