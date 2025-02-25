<?php

use App\Models\UserMeta;
use Carbon\Carbon;
use App\Models\Option;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;


function send_sms($mobile, $message)
{
    $user = 'reseller09128458010';
    $pass = 'Fanweb@2021#';
    $fromNum = '+983000505';
    $input_data = array(
        'verification-code' => $message,
    );
    $rcpt_nm = array($mobile);
    $pattern_code = 'iica8tcb9a3up27'; // pattern code
    $url = 'https://ippanel.com/patterns/pattern?username=' . $user . '&password=' . urlencode($pass) . '&from=' . $fromNum . '&to=' . json_encode($rcpt_nm) . '&input_data=' . urlencode(json_encode($input_data)) . '&pattern_code=' . $pattern_code;
    $handler = curl_init($url);
    curl_setopt($handler, CURLOPT_CUSTOMREQUEST, 'POST');
    curl_setopt($handler, CURLOPT_POSTFIELDS, $input_data);
    curl_setopt($handler, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($handler);
}


function insert_user_meta($user_id, $key, $value)
{
    $meta = new UserMeta();
    $meta->user_id = $user_id;
    $meta->key = $key;
    $meta->value = serialize($value);
    $meta->save();
}


function active_class($route_name, $class = 'active')
{
    return Route::is($route_name) || Route::is(app()->getLocale() . '.' . $route_name) ? $class : '';
}

function open_class($route_list, $class = 'active')
{
    $text = '';

    foreach ($route_list as $route) {
        if (Route::is($route) || Route::is(app()->getLocale() . '.' . $route)) {
            $text = $class;
            break;
        }
    }

    return $text;
}

function option_update($option_name, $option_value)
{
    $option = Option::firstOrNew([
        'option_name' => $option_name,
        'lang'        => app()->getLocale(),
    ]);

    $option->option_value = $option_value;
    $option->save();

    Cache::forever('options.' . app()->getLocale() . '.' . $option_name, $option_value);
}

function option($option_name, $default_value = '')
{
    $non_language_options = config('general.non_language_options');

    if ($non_language_options && in_array($option_name, $non_language_options)) {
        $language = 'fa';
    } else {
        $language = app()->getLocale();
    }

    $value = Cache::rememberForever('options.' . $language . '.' . $option_name, function () use ($option_name, $default_value, $language) {
        $option = Option::where('option_name', $option_name)
            ->where('lang', $language)
            ->first();

        if ($option) {
            return is_null($option->option_value) ? false : $option->option_value;
        }

        return $default_value;
    });

    if (is_null($value) || $value === false) {
        return $default_value;
    }

    return  $value;
}



function short_content($str, $words = 20, $strip_tags = true)
{
    if ($strip_tags) {
        $str = strip_tags($str);
    }

    return Str::words($str, $words);
}


function array_to_string($array)
{
    $comma_separated = implode("','", $array);
    $comma_separated = "'" . $comma_separated . "'";
    return $comma_separated;
}

function convert2english($string)
{
    $newNumbers = range(0, 9);
    // 1. Persian HTML decimal
    $persianDecimal = array('&#1776;', '&#1777;', '&#1778;', '&#1779;', '&#1780;', '&#1781;', '&#1782;', '&#1783;', '&#1784;', '&#1785;');
    // 2. Arabic HTML decimal
    $arabicDecimal = array('&#1632;', '&#1633;', '&#1634;', '&#1635;', '&#1636;', '&#1637;', '&#1638;', '&#1639;', '&#1640;', '&#1641;');
    // 3. Arabic Numeric
    $arabic = array('٠', '١', '٢', '٣', '٤', '٥', '٦', '٧', '٨', '٩');
    // 4. Persian Numeric
    $persian = array('۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹');

    $string =  str_replace($persianDecimal, $newNumbers, $string);
    $string =  str_replace($arabicDecimal, $newNumbers, $string);
    $string =  str_replace($arabic, $newNumbers, $string);
    return str_replace($persian, $newNumbers, $string);
}

function carbon($string)
{
    return Carbon::createFromFormat('Y-m-d H:i:s', $string, 'Asia/Tehran')->timestamp;
}

function datatable($request, $query)
{
    $page = 1;

    if ($request->pagination && isset($request->pagination['page'])) {
        $page = $request->pagination['page'];
    }

    $columns = ['*'];
    $pageName = 'page';
    $perPage = 10;

    if ($request->pagination && isset($request->pagination['perpage']) && $request->pagination['perpage'] > 0) {
        $perPage = $request->pagination['perpage'];
    }

    if ($query->paginate($perPage, $columns, $pageName, $page)->lastPage() >= $page) {
        return $query->paginate($perPage, $columns, $pageName, $page);
    } else {
        return $query->paginate($perPage, $columns, $pageName, 1);
    }
}

function remove_id_from_url($id)
{
    $segments = request()->segments();

    if (($key = array_search($id, $segments)) !== false) {
        unset($segments[$key]);
    }

    return url(implode('/', $segments));
}

function get_separated_values($array, $separator)
{
    if (!$separator) {
        return $array;
    }

    $result = [];

    foreach ($array as $item) {
        foreach (explode($separator, $item) as $val) {
            $result[] = trim($val);
        }
    }

    return array_unique($result);
}

function get_option_property($obj, $property)
{
    $obj = json_decode($obj);

    if (!is_object($obj)) {
        return null;
    }

    if (property_exists($obj, $property)) {
        return $obj->$property;
    }

    return null;
}

function change_env($key, $value)
{
    // Read .env-file
    $env = file_get_contents(base_path() . '/.env');

    // Split string on every " " and write into array
    $env = preg_split('/\s+/', $env);

    $key_exists = false;

    // Loop through .env-data
    foreach ($env as $env_key => $env_value) {

        // Turn the value into an array and stop after the first split
        // So it's not possible to split e.g. the App-Key by accident
        $entry = explode("=", $env_value, 2);

        // Check, if new key fits the actual .env-key
        if ($entry[0] == $key) {
            // If yes, overwrite it with the new one
            $env[$env_key] = $key . "=" . $value;
            $key_exists = true;
        } else {
            // If not, keep the old one
            $env[$env_key] = $env_value;
        }
    }

    if (!$key_exists) {
        $env[] = $key . "=" . $value;
    }

    // Turn the array back to an String
    $env = implode("\n", $env);

    // And overwrite the .env with the new data
    file_put_contents(base_path() . '/.env', $env);

    Artisan::call('config:cache');
}

function str_random($length)
{
    return Str::random($length);
}

function get_svg_contents($path, $default = '')
{
    if (file_exists(public_path($path))) {

        $file_parts = pathinfo($path);

        if ($file_parts['extension'] == 'svg') {
            return file_get_contents(public_path($path));
        }
    }

    return $default;
}

function to_sql($query)
{
    return vsprintf(str_replace(['?'], ['\'%s\''], $query->toSql()), $query->getBindings());
}


function ellips_text($str, $char)
{
    $out = mb_strlen($str, 'utf-8') > $char ? mb_substr($str, 0, $char, 'utf-8') . "..." : $str;

    return $out;
}

function sluggable_helper_function($string, $separator = '-')
{
    $_transliteration = [
        "/ö|œ/" => "e",
        "/ü/" => "e",
        "/Ä/" => "e",
        "/Ü/" => "e",
        "/Ö/" => "e",
        "/À|Á|Â|Ã|Å|Ǻ|Ā|Ă|Ą|Ǎ/" => "",
        "/à|á|â|ã|å|ǻ|ā|ă|ą|ǎ|ª/" => "",
        "/Ç|Ć|Ĉ|Ċ|Č/" => "",
        "/ç|ć|ĉ|ċ|č/" => "",
        "/Ð|Ď|Đ/" => "",
        "/ð|ď|đ/" => "",
        "/È|É|Ê|Ë|Ē|Ĕ|Ė|Ę|Ě/" => "",
        "/è|é|ê|ë|ē|ĕ|ė|ę|ě/" => "",
        "/Ĝ|Ğ|Ġ|Ģ/" => "",
        "/ĝ|ğ|ġ|ģ/" => "",
        "/Ĥ|Ħ/" => "",
        "/ĥ|ħ/" => "",
        "/Ì|Í|Î|Ï|Ĩ|Ī| Ĭ|Ǐ|Į|İ/" => "",
        "/ì|í|î|ï|ĩ|ī|ĭ|ǐ|į|ı/" => "",
        "/Ĵ/" => "",
        "/ĵ/" => "",
        "/Ķ/" => "",
        "/ķ/" => "",
        "/Ĺ|Ļ|Ľ|Ŀ|Ł/" => "",
        "/ĺ|ļ|ľ|ŀ|ł/" => "",
        "/Ñ|Ń|Ņ|Ň/" => "",
        "/ñ|ń|ņ|ň|ŉ/" => "",
        "/Ò|Ó|Ô|Õ|Ō|Ŏ|Ǒ|Ő|Ơ|Ø|Ǿ/" => "",
        "/ò|ó|ô|õ|ō|ŏ|ǒ|ő|ơ|ø|ǿ|º/" => "",
        "/Ŕ|Ŗ|Ř/" => "",
        "/ŕ|ŗ|ř/" => "",
        "/Ś|Ŝ|Ş|Ș|Š/" => "",
        "/ś|ŝ|ş|ș|š|ſ/" => "",
        "/Ţ|Ț|Ť|Ŧ/" => "",
        "/ţ|ț|ť|ŧ/" => "",
        "/Ù|Ú|Û|Ũ|Ū|Ŭ|Ů|Ű|Ų|Ư|Ǔ|Ǖ|Ǘ|Ǚ|Ǜ/" => "",
        "/ù|ú|û|ũ|ū|ŭ|ů|ű|ų|ư|ǔ|ǖ|ǘ|ǚ|ǜ/" => "",
        "/Ý|Ÿ|Ŷ/" => "",
        "/ý|ÿ|ŷ/" => "",
        "/Ŵ/" => "",
        "/ŵ/" => "",
        "/Ź|Ż|Ž/" => "",
        "/ź|ż|ž/" => "",
        "/Æ|Ǽ/" => "E",
        "/ß/" => "s",
        "/Ĳ/" => "J",
        "/ĳ/" => "j",
        "/Œ/" => "E",
        "/ƒ/" => "",
    ];
    $quotedReplacement = preg_quote($separator, '/');
    $merge = [
        '/[^\s\p{Zs}\p{Ll}\p{Lm}\p{Lo}\p{Lt}\p{Lu}\p{Nd}]/mu' => ' ',
        '/[\s\p{Zs}]+/mu' => $separator,
        sprintf('/^[%s]+|[%s]+$/', $quotedReplacement, $quotedReplacement) => '',
    ];
    $map = $_transliteration + $merge;
    unset($_transliteration);
    return preg_replace(array_keys($map), array_values($map), $string);
}


function convertPersianToEnglish($string)
{
    $persian = ['۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹'];
    $english = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9'];

    $output = str_replace($persian, $english, $string);
    return $output;
}

function get_langs()
{
    return config('app.locales');
}

function get_current_url($lang)
{
    $locale = request()->segment(1);
    $current_url = request()->url();

    if (!$locale || !array_key_exists($locale, get_langs())) {
        $index = url('/');

        $url = str_replace_first($index, $index . '/' . $lang, $current_url);
    } else {
        $url = str_replace_first($locale, $lang, $current_url);
    }

    return $url;
}

function local_info()
{
    $local = app()->getLocale();

    $locals = get_langs();

    return $locals[$local];
}

function locale_date($date)
{
    if (app()->getLocale() == 'fa') {
        return jdate($date);
    }

    return carbon($date);
}

function str_replace_first($from, $to, $content)
{
    $from = '/' . preg_quote($from, '/') . '/';

    return preg_replace($from, $to, $content, 1);
}

function aparat_iframe($string)
{
    $p = '/^(?:https?:\/\/)?(?:www\.)?(?:aparat\.com\/v\/)(\w*)(?:\S+)?$/';
    preg_match($p, $string, $matches);

    if (empty($matches)) {
        return '';
    }

    return '<div class="h_iframe-aparat_embed_frame"><span style="display: block;padding-top: 57%">.</span><iframe data-src="https://www.aparat.com/video/video/embed/videohash/' . $matches[1] . '/vt/frame" allowFullScreen="true" webkitallowfullscreen="true" mozallowfullscreen="true"></iframe></div>';
}

function theme_asset($path)
{
    return asset(config('front.asset_path') . $path);
}

function theme_path($path)
{
    return base_path(config('front.theme_path') . $path);
}
function to_english_numbers(String $string): String {
    $persinaDigits1 = ['۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹'];
    $persinaDigits2 = ['٩', '٨', '٧', '٦', '٥', '٤', '٣', '٢', '١', '٠'];
    $allPersianDigits = array_merge($persinaDigits1, $persinaDigits2);
    $replaces = [...range(0, 9), ...range(0, 9)];

    return str_replace($allPersianDigits, $replaces , $string);
}

 function categoriesBuildTree(array $categories, $parentId = null)
{
    $branch = [];
    foreach ($categories as $category) {
        if ($category['parent_id'] == $parentId) {
            $children = categoriesBuildTree($categories, $category['id']);
            if ($children) {
                $category['children'] = $children;
            }
            $branch[] = $category;
        }
    }
    return $branch;
}