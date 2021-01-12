@extends('admin.layouts.app')

@section('pagetitle')
    Category Management
@endsection

@section('content')
<div class="container pd-x-0">
    <div class="d-sm-flex align-items-center justify-content-between mg-b-20 mg-lg-b-25 mg-xl-b-30">
        <div>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb breadcrumb-style1 mg-b-10">
                    <li class="breadcrumb-item" aria-current="page"><a href="{{route('dashboard')}}">CMS</a></li>
                    <li class="breadcrumb-item" aria-current="page"><a href="{{route('news-categories.index')}}">News Category</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Edit News Category</li>
                </ol>
            </nav>
            <h4 class="mg-b-0 tx-spacing--1">Edit News Category</h4>
        </div>
    </div>

    <div class="row row-sm">
        <div class="col-lg-12">
            <div class="card ht-lg-100p">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h6 class="mg-b-0">Category Form</h6>
                </div><!-- card-header -->
                <div class="card-body pd-0">
                    <div class="table-responsive">
                        <form autocomplete="off" action="{{ route('news-categories.update', $articleCategory->id) }}" method="post">
                            @method('PUT')
                            @csrf
                            <div class="modal-body pd-sm-t-30 pd-sm-b-40 pd-sm-x-30">
                                <div class="row row-sm">
                                    <div class="col-sm">
                                        <label class="tx-10 tx-uppercase tx-medium tx-spacing-1 mg-b-5 tx-color-03">Category Name <i class="tx-danger">*</i></label>
                                        <input required type="text" class="form-control @error('category_name') is-invalid @enderror" name="category_name" id="category_title" value="{{$articleCategory->name}}" @htmlValidationMessage({{__('standard.empty_all_field')}})>
                                        @hasError(['inputName' => 'category_name'])
										@endhasError
										<small id="category_slug"><a target="_blank" href="{{env('APP_URL')}}/{{$articleCategory->slug}}">{{env('APP_URL')}}/{{$articleCategory->slug}}</a></small>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer pd-x-20 pd-y-15">
                                <a href="{{ route('news-categories.index') }}" class="btn btn-outline-secondary btn-sm tx-uppercase">Cancel</a>
                                <button type="submit" class="btn btn-sm btn-primary tx-uppercase">Update Category</button>
                            </div>
                        </form>
                    </div>
                </div><!-- card-body -->
            </div><!-- card -->
        </div>
    </div>
</div>
@endsection

@section('customjs')
    <script>
        /** Generation of the page slug **/
        jQuery('#category_title').change(function(){

                var url = $('#category_title').val();

                $.ajaxSetup({
                    headers:{
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr("content")
                    }
                })

                $.ajax({
                    type: "POST",
                    url: "/admin/category/get-slug",
                    data: { url: url }
                })

                .done(function(response){

                    slug_url = '{{env('APP_URL')}}/'+response;
                    $('#category_slug').html("<a target='_blank' href='"+slug_url+"'>"+slug_url+"</a>");

                });

                });
        </script>
@endsection
