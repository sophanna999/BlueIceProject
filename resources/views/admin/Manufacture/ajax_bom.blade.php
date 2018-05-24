
<div class="row">
@isset($ProductBOM)
    @foreach($ProductBOM as $k => $PBOM)
    <div class="col-sm-6 col-lg-4">
        <div class="card mb-3">
            <a class="BOM" href="{{url('Manufacture/BOM/detail')}}/{{base64_encode($PBOM->ProID)}}">
                <img class="card-img-top image" style="width:100%;height:350px;" src="{{asset('/uploads/temp')}}/{{($PBOM->ProImg!="")?$PBOM->ProImg:'no-image.jpg'}}">
            <div class="card-block">
                <h4 class="card-text">{{$PBOM->ProID}}</h4>
                <h4 class="card-title">{{$PBOM->ProName}}</h4>
                <p>{{ $PBOM->Unit['amount']==null ? "": "(". $PBOM->Unit['amount'] .")" }}</p>
                <p class="card-text text-muted">
                    คงเหลือ {{$PBOM->balance==null ? 0 : $PBOM->balance}} {{$PBOM->Unit['name_th']}}
                </p>
                <p class="card-text text-muted">
                    มูลค่า {{$PBOM->balance==null||$PBOM->ProPrice==null ? 0 : (int)($PBOM->ProPrice)*(int)($PBOM->balance)}} บาท
                </p>
            </div>
        </a>
        </div>
    </div>
    @endforeach
@endisset
</div>
