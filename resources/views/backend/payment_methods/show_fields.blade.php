<!-- Id Field -->
<div class="form-group">
    {!! Form::label('id', 'Id:') !!}
    <p>{!! $paymentMethods->id !!}</p>
</div>

<!-- Name Field -->
<div class="form-group">
    {!! Form::label('name', 'Name:') !!}
    <p>{!! $paymentMethods->name !!}</p>
</div>

<!-- Img Url Field -->
<div class="form-group">
    {!! Form::label('img_url', 'Img Url:') !!}
    <p>{!! $paymentMethods->img_url !!}</p>
</div>

<!-- Created At Field -->
<div class="form-group">
    {!! Form::label('created_at', 'Created At:') !!}
    <p>{!! $paymentMethods->created_at !!}</p>
</div>

<!-- Updated At Field -->
<div class="form-group">
    {!! Form::label('updated_at', 'Updated At:') !!}
    <p>{!! $paymentMethods->updated_at !!}</p>
</div>

