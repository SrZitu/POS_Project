@extends('layout.sidenav-layout')

@section('content')

@include('components.category.all_category')
@include('components.category.category_create')
@include('components.category.category_update')
@include('components.category.category_delete')

@endsection
