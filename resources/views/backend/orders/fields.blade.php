<!-- Structure Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('structure_id', 'Structure Id:') !!}
    {!! Form::number('structure_id', null, ['class' => 'form-control']) !!}
</div>

<!-- Order Ref Field -->
<div class="form-group col-sm-6">
    {!! Form::label('order_ref', 'Order Ref:') !!}
    {!! Form::number('order_ref', null, ['class' => 'form-control']) !!}
</div>

<!-- Pax Field -->
<div class="form-group col-sm-6">
    {!! Form::label('pax', 'Pax:') !!}
    {!! Form::text('pax', null, ['class' => 'form-control']) !!}
</div>

<!-- Total Amount Field -->
<div class="form-group col-sm-6">
    {!! Form::label('total_amount', 'Total Amount:') !!}
    {!! Form::text('total_amount', null, ['class' => 'form-control']) !!}
</div>

<!-- Discount Field -->
<div class="form-group col-sm-6">
    {!! Form::label('discount', 'Discount:') !!}
    {!! Form::text('discount', null, ['class' => 'form-control']) !!}
</div>

<!-- Amount Payable Field -->
<div class="form-group col-sm-6">
    {!! Form::label('amount_payable', 'Amount Payable:') !!}
    {!! Form::text('amount_payable', null, ['class' => 'form-control']) !!}
</div>

<!-- Customer Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('customer_id', 'Customer Id:') !!}
    {!! Form::number('customer_id', null, ['class' => 'form-control']) !!}
</div>

<!-- Opened By Field -->
<div class="form-group col-sm-6">
    {!! Form::label('opened_by', 'Opened By:') !!}
    {!! Form::number('opened_by', null, ['class' => 'form-control']) !!}
</div>

<!-- Closed By Field -->
<div class="form-group col-sm-6">
    {!! Form::label('closed_by', 'Closed By:') !!}
    {!! Form::number('closed_by', null, ['class' => 'form-control']) !!}
</div>

<!-- Closed At Field -->
<div class="form-group col-sm-6">
    {!! Form::label('closed_at', 'Closed At:') !!}
    {!! Form::text('closed_at', null, ['class' => 'form-control','id'=>'closed_at']) !!}
</div>

@section('scripts')
   <script type="text/javascript">
           $('#closed_at').datetimepicker({
               format: 'YYYY-MM-DD HH:mm:ss',
               useCurrent: true,
               icons: {
                   up: "icon-arrow-up-circle icons font-2xl",
                   down: "icon-arrow-down-circle icons font-2xl"
               },
               sideBySide: true
           })
       </script>
@endsection

<!-- Terminal Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('terminal_id', 'Terminal Id:') !!}
    {!! Form::number('terminal_id', null, ['class' => 'form-control']) !!}
</div>

<!-- Shift Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('shift_id', 'Shift Id:') !!}
    {!! Form::number('shift_id', null, ['class' => 'form-control']) !!}
</div>

<!-- Is Printed Field -->
<div class="form-group col-sm-6">
    {!! Form::label('is_printed', 'Is Printed:') !!}
    <label class="checkbox-inline">
        {!! Form::hidden('is_printed', 0) !!}
        {!! Form::checkbox('is_printed', '1', null) !!} 1
    </label>
</div>

<!-- Is Active Field -->
<div class="form-group col-sm-6">
    {!! Form::label('is_active', 'Is Active:') !!}
    <label class="checkbox-inline">
        {!! Form::hidden('is_active', 0) !!}
        {!! Form::checkbox('is_active', '1', null) !!} 1
    </label>
</div>

<!-- Is Shown Field -->
<div class="form-group col-sm-6">
    {!! Form::label('is_shown', 'Is Shown:') !!}
    <label class="checkbox-inline">
        {!! Form::hidden('is_shown', 0) !!}
        {!! Form::checkbox('is_shown', '1', null) !!} 1
    </label>
</div>

<!-- Is Closed Field -->
<div class="form-group col-sm-6">
    {!! Form::label('is_closed', 'Is Closed:') !!}
    <label class="checkbox-inline">
        {!! Form::hidden('is_closed', 0) !!}
        {!! Form::checkbox('is_closed', '1', null) !!} 1
    </label>
</div>

<!-- Is Void Field -->
<div class="form-group col-sm-6">
    {!! Form::label('is_void', 'Is Void:') !!}
    <label class="checkbox-inline">
        {!! Form::hidden('is_void', 0) !!}
        {!! Form::checkbox('is_void', '1', null) !!} 1
    </label>
</div>

<!-- Display Name Field -->
<div class="form-group col-sm-6">
    {!! Form::label('display_name', 'Display Name:') !!}
    {!! Form::text('display_name', null, ['class' => 'form-control']) !!}
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <a href="{!! route('orders.index') !!}" class="btn btn-default">Cancel</a>
</div>
