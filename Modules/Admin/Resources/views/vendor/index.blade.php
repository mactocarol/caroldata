@extends('admin::layouts.master')
 
    @section('content') 
      @include('admin::partials.navigation')
      @include('admin::partials.breadcrumb')   

       @include('admin::partials.sidebar')   

            <div class="panel panel-white"> 
  		          <div class="panel panel-flat">
                  <div class="panel-heading">
                    <h6 class="panel-title"><b> {{$heading }}</b><a class="heading-elements-toggle"><i class="icon-more"></i></a></h6>
                    <div class="heading-elements">
                      <ul class="icons-list">
                        <li> <a type="button" href="{{route('vendor.create')}}" class="btn btn-primary text-white btn-labeled btn-rounded "><b><i class="icon-plus3"></i></b> Add {{$page_title }}<span class="legitRipple-ripple" ></span></a></li> 
                         <li> <a type="button" href="{{route('vendorProduct.create')}}" class="btn btn-primary text-white btn-labeled btn-rounded "><b><i class="icon-plus3"></i></b> Add New Product<span class="legitRipple-ripple" ></span></a></li> 

                          <li> <a type="button" href="{{route('vendorProduct.create')}}?product=existing" class="btn btn-primary text-white btn-labeled btn-rounded "><b><i class="icon-plus3"></i></b> Add existing Product<span class="legitRipple-ripple" ></span></a></li>

                      </ul>
                    </div>
                  </div> 
  		        </div> 
  		         <div class="panel-body"> 
                  <div class="table-toolbar">
                    <div class="row">
                      <form action="{{route('vendor')}}" method="get" id="filter_data">
                     
                       
                      <div class="col-md-3">
                          <input value="{{ (isset($_REQUEST['search']))?$_REQUEST['search']:''}}" placeholder="Search by vendor" type="text" name="search" id="search" class="form-control" >
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
	                    	<th> Sno. </th>
	                        <th> Vendor Name </th>
                          <th> Shop Name </th>
	                        <th> Email </th> 
	                        <th> Mobile</th>
                          <th> Pincode</th>
                          <th></th>
	                        <th>Created date</th> 
	                        <th>Action</th> 
	                    </tr>
	                </thead>
	                <tbody>
	                @foreach($vendors as $key => $result)
	                    <tr>
	                    	<td> {{++$key}} </td>
                        <td> {{$result->vendor_name}} </td>
	                        <td> {{$result->shop_name}} </td>
	                        <td> {{$result->email}} </td>
	                        <td> {{$result->mobile}} </td>
                          <td> {{$result->pincode}} </td>
                           <td>  
                            <a href="{{url('admin/vendorProduct?vendor_id='.$result->id)}}">
                           Show Products  </a> </td>
	                         
                             <td>
	                                {!! Carbon\Carbon::parse($result->created_at)->format($date_format); !!}
	                            </td>
	                            
                          <td> 
                            <a href="{{ route('vendor.edit',$result->id)}}" class="btn btn-primary btn-xs" style="margin: 3px">
                            <i class="icon-pencil7" title="edit"></i>  
                            </a> 

                            {!! Form::open(array('class' => 'form-inline pull-left deletion-form', 'method' => 'DELETE',  'id'=>'deleteForm_'.$result->id, 'style'=>'margin:3px', 'route' => array('vendor.destroy', $result->id))) !!}

                            <button class='delbtn btn btn-danger btn-xs' type="submit" name="remove_levels" value="delete" id="{{$result->id}}"><i class="icon-trash" title="Delete"></i> 
                            </button> 
                            {!! Form::close() !!} 

                          </td>
	                       
	                    </tr>
	                   @endforeach
	                    
	                </tbody>
	            </table>
	             <div class="center" align="center">  {!! $vendors->appends(['search' => isset($_GET['search'])?$_GET['search']:''])->render() !!}</div> 
             </div>
      
@stop