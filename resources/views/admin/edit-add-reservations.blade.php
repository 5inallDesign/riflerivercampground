@extends('layouts.admin')
@section('content-header')
    <h1>{{(isset($reservation))?'Reservation #'.$reservation->id:'Add Reservation'}}</h1>
@stop
@section('content')

@if (isset($reservation))
<div class="box">
    <div class="box-body">

        <div class="text-center">
            <button class="btn btn-lg btn-primary">Check In</button>
            <button class="btn btn-lg btn-success">Approve/Deny</button>
        </div>

    </div>
</div>
@endif

<div class="box">

    <div class="box-header with-border">
        <h2 class="box-title">{{(isset($reservation))?'Edit':'Add'}} Reservation</h2>
    </div>
    <div class="box-body">

        <form action="{{url('/reservations')}}" method="post">
            <p class="text-right"><button class="btn btn-primary">Save Changes</button></p>
            <div class="row">
                <div class="col-sm-6 col-md-4">
                    <div class="form-group">
                        <label>From</label>
                        <div class="input-group date" id="starts_at">
                            <input class="form-control date" name="starts_at" type="text" placeholder="{{date('m/d/Y')}}" value="{{(isset($reservation))?date('m/d/Y',strtotime($reservation->starts_at)):''}}">
                            <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-md-4">
                    <div class="form-group">
                        <label>To</label>
                        <div class="input-group date" id="ends_at">
                            <input class="form-control date" name="ends_at" type="text" placeholder="{{date('m/d/Y',strtotime('+3 days'))}}" value="{{(isset($reservation))?date('m/d/Y',strtotime($reservation->ends_at)):''}}">
                            <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-6 col-md-4">
                    <div class="form-group">
                        <label>What</label>
                        <select name="what" class="form-control select-what">
                            <option {{(isset($reservation) && $reservation->reservationable_type == 'CampSite')?'selected':''}} value="CampSite">Camping</option>
                            <option {{(isset($reservation) && $reservation->reservationable_type == 'CabinSite')?'selected':''}} value="CabinSite">Cabin</option>
                        </select>
                    </div>
                </div>
                <div class="col-sm-6 col-md-4 type-col" style="{{(isset($reservation) && $reservation->reservationable_type == 'CabinSite')?'display:none':''}}">
                    <div class="form-group">
                        <label>Type</label>
                        <select name="type" class="form-control select-type">
                            <option value="rustic">Rustic</option>
                            <option value="modern">Modern</option>
                        </select>
                    </div>
                </div>
                <div class="col-sm-6 col-md-4">
                    <div class="form-group">
                        <label>Site</label>
                        <select name="site_id" class="form-control select-type" id="site-id" {{count($available_spots) == 0?'disabled':''}}>
                            @foreach ($available_spots as $site)
                                <option value="{{$site->site_id}}" {{(isset($reservation) && $reservation->site_id == $site->site_id)?'selected':''}}>{{$site->site_id}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-6">
                    <div class="form-group">
                        <label>Adults</label>
                        <select name="adult_count" class="form-control">
                            <option value="1" {{(isset($reservation) && $reservation->adult_count == 1)?'selected':''}}>1</option>
                            <option value="2" {{(isset($reservation) && $reservation->adult_count == 2)?'selected':''}}>2</option>
                            <option value="3" {{(isset($reservation) && $reservation->adult_count == 3)?'selected':''}}>3</option>
                            <option value="4" {{(isset($reservation) && $reservation->adult_count == 4)?'selected':''}}>4</option>
                            <option value="5" {{(isset($reservation) && $reservation->adult_count == 5)?'selected':''}}>5</option>
                            <option value="6" {{(isset($reservation) && $reservation->adult_count == 6)?'selected':''}}>6</option>
                        </select>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label>Children <small>(Ages 6-15)</small></label>
                        <select name="children_count" class="form-control">
                            <option value="0" {{(isset($reservation) && $reservation->children_count == 0)?'selected':''}}>0</option>
                            <option value="1" {{(isset($reservation) && $reservation->children_count == 1)?'selected':''}}>1</option>
                            <option value="2" {{(isset($reservation) && $reservation->children_count == 2)?'selected':''}}>2</option>
                            <option value="3" {{(isset($reservation) && $reservation->children_count == 3)?'selected':''}}>3</option>
                            <option value="4" {{(isset($reservation) && $reservation->children_count == 4)?'selected':''}}>4</option>
                            <option value="5" {{(isset($reservation) && $reservation->children_count == 5)?'selected':''}}>5</option>
                            <option value="6" {{(isset($reservation) && $reservation->children_count == 6)?'selected':''}}>6</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-6">
                    <div class="control-group form-group {{(count($errors) > 0 && $errors->first('name'))?'has-error':''}}">
                        <label>Name</label>
                        <input type="text" name="name" value="{{(isset($reservation))?$reservation->contact_name:''}}" size="40" class="form-control" aria-required="true" aria-invalid="false" placeholder="Name">
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="control-group form-group {{(count($errors) > 0 && $errors->first('email'))?'has-error':''}}">
                        <label>Email Address</label>
                        <input type="email" name="email" value="{{(isset($reservation))?$reservation->contact_email:''}}" size="40" class="form-control" aria-required="true" aria-invalid="false" placeholder="Email">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-6">
                    <div class="control-group form-group {{(count($errors) > 0 && $errors->first('phone'))?'has-error':''}}">
                        <label>Phone Number</label>
                        <input type="tel" name="phone" value="{{(isset($reservation))?$reservation->contact_phone:''}}" size="40" class="form-control" aria-required="true" aria-invalid="false" placeholder="Phone Number">
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="control-group form-group">
                        <label>Best Time to Call</label>
                        <input type="text" name="best_time" value="{{(isset($reservation))?$reservation->best_time:''}}" size="40" class="form-control" aria-required="true" aria-invalid="false" placeholder="ex: 5:00pm">
                    </div>
                </div>
            </div>
            <div class="control-group form-group {{(count($errors) > 0 && $errors->first('comment'))?'has-error':''}}">
                <label>User Comments</label>
                <textarea name="comment" cols="40" rows="3" class="form-control" aria-required="true" aria-invalid="false">{{(isset($reservation))?$reservation->comment:''}}</textarea>
            </div>
        </form>

    </div>
</div>

@stop
@section('scripts')
<script>
    $(document).ready(function()
    {
        $('#starts_at').datetimepicker({
            allowInputToggle: true,
            format: 'M/D/YYYY'
        });
        $('#ends_at').datetimepicker({
            useCurrent: false, //Important! See issue #1075
            allowInputToggle: true,
            format: 'M/D/YYYY'
        });
        $("#starts_at").on("dp.change", function (e) {
            $('#ends_at').data("DateTimePicker").minDate(e.date);
        });
        $("#ends_at").on("dp.change", function (e) {
            $('#starts_at').data("DateTimePicker").maxDate(e.date);
        });
        $('.select-what').on('change', function(event)
        {
            if ($(this).val() == 'CampSite')
            {
                $('.type-col').show();

            } else {
                $('.type-col').hide();
            }
            checkAvailability();
        });

        $('.select-type').on('change', function(event)
        {
            checkAvailability();
        });

        function checkAvailability()
        {
            $('#site-id').prop('disabled', true);
            var availabilityObject =  new Object;
            availabilityObject.starts_at = $("#starts_at input").val();
            availabilityObject.ends_at = $("#ends_at input").val();
            availabilityObject.what = $('.select-what').val();
            availabilityObject.type = $('.select-type').val();
            $.ajax({
                url: '{{url("/api/reservation-availability")}}',
                type: 'GET',
                data: availabilityObject,
                success: function(data) {
                    if (JSON.parse(data).length === 0) {
                        $('.alert-no-sites').show();
                    } else {
                        $('.alert-no-sites').hide();
                        $('#site-id').prop('disabled', false);
                    }
                    console.log(data);
                    var source = $("#site-template").html();
                    var template = Handlebars.compile(source);
                    var html = template({
                        data: JSON.parse(data)
                    });
                    $('#site-id').html(html);
                }
            });
        }
    });
</script>
@stop