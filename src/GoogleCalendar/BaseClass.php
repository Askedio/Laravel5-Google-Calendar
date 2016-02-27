<?php

namespace Askedio\Laravel5GoogleCalendar;

use Auth;

class BaseClass
{
    private static $google_api = 'https://www.googleapis.com/calendar/v3';

    private static $url = '';
    private static $request = [];
    public static $errors = false;

    private static $curl_method = 'POST';
    private static $curl_data = [];

    public static $start = 'last day of last month';
    public static $end = 'last day of this month';

    public static $calendar = 'primary';

    /**
     * Set class variables.
     *
     * @return false
     */
    public static function setVar($var, $val)
    {
        self::$$var = $val;

        return false;
    }

    /**
     * Return json from google api or false.
     *
     * @return object()
     */
    public static function get()
    {
        self::setVar('curl_method', false);

        return self::curl();
    }

    /**
     * Return json from google api or false.
     *
     * @return object()
     */
    public static function remove()
    {
        self::setVar('curl_method', 'DELETE');

        return self::curl();
    }

    /**
     * Return json from google api or false.
     *
     * @return object()
     */
    public static function post($post = [])
    {
        self::setVar('curl_data', json_encode($post));
        self::setVar('curl_method', 'POST');

        return self::curl();
    }

    /**
     * Return json from google api or false.
     *
     * @return object()
     */
    public static function patch($patch = [])
    {
        self::setVar('curl_data', json_encode($patch));
        self::setVar('curl_method', 'PATCH');

        return self::curl();
    }

    /**
     * Return json from google api or false.
     *
     * @return object()
     */
    public static function put($put = [])
    {
        self::setVar('curl_data', json_encode($put));
        self::setVar('curl_method', 'PUT');

        return self::curl();
    }

    /**
     * Return array of curl headers with authorization token.
     *
     * @return array()
     */
    private static function curl_headers()
    {
        return [
         'Content-type: application/json',
         'Authorization: Bearer '.Auth::user()->token,
      ];
    }

    /**
     * Return url for get/post call, has request vars + api key.
     *
     * @return string
     */
    private static function get_url()
    {
        return self::$google_api.self::$url.self::build_request();
    }

    /**
     * Return result of curl get/post.
     *
     * @return object/false
     */
    private static function curl()
    {
        $ch = self::curl_open();
        $results = json_decode(curl_exec($ch));
        curl_close($ch);

        return is_object($results) ? self::check_errors($results) : false;
    }

    /**
     * Return curl.
     *
     * @return curl_init();
     */
    private static function curl_open()
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, self::get_url());
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, self::curl_headers());
        if (self::$curl_method == 'POST') {
            curl_setopt($ch, CURLOPT_POST, true);
        }
        if (in_array(self::$curl_method, ['DELETE', 'PUT', 'PATCH'])) {
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, self::$curl_method);
        }
        if (in_array(self::$curl_method, ['POST', 'PUT', 'PATCH'])) {
            curl_setopt($ch, CURLOPT_POSTFIELDS, self::$curl_data);
        }

        return $ch;
    }

    /**
     * Return boolean if error exists on curl result.
     *
     * @return bool
     */
    private static function check_errors($results)
    {
        return isset($results->error->errors)
        ? self::setVar('errors', $results->error->errors)
        : $results;
    }

    /**
     * Return request query.
     *
     * @return http_build_query()
     */
    private static function build_request()
    {
        $_key = env('GOOGLE_API_KEY') ? ['key' => env('GOOGLE_API_KEY')] : [];

        return '?'.http_build_query(array_merge(self::$request, $_key));
    }

    /**
     * Return date RFC3339.
     *
     * @return false
     */
    public static function get_time($time = 'today')
    {
        $dt = new \DateTime($time, new \DateTimeZone(config('timezone', 'America/Los_Angeles')));

        return $dt->format('Y-m-d\TH:i:sP');
    }
}
