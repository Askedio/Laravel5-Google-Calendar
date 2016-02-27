<?php

namespace Askedio\Laravel5GoogleCalendar;

class Calendar extends BaseClass
{
    /**
     * Return json results when updating a calendar.
     *
     * @return object()
     */
    public static function createCalendar($data = [])
    {
        return self::calendar('post', $data);
    }

    /**
     * Return json details of a calendar or if no calendar defined, a list of calendars.
     *
     * @return object()
     */
    public static function readCalendar()
    {
        return self::calendar('get', false);
    }

    /**
     * Return json results when updating a calendar.
     *
     * @return object()
     */
    public static function updateCalendar($data = [])
    {
        return self::calendar('put', $data);
    }

    /**
     * Return json results when removing a calendar.
     *
     * @return object()
     */
    public static function deleteCalendar()
    {
        return self::calendar('remove', false);
    }

    /**
     * Return calendar function based on method.
     *
     * @return object()
     */
    private static function calendar($method, $data)
    {
        $url = self::$calendar != false
        ? (self::$calendar == 'create'
            ? '/calendars'
            : '/calendars/'.self::$calendar
          )
        : '/users/me/calendarList';

        self::setVar('url', $url);

        return self::$method($data);
    }
}
