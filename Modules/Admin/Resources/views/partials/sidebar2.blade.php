 @if(isset($submenu))

<!-- Main sidebar -->
<div class="sidebar sidebar-main sidebar-default" style="min-width: 275px">
<div class="sidebar-content">
<!-- Main navigation -->
<div class="sidebar-category sidebar-category-visible">
    <div class="category-content no-padding">
        <ul class="navigation navigation-main navigation-accordion">
        <!-- Main -->
            <li class="navigation-header"><span>{{$page_title}}</span> <i class="icon-menu" title="" data-original-title="admin"></i></li>
            
             @foreach($menus as $key => $link)
            <li class="">
                <a href="{{$link}}" class="has-ul legitRipple"><i class="icon-stack2"></i> <span>{{ucfirst($key)}}</span>
                    <span class="legitRipple-ripple"></span></a>
            </li>
            @endforeach 

            @foreach($submenu as $url => $value)
                 
                <li class="">
                    <a href="{{$url}}" class="has-ul legitRipple">  <span>
                        {{$value}} 
                    </span>
                        <span class="legitRipple-ripple"></span></a>
                     
                </li> 

            @endforeach


           <!--  <li class="">
                <a href="{{route('role')}}" class="has-ul legitRipple"><i class="icon-stack2"></i> <span>Roles</span>
                    <span class="legitRipple-ripple"></span></a>
                <ul class="hidden-ul" style="display: none;">
                <li><a href="{{route('role.create')}}" class="legitRipple">Create Role</a></li> 
                <li><a href="{{route('role')}}" class="legitRipple">View Roles</a></li> 
                </ul>
            </li>

           


             <li class="{{($viewPage=='Category')?'active':''}}">
                <a href="#" class="has-ul legitRipple"><i class="icon-stack2"></i> <span>Manage Categories</span>
                    <span class="legitRipple-ripple"></span></a>
                <ul class="hidden-ul" style="display: {{($viewPage=='Category')?'block':'none'}};">
                    <li><a href="{{route('category')}}" class="legitRipple">Category</a></li> 
                    <li><a href="{{route('sub-category')}}" class="legitRipple">Sub Category</a></li> 
                </ul>
            </li>

             <li class="">
                <a href="{{route('setting')}}" class="has-ul legitRipple"><i class="icon-stack2"></i> <span>Website Settings</span>
                    <span class="legitRipple-ripple"></span></a>
                <ul class="hidden-ul" style="display: none;">
                <li><a href="{{route('setting')}}" class="legitRipple">Settings</a></li>  
                </ul>
            </li>
 -->
           
        </ul>
    </div>
</div>
<!-- /main navigation -->               
</div>
</div>
 <div class="content-wrapper">
@endif

