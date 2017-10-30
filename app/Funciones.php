<?php
/**
 * Created by PhpStorm.
 * User: Alfredo
 * Date: 06/05/14
 * Time: 05:05 PM
 */

namespace App;

class Funciones {

    public static function monthName($index, $long = true) {
        if ($index <= 0 && $index !== false) return '';
        if ($long) {
            $months = [
                __('global.jan_l'),
                __('global.feb_l'),
                __('global.mar_l'),
                __('global.apr_l'),
                __('global.may_l'),
                __('global.jun_l'),
                __('global.jul_l'),
                __('global.aug_l'),
                __('global.sep_l'),
                __('global.oct_l'),
                __('global.nov_l'),
                __('global.dec_l')
            ];
        }
        else {
            $months = [
                __('global.jan_s'),
                __('global.feb_s'),
                __('global.mar_s'),
                __('global.apr_s'),
                __('global.may_s'),
                __('global.jun_s'),
                __('global.jul_s'),
                __('global.aug_s'),
                __('global.sep_s'),
                __('global.oct_s'),
                __('global.nov_s'),
                __('global.dec_s')
            ];
        }
        if ($index === false) return $months;
        return $months[$index - 1];
    }

    public static function weekday($index, $long = true) { //0 = monday ... 6 = sunday
        if ($index !== false && ($index < 0 || $index > 6)) return '';
        if ($long) {
            $days = [
                __('global.mon_l'),
                __('global.tue_l'),
                __('global.wed_l'),
                __('global.thu_l'),
                __('global.fri_l'),
                __('global.sat_l'),
                __('global.sun_l')
            ];
        }
        else {
            $days = [
                __('global.mon_s'),
                __('global.tue_s'),
                __('global.wed_s'),
                __('global.thu_s'),
                __('global.fri_s'),
                __('global.sat_s'),
                __('global.sun_s')
            ];
        }
        if ($index === false) return $days;
        return $days[$index];
    }

    public static function longDateFormat($date, $show_time=false, $convert_to_time=true) {
        if ($convert_to_time) {
          $date = strtotime($date);
        }
        if ($date === false) return "";
        $week = [
            __('global.sun_l'),
            __('global.mon_l'),
            __('global.tue_l'),
            __('global.wed_l'),
            __('global.thu_l'),
            __('global.fri_l'),
            __('global.sat_l')
        ];
        
        return __('global.long_date', array(
            'semana' => $week[date('w', $date)],
            'dia' => date('d', $date),
            'mes' => self::monthName(date('n', $date)),
            'ano' => date('Y', $date)
        )) . ($show_time ? (', ' . date(' h:i a', $date)) : '');
    }

    public static function shortDateFormat($date, $show_week=false, $show_time=false, $convert_to_time=true) {
        if ($convert_to_time) {
            $date = strtotime($date);
        }
        if ($date === false) return "";
        $week = [
            __('global.sun_s'),
            __('global.mon_s'),
            __('global.tue_s'),
            __('global.wed_s'),
            __('global.thu_s'),
            __('global.fri_s'),
            __('global.sat_s')
        ];
        
        return __($show_week ? 'global.short_date_week' : 'global.short_date', array(
            'semana' => $week[date('w', $date)],
            'dia' => date('d', $date),
            'mes' => self::monthName(date('n', $date), false),
            'ano' => date('Y', $date)
        )) . ($show_time ? (',' . date(' h:i a', $date)) : '');
    }

    public static function justTime($time, $ampm = true, $convert_to_time = true, $minimum = false) {
        $time = date($ampm ? 'h:i A' : 'H:i', $convert_to_time ? strtotime($time) : $time);
        if ($minimum) {
            $time = str_replace(' PM', 'p', str_replace(' AM', 'a', str_replace(':00', '', $time)));
            if (substr($time, 0, 1) == '0') {
                $time = substr($time, 1);
            }
        }
        return $time;
    }

    public static function ampmto24($time) {
        if (empty($time)) return null;
        $time = explode(' ', $time);
        if (count($time) == 2) {
            $ampm = strtoupper($time[1]);
            $time = explode(':', $time[0], 3);
            if (count($time) > 1) {
                if ($time[0] == 12 && $ampm == 'AM') {
                    $time[0] = 0;
                } else {
                    $time[0] = (int)$time[0] + (($ampm == 'PM' && $time[0] != 12) ? 12 : 0);
                }
                return ($time[0] < 10 ? '0' : '') . $time[0] . ':' . $time[1];
            }
        }
        return '';
    }

    public static function explodeDateTime($datetime, $ignore_time = false) {
        $ret = array();
        //fecha
        $date = explode('-', $datetime, 3);
        $date = array_map('intval', $date);
        $ret['year'] = $date[0];
        $ret['month'] = $date[1];
        $ret['day'] = $date[2];

        //hora
        if (!$ignore_time) {
            $start = explode(':', self::justTime($datetime, false, 3));
            if (count($start) >= 2) {
                $start = array_map('intval', $start);
                $ret['hour'] = $start[0];
                $ret['minutes'] = $start[1];
            }
        }

        return $ret;
    }

    public static function minToHours($min) {
        $hours = 0;
        if ($min > 59) {
            $hours = intval($min / 60);
            $min -= $hours * 60;
        }
        return ($hours ? (self::singlePlural(__('global.hour'), __('global.hours'), $hours, true) . ($min ? ' ' : '')) : '') .
                 ($min ?  self::singlePlural(__('global.minute'), __('global.minutes'), $min, true) : '');
    }

    public static function addMinutes($start, $minutes, $return_format = 'Y-m-d H:i:s') {
        if (strlen(preg_replace('/[0-9]/', '', $start)) > 0) {
            $start = strtotime($start);
        }
        $time = strtotime('+' . $minutes . ' minutes', $start);
        if ($return_format !== false) {
            return date($return_format, $time);
        }
        return $time;
    }

    /**
     * Checks if a time (time2) is between the interval specified from another time (time1)
     * @param $time1
     * @param $time2
     * @param int $interval
     * @return bool
     */
    public static function compareHoursInInverval($time1, $time2, $interval = 30) {
        //if ($time1 < $time2) return false;
        $h1 = (int)date('G', $time1); //G = 0..23 (no leading zero as opposed to H)
        $h2 = (int)date('G', $time2);
        $m1 = (int)date('i', $time1);
        $m2 = (int)date('i', $time2);
        /*if (($m1 < $m2 && $h1 <= $h2) || ($m1 = $m2 && $h1 < $h2)) {
            return false;
        }*/
        if ($h1 == $h2) { //same hour
            if ($m1 == $m2) return true; //same minutes
            $diff = abs($m2 - $m1); // ex:  8:00 -- 8:29 --> diff = 29 (ok)  |  8:00 -- 8:30 --> diff = 30 (bad)
            if ($diff < $interval) return true;
        }
        return false;
    }


    public static function ageFromDate($date) {
      $date = new DateTime($date);
      $now = new DateTime();
      $interval = $now->diff($date);
      return $interval->y;
    }

    public static function inactiveIf($content, $inactive) {
      return ($inactive ? '<span class="text-muted" style="text-decoration:line-through">' : '') . $content . ($inactive ? '</span>' : '');
    }

    public static function wrapWithSpanIf($to_be_wrapped, $wrap, $class = '', $find_str = '', $find_wrap_open = '<b><i>', $find_wrap_close = '</i></b>') {
        $to_be_wrapped = self::wrapSubstringIn($find_str, $to_be_wrapped, $find_wrap_open, $find_wrap_close);
        if ($wrap) {
            if ($class != "") $class = ' class="' . $class . '"';
            return '<span' . $class . '>' . $to_be_wrapped . '</span>';
        }
        else return $to_be_wrapped;
    }

    public static function wrapSubstringIn($substring, $in, $wrap_start = '<b><i>', $wrap_end = '</i></b>') {
        if (strlen($substring)) {
            $pos = stripos($in, $substring);
            if ($pos !== false) {
                $in = substr_replace($in, $wrap_end, $pos + strlen($substring), 0);
                $in = substr_replace($in, $wrap_start, $pos, 0);
            }
        }
        return $in;
    }

    /**
     * Replaces new line for a html br tag. PHP's function only adds a br but doesn't remove the new line character
     * @param $str
     * @param string $nl_tag
     * @return string
     */
    public static function nl2br($str, $nl_tag = '<br />') {
      return str_replace(array("\r\n", "\r", "\n", "\n\r"), $nl_tag, $str);
    }

    /**
     * Removes any character that is not a letter, number or any of these: @ . _ -
     * @param $str
     * @return mixed
     */
    public static function noWeirdChars($str) {
        return preg_replace('/[^ \w@._\-áéíóúÁÉÍÓÚ]+/', '', $str);
    }

    /**
     * simple method to encrypt or decrypt a plain text string
     * initialization vector(IV) has to be the same when encrypting and decrypting
     * PHP 5.4.9
     *
     * this is a beginners template for simple encryption decryption
     * before using this in production environments, please read about encryption
     *
     * @param string $action: can be 'encrypt' or 'decrypt'
     * @param string $string: string to encrypt or decrypt
     *
     * @return string
     */
    public static function encrypt_decrypt($action, $string) {
        $output = false;

        $encrypt_method = "AES-256-CBC";
        $secret_key = '4#7$./jk3@fdk-fd4ñ0?maf&lfrd';
        $secret_iv = 'U1kUEYSRsbXYAidzIBAy';

        // hash
        $key = hash('sha256', $secret_key);

        // iv - encrypt method AES-256-CBC expects 16 bytes - else you will get a warning
        $iv = substr(hash('sha256', $secret_iv), 0, 16);

        if( $action == 'encrypt' ) {
            $output = openssl_encrypt($string, $encrypt_method, $key, 0, $iv);
            $output = base64_encode($output);
        }
        else if( $action == 'decrypt' ){
            $output = openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0, $iv);
        }

        return $output;
    }

    /**
     * Capitalizes the first letter of every word except the word 'de' if cap_de is false
     * @param $val
     * @param $cap_de
     * @return string
     */
    public static function capitalize($val, $cap_de = true) {
        /*$val = str_replace(' De ',' de ',ucwords(strtolower( $val )));*/
        $val = ucwords(mb_strtolower( $val, 'UTF-8' ));
        if (!$cap_de) {
            $val = str_replace(' De ', ' de ', $val);
            if (substr($val,0,3) == 'De ') $val = preg_replace('/De /','de ',$val,1);
        }
        return trim( $val );
    }

    public static function singlePlural($single, $plural, $quantity, $append_quantity = false) {
        return ($append_quantity ? ($quantity . ' ') : '') . ($quantity == 1 ? $single : $plural);
    }

    /**
     * Removes all the html tags (to prevent scripts and odd behavior)
     * @param $str
     * @return string
     */
    public static function noTags($str) {
        return trim( preg_replace('/<(.*?)>/', '', $str) );
    }

    /**
     * Breaks the number and separates it with parenthesis and dots. Ex: //04249440972 --> (0424) 944.09.72
     * @param $str
     * @return string
     */
    public static function formatPhone($str) {
        $str = preg_replace("/[^0-9]/", "", $str);
        $len = strlen($str);
        if ($len == 11) {
            return '(' . substr($str, 0, 4) . ') ' . substr($str, 4, 3) . '.' . substr($str, 7, 2) . '.' . substr($str, 9);
        }
        return $str;
    }

    /**
     * Adds the 'at' symbol before the string if not present
     * @param $str
     * @return string
     */
    public static function formatSocial($str) {
        $str = str_replace(' ', '', $str);
        if (strlen($str) == 0) return '';
        if (substr($str, 0, 1) != '@') {
          $str = '@' . $str;
        }
        return strtolower($str);
    }

    /**
     * Removes all but the allowed phone characters.
     * @param $str
     * @return mixed
     */
    public static function onlyPhoneChars($str) {
        return preg_replace('/[^0-9()+-\.\/]/', '', $str);
    }

    /**
     * Removes all but the allowed email characters.
     * @param $str
     * @return mixed
     */
    public static function onlyEmailChars($str) {
        return strtolower( preg_replace('/[^a-zA-Z0-9_\-\.@]/', '', $str) );
    }

    /**
     * Removes all but letters.
     * @param $str
     * @return mixed
     */
    public static function onlyLetters($str) {
        $str = preg_replace('/[^\pL\s]/', '', $str);
        return trim( preg_replace('!\s+!', ' ', $str) );
    }

    /**
     * Removes all but digits.
     * @param $str
     * @return mixed
     */
    public static function onlyNumbers($str) {
        $str = preg_replace('/[^0-9]/', '', $str);
        return trim( preg_replace('!\s+!', ' ', $str) );
    }


    public static function decimalsForSystem($value) {
        if (strpos($value, ',') !== false) {
            $value = str_replace('.', '', $value);
            $int_dec = explode(',', $value, 2);
        }
        else {
            $int_dec = explode('.', $value, 2);
        }
        return intval(substr($int_dec[0], 0, 8)) . '.' . (isset($int_dec[1]) ? self::onlyNumbers(substr($int_dec[1], 0, 2)) : '00');
    }


    public static function decimalsForUser($value, $sep_thousands = false) {
        //$value = preg_replace('/[^0-9\.,%]/', '', $value);
        //return str_replace('.', ',', $value);
        if (strpos($value, ',') !== false) {
            $value = str_replace('.', '', $value);
            $value = str_replace(',', '.', $value);
        }
        return number_format($value, 2, ',', $sep_thousands ? '.' : '');
    }

    /**
     * Returns an array with the translated values of the passed array
     * @param $lang_file
     * @param $array
     * @param null $field_name
     * @param null $field_id
     * @return array
     */
    public static function langArray($lang_file, $array, $field_name = null, $field_id = null) {
        $return_array = array();
        if (is_array($array)) {
            foreach ($array as $key => $a) {
                if ($field_name == null) {
                    if ($field_id == null) {
                        $return_array[$key] = __($lang_file . '.' . $a);
                    }
                    else {
                        $return_array[$a[$field_id]] = __($lang_file . '.' . $a);
                    }
                }
                else {
                    if ($field_id == null) {
                        $return_array[$key] = __($lang_file . '.' . $a[$field_name]);
                    }
                    else {
                        $return_array[$a[$field_id]] = __($lang_file . '.' . $a[$field_name]);
                    }
                }
            }
        }
        return $return_array;
    }

    public static function arrayIt($objects, $key, $value, $rel = null) {
        $arr = array();
        $has_rel = is_array($rel) && count($rel) > 1;
        foreach($objects as $item) {
            if ($has_rel) {
              $rel_model = $rel[0];
              $rel_field = $rel[1];
              $rel_value = $item->$rel_model->$rel_field;
              //$arr[$item->$key] = $item->$value . ' &nbsp; <span class="text-muted">' . $rel_value . '</span>';
              $arr[$item->$key] = $item->$value . (!empty($rel_value) ? (' - ' . $rel_value) : '');
            }
            elseif ($rel !== null) {
              $arr[$item->$key] = $item->$value . (!empty($item->$rel) ? (' - ' . $item->$rel) : '');
            }
            else {
              $arr[$item->$key] = $item->$value;
            }
        }
        return $arr;
    }

    public static function firstNameLastName($fname, $lname, $initial_lname = false) {
        $fname = explode(' ', $fname);
        $lname = $initial_lname ? substr($lname, 0, 1) : explode(' ', $lname);
        if (!$initial_lname && strtolower($lname[0]) == 'de') {
            return ucfirst(mb_strtolower(reset($fname))) . ' ' . ($initial_lname ? strtoupper($lname) : ('de ' . ucfirst(mb_strtolower(next($lname)))));
        }
        return ucfirst(mb_strtolower(reset($fname))) . ' ' . ($initial_lname ? strtoupper($lname) : ucfirst(mb_strtolower(reset($lname))));
    }

    public static function remainingTime($date_str, $type = null) {
        //date_default_timezone_set('UTC');
        //date_default_timezone_set('America/Caracas');
        $now = new DateTime('now', new DateTimeZone( Config::get('app.timezone') ));
        $future_date = new DateTime($date_str, new DateTimeZone( Config::get('app.timezone') ));

        $interval = $future_date->diff($now, true);

        switch ($type) {
            case 'days':
                return $interval->d;
                break;

            case 'hours':
                return $interval->h;
                break;

            case 'minutes':
                return $interval->i;
                break;

            case 'seconds':
                return $interval->s;
                break;

            case 'all':
                if ($now > $future_date) return '';
                if ($interval->d > 6) {
                    $week = intval($interval->d / 7);
                    $interval->d -= $week * 7;
                }
                else $week = false;
                return 
                    ($interval->y ? (self::singlePlural(__('global.year'), __('global.years'), $interval->y, true) . ' ') : '') .
                    ($interval->m ? (self::singlePlural(__('global.month'), __('global.months'), $interval->m, true) . ' ') : '') .
                    ($week ? (self::singlePlural(__('global.week'), __('global.weeks'), $week, true) . ' ') : '') .
                    ($interval->d ? (self::singlePlural(__('global.day'), __('global.days'), $interval->d, true) . ' ') : '') .
                    ($interval->h ? (self::singlePlural(__('global.hour'), __('global.hours'), $interval->h, true) . ' ') : '') .
                    self::singlePlural(__('global.minute'), __('global.minutes'), $interval->i, true); //. " " .
                    //self::singlePlural(__('global.second'), __('global.seconds'), $interval->s, true);
                break;

            default:
                return $interval;
        }
    }

    public static function timeDiff($date_start, $date_end, $type = null, &$inverted = null) {
        $past_date = new DateTime($date_end, new DateTimeZone( Config::get('app.timezone') ));
        $future_date = new DateTime($date_start, new DateTimeZone( Config::get('app.timezone') ));

        if ($inverted !== null) {
            $inverted = (strtotime($date_start) > strtotime($date_end));
        }

        $interval = $future_date->diff($past_date, true);

        switch ($type) {
            case 'days':
                return $interval->d;
                break;

            case 'hours':
                return $interval->h;
                break;

            case 'minutes':
                return $interval->i;
                break;

            case 'seconds':
                return $interval->s;
                break;

            case 'all-date':
                if ($past_date > $future_date) return '';
                if ($interval->d > 6) {
                    $week = intval($interval->d / 7);
                    $interval->d -= $week * 7;
                }
                else $week = false;
                return
                    ($interval->y ? (self::singlePlural(__('global.year'), __('global.years'), $interval->y, true) . ' ') : '') .
                    ($interval->m ? (self::singlePlural(__('global.month'), __('global.months'), $interval->m, true) . ' ') : '') .
                    ($week ? (self::singlePlural(__('global.week'), __('global.weeks'), $week, true) . ' ') : '') .
                    ($interval->d ? (self::singlePlural(__('global.day'), __('global.days'), $interval->d, true)) : '');
                break;

            case 'all':
                if ($past_date > $future_date) return '';
                if ($interval->d > 6) {
                    $week = intval($interval->d / 7);
                    $interval->d -= $week * 7;
                }
                else $week = false;
                return
                    ($interval->y ? (self::singlePlural(__('global.year'), __('global.years'), $interval->y, true) . ' ') : '') .
                    ($interval->m ? (self::singlePlural(__('global.month'), __('global.months'), $interval->m, true) . ' ') : '') .
                    ($week ? (self::singlePlural(__('global.week'), __('global.weeks'), $week, true) . ' ') : '') .
                    ($interval->d ? (self::singlePlural(__('global.day'), __('global.days'), $interval->d, true) . ' ') : '') .
                    ($interval->h ? (self::singlePlural(__('global.hour'), __('global.hours'), $interval->h, true) . ' ') : '') .
                    self::singlePlural(__('global.minute'), __('global.minutes'), $interval->i, true); //. " " .
                //self::singlePlural(__('global.second'), __('global.seconds'), $interval->s, true);
                break;

            default:
                return $interval;
        }
    }

    public static function timeSince($date_str, $type = null) {
        $now = new DateTime('now', new DateTimeZone( Config::get('app.timezone') ));
        $given_date = new DateTime($date_str, new DateTimeZone( Config::get('app.timezone') ));

        $interval = $now->diff($given_date, true);

        switch ($type) {
            case 'days':
                return $interval->d;
                break;

            case 'hours':
                return $interval->h;
                break;

            case 'minutes':
                return $interval->i;
                break;

            case 'seconds':
                return $interval->s;
                break;

            case 'all':
                if ($now > $given_date) return '';
                if ($interval->d > 6) {
                    $week = intval($interval->d / 7);
                    $interval->d -= $week * 7;
                }
                else $week = false;
                return
                    ($interval->y ? (self::singlePlural(__('global.year'), __('global.years'), $interval->y, true) . ' ') : '') .
                    ($interval->m ? (self::singlePlural(__('global.month'), __('global.months'), $interval->m, true) . ' ') : '') .
                    ($week ? (self::singlePlural(__('global.week'), __('global.weeks'), $week, true) . ' ') : '') .
                    ($interval->d ? (self::singlePlural(__('global.day'), __('global.days'), $interval->d, true) . ' ') : '') .
                    ($interval->h ? (self::singlePlural(__('global.hour'), __('global.hours'), $interval->h, true) . ' ') : '') .
                    self::singlePlural(__('global.minute'), __('global.minutes'), $interval->i, true); //. " " .
                //self::singlePlural(__('global.second'), __('global.seconds'), $interval->s, true);
                break;

            default:
                return $interval;
        }
    }

    /**
     * Returns a the passed string enclosed in two strings
     * @param $str
     * @param string $before
     * @param string $after
     * @return string
     */
    public static function encloseStr($str, $before = ' (', $after = ')') {
        if (!empty($str)) {
            return $before . $str . $after;
        }
        return '';
    }

    /**
     * easy image resize function
     * @param  $file - file name to resize
     * @param  $string - The image data, as a string
     * @param  $width - new image width
     * @param  $height - new image height
     * @param  $proportional - keep image proportional, default is no
     * @param  $output - name of the new file (include path if needed)
     * @param  $delete_original - if true the original image will be deleted
     * @param  $use_linux_commands - if set to true will use "rm" to delete the image, if false will use PHP unlink
     * @param  $quality - enter 1-100 (100 is best quality) default is 100
     * @return boolean|resource
     */
    public static function redimencionarImagen($file, $string = null, $width = 0, $height = 0, $proportional = false, $output = 'file', $delete_original = true, $use_linux_commands = false, $quality = 100) {
        if ( $height <= 0 && $width <= 0 ) return false;
        if ( $file === null && $string === null ) return false;

        # Setting defaults and meta
        $info                         = $file !== null ? getimagesize($file) : getimagesizefromstring($string);
        $image                        = '';
        $final_width                  = 0;
        $final_height                 = 0;
        list($width_old, $height_old) = $info;
        $cropHeight = $cropWidth = 0;

        # Calculating proportionality
        if ($proportional) {
          if      ($width  == 0)  $factor = $height/$height_old;
          elseif  ($height == 0)  $factor = $width/$width_old;
          else                    $factor = min( $width / $width_old, $height / $height_old );

          $final_width  = round( $width_old * $factor );
          $final_height = round( $height_old * $factor );
        }
        else {
          $final_width = ( $width <= 0 ) ? $width_old : $width;
          $final_height = ( $height <= 0 ) ? $height_old : $height;
          $widthX = $width_old / $width;
          $heightX = $height_old / $height;
          
          $x = min($widthX, $heightX);
          $cropWidth = ($width_old - $width * $x) / 2;
          $cropHeight = ($height_old - $height * $x) / 2;
        }

        # Loading image to memory according to type
        switch ( $info[2] ) {
          case IMAGETYPE_JPEG:  $file !== null ? $image = imagecreatefromjpeg($file) : $image = imagecreatefromstring($string);  break;
          case IMAGETYPE_GIF:   $file !== null ? $image = imagecreatefromgif($file)  : $image = imagecreatefromstring($string);  break;
          case IMAGETYPE_PNG:   $file !== null ? $image = imagecreatefrompng($file)  : $image = imagecreatefromstring($string);  break;
          default: return false;
        }
        
        
        # This is the resizing/resampling/transparency-preserving magic
        $image_resized = imagecreatetruecolor( $final_width, $final_height );
        if ( ($info[2] == IMAGETYPE_GIF) || ($info[2] == IMAGETYPE_PNG) ) {
          $transparency = imagecolortransparent($image);
          $palletsize = imagecolorstotal($image);

          if ($transparency >= 0 && $transparency < $palletsize) {
            $transparent_color  = imagecolorsforindex($image, $transparency);
            $transparency       = imagecolorallocate($image_resized, $transparent_color['red'], $transparent_color['green'], $transparent_color['blue']);
            imagefill($image_resized, 0, 0, $transparency);
            imagecolortransparent($image_resized, $transparency);
          }
          elseif ($info[2] == IMAGETYPE_PNG) {
            imagealphablending($image_resized, false);
            $color = imagecolorallocatealpha($image_resized, 0, 0, 0, 127);
            imagefill($image_resized, 0, 0, $color);
            imagesavealpha($image_resized, true);
          }
        }
        imagecopyresampled($image_resized, $image, 0, 0, $cropWidth, $cropHeight, $final_width, $final_height, $width_old - 2 * $cropWidth, $height_old - 2 * $cropHeight);
        
        # Taking care of original, if needed
        if ( $delete_original ) {
          if ( $use_linux_commands ) exec('rm '.$file);
          else @unlink($file);
        }

        # Preparing a method of providing result
        switch ( strtolower($output) ) {
          case 'browser':
            $mime = image_type_to_mime_type($info[2]);
            header("Content-type: $mime");
            $output = NULL;
          break;
          case 'file':
            $output = $file;
          break;
          case 'return':
            return $image_resized;
          break;
          default:
          break;
        }
        
        # Writing image according to type to the output destination and image quality
        switch ( $info[2] ) {
          case IMAGETYPE_GIF:   imagegif($image_resized, $output);    break;
          case IMAGETYPE_JPEG:  imagejpeg($image_resized, $output, $quality);   break;
          case IMAGETYPE_PNG:
            $quality = 9 - (int)((0.9*$quality)/10.0);
            imagepng($image_resized, $output, $quality);
            break;
          default: return false;
        }

        return true;
    }


    public static function randomColor() {
        return '#' . str_pad(dechex(mt_rand(0, 0xFFFFFF)), 6, '0', STR_PAD_LEFT);
    }


    public static function removeAccents($string) {
        if (!preg_match('/[\x80-\xff]/', $string)) return $string;

        $chars = array(
            // Decompositions for Latin-1 Supplement
            chr(195).chr(128) => 'A', chr(195).chr(129) => 'A',
            chr(195).chr(130) => 'A', chr(195).chr(131) => 'A',
            chr(195).chr(132) => 'A', chr(195).chr(133) => 'A',
            chr(195).chr(135) => 'C', chr(195).chr(136) => 'E',
            chr(195).chr(137) => 'E', chr(195).chr(138) => 'E',
            chr(195).chr(139) => 'E', chr(195).chr(140) => 'I',
            chr(195).chr(141) => 'I', chr(195).chr(142) => 'I',
            chr(195).chr(143) => 'I', chr(195).chr(145) => 'N',
            chr(195).chr(146) => 'O', chr(195).chr(147) => 'O',
            chr(195).chr(148) => 'O', chr(195).chr(149) => 'O',
            chr(195).chr(150) => 'O', chr(195).chr(153) => 'U',
            chr(195).chr(154) => 'U', chr(195).chr(155) => 'U',
            chr(195).chr(156) => 'U', chr(195).chr(157) => 'Y',
            chr(195).chr(159) => 's', chr(195).chr(160) => 'a',
            chr(195).chr(161) => 'a', chr(195).chr(162) => 'a',
            chr(195).chr(163) => 'a', chr(195).chr(164) => 'a',
            chr(195).chr(165) => 'a', chr(195).chr(167) => 'c',
            chr(195).chr(168) => 'e', chr(195).chr(169) => 'e',
            chr(195).chr(170) => 'e', chr(195).chr(171) => 'e',
            chr(195).chr(172) => 'i', chr(195).chr(173) => 'i',
            chr(195).chr(174) => 'i', chr(195).chr(175) => 'i',
            chr(195).chr(177) => 'n', chr(195).chr(178) => 'o',
            chr(195).chr(179) => 'o', chr(195).chr(180) => 'o',
            chr(195).chr(181) => 'o', chr(195).chr(182) => 'o',
            chr(195).chr(182) => 'o', chr(195).chr(185) => 'u',
            chr(195).chr(186) => 'u', chr(195).chr(187) => 'u',
            chr(195).chr(188) => 'u', chr(195).chr(189) => 'y',
            chr(195).chr(191) => 'y',
            // Decompositions for Latin Extended-A
            chr(196).chr(128) => 'A', chr(196).chr(129) => 'a',
            chr(196).chr(130) => 'A', chr(196).chr(131) => 'a',
            chr(196).chr(132) => 'A', chr(196).chr(133) => 'a',
            chr(196).chr(134) => 'C', chr(196).chr(135) => 'c',
            chr(196).chr(136) => 'C', chr(196).chr(137) => 'c',
            chr(196).chr(138) => 'C', chr(196).chr(139) => 'c',
            chr(196).chr(140) => 'C', chr(196).chr(141) => 'c',
            chr(196).chr(142) => 'D', chr(196).chr(143) => 'd',
            chr(196).chr(144) => 'D', chr(196).chr(145) => 'd',
            chr(196).chr(146) => 'E', chr(196).chr(147) => 'e',
            chr(196).chr(148) => 'E', chr(196).chr(149) => 'e',
            chr(196).chr(150) => 'E', chr(196).chr(151) => 'e',
            chr(196).chr(152) => 'E', chr(196).chr(153) => 'e',
            chr(196).chr(154) => 'E', chr(196).chr(155) => 'e',
            chr(196).chr(156) => 'G', chr(196).chr(157) => 'g',
            chr(196).chr(158) => 'G', chr(196).chr(159) => 'g',
            chr(196).chr(160) => 'G', chr(196).chr(161) => 'g',
            chr(196).chr(162) => 'G', chr(196).chr(163) => 'g',
            chr(196).chr(164) => 'H', chr(196).chr(165) => 'h',
            chr(196).chr(166) => 'H', chr(196).chr(167) => 'h',
            chr(196).chr(168) => 'I', chr(196).chr(169) => 'i',
            chr(196).chr(170) => 'I', chr(196).chr(171) => 'i',
            chr(196).chr(172) => 'I', chr(196).chr(173) => 'i',
            chr(196).chr(174) => 'I', chr(196).chr(175) => 'i',
            chr(196).chr(176) => 'I', chr(196).chr(177) => 'i',
            chr(196).chr(178) => 'IJ',chr(196).chr(179) => 'ij',
            chr(196).chr(180) => 'J', chr(196).chr(181) => 'j',
            chr(196).chr(182) => 'K', chr(196).chr(183) => 'k',
            chr(196).chr(184) => 'k', chr(196).chr(185) => 'L',
            chr(196).chr(186) => 'l', chr(196).chr(187) => 'L',
            chr(196).chr(188) => 'l', chr(196).chr(189) => 'L',
            chr(196).chr(190) => 'l', chr(196).chr(191) => 'L',
            chr(197).chr(128) => 'l', chr(197).chr(129) => 'L',
            chr(197).chr(130) => 'l', chr(197).chr(131) => 'N',
            chr(197).chr(132) => 'n', chr(197).chr(133) => 'N',
            chr(197).chr(134) => 'n', chr(197).chr(135) => 'N',
            chr(197).chr(136) => 'n', chr(197).chr(137) => 'N',
            chr(197).chr(138) => 'n', chr(197).chr(139) => 'N',
            chr(197).chr(140) => 'O', chr(197).chr(141) => 'o',
            chr(197).chr(142) => 'O', chr(197).chr(143) => 'o',
            chr(197).chr(144) => 'O', chr(197).chr(145) => 'o',
            chr(197).chr(146) => 'OE',chr(197).chr(147) => 'oe',
            chr(197).chr(148) => 'R',chr(197).chr(149) => 'r',
            chr(197).chr(150) => 'R',chr(197).chr(151) => 'r',
            chr(197).chr(152) => 'R',chr(197).chr(153) => 'r',
            chr(197).chr(154) => 'S',chr(197).chr(155) => 's',
            chr(197).chr(156) => 'S',chr(197).chr(157) => 's',
            chr(197).chr(158) => 'S',chr(197).chr(159) => 's',
            chr(197).chr(160) => 'S', chr(197).chr(161) => 's',
            chr(197).chr(162) => 'T', chr(197).chr(163) => 't',
            chr(197).chr(164) => 'T', chr(197).chr(165) => 't',
            chr(197).chr(166) => 'T', chr(197).chr(167) => 't',
            chr(197).chr(168) => 'U', chr(197).chr(169) => 'u',
            chr(197).chr(170) => 'U', chr(197).chr(171) => 'u',
            chr(197).chr(172) => 'U', chr(197).chr(173) => 'u',
            chr(197).chr(174) => 'U', chr(197).chr(175) => 'u',
            chr(197).chr(176) => 'U', chr(197).chr(177) => 'u',
            chr(197).chr(178) => 'U', chr(197).chr(179) => 'u',
            chr(197).chr(180) => 'W', chr(197).chr(181) => 'w',
            chr(197).chr(182) => 'Y', chr(197).chr(183) => 'y',
            chr(197).chr(184) => 'Y', chr(197).chr(185) => 'Z',
            chr(197).chr(186) => 'z', chr(197).chr(187) => 'Z',
            chr(197).chr(188) => 'z', chr(197).chr(189) => 'Z',
            chr(197).chr(190) => 'z', chr(197).chr(191) => 's'
        );

        $string = strtr($string, $chars);

        return $string;
    }


    public static function mb_ucwords($str, $encoding = 'UTF-8') {
        $partes = explode(' ', $str);
        $uc_partes = [];
        foreach ($partes as $parte) {
            $uc_partes[] = mb_strtoupper(substr($parte, 0, 1), $encoding) . substr($parte, 1);
        }
        return implode(' ', $uc_partes);
    }


    public static function strEncode($str) {
        return base64_encode($str);
    }


    public static function strDecode($str) {
        return base64_decode($str);
    }


    public static function trimDecimals($val, $as_float = true) {
        $dp = strpos($val, '.');
        if ($dp !== false) {
            $wd = explode('.', $val);
            if ($as_float) {
                return floatval($wd[0] . '.' . substr($wd[1], 0, 2));
            }
            return $wd[0] . '.' . str_pad(substr($wd[1], 0, 2), 2, '0', STR_PAD_RIGHT);
        }
        if ($as_float) {
            return floatval($val);
        }
        return $val . '.00';
    }


    public static function discount($val, $percent) {
        $percent = floatval($percent);
        if ($percent > 0) {
            if ($percent >= 100) return 0;
            $val = floatval($val);
            return self::trimDecimals($val - ($val * ($percent / 100)));
        }
        return $val;
    }


    public static function getExcelColumnNameFromNumber($num) {
        $numeric = ($num - 1) % 26;
        $letter = chr(65 + $numeric);
        $num2 = intval(($num - 1) / 26);
        if ($num2 > 0) {
            return self::getExcelColumnNameFromNumber($num2) . $letter;
        } else {
            return $letter;
        }
    }


    /**
     * Utilidad para inspeccionar SQLs
     *
     * @param $q
     */
    public static function qdd($q) {
        $bindings = $q->getBindings();
        $var = $q->toSql();
        $parts = explode('?', $var);
        $whole = '';
        $i = 0;
        foreach ($parts as $part) {
            if (isset($bindings[$i])) {
                if (is_int($bindings[$i])) {
                    $whole .= $part . $bindings[$i];
                }
                else {
                    $whole .= $part . '\'' . $bindings[$i] . '\'';
                }
            }
            else {
                $whole .= $part;
            }
            $i++;
        }
        var_dump($whole);
        die();
    }

}