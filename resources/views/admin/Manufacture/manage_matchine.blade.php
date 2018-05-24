@extends('layouts.admin')
@section('csstop')
<title>{{$title}} | BlueIce</title>
<link rel="stylesheet" href="{{asset('js/fullcalendar-3.7.0/fullcalendar.css')}}">
<meta name="csrf-token" content="{{ csrf_token() }}">
<style>
    .fc-content{
        color: white;
    }
</style>
@endsection
@section('body')
<div class="resizecalendar">
    <div class="card card-accent-primary">
        <div class="card-body row ">
            <!-- THE CALENDAR -->
            <div class="col-md-12">
                <div id="calendar"></div>
            </div>                                                    
            <!-- /.box-body -->
        </div>
        <!-- /. box -->
    </div>
</div> 
@endsection

@section('jsbottom')
<script type="text/javascript" src="{{asset('js/fullcalendar-3.7.0/lib/moment.min.js')}}"></script>
<script type="text/javascript" src="{{asset('js/fullcalendar-3.7.0/fullcalendar.js')}}"></script>
<script type="text/javascript" src="{{asset('js/fullcalendar-3.7.0/locale/th.js')}}"></script>
<!--<script type="text/javascript" src="{{asset('js/fullcalendar-3.7.0/locale/ja.js')}}"></script>-->
<script type="text/javascript">
$(window).resize(function () {
    $('#calendar').fullCalendar('option', 'height', $(window).height() - 170);
});
$('body').on('click', '#color-chooser > li > a', function (e) {
    e.preventDefault();
    /* ADDING EVENTS */
    var currColor = '#3c8dbc'; //Red by default
    //Save color
    currColor = $(this).css('color');
    //Add color effect to button
    $('#add-new-event').css({'background-color': currColor, 'border-color': currColor});
});
$(document).ready(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $('#calendar').fullCalendar({
        header: {
            left: 'prev,next today',
            center: 'title',
            right: 'agendaDay,agendaWeek,month,listMonth'
        },
        displayEventEnd: true,
//        displayEventTime: true,
        timeFormat: 'H:mm',
        height: $(window).height() - 170,
//        locale: 'th',
        defaultView: 'month',
        //select table
        navLinks: true, // can click day/week names to navigate views
        selectable: true,
        selectHelper: true,
        // input title
        //select table
        editable: true,
        eventLimit: true, // allow "more" link when too many events
        // select data on database
        // input title
        select: function (start, end) {
            select(start, end);
        },
        events: url + "/Manufacture/ManageMatchine/show",
        eventClick: function (calEvent, jsEvent, view) {
            eventClick(calEvent, jsEvent, view);
        },
        eventResize: function (event, delta, revertFunc) {
            eventResize(event, delta, revertFunc);
        },
        eventDrop: function (event, delta, revertFunc) {
            eventDrop(event, delta, revertFunc);
        }
// select data on database
    });
});
</script>
<script type="text/javascript">
    function eventResize(event, delta, revertFunc) {
        var MachID = event.MachID;
        var startwork = event.start.format();
        var endwork = event.end.format();
        var allDay = event.allDay;
//  var endshow = setdateyyyymmdd(endwork);
        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: url + "/Manufacture/ManageMatchine/updateresize",
            data: {
                MachID: MachID,
                MachAllDay: allDay,
                MachRepairStart: startwork,
                MachRepairStop: endwork
            },
            success: function (data) {
                if (data.status == 1) {
//              $('#calendar').fullCalendar('updateEvent', calEvent);
//              $('#calendar').fullCalendar('refetchEvents');
                }
            }
        });
    }
    function eventDrop(event, delta, revertFunc) {
        var MachID = event.MachID;
        var startwork = event.start.format();
        var allDay = event.allDay;
//    alert(allday);
        if (event.end) {
            var endwork = event.end.format();
        } else {
            var endwork = "";
        }
//    var endshow = setdateyyyymmdd(endwork);
        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: url + "/Manufacture/ManageMatchine/updateresize",
            data: {
                MachID: MachID,
                MachAllDay: allDay,
                MachRepairStart: startwork,
                MachRepairStop: endwork
            },
            success: function (data) {
                if (data.status == 1) {
//              $('#calendar').fullCalendar('updateEvent', calEvent);
//              $('#calendar').fullCalendar('refetchEvents');
                }
            }
        });
    }
    function eventClick(calEvent, jsEvent, view) {
        var startwork = calEvent.start.format();
//  var endshow = setdateyyyymmdd(endwork);
        var currColor = calEvent.color;
        if (calEvent.end) {
            var endwork = calEvent.end.format();
            var endworkshow = ' ถึง  ' + endwork;
        } else {
            var endwork = "";
            var endworkshow = endwork;
        }
        var titleshow = calEvent.title;
        var allDay = calEvent.allDay;
        swal({
            title: '<h3>แก้ไขกิจกรรม</h3>',
            width: 450,
            html: "" + startwork + endworkshow + "\n\
                <div class='btn-group' style='width: 100%; margin-bottom: 10px;'>\n\
                    <ul class='fc-color-picker' id='color-chooser'>\n\
                        <li><a class='text-aqua' href='#'><i class='fa fa-square'></i></a></li>\n\
                        <li><a class='text-blue' href='#'><i class='fa fa-square'></i></a></li>\n\
                        <li><a class='text-light-blue' href='#'><i class='fa fa-square'></i></a></li>\n\
                        <li><a class='text-teal' href='#'><i class='fa fa-square'></i></a></li>\n\
                        <li><a class='text-yellow' href='#'><i class='fa fa-square'></i></a></li>\n\
                        <li><a class='text-orange' href='#'><i class='fa fa-square'></i></a></li>\n\
                        <li><a class='text-green' href='#'><i class='fa fa-square'></i></a></li>\n\
                        <li><a class='text-lime' href='#'><i class='fa fa-square'></i></a></li>\n\
                        <li><a class='text-red' href='#'><i class='fa fa-square'></i></a></li>\n\
                        <li><a class='text-purple' href='#'><i class='fa fa-square'></i></a></li>\n\
                        <li><a class='text-fuchsia' href='#'><i class='fa fa-square'></i></a></li>\n\
                        <li><a class='text-muted' href='#'><i class='fa fa-square'></i></a></li>\n\
                        <li><a class='text-navy' href='#'><i class='fa fa-square'></i></a></li>\n\
                    </ul>\n\
                </div>\n\
                <input id='MachID' type='hidden' class='form-control' value='" + calEvent.MachID + "'>\n\
                <div class='form-group'>\n\
                    <div class='input-group'>\n\
                        <span class='input-group-addon'>ชื่อเครื่องจักร</span>\n\
                        <input id='newevent' name='newevent' type='text' class='form-control' value='" + titleshow + "'>\n\
                        <div class='input-group-btn'>\n\
                            <button id='add-new-event' type='button' class='btn btn-primary btn-flat'\n\
                            style='background-color:" + currColor + ";border-color:" + currColor + ";'>Color</button>\n\
                        </div>\n\
                    </div>\n\
                </div>\n\
                <div class='form-group'>\n\
                    <div class='checkbox' style='text-align: left;'>\n\
                        <label class='checkbox-inline' for='delete-event'>\n\
                            <input id='delete-event' type='checkbox'>\n\
                                ลบกิจกรรม\n\
                        </label>\n\
                    </div>\n\
                </div>",
            showCancelButton: true,
            confirmButtonText: 'บันทึก',
            showLoaderOnConfirm: true,
            cancelButtonText: 'ยกเลิก'
//        allowOutsideClick: false
        }).then((result) => {
            var title = $("#newevent").val();
            var colortitle = $('#add-new-event').css('background-color');
            var MachID = $("#MachID").val();
            if (result.value) {
                if ($('#delete-event').is(':checked')) {
                    swal({
                        title: 'คุณต้องการลบกิจกรรมหรือไม่ ?',
                        text: "หากต้องการลบ กดปุ่ม 'ยืนยัน'",
                        type: 'question',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        showLoaderOnConfirm: true,
                        cancelButtonColor: '#d33',
                        cancelButtonText: 'ยกเลิก',
                        confirmButtonText: 'ยืนยัน'
                    }).then((result) => {
                        if (result.value) {
                            $.ajax({
                                type: 'get',
                                dataType: 'json',
                                url: url + "/Manufacture/ManageMatchine/delete/" + MachID,
                                success: function (rec) {
                                    if (rec.type == 'success') {
                                        $('#calendar').fullCalendar('refetchEvents');
                                        swal({
                                            confirmButtonText: 'ตกลง', title: rec.title, text: rec.text, type: rec.type
                                        });
                                    } else {
                                        swal(rec.title, rec.text, rec.type);
                                    }
                                }
                            });
                        }
                    });
                } else {
                    if (title != '') {
                        $.ajax({
                            type: 'POST',
                            dataType: 'json',
                            url: url + "/Manufacture/ManageMatchine/update",
                            data: {
                                MachID: MachID,
                                MachAllDay: allDay,
                                MachName: title,
                                MachRepairStart: startwork,
                                MachRepairStop: endwork,
                                MachColor: colortitle
                            },
                            success: function (rec) {
                                if (rec.type == 'success') {
                                    $('#calendar').fullCalendar('refetchEvents');
                                    swal({
                                        confirmButtonText: 'ตกลง', title: rec.title, text: rec.text, type: rec.type
                                    });
                                } else {
                                    swal(rec.title, rec.text, rec.type);
                                }
                            }
                        });
                    }
                }
            }
        });
    }
    function select(start, end) {
        var startwork = start.format();
        var endwork = end.format();
//  var endshow = setdateyyyymmdd(endwork);
        swal({
            title: "<h3>เพิ่มกิจกรรม</h3>",
            width: 450,
            html: startwork + " ถึง " + endwork + "<br>\n\
                <div class='btn-group' style='width: 100%; margin-bottom: 10px;'>\n\
                    <ul class='fc-color-picker' id='color-chooser'>\n\
                        <li><a class='text-aqua' href='#'><i class='fa fa-square'></i></a></li>\n\
                        <li><a class='text-blue' href='#'><i class='fa fa-square'></i></a></li>\n\
                        <li><a class='text-light-blue' href='#'><i class='fa fa-square'></i></a></li>\n\
                        <li><a class='text-teal' href='#'><i class='fa fa-square'></i></a></li>\n\
                        <li><a class='text-yellow' href='#'><i class='fa fa-square'></i></a></li>\n\
                        <li><a class='text-orange' href='#'><i class='fa fa-square'></i></a></li>\n\
                        <li><a class='text-green' href='#'><i class='fa fa-square'></i></a></li>\n\
                        <li><a class='text-lime' href='#'><i class='fa fa-square'></i></a></li>\n\
                        <li><a class='text-red' href='#'><i class='fa fa-square'></i></a></li>\n\
                        <li><a class='text-purple' href='#'><i class='fa fa-square'></i></a></li>\n\
                        <li><a class='text-fuchsia' href='#'><i class='fa fa-square'></i></a></li>\n\
                        <li><a class='text-muted' href='#'><i class='fa fa-square'></i></a></li>\n\
                        <li><a class='text-navy' href='#'><i class='fa fa-square'></i></a></li>\n\
                    </ul>\n\
                </div>\n\
                <div class='form-group'>\n\
                    <div class='input-group'>\n\
                        <span class='input-group-addon'>ชื่อเครื่องจักร</span>\n\
                        <input id='newevent' name='newevent' type='text' class='form-control' placeholder=''>\n\
                        <div class='input-group-btn'>\n\
                            <button id='add-new-event' type='button' class='btn btn-primary btn-flat'>Color</button>\n\
                        </div>\n\
                    </div>\n\
                </div>",
            showCancelButton: true,
            confirmButtonText: 'บันทึก',
            showLoaderOnConfirm: true,
            showConfirmButton: true,
            cancelButtonText: 'ยกเลิก',
            preConfirm: (email) => {
                return new Promise((resolve) => {
                    setTimeout(() => {
                        if (email === 'taken@example.com') {
                            swal.showValidationError(
                                    'This email is already taken.'
                                    );
                        }
                        resolve();
                    }, 0);
                });
            },
            allowOutsideClick: false
        }).then((result) => {
            var title = $("#newevent").val();
            var colortitle = $('#add-new-event').css('background-color');
            if (result.value) {
                if (title != '') {
                    $.ajax({
                        type: 'POST',
                        dataType: 'json',
                        url: url + "/Manufacture/ManageMatchine",
                        data: {
                            MachName: title,
                            MachRepairStart: startwork,
                            MachRepairStop: endwork,
                            MachColor: colortitle
                        },
                        success: function (rec) {
                            if (rec.type == 'success') {
                                $('#calendar').fullCalendar('refetchEvents');
                                swal({
                                    confirmButtonText: 'ตกลง', title: rec.title, text: rec.text, type: rec.type
                                });
                            } else {
                                swal(rec.title, rec.text, rec.type);
                            }
                        }
                    });
                    $('#calendar').fullCalendar('unselect');
                }
            }
        });
    }
    function setdateyyyymmdd(datenew) {
        var datenew = Date.parse(datenew);
        datenew = datenew - 86400000;
        datenew = new Date(datenew);
        return datenew.getFullYear() + '-' + (datenew.getMonth() + 1) + '-' + (datenew.getDate() < 10 ? "0" + datenew.getDate() : datenew.getDate());
    }
    function resizescreen() {
        var objTable = $("#resizecalendar");
        var windowheight = jQuery(window).height();
//    alert(windowheight);
        $('#calendar').css({'height': windowheight + 'px'});
    }
</script>
@endsection