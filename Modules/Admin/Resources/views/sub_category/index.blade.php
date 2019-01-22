@extends('admin::layouts.master')
    @section('content')
      @include('admin::partials.navigation')
        @include('admin::partials.breadcrumb')
           @include('admin::partials.sidebar')
            <div class="panel panel-white">
  		          <div class="panel panel-flat">
                  <div class="panel-heading">
                    <h6 class="panel-title"><b> {{$heading }} </b><a class="heading-elements-toggle"><i class="icon-more"></i></a></h6>
                    <div class="heading-elements">
                      <ul class="icons-list">
                        <li> <a type="button" href="{{route('sub-category.create')}}" class="btn btn-primary text-white btn-labeled btn-rounded "><b><i class="icon-plus3"></i></b> Add Sub Category<span class="legitRipple-ripple" ></span></a></li>
                      </ul>
                    </div>
                  </div>
  		        </div>
  		         <div class="panel-body">
                  <div class="table-toolbar">
                    <div class="row">
                      <form action="{{route('sub-category')}}" method="get" id="filter_data">
                      <div class="col-md-3">
                          <input value="{{ (isset($_REQUEST['search']))?$_REQUEST['search']:''}}" placeholder="Search by category/Sub category" type="text" name="search" id="search" class="form-control" >
                      </div>
                      <div class="col-md-2">
                          <input type="submit" value="Search" class="btn btn-primary form-control">
                      </div>
                    </form>
                    </div>
                </div>
            </div>
  		        @if(Session::has('flash_alert_notice'))
                   <div class="alert alert-success alert-dismissable" style="margin:10px">
                      <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                    <i class="icon fa fa-check"></i>
                   {{ Session::get('flash_alert_notice') }}
                   </div>
               @endif


                <table class="table table-striped table-hover table-bordered table-responsive" id="">
	                <thead>
	                    <tr>
	                    	 <th>  Sno. </th>
	                        <th> Sub Category Name </th>
	                        <th> Category Name </th>
                          <th> Commission </th>
                          <th> Total Product Added </th>
                           <th>Over All Commissions</th>
                          <th></th>
	                        <th> Image </th>
	                        <th>Created date</th>
	                        <th>Action</th>
	                    </tr>
	                </thead>
	                <tbody>
	                @foreach($categories as $key => $result)
	                    <tr>
	                    	<td> {{++$key}} </td>
	                        <td> 
                            <a href="{{url(route('product').'?category_id='.$result->id.'&category='.$result->slug)}}" >
                            {{$result->sub_category_name}} </a> </td>
	                        <td> {{$result->parentCategory->category_name??'NA'}} </td>
                          <td> {{$result->commission??0}}% </td>
                          <td> {{$result->products->count()??0}}
                           </td>
                            <td> {{
                          money_format("%.2n",
                         ($result->products->sum('store_price'))*($result->commission)/100).' INR' }} </td>

                           <td>
                             <a href="{{url(route('product').'?category_id='.$result->id.'&category='.$result->slug)}}" >View Products </a>
                           </td>
	                        <td>
	                        <a href="{{ url($result->category_image)  }}" target="_blank" data-popup="lightbox">
	                        <img src="{{url($result->category_image)  }}" width="100px" height="50px;"> </a>  </td>

	                             <td>
	                                {!! Carbon\Carbon::parse($result->created_at)->format($date_format); !!}
	                            </td>

                        <td>
                            <a href="{{ route('sub-category.edit',$result->id)}}" class="btn btn-primary btn-xs" style="margin: 3px">
                            <i class="icon-pencil7" title="edit"></i>  
                            </a> 

                            {!! Form::open(array('class' => 'form-inline pull-left deletion-form', 'method' => 'DELETE',  'id'=>'deleteForm_'.$result->id, 'style'=>'margin:3px', 'route' => array('sub-category.destroy', $result->id))) !!}

                            <button class='delbtn btn btn-danger btn-xs' type="submit" name="remove_levels" value="delete" id="{{$result->id}}"><i class="icon-trash" title="Delete"></i> 
                            </button> 
                            {!! Form::close() !!}

                        </td>

	                    </tr>
	                   @endforeach

	                </tbody>
	            </table>
	             <div class="center" align="center">  {!! $categories->appends(['search' => isset($_GET['search'])?$_GET['search']:''])->render() !!}</div>
             </div>

@stop
