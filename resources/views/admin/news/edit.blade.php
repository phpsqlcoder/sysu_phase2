@extends('admin.layouts.app')

@section('pagetitle')
    Update Article
@endsection

@section('pagecss')
	<link href="{{ asset('lib/bselect/dist/css/bootstrap-select.css') }}" rel="stylesheet">
    <script src="{{ asset('lib/ckeditor/ckeditor.js') }}"></script>
@endsection

@section('content')

<div class="container pd-x-0">
    <div class="d-sm-flex align-items-center justify-content-between mg-b-20 mg-lg-b-25 mg-xl-b-30">
        <div>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb breadcrumb-style1 mg-b-10">
                    <li class="breadcrumb-item" aria-current="page"><a href="{{route('dashboard')}}">CMS</a></li>
                    <li class="breadcrumb-item" aria-current="page"><a href="{{route('news.index')}}">News</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Edit a News</li>
                </ol>
            </nav>
            <h4 class="mg-b-0 tx-spacing--1">Edit a News</h4>
        </div>
        <div>
            <a class="btn btn-outline-primary btn-sm" href="{{$article->get_url()}}" target="_blank">Preview News</a>
        </div>
    </div>
    <form id="editForm" method="post" action="{{ route('news.update',$article->id) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="row row-sm">
            <div class="col-lg-6">

                    @csrf
                    <div class="form-group">
                        <label class="d-block">Title *</label>
                        <input type="text" class="form-control @error('news_title') is-invalid @enderror" maxlength="150" name="news_title" id="news_title" value="{{ old('news_title',$article->name) }}" required>
                        <small id="news_slug">{{ $article->get_url() }}</small>
                        @hasError(['inputName' => 'news_title'])
                        @endhasError
                    </div>
                    <div class="form-group">
                        <label class="d-block">Date *</label>
                        <input type="date" class="form-control @error('date') is-invalid @enderror" name="date" id="date" value="{{ old('date',$article->date) }}">
                        @hasError(['inputName' => 'date'])
                        @endhasError
                    </div>
                    <div class="form-group">
                        <label class="d-block">Category</label>
                        <select id="category" class="selectpicker mg-b-5 @error('category') is-invalid @enderror" name="category" data-style="btn btn-outline-light btn-md btn-block tx-left" title="- None -" data-width="100%">
                            <option value="0" @if (empty($article->category_id)) selected @endif>- None -</option>
                            @forelse($categories as $category)
                                <option value="{{$category->id}}" {{(old("category", $article->category_id) == $category->id ? "selected":"") }} >{{strtoupper($category->name)}}</option>
                            @empty
                            @endforelse
                        </select>
                        @hasError(['inputName' => 'category'])
                        @endhasError
                    </div>
                    <div class="form-group">
                        <label class="d-block">Article banner</label>
                        <div class="custom-file">
                            <input type="file" class="custom-file-input @error('news_image') is-invalid @enderror" name="news_image" id="news_image" @if (!empty($article->image_url)) title="{{$article->get_image_file_name()}}" @endif>
                            <label class="custom-file-label" for="news_image" id="img_name">@if (empty($article->image_url)) Choose file @else {{$article->get_image_file_name()}} @endif</label>
                        </div>
                        <p class="tx-10">
                            Required image dimension: {{ env('NEWS_BANNER_WIDTH') }}px by {{ env('NEWS_BANNER_HEIGHT') }}px <br /> Maximum file size: 1MB <br /> Required file type: .jpeg .png
                        </p>
                        @hasError(['inputName' => 'news_image'])
                        @endhasError
                        <div id="image_div" @if(empty($article->image_url)) style="display:none;" @endif>
                            <img src="{{ $article->image_url }}" height="100" width="300" id="img_temp" alt="">  <br /><br />
                            <a href="javascript:void(0)" class="btn btn-sm btn-danger remove-upload" >Remove Image</a>
                        </div>
                    </div>

            </div>
            <div class="col-lg-12">
                <div class="form-group">
                    <label class="d-block">Content *</label>
                    <textarea name="content" id="editor1" rows="10" cols="80" required>
                        {{ old('content', $article->contents) }}
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
                    <textarea class="form-control @error('teaser') is-invalid @enderror" name="teaser" rows="4" required>{{ old('teaser', $article->teaser) }}</textarea>
                    @error('teaser')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
					<label class="d-block">Page Visibility</label>
					<div class="custom-control custom-switch @error('visibility') is-invalid @enderror">
                        <input type="checkbox" class="custom-control-input" name="visibility" {{ (((old("visibility", strtoupper($article->status)) == "ON") || (old("visibility", strtoupper($article->status)) == "PUBLISHED")) ? "checked":"") }} id="customSwitch1">
						<label class="custom-control-label" id="label_visibility" for="customSwitch1">{{ (((old("visibility", strtoupper($article->status)) == "ON") || (old("visibility", strtoupper($article->status)) == "PUBLISHED")) ? "Published":"Private") }}</label>
					</div>
					@error('visibility')
					    <div class="alert alert-danger">{{ $message }}</div>
					@enderror
				</div>


                <div class="form-group">
                    <label class="d-block">Display</label>
                    <div class="custom-control custom-switch @error('is_featured') is-invalid @enderror">
                        <input type="checkbox" class="custom-control-input" name="is_featured" {{ (old("is_featured",$article->is_featured) ? "checked":"") }} {{ ((strtoupper($article->is_featured) == '1') ? "checked":"") }} id="customSwitch2">
                        <label class="custom-control-label" for="customSwitch2">Featured</label>
                    </div>
                    @error('is_featured')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="col-lg-12 mg-t-30">
                <h4 class="mg-b-0 tx-spacing--1">Manage SEO</h4>
                <hr>
            </div>

            <div class="col-lg-6 mg-t-30">
                <div class="form-group">
                    <label class="d-block">Title <code>(meta title)</code></label>
                    <input type="text" class="form-control @error('seo_title') is-invalid @enderror" name="seo_title" value="{{ old('seo_title',$article->meta_title) }}">
                    @hasError(['inputName' => 'seo_title'])
                    @endhasError
                    <p class="tx-11 mg-t-4">{{ __('standard.seo.title') }}</p>
                </div>
                <div class="form-group">
                    <label class="d-block">Description <code>(meta description)</code></label>
                    <textarea rows="3" class="form-control @error('seo_description') is-invalid @enderror" name="seo_description">{{ old('seo_description',$article->meta_description) }}</textarea>
                    @hasError(['inputName' => 'seo_description'])
                    @endhasError
                    <p class="tx-11 mg-t-4">{{ __('standard.seo.description') }}</p>
                </div>
                <div class="form-group">
                    <label class="d-block">Keywords <code>(meta keywords)</code></label>
                    <textarea rows="3" class="form-control @error('seo_keywords') is-invalid @enderror" name="seo_keywords">{{ old('seo_keywords',$article->meta_keyword) }}</textarea>
                    @hasError(['inputName' => 'seo_keywords'])
                    @endhasError
                    <p class="tx-11 mg-t-4">{{ __('standard.seo.keywords') }}</p>
                </div>
            </div>

    		<div class="col-lg-12 mg-t-30">
    		    <button class="btn btn-primary btn-sm btn-uppercase" type="submit">Update News</button>
    		    <a href="{{ route('news.index') }}" class="btn btn-outline-secondary btn-sm btn-uppercase">Cancel</a>
    		</div>
        </div>
    </form>
</div>

<div class="modal effect-scale" id="prompt-remove" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalCenterTitle">Remove image</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>{{__('standard.banner.remove_image')}}</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-danger" id="btnRemove">Yes, remove image</button>
                <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('pagejs')
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
        // Replace the <textarea id="editor1"> with a CKEditor
        // instance, using default configuration.
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
            $("#customSwitch1").change(function () {
                if (this.checked) {
                    $('#label_visibility').html('Published');
                } else {
                    $('#label_visibility').html('Private');
                }
            });

            /** Generation of the page slug **/
            $('#news_title').change(function () {
                let url = $('#news_title').val().trim();

                if (url == "{{ $article->name }}") {
                    $('#news_slug').html("{{ $article->get_url() }}");
                    return false;
                }

                $.ajax({
                    type: "POST",
                    url: "{{ route('news.get-slug') }}",
                    data: {url: url, _token: "{{ csrf_token() }}"}
                }).done(function (response) {
                    slug_url = '{{env('APP_URL')}}/news/' + response;
                    $('#news_slug').html("<a target='_blank' href='" + slug_url + "'>" + slug_url + "</a>");
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

        $(document).on('click', '.remove-upload', function() {
            $('#prompt-remove').modal('show');
        });

        $('#btnRemove').on('click', function() {
            $('#editForm').prepend('<input type="hidden" name="delete_image" value="1"/>');
            $('#img_name').html('Choose file');
            $('#news_image').removeAttr('title');
            $('#news_image').val('');
            $('#img_temp').attr('src', '');
            $('#image_div').hide();
            $('#prompt-remove').modal('hide');
        });

    </script>
@endsection
