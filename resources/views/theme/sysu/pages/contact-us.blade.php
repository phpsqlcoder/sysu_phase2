@extends('theme.'.env('FRONTEND_TEMPLATE').'.main')

@section('pagecss')
@endsection

@section('content')
  

    <section id="default-wrapper">
        <div class="container">
            <div class="row contact-details">
                <div class="col-lg-8">
                    {!! $page->contents !!}
                </div>
                <div class="col-lg-4">
                    <h3>Leave us a message</h3>
                    <p>
                        Note: Please do not leave required fields (<span class="required-field">*</span>) empty.
                    </p>
                    <form id="contactUsForm" method="POST" action="{{ route('contact-us') }}">
                        @csrf
                        @if(session()->has('success') && session())
                            <div class="alert alert-success">
                                {{ session()->get('success') }}
                            </div>
                        @endif
                        @if(session()->has('error'))
                            <div class="alert alert-danger">
                                {{ session()->get('error') }}
                            </div>
                        @endif
                        <div class="form-style-alt">
                            <p>Full Name <span class="required-field">*</span></p>
                            <div class="form-wrap form-group has-feedback 1">
                                <label class="form-label" for="fullName">First and Last Name</label>
                                <input type="text" id="fullName" class="form-control form-input" name="name" />
                                <span class="glyphicon glyphicon-user form-control-feedback"></span>
                            </div>
                            <div class="gap-10"></div>
                            <p>E-mail Address <span class="required-field">*</span></p>
                            <div class="form-wrap form-group has-feedback 1">
                                <label class="form-label" for="emailAddress">hello@email.com</label>
                                <input type="email" id="emailAddress" class="form-control form-input" name="email"
                                pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$"
                                data-content="Please ensure the e-mail address is accessible and up-to-date" />
                                <span class="glyphicon glyphicon-user form-control-feedback"></span>
                            </div>
                            <div class="gap-10"></div>
                            <p>Contact Number <span class="required-field">*</span></p>
                            <div class="form-wrap form-group has-feedback 1">
                                <label class="form-label" for="contactNumber">Landline or Mobile</label>
                                <input type="number" id="contactNumber" class="form-control form-input" name="contact"
                                data-content="Please ensure the contact number is accessible and up-to-date" />
                                <span class="glyphicon glyphicon-user form-control-feedback"></span>
                            </div>
                            <div class="gap-10"></div>
                            <p>Message <span class="required-field">*</span></p>
                            <div class="txtarea form-wrap form-group has-feedback 1">
                                <label class="form-label" for="message">Tell us what you thought about it</label>
                                <textarea name="message" id="message" class="form-control form-input" rows="5"></textarea>
                                <span class="glyphicon glyphicon-user form-control-feedback"></span>
                            </div>
                            <div class="form-group has-feedback 1">
                                <script src="https://www.google.com/recaptcha/api.js?hl=en" async="" defer=""></script>
                                <div class="g-recaptcha" id="buzzNoCaptchaId_b7b85055bcbc9f863f94c9b599c26558"
                                data-sitekey="6LcmAZIUAAAAAFyl7Lk7YG23jd45KFBiJxg87nGb">
                                <div style="width: 304px; height: 78px;">
                                    <div>
                                        <iframe
                                        src="https://www.google.com/recaptcha/api2/anchor?ar=1&amp;k=6LcmAZIUAAAAAFyl7Lk7YG23jd45KFBiJxg87nGb&amp;co=aHR0cHM6Ly9jbGllbnRzLndlYmZvY3VzcHJvZC53c2lwaDIuY29tOjQ0Mw..&amp;hl=en&amp;v=v1563777128698&amp;size=normal&amp;cb=5bcfl9ks2yn"
                                        width="304" height="78" role="presentation" name="a-jqci39lymds" frameborder="0" scrolling="no"
                                        sandbox="allow-forms allow-popups allow-same-origin allow-scripts allow-top-navigation allow-modals allow-popups-to-escape-sandbox"></iframe>
                                    </div>
                                    <textarea id="g-recaptcha-response" name="g-recaptcha-response" class="g-recaptcha-response"
                                    style="width: 250px; height: 40px; border: 1px solid rgb(193, 193, 193); margin: 10px 25px; padding: 0px; resize: none; display: none;"></textarea>
                                </div>
                                @if($errors->has('g-recaptcha-response'))
                                    @foreach($errors->get('g-recaptcha-response') as $message)
                                        <label class="control-label text-danger" for="g-recaptcha-response"><i class="fa fa-times-circle-o"></i>{{ $message }}</label></br>
                                    @endforeach
                                @endif
                            </div>
                            <span class="glyphicon glyphicon-user form-control-feedback"></span>
                        </div>
                        <div class="form-group mt-5">
                            <input type="hidden" name="_token" value="CgrSn735Uc5xs69pCwIBsIb8979nQ1JyuqoB68Cg" />
                            <button type="submit" class="btn btn-md primary-btn">
                            Submit</button>&nbsp;
                            <button type="reset" class="btn btn-md default-btn">
                                Reset
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
@endsection

@section('pagejs')
    <script>
        $('#contactUsForm').submit(function (evt) {
            let recaptcha = $("#g-recaptcha-response").val();
            if (recaptcha === "") {
                evt.preventDefault();
                $('#catpchaError').show();
                return false;
            }
        });
    </script>
@endsection
