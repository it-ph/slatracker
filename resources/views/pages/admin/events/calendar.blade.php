@extends('layouts.master')

@section('title')
    Event Calendar
@endsection

@section('css')
    <!-- DataTables -->
    <link href="{{ asset('assets/libs/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/libs/datatables/buttons.dataTables.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/libs/calendar/dist/fullcalendar.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/custom-calendar.css') }}" id="app-style" rel="stylesheet" type="text/css" />
@endsection

@section('content')
    @component('components.breadcrumb_w_button')
        @slot('li_1')
            Manage / Event Calendar
        @endslot
        @slot('title')
            Event Calendar
        @endslot
    @endcomponent

    <div class="row">
        <div class="col-md-12">
            @include('notifications.success')
            @include('notifications.error')
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div id="calendar"></div>
                </div>
            </div>
        </div>
    </div>

    @include('pages.admin.events.event-modal')
@endsection

@section('script')
    <!-- Required datatable js -->
    <script src="{{ asset('assets/libs/datatables/datatables.min.js') }}"></script>
    <script src="{{ asset('assets/libs/datatables/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('assets/libs/jszip/jszip.min.js') }}"></script>
    <script src="{{ asset('assets/libs/pdfmake/pdfmake.min.js') }}"></script>
    <script src="{{ asset('assets/libs/daterangepicker/moment.min.js') }}"></script>
    <script src="{{ asset('assets/libs/calendar/dist/fullcalendar.min.js') }}"></script>
</head>
@endsection

@section('custom-js')
    <script src="{{asset('scripts/events.js')}}"></script>
    <script>
        !function($) {
        "use strict";

        var CalendarApp = function() {
            this.$body = $("body")
            this.$calendar = $('#calendar'),
            this.$calendarObj = null
        };

        /* Initializing */
        CalendarApp.prototype.init = function() {
            var defaultEvents =  [
                // events
                @foreach($events as $event)
                {
                    id: "{{ $event->id }}",
                    title: "{{ $event->title }}",
                    description: "{{ $event->description }}",
                    event_type: "{{ $event->event_type }}",
                    start: "{{ $event->start->format('Y-m-d H:i') }}",
                    end: "{{ $event->end->format('Y-m-d H:i') }}",
                    color: "{{ $event->color }}",
                },
                @endforeach
            ];

            moment.DATETIME_LOCAL = "YYYY-MM-DD\THH:mm";

            var $this = this;
            $this.$calendarObj = $this.$calendar.fullCalendar({
                // slotDuration: '00:15:00', /* If we want to split day time each 15minutes */
                // minTime: '08:00:00',
                // maxTime: '19:00:00',
                defaultView: 'month',
                contentHeight: 'auto',
                handleWindowResize: true,

                buttonText: {
                    day: 'Day',
                    week: 'Week',
                },

                header: {
                    left: 'prev,next today',
                    // left: 'none',
                    center: 'title',
                    // center: 'title',
                    right: 'month,listWeek,listDay,list'
                    // right: 'prev,next today'
                },
                events: defaultEvents,
                editable: false,
                droppable: false, // this allows things to be dropped onto the calendar !!!
                eventLimit: true, // allow "more" link when too many events
                views: {
                    month:
                    {
                        eventLimit: 4
                    }
                },
                selectable: true,
                selectHelper: true,
                select: function (start,end) {
                    $('#eventModal').modal('show');
                    $('#eventModalTitle').text('Create New Event');
                    $('#btn_delete').hide();
                    $("#start").val(moment(start).format(moment.DATETIME_LOCAL));
                    $("#end").val(moment(end).format(moment.DATETIME_LOCAL));
                },
                eventClick:  function(event)
                {
                    $('#eventModal').modal('show');
                    $('#eventModalTitle').text('Update Event');
                    $('#btn_delete').show();
                    $("#edit_id").val(event.id);
                    $("#title").val(event.title);
                    $("#description").val(event.description);
                    $("#event_type").val(event.event_type);
                    $("#start").val(moment(event.start).format(moment.DATETIME_LOCAL));
                    $("#end").val(moment(event.end).format(moment.DATETIME_LOCAL));
                    $("#color").val(event.color);
                },
            });
        },

        //init CalendarApp
        $.CalendarApp = new CalendarApp, $.CalendarApp.Constructor = CalendarApp

        }(window.jQuery),

        //initializing CalendarApp
        function($) {
            "use strict";
            $('#calendar').hide();
            $('#calendar').fadeIn(1000);
            $.CalendarApp.init()
        }(window.jQuery);
    </script>
@endsection
