<?php

// Search string get and set an url
use App\Models\Discount;
use Gloudemans\Shoppingcart\Facades\Cart;

if ( ! function_exists('qString')) {
    function qString($query = null)
    {
        if (isset($_SERVER['QUERY_STRING'])) {
            return '?'.$_SERVER['QUERY_STRING'].$query;
        } else {
            if ($query) {
                return '?'.$query;
            }
        }
    }
}

// Date View
if ( ! function_exists('dateFormat')) {
    function dateFormat($date, $time = null)
    {
        if ($time) {
            return date('d/M/Y h:i A',(strtotime($date)));
        } else {
            return date('d/M/Y',strtotime($date));
        }
    }
}

// Time View
if ( ! function_exists('timeFormat')) {
    function timeFormat($date)
    {
        return date('h:i A',(strtotime($date)));
    }
}

// Two Digit Number Format Function
if ( ! function_exists('numberFormat')) {
    function numberFormat($amount=0, $coma=null)
    {
        if ($coma) {
            if ($amount==0)
                return '-';
            else
                return number_format($amount,2);
        } else {
            return number_format($amount,2,'.','');
        }
    }
}

// Two Digit Number Format Function
if ( ! function_exists('excerpt')) {
    function excerpt($text, $limit=200)
    {
        if (strlen(strip_tags($text)) > $limit) {
            return substr(strip_tags($text), 0, $limit).'...';
        } else {
            return strip_tags($text);
        }
    }
}

// For image view if image exists with lightbox (yes/no).
// ['thumb' => 1, 'popup' => 1, 'class' => '', 'style' =>'', 'fakeimg' => 'avatar']
if ( ! function_exists('viewImg')) {
    function viewImg($path, $name, $array = null)
    {
        $path = 'storage/'.$path;
        $thumb = (isset($array['thumb']))?'thumb/':'';
        $class = (isset($array['class']))?'class="'.$array['class'].'"':'';
        $id = (isset($array['id']))?'id="'.$array['id'].'"':'';
        $style = (isset($array['style']))?'style="'.$array['style'].'"':'';
        $title = (isset($array['title']))?$array['title']:'';
        if ($name!= '' && file_exists($path.'/'.$thumb.$name)) {
            $path = url('/'.$path).'/';
            if (isset($array['popup'])) {
                return '<a href="'.$path.$name.'" data-fancybox="group" data-fancybox data-caption="'.$title.'" class="lytebox" data-lyte-options="group:vacation"><img src="'.$path.$thumb.$name.'" alt="'.$title.'" '.$class.$id.' '.$style.'></a>';
            } else {
                return '<img src="'.$path.$thumb.$name.'" alt="'.$title.'" '.$class.$id.' '.$style.'>';
            }
        } else {
            if (isset($array['fakeimg'])) {
                return '<img src="'.url('/assets/img/'.$array['fakeimg']).'.png" alt="'.$array['fakeimg'].'" '.$class.$id.' '.$style.'>';
            } else {
                return '';
            }
        }
    }
}

if ( ! function_exists('numberToWord')) {
    function numberToWord($number)
    {
        if (($number < 0) || ($number > 999999999)) {
            throw new Exception("Number is out of range");
        }
        $Gn = floor($number / 1000000);
        /* Millions (giga) */
        $number -= $Gn * 1000000;
        $kn = floor($number / 1000);
        /* Thousands (kilo) */
        $number -= $kn * 1000;
        $Hn = floor($number / 100);
        /* Hundreds (hecto) */
        $number -= $Hn * 100;
        $Dn = floor($number / 10);
        /* Tens (deca) */
        $n = $number % 10;
        /* Ones */
        $res = "";
        if ($Gn) {
            $res .= numberToWord($Gn) .  "Million";
        }
        if ($kn) {
            $res .= (empty($res) ? "" : " ") .numberToWord($kn) . " Thousand";
        }
        if ($Hn) {
            $res .= (empty($res) ? "" : " ") .numberToWord($Hn) . " Hundred";
        }
        $ones = array("", "One", "Two", "Three", "Four", "Five", "Six", "Seven", "Eight", "Nine", "Ten", "Eleven", "Twelve", "Thirteen", "Fourteen", "Fifteen", "Sixteen", "Seventeen", "Eightteen", "Nineteen");
        $tens = array("", "", "Twenty", "Thirty", "Fourty", "Fifty", "Sixty", "Seventy", "Eigthy", "Ninety");
        if ($Dn || $n) {
            if (!empty($res)) {
                $res .= " and ";
            }
            if ($Dn < 2) {
                $res .= $ones[$Dn * 10 + $n];
            } else {
                $res .= $tens[$Dn];
                if ($n) {
                    $res .= "-" . $ones[$n];
                }
            }
        }
        if (empty($res)) {
            $res = "zero";
        }
        return $res;
    }
}
//Make url slug
if ( ! function_exists('urlSlug')) {
    function urlSlug($text)
    {
        $text = str_replace(' ', '-', $text);
        $text = preg_replace('/[^A-Za-z0-9\-]/', '', $text);
        $text = trim($text);
        $text = str_replace('--', '-', $text);
        return strtolower($text);
    }
}

//List Action: (show, edit, delete, activity, custom)
if ( ! function_exists('listAction')) {
    function listAction($array = [])
    {
        if (!empty($array)) {
            echo '<div class="dropdown">
                <a class="btn btn-success btn-flat btn-xs dropdown-toggle" type="button" data-toggle="dropdown">Action <span class="caret"></span></a>
                <ul class="dropdown-menu dropdown-menu-right">';

            echo implode('', $array);

            echo '</ul>
            </div>';
        } else {
            echo '<div class="text-center">--</div>';
        }
    }

    function actionLi($url, $type, $access = 1, $array = [])
    {
        if ($access) {
            if ($type=='show') {
                return '<li><a href="'.$url.'"><i class="fa fa-eye"></i> Show</a></li>';
            } elseif ($type=='edit') {
                return '<li><a href="'.$url.'"><i class="fa fa-pencil"></i> Edit</a></li>';
            } elseif ($type=='delete') {
                return '<li><a onclick="deleted(\''.$url.'\')"><i class="fa fa-close"></i> Delete</a></li>';
            } elseif ($type=='activity') {
                $actReturn = '';
                if ($array['status']==2 || $array['status']==0) {
                    $actReturn .= '<li><a onclick="activity(\''.$url.'/1\')"><i class="fa fa-check-square-o"></i> Active</a></li>';
                }

                if ($array['status']==1 || $array['status']==0) {
                    $actReturn .=  '<li><a onclick="activity(\''.$url.'/2\')"><i class="fa fa-ban"></i> Inactive</a></li>';
                }
                return $actReturn;
            } elseif ($type=='custom') {
                $link = (isset($array['onclick']))?'onclick='.$array['onclick'].'(\''.$url.'\')"':'href="'.$url.'"';
                return '<li><a href="'.$url.'">'.$array['icon'].'</a></li>';
            }
        }
    }

    //show size

    if ( ! function_exists('getFileSizeUnits')) {
        function getFileSizeUnits($bytes)
        {
            if ($bytes >= 1073741824) {
                $bytes = number_format($bytes / 1073741824, 2) . ' GB';
            } elseif ($bytes >= 1048576) {
                $bytes = number_format($bytes / 1048576, 2) . ' MB';
            } elseif ($bytes >= 1024) {
                $bytes = number_format($bytes / 1024, 2) . ' KB';
            } elseif ($bytes > 1) {
                $bytes = $bytes . ' bytes';
            } elseif ($bytes == 1) {
                $bytes = $bytes . ' byte';
            } else {
                $bytes = '0 bytes';
            }
            return $bytes;
        }
    }
}

/**
 * Check if string starts with the specified character/string.
 *
 * @param  string haystack
 * @param  string needle
 * @return bool
 */
function startsWith( $haystack, $needle ) {
    $length = strlen( $needle );

    return substr( $haystack, 0, $length ) === $needle;
}

/**
 * Check if string ends with the specified character/string.
 *
 * @param  string haystack
 * @param  string needle
 * @return bool
 */
function endsWith( $haystack, $needle ) {
    $length = strlen( $needle );

    if( !$length ) {
        return true;
    }

    return substr( $haystack, -$length ) === $needle;
}

/**
 * Get store.
 *
 * @return bool
 */
function getStore() {
    if (endsWith(url('/'), "." . env('DOMAIN'))) {
        $subdomain = str_replace(['http://', 'https://'],"",join('.', explode('.', url('/'), -2)));
        $store = \App\Models\Store::where('domain', $subdomain)->first();
    } else {
        $store = \App\Models\Store::where('domain', str_replace(['http://', 'https://'], '', url('/')))->first();
    }

    if (!$store) {
        abort(404);
    }

    return $store;
}

if ( ! function_exists('discountPercentage')) {
    function discountPercentage ($originalPrice, $discount) {
        $discountedPrice = $originalPrice - ($originalPrice * $discount / 100);
        return $discountedPrice;
    }
}

if ( ! function_exists('getAllDiscountType')) {
    function getAllDiscountType ($code = null) {
        $today = date('Y-m-d h:i:s');
        $subTotal = Cart::subtotal('2', '.', '');
        if (isset($code)) {
            $discount = Discount::where('discount_type', 'code')
                ->where('code', $code)
                ->whereDate('start','<=', $today)
                ->whereDate('end','>=', $today)
                ->where('status', 'active')
                ->first();

            if (!empty($discount)){
                if ($discount->type == 'percentage' && $discount->applies_to == 'all') {
                    $totalAmount = discountPercentage($subTotal, $discount->value);
                } else {
                    $totalAmount = $subTotal - $discount->value;
                }

            } else {
                return 'invalid';
            }
        } else {
            $discount = Discount::where('discount_type', 'automatic')
                ->whereDate('start','<=', $today)
                ->whereDate('end','>=', $today)
                ->where('status', 'active')
                ->first();

            if (!empty($discount)) {
                if ($discount->type == 'percentage' && $discount->applies_to == 'all') {
                    $totalAmount = discountPercentage($subTotal, $discount->value);
                } else {
                    $totalAmount = $subTotal - $discount->value;
                }
            } else {
                $totalAmount = $subTotal;
            }

            return $totalAmount;
        }
    }
}

// Get Ip address
if (!function_exists('getIpAddress')) {
    function getIpAddress(){
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
            $ip = $_SERVER['REMOTE_ADDR'];
        }
        return $ip;
    }
}

if (!function_exists('getCountryInfo')) {
    function getCountryInfo(){
        $ip = getIpAddress();
        //$ip = '103.239.252.115'; // Your static ip
        $country = json_decode(file_get_contents("http://www.geoplugin.net/json.gp?ip=" . $ip));
        return $country;
    }
}

if (!function_exists('webThemeCheck')) {
    function webThemeCheck() {
        $storeTheme = \request()->store->theme;
        if (!empty($storeTheme)) {
            return $storeTheme->path.'.';
        } else {
            return 'themes.demo.';
        }
    }
}

if (!function_exists('webThemeAsset')) {
    function webThemeAsset() {
        $storeTheme = \request()->store->theme;
        if (!empty($storeTheme)) {
            return   str_replace('.', '/', $storeTheme->path);
        } else {
            return 'themes/demo';
        }
    }
}



