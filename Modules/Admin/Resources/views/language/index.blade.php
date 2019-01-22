@extends('admin::layouts.master')
 
    @section('content') 
      @include('admin::partials.navigation')
      @include('admin::partials.breadcrumb')   

       @include('admin::partials.sidebar')  

            <div class="panel panel-white"> 
  		          <div class="panel panel-flat">
                  <div class="panel-heading">
                    <h6 class="panel-title"><b> {{$heading }} List</b><a class="heading-elements-toggle"><i class="icon-more"></i></a></h6>
                    <div class="heading-elements">
                      <ul class="icons-list">
                        <li> <a type="button" href="{{route('language.create')}}" class="btn btn-primary text-white btn-labeled btn-rounded "><b><i class="icon-plus3"></i></b> Add {{$heading}}<span class="legitRipple-ripple" ></span></a></li> 
                      </ul>
                    </div>
                  </div> 
  		        </div>  
		        
  		        <div class="panel-body">
  		            <table class="table datatable-basic table-bordered table-hover" id="roles_list">
  		                <thead>
  		                    <tr>
  		                        <th>#Sno</th>
  		                        <th>Name</th> 
  		                        <th>Created at</th> 
  		                        <th class="text-center">Actions</th>
  		                    </tr>
  		                </thead>
  		                     
  		            </table> 
  		        </div> 
 		       </div>
	     </div> 
   @stop