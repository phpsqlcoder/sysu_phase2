@extends('theme.'.env('FRONTEND_TEMPLATE').'.main')

@section('pagecss')
    <link rel="stylesheet" href="{{ asset('theme/legande/plugins/responsive-tabs/css/responsive-tabs.css') }}" />
    <link rel="stylesheet" href="{{ asset('theme/legande/plugins/gijgo/css/gijgo.min.css') }}" />
@endsection

@section('content')

    <section>
        <div class="content-wrapper">
            <div class="gap-70"></div>
            <div class="container">
                <div class="row">
                    <div class="col-md-6 offset-md-3">
                        <h2>Login as a Guest</h2>
                        <form class="form message-form" role="form" autocomplete="off">
                            <div class="form-group">
                                <input type="text" class="form-control" name="gname1" id="gname1" required="" placeholder="Name">
                                <div class="invalid-feedback">Please enter your name</div>
                            </div>
                            <div class="form-group">
                                <label for="gaddress1">Home Address</label>
                                <select class="form-control col-md-11 offset-md-1" name="cc_exp_mo" size="0" >
                                    <option value="01">Province</option>
                                    <option value="02">02</option>
                                    <option value="03">03</option>
                                </select>
                                <select class="form-control col-md-11 offset-md-1" name="cc_exp_mo" size="0" >
                                    <option value="01">City</option>
                                    <option value="02">02</option>
                                    <option value="03">03</option>
                                </select>
                                <select class="form-control col-md-11 offset-md-1" name="cc_exp_mo" size="0" >
                                    <option value="01">Barangay</option>
                                    <option value="02">02</option>
                                    <option value="03">03</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control" name="gemail" id="gemail" required="" placeholder="Email address">
                                <div class="invalid-feedback">Please enter your email address</div>
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control" name="gnumber" id="gnumber" required="" placeholder="Contact number">
                                <div class="invalid-feedback">Please enter your contact number</div>
                            </div>
                            <div class="form-check">
                                <label class="form-check-label">
                                    <input type="checkbox" class="form-check-input" checked="checked"> <span>Delivery address is the same with the above.</span>
                                </label>
                            </div>
                            <div class="gap-20"></div>
                            <div class="form-group">
                                <div class="form-group">
                                    <input type="text" class="form-control" name="gname2" id="gname2" required="" placeholder="Name">
                                    <div class="invalid-feedback">Please enter your name</div>
                                </div>
                                <label for="gaddress1">Home Address</label>
                                <select class="form-control col-md-11 offset-md-1" name="cc_exp_mo" size="0" >
                                    <option value="01">Province</option>
                                    <option value="02">02</option>
                                    <option value="03">03</option>
                                </select>
                                <select class="form-control col-md-11 offset-md-1" name="cc_exp_mo" size="0" >
                                    <option value="01">City</option>
                                    <option value="02">02</option>
                                    <option value="03">03</option>
                                </select>
                                <select class="form-control col-md-11 offset-md-1" name="cc_exp_mo" size="0" >
                                    <option value="01">Barangay</option>
                                    <option value="02">02</option>
                                    <option value="03">03</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control" name="gnumber" id="gnumber" required="" placeholder="Contact number">
                                <div class="invalid-feedback">Please enter your contact number</div>
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn primary-btn cancel-btn">Cancel</button>
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn primary-btn more2">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="gap-70"></div>
        </div>
    </section>

@endsection

@section('jsscript')
    <script src="{{ asset('theme/legande/plugins/responsive-tabs/js/jquery.responsiveTabs.min.js') }}"></script>
    <script src="{{ asset('theme/legande/plugins/gijgo/js/gijgo.min.js') }}"></script>
    <script src="{{ asset('theme/legande/plugins/jquery-steps/build/jquery.steps.min.js') }}"></script>

    <script>

    </script>
@endsection
