<div class="page-container" style="min-height:360px">

<!-- Page content -->
<div class="page-content">

<!-- Main sidebar -->
<div class="sidebar sidebar-main sidebar-default">
<div class="sidebar-content">
<!-- Main navigation -->
<div class="sidebar-category sidebar-category-visible">
    <div class="category-content no-padding">
        <ul class="navigation navigation-main navigation-accordion">
        <!-- Main -->
            <li class="navigation-header"><span>Main Navigation</span> <i class="icon-menu" title="" data-original-title="admin"></i></li>
            <li class="active"><a href="{{url('admin')}}" class="legitRipple"><i class="icon-home4"></i> <span>Dashboard</span></a></li> 
            

            <li class="{{($viewPage=='Users')?'active':''}}">
                <a href="#" class="has-ul legitRipple"><i class="icon-stack2"></i> <span>Manage Users</span>
                    <span class="legitRipple-ripple"></span></a>
                <ul class="hidden-ul" style="display: {{($viewPage=='Users')?'block':'none'}};">
                    <li>
                        <!-- <a href="{{route('adminUser')}}" class="legitRipple"> <span class=" icon-arrow-right13"></span> Admin Users</a></li> --> 
                    <li><a href="{{route('user')}}" class="legitRipple"><span class=" icon-arrow-right13"></span>Users</a></li> 
                     <!-- <li><a href="{{route('role')}}" class="legitRipple"><span class=" icon-arrow-right13"></span>Role & Permission</a></li> --> 
                </ul>
            </li> 

            <!-- <li class="{{($viewPage=='Vendor')?'active':''}}">
                <a href="#" class="has-ul legitRipple"><i class="icon-stack2"></i> <span>Manage Vendor </span>
                    <span class="legitRipple-ripple"></span></a>
                <ul class="hidden-ul" style="display: {{($viewPage=='Vendor')?'block':'none'}};">
                     <li><a href="{{route('vendor')}}" class="legitRipple"><span class=" icon-arrow-right13"></span> All Vendors</a></li> 
                     <li><a href="{{route('vendor.create')}}" class="legitRipple"><span class=" icon-arrow-right13"></span> Add New Vendor</a></li>
                    
                    <li><a href="{{route('vendorProduct')}}?product=existing" class="legitRipple"><span class=" icon-arrow-right13"></span> Add Vendor product</a></li>  
                </ul>
            </li> -->

            <li class="{{($viewPage=='Product')?'active':''}}">
                <a href="#" class="has-ul legitRipple"><i class="icon-stack2"></i> <span>Manage Categories </span>
                    <span class="legitRipple-ripple"></span></a>
                <ul class="hidden-ul" style="display: {{($viewPage=='Product')?'block':'none'}};">
                    <li><a href="{{route('category')}}" class="legitRipple"><span class=" icon-arrow-right13"></span>Category</a></li>  
                    <!-- <li><a href="{{route('sub-category')}}" class="legitRipple"><span class=" icon-arrow-right13"></span> Store Sub Category</a></li> -->  
                    <!-- <li><a href="{{route('product-unit')}}" class="legitRipple"><span class=" icon-arrow-right13"></span> Product Product Units</a></li>
                    <li><a href="{{route('product-type')}}" class="legitRipple"><span class=" icon-arrow-right13"></span> Store Product Types</a></li>
                    <li><a href="{{route('product')}}" class="legitRipple"><span class=" icon-arrow-right13"></span> All Store Products</a></li>
                    <li><a href="{{route('product.create')}}" class="legitRipple"><span class=" icon-arrow-right13"></span> Add Store Products</a></li> -->
                   
                </ul>

            </li>

              <li class="{{($viewPage=='Setting')?'active':''}}">
                <a href="{{route('setting')}}" class="has-ul legitRipple"><i class="icon-stack2"></i> <span>Website Settings</span>
                    <span class="legitRipple-ripple"></span></a>
                 <ul class="hidden-ul" style="display: {{($viewPage=='Setting')?'block':'none'}};">
                <li><a href="{{route('setting')}}" class="legitRipple"><span class=" icon-arrow-right13"></span> Settings</a></li>  
                </ul>
            </li> 
           
        </ul>
    </div>
</div>          
</div>
</div>
 <div class="content-wrapper">


