@extends('layout.sidenav-layout')
@section('site_title', 'Products')
@section('content')

@include('components.product.all_product')
@include('components.product.product_delete')
@include('components.product.product_create')
@include('components.product.product_update')


@endsection
