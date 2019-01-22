
  @extends('admin::layouts.master')

  @section('content') 
  @include('admin::partials.navigation')
  @include('admin::partials.breadcrumb')   

  @include('admin::partials.sidebar')  
  <div class="panel panel-white"> 


    <div class="panel panel-flat">
      <div class="panel-heading">
      <h6 class="panel-title"><b>Create {{$page_title ?? ''}}</b><a class="heading-elements-toggle"><i class="icon-more"></i></a></h6>
      <div class="heading-elements">
      <ul class="icons-list">
        <li> <a type="button" href="{{route('category')}}" class="btn btn-primary text-white   btn-rounded "> View categories<span class="legitRipple-ripple" ></span></a></li> 
      </ul>
      </div>
      </div> 
    </div>


    {!! Form::model($category, ['method' => 'PATCH', 'route' => ['sub-category.update', $category->id],'class'=>'form-basic ui-formwizard user-form','id'=>'form_sample_3','enctype'=>'multipart/form-data']) !!}
        @include('admin::sub_category.form', compact('category'))
    {!! Form::close() !!} 
        <!-- END FORM-->
    </div>
                        

        
@stop