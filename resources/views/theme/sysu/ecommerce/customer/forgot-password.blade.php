@extends('theme.'.env('FRONTEND_TEMPLATE').'.main')

@section('pagecss')
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
                    <div class="col-md-6">
                        <form method="POST" action="{{ route('ecommerce.send_reset_link_email') }}">
                            @csrf
                            <h4>Forgot Password</h4>
                            <p>Enter the e-mail address associated with your account. Click submit to have a password reset link e-mailed to you.</p>
                            @if ($errors->any())
                                <div class="alert alert-danger" role="alert">
                                    <span class="fa fa-info-circle"></span>
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                            @if (session('error'))
                                <div class="gap-20"></div>
                                <div class="alert alert-danger" role="alert">
                                    {{ session('error') }}
                                </div>
                            @endif
                            @if (session('status'))
                                <div class="gap-20"></div>
                                <div class="alert alert-success" role="alert">
                                    {{ session('status') }}
                                </div>
                            @endif
                            @if (session('status') <> 'success')
                            <div class="form-group">
                                <label for="exampleInputEmail1">Email Address</label>
                                <input type="email" class="form-control" id="email" name="email" required>
                            </div>
                            <button type="submit" class="btn btn-success reg-btn">Submit</button>
                          <a href="{{ route('customer-front.login') }}" class="cancel-btn btn" style="margin-right:5px;">Go Back</a>
                            @endif
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
