@extends('layouts.app')

@section('content')
    <ol class="breadcrumb">
          <li class="breadcrumb-item">
             <a href="{!! route('customerSaleStructrures.index') !!}">Customer Sale Structrure</a>
          </li>
          <li class="breadcrumb-item active">Edit</li>
        </ol>
    <div class="container-fluid">
         <div class="animated fadeIn">
             @include('coreui-templates::common.errors')
             <div class="row">
                 <div class="col-lg-12">
                      <div class="card">
                          <div class="card-header">
                              <i class="fa fa-edit fa-lg"></i>
                              <strong>Edit Customer Sale Structrure</strong>
                          </div>
                          <div class="card-body">
                              {!! Form::model($customerSaleStructrure, ['route' => ['customerSaleStructrures.update', $customerSaleStructrure->id], 'method' => 'patch']) !!}

                              @include('customer_sale_structrures.fields')

                              {!! Form::close() !!}
                            </div>
                        </div>
                    </div>
                </div>
         </div>
    </div>
@endsection