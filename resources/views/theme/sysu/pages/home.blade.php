@extends('theme.'.env('FRONTEND_TEMPLATE').'.main')

@section('pagecss')
@endsection

@section('content')
    {!! $page->contents !!}
@endsection

@section('pagejs')
@endsection

@section('customjs')
@endsection


