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
                            <h4>Forgot Password</h4>
                            <p>Enter the e-mail address associated with your account. Click submit to have a password reset link e-mailed to you.</p>
                            <div class="alert alert-danger" role="alert">
                                Warning: The e-mail address you entered is invalid, please try again.
                            </div>
                            <div class="alert alert-success" role="alert">
                                Success! Please check your e-mail's inbox for the re-activation link.
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Email Address</label>
                                <input type="email" class="form-control">
                            </div>
                            <button type="submit" class="btn btn-success">Submit</button>
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
