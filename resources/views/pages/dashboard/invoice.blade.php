@extends('layout.sidenav-layout')
@section('content')
    @include('components.invoice.invoiceList')
    @include('components.invoice.invoiceDetails')
    @include('components.invoice.invoiceDelete')
@endsection
