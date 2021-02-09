@extends('admin.layouts.app')

@section('pagecss')
	<link href="{{ asset('lib/bselect/dist/css/bootstrap-select.css') }}" rel="stylesheet">
	<link href="{{ asset('lib/clockpicker/bootstrap-clockpicker.min.css') }}" rel="stylesheet">
	<link href="{{ asset('lib/select2/css/select2.min.css') }}" rel="stylesheet">
	<style>
		.select2 {width:100% !important;}

		.select2-container--default .select2-selection--multiple .select2-selection__choice{
			position: relative;
		    margin-top: 4px;
		    margin-right: 4px;
		    padding: 3px 10px 3px 20px;
		    border-color: transparent;
		    border-radius: 1px;
		    background-color: #0168fa;
		    color: #fff;
		    font-size: 13px;
		    line-height: 1.45;
		}

		.select2-container--default .select2-selection--multiple .select2-selection__choice__remove{
			color: #fff;
		    opacity: .5;
		    font-size: 14px;
		    font-weight: 400;
		    display: inline-block;
		    position: absolute;
		    top: 4px;
		    left: 7px;
		    line-height: 1.2;
		}
	</style>
@endsection

@section('content')
<div class="container pd-x-0">
	<div class="d-sm-flex align-items-center justify-content-between mg-b-20 mg-lg-b-25 mg-xl-b-30">
		<div>
			<nav aria-label="breadcrumb">
				<ol class="breadcrumb breadcrumb-style1 mg-b-10">
					<li class="breadcrumb-item" aria-current="page">CMS</li>
					<li class="breadcrumb-item" aria-current="page">Coupons</li>
					<li class="breadcrumb-item active" aria-current="page">Edit Coupon</li>
				</ol>
			</nav>
			<h4 class="mg-b-0 tx-spacing--1">Edit Coupon</h4>
		</div>
	</div>

	<form method="post" action="{{ route('coupons.update',$coupon->id) }}" id="couponForm">
		@csrf
		@method('PUT')
		<div class="row row-sm">
			<div class="col-lg-6">
				<div class="form-group">
					<label class="d-block">Name *</label>
					<input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name',$coupon->name) }}">
					@hasError(['inputName' => 'name'])
                    @endhasError
				</div>
				<div class="form-group">
					<label class="d-block">Description *</label>
					<textarea name="description" rows="3" class="form-control @error('description') is-invalid @enderror">{{ old('description',$coupon->description) }}</textarea>
					@hasError(['inputName' => 'description'])
                    @endhasError
				</div>
				<div class="form-group">
					<label class="d-block">Terms and Conditions</label>
					<textarea name="terms" rows="3" class="form-control">{{ old('terms',$coupon->terms_and_conditions) }}</textarea>
				</div>
				<div class="form-group">
					<label class="d-block">Activation Type</label>
					<div class="row">
						<div class="col-6">
							<div class="custom-control custom-radio">
								<input type="radio" id="coupon-activate-manual" name="coupon_activation[]" class="custom-control-input" value="manual" @if(is_array(old('coupon_activation')) && in_array('manual', old('coupon_activation')) || $coupon->activation_type == 'manual') checked @else checked @endif>
								<label class="custom-control-label" for="coupon-activate-manual">Manual</label>
							</div>
						</div>
						<div class="col-6">
							<div class="custom-control custom-radio">
								<input type="radio" id="coupon-activate-auto" name="coupon_activation[]" class="custom-control-input" value="auto"  @if(is_array(old('coupon_activation')) && in_array('auto', old('coupon_activation')) || $coupon->activation_type == 'auto') checked @endif>
								<label class="custom-control-label" for="coupon-activate-auto">Automatic</label>
							</div>
						</div>
					</div>
				</div>
				<div class="form-group">
					<label class="d-block">Customer Scope</label>
					<div class="row">
						<div class="col-6">
							<div class="custom-control custom-radio">
								<input type="radio" id="coupon-scope-all" name="coupon_scope" class="custom-control-input" value="all" @if($coupon->customer_scope == 'all') checked @endif>
								<label class="custom-control-label" for="coupon-scope-all">All</label>
							</div>
						</div>
						<div class="col-6">
							<div class="custom-control custom-radio">
								<input type="radio" id="coupon-scope-specific" name="coupon_scope" class="custom-control-input" value="specific" @if($coupon->customer_scope == 'specific') checked @endif>
								<label class="custom-control-label" for="coupon-scope-specific">Specific</label>
							</div>
						</div>
					</div>
				</div>
				<div class="form-group">
					<label class="d-block">Reward</label>
					<select class="custom-select @error('reward') is-invalid @enderror" id="reward-optn" name="reward">
						<option @if(isset($coupon->location)) selected @endif value="free-shipping-optn">Free Shipping</option>
						<option @if(isset($coupon->amount) )selected @endif value="discount-amount-optn">Discount Amount</option>
						<option @if(isset($coupon->percentage)) selected @endif value="discount-percentage-optn">Discount Percentage</option>
						<option @if(isset($coupon->gift_name)) selected @endif value="free-gift-optn">Free Gift</option>
						<option @if(isset($coupon->free_product_id)) selected @endif value="free-product-optn">Free Product</option>
						<option @if(isset($coupon->upgrade_product_id)) selected @endif value="product-upgrade-optn">Product upgrade</option>
						<!-- <option value="points-earned-optn">Points Earned</option>
						<option value="upgrade-optn">Upgrade</option> -->
					</select>
					@hasError(['inputName' => 'reward'])
                    @endhasError
				</div>

				<div class="form-group">
					<div class="mb-3 reward-option" id="free-shipping-optn" style="display:@if(isset($coupon->location)) block @else none @endif">
						<label class="d-block">Free Shipping</label>
						<select class="custom-select" name="location">
							<option selected disabled class="text-secondary">Select Areas</option>
							<option @if($coupon->location == 'all') selected @endif value="all">All Areas</option>
							<option @if($coupon->location == 'ncr') selected @endif  value="ncr">NCR</option>
							<option @if($coupon->location == 'local') selected @endif  value="local">Local</option>
							<option @if($coupon->location == 'intl') selected @endif  value="intl">International</option>
						</select>
					</div>

					<div class="mb-3 reward-option" id="discount-amount-optn" style="display:@if(isset($coupon->amount)) block @else none @endif">
						<label class="d-block">Discount amount</label>
						<input name="discount_amount" type="number" class="form-control" value="{{ $coupon->amount }}">
					</div>

					<div class="mb-3 reward-option" id="discount-percentage-optn" style="display:@if(isset($coupon->percentage)) block @else none @endif">
						<label class="d-block">Discount percentage</label>
						<input name="discount_percentage" type="number" class="form-control" value="{{ $coupon->percentage }}">
					</div>

					<div class="mb-3 reward-option" id="free-gift-optn" style="display:@if(isset($coupon->gift_name)) block @else none @endif">
						<label class="d-block">Free gift</label>
						<input name="gift_name" type="text" class="form-control" placeholder="Input box">
					</div>

					<div class="mb-3 reward-option" id="free-product-optn" style="display:@if(isset($coupon->free_product_id)) block @else none @endif">
						<label class="d-block">Free product</label>
						<select class="form-control select2" name="free_product_id" style="min-height: 32px;">
							<option label="Choose one"></option>
							@foreach($products as $product)
								<option value="{{$product->id}}">{{ $product->name }}</option>
							@endforeach
						</select>
					</div>

					<div class="mb-3 reward-option" id="product-upgrade-optn" style="display:@if(isset($coupon->upgrade_product_id)) block @else none @endif">
						<label class="d-block">Product upgrade</label>
						<select class="form-control select2" name="update_product_id" style="min-height: 32px;">
							<option label="Choose one"></option>
							@foreach($products as $product)
								<option value="{{$product->id}}">{{ $product->name }}</option>
							@endforeach
						</select>
					</div>

					<!-- <div class="mb-3 reward-option" id="points-earned-optn" style="display:none">
						<label class="d-block">Points earned</label>
						<div class="input-group border rounded">
							<span class="input-group-btn">
								<button type="button" class="btn btn-default btn-number" disabled="disabled" data-type="minus" data-field="quant[1]">
									<span class="fa fa-minus"></span>
								</button>
							</span>
							<input type="text" name="quant[1]" class="form-control input-number border border-top-0 border-bottom-0" value="1" min="1" max="10">
							<span class="input-group-btn">
								<button type="button" class="btn btn-default btn-number" data-type="plus" data-field="quant[1]">
									<span class="fa fa-plus"></span>
								</button>
							</span>
						</div>
					</div>

					<div class="mb-3 reward-option" id="upgrade-optn" style="display:none">
						<label class="d-block">Rebate Amount</label>
						<input type="text" class="form-control" placeholder="Input box">
					</div> -->
					<hr>
				</div>


				<br>
				<h4 class="mg-b-0 tx-spacing--1">Coupon Settings</h4>
				<hr>

				<div class="form-group">
					<div class="custom-control custom-checkbox">
						<input type="checkbox" class="custom-control-input" id="coupon-time" onclick="myFunction()" name="coupon_setting[]" value="time" @if(is_array(old('coupon_setting')) && in_array('time', old('coupon_setting')) || isset($coupon->start_date) || isset($coupon->event_name)) checked @endif>
						<label class="custom-control-label" for="coupon-time"> Time </label>
					</div>
				</div>

				<div class="form-row border rounded p-3 pt-4 mb-4" id="coupon-time-option" style="display:@if(is_array(old('coupon_time')) && in_array('datetime', old('coupon_time')) || is_array(old('coupon_time')) && in_array('custom', old('coupon_time')) || isset($coupon->start_date) || isset($coupon->event_name)) flex @else none @endif;">
					<div class="col-md-3">
						<div class="custom-control custom-radio">
							<input type="radio" id="coupon-date-time" name="coupon_time[]" class="custom-control-input" onclick="ShowHideDiv()" value="datetime" @if(is_array(old('coupon_time')) && in_array('datetime', old('coupon_time')) || isset($coupon->start_date)) checked @endif>
							<label class="custom-control-label" for="coupon-date-time">Date and Time</label>
						</div>
					</div>
					<!-- <div class="col-md-3">
						<div class="custom-control custom-radio">
							<input type="radio" id="coupon-calendar" name="coupon-time" class="custom-control-input" onclick="ShowHideDiv()">
							<label class="custom-control-label" for="coupon-calendar">Calendar</label>
						</div>
					</div>
					<div class="col-md-3">
						<div class="custom-control custom-radio">
							<input type="radio" id="coupon-holiday" name="coupon-time" class="custom-control-input" onclick="ShowHideDiv()">
							<label class="custom-control-label" for="coupon-holiday">Holiday</label>
						</div>
					</div> -->
					<div class="col-md-3">
						<div class="custom-control custom-radio">
							<input type="radio" id="coupon-custom" name="coupon_time[]" class="custom-control-input" onclick="ShowHideDiv()" value="custom" @if(is_array(old('coupon_time')) && in_array('custom', old('coupon_time')) || isset($coupon->event_name)) checked @endif>
							<label class="custom-control-label" for="coupon-custom">Custom</label>
						</div>
					</div>

					<div class="col-12" id="coupon-date-time-form" style="display:@if(is_array(old('coupon_time')) && in_array('datetime', old('coupon_time')) || isset($coupon->start_date)) block @else none @endif;">
						<div class="row mt-3">
							<div class="col-6">
								<label class="d-block">Start Date *</label>
								<input name="startdate" type="text" id="dateFrom" class="form-control" placeholder="From" autocomplete="off" value="{{ old('startdate',$coupon->start_date) }}">
								<small id="spanDatefrom" style="display: none;" class="text-danger"></small>
							</div>
							<div class="col-6">
								<label class="d-block">End Date</label>
								<input name="enddate" type="text" id="dateTo" class="form-control" placeholder="To" autocomplete="off" value="{{ old('enddate',$coupon->end_date) }}">
							</div>
						</div>

						<div class="row mt-3">
							<div class="col-6">
								<label class="d-block">Start Time</label>
								<div class="input-group datetime">
									<input name="starttime" type="text" class="form-control" autocomplete="off" value="{{ old('starttime',$coupon->start_time) }}">
									<span class="input-group-addon">
										<span class="glyphicon glyphicon-time"></span>
									</span>
								</div>
							</div>
							<div class="col-6">
								<label class="d-block">End Time</label>
								<div class="input-group datetime">
									<input name="endtime" type="text" class="form-control" autocomplete="off" value="{{ old('endtime',$coupon->end_time) }}">
									<span class="input-group-addon">
										<span class="glyphicon glyphicon-time"></span>
									</span>
								</div>
							</div>
						</div>
					</div>

					<!-- <div class="col-12" id="coupon-calendar-form" style="display:none;">
						<div class="row mt-3">
							<div class="col-md-4">
								<label class="d-block">Day</label>
								<select class="custom-select">
									<option selected disabled class="text-secondary">Select Day</option>
									<option value="1">Sunday</option>
									<option value="2">Monday</option>
									<option value="3">Tuesday</option>
									<option value="3">Wednesday</option>
									<option value="3">Thursday</option>
									<option value="3">Friday</option>
									<option value="3">Saturday</option>
								</select>
							</div>

							<div class="col-md-4">
								<label class="d-block">Week</label>
								<select class="custom-select">
									<option selected disabled class="text-secondary">Select Week</option>
									<option value="1">1st</option>
									<option value="2">2nd</option>
									<option value="3">3rd</option>
									<option value="3">4th</option>
								</select>
							</div>

							<div class="col-md-4">
								<label class="d-block">Month</label>
								<select class="custom-select">
									<option selected disabled class="text-secondary">Select Month</option>
									<option value="1">January</option>
									<option value="2">February</option>
									<option value="3">March</option>
									<option value="3">April</option>
									<option value="3">May</option>
									<option value="3">June</option>
									<option value="3">July</option>
									<option value="3">August</option>
									<option value="3">September</option>
									<option value="3">October</option>
									<option value="3">November</option>
									<option value="3">December</option>
								</select>
							</div>
						</div>
					</div>

					<div class="col-12" id="coupon-holiday-form" style="display:none;">
						<div class="row mt-3">
							<div class="col-md-6">
								<label class="d-block">Holiday Name</label>
								<select class="custom-select">
									<option selected disabled class="text-secondary">Select Holiday</option>
									<option value="1">New Year's Day</option>
									<option value="2">Lunar New Year</option>
									<option value="3">Maundy Thursday</option>
									<option value="3">Good Friday</option>
									<option value="3">Bataan Day</option>
									<option value="3">Labour Day</option>
									<option value="3">Eid al-Fitr</option>
									<option value="3">Philippines Independence Day</option>
									<option value="3">Eid al-Adha</option>
									<option value="3">National Heroes' Day</option>
									<option value="3">Bonifacio Day</option>
									<option value="3">Feast of the Immaculate Conception</option>
									<option value="3">Christmas Day</option>
									<option value="3">Rizal Day</option>
								</select>
							</div>
							<div class="col-md-6">
								<label class="d-block">Date</label>
								<input type="text" class="form-control singlecalendar" placeholder="Choose date">
							</div>
						</div>
					</div> -->

					<div class="col-12" id="coupon-custom-form" style="display:@if(is_array(old('coupon_time')) && in_array('custom', old('coupon_time')) || isset($coupon->event_name)) block @else none @endif;">
						<div class="row mt-3">
							<div class="col-md-6">
								<label class="d-block">Event Name *</label>
								<input name="eventname" id="eventname" type="text" class="form-control" autocomplete="off" value="{{ old('eventname',$coupon->event_name) }}">
								<small class="text-danger" style="display: none;" id="spanEventName"></small>
							</div>
							<div class="col-md-6">
								<label class="d-block">Date *</label>
								<input name="eventdate" id="eventdate" type="text" class="form-control singlecalendar" placeholder="Choose date" autocomplete="off" value="{{ old('eventdate',$coupon->event_date) }}">
								<small class="text-danger" style="display: none;" id="spanEventDate"></small>
							</div>
							<div class="col-12 mt-3">
								<div class="custom-control custom-switch">
									<input name="repeat_annually" type="checkbox" {{old("repeat_annually") == "ON" || $coupon->repeat_annually == 1 ? "checked":"" }} class="custom-control-input" id="customSwitch1" >
									<label class="custom-control-label" for="customSwitch1">Repeat Annually</label>
								</div>
							</div>
						</div>
					</div>
				</div>

				<div class="form-group">
					<div class="custom-control custom-checkbox">
						<input type="checkbox" class="custom-control-input" id="coupon-purchase" onclick="myFunction()" name="coupon_setting[]" value="purchase" @if(is_array(old('coupon_setting')) && in_array('purchase', old('coupon_setting')) || isset($coupon->purchase_product_id) || isset($coupon->purchase_product_cat_id) || isset($coupon->purchase_product_brand) || isset($coupon->purchase_amount) || isset($coupon->purchase_qty)) checked @endif>
						<label class="custom-control-label" for="coupon-purchase">Purchase</label>
					</div>
				</div>

				<div class="form-row border rounded p-3 mb-4" id="coupon-purchase-option" style="display:@if(is_array(old('coupon_setting')) && in_array('purchase', old('coupon_setting')) || isset($coupon->purchase_product_id) || isset($coupon->purchase_product_cat_id) || isset($coupon->purchase_product_brand) || isset($coupon->purchase_amount) || isset($coupon->purchase_qty)) flex @else none @endif;">
					<!-- <div class="col-md-3">
						<div class="custom-control custom-radio">
							<input type="radio" id="coupon-frequency" name="coupon-purchase" class="custom-control-input" onclick="ShowHideDiv()">
							<label class="custom-control-label" for="coupon-frequency">Frequency</label>
						</div>
					</div> -->
					<div class="col-md-3">
						<div class="custom-control custom-radio">
							<input type="radio" id="coupon-product" name="coupon_purchase[]" class="custom-control-input" onclick="ShowHideDiv()" value="product" @if(is_array(old('coupon_purchase')) && in_array('product', old('coupon_purchase')) || isset($coupon->purchase_product_id) || isset($coupon->purchase_product_cat_id) || isset($coupon->purchase_product_brand)) checked @endif>
							<label class="custom-control-label" for="coupon-product">Product</label>
						</div>
					</div>
					<div class="col-md-3">
						<div class="custom-control custom-radio">
							<input type="radio" id="coupon-amount" name="coupon_purchase[]" class="custom-control-input" onclick="ShowHideDiv()" value="amount" @if(is_array(old('coupon_purchase')) && in_array('amount', old('coupon_purchase')) || isset($coupon->purchase_amount)) checked @endif>
							<label class="custom-control-label" for="coupon-amount">Amount</label>
						</div>
					</div>
					<div class="col-md-3">
						<div class="custom-control custom-radio">
							<input type="radio" id="coupon-quantity" name="coupon_purchase[]" class="custom-control-input" onclick="ShowHideDiv()" value="qty" @if(is_array(old('coupon_purchase')) && in_array('qty', old('coupon_purchase')) || isset($coupon->purchase_qty)) checked @endif>
							<label class="custom-control-label" for="coupon-quantity">Quantity</label>
						</div>
					</div>

					<div class="col-12 mt-3" id="coupon-frequency-form" style="display:none;">
						<div class="row">
							<div class="col-md-6">
								<label class="d-block">No. of Purchases</label>
								<div class="input-group border rounded">
									<span class="input-group-btn">
										<button type="button" class="btn btn-default btn-number" disabled="disabled" data-type="minus" data-field="quant[1]">
											<span class="fa fa-minus"></span>
										</button>
									</span>
									<input type="text" name="quant[1]" class="form-control input-number border border-top-0 border-bottom-0" value="1" min="1" max="10">
									<span class="input-group-btn">
										<button type="button" class="btn btn-default btn-number" data-type="plus" data-field="quant[1]">
											<span class="fa fa-plus"></span>
										</button>
									</span>
								</div>
							</div>
							<div class="col-md-6">
								<label class="d-block">No. of Reorders</label>
								<div class="input-group border rounded">
									<span class="input-group-btn">
										<button type="button" class="btn btn-default btn-number" disabled="disabled" data-type="minus" data-field="quant[1]">
											<span class="fa fa-minus"></span>
										</button>
									</span>
									<input type="text" name="quant[1]" class="form-control input-number border border-top-0 border-bottom-0" value="1" min="1" max="10">
									<span class="input-group-btn">
										<button type="button" class="btn btn-default btn-number" data-type="plus" data-field="quant[1]">
											<span class="fa fa-plus"></span>
										</button>
									</span>
								</div>
							</div>
						</div>
					</div>

					<div class="col-12 mt-3" id="coupon-product-form" style="display:@if(is_array(old('coupon_purchase')) && in_array('product', old('coupon_purchase')) || isset($coupon->purchase_product_id) || isset($coupon->purchase_product_cat_id) || isset($coupon->purchase_product_brand)) block @else none @endif;">
						<small class="text-danger" style="display: none;" id="spanProductOpt"></small>
						<div class="form-group">
							<label class="d-block">Product Name</label>
							@php
								$arr_products = [];
								$arr_categories = [];
								$arr_brands = [];

								$coupon_products = explode('|',$coupon->purchase_product_id);
								$coupon_categories = explode('|',$coupon->purchase_product_cat_id);
								$coupon_brands = explode('|',$coupon->purchase_product_brand);

								foreach($coupon_products as $cprod){
									array_push($arr_products,$cprod);
								}

								foreach($coupon_categories as $ccat){
									array_push($arr_categories,$ccat);
								}

								foreach($coupon_brands as $cbrand){
									array_push($arr_brands,$cbrand);
								}
							@endphp
							<select class="form-control select2" multiple="multiple" name="product_name[]" id="product_opt">
								<option label="Choose one"></option>
								@foreach($products as $product)
									<option @if(is_array(old('product_name')) && in_array($product->id, old('product_name')) || in_array($product->id,$arr_products)) selected @endif value="{{$product->id}}">{{ $product->name }}</option>
								@endforeach
							</select>
						</div>

						<div class="form-group">
							<label class="d-block">Category</label>
							<select class="form-control select2" multiple="multiple" name="product_category[]" id="category_opt">
								<option label="Choose one"></option>
								@foreach($categories as $category)
									<option @if(is_array(old('product_category')) && in_array($category->id, old('product_category')) || in_array($category->id,$arr_categories)) selected @endif value="{{$category->id}}">{{ $category->name }}</option>
								@endforeach
							</select>
						</div>

						<div class="form-group">
							<label class="d-block">Brand</label>
							<select class="form-control select2" multiple="multiple" name="product_brand[]" id="brand_opt">
								<option label="Choose one"></option>
								@foreach($brands as $brand)
									<option @if(is_array(old('product_brand')) && in_array($brand->brand, old('product_brand')) || in_array($brand->brand,$arr_brands)) selected @endif value="{{$brand->brand}}">{{$brand->brand}}</option>
								@endforeach
							</select>
						</div>
					</div>

					<div class="col-12 mt-3" id="coupon-amount-form" style="display:@if(is_array(old('coupon_purchase')) && in_array('amount', old('coupon_purchase')) || isset($coupon->purchase_amount)) block @else none @endif;">
						<div class="row">
							<div class="col-12">
								<label class="d-block">Amount *</label>
							</div>
							<div class="col-md-6">
								<input name="purchase_amount" id="purchase_amount" type="number" min="1" class="form-control" value="{{ old('purchase_amount',$coupon->purchase_amount) }}">
								<small id="spanPurchaseAmount" style="display: none;" class="text-danger"></small>
							</div>
							<div class="col-md-6">
								<select class="custom-select" name="amount_opt" id="amount_opt">
									<option selected value="">Open this select menu</option>
									<option @if(old('amount_opt') == 'min' || $coupon->purchase_amount_type == 'min') selected @endif value="min">Minimum</option>
									<option @if(old('amount_opt') == 'max' || $coupon->purchase_amount_type == 'max') selected @endif value="max">Maximum</option>
									<option @if(old('amount_opt') == 'exact' || $coupon->purchase_amount_type == 'exact') selected @endif value="exact">Exact</option>
								</select>
								<small id="spanAmountOpt" style="display: none;" class="text-danger"></small>
							</div>
						</div>
					</div>

					<div class="col-12 mt-3" id="coupon-quantity-form" style="display:@if(is_array(old('coupon_purchase')) && in_array('qty', old('coupon_purchase')) || isset($coupon->purchase_qty)) block @else none @endif;">
						<div class="row">
							<div class="col-12">
								<label class="d-block">Quantity *</label>
							</div>
							<div class="col-md-6">
								<input name="purchase_qty" id="purchase_qty" type="number" min="1" class="form-control" value="{{ old('purchase_qty',$coupon->purchase_qty) }}">
								<small id="spanPurchaseQty" style="display: none;" class="text-danger"></small>
							</div>
							<div class="col-md-6">
								<select class="custom-select" name="qty_opt" id="qty_opt">
									<option selected value="">Open this select menu</option>
									<option @if(old('qty_opt') == 'min' || $coupon->purchase_qty_type == 'min') selected @endif value="min">Minimum</option>
									<option @if(old('qty_opt') == 'max' || $coupon->purchase_qty_type == 'max') selected @endif value="max">Maximum</option>
									<option @if(old('qty_opt') == 'exact' || $coupon->purchase_qty_type == 'exact') selected @endif value="exact">Exact</option>
								</select>
								<small id="spanQtyOpt" style="display: none;" class="text-danger"></small>
							</div>
						</div>
					</div>
				</div>

				<div class="form-group">
					<div class="custom-control custom-checkbox">
						<input type="checkbox" class="custom-control-input" id="coupon-activity" onclick="myFunction()" name="coupon_setting[]" value="activity" @if(is_array(old('coupon_setting')) && in_array('activity', old('coupon_setting')) || isset($coupon->activity_type)) checked @endif>
						<label class="custom-control-label" for="coupon-activity">Activity</label>
					</div>
				</div>

				<div class="form-row border rounded p-3 mb-4" id="coupon-activity-option" style="display:@if(is_array(old('coupon_setting')) && in_array('activity', old('coupon_setting')) || isset($coupon->activity_type)) flex @else none @endif;">
					<div class="col-12">
						<div class="custom-control custom-radio">
							<input type="radio" id="coupon-product-review" name="coupon_activity[]" class="custom-control-input" onclick="ShowHideDiv()" value="product_review" @if(is_array(old('coupon_activity')) && in_array('product_review', old('coupon_activity')) || $coupon->activity_type == 'product_review') checked @endif>
							<label class="custom-control-label" for="coupon-product-review">Product Review</label>
						</div>
					</div>

					<div class="col-12 mt-1">
						<div class="custom-control custom-radio">
							<input type="radio" id="coupon-cart-abandonment" name="coupon_activity[]" class="custom-control-input" onclick="ShowHideDiv()" value="cart_abandonment" @if(is_array(old('coupon_activity')) && in_array('cart_abandonment', old('coupon_activity')) || $coupon->activity_type == 'cart_abandonment') checked @endif>
							<label class="custom-control-label" for="coupon-cart-abandonment">Cart Abandonment</label>
						</div>
					</div>

					<div class="col-12 mt-1">
						<div class="custom-control custom-radio">
							<input type="radio" id="coupon-returning-customer" name="coupon_activity[]" class="custom-control-input" onclick="ShowHideDiv()" value="returning_customer" @if(is_array(old('coupon_activity')) && in_array('returning_customer', old('coupon_activity')) || $coupon->activity_type == 'returning_customer') checked @endif>
							<label class="custom-control-label" for="coupon-returning-customer">Returning Customer</label>
						</div>

						<div class="mt-3" id="coupon-returning-form" style="display:@if(is_array(old('coupon_activity')) && in_array('returning_customer', old('coupon_activity')) || $coupon->activity_type == 'returning_customer') block @else none @endif;">
							<div class="row">
								<div class="col-md-4">
									<label class="d-block">Minimum inactive time</label>
								</div>
								<div class="col-md-8">
									<div class="input-group border rounded">
										<span class="input-group-btn">
											<button type="button" class="btn btn-default btn-number" disabled="disabled" data-type="minus" data-field="quant[1]">
												<span class="fa fa-minus"></span>
											</button>
										</span>
										<input type="text" name="inactive_no" class="form-control input-number border border-top-0 border-bottom-0" value="{{ old('inactive_no',$coupon->inactive_no) }}" min="1" max="10">
										<span class="input-group-btn">
											<button type="button" class="btn btn-default btn-number" data-type="plus" data-field="quant[1]">
												<span class="fa fa-plus"></span>
											</button>
										</span>
									</div>
								</div>
								<div class="col-md-3 col-6 mt-3">
									<div class="custom-control custom-radio">
										<input type="radio" id="coupon-returning-customer-days" name="coupon_return_customer[]" class="custom-control-input" onclick="ShowHideDiv()" value="days" @if(is_array(old('coupon_return_customer')) && in_array('days', old('coupon_return_customer')) || $coupon->inactive_type == 'days') checked @else checked @endif>
										<label class="custom-control-label" for="coupon-returning-customer-days">Days</label>
									</div>
								</div>
								<div class="col-md-3 col-6 mt-3">
									<div class="custom-control custom-radio">
										<input type="radio" id="coupon-returning-customer-weeks" name="coupon_return_customer[]" class="custom-control-input" onclick="ShowHideDiv()" value="weeks" @if(is_array(old('coupon_return_customer')) && in_array('weeks', old('coupon_return_customer')) || $coupon->inactive_type == 'weeks') checked @endif>
										<label class="custom-control-label" for="coupon-returning-customer-weeks">Weeks</label>
									</div>
								</div>
								<div class="col-md-3 col-6 mt-3">
									<div class="custom-control custom-radio">
										<input type="radio" id="coupon-returning-customer-months" name="coupon_return_customer[]" class="custom-control-input" onclick="ShowHideDiv()" value="months" @if(is_array(old('coupon_return_customer')) && in_array('months', old('coupon_return_customer')) || $coupon->inactive_type == 'months') checked @endif>
										<label class="custom-control-label" for="coupon-returning-customer-months">Months</label>
									</div>
								</div>
								<div class="col-md-3 col-6 mt-3">
									<div class="custom-control custom-radio">
										<input type="radio" id="coupon-returning-customer-years" name="coupon_return_customer[]" class="custom-control-input" onclick="ShowHideDiv()" value="years" @if(is_array(old('coupon_return_customer')) && in_array('years', old('coupon_return_customer')) || $coupon->inactive_type == 'years') checked @endif>
										<label class="custom-control-label" for="coupon-returning-customer-years">Years</label>
									</div>
								</div>
							</div>

							<hr>
						</div>
					</div>

					<div class="col-12 mt-1">
						<div class="custom-control custom-radio">
							<input type="radio" id="coupon-featured-organization" name="coupon_activity[]" class="custom-control-input" onclick="ShowHideDiv()" value="feat_organization" @if(is_array(old('coupon_activity')) && in_array('feat_organization', old('coupon_activity')) || $coupon->activity_type == 'feat_organization') checked @endif>
							<label class="custom-control-label" for="coupon-featured-organization">Featured Organization</label>
						</div>

						<div class="mt-3" id="coupon-featured-form" style="display:@if(is_array(old('coupon_activity')) && in_array('feat_organization', old('coupon_activity')) || $coupon->activity_type == 'feat_organization') block @else none @endif;">
							<label class="d-block">Organization Name *</label>
							<input type="text" class="form-control" name="org_name" id="org_name" value="{{ old('org_name',$coupon->org_name) }}">
							<small id="spanOrgName" class="text-danger" style="display: none;"></small>
							<hr>
						</div>
					</div>

					<div class="col-12 mt-1">
						<div class="custom-control custom-radio">
							<input type="radio" id="coupon-share-social" name="coupon_activity[]" class="custom-control-input" onclick="ShowHideDiv()" value="share_via_social" @if(is_array(old('coupon_activity')) && in_array('share_via_social', old('coupon_activity')) || $coupon->activity_type == 'share_via_social') checked @endif>
							<label class="custom-control-label" for="coupon-share-social">Share Via Social</label>
						</div>
					</div>

					<div class="col-12 mt-1">
						<div class="custom-control custom-radio">
							<input type="radio" id="coupon-wishlist-item" name="coupon_activity[]" class="custom-control-input" onclick="ShowHideDiv()" value="purchase_wishlist_item" @if(is_array(old('coupon_activity')) && in_array('purchase_wishlist_item', old('coupon_activity')) || $coupon->activity_type == 'purchase_wishlist_item') checked @endif>
							<label class="custom-control-label" for="coupon-wishlist-item">Purchase Wishlist Item</label>
						</div>
					</div>

					<div class="col-12 mt-1">
						<div class="custom-control custom-radio">
							<input type="radio" id="coupon-survey" name="coupon_activity[]" class="custom-control-input" onclick="ShowHideDiv()" value="survey" @if(is_array(old('coupon_activity')) && in_array('survey', old('coupon_activity')) || $coupon->activity_type == 'survey') checked @endif>
							<label class="custom-control-label" for="coupon-survey">Survey</label>
						</div>
					</div>

					<div class="col-12 mt-1">
						<div class="custom-control custom-radio">
							<input type="radio" id="coupon-subscribe-mailing-list" name="coupon_activity[]" class="custom-control-input" onclick="ShowHideDiv()" value="subscribe_to_milling_list" @if(is_array(old('coupon_activity')) && in_array('subscribe_to_milling_list', old('coupon_activity')) || $coupon->activity_type == 'subscribe_to_milling_list') checked @endif>
							<label class="custom-control-label" for="coupon-subscribe-mailing-list">Subscribe to Mailing List</label>
						</div>
					</div>

					<div class="col-12 mt-1">
						<div class="custom-control custom-radio">
							<input type="radio" id="coupon-refer-friend" name="coupon_activity[]" class="custom-control-input" onclick="ShowHideDiv()" value="refer_a_friend" @if(is_array(old('coupon_activity')) && in_array('refer_a_friend', old('coupon_activity')) || $coupon->activity_type == 'refer_a_friend') checked @endif>
							<label class="custom-control-label" for="coupon-refer-friend">Refer a Friend</label>
						</div>
					</div>

					<div class="col-12 mt-1">
						<div class="custom-control custom-radio">
							<input type="radio" id="coupon-purchase-points" name="coupon_activity[]" class="custom-control-input" onclick="ShowHideDiv()" value="purhcase_via_points" @if(is_array(old('coupon_activity')) && in_array('purhcase_via_points', old('coupon_activity')) || $coupon->activity_type == 'purhcase_via_points') checked @endif>
							<label class="custom-control-label" for="coupon-purchase-points">Purchase via Points</label>
						</div>
					</div>

					<div class="col-12 mt-1">
						<div class="custom-control custom-radio">
							<input type="radio" id="coupon-senior-discounts" name="coupon_activity[]" class="custom-control-input" onclick="ShowHideDiv()" value="senior_pwd_discount" @if(is_array(old('coupon_activity')) && in_array('senior_pwd_discount', old('coupon_activity')) || $coupon->activity_type == 'senior_pwd_discount') checked @endif>
							<label class="custom-control-label" for="coupon-senior-discounts">Senior/PWD Discount</label>
						</div>
					</div>
				</div>

				<div class="form-group">
					<div class="custom-control custom-checkbox">
						<input type="checkbox" class="custom-control-input" id="coupon-rules" onclick="myFunction()" name="coupon_setting[]" value="rule" @if(is_array(old('coupon_setting')) && in_array('rule', old('coupon_setting')) || isset($coupon->customer_limit) || isset($coupon->customer_usage_limit) || isset($coupon->transaction_limit)) checked @endif>
						<label class="custom-control-label" for="coupon-rules">Rules</label>
					</div>
				</div>

				<div class="form-row border rounded p-3" id="coupon-rules-option" style="display:@if(is_array(old('coupon_setting')) && in_array('rule', old('coupon_setting')) || isset($coupon->customer_limit) || isset($coupon->customer_usage_limit) || isset($coupon->transaction_limit)) flex @else none @endif;">
					<div class="col-12">
						<div class="custom-control custom-checkbox">
							<input type="checkbox" class="custom-control-input" id="coupon-customer-limit" name="coupon_rule[]" onclick="myFunction()" value="customer_limit" @if(is_array(old('coupon_rule')) && in_array('customer_limit', old('coupon_rule')) || isset($coupon->customer_limit)) checked @endif>
							<label class="custom-control-label" for="coupon-customer-limit">Customer Limit</label>
						</div>

						<div class="mt-3" id="coupon-customer-limit-form" style="display:@if(is_array(old('coupon_rule')) && in_array('customer_limit', old('coupon_rule')) || isset($coupon->customer_limit)) flex @else none @endif;">
							<div class="input-group border rounded">
								<span class="input-group-btn">
									<button type="button" class="btn btn-default btn-number" disabled="disabled" data-type="minus" data-field="quant[1]">
										<span class="fa fa-minus"></span>
									</button>
								</span>
								<input type="text" name="coupon_customer_limit_qty" class="form-control input-number border border-top-0 border-bottom-0" value="{{ old('coupon_customer_limit_qty',$coupon->customer_limit)}}" min="1" max="10">
								<span class="input-group-btn">
									<button type="button" class="btn btn-default btn-number" data-type="plus" data-field="quant[1]">
										<span class="fa fa-plus"></span>
									</button>
								</span>
							</div>
							<hr>
						</div>
					</div>

					<div class="col-12 mt-3">
						<div class="custom-control custom-checkbox">
							<input type="checkbox" class="custom-control-input" id="coupon-customer-usage" name="coupon_rule[]" onclick="myFunction()" value="usage_limit" @if(is_array(old('coupon_rule')) && in_array('usage_limit', old('coupon_rule')) || isset($coupon->usage_limit)) checked @endif>
							<label class="custom-control-label" for="coupon-customer-usage">Usage Limit</label>
						</div>

						<div class="mt3" id="coupon-customer-usage-form" style="display:@if(is_array(old('coupon_rule')) && in_array('usage_limit', old('coupon_rule')) || isset($coupon->usage_limit)) block @else none @endif;">
							<div class="row">
								<div class="col-md-4 mt-3">
									<div class="custom-control custom-radio">
										<input type="radio" id="coupon-no-limit" name="usage_limit[]" class="custom-control-input" onclick="ShowHideDiv()" value="no_limit" @if(is_array(old('usage_limit')) && in_array('no_limit', old('usage_limit')) || $coupon->usage_limit == 'no_limit') checked @else checked @endif>
										<label class="custom-control-label" for="coupon-no-limit">No Limit</label>
									</div>
								</div>
								<div class="col-md-4 mt-3">
									<div class="custom-control custom-radio">
										<input type="radio" id="coupon-single-use" name="usage_limit[]" class="custom-control-input" onclick="ShowHideDiv()" value="single_use" @if(is_array(old('usage_limit')) && in_array('single_use', old('usage_limit')) || $coupon->usage_limit == 'single_use') checked @endif>
										<label class="custom-control-label" for="coupon-single-use">Single Use</label>
									</div>
								</div>
								<div class="col-md-4 mt-3">
									<div class="custom-control custom-radio">
										<input type="radio" id="coupon-multi-use" name="usage_limit[]" class="custom-control-input" onclick="ShowHideDiv()" value="multiple_use" @if(is_array(old('usage_limit')) && in_array('multiple_use', old('usage_limit')) || $coupon->usage_limit == 'multiple_use') checked @endif>
										<label class="custom-control-label" for="coupon-multi-use">Multi Use</label>
									</div>
								</div>
								<div class="col-12 mt-3" id="coupon-multi-use-form" style="display:@if(is_array(old('usage_limit')) && in_array('multiple_use', old('usage_limit')) || $coupon->usage_limit == 'multiple_use') flex @else none @endif;">
									<div class="input-group border rounded">
										<span class="input-group-btn">
											<button type="button" class="btn btn-default btn-number" disabled="disabled" data-type="minus" data-field="quant[1]">
												<span class="fa fa-minus"></span>
											</button>
										</span>
										<input type="text" name="multi_usage_limit_qty" class="form-control input-number border border-top-0 border-bottom-0" value="{{ old('multi_usage_limit_qty',isset($coupon->usage_limit_no) ? $coupon->usage_limit_no : 1) }}" min="1" max="10">
										<span class="input-group-btn">
											<button type="button" class="btn btn-default btn-number" data-type="plus" data-field="quant[1]">
												<span class="fa fa-plus"></span>
											</button>
										</span>
									</div>
								</div>
								<div class="col-12"><hr></div>
							</div>
						</div>
					</div>

					<div class="col-12 mt-3">
						<div class="custom-control custom-checkbox">
							<input type="checkbox" class="custom-control-input" id="coupon-customer-transaction" name="coupon_rule[]" onclick="myFunction()" value="transaction_limit" @if(is_array(old('coupon_rule')) && in_array('transaction_limit', old('coupon_rule')) || isset($coupon->transaction_limit)) checked @endif>
							<label class="custom-control-label" for="coupon-customer-transaction">Transaction Limit</label>
						</div>

						<div class="mt3" id="coupon-customer-transaction-form" style="display:@if(is_array(old('coupon_rule')) && in_array('transaction_limit', old('coupon_rule')) || isset($coupon->transaction_limit)) block @else none @endif;">
							<div class="row">
								<div class="col-md-6 mt-3">
									<div class="custom-control custom-radio">
										<input type="radio" id="coupon-trans-yes" name="coupon_transac_limit[]" class="custom-control-input" onclick="ShowHideDiv()" value="1" @if(is_array(old('coupon_transac_limit')) && in_array(1, old('coupon_transac_limit')) || $coupon->transaction_limit == 1) checked @else checked @endif>
										<label class="custom-control-label" for="coupon-trans-yes">Yes</label>
									</div>
								</div>
								<div class="col-md-6 mt-3">
									<div class="custom-control custom-radio">
										<input type="radio" id="coupon-trans-no" name="coupon_transac_limit[]" class="custom-control-input" onclick="ShowHideDiv()" value="0" @if(is_array(old('coupon_transac_limit')) && in_array(0, old('coupon_transac_limit')) || $coupon->transaction_limit == 0) checked @endif>
										<label class="custom-control-label" for="coupon-trans-no">No</label>
									</div>
								</div>
								<div class="col-12"><hr></div>
							</div>
						</div>
					</div>

					<!-- <div class="col-12 mt-3">
						<div class="custom-control custom-checkbox">
							<input type="checkbox" class="custom-control-input" id="coupon-customer-amount" onclick="myFunction()">
							<label class="custom-control-label" for="coupon-customer-amount">Amount Limit</label>
						</div>

						<div class="mt3" id="coupon-customer-amount-form" style="display:none;">
							<div class="row">
								<div class="col-12 mt-3">
									<div class="custom-control custom-radio">
										<input type="radio" id="coupon-cust-1" name="coupon-cust-amount" class="custom-control-input" onclick="ShowHideDiv()">
										<label class="custom-control-label" for="coupon-cust-1">Remaining coupon value is disregarded/void.</label>
									</div>
								</div>
								<div class="col-12 mt-3">
									<div class="custom-control custom-radio">
										<input type="radio" id="coupon-cust-2" name="coupon-cust-amount" class="custom-control-input" onclick="ShowHideDiv()">
										<label class="custom-control-label" for="coupon-cust-2">Remaining coupon value is credited and can be used in next purchase.</label>
									</div>
								</div>
							</div>
						</div>
					</div> -->
				</div>

				<hr>
			</div>
			<div class="col-lg-12">
				<div class="form-group">
					<label class="d-block">Status</label>
					<div class="custom-control custom-switch">
						<input type="checkbox" class="custom-control-input" id="enableSwitch1" name="status" {{ (old("status") == "ON" || $coupon->status == "ACTIVE" ? "checked":"") }}>
						<label class="custom-control-label" for="enableSwitch1" id="label_status">{{ucfirst(strtolower($coupon->status))}}</label>
					</div>
				</div>
			</div>

			<div class="col-lg-12 mg-t-30">
				<button class="btn btn-primary btn-sm btn-uppercase" type="button" id="btnSubmit">Update</button>
				<a href="{{ route('coupons.index') }}" class="btn btn-outline-secondary btn-sm btn-uppercase">Cancel</a>
			</div>
		</div>
	</form>
	<!-- row -->
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
                <p id="no_selected_title"></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('pagejs')
	<script src="{{ asset('lib/bselect/dist/js/bootstrap-select.js') }}"></script>
	<script src="{{ asset('lib/bselect/dist/js/i18n/defaults-en_US.js') }}"></script>
	<script src="{{ asset('lib/jqueryui/jquery-ui.min.js') }}"></script>
	<script src="{{ asset('lib/clockpicker/bootstrap-clockpicker.min.js') }}"></script>
	<script src="{{ asset('lib/select2/js/select2.min.js') }}"></script>
@endsection


@section('customjs')
<script>

	$('#btnSubmit').click(function(){

		if(!$("input[name='coupon_setting[]']:checked").val()) {  
				$('#no_selected_title').html('Please select at least one (1) coupon setting.');      
                $('#prompt-no-selected').modal('show');
                return false;
            } else {
            	var rs;
            	$('input[name="coupon_setting[]"]:checked').each(function(){

				   	if(this.value == 'time') {
					   	if(!$("input[name='coupon_time[]']:checked").val()) {
					   		$('#coupon-time-option').addClass('is-invalid');
				   			$('#no_selected_title').html('Please select at least one (1) time option.');      
	            			$('#prompt-no-selected').modal('show');
	            			rs = false;
	            			return false;
					   	} else {
					   		$('#coupon-time-option').removeClass('is-invalid');
					   		var selectedOption = $('input[name="coupon_time[]"]:checked').val();

					   		if(selectedOption == 'datetime'){
					   			var startdate = $('#dateFrom').val();
						   		if(startdate.length === 0){
						   			$('#dateFrom').addClass('is-invalid');
						   			$('#spanDatefrom').css('display','block');
						   			$('#spanDatefrom').html('Start Date field is required.');
						   			rs = false;
	            					return false;
						   		}
					   		}

					   		if(selectedOption == 'custom'){
					   			var eventname = $('#eventname').val();
					   			var eventdate = $('#eventdate').val();

					   			if(eventname.length === 0){
					   				$('#eventname').addClass('is-invalid');
						   			$('#spanEventName').css('display','block');
						   			$('#spanEventName').html('Event name field is required.');
						   			rs = false;
	            					return false;
					   			}

					   			if(eventdate.length === 0){
					   				$('#eventdate').addClass('is-invalid');
						   			$('#spanEventDate').css('display','block');
						   			$('#spanEventDate').html('Event date field is required.');
						   			rs = false;
	            					return false;
					   			}
					   		}

					   		rs = true;
					   	}	
				   	}

				   	if(this.value == 'purchase') {
				   		if(!$("input[name='coupon_purchase[]']:checked").val()) {
				   			$('#coupon-purchase-option').addClass('is-invalid');
				   			$('#no_selected_title').html('Please select at least one (1) purchase option.');      
                			$('#prompt-no-selected').modal('show');
                			rs = false;
	            			return false;
				   		} else {
				   			$('#coupon-purchase-option').removeClass('is-invalid');
				   			var selectedOption = $('input[name="coupon_purchase[]"]:checked').val();

				   			if(selectedOption == 'product'){
				   				var product = $('#product_opt').val();
				   				var category = $('#category_opt').val();
				   				var brand = $('#brand_opt').val();

				   				if(product.length === 0 && category.length === 0 && brand.length === 0){
				   					$('.select2-container').css('border','1px solid red');
				   					$('.select2-container').css('border-radius','0.25rem');
				   					$('#spanProductOpt').css('display','block');
				   					$('#spanProductOpt').html('Please select at least one(1) option.');
				   					rs = false;
	            					return false;
				   				}

				   				rs = true;
				   			}

				   			if(selectedOption == 'amount'){
				   				var amount = $('#purchase_amount').val();
						   		var amounttype = $('#amount_opt').val();

						   		if(amount.length === 0){
						   			$('#purchase_amount').addClass('is-invalid');
						   			$('#spanPurchaseAmount').css('display','block');
						   			$('#spanPurchaseAmount').html('Amount field is required.');
						   			rs = false;
	            					return false;
						   		}

						   		if(amounttype.length === 0){
						   			$('#amount_opt').addClass('is-invalid');
						   			$('#spanAmountOpt').css('display','block');
						   			$('#spanAmountOpt').html('Please select one(1) option.');
						   			rs = false;
	            					return false;
						   		}

						   		rs = true;
				   			}

				   			if(selectedOption == 'qty'){
				   				var qty = $('#purchase_qty').val();
						   		var qtytype = $('#qty_opt').val();

						   		if(qty.length === 0){
						   			$('#purchase_qty').addClass('is-invalid');
						   			$('#spanPurchaseQty').css('display','block');
						   			$('#spanPurchaseQty').html('Quantity field is required.');
						   			rs = false;
	            					return false;
						   		}

						   		if(qtytype.length === 0){
						   			$('#qty_opt').addClass('is-invalid');
						   			$('#spanQtyOpt').css('display','block');
						   			$('#spanQtyOpt').html('Please select one(1) option.');
						   			rs = false;
						   			return false;
						   		}
				   			}

				   			rs = true;
				   		}
				   	}

				   	if(this.value == 'activity') {
				   		if(!$("input[name='coupon_activity[]']:checked").val()) {
				   			$('#coupon-activity-option').addClass('is-invalid');
				   			$('#no_selected_title').html('Please select at least one (1) activity.');      
                			$('#prompt-no-selected').modal('show');
                			rs = false;
                			return false;
				   		} else {
				   			$('#coupon-activity-option').removeClass('is-invalid');
				   			var selectedActivity = $('input[name="coupon_activity[]"]:checked').val();

				   			if(selectedActivity == 'feat_organization'){
				   				var org = $('#org_name').val();

				   				if(org.length === 0){
					   				$('#org_name').addClass('is-invalid');
						   			$('#spanOrgName').css('display','block');
						   			$('#spanOrgName').html('Organization name field is required.');	
						   			rs = false;
						   			return false;
				   				}
				   			}

				   			rs = true;
				   		}
				   	}

				   	if(this.value == 'rule') {
				   		if(!$("input[name='coupon_rule[]']:checked").val()) {
				   			$('#coupon-rules-option').addClass('is-invalid');
				   			$('#no_selected_title').html('Please select at least one (1) rule.');      
                			$('#prompt-no-selected').modal('show');
                			rs = false;
                			return false;
				   		} else{
				   			$('#coupon-rules-option').removeClass('is-invalid');
				   			rs = true;
				   		}
				   	}	
				});
				
				if(rs == true){
					$('#couponForm').submit();
				}
            }
	});

	$("#enableSwitch1").change(function() {
        if(this.checked) {
            $('#label_status').html('Active');
        }
        else{
            $('#label_status').html('Inactive');
        }
    });

	$('.datetime').clockpicker();

	$('.singlecalendar').datepicker({
		dateFormat: 'yy-mm-dd'
	});

	var dateToday = new Date(); 
	$('#dateFrom').datepicker({
		dateFormat: 'yy-mm-dd',
		minDate: dateToday,
	});
	$('#dateTo').datepicker({
		dateFormat: 'yy-mm-dd',
		minDate: dateToday,
	});

	$('.select2').select2({
		placeholder: 'Choose Options'
	});

	$('#reward-optn').change(function(){
		$('.reward-option').hide();
		$('#' + $(this).val()).show();
	});

	function myFunction() {
		var checkCouponTime = document.getElementById("coupon-time");
		var fieldCouponOption = document.getElementById("coupon-time-option");
		if (checkCouponTime.checked == true){
			fieldCouponOption.style.display = "flex";
		} else {
			fieldCouponOption.style.display = "none";
		};

		var couponPurchase = document.getElementById("coupon-purchase");
		var fieldCouponOption = document.getElementById("coupon-purchase-option");
		if (couponPurchase.checked == true){
			fieldCouponOption.style.display = "flex";
		} else {
			fieldCouponOption.style.display = "none";
		};

		var couponActivity = document.getElementById("coupon-activity");
		var fieldActivityOption = document.getElementById("coupon-activity-option");
		if (couponActivity.checked == true){
			fieldActivityOption.style.display = "flex";
		} else {
			fieldActivityOption.style.display = "none";
		};

		var couponRules = document.getElementById("coupon-rules");
		var fieldRulesOption = document.getElementById("coupon-rules-option");
		if (couponRules.checked == true){
			fieldRulesOption.style.display = "flex";
		} else {
			fieldRulesOption.style.display = "none";
		};

		var couponCustomerLimit = document.getElementById("coupon-customer-limit");
		var fieldCustomerLimitOption = document.getElementById("coupon-customer-limit-form");
		if (couponCustomerLimit.checked == true){
			fieldCustomerLimitOption.style.display = "block";
		} else {
			fieldCustomerLimitOption.style.display = "none";
		};

		var couponCustomerUsage = document.getElementById("coupon-customer-usage");
		var fieldCustomerUsageOption = document.getElementById("coupon-customer-usage-form");
		if (couponCustomerUsage.checked == true){
			fieldCustomerUsageOption.style.display = "block";
		} else {
			fieldCustomerUsageOption.style.display = "none";
		};

		var couponCustomerTransaction = document.getElementById("coupon-customer-transaction");
		var fieldCustomerTransactionOption = document.getElementById("coupon-customer-transaction-form");
		if (couponCustomerTransaction.checked == true){
			fieldCustomerTransactionOption.style.display = "block";
		} else {
			fieldCustomerTransactionOption.style.display = "none";
		};

		var couponCustomerAmount = document.getElementById("coupon-customer-amount");
		var fieldCustomerAmountOption = document.getElementById("coupon-customer-amount-form");
		if (couponCustomerAmount.checked == true){
			fieldCustomerAmountOption.style.display = "block";
		} else {
			fieldCustomerAmountOption.style.display = "none";
		};
	};

	function ShowHideDiv() {
		var couponDateTime = document.getElementById("coupon-date-time");
		var couponDateTimeForm = document.getElementById("coupon-date-time-form");
		couponDateTimeForm.style.display = couponDateTime.checked ? "block" : "none";

		// var couponCalendar = document.getElementById("coupon-calendar");
		// var couponCalendarForm = document.getElementById("coupon-calendar-form");
		// couponCalendarForm.style.display = couponCalendar.checked ? "block" : "none";

		// var couponHoliday = document.getElementById("coupon-holiday");
		// var couponHolidayForm = document.getElementById("coupon-holiday-form");
		// couponHolidayForm.style.display = couponHoliday.checked ? "block" : "none";

		var couponCustom = document.getElementById("coupon-custom");
		var couponCustomForm = document.getElementById("coupon-custom-form");
		couponCustomForm.style.display = couponCustom.checked ? "block" : "none";

		// var couponFrequency = document.getElementById("coupon-frequency");
		// var couponFrequencyForm = document.getElementById("coupon-frequency-form");
		// couponFrequencyForm.style.display = couponFrequency.checked ? "block" : "none";

		var couponProduct = document.getElementById("coupon-product");
		var couponProductForm = document.getElementById("coupon-product-form");
		couponProductForm.style.display = couponProduct.checked ? "block" : "none";

		var couponAmount = document.getElementById("coupon-amount");
		var couponAmountForm = document.getElementById("coupon-amount-form");
		couponAmountForm.style.display = couponAmount.checked ? "block" : "none";

		var couponQuantity = document.getElementById("coupon-quantity");
		var couponQuantityForm = document.getElementById("coupon-quantity-form");
		couponQuantityForm.style.display = couponQuantity.checked ? "block" : "none";

		var couponReturningCustomer = document.getElementById("coupon-returning-customer");
		var couponReturningCustomerForm = document.getElementById("coupon-returning-form");
		couponReturningCustomerForm.style.display = couponReturningCustomer.checked ? "block" : "none";

		var couponFeaturedOrganization = document.getElementById("coupon-featured-organization");
		var couponFeaturedOrganizationForm = document.getElementById("coupon-featured-form");
		couponFeaturedOrganizationForm.style.display = couponFeaturedOrganization.checked ? "block" : "none";

		var couponMultiUse = document.getElementById("coupon-multi-use");
		var couponMultiUseForm = document.getElementById("coupon-multi-use-form");
		couponMultiUseForm.style.display = couponMultiUse.checked ? "block" : "none";
	};


// Date Picker start --------------------->
// var dateFormat = 'yy-mm-dd',
// from = $('#dateFrom')
// .datepicker({
// 	defaultDate: '+1w',
// 	numberOfMonths: 1
// })
// .on('change', function() {
// 	to.datepicker('option','minDate', getDate( this ) );
// }),
// to = $('#dateTo').datepicker({
// 	defaultDate: '+1w',
// 	numberOfMonths: 1
// })
// .on('change', function() {
// 	from.datepicker('option','maxDate', getDate( this ) );
// });

// function getDate( element ) {
// 	var date;
// 	try {
// 		date = $.datepicker.parseDate( dateFormat, element.value );
// 	} catch( error ) {
// 		date = null;
// 	}

// 	return date;
// }
// Date Picker end --------------------->

// Points Earned start --------------------->
$('.btn-number').click(function(e){
	e.preventDefault();

	fieldName = $(this).attr('data-field');
	type      = $(this).attr('data-type');
	var input = $("input[name='"+fieldName+"']");
	var currentVal = parseInt(input.val());
	if (!isNaN(currentVal)) {
		if(type == 'minus') {

			if(currentVal > input.attr('min')) {
				input.val(currentVal - 1).change();
			} 
			if(parseInt(input.val()) == input.attr('min')) {
				$(this).attr('disabled', true);
			}

		} else if(type == 'plus') {

			if(currentVal < input.attr('max')) {
				input.val(currentVal + 1).change();
			}
			if(parseInt(input.val()) == input.attr('max')) {
				$(this).attr('disabled', true);
			}

		}
	} else {
		input.val(0);
	}
});

$('.input-number').focusin(function(){
	$(this).data('oldValue', $(this).val());
});

$('.input-number').change(function() {

	minValue =  parseInt($(this).attr('min'));
	maxValue =  parseInt($(this).attr('max'));
	valueCurrent = parseInt($(this).val());

	name = $(this).attr('name');
	if(valueCurrent >= minValue) {
		$(".btn-number[data-type='minus'][data-field='"+name+"']").removeAttr('disabled')
	} else {
		alert('Sorry, the minimum value was reached');
		$(this).val($(this).data('oldValue'));
	}
	if(valueCurrent <= maxValue) {
		$(".btn-number[data-type='plus'][data-field='"+name+"']").removeAttr('disabled')
	} else {
		alert('Sorry, the maximum value was reached');
		$(this).val($(this).data('oldValue'));
	}
});

$(".input-number").keydown(function (e) {
// Allow: backspace, delete, tab, escape, enter and .
if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 190]) !== -1 ||
// Allow: Ctrl+A
(e.keyCode == 65 && e.ctrlKey === true) || 
// Allow: home, end, left, right
(e.keyCode >= 35 && e.keyCode <= 39)) {
// let it happen, don't do anything
return;
}

// Ensure that it is a number and stop the keypress
if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
	e.preventDefault();
}
});
// Points Earned end --------------------->

$(function() {
	$('.selectpicker').selectpicker();
});
</script>
@endsection