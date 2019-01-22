
@extends('admin::layouts.master')

  @section('content')

    @include('admin::partials.navigation')

    @include('admin::partials.breadcrumb')

     @include('admin::partials.sidebar')

    <div class="panel panel-white">
    <div class="panel panel-flat">
        <div class="panel-heading">
          <h6 class="panel-title"><b>{{$heading ?? ''}}</b><a class="heading-elements-toggle"><i class="icon-more"></i></a>  </h6>
            <div class="heading-elements">
                <ul class="icons-list">
                    <li> <a type="button" href="{{route('product-type')}}" class="btn btn-primary text-white   btn-rounded "> View Product Type<span class="legitRipple-ripple" ></span></a></li>
                </ul>
          </div>
        </div>
    </div>

    {!! Form::model($producttype, ['method' => 'PATCH', 'route' => ['product-type.update', $producttype->id],'class'=>'form-basic ui-formwizard user-form','id'=>'form_sample_3','enctype'=>'multipart/form-data']) !!}
        @include('admin::type.form', compact('producttype'))
    {!! Form::close() !!}
<!-- END FORM-->
</div>
<!-- END VALIDATION STATES-->



@stop
