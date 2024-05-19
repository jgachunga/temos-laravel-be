@extends('backend.layouts.app')

@section('content')
    <ol class="breadcrumb">
        <li class="breadcrumb-item">Products</li>
    </ol>
    <div class="container-fluid">
        <div class="animated fadeIn">
             @include('flash::message')
             <div class="row">
                 <div class="col-lg-12">
                     <div class="card">
                         <div class="card-header">
                             <i class="fa fa-align-justify"></i>
                             Products
                             <a class="pull-right" href="{!! route('admin.products.create') !!}"><i class="fa fa-plus-square fa-lg"></i></a>
                             <a class="pull-right mr-5" href="{!! route('admin.products.createmultiple') !!}"><i class="fa fa-file fa-lg"></i>Upload file</a>
                         </div>
                         <div class="card-body">
                             @include('backend.products.table')
                              <div class="pull-right mr-3">
                                     
                              </div>
                         </div>
                     </div>
                  </div>
             </div>
         </div>
    </div>
@endsection

