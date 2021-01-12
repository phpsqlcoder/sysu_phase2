@extends('theme.'.env('FRONTEND_TEMPLATE').'.main')

@section('pagecss')
@endsection

@section('content')
    <main>
        <section class="wrapper">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <h3>{{ Setting::info()->data_privacy_title }}</h3>
                        <p>&nbsp;</p>
                        {!! Setting::info()->data_privacy_content !!}
                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection

@section('pagejs')
@endsection
