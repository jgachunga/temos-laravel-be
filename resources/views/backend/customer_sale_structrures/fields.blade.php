<!-- Cust Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('cust_id', 'Cust Id:') !!}
    {!! Form::text('cust_id', null, ['class' => 'form-control']) !!}
</div>

<!-- Structure Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('structure_id', 'Structure Id:') !!}
    {!! Form::text('structure_id', null, ['class' => 'form-control']) !!}
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <a href="{!! route('customerSaleStructrures.index') !!}" class="btn btn-default">Cancel</a>
</div>
