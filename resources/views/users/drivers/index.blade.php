@extends('layouts.back')

@section('page-title', trans('app.drivers'))

@section('content')

<div class="right_col" role="main">
  <div class="">
    <div class="row">
      <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
          <div class="page-title">
            <div class="title_left">
              <h3>@lang('app.drivers')</h3>
            </div>
            @include('partials.status')
            @include('partials.search')
            <div class="clearfix"></div>
          </div>
        
          <div class="x_content">

          @if (Auth::user()->role->name == 'admin')
            <div class="row">
              <div class="col-md-2 col-sm-2 col-xs-12">
              <button type="button" data-href="{{ route('admin-driver.create', 'role=false') }}" class="btn btn-primary create-edit-show col-xs-12" data-model="modal" title="@lang('app.create_driver')">@lang('app.create_driver')</button>
              </div>
            </div>
          @endif
            
            <div id="content-table">
              @include('users.drivers.list')
            </div>

          </div>
        </div>
      </div>
    </div>
  </div>
</div>

@endsection

@section('scripts')

 <!-- jquery.inputmask -->
 {!! HTML::script('public/vendors/jquery.inputmask/dist/min/jquery.inputmask.bundle.min.js') !!}
 <!-- moment -->
 {!! HTML::script('public/assets/js/moment/moment.min.js') !!}
 <!-- bootstrap-daterangepicker -->
 {!! HTML::script('public/vendors/bootstrap-datetimepicker/bootstrap-datetimepicker.min.js') !!}

 {!! HTML::script('public/assets/js/comission_shedules.js') !!}
@endsection