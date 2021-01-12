@extends('admin.layouts.app')

@section('pagetitle')
    Manage Product Reviews
@endsection

@section('pagecss')
    <link href="{{ asset('lib/ion-rangeslider/css/ion.rangeSlider.min.css') }}" rel="stylesheet"
          xmlns="http://www.w3.org/1999/html">
    <style>
        .table {
            table-layout: fixed;
            word-wrap: break-word;
            /*border-collapse: separate;*/
            /*border-spacing:0 12px;*/
        }
        td {
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        .row-selected {
            background-color: #92b7da !important;
        }
    </style>
@endsection

@section('content')

        <div class="container pd-x-0">
            <div class="d-sm-flex align-items-center justify-content-between mg-b-20 mg-lg-b-25 mg-xl-b-30">
                <div>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb breadcrumb-style1 mg-b-5">
                            <li class="breadcrumb-item" aria-current="page"><a href="{{route('dashboard')}}">CMS</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Product Reviews</li>
                        </ol>
                    </nav>
                    <h4 class="mg-b-0 tx-spacing--1">Manage Product Reviews</h4>
                </div>
            </div>

            <!-- Start Filters -->
            <div class="row row-sm">
                <div class="col-md-12">
                    <div class="filter-buttons mg-b-10">
                        <div class="d-md-flex bd-highlight">
                            <div class="bd-highlight mg-r-10 mg-t-10">
                                <div class="dropdown d-inline mg-r-5">
                                    <button class="btn btn-secondary btn-sm dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        {{__('common.filters')}}
                                    </button>
                                    <div class="dropdown-menu">
                                        <form id="filterForm" class="pd-20">
                                            <div class="form-group">
                                                <label for="exampleDropdownFormEmail1">{{__('common.sort_by')}}</label>
                                                <div class="custom-control custom-radio">
                                                    <input type="radio" id="orderBy1" name="orderBy" class="custom-control-input" value="ecommerce_product_review.updated_at" @if ($filter['orderBy'] == 'ecommerce_product_review.updated_at') checked @endif>
                                                    <label class="custom-control-label" for="orderBy1">{{__('common.date_modified')}}</label>
                                                </div>
                                                <div class="custom-control custom-radio">
                                                    <input type="radio" id="orderBy2" name="orderBy" class="custom-control-input" value="products.name" @if ($filter['orderBy'] == 'products.name') checked @endif>
                                                    <label class="custom-control-label" for="orderBy2">Product Name</label>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="exampleDropdownFormEmail1">{{__('common.sort_order')}}</label>
                                                <div class="custom-control custom-radio">
                                                    <input type="radio" id="sortByAsc" name="sortBy" class="custom-control-input" value="asc" @if ($filter['sortBy'] == 'asc') checked @endif>
                                                    <label class="custom-control-label" for="sortByAsc">{{__('common.ascending')}}</label>
                                                </div>

                                                <div class="custom-control custom-radio">
                                                    <input type="radio" id="sortByDesc" name="sortBy" class="custom-control-input" value="desc"  @if ($filter['sortBy'] == 'desc') checked @endif>
                                                    <label class="custom-control-label" for="sortByDesc">{{__('common.descending')}}</label>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" id="showDeleted" name="showDeleted" class="custom-control-input" @if ($filter['showDeleted']) checked @endif>
                                                    <label class="custom-control-label" for="showDeleted">{{__('common.show_deleted')}}</label>
                                                </div>
                                            </div>
                                            <div class="form-group mg-b-40">
                                                <label class="d-block">{{__('common.item_displayed')}}</label>
                                                <input id="displaySize" type="text" class="js-range-slider" name="perPage" value="{{ $filter['perPage'] }}"/>
                                            </div>
                                            <button id="filter" type="button" class="btn btn-sm btn-primary">{{__('common.apply_filters')}}</button>
                                        </form>
                                    </div>
                                </div>
                                @if (auth()->user()->has_access_to_route('product-review.change_status') || auth()->user()->has_access_to_route('product-review.delete'))
                                    <div class="list-search d-inline">
                                        <div class="dropdown d-inline mg-r-10">
                                            <button class="btn btn-light btn-sm dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                Actions
                                            </button>
                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                @if (auth()->user()->has_access_to_route('product-review.change_status'))
                                                    <a class="dropdown-item"  href="javascript:void(0)" onclick="change_status('Approve')">Approve</a>
                                                @endif

                                                @if (auth()->user()->has_access_to_route('product-review.delete'))
                                                    <a class="dropdown-item tx-danger" href="javascript:void(0)" onclick="delete_review()">Delete</a>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>
                            <div class="ml-auto bd-highlight mg-t-10 mg-r-10">
                                <form class="form-inline" id="searchForm">
                                    <div class="search-form mg-r-10">
                                        <input name="search" type="search" id="search" class="form-control"  placeholder="Search by Product Name" value="{{ $filter['search'] }}">
                                        <button class="btn filter" type="button" id="btnSearch"><i data-feather="search"></i></button>
                                    </div>
                                    <a class="btn btn-success btn-sm mg-b-5" href="javascript:void(0)" data-toggle="modal" data-target="#advanceSearchModal">{{__('common.advance_search')}}</a>
                                </form>
                            </div>
                            <div class="mg-t-10">
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End Filters -->

                <!-- Container -->
                <div class="col-md-12">
                    <div class="table-list mg-b-10">
                        <div class="table-responsive-lg text-nowrap">
                            <table class="table mg-b-0 table-light table-hover" style="width:100%;">
                                <thead>
                                <tr>
                                    <th>
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="checkbox_all">
                                            <label class="custom-control-label" for="checkbox_all"></label>
                                        </div>
                                    </th>
                                    <th scope="col">Product Name</th>
                                    <th scope="col">Customer Name</th>
{{--                                    <th scope="col">Member</th>--}}
                                    <th scope="col" width="20%">Summary</th>
                                    <th scope="col">Star Rating</th>
                                    <th scope="col">Options</th>
                                </tr>
                                </thead>
                                <tbody>
                                @forelse($reviews as $review)
                                <tr id="row{{$review->id}}" class="row_cb">
                                    <th>
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input cb" id="cb{{ $review->id }}" data-id="{{ $review->id }}">
                                            <label class="custom-control-label" for="cb{{ $review->id }}"></label>
                                        </div>
                                    </th>
                                    <td><strong @if($review->trashed()) style="text-decoration:line-through;" @endif> {{ $review->product->name }}</strong></td>
                                    <td>{{ $review->user->name }}</td>
{{--                                    <td>{{ $review->user->user_type }}</td>--}}
                                    <td maxlength="50">{{ $review->review }}</td>
                                    <td>{{ $review->rating }}</td>
                                    <td>
                                        @if($review->trashed())
                                            @if (auth()->user()->has_access_to_route('product-review.restore'))
                                                <nav class="nav table-options justify-content-end">
                                                    <a class="nav-link" href="{{route('product-review.restore',$review->id)}}" title="Restore this FAQ"><i data-feather="rotate-ccw"></i></a>
                                                </nav>
                                            @endif
                                        @else
                                            @if (auth()->user()->has_access_to_route('product-review.delete'))
                                                <nav class="nav table-options">
                                                    <a class="nav-link" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                        <i data-feather="trash" class="mg-t-3"></i>
                                                    </a>
                                                    <div class="dropdown-menu dropdown-menu-right">
                                                        <a class="dropdown-item" style="display: none;" id="update-review" data-target="#prompt-update-review" data-toggle="modal" data-animation="effect-scale" data-id="{{ $review->id }}" data-product="{{ $review->product->name }}" data-user="{{ $review->user->name }}" data-member="{{ $review->user->user_type }}" data-rating="{{ $review->rating }}" data-review="{{ $review->review }}" data-status="{{ $review->is_approved }}">Update</a>
                                                        <a class="dropdown-item tx-danger" data-toggle="modal" href="javascript:void(0)" onclick="delete_one_category({{$review->id}},'{{$review->product_id}}')">Delete</a>
                                                    </div>
                                                </nav>
                                            @endif
                                        @endif
                                    </td>
                                </tr>
                                @empty
                                    <tr>
                                        <th colspan="6" style="text-align: center;"> <p class="text-danger">No reviews found.</p></th>
                                    </tr>
                                @endforelse
                                </tbody>
                            </table>
                        </div>
                        <!-- table-responsive -->
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mg-t-5">
                        @if ($reviews->firstItem() == null)
                            <p class="tx-gray-400 tx-12 d-inline">{{__('common.showing_zero_items')}}</p>
                        @else
                            <p class="tx-gray-400 tx-12 d-inline">Showing {{ $reviews->firstItem() }} to {{ $reviews->lastItem() }} of {{ $reviews->total() }} items</p>
                        @endif
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="text-md-right float-md-right mg-t-5">
                        <div>
                            {{ $reviews->appends((array) $filter)->links() }}
                        </div>
                    </div>
                </div>
            </div>
            <!-- row -->
        </div>
        <!-- container -->
    </div>


    <form action="" id="posting_form" style="display:none;" method="post">
        @csrf
        <input type="text" id="pages" name="pages">
        <input type="text" id="status" name="status">
    </form>

    <!-- Modal -->
    <div class="modal effect-scale" id="prompt-update-review" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalCenterTitle">Update Review</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="editForm" method="POST" action="">
                        @csrf
                        @method('POST')
                        <div class="table-responsive">
                            <table class="table table-borderless table-sm">
                                <tbody>
                                <tr>
                                    <th scope="row" width="200">Product Name</th>
                                    <td><span name="product" id="viewProduct"></span></td>
                                </tr>
                                <tr>
                                    <th scope="row" width="200">Customer Name</th>
                                    <td><span name="user" id="viewUser"></span></td>
                                </tr>
                                <tr>
                                    <th scope="row" width="200">Member</th>
                                    <td><span name="member" id="viewMember"></span></td>
                                </tr>
                                <tr>
                                    <th scope="row" width="200">Star Rating</th>
                                    <td><span name="rating" id="viewRating"></span></td>
                                </tr>
                                <tr>
                                    <th scope="row">Review Summary</th>
                                    <td><span name="review" id="viewReview"></span></td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Back</button>
                    <input type="hidden" name="viewId" id="viewId">
{{--                    <button type="button" class="btn btn-sm btn-primary" id="editStatus" ><span id="viewStatus"></span></button>--}}
                    <a class="btn btn-sm btn-primary"  href="javascript:void(0)" onclick="change_approve('Approve')" id="editStatus"><span id="viewStatus"></span></a>
                </div>
            </div>
        </div>
    </div>

    <div class="modal effect-scale" id="prompt-delete" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalCenterTitle">{{__('common.delete_confirmation_title')}}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>{{__('common.delete_confirmation')}}</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-danger" id="btnDelete">Yes, Delete</button>
                    <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal effect-scale" id="prompt-multiple-delete" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalCenterTitle">{{__('common.delete_mutiple_confirmation_title')}}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    {{__('common.delete_mutiple_confirmation')}}
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-danger" id="btnDeleteMultiple">Yes, Delete</button>
                    <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal effect-scale" id="prompt-multiple-approve" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalCenterTitle">{{__('common.update_confirmation_title')}}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    You are about to <span id="productStatus"></span> this item. Do you want to continue?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-danger" id="btnUpdateStatus">Yes, Update</button>
                    <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal effect-scale" id="prompt-no-selected" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalCenterTitle">{{__('common.no_selected_title')}}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>{{__('common.no_selected')}}</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>


    <!-- Modal -->
@endsection

@section('pagejs')
    <script src="{{ asset('lib/bselect/dist/js/bootstrap-select.js') }}"></script>
    <script src="{{ asset('lib/bselect/dist/js/i18n/defaults-en_US.js') }}"></script>
    <script src="{{ asset('lib/ion-rangeslider/js/ion.rangeSlider.min.js') }}"></script>
    <script>

    </script>
    <script src="{{ asset('js/listing.js') }}"></script>
    <script>

        function post_form(url,status,pages){
            $('#posting_form').attr('action',url);
            $('#pages').val(pages);
            $('#status').val(status);
            $('#posting_form').submit();
        }

        function delete_one_category(id,page){
            $('#prompt-update-review').modal('hide');
            $('#prompt-delete').modal('show');
            $('#btnDelete').on('click', function() {
                post_form('{{route('product-review.delete')}}','',id);
            });
        }

        $('#btnDeleteMany').on('click', function () {
            $('#reviewIds').val(ids);
            $('#reviewsForm').submit();
        });

        let selected_pages = '';
        function delete_review(){
            var counter = 0;
            $(".cb:checked").each(function(){
                counter++;
                fid = $(this).attr('id');
                selected_pages += fid.substring(2, fid.length)+'|';
            });

            if(parseInt(counter) < 1){
                $('#prompt-no-selected').modal('show');
                return false;
            }
            else{
                $('#prompt-multiple-delete').modal('show');
            }
        }

        $('#btnDeleteMultiple').on('click', function() {
            post_form('{{route('product-review.delete')}}','',selected_pages);
        });

        // $("#checkbox_all").click(function(){
        //     $('.cb').not(this).prop('checked', this.checked);
        // });

        let selected_reviews = '';
        let new_status = '';
        function change_status(status){
            new_status = status;
            var counter = 0;
            selected_reviews = '';
            $(".cb:checked").each(function(){
                counter++;
                fid = $(this).attr('id');
                selected_reviews += fid.substring(2, fid.length)+'|';
            });
            if(parseInt(counter) < 1){
                $('#prompt-no-selected').modal('show');
                return false;
            }
            else{
                if(parseInt(counter)>1){ // ask for confirmation when multiple pages was selected
                    $('#productStatus').html(status)
                    $('#prompt-multiple-approve').modal('show');

                    $('#btnUpdateStatus').on('click', function() {
                        post_form("{{route('product-review.change_status')}}",status,selected_reviews);
                    });
                }
                else{
                    post_form("{{route('product-review.change_status')}}",status,selected_reviews);
                }
            }
        }

        function change_approve(status){
            let id = $('#viewId').val();
            post_form("{{route('product-review.change_status')}}",status,id);

        }

    </script>
@endsection
