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
                        <li> <a type="button" href="{{route('adminUser.create')}}" class="btn btn-primary text-white btn-labeled btn-rounded "><b><i class="icon-plus3"></i></b>Add Admin User<span class="legitRipple-ripple" ></span></a></li> 
                      </ul>
                    </div>
                  </div> 
                </div>  
                <div class="panel-body">
                    
                                    <div class="table-toolbar">
                                        <div class="row">
                                            <form action="{{route('adminUser')}}" method="get" id="filter_data">
                                            <div class="col-md-2">
                                                <select name="status" class="form-control" onChange="SortByStatus('filter_data')">
                                                    <option value="">Search by Status</option>
                                                    <option value="active" @if($status==='active') selected  @endif>Active</option>
                                                    <option value="inActive" @if($status==='inActive') selected  @endif>Inactive</option>
                                                </select>
                                            </div>
                                             
                                            <div class="col-md-2">
                                                <input value="{{ (isset($_REQUEST['search']))?$_REQUEST['search']:''}}" placeholder="search by Name/Email" type="text" name="search" id="search" class="form-control" >
                                            </div>
                                            <div class="col-md-2">
                                                <input type="submit" value="Search" class="btn btn-primary form-control">
                                            </div>
                                           
                                        </form>
                                        
                                      
                                        </div>
                                    </div>  
                            </div>
                                    <br>
                                     @if(Session::has('flash_alert_notice'))
                                         <div class="alert alert-success alert-dismissable" style="margin:10px">
                                            <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                                          <i class="icon fa fa-check"></i>  
                                         {{ Session::get('flash_alert_notice') }} 
                                         </div>
                                    @endif

                                    @if($users->count()==0)
                                   
                                     <span class="caption-subject font-red sbold uppercase"> Record not found!</span>
                                    @else 
                                  <div class="table-responsive">
                                    <table class="table table-striped table-hover table-bordered table-responsive" id="">
                                        <thead>
                                            <tr>
                                                 <th> Sno. </th>
                                                <th> Full Name </th>
                                                <th> Email </th>
                                                <th> Phone </th>
                                                <th> Role Type </th>
                                                <th>Signup Date</th>
                                                <th>Status</th>
                                                <th>Action</th> 
                                            </tr>
                                        </thead>
                                        <tbody>

                                    
                                        @foreach($users as $key => $result)
                                            <tr>
                                                 <td> {{ (($users->currentpage()-1)*15)+(++$key) }}</td>
                                                <td> {{$result->first_name.'  '.$result->last_name}} </td>
                                                <td> {{$result->email}} </td>
                                                <td> {{$result->phone}} </td>
                                                <td class="center"> 
                                               
                                                    @if($result->role_type==4)
                                                    <a href="{{url('admin/mytask/'.$result->id)}}">
                                                        View Details

                                                    </a>
                                                    @else
                                                    {{$roles[$result->role_type]??'admin'}}
                                                    @endif
                                                </td>
                                                <td>
                                                    {!! Carbon\Carbon::parse($result->created_at)->format('Y-m-d'); !!}
                                                </td>
                                                <td>
                                                    <span class="label label-{{ ($result->status==1)?'success':'warning'}} status" id="{{$result->id}}"  data="{{$result->status}}"  onclick="changeStatus({{$result->id}},'user')" >
                                                            {{ ($result->status==1)?'Active':'Inactive'}}
                                                        </span>
                                                </td>
                                                <td> 
                                      <a href="{{ route('adminUser.edit',$result->id)}}" class="btn btn-primary btn-xs" style="margin: 3px">
                            <i class="icon-pencil7" title="edit"></i>  
                            </a> 

                            {!! Form::open(array('class' => 'form-inline pull-left deletion-form', 'method' => 'DELETE',  'id'=>'deleteForm_'.$result->id, 'style'=>'margin:3px', 'route' => array('adminUser.destroy', $result->id))) !!}

                            <button class='delbtn btn btn-danger btn-xs' type="submit" name="remove_levels" value="delete" id="{{$result->id}}"><i class="icon-trash" title="Delete"></i> 
                            </button> 
                            {!! Form::close() !!} 

                                                    </td>
                                               
                                            </tr>
                                           @endforeach
                                         @endif   
                                        </tbody>
                                    </table>
                                    Showing {{($users->currentpage()-1)*$users->perpage()+1}} to {{$users->currentpage()*$users->perpage()}}
                                    of  {{$users->total()}} entries
                                     <div class="center" align="center">  {!! $users->appends(['search' => isset($_GET['search'])?$_GET['search']:''])->render() !!}</div> 
                </div> 
               </div>
         </div> 
   @stop