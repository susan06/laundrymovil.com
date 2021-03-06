@if($modal)
<div class="modal-body">
@endif         

@if($order->order_payment)
  {!! Form::open(['route' => ['order.payment.update', $order->order_payment->id], 'method' => 'PUT', 'id' => 'form-modal', 'class' => 'form-horizontal form-label-left']) !!}
@else
 {!! Form::open(['route' => ['order.payment.store', $order->id], 'id' => 'form-modal', 'class' => 'form-horizontal form-label-left']) !!}
@endif

@if($order->order_payment)

  <div class="form-group">
    <label class="control-label col-md-3 col-sm-3 col-xs-12 hor-form" for="@lang('app.method_payment')">@lang('app.method_payment') <span class="required">*</span>
    </label>
    <div class="col-md-4 col-sm-4 col-xs-12">
      {!! Form::select('payment_method_id', $payments, $order->order_payment->payment_method_id, ['class' => 'form-control', 'id' => 'payment_method_id']) !!}
    </div>
  </div>

  <div class="form-group">
    <label class="control-label col-md-3 col-sm-3 col-xs-12 hor-form" for="@lang('app.reference')">@lang('app.reference') <span class="required">*</span>
    </label>
    <div class="col-md-2 col-sm-2 col-xs-12">
    {!! Form::text('reference', $order->order_payment->reference, ['class' => 'form-control', 'id' => 'reference']) !!}
    </div>
  </div>

  <div class="form-group">
    <label class="control-label col-md-3 col-sm-3 col-xs-12 hor-form" for="@lang('app.price')">@lang('app.price') <span class="required">*</span>
    </label>
    <div class="col-md-2 col-sm-2 col-xs-12">
    {!! Form::text('amount', $order->order_payment->amount, ['class' => 'form-control', 'id' => 'amount', 'readonly' => 'readonly']) !!}
    </div>
  </div>
@else
  
    <div class="alert alert-info alert-dismissible fade in" role="alert">
      <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
      </button>
      @lang('app.resumen_payment_programer')
    </div>

  <div class="form-group padding-10">
    <label class="control-label col-md-3 col-sm-3 col-xs-12 hor-form" for="@lang('app.method_payment')">@lang('app.method_payment') <span class="required">*</span>
    </label>
    <div class="col-md-4 col-sm-4 col-xs-12">
      {!! Form::select('payment_method_id', $payments, old('payment_method_id'), ['class' => 'form-control', 'id' => 'payment_method_id']) !!}
    </div>
  </div>

  <div class="form-group padding-10">
    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="@lang('app.reference_or_number')">@lang('app.reference_or_number') <span class="required">*</span>
    </label>
    <div class="col-md-2 col-sm-2 col-xs-12">
    {!! Form::text('reference', old('reference'), ['class' => 'form-control', 'id' => 'reference']) !!}
    </div>
  </div>

  <div class="form-group padding-10">
    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="@lang('app.price')">@lang('app.price') <span class="required">*</span>
    </label>
    <div class="col-md-2 col-sm-2 col-xs-12">
    {!! Form::text('amount', $order->total, ['class' => 'form-control', 'id' => 'amount', 'readonly' => 'readonly']) !!}
    </div>
  </div>
@endif

@if($modal)
</div>
@endif   

@if($modal)
<div class="modal-footer form-group">
  @if($order->order_payment)
    <button type="submit" class="btn btn-primary btn-submit col-sm-2 col-xs-6">@lang('app.update')</button>
  @else
      <button type="submit" class="btn btn-primary btn-submit col-sm-2 col-xs-6">@lang('app.save')</button>
  @endif
  <button type="button" class="btn btn-default col-sm-2 col-xs-5" data-dismiss="modal">@lang('app.close')</button>
</div>
@else

  <div class="form-group margin-top-10">
    <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
    @if($order->order_payment)
      <button type="submit" class="btn btn-primary btn-submit col-sm-3 col-xs-6">@lang('app.update')</button>
    @else
      <button type="submit" class="btn btn-primary btn-submit col-sm-3 col-xs-6">@lang('app.save')</button>
    @endif
      <button type="button" data-href="{{ route('order.show', $order->id) }}"  class="btn btn-default margin-left-5 col-sm-3 col-xs-5 create-edit-show" data-model="content" data-title="{{ trans('app.order_id').': '.$order->id }}">@lang('app.cancel')</button>
    </div>
  </div>
@endif 

{!! Form::close() !!}