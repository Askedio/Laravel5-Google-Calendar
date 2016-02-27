<?php

namespace Askedio\Laravel5GoogleCalendar;

class Events extends BaseClass
{
    /**
     * Return json results when posting events to a calendar.
     *
     * @return object()
     */
    public static function createEvents($data = [])
    {
        return self::events('post', $data);
    }

    /**
     * Return json list of events for a calendar.
     *
     * @return object()
     */
    public static function readEvents($event = false)
    {
        self::setVar('request', [
          'timeMin'      => self::get_time(self::$start),
          'timeMax'      => self::get_time(self::$end),
          'singleEvents' => 'true',
        ]);

        return self::events('get', false, $event);
    }

    /**
     * Return json results when updating a calendar.
     *
     * @return object()
     */
    public static function updateEvents($event, $data = [])
    {
        return self::events('patch', $data, $event);
    }

    /**
     * Return json results when removing a calendar.
     *
     * @return object()
     */
    public static function deleteEvents($event)
    {
        return self::events('remove', false, $event);
    }

    /**
     * Return calendar function based on method.
     *
     * @return object()
     */
    private static function events($method, $data, $event = false)
    {
        self::setVar('url', '/calendars/'.self::$calendar.'/events/'.$event);

        return self::$method($data);
    }
}
