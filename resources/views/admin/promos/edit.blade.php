@extends('admin.layouts.app')

@section('pagecss')
    <link href="{{ asset('lib/bselect/dist/css/bootstrap-select.css') }}" rel="stylesheet">
    <link href="{{ asset('lib/prismjs/themes/prism-vs.css') }}" rel="stylesheet">
    <link href="{{ asset('lib/datextime/daterangepicker.css') }}" rel="stylesheet">

    <link href="{{ asset('lib/select2/css/select2.min.css') }}" rel="stylesheet">
    <style>
        .table td {
            padding: 0 0px;
        }
    </style>

@endsection

@section('content')
<div class="container pd-x-0">
    <div class="d-sm-flex justify-content-between mg-b-20 mg-lg-b-25 mg-xl-b-30">
        <div>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb breadcrumb-style1 mg-b-10">
                    <li class="breadcrumb-item" aria-current="page">CMS</li>
                    <li class="breadcrumb-item" aria-current="page">Promos</li>
                    <li class="breadcrumb-item active" aria-current="page">Edit a Promo</li>
                </ol>
            </nav>
            <h4 class="mg-b-0 tx-spacing--1">Edit a Promo</h4>
        </div>
    </div>
    <form autocomplete="off" action="{{ route('promos.update',$promo->id) }}" method="post" id="promo_form">
        @csrf
        @method('PUT')
        <div class="row row-sm">
            <div class="col-lg-6">
                <div class="form-group">
                    <label class="d-block">Name*</label>
                    <input required type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name',$promo->name) }}" maxlength="150">
                    @hasError(['inputName' => 'name'])
                    @endhasError
                </div>
                <div class="form-row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="d-block">Promotion Date & Time*</label>
                            <input required type="text" name="promotion_dt" class="form-control wd-100p @error('promotion_dt') is-invalid @enderror" placeholder="Choose date range" id="date1" value="{{ date('Y-m-d H:i',strtotime($promo->promo_start)) }} - {{ date('Y-m-d H:i',strtotime($promo->promo_end)) }}">
                            @hasError(['inputName' => 'promotion_dt'])
                            @endhasError
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label>Discount (%)*</label>
                    <input required name="discount" id="discount" value="{{ old('discount',$promo->discount) }}" type="number" class="form-control @error('discount') is-invalid @enderror" max="100" min="1">
                    @hasError(['inputName' => 'discount'])
                    @endhasError
                </div>

                <div class="form-group">
                    <label class="d-block">Status</label>
                    <div class="custom-control custom-switch @error('status') is-invalid @enderror">
                        <input type="checkbox" class="custom-control-input" name="status" {{ (old("status") == "ON" || $promo->status == "ACTIVE" ? "checked":"") }} id="customSwitch1">
                        <label class="custom-control-label" id="label_visibility" for="customSwitch1">{{ucfirst(strtolower($promo->status))}}</label>
                    </div>
                    @hasError(['inputName' => 'status'])
                    @endhasError
                </div>

                <div class="form-group">
                    <label>Type *</label>
                    <select class="form-control" name="type" required id="type" onchange="promo_type();">
                        <option disabled value="">Choose One</option>
                        <option @if($promo->type == 'brand') selected @endif value="brand">Brand</option>
                        <option @if($promo->type == 'category') selected @endif value="category">Category</option>
                    </select>
                </div>

                <div style="display: @if($promo->type == 'brand') block @else none; @endif" id="tbl_brand">
                    <div class="access-table-head" id="div_brand">
                        <div class="table-responsive-lg text-nowrap">
                            <table class="table table-borderless" style="width:100%;">
                                <thead>
                                <tr>
                                    <td width="50%"><strong>Select Brands</strong></td>
                                </tr>
                                </thead>
                            </table>
                        </div>
                    </div>

                    <table class="table table-hover" style="width:100%;">
                        <thead></thead>
                        <tbody>
                        @foreach($brands as $brand)
                            @php
                                $pproducts = 0;
                                $products = \App\EcommerceModel\Product::where('status','PUBLISHED')->where('brand',$brand->brand)->get();
                                foreach($products as $p){
                                    $pproducts += \App\EcommerceModel\PromoProducts::where('promo_id',$promo->id)->where('product_id',$p->id)->count();   
                                }
                            @endphp

                            @if(count($products))
                                <tr>
                                    <td width="50%"><p class="mg-0 pd-t-5 pd-b-5 tx-uppercase tx-semibold tx-primary">{{ $brand->brand }}</p></td>
                                    <td class="text-right">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" value="{{ $brand->brand }}" class="custom-control-input cb_brand" data-toggle="collapse" data-target="#product_brands{{str_replace(' ','_',$brand->brand) }}" id="ptoggleBrand{{str_replace(' ','_',$brand->brand) }}" @if($pproducts > 0) checked @endif>
                                            
                                            <label class="custom-control-label" for="ptoggleBrand{{str_replace(' ','_',$brand->brand) }}"></label>
                                        </div>
                                    </td>
                                </tr>

                                <tr>
                                    <td colspan="8" class="hiddenRow">
                                        <div class="accordian-body collapse @if($pproducts>0) show @endif" id="product_brands{{str_replace(' ','_',$brand->brand) }}">
                                            <div class="autoship-table">
                                                <div class="mg-b-10">
                                                    <table class="table">
                                                        <thead></thead>
                                                        <tbody>
                                                            @forelse($products as $product)
                                                                @php
                                                                    $exist = \App\EcommerceModel\PromoProducts::where('promo_id',$promo->id)->where('product_id',$product->id)->count();
                                                                @endphp
                                                                <tr>
                                                                    <td>{{ $product->name }}</td>
                                                                    <td class="text-right">
                                                                        <div class="custom-control custom-checkbox">
                                                                            <input type="checkbox" name="brand[]" value="{{$product->id}}" class="custom-control-input cbbrand" id="pbrand{{$product->id}}" @if($exist > 0) checked @endif>
                                                                            <label class="custom-control-label" for="pbrand{{$product->id}}"></label>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                            @empty
                                                                <tr><td colspan="2">No Products</td></tr>
                                                            @endforelse
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endif
                        @endforeach
                        </tbody>
                    </table>
                </div>

                <div style="display: @if($promo->type == 'category') block @else none; @endif;" id="tbl_product">
                    <div class="access-table-head" id="div_products">
                        <div class="table-responsive-lg text-nowrap">
                            <table class="table table-borderless" style="width:100%;">
                                <thead>
                                <tr>
                                    <td width="50%"><strong>Select Categories</strong></td>
                                </tr>
                                </thead>
                            </table>
                        </div>
                    </div>

                    <table class="table table-hover" style="width:100%;">
                        <thead>
                            
                        </thead>
                        <tbody>
                        @foreach($categories as $category)
                            @if(count($category->published_products) > 0)
                                @php
                                    $cproducts = 0;
                                    $products = \App\EcommerceModel\Product::where('status','PUBLISHED')->where('category_id',$category->id)->get();
                                    foreach($products as $p){
                                        $cproducts += \App\EcommerceModel\PromoProducts::where('promo_id',$promo->id)->where('product_id',$p->id)->count();
                                    }
                                @endphp
                                <tr>
                                    <td width="50%"><p class="mg-0 pd-t-5 pd-b-5 tx-uppercase tx-semibold tx-primary">{{ $category->name }}</p></td>
                                    <td class="text-right">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input category" data-toggle="collapse" data-target="#product_category{{$category->id}}"  id="cat{{$category->id}}" @if($cproducts>0) checked @endif>
                                            <label class="custom-control-label" for="cat{{$category->id}}"></label>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2" class="hiddenRow">
                                        <div class="accordian-body collapse @if($cproducts>0) show @endif" id="product_category{{$category->id}}">
                                            <div>
                                                <table class="table" cellpadding="0">
                                                    <thead></thead>
                                                    <tbody>
                                                        @forelse($products as $product)
                                                            @php
                                                                $exist = \App\EcommerceModel\PromoProducts::where('promo_id',$promo->id)->where('product_id',$product->id)->count();
                                                            @endphp
                                                            <tr>
                                                                <td>{{ $product->name }}</td>
                                                                <td class="text-right">
                                                                    <div class="custom-control custom-checkbox">
                                                                        <input type="checkbox" name="productid[]" value="{{$product->id}}" class="custom-control-input cb" id="pcategory{{$product->id}}" @if($exist>0) checked @endif>
                                                                        <label class="custom-control-label" for="pcategory{{$product->id}}"></label>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                            @empty
                                                            <tr><td colspan="2">No Products</td></tr>
                                                        @endforelse
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endif
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="col-lg-12 mg-t-20 mg-b-30">
                <button class="btn btn-primary btn-sm btn-uppercase" type="submit">Update Promo</button>
                <a href="{{ route('promos.index') }}" class="btn btn-outline-secondary btn-sm btn-uppercase">Cancel</a>
            </div>
        </div>
    </form>
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
                <p>{{__('common.no_product_selected')}}</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('pagejs')
    <script src="{{ asset('lib/jqueryui/jquery-ui.min.js') }}"></script>
    <script src="{{ asset('lib/bselect/dist/js/bootstrap-select.js') }}"></script>

    <script src="{{ asset('lib/datextime/moment.min.js') }}"></script>
    <script src="{{ asset('lib/datextime/daterangepicker.js') }}"></script>
    <script src="{{ asset('lib/select2/js/select2.min.js') }}"></script>

    <script>
        var dateToday = new Date(); 

        $(function(){
            'use strict'

            $('#date1').daterangepicker({
                autoUpdateInput: false,
                timePicker: true,
                locale: {
                    format: 'MM/DD/YYYY h:mm A',
                    cancelLabel: 'Clear'
                },
                minDate: dateToday,
            });

            $('input[name="promotion_dt"]').on('apply.daterangepicker', function(ev, picker) {
                $(this).val(picker.startDate.format('YYYY-MM-DD H:mm') + ' - ' + picker.endDate.format('YYYY-MM-DD H:mm'));
            });

            $('input[name="promotion_dt"]').on('cancel.daterangepicker', function(ev, picker) {
                $(this).val('');
            });
        });

        $("#customSwitch1").change(function() {
            if(this.checked) {
                $('#label_visibility').html('Active');
            }
            else{
                $('#label_visibility').html('Inactive');
            }
        });
    </script>
@endsection

@section('customjs')
    <script>
        function promo_type(){
            var val = $('#type').val();

            if(val == 'brand'){
                $('#tbl_brand').css('display','block');
                $('#tbl_product').css('display','none');
            }

            if(val == 'category'){
                $('#tbl_brand').css('display','none');
                $('#tbl_product').css('display','block');
            }
        }

        $('#promo_form').submit(function(){
            var val = $('#type').val();
            if(val == 'category'){
                if(!$("input[name='productid[]']:checked").val()) {        
                    $('#prompt-no-selected').modal('show');
                    return false;
                } else {
                    return true;
                }
            } else {
                if(!$("input[name='brand[]']:checked").val()) {        
                    $('#prompt-no-selected').modal('show');
                    return false;
                } else {
                    return true;
                }
            }
            
        });

        /** form validations **/
        $(document).ready(function () {
            //called when key is pressed in textbox
            $("#discount").keypress(function (e) {
                //if the letter is not digit then display error and don't type anything
                var charCode = (e.which) ? e.which : event.keyCode
                if (charCode != 43 && charCode > 31 && (charCode < 48 || charCode > 57))
                    return false;
                return true;

            });
        });
    </script>
@endsection