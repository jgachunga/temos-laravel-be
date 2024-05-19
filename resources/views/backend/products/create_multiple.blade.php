@extends('backend.layouts.app')

@section('content')
    <ol class="breadcrumb">
      <li class="breadcrumb-item">
         <a href="{!! route('admin.products.index') !!}">Product</a>
      </li>
      <li class="breadcrumb-item active">Upload Multiple</li>
    </ol>
     <div class="container-fluid">
          <div class="animated fadeIn">
                @include('coreui-templates::common.errors')
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                <i class="fa fa-plus-square-o fa-lg"></i>
                                <strong>Upload Multiple Products</strong>
                                <a class="pull-right mr-5" href="{!! route('admin.products.downloadproducttemplate') !!}"><i class="fa fa-file fa-lg"></i>Download Template file</a>
                            </div>
                            <div class="card-body">
                                {!! Form::open(['route' => 'admin.products.storeupload', 'files'=> true]) !!}

                                   @include('backend.products.fieldsupload')

                                {!! Form::close() !!}
                            </div>
                        </div>
                    </div>
                </div>
           </div>
    </div>
@endsection
