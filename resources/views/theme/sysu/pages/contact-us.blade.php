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
                <form>
                  <div class="form-group">
                    <select class="form-control" id="exampleFormControlSelect1">
                      <option selected="true" disabled="disabled">I am a</option>
                      <option>Supplier</option>
                      <option>Client</option>
                      <option>General Inquiry</option>
                    </select>
                  </div>
                  <div class="form-group">
                      <input id="form_name" type="text" name="name" class="form-control" placeholder="Your name *" required="required" data-error="Firstname is required.">
                  </div>
                  <div class="form-row pb-3">
                    <div class="col-md-6">
                        <input id="form_email" type="email" name="email" class="form-control" placeholder="Your email *" required="required" data-error="Valid email is required.">
                        <div class="help-block with-errors"></div>
                    </div>
                    <div class="col-md-6 mt-3 mt-md-0">
                        <input id="form_number" type="number" name="number" class="form-control" placeholder="Your contact number *" required="required" data-error="Valid email is required.">
                        <div class="help-block with-errors"></div>
                    </div>
                  </div>
                  <div class="form-group">
                      <textarea id="form_message" name="message" class="form-control" placeholder="Message *" rows="5" required data-error="Please, leave us a message."></textarea>
                      <div class="help-block with-errors"></div>
                  </div>
                  <div class="form-group">
                      <form action="" method="get">
                        <div class="g-recaptcha" data-sitekey="xxx insert your key here xxx"></div>
                      </form>
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
