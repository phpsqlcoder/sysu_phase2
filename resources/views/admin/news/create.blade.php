@extends('admin.layouts.app')

@section('pagetitle')
    Create News
@endsection

@section('pagecss')
	<link href="{{ asset('lib/bselect/dist/css/bootstrap-select.css') }}" rel="stylesheet">
@endsection

@section('content')

<div class="container pd-x-0">
    <div class="d-sm-flex align-items-center justify-content-between mg-b-20 mg-lg-b-25 mg-xl-b-30">
        <div>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb breadcrumb-style1 mg-b-10">
                    <li class="breadcrumb-item" aria-current="page"><a href="{{route('dashboard')}}">CMS</a></li>
                    <li class="breadcrumb-item" aria-current="page"><a href="{{route('news.index')}}">News</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Create a News</li>
                </ol>
            </nav>
            <h4 class="mg-b-0 tx-spacing--1">Create a News</h4>
        </div>
    </div>
    <form method="post" action="{{ route('news.store') }}" enctype="multipart/form-data">
        <div class="row row-sm">
            <div class="col-lg-6">

                @csrf
                <div class="form-group">
                    <label class="d-block">Title *</label>
                    <input type="text" class="form-control @error('news_title') is-invalid @enderror" name="news_title" id="news_title" value="{{ old('news_title') }}" required @htmlValidationMessage({{__('standard.empty_all_field')}})>
                    @hasError(['inputName' => 'news_title'])
                    @endhasError
                    <small id="news_slug"></small>
                </div>
                <div class="form-group">
                    <label class="d-block">Date *</label>
                    <input type="date" class="form-control @error('date') is-invalid @enderror" name="date" id="date" value="{{ old('date',date('Y-m-d')) }}">
                    @hasError(['inputName' => 'date'])
                    @endhasError
                </div>
                <div class="form-group">
                    <label class="d-block">Category</label>
                    <select id="category" class="selectpicker mg-b-5 @error('category') is-invalid @enderror" name="category" data-style="btn btn-outline-light btn-md btn-block tx-left" title="- None -" data-width="100%">
                        <option value="0" selected>- None -</option>
                        @forelse($categories as $category)
                            <option value="{{$category->id}}">{{strtoupper($category->name)}}</option>
                        @empty
                        @endforelse
                    </select>
                    @hasError(['inputName' => 'category'])
                    @endhasError
                </div>
                <div class="form-group">
                    <label class="d-block">Article banner</label>
                    <div class="custom-file">
                        <input type="file" class="custom-file-input @error('news_image') is-invalid @enderror" name="news_image" id="news_image"  accept="image/*">
                        <label class="custom-file-label" for="news_image" id="img_name">Choose file</label>
                    </div>
                    <p class="tx-10">
                        Required image dimension: {{ env('NEWS_BANNER_WIDTH') }}px by {{ env('NEWS_BANNER_HEIGHT') }}px <br /> Maximum file size: 1MB <br /> Required file type: .jpeg .png
                    </p>
                    @error('news_image')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                    <div id="image_div" style="display:none;">
                        <img src="" height="100" width="300" id="img_temp" alt="">  <br /><br />
                        <a href="javascript:void(0)" class="btn btn-xs btn-danger" onclick="remove_image();">Remove Image</a>
                    </div>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="form-group">
                    <label class="d-block">Content *</label>
                    <textarea name="content" id="editor1" rows="10" cols="80" required>
                         {{ old('content') }}
                    </textarea>
                    @hasError(['inputName' => 'content'])
                    @endhasError
                    <span class="invalid-feedback" role="alert" id="contentRequired" style="display: none;">
                        <strong>The content field is required</strong>
                    </span>
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label class="d-block">Teaser *</label>
                    <textarea class="form-control @error('teaser') is-invalid @enderror" name="teaser" rows="4" required @htmlValidationMessage({{__('standard.empty_all_field')}})>{{ old("teaser") }}</textarea>
                    @hasError(['inputName' => 'teaser'])
                    @endhasError
                </div>
                <div class="form-group">
                    <label class="d-block">Page Visibility</label>
                    <div class="custom-control custom-switch @error('visibility') is-invalid @enderror">
                        <input type="checkbox" class="custom-control-input" name="visibility" {{ (old("visibility") ? "checked":"") }} id="customSwitch1">
                        <label class="custom-control-label" id="label_visibility" for="customSwitch1">@if (old("visibility")) Published @else Private @endif</label>
                    </div>
                    @hasError(['inputName' => 'visibility'])
                    @endhasError
                </div>
                <div class="form-group">
                    <label class="d-block">Display</label>
                    <div class="custom-control custom-switch @error('is_featured') is-invalid @enderror">
                        <input type="checkbox" class="custom-control-input" name="is_featured" {{ (old("is_featured") ? "checked":"") }} id="customSwitch2">
                        <label class="custom-control-label" for="customSwitch2">Featured</label>
                    </div>
                    @hasError(['inputName' => 'is_featured'])
                    @endhasError
                </div>
            </div>

            <div class="col-lg-12 mg-t-30">
                <h4 class="mg-b-0 tx-spacing--1">Manage SEO</h4>
                <hr>
            </div>

            <div class="col-lg-6 mg-t-30">
                <div class="form-group">
                    <label class="d-block">Title <code>(meta title)</code></label>
                    <input type="text" class="form-control @error('seo_title') is-invalid @enderror" name="seo_title" value="{{ old('seo_title') }}">
                    @hasError(['inputName' => 'seo_title'])
                    @endhasError
                    <p class="tx-11 mg-t-4">{{ __('standard.seo.title') }}</p>
                </div>
                <div class="form-group">
                    <label class="d-block">Description <code>(meta description)</code></label>
                    <textarea rows="3" class="form-control @error('seo_description') is-invalid @enderror" name="seo_description">{{ old('seo_description') }}</textarea>
                    @hasError(['inputName' => 'seo_description'])
                    @endhasError
                    <p class="tx-11 mg-t-4">{{ __('standard.seo.description') }}</p>
                </div>
                <div class="form-group">
                    <label class="d-block">Keywords <code>(meta keywords)</code></label>
                    <textarea rows="3" class="form-control @error('seo_keywords') is-invalid @enderror" name="seo_keywords">{{ old('seo_keywords') }}</textarea>
                    @hasError(['inputName' => 'seo_keywords'])
                    @endhasError
                    <p class="tx-11 mg-t-4">{{ __('standard.seo.keywords') }}</p>
                </div>
            </div>

    		<div class="col-lg-12 mg-t-30">
    		    <button class="btn btn-primary btn-sm btn-uppercase" type="submit">Save News</button>
    		    <a href="{{ route('news.index') }}" class="btn btn-outline-secondary btn-sm btn-uppercase">Cancel</a>
    		</div>
        </div>
</div>
@endsection

@section('pagejs')
    <script src="{{ asset('lib/ckeditor/ckeditor.js') }}"></script>
	<script src="{{ asset('lib/bselect/dist/js/bootstrap-select.js') }}"></script>
    <script src="{{ asset('lib/jqueryui/jquery-ui.min.js') }}"></script>

    {{--    Image validation--}}
    <script>
        let BANNER_WIDTH = "{{ env('NEWS_BANNER_WIDTH') }}";
        let BANNER_HEIGHT =  "{{ env('NEWS_BANNER_HEIGHT') }}";
    </script>
    <script src="{{ asset('js/image-upload-validation.js') }}"></script>
    {{--    End Image validation--}}
@endsection

@section('customjs')
	<script>
        // CKEditor
        var options = {
            filebrowserImageBrowseUrl: '{{ env('APP_URL') }}/laravel-filemanager?type=Images',
            filebrowserImageUpload: '{{ env('APP_URL') }}/laravel-filemanager/upload?type=Images&_token={{ csrf_token() }}',
            filebrowserBrowseUrl: '{{ env('APP_URL') }}/laravel-filemanager?type=Files',
            filebrowserUploadUrl: '{{ env('APP_URL') }}/laravel-filemanager/upload?type=Files&_token={{ csrf_token() }}',
            allowedContent: true,
        };
        let editor = CKEDITOR.replace('content', options);
        editor.on('required', function (evt) {
            if ($('.invalid-feedback').length == 1) {
                $('#contentRequired').show();
            }
            $('#cke_editor1').addClass('is-invalid');
            evt.cancel();
        });

        $(function() {
            $('.selectpicker').selectpicker();
        });

        // document.getElementById("category").selectedIndex = -1;
        // $('#category').on('change', function() {
        //     if ($(this).val() == 0) {
        //         document.getElementById("category").selectedIndex = -1;
        //     }
        // });

        // $('#news-date').datepicker({
        //     changeMonth: true,
        //     changeYear: true
        // });

        $(function() {
            $("#customSwitch1").change(function() {
                if(this.checked) {
                    $('#label_visibility').html('Published');
                }
                else{
                    $('#label_visibility').html('Private');
                }
            });

            $('#news_title').change(function(){
                let url = $('#news_title').val();
                $.ajax({
                    type: "POST",
                    url: "{{ route('news.get-slug') }}",
                    data: { url: url, _token: "{{ csrf_token() }}" }
                }).done(function(response){
                    slug_url = '{{env('APP_URL')}}/news/'+response;
                    $('#news_slug').html("<a target='_blank' href='"+slug_url+"'>"+slug_url+"</a>");
                });
            });
        });
    </script>
    <script>
        function readURL(file) {
            let reader = new FileReader();

            reader.onload = function(e) {
                $('#img_name').html(file.name);
                $('#news_image').attr('title', file.name);
                $('#img_temp').attr('src', e.target.result);
            }

            reader.readAsDataURL(file);
            $('#image_div').show();
        }

        $("#news_image").change(function(evt) {
            validate_images(evt, readURL);
        });

        function remove_image(){
            $('#img_name').html('Choose file');
            $('#news_image').removeAttr('title');
            $('#news_image').val('');
            $('#img_temp').attr('src', '');
            $('#image_div').hide();
        }

    </script>
@endsection
