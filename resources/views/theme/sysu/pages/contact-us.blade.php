@extends('theme.'.env('FRONTEND_TEMPLATE').'.main')

@section('pagecss')
@endsection

@section('content')
<section class="mb-5">
    <div class="container pt-2">
        <div class="gap-20"></div>
        <div class="row">
            <div class="col-lg-6 mb-5">
                <h4>Get in touch with us</h4>
                <p>Please fill up a form or send us an email, and we’ll get in touch shortly.</p>
                @if(session()->has('success'))
                    <div class="alert alert-success">
                        {{ session()->get('success') }}
                    </div>
                @endif
                @if(session()->has('error'))
                    <div class="alert alert-danger">
                        {{ session()->get('error') }}
                    </div>
                @endif
                <form autocomplete="off" id="contactUsForm" action="{{ route('contact-us') }}" method="POST">
                    @method('POST')
                    @csrf
                    <div class="form-group">
                        <select class="form-control" id="exampleFormControlSelect1" name="type">
                            <option selected="true" disabled="disabled">I am a</option>
                            <option value="Supplier">Supplier</option>
                            <option value="Client">Client</option>
                            <option value="General Inquiry">General Inquiry</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <input required type="text" class="form-control" name="name" placeholder="Your name *" />
                    </div>
                    <div class="form-row pb-3">
                        <div class="col-md-6">
                            <input required type="email" class="form-control" name="email" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$" placeholder="Your email *" />
                        </div>
                        <div class="col-md-6 mt-3 mt-md-0">
                            <input required type="number" class="form-control" name="contact" placeholder="Your contact number *" />
                        </div>
                    </div>
                    <div class="form-group">
                        <textarea required name="message" class="form-control" rows="5" placeholder="Message *"></textarea>
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
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary btn-main">Submit</button>
                    </div>
                </form>
            </div>
            {!! $page->contents !!}
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
