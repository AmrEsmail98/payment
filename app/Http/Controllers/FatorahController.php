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
          'InvoiceValue'       => '100',
          'DisplayCurrencyIso' => 'KWD',
          'CustomerEmail'      => 'amr@example.com',
          'CallBackUrl'        => 'https://emr.local/api/call_back',
           'ErrorUrl'           => 'https://youtube.com',
           'Language'           => 'en'

     ];
      return $this->fatoorahServices->sendPayment($data);
 }
 public function paymentCallBack(Request $request)
 {
     $data=[];
     $data['Key']=$request->paymentId;
     $data['KeyType'] ='paymentId';

 $paymentData=$this->fatoorahServices->getPaymentStatus($data);
 return $paymentData['Data']['InvoiceId'];

 }

}
