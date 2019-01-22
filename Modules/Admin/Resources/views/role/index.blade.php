@extends('admin::layouts.master')
 
    @section('content') 
      @include('admin::partials.navigation')
      @include('admin::partials.breadcrumb')   

       @include('admin::partials.sidebar')  

            <div class="panel panel-white"> 
  		          <div class="panel panel-flat">
                  <div class="panel-heading">
                    <h6 class="panel-title"><b> {{$heading }}s and Permission</b><a class="heading-elements-toggle"><i class="icon-more"></i></a></h6>
                    <div class="heading-elements">
                      <ul class="icons-list">
                        <li> <a type="button" href="{{route('role.create')}}" class="btn btn-primary text-white btn-labeled btn-rounded "><b><i class="icon-plus3"></i></b> Add Role<span class="legitRipple-ripple" ></span></a></li> 
                      </ul>
                    </div>
                  </div> 
  		        </div>  
		        
  		        <div class="table-responsive">
  		            <table class="table datatable-basic table-bordered table-hover table-responsive" id="roles_list">
  		                <thead>
  		                    <tr>
  		                        <th>#Sno</th>
  		                        <th>Display Name</th> 
                              <th>Role Type</th> 
  		                        <th>Created at</th> 
  		                        <th class="text-center">Actions</th>
  		                    </tr>
  		                </thead>
  		                    <tbody>
                          @foreach($role as $key => $result)
                              <tr>
                               <th> {{++$key}} </th> 
                               <td> {{$result->name }} </td>
                                 <td> {{$result->name }} </td>
                                   <td>
                                      {!! Carbon\Carbon::parse($result->created_at)->format($date_format); !!}
                                  </td>
                                  
                                  <td> 
                                      <a href="{{ route('role.edit',$result->id)}}" class="btn btn-primary btn-xs" style="margin: 3px">
                            <i class="icon-pencil7" title="edit"></i>  
                            </a> 

                            {!! Form::open(array('class' => 'form-inline pull-left deletion-form', 'method' => 'DELETE',  'id'=>'deleteForm_'.$result->id, 'style'=>'margin:3px', 'route' => array('role.destroy', $result->id))) !!}

                            <button class='delbtn btn btn-danger btn-xs' type="submit" name="remove_levels" value="delete" id="{{$result->id}}"><i class="icon-trash" title="Delete"></i> 
                            </button> 
                            {!! Form::close() !!} 
                                  </td>
                                 
                              </tr>
                             @endforeach
                              
                          </tbody>
  		            </table> 
  		        </div> 
 		       </div>
	     </div> 
   @stop