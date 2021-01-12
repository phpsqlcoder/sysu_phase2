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
    </style>
@endsection

@section('content')

    <div class="content-wrapper">
        <div class="gap-70"></div>
        <div class="container">
            <div class="account-wrapper">
                <div class="row">
                    <div class="col-md-6 offset-md-3">
                        <form autocomplete="off" method="POST" action="{{ route('customer-front.customer_login') }}">
                            @csrf
                            @method('POST')
                            <h4>Login</h4>
                            @if($message = Session::get('error'))
                                <div class="alert alert-danger d-flex align-items-center" role="alert">
                                    <i data-feather="alert-circle" class="mg-r-10"></i> {{ $message }}
                                </div>
                            @endif
                            <div class="form-group {{ $errors->has('email') ? 'has-error' : '' }}">
                                <input type="text" class="form-control" id="email" name="email" placeholder="Email Address" required>
                                <span class="text-danger">{{ $errors->first('email') }}</span>
                            </div>
                            <div class="form-group {{ $errors->has('password') ? 'has-error' : '' }}">
                                <input type="password" class="form-control" id="password" name="password" placeholder="Password" autocomplete="off" required>
                                <span class="text-danger">{{ $errors->first('password') }}</span>
                            </div>
                            <span class="form-text text-muted">
								<a class=" float-right" href="{{ route('ecommerce.forgot_password') }}">Forgot Password?</a>
							</span>
                            <span class="form-text text-muted">
								New customer? <a href="{{ route('customer-front.sign-up') }}">Register</a> here.
							</span>
                            <div class="gap-20"></div>
                            <button type="submit" class="btn btn-success reg-btn">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="gap-70"></div>
    </div>

@endsection

@section('jsscript')
    <script src="{{ asset('theme/legande/plugins/responsive-tabs/js/jquery.responsiveTabs.min.js') }}"></script>
    <script src="{{ asset('theme/legande/plugins/gijgo/js/gijgo.min.js') }}"></script>
    <script src="{{ asset('theme/legande/plugins/jquery-steps/build/jquery.steps.min.js') }}"></script>

    <script>

    </script>
@endsection
