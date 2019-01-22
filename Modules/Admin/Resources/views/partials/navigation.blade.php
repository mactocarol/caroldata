
<body class="navbar-bottom" data-gr-c-s-loaded="true">

    <div class="navbar navbar-inverse bg-indigo">
    <div class="navbar-header" style="min-width: 225px !important">
    <a class="navbar-brand" href="{{url('/')}}"><img style="height: 24px;" src="{{url('storage/uploads/img/'.$setting->website_logo)}}" alt=""></a>
    <ul class="nav navbar-nav visible-xs-block">
    <li><a data-toggle="collapse" data-target="#navbar-mobile" class="legitRipple"><i class="icon-tree5"></i></a></li>
    <li><a class="sidebar-mobile-main-toggle legitRipple"><i class="icon-paragraph-justify3"></i></a></li>
    </ul>
    </div>

    <div class="navbar-collapse collapse" id="navbar-mobile">
        <ul class="nav navbar-nav">
            <li><a class="sidebar-control sidebar-main-toggle hidden-xs legitRipple"><i class="icon-paragraph-justify3"></i></a></li>
        </ul>


    <ul class="nav navbar-nav navbar-right">
    <li class="dropdown language-switch">
    <a class="dropdown-toggle legitRipple" data-toggle="dropdown">
    


    </a></li><li class="dropdown dropdown-user"><a class="dropdown-toggle legitRipple" data-toggle="dropdown" aria-expanded="false">
    </a><a class="dropdown-toggle legitRipple" data-toggle="dropdown" aria-expanded="true">
    <img src="assets/images/placeholder.jpg" alt="">
    <span>Admin</span>
    <i class="caret"></i>
    </a>

    <ul class="dropdown-menu dropdown-menu-right">
    <li><a href="javascript::void(0)"><i class="icon-user-plus"></i> My profile</a></li> 
    <li><a href="javascript::void(0)"><i class="icon-cog5"></i> Account settings</a></li>
    <li><a href="{{url(('admin/logout'))}}"><i class="icon-switch2"></i> Logout</a></li>
    </ul>
    </li>
    </ul>
    </div>
</div>