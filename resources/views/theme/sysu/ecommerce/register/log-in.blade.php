@extends('theme.'.env('FRONTEND_TEMPLATE').'.main')

@section('pagecss')
@endsection

@section('content')

    <div class="content-wrapper">
        <div class="gap-70"></div>
        <div class="container">
            <div class="account-wrapper">
                <div class="row">
                    <div class="col-md-6">
                        <form>
                            <h4>Login</h4>
                            <p>Returning customer? Login here.</p>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Email Address</label>
                                <input type="email" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">Password</label>
                                <input type="password" class="form-control" id="exampleInputPassword1">
                            </div>
                            <div class="form-group form-check mb-5">
                                <input type="checkbox" class="form-check-input" id="exampleCheck1">
                                <label class="form-check-label" for="exampleCheck1">Remember me</label>
                            </div>
                            <button type="submit" class="btn btn-success">Submit</button>
                            <hr>
                            <a href="{{ route('register.front.forgot_password') }}">Forgot password?</a>
                        </form>
                    </div>
                    <div class="col-md-6">
                        <form>
                            <h4>Signup</h4>
                            <p>By creating an account, you will be able to shop faster, be up to date on an order's status, and keep track of the orders you have previously made.</p>
                            <div class="alert alert-success" role="alert">
                                A simple success alert—check it out!
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">First Name *</label>
                                <input type="text" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Last Name *</label>
                                <input type="text" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Email Address *</label>
                                <input type="email" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">Password *</label>
                                <input type="password" class="form-control" id="exampleInputPassword1">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">Re-enter Password *</label>
                                <input type="password" class="form-control" id="exampleInputPassword1">
                            </div>
                            <div class="form-group form-check mb-5">
                                <input type="checkbox" class="form-check-input" id="exampleCheck1">
                                <label class="form-check-label" for="exampleCheck1">I agree to the Terms and Conditions of Lydia's Lechon</label>
                            </div>
                            <button type="submit" class="btn btn-success">Submit</button>
                            <button type="submit" class="btn btn-outline-secondary">Clear</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="gap-70"></div>
    </div>

@endsection

@section('jsscript')
@endsection
