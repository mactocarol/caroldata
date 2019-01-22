@extends('admin::layouts.master')
 
    @section('content') 
      @include('admin::partials.navigation')
      @include('admin::partials.breadcrumb')   

       @include('admin::partials.sidebar')  
      <div class="panel panel-white"> 

 
        <div class="panel panel-flat">
                      <div class="panel-heading">
                    <h6 class="panel-title"><b>Create {{$heading ?? ''}}</b><a class="heading-elements-toggle"><i class="icon-more"></i></a></h6>
                    <div class="heading-elements">
                      <ul class="icons-list">
                        <li> <a type="button" href="{{route('user')}}" class="btn btn-primary text-white   btn-rounded "> View Users<span class="legitRipple-ripple" ></span></a></li> 
                      </ul>
                    </div>
                  </div> 
            </div>
                     <div class="panel-body">
                            <div class="profile-sidebar col-md-2">
                                <!-- PORTLET MAIN -->
                                <div class="portlet light profile-sidebar-portlet bordered">
                                    <!-- SIDEBAR USERPIC -->
                                    <div class="profile-userpic">
                                    @if(!empty($user->profile_image))
                                    
                                     <img src="{{url($user->profile_image)}}" class="img-responsive" alt=""> </div>
                                    @else
                                     <img src="{{ URL::asset('assets/img/user.png')}}" class="img-responsive" alt=""> </div>
                                    @endif
                                      
                                    <!-- END SIDEBAR USERPIC -->
                                    <!-- SIDEBAR USER TITLE -->
                                    <div class="profile-usertitle">
                                        <div class="profile-usertitle-name"> {{$user->first_name}} </div>
                                        <div class="profile-usertitle-job"> {{$user->position}} </div>
                                    </div>
                                    <!-- END SIDEBAR USER TITLE -->
                                    <!-- SIDEBAR BUTTONS -->
                                    <div class="profile-userbuttons">
                                        <button type="button" class="btn btn-circle green btn-sm">Email</button>
                                        <button type="button" class="btn btn-circle red btn-sm">Message</button>
                                       
                                    </div>
                                    <!-- END SIDEBAR BUTTONS -->
                                    <!-- SIDEBAR MENU -->
                                    <div class="profile-usermenu">
                                        <ul class="nav">
                                            <li>
                                               <a href="{{url('admin/mytask/'.$user->id)}}">
                                                    <i class="icon-home"></i> Overview </a>
                                            </li>
                                            <li class="active">
                                                <a href="#">
                                                    <i class="icon-settings"></i> Account Settings </a>
                                            </li>
                                            <!-- <li>
                                                <a href="#">
                                                    <i class="icon-info"></i> Help </a>
                                            </li> -->
                                        </ul>
                                    </div>
                                    <!-- END MENU -->
                                </div>
                                <!-- END PORTLET MAIN -->
                                <!-- PORTLET MAIN -->
                                <div class="portlet light bordered">
                                    <!-- STAT -->
                                   
                                    <!-- END STAT -->
                                    <div>
                                         
                                        <span class="profile-desc-text">{{$user->about_me}}</span>
                                        <div class="margin-top-20 profile-desc-link">
                                            <i class="fa fa-phone"></i>
                                          Contact Number: {{$user->phone}}
                                        </div>
                                       <!--  <div class="margin-top-20 profile-desc-link">
                                            <i class="fa fa-twitter"></i>
                                            <a href="http://www.twitter.com/keenthemes/">@keenthemes</a>
                                        </div>
                                        <div class="margin-top-20 profile-desc-link">
                                            <i class="fa fa-facebook"></i>
                                            <a href="http://www.facebook.com/keenthemes/">keenthemes</a>
                                        </div> -->
                                    </div>
                                </div>
                                <!-- END PORTLET MAIN -->
                            </div>
                            <!-- END BEGIN PROFILE SIDEBAR -->
                            <!-- BEGIN PROFILE CONTENT -->
                            <div class="profile-content col-md-10">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="portlet light bordered">
                                            <div class="portlet-title tabbable-line">
                                                <div class="caption caption-md">
                                                    <i class="icon-globe theme-font hide"></i>
                                                    <span class="caption-subject font-blue-madison bold uppercase">Profile Account</span>
                                                </div>
                                                <ul class="nav nav-tabs">
                                                    <li class="active">
                                                        <a href="#tab_1_1" data-toggle="tab">Personal Info</a>
                                                    </li>
                                                    <li>
                                                        <a href="#tab_1_2" data-toggle="tab">Change Avatar</a>
                                                    </li>
                                                   
                                                    <!-- <li>
                                                        <a href="#tab_1_4" data-toggle="tab">  Payment Info</a>
                                                    </li> -->
                                                </ul>
                                            </div>
                                   {!! Form::model($user, ['method' => 'PATCH', 'route' => ['user.update', $user->id],'enctype'=>'multipart/form-data','class'=>
                                   'form-basic ui-formwizard user-form']) !!}
                                   <div class="portlet-body">
                                        <div class="tab-content">
                                            <!-- PERSONAL INFO TAB --> 
                                                <div class="margin-top-10">
                                                    @if (count($errors) > 0)
                                                      <div class="alert alert-danger">
                                                          <ul>
                                                              @foreach ($errors->all() as $error)
                                                                  <li>{!! $error !!}</li>
                                                              @endforeach
                                                          </ul>
                                                      </div>
                                                    @endif
                                                </div>

                                            @include('admin::users.user.personel_info', compact('user'))

                                            {!! Form::close() !!} 
                                            <!-- END PERSONAL INFO TAB --> 
                                            @include('admin::users.user.changeAvtar', compact('user'))
                                           

                                           
                                        </div>

                                    </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- END PAGE BASE CONTENT -->
                </div>
                <!-- END CONTENT BODY -->
            </div>
            
            
            <!-- END QUICK SIDEBAR -->
        </div>
        

        
@stop