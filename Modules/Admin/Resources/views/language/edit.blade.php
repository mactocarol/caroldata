@extends('admin::layouts.master')
 
    @section('content') 
      @include('admin::partials.navigation')
      @include('admin::partials.breadcrumb')   

       @include('admin::partials.sidebar') 
      @include('roles::partials.sidebar') 

      
      <!-- /main sidebar -->

 <div class="content-wrapper">
      <div class="panel panel-white"> 

 
        <div class="panel panel-flat">
                      <div class="panel-heading">
                    <h6 class="panel-title"><b>Edit {{$heading or ''}}</b><a class="heading-elements-toggle"><i class="icon-more"></i></a></h6>
                    <div class="heading-elements">
                      <ul class="icons-list">
                        <li> <a type="button" href="{{route('role')}}" class="btn btn-primary text-white   btn-rounded "> View Roles<span class="legitRipple-ripple" ></span></a></li> 
                      </ul>
                    </div>
                  </div> 
            </div>

             {!! Form::model($role, ['method' => 'PATCH', 'route' => ['role.update', $role->id],'class'=>'form-basic ui-formwizard user-form','id'=>'form_sample_3','enctype'=>'multipart/form-data']) !!}
                @include('role::role.form', compact('role'))
            {!! Form::close() !!}   
                     
        </div> 
@stop
