# Laravel5-Google-Calendar
A simple integration of Laravel 5 (or any PHP) and Google Calendar REST API

Used in the Laravel Bill Reminder app I created:
https://github.com/Askedio/BillReminder

# Overview
I needed access to Google Calendar and their PHP SDK failed for me on to many levels. I am perfectly happy using REST APIS and decided to go that route.


## This package needs better authentication checks, error checks and unit testing.

# Usage

Declare use statements to access Calendar and CalendarEvent.
~~~
  use Askedio\Laravel5GoogleCalendar\Calendar
  use Askedio\Laravel5GoogleCalendar\Events as CalendarEvent
~~~


# Event Options

~~~
  CalendarEvent::createEvents([])
  CalendarEvent::readEvents(eventId)
  CalendarEvent::updateEvents(eventId, [])
  CalendarEvent::deleteEvents(eventId)
~~~

# Calendar Options

~~~
  Calendar::createCalendar([])
  Calendar::readCalendar()
  Calendar::updateCalendar([])
  Calendar::deleteCalendar()
~~~

# Class Options
Set the calendar to an empty value when using readCalendar to get a list of calendars.

~~~
  # Change calendar
  Calendar::setVar('calendar', 'primary')

  # Change start/end time
  Calendar::setVar('start', 'yesterday')
  Calendar::setVar('end', 'today')
~~~
