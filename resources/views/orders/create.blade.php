@extends('layouts.front')

@section('page-title', trans('app.service_request'))

@section('content')

<div class="right_col" role="main">
  <div class="">
    <div class="row">
      <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
          <div class="x_title">
            <h3>@lang('app.service_request')</h3>
            <div class="clearfix"></div>
          </div>
          <div class="x_content">
            <div class="" id="order_create">
              {!! Form::open(['route' => 'order.store', 'id' => 'form-modal', 'class' => 'form-horizontal form-label-left']) !!}

                <div class="t_title">
                  <h2> @lang('app.address')</h2>
                  <div class="clearfix"></div>
                </div>

                @if($exist_address)
                <table class="table">
                  <thead>
                  <tr>
                    <th>@lang('app.label')</th>
                    <th>@lang('app.address')</th>
                    <th width="10%"></th>
                  </tr>
                  </thead>
                    <tbody id="locations_list" class="form-horizontal">
                    @foreach($client->client_location as $key => $item)
                      @if($item->status == 'accepted')
                      <tr class="row_location">
                        <td>{{ $item->get_label() }}</td>
                        <td>{{ $item->address }}</td>
                        <td>
                          <button type="button" data-location="{{ $item->id }}" class="btn btn-success select-location"> 
                            @lang('app.select')
                          </button>
                        </td>
                      </tr>
                      @endif
                      @endforeach
                    </tbody>
                 </table>
                @else
                <div class="alert alert-warning alert-dismissible fade in" role="alert">
                  @lang('app.dont_address_accepted') <a href="{{ route('client.locations') }}">@lang('app.my_locations')</a>
                </div>
                @endif 
                {{Form::hidden('client_location_id', '', ['id' => 'client_location_id'])}}

                <div class="t_title">
                  <h2> @lang('app.searched')</h2>
                  <div class="clearfix"></div>
                </div>

                <div class="row">            
                  <div class="col-md-4 col-sm-4 col-xs-12 form-group">
                      {!! Form::text('date_search', old('date_search'), ['class' => 'form-control datetime has-feedback-left', 'id' => 'date_search', 'readonly' => 'readonly']) !!}
                    <span class="fa fa-calendar form-control-feedback left" aria-hidden="true"></span>
                  </div>
                </div>
                
                <div class="row"> 
                  <div class="col-md-4 col-sm-4 col-xs-12 form-group">
                    <select name="time_search" class="form-control" id="time_search">
                      @foreach($working_hours as $working_hour)
                      @if($working_hour['status'] == 'notavailable')
                         <option value="" disabled="disabled">{{$working_hour['interval'].' - '.trans("app.Not available") }}
                      @else
                         <option value="{{$working_hour['id']}}">{{$working_hour['interval']}} 
                      @endif
                      @endforeach
                    </select>
                  </div>
                </div>
                  
                <div class="t_title">
                  <h2> @lang('app.delivery')</h2>
                  <div class="clearfix"></div>
                </div>

     
                <div class="row">
                  <div class="col-md-4 col-sm-4 col-xs-12 form-group">
                    {!! Form::text('date_delivery', old('date_delivery'), ['class' => 'form-control has-feedback-left datetime', 'id' => 'date_delivery', 'readonly' => 'readonly']) !!}
                    <span class="fa fa-calendar form-control-feedback left" aria-hidden="true"></span>
                  </div>                
                </div>
                 <div class="row">
                  <div class="col-md-4 col-sm-4 col-xs-12 form-group">
                    <select name="time_delivery" class="form-control" id="time_delivery">
                      @foreach($time_delivery as $delivery)
                        @if($delivery['published'] == 'public')
                        <option value="{{$delivery['id']}}">{{$delivery['interval']}}
                        @endif
                      @endforeach
                    </select>  
                  </div>            
                </div>
                
                <div class="t_title">
                  <h2> @lang('app.packages')</h2>
                  <div class="clearfix"></div>
                </div>

                <div class="row">
                  <div class="col-md-5 col-sm-5 col-xs-12 form-group">
                    {!! Form::select('category', $categories, old('category'), ['class' => 'form-control col-md-7 col-xs-12 select2_single', 'id' => 'category']) !!}
                  </div>            
                </div>

                <div class="row">
                    <table class="table" id="packages_table">
                      <thead>
                      <tr>
                        <th>@lang('app.name')</th>
                        <th>@lang('app.category')</th>
                        <th>@lang('app.price') {{ '('.Settings::get('coin').')' }}</th>
                        <th width="10%"></th>
                      </tr>
                      </thead>
                      <tbody id="packages_list" class="form-horizontal">
                        <!-- load content locations -->
                      </tbody>
                    </table>
                </div>

                <div class="t_title">
                  <h2> @lang('app.details')</h2>
                  <div class="clearfix"></div>
                </div>

                <div class="row">
                  <div class="col-md-7 col-sm-7 col-xs-12 form-group">
                      {!! Form::textarea('special_instructions', old('special_instructions'), ['class' => 'form-control', 'id' => 'special_instructions', 'rows' => '3', 'placeholder' => trans('app.special_instructions')]) !!}
                  </div>
                </div>

                <div class="t_title">
                  <h2> @lang('app.code_promo')</h2>
                  <div class="clearfix"></div>
                </div>

                <div class="row">
                  <div class="col-md-7 col-sm-7 col-xs-12 form-group">
                    <div class="input-group">
                      {!! Form::text('coupon', old('coupon'), ['class' => 'form-control', 'id' => 'coupon', 'placeholder' => trans('app.coupon')]) !!}
                      <span class="input-group-btn">
                          <button class="btn btn-primary validate" type="button">@lang('app.validate')</button>
                        </span>
                    </div>
                  </div>
                </div>
                {!! Form::hidden('client_coupon_id', '0', ['id' => 'client_coupon_id']) !!}

                <div class="sub-total" style="display: none;">
                  <div class="t_title">
                    <h2> @lang('app.sub_total')</h2>
                    <div class="clearfix"></div>
                  </div>

                  <div class="row">
                    <div class="product_price col-md-4 col-sm-4 col-xs-12">
                      <h1 class="price"><span id="sub-total">0.00</span> {{Settings::get('coin') }}</h1> 
                    </div>
                  </div>
                </div>
                {!! Form::hidden('sub_total', '0', ['id' => 'sub_total_price']) !!}
                  
                <div class="discount" style="display: none;">
                  <div class="t_title">
                    <h2> @lang('app.discount')</h2> 
                    <div class="clearfix"></div>
                  </div>

                  <div class="row">
                    <div class="product_price col-md-4 col-sm-4 col-xs-12">
                      <h1 class="price" id="discount">0.00</h1>
                      <h1 class="price" id="discount-porcentage">(0%)</h1>
                    </div>
                  </div>
                  {!! Form::hidden('discount', '0', ['id' => 'discount_price']) !!}
                </div>
                  
                  <div class="t_title">
                    <h2> @lang('app.total')</h2>
                    <div class="clearfix"></div>
                  </div>

                  <div class="row">
                    <div class="product_price col-md-4 col-sm-4 col-xs-12">
                      <h1 class="price"><span id="total">0.00</span> {{Settings::get('coin') }}</h1> 
                    </div>
                  </div>

                  {!! Form::hidden('total', '0', ['id' => 'total_price']) !!}

                  @if($exist_address)
                  <div class="ln_solid"></div>
                  <div class="form-group col-md-3 col-sm-3 col-xs-12">
                    <button type="submit" class="btn btn-primary btn-submit col-xs-12">@lang('app.save')</button>
                  </div>
                  @endif
              {!! Form::close() !!}
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

@endsection

@section('scripts')
@parent

  <!-- Select2 -->
  {!! HTML::script('public/vendors/select2/dist/js/select2.full.min.js') !!}
  <!-- bootstrap-daterangepicker -->
  {!! HTML::script('public/vendors/bootstrap-datetimepicker/bootstrap-datetimepicker.min.js') !!}


<script type="text/javascript">

  var first_select_package = "{{ trans('app.first_select_package') }}";
  var first_introduce_coupon = "{{ trans('app.first_introduce_coupon') }}";
  var package_added = "{{ trans('app.package_added') }}";
  var edit = false;
  var count = 1;
  var day_disabled = [0,{!! Settings::get('week') !!},6];
  var today = moment(new Date());
  var url_package_get_details = "{{ route('package.get.details') }}";
  var url_package_show_category = "{{ route('package.show.category') }}";
  var url_validate_coupon = "{{ route('coupon.check') }}";
  var endTime = '{!! Settings::get("time_close") !!}';
  var coin = "{{ Settings::get('coin') }}";

  var beginningTime = moment().add({ hours: 0, minutes: 30}).format('h:mm A');

  if(! moment(new Date(beginningTime)).isBefore(new Date(endTime)) ) {
    today =  moment(new Date()).add(1, 'day');
  }

  $('#date_search').datetimepicker({
    format: 'DD-MM-YYYY',
    minDate: today,
    maxDate: moment(today).add(7, 'day'),
    ignoreReadonly: true,
    daysOfWeekDisabled: day_disabled
  });

  var today_search = $('#date_search').val();
  var today_new = today_search.split("-").reverse().join("-");
  var tomorrow = moment(today_new).add(1, 'day');

  $('#date_delivery').datetimepicker({
    format: 'DD-MM-YYYY',
    defaultDate: tomorrow,
    minDate: tomorrow,
    maxDate: moment(today).add(7, 'day'),
    ignoreReadonly: true,
    daysOfWeekDisabled: day_disabled
  }); 

</script>

{!! HTML::script('public/assets/js/services_create.js') !!}

@endsection