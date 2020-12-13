<?php

namespace App\Http\Controllers;

use App\Purchase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PurchaseController extends Controller
{
    private static $bearer = "47vgeb62oe8qyk395l549392y6g2hcjt";

    /**
     * Check purchase code is valid or not
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function check(Request $request)
    {
        $purchase_code = $request->input('purchase_code');
        $client_ip = $request->getClientIp();

        $validator = Validator::make($request->all(), [
            'purchase_code' => 'required',
        ], [
            'purchase_code.required' => 'Purchase code is required'
        ]);
        if ($validator->fails()) {
            //return error true, with validation error if has
            return response()->json(['error' => true, 'messages' => 'Purchase code is invalid'], 403);
        } else {
            $purchase = Purchase::where(['code' => $purchase_code])->first();
            if ($purchase) {
                if ($purchase->ip = $client_ip || $purchase->host == $request->getHost()) {
                    return response()->json(['error' => false, 'messages' => 'This is a valid purchase code.']);
                } else {
                    return response()->json(['error' => true, 'messages' => 'Sorry, This is not a valid purchase code or this user have not purchased any of your items.'], 403);
                }
            } else {
                $result = self::verifyPurchase($purchase_code);
                if (is_object($result)) {
                    $name = $result->item_name;
                    $created_at = $result->created_at;
                    $buyer = $result->buyer;
                    $licence = $result->licence;
                    $supported_until = $result->supported_until;
                    Purchase::create([
                        'name' => $name,
                        'code' => $purchase_code,
                        'host' => $request->getHost(),
                        'licence' => $licence,
                        'ip' => $client_ip,
                        'url' => $request->fullUrl(),
                        'time' => $created_at,
                        'buyer' => $buyer,
                        'supported_until' => $supported_until,
                        'status' => true
                    ]);
                    return response()->json(['error' => false, 'messages' => 'This is a valid purchase code.']);
                } else {
                    return response()->json(['error' => true, 'messages' => 'Sorry, This is not a valid purchase code or this user have not purchased any of your items.'], 403);
                }
            }
        }
    }


    static function getPurchaseData($code)
    {

        //setting the header for the rest of the api
        $bearer = 'bearer ' . self::$bearer;
        $header = array();
        $header[] = 'Content-length: 0';
        $header[] = 'Content-type: application/json; charset=utf-8';
        $header[] = 'Authorization: ' . $bearer;

        $verify_url = 'https://api.envato.com/v1/market/private/user/verify-purchase:' . $code . '.json';
        $ch_verify = curl_init($verify_url . '?code=' . $code);

        curl_setopt($ch_verify, CURLOPT_HTTPHEADER, $header);
        curl_setopt($ch_verify, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch_verify, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch_verify, CURLOPT_CONNECTTIMEOUT, 5);
        curl_setopt($ch_verify, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.13) Gecko/20080311 Firefox/2.0.0.13');

        $cinit_verify_data = curl_exec($ch_verify);
        curl_close($ch_verify);

        if ($cinit_verify_data != "")
            return json_decode($cinit_verify_data);
        else
            return false;

    }

    static function verifyPurchase($code)
    {
        $verify_obj = self::getPurchaseData($code);


        // Check for correct verify code
        if (
            (false === $verify_obj) ||
            !is_object($verify_obj) ||
            !isset($verify_obj->{"verify-purchase"}) ||
            !isset($verify_obj->{"verify-purchase"}->item_name)
        )
            return -1;

        // If empty or date present, then it's valid
        if (
            $verify_obj->{"verify-purchase"}->supported_until == "" ||
            $verify_obj->{"verify-purchase"}->supported_until != null
        )
            return $verify_obj->{"verify-purchase"};

        // Null or something non-string value, thus support period over
        return 0;

    }
}
