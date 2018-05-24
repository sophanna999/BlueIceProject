function ReservationProvince(me, attr, val, select){
    var data = me.value!=""&&me.value!=null&&me.value!="undefined"?me.value:val;
    $.ajax({
        method : "GET",
        url : url+"/address/amphur/"+data,
        dataType : 'json'
    }).done(function(rec){
        $(me).parent().parent().parent().find(attr).empty();
        $(me).parent().parent().parent().find(attr).append('<option value="">เลือกเมือง / อำเภอ / เขต</option>');
        $.each(rec, function(i, item) {
            if(select!=""&&select!=null&&select==item.amphur_id) {
                $(me).parent().parent().parent().find(attr).append('<option selected value="'+item.amphur_id+'" onclick="">'+item.amphur_name+'</option>');
            } else {
                $(me).parent().parent().parent().find(attr).append('<option value="'+item.amphur_id+'" onclick="">'+item.amphur_name+'</option>');
            }
        });
    })
}
function ReservationAmphur(me, attr, val, select){
    var data = me.value!=""&&me.value!=null&&me.value!="undefined"?me.value:val;
    $.ajax({
        method : "GET",
        url : url+"/address/district/"+data,
        dataType : 'json',
    }).done(function(rec){
        $(me).parent().parent().parent().find(attr).empty();
        $(me).parent().parent().parent().find(attr).append('<option value="">เลือกตำบล</option>');
        $.each(rec, function(i, item) {
            if(select!=""&&select!=null&&select==item.district_id) {
                $(me).parent().parent().parent().find(attr).append('<option selected value="'+item.district_id+'" onclick="">'+item.district_name+'</option>');
            } else {
                $(me).parent().parent().parent().find(attr).append('<option value="'+item.district_id+'" onclick="">'+item.district_name+'</option>');
            }
        });
    })
}
    function ReservationZipcode(me, attr, val){
        var data = me.value!=""&&me.value!=null&&me.value!="undefined"?me.value:val;
        $.ajax({
            method : "GET",
            url : url+"/address/zipcode/"+data,
            dataType : 'json'
        }).done(function(zipcode){
            $(me).parent().parent().parent().find(attr).val(zipcode[0].zipcode);
        })
    }
    function AutoReservation(state_val,city_val,tambon_val, state_attr,city_attr,tambon_attr,zip_attr){
        ReservationProvince(state_attr, city_attr, state_val, city_val);
        ReservationAmphur(city_attr, tambon_attr, city_val, tambon_val);
        ReservationZipcode(tambon_attr, zip_attr, tambon_val);
    }

    function Province(value,amphur,district,zipcode){
        var amp = "#"+amphur;
        var dt = "#"+district;
        var zc = "#"+zipcode;
        if(value == null){
            //$("#amphur").hide();
        }else{
            $.ajax({
                method : "GET",
                url : url+"/address/amphur/"+value,
                dataType : 'json'
            }).done(function(rec){
                $(amp).parent().html('<select class="form-control" name="BraCity" id="'+amphur+'" onchange="Amphur(this.value,\''+district+'\',\''+zipcode+'\')">'+
                    '<option value="">เลือก อำเภอ/เขต</option>'+
                '</select>');
                
                $(dt).parent().html('<select class="form-control" name="BraTambon" id="'+district+'">'+
                    '<option value="">เลือก ตำบล/แขวง</option>'+
                '</select>');
                $(zc).parent().html('<input type="text" class="form-control" placeholder="Enter your Zipcode" name="BraZipcode" id="'+zipcode+'">');
                var str = "";
    
                for(i=0; i<rec.length; i++){
                    str +='<option value="'+rec[i].amphur_id+'" onclick="">'+rec[i].amphur_name+'</option>';
                }
                $(amp).append(str);
                //$("#amphur").show();
            })
        }
    }
    function Amphur(value,district,zipcode){
        var dt = "#"+district;
        var zc = "#"+zipcode;
        if(value == null){
        //$("#district").hide();
        }else{
            $.ajax({
                method : "GET",
                url : url+"/address/district/"+value,
                dataType : 'json',
            }).done(function(rec){
                $(dt).parent().html(
                '<select class="form-control" name="BraTambon" id="'+district+'" onchange="Zipcode(this.value,\''+zipcode+'\')">'+
                    '<option>เลือกตำบล/แขวง</option>'+
                '</select>');
                $(zc).parent().html('<input type="text" class="form-control" name="BraZipcode" id="'+zipcode+'">');
                var str = "";
                for(i=0; i<rec.length; i++){
                    str +='<option value="'+rec[i].district_id+'">'+rec[i].district_name+'</option>';
                }
                $(dt).append(str);
                //Zipcode(rec[0].amphur_id);
                //$("#district").show();
            })
        }
    }
    function Zipcode(distrinct_id,zipcode){
        var zc = "#"+zipcode;
        $.ajax({
            method : "GET",
            url : url+"/address/zipcode/"+distrinct_id,
            dataType : 'json'
        }).done(function(zipcode){
            //alert(zipcode[0].zipcode);
            $(zc).val(zipcode[0].zipcode);
        })
    }
    
    function valAddress(tvalue,avalue,pvalue,did,aid,pid,zid){ //addvalue
        var amp = "#"+aid;
        var dt = "#"+did;
        var district = did;
        var amphur = aid;
        var zipcode = zid;
        if(avalue !== null){
            $.ajax({
                method : "GET",
                url : url+"/address/district/"+avalue,
                dataType : 'json',
            }).done(function(rec){
                $(dt).parent().html(
                '<select class="form-control" name="BraTambon" id="'+district+'" onchange="Zipcode(this.value,\''+zipcode+'\')">'+
                    '<option>เลือกตำบล/แขวง</option>'+
                '</select>');
                //$(zc).parent().html('<input type="text" class="form-control" name="'+zipcode+'" id="'+zipcode+'">');
                var str = "";
                for(i=0; i<rec.length; i++){
                    if(rec[i].district_id == tvalue){
                        str +='<option selected value="'+rec[i].district_id+'">'+rec[i].district_name+'</option>';
                    }else{
                        str +='<option value="'+rec[i].district_id+'">'+rec[i].district_name+'</option>';
                    }
                }
                $(dt).append(str);
            })
        }
    
        if(pvalue !== null){
            $.ajax({
                method : "GET",
                url : url+"/address/amphur/"+pvalue,
                dataType : 'json'
            }).done(function(rec){
                $(amp).parent().html('<select class="form-control" name="BraCity" id="'+amphur+'" onchange="Amphur(this.value,\''+district+'\',\''+zipcode+'\')">'+
                    '<option value="">เลือก อำเภอ/เขต</option>'+
                '</select>');
    
                var str = "";
    
                for(i=0; i<rec.length; i++){
                    if(avalue == rec[i].amphur_id){
                        str +='<option selected value="'+rec[i].amphur_id+'" onclick="">'+rec[i].amphur_name+'</option>';
                    }else{
                        str +='<option value="'+rec[i].amphur_id+'" onclick="">'+rec[i].amphur_name+'</option>';
                    }
                }
                $(amp).append(str);
                //$("#amphur").show();
            })
        }
    
    }