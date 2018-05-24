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
<div class="col-12">
    <div class="card card-accent-primary">
        <div class="card-body row">
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
    var currColor = '#3c8dbc' //Red by default
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
        height: $(window).height() - 170,
//        displayEventTime: true,
        timeFormat: 'H:mm',
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
        events: url + "/Manufacture/ScheduleManufacture/show",
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
});</script>
<script type="text/javascript">
    function eventResize(event, delta, revertFunc) {
        var proid = event.ProPlanID;
        var startwork = event.start.format();
        var endwork = event.end.format();
        var allday = event.allDay;
//    var endshow = setdateyyyymmdd(endwork);
        var ppid = event.ProPlanID;
//    swal({
//        title: 'ปรับเวลางาน',
//        html: "แน่ใจหรือไม่ว่าต้องการปรับเวลางาน<br>ตั้งแต่ " + startwork + " ถึง " + endwork,
//        type: 'warning',
//        showCancelButton: true,
//        confirmButtonColor: '#3085d6',
//        cancelButtonColor: '#d33',
//        cancelButtonText: 'ยกเลิก',
//        confirmButtonText: 'บันทึก'
//    }).then((result) => {
//        if (result.value) {
        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: url + "/Manufacture/ScheduleManufacture/updateresize",
            data: {
                proid: proid,
                allDay: allday,
                start: startwork,
                end: endwork,
            },
            success: function (data) {
                if (data.status == 1) {
//              $('#calendar').fullCalendar('updateEvent', calEvent);
//              $('#calendar').fullCalendar('refetchEvents');s
                }
//                    swal({
//                        type: data.type,
//                        title: data.text,
//                        html: data.title
//                    });
            }
        });
//        } else {
//            revertFunc();
//        }
//    });
    }
    function eventDrop(event, delta, revertFunc) {
        var proid = event.ProPlanID;
        var startwork = event.start.format();
        var allday = event.allDay;
//    alert(allday);
        if (event.end) {
            var endwork = event.end.format();
        } else {
            var endwork = "";
        }
//    var endshow = setdateyyyymmdd(endwork);
        var ppid = event.ProPlanID;
//    swal({
//        title: 'ปรับเวลางาน',
//        html: "แน่ใจหรือไม่ว่าต้องการปรับเวลางาน<br>ตั้งแต่ " + startwork + " ถึง " + endwork,
//        type: 'warning',
//        showCancelButton: true,
//        confirmButtonColor: '#3085d6',
//        cancelButtonColor: '#d33',
//        cancelButtonText: 'ยกเลิก',
//        confirmButtonText: 'บันทึก'
//    }).then((result) => {
//        if (result.value) {
        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: url + "/Manufacture/ScheduleManufacture/updateresize",
            data: {
                proid: proid,
                allDay: allday,
                start: startwork,
                end: endwork
            },
            success: function (data) {
                if (data.status == 1) {
//              $('#calendar').fullCalendar('updateEvent', calEvent);
//              $('#calendar').fullCalendar('refetchEvents');
                }
//                    swal({
//                        type: data.type,
//                        title: data.text,
//                        html: data.title
//                    });
            }
        });
//        } else {
//            revertFunc();
//        }
//    });
    }
    function eventClick(calEvent, jsEvent, view) {
        var startwork = calEvent.start.format();
        var currColor = calEvent.color;
//    var endshow = setdateyyyymmdd(endwork);
        if (calEvent.end) {
            var endwork = calEvent.end.format();
            var endworkshow = ' ถึง  ' + endwork;
        } else {
            var endwork = "";
            var endworkshow = endwork;
        }
        var titleshow = calEvent.title;
                var machine = {!! $machine !!}
        ;
                var product = {!! $product !!}
        ;
        var allday = calEvent.allDay;
        var selectpro = '';
        var selectmach = '';
        // select productBOM
        selectpro += "<div class='form-group'>\n\
                    <div class='input-group'>\n\
                        <span class='input-group-addon'> สินค้า </span>\n\
                        <select id='product' class='form-control'>";
        for (var i = 0; i < product.length; i++) {
            var sl = '';
            if (product[i].ProID == calEvent.ProID)
                var sl = 'selected';
            selectpro += "<option " + sl + " value='" + product[i].ProID + "'>" + product[i].ProName + "</option>";
        }
        selectpro += "  </select></div></div>";
        // select machine
        var selectmach = "<div class='form-group'>\n\
                        <div class='input-group'>\n\
                            <span class='input-group-addon'> เครื่องจักร </span>\n\
                            <select id='machine' class='form-control'>";
        for (var i = 0; i < machine.length; i++) {
            var sl = '';
            if (machine[i].MachID == calEvent.MachID)
                var sl = 'selected';
            selectmach += "<option  " + sl + " value='" + machine[i].MachID + "'>" + machine[i].MachName + "</option>";
        }
        selectmach += "   </select></div></div>";
        swal({
            title: '<h3>แก้ไขกิจกรรม</h3>',
            width: 450,
            html: "" + startwork + endworkshow + "\n\
                " + selectpro + "\n\
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
                <input id='proid' type='hidden' class='form-control' value='" + calEvent.ProPlanID + "'>\n\
                <div class='form-group'>\n\
                    <div class='input-group'>\n\
                        <span class='input-group-addon'>จำนวน</span>\n\
                        <input id='newevent' name='newevent' type='number' class='form-control' value='" + calEvent.ProAmount + "'>\n\
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
            var proid = $("#proid").val();
            var machine = $("#machine").val();
            var product = $("#product").val();
//        alert(result.value);
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
                                url: url + "/Manufacture/ScheduleManufacture/delete/" + proid,
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
                            url: url + "/Manufacture/ScheduleManufacture/update",
                            data: {
                                proid: proid,
                                product: product,
                                machine: machine,
                                allDay: allday,
                                title: title,
                                start: startwork,
                                end: endwork,
                                color: colortitle
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
//                alert(title);
                    }
                }
            }
        });
    }
    function select(start, end) {
        var startwork = start.format();
        var endwork = end.format();
//    var endshow = setdateyyyymmdd(endwork);
        var machine = {!! $machine !!}
        ;
                var product = {!! $product !!}
        ;
        var selectpro = '';
        var selectmach = '';
        // select productBOM
        selectpro += "<div class='form-group'>\n\
                    <div class='input-group'>\n\
                        <span class='input-group-addon'> สินค้า </span>\n\
                        <select id='product' class='form-control'>";
        for (var i = 0; i < product.length; i++) {
            selectpro += "<option value='" + product[i].ProID + "'>" + product[i].ProName + "</option>";
        }
        selectpro += "  </select></div></div>";
        // select machine
        var selectmach = "<div class='form-group'>\n\
                        <div class='input-group'>\n\
                            <span class='input-group-addon'> เครื่องจักร </span>\n\
                            <select id='machine' class='form-control'>";
        for (var i = 0; i < machine.length; i++) {
            selectmach += "<option value='" + machine[i].MachID + "'>" + machine[i].MachName + "</option>";
        }
        selectmach += "   </select></div></div>";
        swal({
            title: "<h3>เพิ่มกิจกรรม</h3>",
            width: 450,
            html: startwork + " ถึง " + endwork + "<br>\n\
                " + selectpro + "\n\
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
                        <span class='input-group-addon'>จำนวน</span>\n\
                        <input id='newevent' name='newevent' type='number' class='form-control' placeholder=''>\n\
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
            var machine = $("#machine").val();
            var product = $("#product").val();
            var colortitle = $('#add-new-event').css('background-color');
            if (result.value) {
                if (title !== '') {
                    $.ajax({
                        type: 'POST',
                        dataType: 'json',
                        url: url + "/Manufacture/ScheduleManufacture",
                        data: {
                            product: product,
                            machine: machine,
                            title: title,
                            start: startwork,
                            end: endwork,
                            color: colortitle
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
</script>
@endsection