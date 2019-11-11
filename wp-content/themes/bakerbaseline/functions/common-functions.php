<?php
/**
 * Common PHP/Wordpress Methods & Functions
 */

if (!function_exists('get_query_var')) {
    function get_query_var($query_var, $defaul_val) {
        $val = get_qv($query_var, $default_val);
        return $val;
    }
}

if (!function_exists('set_query_var')) {
    function set_query_var($query_var, $defaul_val) {
        $val = get_qv($query_var, $default_val);
        $GLOBALS[$query_var] = $val;
    }
}

/**
 * Determine wordpress base path when wordpress core is not loaded
 *
 * @return string
 */
function my_get_wordpress_base_path() {
    $dir = dirname(__FILE__);
    do {
        /* Check for wp-config.php (it is possible to check for other files here) */
        if (file_exists($dir . '/wp-config.php')) {
            return $dir;
        }
    } while ($dir = realpath("$dir/.."));
    return null;
}

/**
 * Determine wordpress theme path when core is not loaded
 *
 * @return string
 */
function my_get_wordpress_theme_path() {
    $theme_path = my_get_wordpress_base_path() . '/wp-content/themes';
    /** Loop through/register all ACF field groups in specified directory */
    if(file_exists($theme_path)) {
        $dir = new DirectoryIterator($theme_path);
        foreach ($dir as $fileinfo) {
            if (!$fileinfo->isDot()) {
                $filename = $fileinfo->getFilename();
                if (strpos($filename, '.') !== 0 && is_dir($fileinfo->getPathname())) {
                    return $fileinfo->getPathname();
                }
            }
        }
    }
}

/**
 * Generate Font Awesome Icon
 *
 * @param string $class fontawesome icon class string (e.g. 'fa-check')
 * @return void
 */
function fa_icon($class) {
    $icon = '<i class="icon fa ' . $class . '"></i>';
    echo $icon;
}

/**
 * Clean a string, Remove spaces and special characters (replace with '-')
 *
 * @return string
 */
function clean_slug($string) {
    $string = strtolower(str_replace(' ', '-', $string)); // Replaces all spaces with hyphens.
    return preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.
}

/**
 * Try to turn URL-friendly string into page title-friendly string (e.g. 'this-page' => 'This Page')
 *
 * @return string
 */
function unclean_slug($string, $fallback = '') {
    $patterns = array(
        '/_/',
        '/-/',
    );
    $string = preg_replace($patterns, ' ', $string);
    $string = ucwords(strtolower($string));
    $string = str_replace(array('And', 'Or'), array('and', 'or'), $string);
    return $string;
}

/**
 * Log a value in JavaScript console
 *
 * @param $value value to log
 * @param $log_type type of log (e.g. 'alert')
 * @return void
 */
function js_log($value, $log_type = 'console.log') {
    $data = null;
    $jseval = false;
    if (!$value):
        return false;
    endif;
    $isevaled = false;
    $type = ($data || gettype($data)) ? 'Type: ' . gettype($data) : '';
    if ($jseval && (is_array($data) || is_object($data))):
        $data = 'eval(' . preg_replace('#[\s\r\n\t\0\x0B]+#', '', json_encode($data)) . ')';
        $isevaled = true;
    else:
        $data = json_encode($data);
    endif;
    $data = $data ? $data : '';
    $search_array = array("#'#", '#""#', "#''#", "#\n#", "#\r\n#");
    $replace_array = array('"', '', '', '\\n', '\\n');
    $data = preg_replace($search_array, $replace_array, $data);
    $data = ltrim(rtrim($data, '"'), '"');
    $data = $isevaled ? $data : ("'" === $data[0]) ? $data : "'" . $data . "'";
    $wrapping = '';
    $js_string = $wrapping . $log_type . "('" . $value . "');" . $wrapping;
    $js_string = '<script>' . $js_string . '</script>';
    echo $js_string;
}

/**
 * Output a nicer, cleaner var_dump using HTML <pre> tag
 *
 * @param $var Required variable (any type)
 * @return void
 *
 * @uses var_dump()
 */
function var_log($var) {
    echo '<pre>';
    var_dump($var);
    echo '</pre>';
}

/**
 * Get current page path
 *
 * @return string
 */
function get_current_page_path() {
    $path = get_array_item($_SERVER, 'REQUEST_URI');
    $path = str_replace_custom('?', '', str_replace_custom(get_array_item($_SERVER, 'QUERY_STRING'), '', $path));
    return $path;
}
/**
 * Get last item of current page path
 *  - Example Usage:
 *     get_current_page_path_last('http://domain.com/first/child/'); // <= returns '/child/'
 *
 * @return string
 */
function get_current_page_path_last() {
    $path = get_current_page_path();
    $path = str_replace_custom('?', '', str_replace_custom(get_array_item($_SERVER, 'QUERY_STRING'), '', $path));
    $split_str = explode('/', $path);
    $split_str = array_reverse(array_filter($split_str));
    if (isset($split_str[0])) {
        return $split_str[0];
    }
}

/**
 * Get server domain name
 *
 * @return string
 */
function get_server_domain($protocol = false) {
    $domain = (($protocol) ? get_current_document_protocol($_SERVER["PROTOCOL"]) . '://' : '') . trim($_SERVER["SERVER_NAME"]);
    return $domain;
}

/**
 * Get current page protocol
 *
 * @return string
 */
function get_current_document_protocol() {
    return strtolower(substr($_SERVER["SERVER_PROTOCOL"], 0, strpos($_SERVER["SERVER_PROTOCOL"], '/')));
}
/**
 * Get server domain name
 *
 * @return string
 */
function get_page_referrer() {
    if (isset($_SERVER["HTTP_REFERER"])):
        return $_SERVER["HTTP_REFERER"];
    endif;
}

/**
 * Get current page URL
 *
 * @return string
 */
function get_current_page_url() {
    $protocol = strtolower(substr($_SERVER["SERVER_PROTOCOL"], 0, strpos($_SERVER["SERVER_PROTOCOL"], '/'))) . '://';
    return $protocol . trim($_SERVER["SERVER_NAME"]) . trim($_SERVER["REQUEST_URI"]);
}

/**
 * Get array item without breaking if it doesn't exist
 *
 * @return string
 */
function get_array_item($array, $key = 0, $fallback_val = false) {
    if (!is_array($array)) {
        $array = (array) $array;
    }
    if (isset($array[$key])):
        return $array[$key];
    else:
        return $fallback_val;
    endif;
}

/**
 * Output array item value without breaking if it doesn't exist
 *
 * @return void
 */
function array_item($array, $key = 0, $fallback_val = false) {
    echo get_array_item($array, $key, $fallback_val);
}

/**
 * Get first item in array without breaking if it doesn't exist
 *
 * @return string
 */
function get_array_first_item($array) {
    return get_array_item($array, 0);
}

/**
 * Output first item in array without breaking if it doesn't exist
 *
 * @return void
 */
function array_first_item($array) {
    echo get_array_first_item($array);
}

/**
 * Get last item in array without breaking if it doesn't exist
 *
 * @return [value]
 */
function get_array_last_item($array) {
    if (!is_array($array)) {
        $array = (array) $array;
    }
    $length = count($array);
    if (count($length) > 0 && isset($array[$length - 1])):
        return $array[$length - 1];
    else:
        return false;
    endif;
}

/**
 * Get URL query var
 *
 * @param $query_var name of query var to get/check
 * @param $allow_empty allow empty string?
 * @return var
 */
function get_qv($query_var, $default_val = null) {
    global $argv;
    if (isset($argv) && null !== $argv) {
        foreach ($argv as $param => $val) {
            $param = (explode('=', $val));
            if (contains('=', $val) && get_array_item($param, 0) === $query_var) {
                $_query_var_val = get_array_item($param, 1);
            }
        }
    } else {
        if (isset($_GET[$query_var])) {
            $_query_var_val = $_GET[$query_var];
        } elseif (isset($_POST[$query_var])) {
            $_query_var_val = $_POST[$query_var];
        } else {
            $_query_var_val = $default_val;
        }
    }
    if (!isset($_query_var_val)) {
        $_query_var_val = $default_val;
    }
    return $_query_var_val;
}

/**
 * Get URL query var or set to a default value
 *
 * @param $query_var name of query var to get/check
 * @param $default_val the default value to use if query var is not already set
 * @return string
 */
function get_set_query_var($query_var, $default_val = '', $allow_empty = true, $set = true) {
    if (isset($_GET[$query_var]) && '' !== $_GET[$query_var]) {
        $_query_var_val = $_GET[$query_var];
    } elseif (isset($_POST[$query_var]) && '' !== $_POST[$query_var]) {
        $_query_var_val = $_POST[$query_var];
    } else {
        $_query_var_val = $default_val;
    }

    if (!$allow_empty && ('' === $_query_var_val || !isset($_query_var_val) || !$_query_var_val)) {
        $_query_var_val = false;
    }

    if ($set) {
        set_query_var($query_var, $_query_var_val);
    }
    return $_query_var_val;
}

/**
 * Check if query variable is empty
 *
 * @param [string] $var_key
 * @param [boolean] $allow_empty
 * @return [boolean]
 */
function query_var_empty($var_key) {
    $qv = get_set_query_var($var_key, '', true, false);
    $is_empty = ('' === $qv) ? true : false;
    return $is_empty;
}

/**
 * Echo line break(s)
 *
 * @return void
 */
function br($num_times = 1) {
    echo str_repeat('<br/>', $num_times);
}

/**
 * Does opposite of isset
 *
 * @param $var variable to test
 * @return bool
 */
function isntset($var) {
    if (isset($var)) {
        return false;
    } else {
        return false;
    }
}

/**
 * Check if string contains substring
 *
 * @param $substring
 * @param $string
 * @return bool
 */
function contains($substring, $string, $strict = true) {
    if (false === $strict) {
        $pos = strpos(strtolower($string), strtolower($substring));
    } else {
        $pos = strpos($string, $substring);
    }
    if (false === $pos) {
        return false;
    } else {
        return true;
    }
}

/**
 * Check if string contains any substrings passed in as an array
 *
 * @param $substrings [array] An array contain each substring to search for
 * @param $string [string] - the string to be searched
 * @return bool
 * @uses contains()
 */
function contains_any($substrings, $string, $return_string = false) {
    $contains = false;
    if (is_array($substrings)) {
        foreach ($substrings as $s => $substr) {
            if (contains($substr, $string)) {
                if ($return_string) {
                    return $substrings[$s];
                } else {
                    return true;
                }
            }
        }
    } elseif (is_string($substrings)) {
        $contains = contains($substrings, $string);
    }
    return $contains;
}

/**
 * Get most frequent value(s) in array
 *
 * @param $arr
 * @return array
 */
function my_get_most_frequent_array_values($arr) {
    $counted = array_count_values($arr);
    arsort($counted);
    return (key($counted));
}

/**
 * Get formatted date from timestamp
 *
 * @param $timestamp
 * @param $format
 * @return string
 */
function get_date_from_timestamp($timestamp, $format = 'm/d/Y') {
    return date($format, intval($timestamp));
}

/**
 * Split string into two lines as HTML
 *
 * @param $string [string]
 * @param $lines [int]
 * @return string
 */
function str_word_wrap($string, $lines = 2) {
    return nl2br(wordwrap($string, (strlen($string) / $lines) + (ceil($lines / 2) + 2)));
}

/**
 * Split string into two lines as HTML
 *
 * @param $string [string]
 * @param $center [float]
 * @return string
 */
function my_split_str($string, $center = 0.4, $split_str = '<br/>') {
    $length2 = strlen($string) * $center;
    $tmp = explode(' ', $string);
    $index = 0;
    $result = array(0 => '', 1 => '');
    $return_str = '';
    foreach ($tmp as $word) {
        if (!$index && strlen($result[0]) > $length2) {
            $index++;
        }
        $result[$index] .= $word . ' ';
    }
    return implode($split_str, $result);
}

/**
 * Custom str_replace function for limiting number of replacements
 *
 * @param $find [string]
 * @param $replace [string]
 * @param $subject [string]
 * @param $limit [int]
 * @param &$count [int]
 * @return string
 */
function str_replace_custom($find, $replacement, $subject, $limit = 0, &$count = 0) {
    if (0 == $limit) {
        return str_replace($find, $replacement, $subject, $count);
    }
    $ptn = '/' . preg_quote($find, '/') . '/';
    return preg_replace($ptn, $replacement, $subject, $limit, $count);
}

/**
 * Get the file path/dir from which a script/function was initially executed
 *
 * @param bool $include_filename include/exclude filename in the return string
 * @return string
 */
function get_function_origin_path($include_filename = true) {
    $bt = debug_backtrace();
    array_shift($bt);
    if (array_key_exists(0, $bt) && array_key_exists('file', $bt[0])) {
        $file_path = $bt[0]['file'];
        if (false === $include_filename) {
            $file_path = str_replace(basename($file_path), '', $file_path);
        }
    } else {
        $file_path = null;
    }
    return $file_path;
}

/**
 * Loop through a directory for existing PHP files
 *
 * @param [string] folder_name
 * @param [bool] require_here
 * @return void
 */
function require_all_here($folder_name, $require_here = true) {
    $folder_name = get_function_origin_path(false) . $folder_name;
    $all_files = array();
    if ($handle = opendir($folder_name)):
        while (false !== ($file = readdir($handle))):
            $current_file = $folder_name . '/' . $file;
            if (is_file($current_file) && strpos($current_file, '.php') !== false):
                $all_files[] = $current_file;
                if (true === $require_here):
                    require_once $current_file;
                endif;
            endif;
        endwhile;
        closedir($handle);
    endif;
    return $all_files;
}

/**
 * Check if multi-array key exists
 *
 * @param mixed $needle the key you want to check for
 * @param mixed $haystack the array you want to search
 * @return bool
 */
function multi_array_key_exists($needle, $haystack) {
    foreach ($haystack as $key => $value):
        if ($needle == $key) {
            return true;
        }
        if (is_array($value)):
            if (multi_array_key_exists($needle, $value) == true) {
                return true;
            } else {
                continue;
            }
        endif;
    endforeach;
    return false;
}

/**
 * Flatten an array
 *
 * @param [array] $array
 * @param [string/int] $key
 * @return array
 */
function array_flatten($array, $key = 0) {
    $return = array();
    if (is_object($array)) {
        $array = (array) $array;
    }
    foreach ($array as $v => $value) {
        if (isset($value[$key])) {
            $return[] = $value[$key];
        }
    }
    return $return;
}

/**
 * Return a string or array of strings replacing all instances
 * of a substring with provided replacement strings
 *
 * @param [array] $find_array an array of all substrings to find
 * @param [array] $replacements an array of all strings to replace with correlated string in $find_array
 * @param [array/string] $subject
 * @return array/string
 */
function str_replace_all($find_array, $replacements, $subject) {
    foreach ($find_array as $i => $value):
        if (is_array($replacements)):
            $subject = str_replace($find_array[$i], $replacements[$i], $subject);
        else:
            $subject = str_replace($find_array[$i], $replacements, $subject);
        endif;
    endforeach;
    return $subject;
}

/**
 * Return the values in an array as string
 *
 * @param [array] $array
 * @param [string] $separator
 * @param [string/int] $sub_key
 * @return string
 */
function echo_array_values($array, $separator = ' ', $sub_key = null) {
    $return_string = '';
    foreach ($array as $key => $val) {
        if (is_object($val)) {
            $val = object_to_array($val);
        }
        if (null !== $sub_key) {
            $val = get_array_item($val, $sub_key);
        }
        $return_string .= ($val . $separator);
    }
    return trim($return_string);
}

/**
 * Convert a PHP object to an array
 *
 * @param [object] $obj
 * @return array
 */
function object_to_array($obj) {
    return (array) $obj;
}

/**
 * Trim/Remove empty array items (e.g. null or empty string values)
 *
 * @param [array] $array
 * @return array
 */
function trim_empty_array_items($array) {
    $trimmed_array = array_filter($array, create_function('$value', 'return $value !== "";'));
    return $trimmed_array;
}

/**
 * Trim/Remove empty array items (e.g. null or empty string values)
 *
 * @param [array] $array
 * @return array
 */
function filter_out_false_array_items($array) {
    $trimmed_array = array_filter($array, create_function('$value', 'return $value !== false;'));
    return $trimmed_array;
}

/**
 * Split string returning array or last item
 *
 * @param [string] $string
 * @param [int] $split where to split the string
 * @param [bool] $last
 * @return array/string
 */
function split_string_custom($string, $split, $last = false) {
    $array = explode($split, $string);
    if ($last) {
        if (is_array($array) && isset($array[count($array) - 1])) {
            return $array[count($array) - 1];
        }
    } else {
        return $array;
    }
}

/**
 * Return an array as string
 *
 * @param [array] $array
 * @param [string] $separator
 * @param [string/int] $sub_key
 * @return string
 */
function get_array_as_string($array, $separator = ' ', $sub_key = null) {
    $return_string = '';
    foreach ($array as $key => $val) {
        if (is_object($val)) {
            $val = object_to_array($val);
        }
        if (null !== $sub_key) {
            $val = get_array_item($val, $sub_key);
        }
        $return_string .= ($val . $separator);
    }
    return trim($return_string);
}

/**
 * Set Cookie w/ JavaScript by injecting inline script element
 *
 * @param  $name
 * @param  $value
 * @return cookie
 */
function js_set_cookie($name, $value = null) {
    $js_script = 'function createCookie(name, value, days) {var expires; if (days) {var date = new Date(); date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000)); expires = "; expires=" + date.toGMTString(); } else {expires = ""; } document.cookie = name + "=" + value + expires + "; path=/"; } function getCookie(c_name) {if (document.cookie.length > 0) {c_start = document.cookie.indexOf(c_name + "="); if (c_start != -1) {c_start = c_start + c_name.length + 1; c_end = document.cookie.indexOf(";", c_start); if (c_end == -1) {c_end = document.cookie.length; } return unescape(document.cookie.substring(c_start, c_end)); } } return null; } function setCookie(c_name, value, exdays) {var exdate = new Date(); exdate.setDate(exdate.getDate() + exdays); var c_value = escape(value) + ((exdays == null) ? "" : "; expires=" + exdate.toUTCString()); document.cookie = c_name + "=" + c_value; }';
    if (null !== $value) {
        $js_script .= 'setCookie("' . $name . '", "' . $value . '");';
    }
    $js_string = '<script id="my-tmp-script-id">' . $js_script . '</script>';
    echo $js_string;
    return get_array_item($_COOKIE, $name);
}

/**
 * Validate a US zip code
 * @param $zip_code
 *
 * @return bool
 */
function validate_zip_code($zip_code) {
    if (preg_match("/^([0-9]{5})(-[0-9]{4})?$/i", $zip_code)):
        return true;
    else:
        return false;
    endif;
}

/**
 * Log to file on server - Optionally define global PHP variable $user_log_file
 *
 * Example:
 * $GLOBALS['user_log_file'] = '/var/log/userlog.log';
 *
 * @param  $msg [string] the log message to write
 * @param  $filename [string] the log file path on server
 * @return void
 */
function my_log_to_file($msg, $filename = null) {
    global $user_log_file;
    if (null !== $filename):
        $fd = fopen($filename, "a");
    elseif (isset($user_log_file)):
        $fd = fopen($user_log_file, "a");
    endif;
    $str = "[" . date("Y/m/d h:i:s", strtotime('Now')) . "] " . $msg;
    fwrite($fd, $str . "\n");
    fclose($fd);
}

/**
 * Send log message to email address - Optionally define global PHP variable $user_log_email
 *
 * Example:
 * $GLOBALS['user_log_email'] = '/var/log/userlog.log';
 *
 * @param  $msg [string] the log message
 * @param  $address [string] email address to send to
 * @return void
 */
function my_log_to_mail($msg, $address = null) {
    global $user_log_email;
    $str = "[" . date("Y/m/d h:i:s", strtotime('Now')) . "] " . $msg;
    $e = "/^[-+\\.0-9=a-z_]+@([-0-9a-z]+\\.)+([0-9a-z]){2,4}$/i";
    if (null !== $address):
        $valid_email = (preg_match("/^([_a-z0-9\-]+)(\.[_a-z0-9\-]+)*@([a-z0-9\-]{2,}\.)*([a-z]{2,4})(,([_a-z0-9\-]+)(\.[_a-z0-9\-]+)*@([a-z0-9\-]{2,}\.)*([a-z]{2,4}))*$/", $address)) ? true : false;
        if ($valid_email):
            mail($address, "Log message", $str);
            log_to_file('Sending log email(s) to ' . $address . '.');
        else:
            log_to_file('Skipping email log: email(s) invalid.');
        endif;
    elseif (isset($user_log_email)):
        $valid_email = (preg_match("/^([_a-z0-9\-]+)(\.[_a-z0-9\-]+)*@([a-z0-9\-]{2,}\.)*([a-z]{2,4})(,([_a-z0-9\-]+)(\.[_a-z0-9\-]+)*@([a-z0-9\-]{2,}\.)*([a-z]{2,4}))*$/", $user_log_email)) ? true : false;
        if ($valid_email):
            mail($user_log_email, "Log message", $str);
            log_to_file('Sending log email(s) to ' . $user_log_email . '.');
        else:
            log_to_file('Skipping email log: email(s) invalid.');
        endif;
    else:
        log_to_file('Skipping email log: no email addresses defined. (define $GLOBALS["user_log_email"] in "wp-config.php" to enable).');
    endif;
}
/**
 * Check Remote File URL Exists
 *
 * @param  [str] $url
 * @return bool
 */
function check_remote_file_url_exists($url) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_NOBODY, 1);
    curl_setopt($ch, CURLOPT_FAILONERROR, 1);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    if (curl_exec($ch) !== FALSE) {
        return true;
    } else {
        return false;
    }
}

/**
 * Split HTML string into elements
 *
 * @param $string
 * @return str
 */
function my_split_els($string, $elem = 'div') {
    return trim_empty_array_items(explode('</' . $elem . '>', $string));
}

/**
 * Split HTML string into paragraphs
 *
 * @param $string
 * @return str
 */
function my_split_paragraphs($string, $elem = 'div') {
    return my_split_els($string, $elem);
}

/**
 * Get image count in directory
 *
 * @param  [str] $directory
 * @return [int]
 */
function get_img_count_in_dir($directory) {
    $files = glob("$directory{*.jpg,*.JPG,*jpeg, *JPEG,*.png,*.gif,*.svg,*.SVG}", GLOB_BRACE);
    if (false !== $files) {
        $filecount = count($files);
        return $filecount;
    } else {
        return 0;
    }
}

/**
 * Validate a US phone number
 *
 * @param $phone_num
 * @return bool
 */
function validate_phone_number($phone_num) {
    $regex = "/^(\d[\s-]?)?[\(\[\s-]{0,2}?\d{3}[\)\]\s-]{0,2}?\d{3}[\s-]?\d{4}$/i";
    $valid = (preg_match($regex, $phone_num) ? 'valid' : 'invalid');
    return $valid;
}

/**
 * Format phone number
 *
 * @param  [str] $country
 * @param  [str] $phone
 * @return [str]
 */
function format_phone_number($country, $phone) {
    $function = 'format_' . $country . 'phone_number';
    if (function_exists($function)) {
        return $function($phone);
    }
    return $phone;
}

/**
 * Format US phone number
 *
 * @param  [str] $country
 * @param  [str] $phone
 * @return [str]
 */
function format_us_phone_number($phone, $html_compliant = false) {
    if (!isset($phone{3})) {return '';}
    $phone = preg_replace("/[^0-9]/", "", $phone);
    $length = strlen($phone);
    switch ($length) {
    case 7:
        $formatted = preg_replace("/([0-9]{3})([0-9]{4})/", "$1-$2", $phone);
        break;
    case 10:
        $formatted = preg_replace("/([0-9]{3})([0-9]{3})([0-9]{4})/", "($1) $2-$3", $phone);
        break;
    case 11:
        $formatted = preg_replace("/([0-9]{1})([0-9]{3})([0-9]{3})([0-9]{4})/", "$1($2) $3-$4", $phone);
        break;
    default:
        $formatted = $phone;
        break;
    }
    if ($html_compliant) {
        $formatted = str_replace_custom(' ', '', $formatted);
    }
    return $formatted;
}

/**
 * Check if file is image
 *
 * @param  [str] $path
 * @return bool
 */
function my_file_is_valid_image($path) {
    $size = @getimagesize($path);
    return !empty($size);
}

/**
 * Check if file exists or just suppress the error
 *
 * @param  [str] $path - the file path
 * @return void
 */
function my_require($path) {
    if( file_exists($path) ) {
        require_once $path;
    }
}
