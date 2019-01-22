
  @extends('admin::layouts.master')

  @section('content')
  @include('admin::partials.navigation')
  @include('admin::partials.breadcrumb')

  @include('admin::partials.sidebar')
  <div class="panel panel-white">


  <div class="panel panel-flat">
    <div class="panel-heading">
    <h6 class="panel-title"><b> {{$page_title ?? ''}}</b><a class="heading-elements-toggle"><i class="icon-more"></i></a></h6>
    <div class="heading-elements">
    <ul class="icons-list">
      <li> <a type="button" href="{{route('product-unit')}}" class="btn btn-primary text-white   btn-rounded ">{{$page_action ?? ''}}<span class="legitRipple-ripple" ></span></a></li>
    </ul>
    </div>
    </div>
  </div>


           {!! Form::model($productunit, ['route' => ['product-unit.store'],'class'=>'form-basic ui-formwizard user-form','id'=>'user-form','enctype'=>'multipart/form-data']) !!}

                @include('admin::unit.form')

            {!! Form::close() !!}

        </div>
@stop

