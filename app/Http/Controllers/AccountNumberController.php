<?php

namespace App\Http\Controllers;

class AccountNumberController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function getToken(){
        $api_key = 'ts_VZJ5K36HYKSVE4VRS5VC';
        $secret_key = 'ts_09443SHY1WRF56TZBYRK0Z55OOO68C';

        \Unirest\Request::verifyPeer(false);

        $headers = array('content-type' => 'application/json'); 
        $query =  array('apiKey' => $api_key, 'secret' => $secret_key);

        $body = \Unirest\Request\Body::json($query);

        $response = \Unirest\Request::post('https://moneywave.herokuapp.com/v1/merchant/verify', $headers, $body);

        $response = json_decode($response->raw_body, TRUE);

        $status = $response['status'];

            if (! $status == 'success') {
                echo 'INVALID TOKEN';
            } else {

                $token = $response['token'];

                return $token;
            }
        }

    public function accountResolve() {
        $token = $this->getToken();
        $headers = array('content-type' => 'application/json','Authorization'=> $token);
        $query = array('account_number'=> "0719217876",'bank_code' => "044");
        $body = \Unirest\Request\Body::json($query);
        $response = \Unirest\Request::post('https://moneywave.herokuapp.com/v1/resolve/account', $headers, $body);

        $data=json_decode($response->raw_body, true);
        $status = $data['status'];
        var_dump($status);
    }
    //
}
