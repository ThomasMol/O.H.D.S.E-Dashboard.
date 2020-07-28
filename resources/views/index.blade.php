@extends('layout')
@section('title','Index')
@section('content')
<!-- For google calendar integration -->
<script src="https://momentjs.com/downloads/moment-with-locales.min.js"></script>
<script src="https://apis.google.com/js/api.js"></script>
<header>
    <h1>Overzicht</h1>
</header>

<div class="row">
    <div class="col mb-4">
        <div class="card">
            <div class="card-header">Financi&euml;n</div>
            <div class="card-body">
                <h3>&euro; {{format_currency($financien->gespaard)}} <small class="text-muted"> gespaard</small></h3>
                <hr>
                <h2>&euro; {{format_currency($financien->schuld)}} <small class="text-muted"> schuld</small></h2>
            </div>

        </div>
    </div>
    <div class="col mb-4">
        <div id="se-calendar" class="card">
            <div class="card-header">
                Agenda
            </div>
            <div class="card-body">

            </div>
        </div>
    </div>

    <div class="col mb-4">
        <div class="card">
            <div class="card-header">
                Laatste declaraties
            </div>
            <div class="card-body p-0">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th scope="col">Datum</th>
                            <th scope="col">Omschrijving</th>
                            <th scope="col">Bedrag</th>
                            <th scope="col"></th>
                            <th scope="col"></th>

                        </tr>
                    </thead>
                    <tbody>
                        @foreach($declaraties as $declaratie)
                        <tr>
                            <th>{{ Carbon\Carbon::parse($declaratie->datum)->translatedFormat('d F Y - \(l\)') }}</th>
                            <td>{{ $declaratie->omschrijving }}</td>
                            <td>&euro; {{ format_currency($declaratie->bedrag) }}</td>
                            <td>
                                <a class="btn btn-link" href="/declaratie/{{$declaratie->declaratie_id}}"><span
                                        data-feather="eye"></span> Bekijk</a>
                                @if(Auth::user()->admin == 1)
                                <a class="btn btn-link" href="/declaraties/{{$declaratie->declaratie_id}}/wijzig"><span
                                        data-feather="edit"></span> Wijzig</a>
                                @endif
                            </td>
                        </tr>
                        @endforeach

                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
    /* This solution makes use of "simple access" to google, providing only an API Key.
            * This way we can only get access to public calendars. To access a private calendar,
            * we would need to use OAuth 2.0 access.
            *
            * "Simple" vs. "Authorized" access: https://developers.google.com/api-client-library/javascript/features/authentication
            * Examples of "simple" vs OAuth 2.0 access: https://developers.google.com/api-client-library/javascript/samples/samples#authorizing-and-making-authorized-requests
            *
            * We will make use of "Option 1: Load the API discovery document, then assemble the request."
            * as described in https://developers.google.com/api-client-library/javascript/start/start-js
            */
            function printCalendar() {
                // The "Calendar ID" from your calendar settings page, "Calendar Integration" secion:
                var calendarId = 'rdommb9v1jis80v4nvv3ki5m5g@group.calendar.google.com';
                moment.locale('nl');

                // 1. Create a project using google's wizzard: https://console.developers.google.com/start/api?id=calendar
                // 2. Create credentials:
                //    a) Go to https://console.cloud.google.com/apis/credentials
                //    b) Create Credentials / API key
                //    c) Since your key will be called from any of your users' browsers, set "Application restrictions" to "None",
                //       leave "Website restrictions" blank; you may optionally set "API restrictions" to "Google Calendar API"
                var apiKey = 'AIzaSyBU1p7_cCnqjwX2HEz8KFjfwaAk84bi3zI';
                // You can get a list of time zones from here: http://www.timezoneconverter.com/cgi-bin/zonehelp
                var userTimeZone = "Europe/Amsterdam";
                // Initializes the client with the API key and the Translate API.
                gapi.client.init({
                    'apiKey': apiKey,
                    // Discovery docs docs: https://developers.google.com/api-client-library/javascript/features/discovery
                    'discoveryDocs': ['https://www.googleapis.com/discovery/v1/apis/calendar/v3/rest'],
                }).then(function () {
                    // Use Google's "apis-explorer" for research: https://developers.google.com/apis-explorer/#s/calendar/v3/
                    // Events: list API docs: https://developers.google.com/calendar/v3/reference/events/list
                    return gapi.client.calendar.events.list({
                        'calendarId': calendarId,
                        'timeZone': userTimeZone,
                        'singleEvents': true,
                        'timeMin': (new Date()).toISOString(), //gathers only events not happened yet
                        'maxResults': 10,
                        'orderBy': 'startTime'
                    });
                }).then(function (response) {
                    if (response.result.items) {
                        var calendarRows = [`<div class="table-responsive"><table class="table table-hover table-fixed">

                                            <tbody>`];
                        response.result.items.forEach(function(entry) {
                            //console.log(entry.start.date);
                            if(entry.start.date !== undefined && entry.end.date == moment(entry.start.date).add(1, 'days').format('YYYY-MM-DD')){
                                var date = moment(entry.start.date).format('dddd D MMMM');
                                calendarRows.push(`<tr><td>${date}</td><td>${entry.summary}</td></tr>`);
                            }else if(entry.start.date !== undefined){
                                var startDate = moment(entry.start.date).format('dddd D MMMM');
                                var endDate = moment(entry.end.date).add(-1, 'days').format('dddd D MMMM');
                                calendarRows.push(`<tr><td>${startDate} - ${endDate}</td><td>${entry.summary}</td></tr>`);
                            }else if(moment(entry.start.dateTime).format('ll') == moment(entry.end.dateTime).format('ll')){
                                var startDateTime = moment(entry.start.dateTime).format('dddd D MMMM kk:mm');
                                var endDateTime = moment(entry.end.dateTime).format('kk:mm');
                                calendarRows.push(`<tr><td>${startDateTime} - ${endDateTime}</td><td>${entry.summary}</td></tr>`);
                            }else{
                                var startDateTime = moment(entry.start.dateTime).format('dddd D MMMM kk:mm');
                                var endDateTime = moment(entry.end.dateTime).format('dddd D MMMM kk:mm');
                                calendarRows.push(`<tr><td>${startDateTime} - ${endDateTime}</td><td>${entry.summary}</td></tr>`);
                            }

                        });
                        calendarRows.push('</tbody></table></div>');
                        $('#se-calendar .card-body').append(calendarRows.join(""));
                    }
                }, function (reason) {
                    console.log('Error: ' + reason.result.error.message);
                });
            };

            // Loads the JavaScript client library and invokes `start` afterwards.
            gapi.load('client', printCalendar);
</script>
@endsection
