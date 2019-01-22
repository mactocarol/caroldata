@extends('admin::layouts.master')
 
    @section('content') 
      @include('admin::partials.navigation')
      @include('admin::partials.breadcrumb')   

       @include('admin::partials.sidebar')    
      
      <!-- /main sidebar -->

 <div class="content-wrapper">
      <div class="panel panel-white"> 

 
        <div class="panel panel-flat">
                      <div class="panel-heading">
                    <h6 class="panel-title"><b>Add {{$heading}}</b><a class="heading-elements-toggle"><i class="icon-more"></i></a></h6>
                    <div class="heading-elements">
                      <ul class="icons-list">
                        <li> <a type="button" href="{{route('language')}}" class="btn btn-primary text-white   btn-rounded "> View {{$heading}}<span class="legitRipple-ripple" ></span></a></li>   
                      </ul>

                    </div>
                  </div> 
                   <br> 
            </div>


            {!! Form::model($language, ['route' => ['language.store'],'class'=>'form-basic ui-formwizard user-form','id'=>'user-form','enctype'=>'multipart/form-data']) !!}
                               
                @include('admin::language.form')

  
            {!! Form::close() !!}  
                     
        </div> 
@stop
