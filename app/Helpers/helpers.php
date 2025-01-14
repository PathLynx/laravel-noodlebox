<?php

use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Storage;

/**
 * @return int|mixed
 */
function appversion()
{
    return env('APP_DEBUG') ? time() : env('APP_VERSION', 1.0);
}

/**
 * @param $str
 * @param $length
 * @param string $dot
 * @return string
 */
function mbsubstr($str, $length, $dot = '...')
{
    if (mb_strlen($str) <= $length) return $str;
    return mb_substr($str, 0, $length - strlen($dot)) . $dot;
}

/**
 * 计算两点之间的距离
 * @param $lat1
 * @param $lng1
 * @param $lat2
 * @param $lng2
 * @return float
 */
function distance($lat1, $lng1, $lat2, $lng2)
{
    $earthRadius = 6377830;
    $lat1 = ($lat1 * pi()) / 180;
    $lng1 = ($lng1 * pi()) / 180;

    $lat2 = ($lat2 * pi()) / 180;
    $lng2 = ($lng2 * pi()) / 180;

    $calcLongitude = $lng2 - $lng1;
    $calcLatitude = $lat2 - $lat1;
    $stepOne = pow(sin($calcLatitude / 2), 2) + cos($lat1) * cos($lat2) * pow(sin($calcLongitude / 2), 2);
    $stepTwo = 2 * asin(min(1, sqrt($stepOne)));
    $calculatedDistance = $earthRadius * $stepTwo;
    return round($calculatedDistance);
}

/**
 * @param $lng
 * @param $lat
 * @param $distance
 * @param $rad
 * @return array
 */
function get_coordinate_range($lng, $lat, $distance = 1, $rad = 6371)
{
    $dlng = 2 * asin(sin($distance / (2 * $rad)) / cos(deg2rad($lat)));
    $dlng = rad2deg($dlng);

    $dlat = $distance / $rad;
    $dlat = rad2deg($dlat);

    return [
        'lng-min' => $lng - $dlng,
        'lng-max' => $lng + $dlng,
        'lat-min' => $lat - $dlat,
        'lat-max' => $lat + $dlat
    ];
}

/**
 * 格式化距离
 * @param string $distance
 * @return string
 */
function format_distance($distance)
{
    if (!$distance) return '';
    if ($distance < 1000) {
        return $distance . 'm';
    } else {
        return number_format($distance / 1000, 2) . 'km';
    }
}

/**
 * 去除HTML代码和空格
 * @param string $str
 * @return mixed
 */
function strip_html($str)
{
    $str = strip_tags($str);
    $str = str_replace('&amp;', '&', $str);
    $str = str_replace(array('&ldquo;', '&rdquo;'), array('“', '”'), $str);
    $str = preg_replace('/\s|\n\r|　/', '', $str);
    return $str;
}

/**
 * 格式化文件尺寸
 * @param number $size
 * @return string
 */
function format_size($size)
{
    $sizes = array(" Bytes", " KB", " MB", " GB", " TB", " PB", " EB", " ZB", " YB");
    if ($size == 0) {
        return ('n/a');
    } else {
        return (round($size / pow(1024, ($i = floor(log($size, 1024)))), 2) . $sizes[$i]);
    }
}

/**
 * @param $money
 * @return string
 */
function format_amount($money)
{
    return number_format($money, 2, '.', '');
}

/**
 * @param $count
 * @return string
 */
function format_count($count)
{
    if ($count > 10000) {
        return round($count / 10000, 2) . 'w';
    } else {
        return $count;
    }
}

/**
 * 清除文档格式
 */
function clean_style($str)
{
    $str = preg_replace('/\s*mso-[^:]+:[^;"]+;?/i', "", $str);
    $str = preg_replace('/\s*margin(.*?)pt\s*;/i', "", $str);
    $str = preg_replace('/\s*margin(.*?)cm\s*;/i', "", $str);
    $str = preg_replace('/\s*text-indent:(.*?)\s*;/i', "", $str);
    $str = preg_replace('/\s*line-height:(.*?)\s*;/i', "", $str);
    $str = preg_replace('/\s*page-break-before: [^\s;]+;?"/i', "", $str);
    $str = preg_replace('/\s*font-variant: [^\s;]+;?"/i', "", $str);
    $str = preg_replace('/\s*tab-stops:[^;"]*;?/i', "", $str);
    $str = preg_replace('/\s*tab-stops:[^"]*/i', "", $str);
    $str = preg_replace('/\s*face="[^"]*"/i', "", $str);
    $str = preg_replace('/\s*face=[^ >]*/i', "", $str);
    $str = preg_replace('/\s*font:(.*?);/i', "", $str);
    $str = preg_replace('/\s*font-size:(.*?);/i', "", $str);
    $str = preg_replace('/\s*font-weight:(.*?);/i', "", $str);
    $str = preg_replace('/\s*font-family:[^;"]*;?/i', "", $str);
    $str = preg_replace('/<span style="Times New Roman&quot;">\s\n<\/span>/i', "", $str);
    return $str;
}

/**
 * @param string $path
 * @return string
 */
function material_path($path = '')
{
    return Storage::path($path);
}

/**
 * @param string $path
 * @return string
 */
function material_url($path = '')
{
    if (URL::isValidUrl($path)) return $path;
    return Storage::url($path);
}

/**
 * @param $path
 * @return string
 */
function image_url($path = '')
{
    if (URL::isValidUrl($path)) {
        return $path;
    }

    if ($path) {
        return material_url($path);
    }

    return asset('images/common/nopic.png');
}

/**
 * @param $url
 * @return string|string[]
 */
function strip_image_url($url)
{
    return $url ? str_replace(material_url(), '', $url) : $url;
}

/**
 * @param $path
 * @return \Illuminate\Contracts\Routing\UrlGenerator|string
 */
function admin_url($path = '')
{
    return url('admin/' . trim($path, '/'));
}

/**
 * @return bool
 */
function is_wechat()
{
    return strpos($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger') !== false;
}

/**
 * @param $data
 * @param $options
 * @return \Illuminate\Http\JsonResponse
 */
function json_success($data = [], $options = JSON_UNESCAPED_UNICODE)
{
    return response()->json([
        'code' => 0,
        'data' => $data
    ], 200, [], $options);
}

/**
 * @param $message
 * @param $code
 * @param $errors
 * @return \Illuminate\Http\JsonResponse
 */
function json_error($message, $code = 422, $errors = null)
{
    $response = [
        'code' => $code,
        'message' => $message,
    ];
    if ($errors) {
        $response['errors'] = $errors;
    }
    return response()->json($response, $code, [], JSON_UNESCAPED_UNICODE);
}

require __DIR__ . '/hooks.php';
require __DIR__ . '/settings.php';
require __DIR__ . '/misc.php';
require __DIR__ . '/block.php';
require __DIR__ . '/page.php';
require __DIR__ . '/category.php';
require __DIR__ . '/post.php';
require __DIR__ . '/product.php';