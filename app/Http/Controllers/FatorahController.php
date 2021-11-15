<?php

namespace App\Http\Controllers;
use App\Http\Services\FatoorahServices;
use Illuminate\Http\Request;

class FatorahController extends Controller
{

    private $fatoorahServices;
    public function __construct(FatoorahServices $FatoorahServices)
    {
            $this ->fatoorahServices =$FatoorahServices;
    }

 public function payOrder(){
     $data=[
        'CustomerName'       => 'Amr Esmail',
        'NotificationOption' => 'Lnk',
          'CustomerMobile'     => '01090807013',
          'InvoiceValue'       => '500',
          'DisplayCurrencyIso' => 'KWD',
          'CustomerEmail'      => 'amr@example.com',
          'CallBackUrl'        => 'https://emr.local/call_back',
           'ErrorUrl'           => 'http://google.com',
           'Language'           => 'en'

     ];
      return $data= $this->fatoorahServices->sendPayment($data);
 }
 public function paymentCallBack(Request $request)
 {
     $data=[];
     $data['Key']=$request->paymentId;
     $data['KeyType'] ='paymentId';

 $paymentData=$this->fatoorahServices->getPaymentStatus($data);
 return $paymentData['Data']['InvoiceId'];
// return $this->fatoorahServices->getPaymentStatus($data);
 }
}
