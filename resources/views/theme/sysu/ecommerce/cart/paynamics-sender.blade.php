<div style="display: none;">
@php
    $merchant = Setting::paynamics_merchant();
    $convenienceFee = Setting::convenience_fee();
    $convenienceFee = (!empty($convenienceFee)) ? $convenienceFee : 0;
    $_amount = 0.00;
    $itemXml = "";
    foreach ($products as $product) {
        $totalAmount = 0;
        $price = number_format($product->product->price, 2, '.', '');
        if ($product->with_installation) {
            $installationFee = number_format($product->product->installation_fee, 2, '.', '');
            $price = $price + $installationFee;
            $totalAmount = $product->qty * $price;
        } else {
            $totalAmount = $product->qty * $price;
        }
        $_amount = $_amount + $totalAmount;
        $itemXml = $itemXml . "<Items><itemname>{$product->product->name}</itemname><quantity>{$product->qty}</quantity><amount>{$price}</amount></Items>";
    }

    $itemXml = $itemXml . "<Items><itemname>Convenience Fee</itemname><quantity>1</quantity><amount>{$convenienceFee}</amount></Items>";
    $_amount += $convenienceFee;

    $_amount = number_format($_amount,2, '.', '');

    $_mid = $merchant['id']; //<-- your merchant id
    $_requestid = $requestId;
    $_ipaddress = $_SERVER['SERVER_ADDR'];
    $_noturl = route('cart.payment-notification'); //<-- your notification url where notification of final status will be sent upon loading the transaction receipt page
    $_resurl = route('profile.sales'); // route('cart.front.checkout_completed'); //<-- your response url where transaction will be redirected after pressing continue button
    $_cancel_url = route('profile.sales'); //<-- your cancel url where transaction will be redirected if transaction is cancelled
    $_mtac_url = url('/'); //<-- your terms and condition url
    $_fname = $member->first_name;
    $_mname = $member->middle_name;
    $_lname = $member->last_name;
    $_addr1 = $member->address_street;
    $_addr2 = "";
    $_city = $member->address_city;
    $_state = $member->address_province;
    $_country = $member->address_country;
    $_zip = $member->address_zip;
    $_sec3d = "-";
    $_email = $member->email;
    $_phone = $member->phone;
    $_mobile = $member->mobile;
    $_clientip = $_SERVER['REMOTE_ADDR'];
    $_currency = "PHP";
    $_ptype = ""; // <-- if empty, all payment types available for the merchant will be shown (BN,PP,GC)
    $_mlogo_url = asset('theme/legande/images/misc/logo.png'); // <-- url of the logo to appear on the wpf page
    $forSign = $_mid . $_requestid . $_ipaddress . $_noturl . $_resurl . $_fname . $_lname . $_mname . $_addr1 . $_addr2 . $_city . $_state . $_country . $_zip . $_email . $_phone . $_clientip . $_amount . $_currency . $_sec3d;
    $cert = $merchant['key']; //<-- your merchant key


    $_sign = hash("sha512", $forSign.$cert);
    $xmlstr = "";

    $strxml = "";

    $strxml = $strxml . "<?xml version=\"1.0\" encoding=\"utf-8\" ?>";
    $strxml = $strxml . "<Request>";
    $strxml = $strxml . "<orders>";
    $strxml = $strxml . "<items>";
    //$strxml = $strxml . "<Items>";
    $strxml = $strxml . $itemXml;
    //$strxml = $strxml . "</Items>";
    $strxml = $strxml . "</items>";
    $strxml = $strxml . "</orders>";
    $strxml = $strxml . "<mid>" . $_mid . "</mid>";
    $strxml = $strxml . "<request_id>" . $_requestid . "</request_id>";
    $strxml = $strxml . "<ip_address>" . $_ipaddress . "</ip_address>";
    $strxml = $strxml . "<notification_url>" . $_noturl . "</notification_url>";
    $strxml = $strxml . "<response_url>" . $_resurl . "</response_url>";
    $strxml = $strxml . "<cancel_url>" . $_cancel_url . "</cancel_url>";
    $strxml = $strxml . "<mtac_url>" . $_mtac_url . "</mtac_url>";
    $strxml = $strxml . "<descriptor_note>'My Descriptor .18008008008'</descriptor_note>";
    $strxml = $strxml . "<fname>" . $_fname . "</fname>";
    $strxml = $strxml . "<lname>" . $_lname . "</lname>";
    $strxml = $strxml . "<mname>" . $_mname . "</mname>";
    $strxml = $strxml . "<address1>" . $_addr1 . "</address1>";
    $strxml = $strxml . "<address2>" . $_addr2 . "</address2>";
    $strxml = $strxml . "<city>" . $_city . "</city>";
    $strxml = $strxml . "<state>" . $_state . "</state>";
    $strxml = $strxml . "<country>" . $_country . "</country>";
    $strxml = $strxml . "<zip>" . $_zip . "</zip>";
    $strxml = $strxml . "<secure3d>" . $_sec3d . "</secure3d>";
    $strxml = $strxml . "<trxtype>sale</trxtype>";
    $strxml = $strxml . "<email>" . $_email . "</email>";
    $strxml = $strxml . "<phone>" . $_phone . "</phone>";
    $strxml = $strxml . "<mobile>" . $_mobile . "</mobile>";
    $strxml = $strxml . "<client_ip>" . $_clientip . "</client_ip>";
    $strxml = $strxml . "<amount>" . $_amount . "</amount>";
    $strxml = $strxml . "<currency>" . $_currency . "</currency>";
    $strxml = $strxml . "<mlogo_url>" . $_mlogo_url . "</mlogo_url>";
    $strxml = $strxml . "<pmethod>" . $_ptype . "</pmethod>";
    $strxml = $strxml . "<signature>" . $_sign . "</signature>";
    $strxml = $strxml . "</Request>";
    $b64string =  base64_encode($strxml);
    //echo "<pre>" . $strxml . "</pre><br>";
    //echo $b64string . "<br>";

@endphp

<form id="paynamicsForm" method="post" action="<?php echo $merchant['url']; ?>">
    <input type="text" name="paymentrequest" id="paymentrequest" value="<?php echo $b64string; ?>" style="width:800px">
    <input type="submit">
</form>

    <script>
        document.getElementById("paynamicsForm").submit();
    </script>
</div>
