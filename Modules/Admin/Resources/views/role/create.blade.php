@extends('admin::layouts.master')
 
    @section('content') 
      @include('admin::partials.navigation')
      @include('admin::partials.breadcrumb')   

       @include('admin::partials.sidebar')  
      <div class="panel panel-white"> 

 
        <div class="panel panel-flat">
                      <div class="panel-heading">
                    <h6 class="panel-title"><b> {{$page_action ?? ''}}</b><a class="heading-elements-toggle"><i class="icon-more"></i></a></h6>
                    <div class="heading-elements">
                      <ul class="icons-list">
                        <li> <a type="button" href="{{route('role')}}" class="btn btn-primary text-white   btn-rounded "> View  {{$heading ?? ''}}<span class="legitRipple-ripple" ></span></a></li> 
                      </ul>
                    </div>
                  </div> 
            </div>


            {!! Form::model($role, ['route' => ['role.store'],'class'=>'form-basic ui-formwizard user-form','id'=>'user-form','enctype'=>'multipart/form-data']) !!}
                               
                @include('admin::role.form')

                <div class="table-responsive ">
                <table class="table table-striped table-hover table-bordered" id="contact">
                          <th>Module Name</th>
                          <th>Set Permission</th>
                          <tbody> 
                           @foreach($controllers as $route )
                               <tr >
                                   <td width="20%">{{$route}}</td>
                               
                                <?php
                                $canRead = '';
                                $canWrite = '';
                                $canDelete = '';
                                ?>
                                 <td class="text-center"> 
                                  <table width="50%"> 
                                  <tr>
                                    <td>
                                     Read <input type="checkbox" name="permission[{{$route}}][read]" value="1"   @if($canRead)  checked="checked" @endif  class="styled">
                                      </td>
                                     <td>
                                    Write  <input type="checkbox" name="permission[{{$route}}][write]" value="1"  @if($canWrite)  checked="checked" @endif class="styled">
                                    </td>
                                    <td>
                                    Delete <input type="checkbox" name="permission[{{$route}}][delete]" value="1"  @if($canDelete)  checked="checked" @endif class="styled">
                                  </td>
                                  </tr>
                                </table>  
                                 </td>  
                                 
                                  
                             </tr>     
                                @endforeach
                    </tbody>
                </table> 
                </div>
            {!! Form::close() !!}  
                     
        </div> 
@stop
