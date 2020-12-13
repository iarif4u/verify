<?php

if (!function_exists('DummyFunction')) {

    /**
     * description
     *
     * @param
     * @return
     */
    function DummyFunction()
    {

    }
}

//execute curl request
function curlExecution($url)
{
    // Get cURL resource
    $curl = curl_init();
    // Set some options - we are passing in a useragent too here
    curl_setopt_array($curl, array(
        CURLOPT_RETURNTRANSFER => 1,
        CURLOPT_URL => $url,
        CURLOPT_USERAGENT => 'Codular Sample cURL Request'
    ));
    // Send the request & save response to $resp
    $resp = curl_exec($curl);
    // Close request to clear up some resources
    if (!curl_exec($curl)) {
        return ['error' => true, 'error_txt' => curl_error($curl), 'code' => curl_errno($curl)];

    }
    curl_close($curl);
    return ['error' => false, 'response' => $resp];
}

// this function will cut the string by how many words you want
function word_teaser($string, $count = 20)
{
    $original_string = $string;
    $words = explode(' ', $original_string);

    if (count($words) > $count) {
        $words = array_slice($words, 0, $count);
        $string = implode(' ', $words);
    }
    return closetags($string);
}

// this function will cut the string by how many words you want
function word_trim($string, $count = 20)
{
    $words = explode('-', word_teaser($string, $count));

    if (count($words) > $count) {
        $words = array_slice($words, 0, $count);
        $string = implode(' ', $words);
    }
    return closetags($string);
}


// this function will get the remaining words
function word_teaser_end($string, $count = 20)
{
    $words = explode(' ', $string);
    $words = array_slice($words, $count);
    $string = implode(' ', $words);
    return closetags($string);
}


function closetags($html)
{
    preg_match_all('#<(?!meta|img|br|hr|input\b)\b([a-z]+)(?: .*)?(?<![/|/ ])>#iU', $html, $result);
    $openedtags = $result[1];
    preg_match_all('#</([a-z]+)>#iU', $html, $result);
    $closedtags = $result[1];
    $len_opened = count($openedtags);
    if (count($closedtags) == $len_opened) {
        return $html;
    }
    $openedtags = array_reverse($openedtags);
    for ($i = 0; $i < $len_opened; $i++) {
        if (!in_array($openedtags[$i], $closedtags)) {
            $html .= '</' . $openedtags[$i] . '>';
        } else {
            unset($closedtags[array_search($openedtags[$i], $closedtags)]);
        }
    }
    return $html;
}

function activeMenu($route, $output = "active")
{
    if (\Illuminate\Support\Facades\Route::currentRouteName() == $route) return $output;
}

function areActiveRoutes(Array $routes, $output = "active")
{
    foreach ($routes as $route) {
        if (\Illuminate\Support\Facades\Route::currentRouteName() == $route) return $output;
    }

}

function isCurrentRoute($route)
{
    return (\Illuminate\Support\Facades\Route::currentRouteName() == $route) ? true : false;
}

function is_image_file($file)
{
    $image = ['jpg', 'jpeg', 'png', 'bmp'];
    if (in_array(strtolower(pathinfo($file, PATHINFO_EXTENSION)), $image)) {
        return true;
    }
    return false;

}

function is_pdf_file($file)
{
    $image = ['pdf'];
    if (in_array(strtolower(pathinfo($file, PATHINFO_EXTENSION)), $image)) {
        return true;
    }
    return false;

}

function is_word_file($file)
{
    $image = ['docx', 'doc'];
    if (in_array(strtolower(pathinfo($file, PATHINFO_EXTENSION)), $image)) {
        return true;
    }
    return false;
}

function is_zip_file($file)
{
    $image = ['zip', 'rar'];
    if (in_array(strtolower(pathinfo($file, PATHINFO_EXTENSION)), $image)) {
        return true;
    }
    return false;
}

function is_url_exist($url)
{
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_NOBODY, true);
    curl_exec($ch);
    $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);

    if ($code == 200) {
        $status = true;
    } else {
        $status = false;
    }
    curl_close($ch);
    return $status;
}

function bn2enNumber($number)
{
    $search_array = array("১", "২", "৩", "৪", "৫", "৬", "৭", "৮", "৯", "০");
    $replace_array = array("1", "2", "3", "4", "5", "6", "7", "8", "9", "0");
    $en_number = str_replace($search_array, $replace_array, $number);

    return $en_number;
}

function en2bnNumber($number)
{
    $replace_array = array("১", "২", "৩", "৪", "৫", "৬", "৭", "৮", "৯", "০", 'মধ্যাহ্ন', 'অপরাহ্ন');
    $search_array = array("1", "2", "3", "4", "5", "6", "7", "8", "9", "0", 'AM', 'PM');
    $en_number = str_replace($search_array, $replace_array, $number);

    return $en_number;
}

function send_custom_mail($to, $subject, $link)
{
    $subject = "Password Reset";
    $txt = "Dear Customer,
    You are receiving this email because we received a password reset request for your account.
    Password reset link: " . $link . "
    Thanks
    ThemeHappy SMS";
    $headers = "From:no-reply@themehayyy.com";

    mail($to, $subject, $txt, $headers);
}

function generateRandomString($length = 10)
{
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

function cr_y_pt($string, $action = 'd')
{
// you may change these values to your own
    $secret_key = 'my_simple_secret_key';
    $secret_iv = 'my_simple_secret_iv';

    $output = false;
    $encrypt_method = "AES-256-CBC";
    $key = hash('sha256', $secret_key);
    $iv = substr(hash('sha256', $secret_iv), 0, 16);

    if ($action == 'e') {
        $output = base64_encode(openssl_encrypt($string, $encrypt_method, $key, 0, $iv));
    } else if ($action == 'd') {
        $output = openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0, $iv);
    }
    return $output;
}
