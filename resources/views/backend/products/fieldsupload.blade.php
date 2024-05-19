<!-- Client Field -->
<div class="form-group col-sm-6">
    {!! Form::label('client_id', 'Client:') !!}
    {!! Form::select('client_id', $clients , null, ['class' => 'form-control']) !!}
</div>
<!-- Distributor Field -->
<div class="form-group col-sm-6">
        {!! Form::label('', 'Choose File to Upload:') !!}
        {!! Form::file('productfile'); !!} 
</div>
<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <a href="{!! route('admin.products.index') !!}" class="btn btn-default">Cancel</a>
</div>