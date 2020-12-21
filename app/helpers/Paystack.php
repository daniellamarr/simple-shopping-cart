<?php
namespace ApolloApi\helpers;

class Paystack {
  public static function initiatePayment ($email, $amount) {
    $url = "https://api.paystack.co/charge";
    $fields = [
      'email' => $email,
      'amount' => $amount * 100,
      'bank' => [
        'code' => '057',
        'account_number' => '0000000000'
      ],
      'birthday' => '1995-12-23'
    ];
    $fields_string = http_build_query($fields);
    //open connection
    $ch = curl_init();
    
    //set the url, number of POST vars, POST data
    curl_setopt($ch,CURLOPT_URL, $url);
    curl_setopt($ch,CURLOPT_POST, true);
    curl_setopt($ch,CURLOPT_POSTFIELDS, $fields_string);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
      "Authorization: Bearer sk_test_d0f1168640265a1c433348b9ebdb7b7f1258c824",
      "Cache-Control: no-cache",
    ));
    
    //So that curl_exec returns the contents of the cURL; rather than echoing it
    curl_setopt($ch,CURLOPT_RETURNTRANSFER, true); 
    
    //execute post
    $result = curl_exec($ch);
    return $result;
  }

  public static function verifyPayment ($reference) {
    $url = "https://api.paystack.co/transaction/verify/$reference";
    //open connection
    $ch = curl_init();
    
    //set the url, number of POST vars, POST data
    curl_setopt($ch,CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
      "Authorization: Bearer sk_test_d0f1168640265a1c433348b9ebdb7b7f1258c824",
      "Cache-Control: no-cache",
    ));
    
    //So that curl_exec returns the contents of the cURL; rather than echoing it
    curl_setopt($ch,CURLOPT_RETURNTRANSFER, true); 
    
    //execute post
    $result = curl_exec($ch);
    return $result;
  }

  public static function submitOtp ($reference) {
    $url = "https://api.paystack.co/charge/submit_otp";
    $fields = [
      'reference' => $reference,
      'otp' => '123456'
    ];
    $fields_string = http_build_query($fields);
    //open connection
    $ch = curl_init();
    
    //set the url, number of POST vars, POST data
    curl_setopt($ch,CURLOPT_URL, $url);
    curl_setopt($ch,CURLOPT_POST, true);
    curl_setopt($ch,CURLOPT_POSTFIELDS, $fields_string);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
      "Authorization: Bearer sk_test_d0f1168640265a1c433348b9ebdb7b7f1258c824",
      "Cache-Control: no-cache",
    ));
    
    //So that curl_exec returns the contents of the cURL; rather than echoing it
    curl_setopt($ch,CURLOPT_RETURNTRANSFER, true); 
    
    //execute post
    $result = curl_exec($ch);
    return $result;
  }

  public static function submitPhone ($reference) {
    $url = "https://api.paystack.co/charge/submit_phone";
    $fields = [
      'reference' => $reference,
      'phone' => '08012345678'
    ];
    $fields_string = http_build_query($fields);
    //open connection
    $ch = curl_init();
    
    //set the url, number of POST vars, POST data
    curl_setopt($ch,CURLOPT_URL, $url);
    curl_setopt($ch,CURLOPT_POST, true);
    curl_setopt($ch,CURLOPT_POSTFIELDS, $fields_string);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
      "Authorization: Bearer sk_test_d0f1168640265a1c433348b9ebdb7b7f1258c824",
      "Cache-Control: no-cache",
    ));
    
    //So that curl_exec returns the contents of the cURL; rather than echoing it
    curl_setopt($ch,CURLOPT_RETURNTRANSFER, true); 
    
    //execute post
    $result = curl_exec($ch);
    return $result;
  }
}
?>
