@extends('theme.'.env('FRONTEND_TEMPLATE').'.main')

@section('pagecss')
@endsection

@section('content')
    <section id="member-wrapper">
    <div class="container">
        <div class="bs-wizard">
            <ul class="nav nav-tab nav-line" id="myTab" role="tablist">
                <li class="nav-item">
                    <a class="nav-link @if (!$errors->any()) active @endif" id="home-tab" data-toggle="tab" href="#first" role="tab" aria-controls="home" aria-selected="true">
                        <span class="step-no step-active">1</span>
                        <span class="step-label"> Sponsor Information</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link @if ($errors->any()) active @endif" id="profile-tab" data-toggle="tab" href="#second" role="tab" aria-controls="profile" aria-selected="false">
                        <span class="step-no">2</span>
                        <span class="step-label">Personal Information</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="contact-tab" data-toggle="tab" href="#" role="tab" aria-controls="contact" aria-selected="false">
                        <span class="step-no">3</span>
                        <span class="step-label"> Initial Purchase</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="contact-tab" data-toggle="tab" href="#" role="tab" aria-controls="contact" aria-selected="false">
                        <span class="step-no">4</span>
                        <span class="step-label"> Review Order</span>
                    </a>
                </li>
            </ul>
            <div class="tab-content pd-y-20" id="myTabContent">
                <div class="tab-pane fade  @if (!$errors->any()) show active @endif" id="first" role="tabpanel" aria-labelledby="first-tab">
                    <h4 class="tx-bold wizard-header">Sponsor Information</h4>
                    <div class="sponsor-wrapper wizard-pane active" role="tabpanel">
                        <div class="sponsor-option">
                            <label class="radio">
                                <input type="radio" class="no-sponsor" name="sponsor" value="0" required="" @if (!$withSponsor) checked @endif>
                                No Sponsor
                                <span class="radio-button"></span>
                            </label>
                            <label class="radio">
                                <input type="radio" class="with-sponsor" name="sponsor" value="1" required="" @if ($withSponsor) checked @endif>
                                With Sponsor
                                <span class="radio-button"></span>
                            </label>
                        </div>
                        <div class="sponsor-details @if ($withSponsor) fadeIn @endif" @if ($withSponsor) style="display: block;" @endif>
                            <label for="inlineFormInputName2">Enter sponsor username or code *</label>
                            <form id="verifyForm" class="form-style-alt form-inline">
                                @csrf
                                <input name="code" type="text" class="form-input form-control mr-2 col-sm-4" id="inlineFormInputName2"
                                       placeholder="" value="@if ($withSponsor) {{ $member->name }} @endif" @if ($withSponsor) readonly @endif required>
                                <button type="submit" class="btn btn-md tertiary-btn mt-0" id="verify">Verify</button>
                            </form>
                            <div class="gap-10"></div>
                            <div id="verifiedSuccess" class="alert alert-success" role="alert" style="display: none;">
                                <span class="fa fa-info-circle"></span> Success! Sponsor had been verified.
                            </div>
                            <div id="verifiedFailed" class="alert alert-danger" role="alert" style="display: none;">
                                <span class="fa fa-info-circle"></span> Sponsor had been not verified.
                            </div>
                            {{--                                <div class="gap-10"></div>--}}
                            {{--                                <label class="check txt-lg"><input type="checkbox" class="preferences" name="preferences" value="2">I want to receive exclusive--}}
                            {{--                                    offers and promotions from <span class="white-spc">Legande, Inc.</span><span class="checkbox"></span></label>--}}
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade @if ($errors->any()) show active @endif" id="second" role="tabpanel" aria-labelledby="second-tab">
                    <h4 class="tx-bold wizard-header">Personal Information</h4>
                    <div class="personal-info wizard-pane" role="tabpanel">
                        <div class="gap-10"></div>
                        <div class="row">
                            <div class="col-md-6 offset-md-3">
                                <form id="personalInfoForm" method="POST" class="form-style-alt" action="{{ route('member-front.member-sign-up') }}">
                                    @csrf
                                    @method('POST')
                                    <div class="form-style-alt">
                                        @if ($errors->any())
                                            <div class="alert alert-solid alert-danger d-flex align-items-center" role="alert">
                                                <ul id="errorMessage">
                                                    @foreach ($errors->all() as $error)
                                                        <li>
                                                            <i data-feather="x-circle" class="mg-r-10"></i> {{ $error }}
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        @endif
                                        <input type="hidden" id="sponsor_id" name="sponsor_id" value="0">
                                        <div class="form-group form-wrap">
                                            <p>Entity Type *</p>
                                            <select name="entity_type" class="form-input form-select form-sm" required>
                                                @foreach ($entityTypes as $type)
                                                    <option value="{{ $type }}">{{ $type }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="gap-20"></div>

                                        <div class="form-group form-wrap">
                                            <p>First Name *</p>
                                            <input type="text" class="form-control form-input form-sm" name="first_name" required>
                                        </div>

                                        <div class="gap-20"></div>

                                        <div class="form-group form-wrap">
                                            <p>Middle Name</p>
                                            <input type="text" class="form-input form-sm" name="middle_name">
                                        </div>

                                        <div class="gap-20"></div>

                                        <div class="form-group form-wrap">
                                            <p>Last Name *</p>
                                            <input type="text" class="form-input form-sm" name="last_name" required>
                                        </div>

                                        <div class="gap-20"></div>

                                        <div class="form-group form-wrap">
                                            <p>Government ID Type</p>
                                            <select name="government_type" class="form-input form-select form-sm">
                                                @foreach ($governmentIdTypes as $type)
                                                    <option value="{{ $type }}">{{ $type }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="gap-20"></div>

                                        <div class="form-group form-wrap">
                                            <p>Government ID</p>
                                            <input type="text" class="form-input form-sm" id="government_id" name="government_id">
                                        </div>

                                        <div class="gap-20"></div>

                                        <div class="form-group form-wrap">
                                            <p>Upload Government ID Photo</p>
                                            <div class="input-group">
                                                <input type="text" name="government_id_photo" class="form-input form-sm" placeholder="No file selected" readonly>
                                                <span class="input-group-append">
                                                          <div class="btn btn-light form-file">
                                                            <input type="file" name="file"
                                                                   onchange="this.form.government_id_photo.value = this.files.length ? this.files[0].name : ''" />
                                                            Select a file
                                                          </div>
                                                        </span>
                                            </div>
                                        </div>

                                        <div class="gap-20"></div>

                                        <div class="form-group form-wrap">
                                            <p>Birthday</p>
                                            <input type="date" name="birthday" class="form-input form-sm" id="birthday" />
                                        </div>

                                        <div class="gap-40"></div>

                                        <h5>Account Information</h5>

                                        <div class="form-group form-wrap">
                                            <p>Username *</p>
                                            <input type="text" class="form-input form-sm" name="username" required>
                                        </div>

                                        <div class="gap-20"></div>

                                        <div class="form-group form-wrap">
                                            <p>Password *</p>
                                            <input type="password" class="form-input form-sm" name="password" required>
                                        </div>

                                        <div class="gap-20"></div>

                                        <div class="form-group form-wrap">
                                            <p>Confirm Password *</p>
                                            <input type="password" class="form-input form-sm" name="confirm_password" required>
                                        </div>

                                        <div class="gap-20"></div>

                                        <div class="form-group form-wrap">
                                            <p>Security Question *</p>
                                            <select name="security_question" class="form-input form-select form-sm" required>
                                                @foreach ($securityQuestions as $question)
                                                    <option value="{{ $question }}">{{ $question }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="gap-20"></div>

                                        <div class="form-group form-wrap">
                                            <p>Answer *</p>
                                            <input type="text" class="form-input form-sm" id="answer" name="security_answer" required>
                                        </div>

                                        <div class="gap-20"></div>

                                        <hr>

                                        <div class="gap-20"></div>

                                        <h5>Mailing Address</h5>

                                        <div class="form-group form-wrap">
                                            <p>Country *</p>
                                            <input type="text" class="form-input form-sm" id="address_country" name="address_country" required>
                                        </div>

                                        <div class="gap-20"></div>

                                        <div class="form-group form-wrap">
                                            <p>Province *</p>
                                            <input type="text" class="form-input form-sm" id="address_province" name="address_province" required>
                                        </div>

                                        <div class="gap-20"></div>

                                        <div class="form-group form-wrap">
                                            <p>City/Municipality *</p>
                                            <input type="text" class="form-input form-sm" id="address_city" name="address_city" required>
                                        </div>

                                        <div class="gap-20"></div>

                                        <div class="form-group form-wrap">
                                            <p>Street *</p>
                                            <input type="text" class="form-input form-sm" id="address_street" name="address_street" required>
                                        </div>

                                        <div class="gap-20"></div>

                                        <div class="form-group form-wrap">
                                            <p>ZIP Code *</p>
                                            <input type="number" class="form-input form-sm" id="address_zip" name="address_zip" required>
                                        </div>

                                        <div class="gap-20"></div>

                                        <hr>

                                        <div class="gap-20"></div>

                                        <h5>Delivery Address</h5>

                                        <div class="gap-10"></div>

                                        <label class="check txt-md" for="sameAddress"><input type="checkbox" id="sameAddress">Same with Mailing
                                            Address<span class="checkbox"></span></label>

                                        <div class="gap-10"></div>

                                        <div class="form-group form-wrap">
                                            <p>Country *</p>
                                            <input type="text" class="form-input form-sm" id="address_delivery_country" name="address_delivery_country" required>
                                        </div>

                                        <div class="gap-20"></div>

                                        <div class="form-group form-wrap">
                                            <p>Province *</p>
                                            <input type="text" class="form-input form-sm" id="address_delivery_province" name="address_delivery_province" required>
                                        </div>

                                        <div class="gap-20"></div>

                                        <div class="form-group form-wrap">
                                            <p>City/Municipality *</p>
                                            <input type="text" class="form-input form-sm" id="address_delivery_city" name="address_delivery_city" required>
                                        </div>

                                        <div class="gap-20"></div>

                                        <div class="form-group form-wrap">
                                            <p>Street *</p>
                                            <input type="text" class="form-input form-sm" id="address_delivery_street" name="address_delivery_street" required>
                                        </div>

                                        <div class="gap-20"></div>

                                        <div class="form-group form-wrap">
                                            <p>ZIP Code *</p>
                                            <input type="number" class="form-input form-sm" id="address_delivery_zip" name="address_delivery_zip" required>
                                        </div>

                                        <div class="gap-20"></div>

                                        <hr>

                                        <div class="gap-20"></div>

                                        <div class="form-group form-wrap">
                                            <p>Email Address *</p>
                                            <input type="text" class="form-input form-sm" id="email" name="email" required>
                                        </div>

                                        <div class="gap-20"></div>

                                        <div class="form-group form-wrap">
                                            <p>Mobile Number</p>
                                            <input type="number" class="form-input form-sm" id="mobile" name="mobile">
                                        </div>

                                        <div class="gap-20"></div>

                                        <div class="form-group form-wrap">
                                            <p>Phone Number</p>
                                            <input type="number" class="form-input form-sm" id="phone" name="phone">
                                        </div>

                                        <div class="gap-20"></div>

                                        <div class="form-group form-wrap">
                                            <p>Work Phone Number</p>
                                            <input type="number" class="form-input form-sm" id="work_phone" name="work_phone">
                                        </div>

                                        <div class="gap-20"></div>

                                        <div class="form-group form-wrap">
                                            <p>Fax</p>
                                            <input type="number" class="form-input form-sm" id="fax" name="fax">
                                        </div>
                                        <input type="submit" id="btnPersonalInform" class="d-none">
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="third" role="tabpanel" aria-labelledby="t-tab">
                    <h4 class="tx-bold wizard-header">Inital Purchase</h4>
                    <div class="purchase-wrapper wizard-pane" role="tabpanel">
                        <div class="form-group">
                            <div class="purchase-intro">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="d-flex bd-highlight">
                                            <div class="mr-auto bd-highlight">
                                                <p class="pd-t-10">Select one or more products to make your initial purchase:</p>
                                            </div>
                                            <div class="bd-highlight">
                                                <div class="dropdown d-inline">
                                                    <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Sort by</button>
                                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                        <a class="dropdown-item" href="#">Action</a>
                                                        <a class="dropdown-item" href="#">Another action</a>
                                                        <a class="dropdown-item" href="#">Something else here</a>
                                                    </div>
                                                </div>
                                                <div class="dropdown d-inline">
                                                    <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Cart (3)</button>
                                                    <div class="dropdown-menu dropdown-menu-right">
                                                        <div class="wd-400 pd-15">
                                                            <div class="table-responsive">
                                                                <table class="table table-sm table-borderless table-hover mg-0">
                                                                    <thead>
                                                                    <tr>
                                                                        <th class="wd-50p">Product Name</th>
                                                                        <th class="tx-center">Qty</th>
                                                                        <th class="tx-right">PV</th>
                                                                        <th class="tx-right">Amount</th>
                                                                    </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                    <tr>
                                                                        <td class="tx-nowrap">Website Design</td>
                                                                        <td class="tx-center">2</td>
                                                                        <td class="tx-right">15</td>
                                                                        <td class="tx-right">Php 22,500.00</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td class="tx-nowrap">Firefox Plugin</td>
                                                                        <td class="tx-center">1</td>
                                                                        <td class="tx-right">15</td>
                                                                        <td class="tx-right">Php 22,500.00</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td class="tx-nowrap">iPhone App</td>
                                                                        <td class="tx-center">2</td>
                                                                        <td class="tx-right">15</td>
                                                                        <td class="tx-right">Php 22,500.00</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td class="tx-nowrap">Android App</td>
                                                                        <td class="tx-center">3</td>
                                                                        <td class="tx-right">15</td>
                                                                        <td class="tx-right">Php 22,500.00</td>
                                                                    </tr>
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="purchase-category">
                                        <h4 class="mg-b-30"><strong>Categories</strong></h4>
                                        <p><strong>Tea</strong></p>
                                        <ul>
                                            <li>Green Tea</li>
                                            <li>White Tea</li>
                                            <li>Oolong Tea</li>
                                            <li>Black Tea</li>
                                            <li>Jasmine Lovers</li>
                                        </ul>
                                        <p><strong>Argon Oil</strong></p>
                                        <ul>
                                            <li>Face, Daytime Use</li>
                                            <li>Face, Night Repair</li>
                                            <li>Hair, Daytime Use</li>
                                            <li>Hair, Deep Conditioning</li>
                                            <li>Skin, Moisturizer</li>
                                        </ul>
                                        <p><strong>Essential Oils</strong></p>
                                        <ul>
                                            <li>Lemongrass</li>
                                            <li>Rosemary</li>
                                            <li>Lemon</li>
                                            <li>Frakincense</li>
                                            <li>Orange</li>
                                            <li>Tea Trea</li>
                                            <li>Lavender</li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="col-md-9">
                                    <div class="row">
                                        <div class="col-md-4 col-sm-6 item">
                                            <div class="product-link">
                                                <div class="product-card">
                                                    <a href="product-profile.htm">
                                                        <div class="product-img">
                                                            <img src="images/misc/img-placeholder.png" alt="">
                                                        </div>
                                                        <div class="gap-30"></div>
                                                        <p class="product-title">Red Women Purses</p>
                                                    </a>
                                                    <h3 class="product-price">Php 1,549.00</h3>
                                                    <div class="prod-pv">
                                                        <p class="mg-0 pd-0 tx-danger">145 PV</p>
                                                    </div>
                                                    <div class="gap-10"></div>
                                                    <button class="btn btn-xs primary-btn mg-t-10"><i data-feather="plus-circle" class="mg-r-10"></i> Add
                                                        to Cart</button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-sm-6 item">
                                            <div class="product-link">
                                                <div class="product-card">
                                                    <a href="product-profile.htm">
                                                        <div class="product-img">
                                                            <img src="images/misc/img-placeholder.png" alt="">
                                                        </div>
                                                        <div class="gap-30"></div>
                                                        <p class="product-title">Red Women Purses</p>
                                                    </a>
                                                    <h3 class="product-price">Php 1,549.00</h3>
                                                    <div class="prod-pv">
                                                        <p class="mg-0 pd-0 tx-danger">145 PV</p>
                                                    </div>
                                                    <div class="gap-10"></div>
                                                    <button class="btn btn-xs primary-btn mg-t-10"><i data-feather="plus-circle" class="mg-r-10"></i> Add
                                                        to Cart</button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-sm-6 item">
                                            <div class="product-link">
                                                <div class="product-card">
                                                    <a href="product-profile.htm">
                                                        <div class="product-img">
                                                            <img src="images/misc/img-placeholder.png" alt="">
                                                        </div>
                                                        <div class="gap-30"></div>
                                                        <p class="product-title">Red Women Purses</p>
                                                    </a>
                                                    <h3 class="product-price">Php 1,549.00</h3>
                                                    <div class="prod-pv">
                                                        <p class="mg-0 pd-0 tx-danger">145 PV</p>
                                                    </div>
                                                    <div class="gap-10"></div>
                                                    <button class="btn btn-xs primary-btn mg-t-10"><i data-feather="plus-circle" class="mg-r-10"></i> Add
                                                        to Cart</button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-sm-6 item">
                                            <div class="product-link">
                                                <div class="product-card">
                                                    <a href="product-profile.htm">
                                                        <div class="product-img">
                                                            <img src="images/misc/img-placeholder.png" alt="">
                                                        </div>
                                                        <div class="gap-30"></div>
                                                        <p class="product-title">Red Women Purses</p>
                                                    </a>
                                                    <h3 class="product-price">Php 1,549.00</h3>
                                                    <div class="prod-pv">
                                                        <p class="mg-0 pd-0 tx-danger">145 PV</p>
                                                    </div>
                                                    <div class="gap-10"></div>
                                                    <button class="btn btn-xs primary-btn mg-t-10"><i data-feather="plus-circle" class="mg-r-10"></i> Add
                                                        to Cart</button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-sm-6 item">
                                            <div class="product-link">
                                                <div class="product-card">
                                                    <a href="product-profile.htm">
                                                        <div class="product-img">
                                                            <img src="images/misc/img-placeholder.png" alt="">
                                                        </div>
                                                        <div class="gap-30"></div>
                                                        <p class="product-title">Red Women Purses</p>
                                                    </a>
                                                    <h3 class="product-price">Php 1,549.00</h3>
                                                    <div class="prod-pv">
                                                        <p class="mg-0 pd-0 tx-danger">145 PV</p>
                                                    </div>
                                                    <div class="gap-10"></div>
                                                    <button class="btn btn-xs primary-btn mg-t-10"><i data-feather="plus-circle" class="mg-r-10"></i> Add
                                                        to
                                                        Cart</button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-sm-6 item">
                                            <div class="product-link">
                                                <div class="product-card">
                                                    <a href="product-profile.htm">
                                                        <div class="product-img">
                                                            <img src="images/misc/img-placeholder.png" alt="">
                                                        </div>
                                                        <div class="gap-30"></div>
                                                        <p class="product-title">Red Women Purses</p>
                                                    </a>
                                                    <h3 class="product-price">Php 1,549.00</h3>
                                                    <div class="prod-pv">
                                                        <p class="mg-0 pd-0 tx-danger">145 PV</p>
                                                    </div>
                                                    <div class="gap-10"></div>
                                                    <button class="btn btn-xs primary-btn mg-t-10"><i data-feather="plus-circle" class="mg-r-10"></i> Add
                                                        to
                                                        Cart</button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-sm-6 item">
                                            <div class="product-link">
                                                <div class="product-card">
                                                    <a href="product-profile.htm">
                                                        <div class="product-img">
                                                            <img src="images/misc/img-placeholder.png" alt="">
                                                        </div>
                                                        <div class="gap-30"></div>
                                                        <p class="product-title">Red Women Purses</p>
                                                    </a>
                                                    <h3 class="product-price">Php 1,549.00</h3>
                                                    <div class="prod-pv">
                                                        <p class="mg-0 pd-0 tx-danger">145 PV</p>
                                                    </div>
                                                    <div class="gap-10"></div>
                                                    <button class="btn btn-xs primary-btn mg-t-10"><i data-feather="plus-circle" class="mg-r-10"></i> Add
                                                        to
                                                        Cart</button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-sm-6 item">
                                            <div class="product-link">
                                                <div class="product-card">
                                                    <a href="product-profile.htm">
                                                        <div class="product-img">
                                                            <img src="images/misc/img-placeholder.png" alt="">
                                                        </div>
                                                        <div class="gap-30"></div>
                                                        <p class="product-title">Red Women Purses</p>
                                                    </a>
                                                    <h3 class="product-price">Php 1,549.00</h3>
                                                    <div class="prod-pv">
                                                        <p class="mg-0 pd-0 tx-danger">145 PV</p>
                                                    </div>
                                                    <div class="gap-10"></div>
                                                    <button class="btn btn-xs primary-btn mg-t-10"><i data-feather="plus-circle" class="mg-r-10"></i> Add
                                                        to
                                                        Cart</button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-sm-6 item">
                                            <div class="product-link">
                                                <div class="product-card">
                                                    <a href="product-profile.htm">
                                                        <div class="product-img">
                                                            <img src="images/misc/img-placeholder.png" alt="">
                                                        </div>
                                                        <div class="gap-30"></div>
                                                        <p class="product-title">Red Women Purses</p>
                                                    </a>
                                                    <h3 class="product-price">Php 1,549.00</h3>
                                                    <div class="prod-pv">
                                                        <p class="mg-0 pd-0 tx-danger">145 PV</p>
                                                    </div>
                                                    <div class="gap-10"></div>
                                                    <button class="btn btn-xs primary-btn mg-t-10"><i data-feather="plus-circle" class="mg-r-10"></i> Add
                                                        to
                                                        Cart</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="d-flex bd-highlight mb-3">
                                        <div class="mr-auto bd-highlight">
                                            <nav aria-label="Page navigation example">
                                                <ul class="pagination">
                                                    <li class="page-item disabled">
                                                        <a class="page-link" href="#" title="Back"><i class="fa fa-caret-left"></i></a>
                                                    </li>
                                                    <li class="page-item active">
                                                        <a class="page-link" href="#">1</a>
                                                    </li>
                                                    <li class="page-item">
                                                        <a class="page-link" href="#">2</a>
                                                    </li>
                                                    <li class="page-item">
                                                        <a class="page-link" href="#">3 <span class="sr-only">(current)</span></a>
                                                    </li>
                                                    <li class="page-item">
                                                        <a class="page-link" href="#" title="Next"><i class="fa fa-caret-right"></i></a>
                                                    </li>
                                                </ul>
                                            </nav>
                                        </div>
                                        <div class="bd-highlight">
                                            <div class="gap-10"></div>
                                            <button type="reset" class="btn btn-md default-btn">
                                                Skip this step
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="fourth" role="tabpanel" aria-labelledby="contact-tab">
                    <h4 class="tx-bold wizard-header">Review Order</h4>
                    <div class="member-content wizard-pane" role="tabpanel">
                        <div class="form-group">
                            <div class="d-sm-flex align-items-center justify-content-between">
                                <div>
                                    <h5>Transaction #0001</h5>
                                    <p>January 2, 2020</p>
                                </div>
                                <div class="mg-t-20 mg-sm-t-0">
                                    <div class="gap-20"></div>
                                    <button class="btn default-btn"><span class="lnr lnr-printer mr-1"></span> Print</button>
                                </div>
                            </div>
                            <!-- container -->
                            <div class="gap-20"></div>
                            <div class="row">
                                <div class="col-lg-8">
                                    <div class="gap-20"></div>
                                    <label class="subtitle">Billed To</label>
                                    <h4 class="customer-name">Stephen Curry</h4>
                                    <p class="customer-address">Unit 908 9th Floor, Antel Global Corporate Center, Julia Vargas Ave., Ortigas Center, Metro Manila, Philippines 1600</p>
                                    <p class="customer-phone">Tel No: 324 445-4544</p>
                                    <p class="customer-email">Email: youremail@companyname.com</p>
                                </div>
                                <!-- col -->
                                <div class="col-lg-4">
                                    <div class="gap-20"></div>
                                    <label class="subtitle">Transaction Details</label>
                                    <ul class="list-unstyled lh-7">
                                        <li class="d-flex justify-content-between">
                                            <p>Transaction Number</p>
                                            <p>#0001</p>
                                        </li>
                                        <li class="d-flex justify-content-between">
                                            <p>Issue Date</p>
                                            <p>January 2, 2020</p>
                                        </li>
                                        <li class="d-flex justify-content-between">
                                            <p>Shipping Method</p>
                                            <p><strong>Standard Shipping</strong></p>
                                        </li>
                                    </ul>
                                </div>
                                <!-- col -->
                            </div>
                            <!-- row -->

                            <div class="gap-40"></div>

                            <div class="table-responsive mg-t-40">
                                <table class="table table-invoice bd-b order-table">
                                    <thead>
                                    <tr>
                                        <th class="w-25">Type</th>
                                        <th class="w-25 d-none d-sm-table-cell">Description</th>
                                        <th class="w-10 text-center">QNTY</th>
                                        <th class="w-10 text-center">PV</th>
                                        <th class="w-15 text-right">Unit Price</th>
                                        <th class="w-15 text-right">Amount</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td class="tx-nowrap"><a href="">The Atelier Tailored Coat</a></td>
                                        <td class="d-none d-sm-table-cell tx-color-03">Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam...</td>
                                        <td class="text-center">
                                            <div class="checkout-quantity">
                                                <select name="quantity" id="quantity">
                                                    <option value="1">1</option>
                                                    <option value="2" selected="">2</option>
                                                    <option value="3">3</option>
                                                    <option value="4">4</option>
                                                    <option value="5">5</option>
                                                    <option value="6">6</option>
                                                    <option value="7">7</option>
                                                    <option value="8">8</option>
                                                    <option value="9">9</option>
                                                    <option value="10">10</option>
                                                    <option value="11">11</option>
                                                    <option value="12">12</option>
                                                    <option value="13">13</option>
                                                    <option value="14">14</option>
                                                    <option value="15">15</option>
                                                    <option value="16">16</option>
                                                    <option value="17">17</option>
                                                    <option value="18">18</option>
                                                    <option value="19">19</option>
                                                    <option value="20">20</option>
                                                    <option value="21">21</option>
                                                    <option value="22">22</option>
                                                    <option value="23">23</option>
                                                    <option value="24">24</option>
                                                    <option value="25">25</option>
                                                </select>
                                            </div>
                                        </td>
                                        <td class="text-center">15</td>
                                        <td class="text-right">₱ 150.00</td>
                                        <td class="text-right">₱ 300.00</td>
                                    </tr>
                                    <tr>
                                        <td class="tx-nowrap"><a href="">The Atelier Tailored Coat</a></td>
                                        <td class="d-none d-sm-table-cell tx-color-03">At vero eos et accusamus et iusto odio dignissimos ducimus qui blanditiis praesentium voluptatum deleniti atque...</td>
                                        <td class="text-center">
                                            <div class="checkout-quantity">
                                                <select name="quantity" id="quantity">
                                                    <option value="1" selected="">1</option>
                                                    <option value="2">2</option>
                                                    <option value="3">3</option>
                                                    <option value="4">4</option>
                                                    <option value="5">5</option>
                                                    <option value="6">6</option>
                                                    <option value="7">7</option>
                                                    <option value="8">8</option>
                                                    <option value="9">9</option>
                                                    <option value="10">10</option>
                                                    <option value="11">11</option>
                                                    <option value="12">12</option>
                                                    <option value="13">13</option>
                                                    <option value="14">14</option>
                                                    <option value="15">15</option>
                                                    <option value="16">16</option>
                                                    <option value="17">17</option>
                                                    <option value="18">18</option>
                                                    <option value="19">19</option>
                                                    <option value="20">20</option>
                                                    <option value="21">21</option>
                                                    <option value="22">22</option>
                                                    <option value="23">23</option>
                                                    <option value="24">24</option>
                                                    <option value="25">25</option>
                                                </select>
                                            </div>
                                        </td>
                                        <td class="text-center">15</td>
                                        <td class="text-right">₱ 1,200.00</td>
                                        <td class="text-right">₱ 1,200.00</td>
                                    </tr>
                                    <tr>
                                        <td class="tx-nowrap"><a href="">The Atelier Tailored Coat</a></td>
                                        <td class="d-none d-sm-table-cell tx-color-03">Et harum quidem rerum facilis est et expedita distinctio</td>
                                        <td class="text-center">
                                            <div class="checkout-quantity">
                                                <select name="quantity" id="quantity">
                                                    <option value="1">1</option>
                                                    <option value="2" selected="">2</option>
                                                    <option value="3">3</option>
                                                    <option value="4">4</option>
                                                    <option value="5">5</option>
                                                    <option value="6">6</option>
                                                    <option value="7">7</option>
                                                    <option value="8">8</option>
                                                    <option value="9">9</option>
                                                    <option value="10">10</option>
                                                    <option value="11">11</option>
                                                    <option value="12">12</option>
                                                    <option value="13">13</option>
                                                    <option value="14">14</option>
                                                    <option value="15">15</option>
                                                    <option value="16">16</option>
                                                    <option value="17">17</option>
                                                    <option value="18">18</option>
                                                    <option value="19">19</option>
                                                    <option value="20">20</option>
                                                    <option value="21">21</option>
                                                    <option value="22">22</option>
                                                    <option value="23">23</option>
                                                    <option value="24">24</option>
                                                    <option value="25">25</option>
                                                </select>
                                            </div>
                                        </td>
                                        <td class="text-center">15</td>
                                        <td class="text-right">₱ 850.00</td>
                                        <td class="text-right">₱ 1,700.00</td>
                                    </tr>
                                    <tr>
                                        <td class="tx-nowrap"><a href="">The Atelier Tailored Coat</a></td>
                                        <td class="d-none d-sm-table-cell tx-color-03">Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt ut</td>
                                        <td class="text-center">
                                            <div class="checkout-quantity">
                                                <select name="quantity" id="quantity">
                                                    <option value="1">1</option>
                                                    <option value="2">2</option>
                                                    <option value="3" selected="">3</option>
                                                    <option value="4">4</option>
                                                    <option value="5">5</option>
                                                    <option value="6">6</option>
                                                    <option value="7">7</option>
                                                    <option value="8">8</option>
                                                    <option value="9">9</option>
                                                    <option value="10">10</option>
                                                    <option value="11">11</option>
                                                    <option value="12">12</option>
                                                    <option value="13">13</option>
                                                    <option value="14">14</option>
                                                    <option value="15">15</option>
                                                    <option value="16">16</option>
                                                    <option value="17">17</option>
                                                    <option value="18">18</option>
                                                    <option value="19">19</option>
                                                    <option value="20">20</option>
                                                    <option value="21">21</option>
                                                    <option value="22">22</option>
                                                    <option value="23">23</option>
                                                    <option value="24">24</option>
                                                    <option value="25">25</option>
                                                </select>
                                            </div>
                                        </td>
                                        <td class="text-center">15</td>
                                        <td class="text-right">₱ 850.00</td>
                                        <td class="text-right">₱ 2,550.00</td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>

                            <div class="checkout-bt row justify-content-between">
                                <div class="col-sm-12 col-lg-6 order-2 order-sm-0 mg-t-40 mg-sm-t-0">
                                    <div class="gap-30"></div>
                                    <label class="tx-sans tx-uppercase tx-10 tx-medium tx-spacing-1 tx-color-03">Notes</label>
                                    <p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt
                                        explicabo.
                                    </p>
                                </div>
                                <!-- col -->
                                <div class="col-sm-12 col-lg-4 order-1 order-sm-0">
                                    <div class="gap-30"></div>
                                    <ul class="list-unstyled lh-7 pd-r-10">
                                        <li class="d-flex justify-content-between">
                                            <span>Sub-Total</span>
                                            <span>₱ 5,750.00</span>
                                        </li>
                                        <li class="d-flex justify-content-between">
                                            <span>Shipping Fee</span>
                                            <span>₱ 500.00</span>
                                        </li>
                                        <li class="d-flex justify-content-between">
                                            <span>Membership Fee</span>
                                            <span>₱ 1000.00</span>
                                        </li>
                                        <li class="d-flex justify-content-between">
                                            <strong>Total Due</strong>
                                            <strong>₱ 5,987.50</strong>
                                        </li>
                                    </ul>

                                    <!-- <button class="btn btn-block primary-btn mt-2"><span class="fa fa-check-circle fa-icon mr-2"></span> Place Order</button> -->
                                </div>
                                <!-- col -->
                            </div>

                            <!-- container -->

                        </div>
                    </div>
                </div>
            </div>

            <div class="d-flex bd-highlight wizard-nav">
                <div class="mr-auto bd-highlight"><button type="button" class="btn btn-primary primary-btn" id="back">Back</button></div>
                <div class="bd-highlight"><button type="button" class="btn btn-primary primary-btn" id="next">Next</button></div>
            </div>
        </div>
    </div>
</section>
@endsection

@section('jsscript')
    <script>
        let validSponsor = false;
        $(document).ready(function () {
            $(".with-sponsor").on("click", function() {
                validSponsor = false;
                $('#verifiedSuccess').hide();
                $('#verifiedFailed').hide();
                $(".sponsor-details").css("display", "block");
                $(".sponsor-details").addClass("fadeIn");
                $('#inlineFormInputName2').val('');
            });

            $(".no-sponsor").on("click", function() {
                $('#sponsor_id').val(0);
                validSponsor = true;
                $(".sponsor-details").css("display", "");
            });
        });

        $(function() {
            $('#back').on('click', function() {

            });

            $('#next').on('click', function() {
                if ($('#profile-tab').hasClass('active')) {
                    $('#btnPersonalInform').click();
                } else {
                    if ($('#home-tab').hasClass('active')) {
                        let sponsor = $('input[name="sponsor"]:checked').val();
                        if (sponsor == 0) {
                            $('#sponsor_id').val(0);
                            validSponsor = true;
                            $('#profile-tab').click();
                        } else {
                            if (validSponsor) {
                                $('#profile-tab').click();
                            } else {
                                $('#verify').click();
                            }
                        }
                    } else {
                        $('#profile-tab').click();
                    }
                }
            });

            $('#myCollapsible').on('show.bs.collapse', function () {
                if (validSponsor) {
                    return true;
                } else {
                    return false;
                }
            })

            $('#verifyForm').on('submit', function() {
                let data = $(this).serialize();
                $('#verifiedSuccess').hide();
                $('#verifiedFailed').hide();

                $.ajax({
                    data: data,
                    type: "POST",
                    url: "{{ route('member-front.verify-member') }}",
                    success: function(returnData) {
                        if (returnData.isExist) {
                            validSponsor = true;
                            $('#sponsor_id').val(returnData.sponsorId);
                            $('#verifiedSuccess').fadeIn()
                        } else {
                            validSponsor = false;
                            $('#sponsor_id').val(0);
                            $('#verifiedFailed').fadeIn();
                        }
                    }
                });

                return false;
            });
        });
    </script>
@endsection

