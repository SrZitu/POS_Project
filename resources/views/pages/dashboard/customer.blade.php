@extends('layout.sidenav-layout')

@section('content')

@include('components.customer.all_customer')
@include('components.customer.customer_create')
@include('components.customer.customer_update')
@include('components.customer.customer_delete')
@endsection
