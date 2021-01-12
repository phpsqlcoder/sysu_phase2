@extends('theme.'.env('FRONTEND_TEMPLATE').'.main')

@section('pagecss')
    <link rel="stylesheet" href="{{ asset('theme/legande/plugins/responsive-tabs/css/responsive-tabs.css') }}" />
    <link rel="stylesheet" href="{{ asset('theme/legande/plugins/gijgo/css/gijgo.min.css') }}" />
    <style>
        .reg-btn{
            border-radius: 100px;
            border: 2px solid #f26522;
            background: #f26522;
            color: #fff;
        }
        .cancel-btn{
            border-radius: 100px;
            border: 2px solid #f26522;
            background: #fff;
            color: #f26522;
        }

        h4{
            color:#ffb100 !important;
        }

        form .form-group {
            margin-bottom: 1em;
        }
    </style>
@endsection

@section('content')

    <div class="content-wrapper">
        <div class="gap-70"></div>
        <div class="container">
            <div class="account-wrapper">
                <div class="row">
                    <div class="col-md-6 offset-md-3">
                        <form id="signUpForm" autocomplete="off" action="{{ route('customer-front.customer-sign-up') }}" method="post" style="font-family:sans-serif;">
                            @csrf
                            @method('POST')

                            <div>
                                <div class="form-group">
                                    <label class="d-block">First Name *</label>
                                    <input type="text" name="fname" id="fname" value="{{ old('fname')}}" class="form-control @error('fname') is-invalid @enderror">
                                    @hasError(['inputName' => 'fname'])
                                    @endhasError
                                </div>
                                <div class="form-group">
                                    <label class="d-block">Last Name *</label>
                                    <input type="text" name="lname" id="lname" value="{{ old('lname')}}" class="form-control @error('lname') is-invalid @enderror">
                                    @hasError(['inputName' => 'lname'])
                                    @endhasError
                                </div>

                            </div>
                            <br>
                            <h4 class="mg-b-0 tx-spacing--1">Account</h4>
                            <div class="form-group">
                                <label class="d-block">Email *</label>
                                <input type="email" name="email" id="email" required="required" value="{{ old('email')}}" class="form-control @error('email') is-invalid @enderror" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$">
                                @hasError(['inputName' => 'email'])
                                @endhasError
                            </div>
                            <div class="form-group">
                                <label class="d-block">Password *</label>
                                <input type="password" name="password" id="password" required="required" value="{{ old('password')}}" class="form-control @error('password') is-invalid @enderror">
                                @hasError(['inputName' => 'password'])
                                @endhasError
                                <small id="emailHelp" class="form-text text-muted">Minimum of eight (8) characters</small>
                            </div>
                            <div class="form-group">
                                <label class="d-block">Confirm Password *</label>
                                <input type="password" name="password_confirmation" id="password_confirmation" required="required" value="{{ old('password_confirmation')}}" class="form-control @error('password_confirmation') is-invalid @enderror">
                                @hasError(['inputName' => 'password_confirmation'])
                                @endhasError
                            </div>
                            <br>

                            <h4 class="mg-b-0 tx-spacing--1">Address Information</h4>
                            <div class="form-group">
                                <label class="d-block">Address Line 1 *</label>
                                <input type="text" name="address_street" id="address_street" value="{{ old('address_street')}}" class="form-control @error('address_street') is-invalid @enderror" placeholder="Unit No./Building/House No./Street" required>
                                @hasError(['inputName' => 'address_street'])
                                @endhasError
                            </div>
                            <div class="form-group">
                                <label class="d-block">Address Line 2 *</label>
                                <input type="text" name="address_municipality" id="address_municipality" placeholder="Subd/Brgy/Municipality/City/Province" value="{{ old('address_municipality')}}" class="form-control @error('address_municipality') is-invalid @enderror" required>
                                @hasError(['inputName' => 'address_municipality'])
                                @endhasError
                            </div>
                            <div class="form-group">
                                <label class="d-block">City/Province *</label>
                                <input type="text" name="address_city" id="address_city" value="{{ old('address_city')}}" class="form-control @error('address_city') is-invalid @enderror" required>
                                @hasError(['inputName' => 'address_city'])
                                @endhasError
                            </div>
                            <div class="form-group">
                                <label class="d-block">Zip *</label>
                                <input type="text" name="address_zip" id="address_zip" value="{{ old('address_zip')}}" class="form-control @error('address_zip') is-invalid @enderror" required>
                                @hasError(['inputName' => 'address_zip'])
                                @endhasError
                            </div>
                            <br>
                            <h4 class="mg-b-0 tx-spacing--1">Contact Information</h4>

                            <div class="form-group">
                                <label class="d-block">Telephone Number</label>
                                <input type="text" name="contact_tel" id="contact_tel" value="{{ old('contact_tel')}}" class="form-control @error('contact_tel') is-invalid @enderror" maxlength="200">
                                @hasError(['inputName' => 'contact_tel'])
                                @endhasError
                            </div>
                            <div class="form-group">
                                <label class="d-block">Mobile Number *</label>
                                <input type="text" name="contact_mobile" id="contact_mobile" value="{{ old('contact_mobile')}}" class="form-control @error('contact_mobile') is-invalid @enderror" required="required" maxlength="13">
                                @hasError(['inputName' => 'contact_mobile'])
                                @endhasError
                            </div>

                            <div class="form-group">
                                <script src="https://www.google.com/recaptcha/api.js?hl=en" async="" defer="" ></script>
                                <div class="g-recaptcha" data-sitekey="{{ \Setting::info()->google_recaptcha_sitekey }}"></div>
                                <label class="control-label text-danger" for="g-recaptcha-response" id="catpchaError" style="display:none;font-size: 14px;"><i class="fa fa-times-circle-o"></i>The Captcha field is required.</label></br>
                                @if($errors->has('g-recaptcha-response'))
                                    @foreach($errors->get('g-recaptcha-response') as $message)
                                        <label class="control-label text-danger" for="g-recaptcha-response"><i class="fa fa-times-circle-o"></i>{{ $message }}</label></br>
                                    @endforeach
                                @endif
                            </div>

                            <button class="btn btn-primary reg-btn" type="submit">Register</button>&nbsp;&nbsp;
                            <a class="btn btn-outline-secondary btn-uppercase cancel-btn" href="{{ route('customers.index') }}" style="margin-right:5px;">Cancel</a>&nbsp;&nbsp;
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="gap-70"></div>
    </div>

@endsection

@section('customjs')
    <script>
        $('#signUpForm').submit(function (evt) {
            let recaptcha = $("#g-recaptcha-response").val();
            if (recaptcha === "") {
                evt.preventDefault();
                $('#catpchaError').show();
                return false;
            }
        });
    </script>
@endsection

@section('jsscript')
    <script src="{{ asset('theme/legande/plugins/responsive-tabs/js/jquery.responsiveTabs.min.js') }}"></script>
    <script src="{{ asset('theme/legande/plugins/gijgo/js/gijgo.min.js') }}"></script>
    <script src="{{ asset('theme/legande/plugins/jquery-steps/build/jquery.steps.min.js') }}"></script>

    <script>
        $(document).ready(function () {
            $('#fname').attr('required', true);
            $('#lname').attr('required', true);
            $('#contact_person').attr('required', false);
            $('#organization').attr('required', false);
            $('.org').hide();
            $('.individual').show();
            //called when key is pressed in textbox
            $("#contact_tel,#contact_mobile,#contact_fax").keypress(function (e) {
                //if the letter is not digit then display error and don't type anything
                // if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
                //     return false;
                // }
                var charCode = (e.which) ? e.which : event.keyCode
                if (charCode != 43 && charCode > 31 && (charCode < 48 || charCode > 57))
                    return false;
                return true;

            });
        });

    </script>


    <script type="text/javascript">
        $("#is_org").change(function(){
            var x = $("#is_org").val();
            if(x == '0'){
                $('#fname').attr('required', true);
                $('#lname').attr('required', true);
                $('#contact_person').attr('required', false);
                $('#organization').attr('required', false);
                $('.org').hide();
                $('.individual').show();
            }
            else
            {
                $('#fname').attr('required', false);
                $('#lname').attr('required', false);
                $('#contact_person').attr('required', true);
                $('#organization').attr('required', true);
                $('.individual').hide();
                $('.org').show();
            }
        });
    </script>
@endsection
