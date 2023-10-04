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
    <div class="col-md-4 mb-4">
        <div class="card">
            <div class="card-header">Financi&euml;n</div>
            <div class="card-body">
                <small class="text-muted"> gespaard</small>
                <h3>&euro; {{format_currency($financien->gespaard)}} </h3>
                <small class="text-muted"> schuld</small><br>
                @php
                    $schuld = $financien->schuld;
                    $colorClass = ($schuld < 0) ? '#24AC3A' : '#F82F28';
                @endphp

                <h2 class="h2schuld" style="background-color: {{ $colorClass }} ">
                    &euro; {{ format_currency($financien->schuld) }}
                </h2><br>
                <small class="text-muted">Laatste update: {{$transacties}}</small><br>
                <style>
                .h2schuld {
                color: white;
                padding: 7px 12px;
                border-radius: 10px;
                font-size: 20px;
                width: auto;
                display: inline-block;
                }
                </style>
            </div>

        </div>

        <div class="card">
            <div class="card-body">
                <button class="btn btn-outline-primary btn-block" type="submit"
                onclick="window.open('https://my.hidrive.com/share/2ytxhv263n', '_blank');">SE Gallery</a>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                Top 5 schulden
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover table-fixed">
                        <tbody>
                            @foreach ($leden as $index => $lid)
                                <td>{{ $lid->roepnaam }}</td>
                                <td>&euro; {{ format_currency($lid->schuld) }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                SE Awards 22-23
            </div>
            <div class="card-body" style="padding-top:0px;">
                <b>SE'er van het jaar:</b> Paul<br>
                <b>Koningsaward:</b> Stan<br>
                <b>Gouden lul:</b> Lucas<br>
                <b>Gouden haak:</b> Tom<br>
                <b>Gouden bieb:</b> Ashkan<br>
            </div>
        </div>

    </div>
    <div class="col-md-8 mb-4">
        <div id="se-calendar" class="card">
            <div class="card-header">
                Agenda
            </div>
            <div class="card-body">

            </div>
        </div>

        <!-- <div class="card">
            <div class="card-header">
                Belangrijke data
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover table-fixed">
                        <tbody>
                            <tr><td>Vrijdag 9 juni</td><td>Datediner</td></tr>
                            <tr><td>14 t/m 17 augustus</td><td>UIT-week</td></tr>
                            <tr><td>Vrijdag 15 december</td><td>Kerstdiner</td></tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div> -->

        <div class="card">
            <div class="card-body">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6" style="padding-left: 0;">
                            <h4>Top 5 naheffing</h4>
                            <div class="table-responsive">
                                <table class="table table-hover table-fixed">
                                    <tbody>
                                        @foreach ($leden_nahef as $index => $lid)
                                            <td>{{ $lid->roepnaam }}</td>
                                            <td>&euro; {{ format_currency($lid->total_amount) }}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="col-md-6" style="padding-right: 0;">
                            <h4>Top 5 afwezig</h4>
                            <div class="table-responsive">
                                <table class="table table-hover table-fixed">
                                    <tbody>
                                        @foreach ($leden_afwezig as $index => $lid)
                                            <td>{{ $lid->roepnaam }}</td>
                                            <td>{{ $lid->total_afwezig }}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
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
