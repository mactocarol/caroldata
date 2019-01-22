@extends('admin::layouts.master')
  @section('title', 'Dashboard')
    @section('header')
    <h1>Dashboard</h1>
    @stop
    @section('content') 
      @include('admin::partials.navigation')
      <!-- Left side column. contains the logo and sidebar -->
      @include('admin::partials.sidebar')
      @include('admin::sub_category.getdata')   
@stop