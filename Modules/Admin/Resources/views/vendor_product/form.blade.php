@foreach($category  as $key => $val)
    <input type="hidden" id="{{$val->id}}" value="{{$val->commission??0}}" >
@endforeach
<input type="hidden" id="charges" value="0">
<fieldset class="step ui-formwizard-content" id="step1" style="display: block; margin-left: 30px">
   

<div class="row"> 

<div class="tabbable">
        <ul class="nav nav-tabs nav-tabs-highlight">
        @if($existing_product) 
        <li class="active">
            <a href="#existing_product" data-toggle="tab" aria-expanded="true">Existing Products</a>
        </li>
        @else
        <li class="active">
            <a href="#1" data-toggle="tab" aria-expanded="true">New Product </a>
        </li> 
        <li class="">
            <a href="#2" data-toggle="tab" aria-expanded="true">Product Meta Details</a>
        </li>

        <li class="">
            <a href="#3" data-toggle="tab" aria-expanded="true">Product Images</a>
        </li>
         @endif 
        </ul>
        <div class="tab-content">

              @if(Session::has('flash_alert_notice'))
               <div class="alert alert-success alert-dismissable" style="margin:10px">
                  <button aria-hidden="true" data-dismiss="alert"  class="close" type="button">×</button>
                <i class="icon fa fa-check"></i>  
               {{ Session::get('flash_alert_notice') }} 
               </div>
            @endif
            
             @if($existing_product) 
            <div class="tab-pane active" id="existing_product">

                    <input type="hidden" name="existing_product" value="{{$existing_product??null}}">
                    <div class="col-md-8">
                        <div class="form-group {{ $errors->first('vendor', ' has-error') }}  @if(session('field_errors')) {{ 'has-error' }} @endif">
                            <label> <b>Select Vendors</b> <span class="required"> * </span></label>

                            <div class="multi-select-full  ">
                                <select class="multiselect-full-featured form-control" multiple="multiple" name="vendors[]">
                                @foreach($vendors as $key => $result)
                                    <option value="{{$result->id}}">
                                        {{ucfirst($result->vendor_name)}}
                                        -
                                        {{ucfirst($result->shop_name)}}- 
                                        {{ucfirst($result->pincode)}}
                                    </option>  
                                @endforeach
                                    
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-8">
                        <div class="form-group {{ $errors->first('products', ' has-error') }}  @if(session('field_errors')) {{ 'has-error' }} @endif">
                            <label > <b> Select Product </b><span class="required"> * </span></label>

                            <div class="multi-select-full  ">
                                <select class="multiselect-full-featured form-control" multiple="multiple" name="products[]">
                                     
                                @foreach($products as $key => $result)
                                @if($result->products->count()==0)
                                    <?php 
                                        continue;
                                     ?>
                                @endif
                                <optgroup label="{{$result->category_name}}">
                                    @foreach($result->products as $key => $product)
                                        <option value="{{$product->id}}">
                                            {{ucfirst($product->product_title)}}
                                        </option>
                                        
                                     @endforeach
                                    </optgroup>
                                @endforeach
                                    
                                </select>
                            </div>
                        </div>
                    </div> 
            </div>
            @endif
            <div class="tab-pane {{empty($existing_product)?'active':""}}" id="1"> 
                <div class="col-md-12">
                    <div class="form-group {{ $errors->first('vendor_id', ' has-error') }}  @if(session('field_errors')) {{ 'has-error' }} @endif">
                        <label class="control-label col-md-2">Select Vendors <span class="required"> * </span></label>
                          
                            <div class="col-md-6">
                               <select name="vendor_id" class="form-control" id="vendor_id" > 
 
                                @foreach($vendors as $key => $result)
                                    <option value="{{$result->id}}">
                                        {{ucfirst($result->vendor_name)}}
                                        -
                                        {{ucfirst($result->shop_name)}}- 
                                        {{ucfirst($result->pincode)}}
                                    </option>  
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <br><br>
                </div> 

                <div class="col-md-12">
                        <div class="form-group {{ $errors->first('product_title', ' has-error') }}  @if(session('field_errors')) {{ 'has-error' }} @endif">
                            <label class="control-label col-md-2">Product Title<span class="required"> * </span></label>
                            <div class="col-md-6">
                                {!! Form::text('product_title',null, ['class' => 'form-control','data-required'=>1])  !!}

                                <span class="help-block" style="color:red">{{ $errors->first('product_title', ':message') }}</span>
                            </div>
                        </div>
                </div>

                <div class="col-md-12">
                        <div class="form-group {{ $errors->first('product_category', ' has-error') }}  @if(session('field_errors')) {{ 'has-error' }} @endif">
                            <label class="control-label col-md-2">Select Category <span class="required"> * </span></label>
                            <div class="col-md-6">
                                {!! $categories !!}
                                <span class="help-block" style="color:red">{{ $errors->first('product_category', ':message') }}</span>
                            </div>
                        </div>
                    </div>

                <div class="col-md-12 commission" style="display: none">
                        <div class="form-group {{ $errors->first('commission', ' has-error') }}  @if(session('field_errors')) {{ 'has-error' }} @endif">
                            <label class="control-label col-md-2">Commission(%)<span class="required"> * </span></label>
                            <div class="col-md-6">
                                 <input type="text" disabled="" class="form-control" id="commission" value="0">

                                <span class="help-block" style="color:red">{{ $errors->first('commission', ':message') }}</span>
                            </div>
                        </div>
                </div>  

                 

                <div class="col-md-12">
                        <div class="form-group {{ $errors->first('store_price', ' has-error') }}  @if(session('field_errors')) {{ 'has-error' }} @endif">
                            <label class="control-label col-md-2">Store Price<span class="required"> * </span></label>
                            <div class="col-md-6">
                                {!! Form::text('store_price',null, ['class' => 'form-control','data-required'=>1,'id'=>'store_price'])  !!}

                                <span class="help-block" style="color:red">{{ $errors->first('store_price', ':message') }}</span>
                            </div>
                        </div>
                </div>

                 <div class="col-md-12">
                        <div class="form-group {{ $errors->first('price', ' has-error') }}  @if(session('field_errors')) {{ 'has-error' }} @endif">
                            <label class="control-label col-md-2">Product MRP<span id="mrp"></span><span class="required"> * </span></label>
                            <div class="col-md-6">
                                {!! Form::text('price',null, ['class' => 'form-control','data-required'=>1,'id'=>'price'])  !!}

                                <span class="help-block" style="color:red">{{ $errors->first('price', ':message') }}</span>
                            </div>
                        </div>
                </div>

                <div class="col-md-12">
                        <div class="form-group {{ $errors->first('discount_type', ' has-error') }}  @if(session('field_errors')) {{ 'has-error' }} @endif">
                            <label class="control-label col-md-2">Discount type<span class="required"> * </span></label>
                            <div class="col-md-6">
                               <select name="discount_type" class="form-control" id="discount_type" > 
                               	<option value="fixed">Fixed Discount</option>
                               	<option value="percentage">Percentage Discount</option>
                               </select>

                                <span class="help-block" style="color:red">{{ $errors->first('discount_type', ':message') }}</span>
                            </div>
                        </div>
                </div>

                <div class="col-md-12">
                    <div class="form-group {{ $errors->first('discount', ' has-error') }}  @if(session('field_errors')) {{ 'has-error' }} @endif">
                        <label class="control-label col-md-2">Product discount<span class="required"> * </span></label>
                        <div class="col-md-6">
                                {!! Form::text('discount',null, ['class' => 'form-control form-cascade-control input-small','min'=>0, 'id'=>'discount'])  !!}
                        <span class="help-block" style="color:red">{{ $errors->first('discount', ':message') }}</span>
                        </div>
                    </div>
                </div>


                <div class="col-md-12">
                    <div class="form-group {{ $errors->first('discount_price', ' has-error') }}  @if(session('field_errors')) {{ 'has-error' }} @endif">
                        <label class="control-label col-md-2">Discounted price<span class="required"> * </span></label>
                        <div class="col-md-6">
                            {!! Form::text('discount_price',null, ['class' => 'form-control','data-required'=>1,'id'=>'discount_price','minlength'=>1])  !!}

                            <span class="help-block" style="color:red">{{ $errors->first('discount_price', ':message') }}</span>
                        </div>
                    </div>
                </div> 
                   


                <div class="col-md-12">
                    <div class="form-group {{ $errors->first('product_type', ' has-error') }}  @if(session('field_errors')) {{ 'has-error' }} @endif">
                        <label class="control-label col-md-2">Product Type <span class="required"> * </span></label>
                        <div class="col-md-6">

                            {!! Form::select( 'product_type', $producttypes,$product->product_type,['class' => 'form-control form-cascade-control','placeholder'=>'select product packet type'])  !!}

                            <span class="help-block" style="color:red">{{ $errors->first('product_type', ':message') }}</span>
                        </div>
                    </div>
                </div>

                <div class="col-md-12">
                        <div class="form-group {{ $errors->first('unit', ' has-error') }}  @if(session('field_errors')) {{ 'has-error' }} @endif">
                            <label class="control-label col-md-2">Unit Description <span class="required"> * </span></label>
                            <div class="col-md-6">
                                {!! Form::select('unit',$productunits,$product->unit,['class' => 'form-control form-cascade-control','placeholder'=>'select product unit'])  !!}

                                <span class="help-block" style="color:red">{{ $errors->first('unit', ':message') }}</span>
                            </div>
                        </div>
                </div>


                <div class="col-md-12">
                    <div class="form-group {{ $errors->first('total_item', ' has-error') }}  @if(session('field_errors')) {{ 'has-error' }} @endif">
                        <label class="control-label col-md-2">Total Item<span class="required"> * </span></label>
                        <div class="col-md-6">
                            {!! Form::number('total_item',null, ['class' => 'form-control','data-required'=>1,'id'=>'total_item','minlength'=>1,'min'=>1])  !!}

                            <span class="help-block" style="color:red">{{ $errors->first('total_item', ':message') }}</span>
                        </div>
                    </div>
                </div> 



                <div class="col-md-12">
                        <div class="form-group {{ $errors->first('description', ' has-error') }}  @if(session('field_errors')) {{ 'has-error' }} @endif">
                            <label class="control-label col-md-2">Description <span class="required"> * </span></label>
                            <div class="col-md-6">
                                    {!! Form::textarea('description',null, ['class' => 'form-control summernote' ,'id'=>'textarea'])  !!}
                                    <span class="help-block" style="color:red">{{ $errors->first('description', ':message') }}</span>
                                    @if(Session::has('flash_alert_notice'))
                                    <span class="label label-danger">

                                        {{ Session::get('flash_alert_notice') }}
                                    </span>@endif
                            </div>
                        </div>
                </div>

                <div class="col-md-12">
                    <div class="form-group  {{ $errors->first('photo', ' has-error') }}">
                        <label class="control-label col-md-2"> Default Image <span class="required"> * </span></label>
                        <div class="col-lg-6">
                            @if(isset($product->photo))
                             <div class="fileinput-new thumbnail" style="width: 200px; height: 150px;">
                        <img src=" {{ url($product->photo) ?? 'http://www.placehold.it/200x150/EFEFEF/AAAAAA&amp;text=no+image'}}" alt=""> </div>
                        @endif
                            <input type="file" class="file-input" name="photo">
                             <span class="help-block" style="color:#e73d4a">{{ $errors->first('photo', ':message') }}</span>
                        
                        </div>
                    </div>
                </div>


                <div class="col-md-12">
                            <div class="form-group {{ $errors->first('status', ' has-error') }}  @if(session('field_errors')) {{ 'has-error' }} @endif">
                                <label class="control-label col-md-2">Status</label>
                                <div class="col-md-6">
                                        {!! Form::select('status',array('1' => 'Publish', '2' => 'Unpublish'),null,['class' => 'form-control form-cascade-control'])  !!}
                                </div>
                            </div>
                </div>  


                <div class="clearfix">&nbsp;</div>
                <div class="col-md-12">
                    <div class="form-group {{ $errors->first('total_stocks', ' has-error') }}  @if(session('field_errors')) {{ 'has-error' }} @endif">
                        <label class="control-label col-md-2">Total Stocks</label>
                        <div class="col-md-6">
                            {!! Form::text('total_stocks',null, ['class' => 'form-control'])  !!}

                            <span class="help-block" style="color:red">{{ $errors->first('total_stocks', ':message') }}</span>
                        </div>
                    </div>
                </div>


                <div class="col-md-12">
                    <div class="form-group {{ $errors->first('available_stocks', ' has-error') }}  @if(session('field_errors')) {{ 'has-error' }} @endif">
                        <label class="control-label col-md-2">Available Stocks</label>
                        <div class="col-md-6">
                            {!! Form::text('available_stocks',null, ['class' => 'form-control'])  !!}

                            <span class="help-block" style="color:red">{{ $errors->first('available_stocks', ':message') }} </span>
                        </div>
                    </div>
                </div>
        </div>
        <div class="tab-pane" id="2">

                        <div class="col-md-12">
                            <div class="form-group {{ $errors->first('meta_title', ' has-error') }}  @if(session('field_errors')) {{ 'has-error' }} @endif">
                                <label class="control-label col-md-2">Meta title</label>
                                <div class="col-md-6">
                                        {!! Form::text('meta_title',null, ['class' => 'form-control form-cascade-control input-small'])  !!}
                                        <span class="help-block" style="color:red">{{ $errors->first('meta_title', ':message') }}</span>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group {{ $errors->first('meta_key', ' has-error') }}  @if(session('field_errors')) {{ 'has-error' }} @endif">
                                <label class="control-label col-md-2">Meta Key</label>
                                <div class="col-md-6">
                                        {!! Form::text('meta_key',null, ['class' => 'form-control tokenfield-primary'])  !!}
                                        <span class="help-block" style="color:red">{{ $errors->first('meta_key', ':message') }}</span>
                                </div>
                            </div>
                        </div>


                        <div class="col-md-12">
                                &nbsp; &nbsp;
                                <div class="form-group {{ $errors->first('meta_description', ' has-error') }}  @if(session('field_errors')) {{ 'has-error' }} @endif">
                                    <label class="control-label col-md-2">Meta Description</label>
                                    <div class="col-md-6">
                                            {!! Form::textarea('meta_description',null, ['class' => 'form-control summernote'])  !!}
                                            <span class="help-block" style="color:red">{{ $errors->first('meta_description', ':message') }}</span>
                                            @if(Session::has('flash_alert_notice'))
                                            <span class="label label-danger">
                                                {{ Session::get('flash_alert_notice') }}
                                            </span>@endif
                                    </div>
                                </div>
                        </div>
        </div>


                <div class="tab-pane" id="3" style="min-height: 330px"> 

                        <div class="col-md-12" > 
                            <div class="col-md-2">
                                    <label>Product Additional Images</label>
                            </div>
                            <div class="col-md-10">
                                    @if(!empty($additional_images))
                                    @for ($i = 0; $i < count($additional_images); $i++)
                                    <input type="hidden" name="add_img[]" value="{!! $additional_images[$i] !!}">
                                    <div class="col-md-2">
                                        <div class="thumbnail">
                                        <div class="thumb">
                                        <img class="img-rounded" width="150" height="150" src="{!! url('storage/uploads/products/'.$additional_images[$i]) !!}">
                                        <div class="caption-overflow">
                                        <span>
                                        <a href="{!! url('storage/uploads/products/'.$additional_images[$i]) !!}" data-popup="lightbox" rel="gallery" class="btn border-white text-white btn-flat btn-icon btn-rounded"><i class="icon-plus3"></i></a>

                                        </span>
                                        </div>
                                        </div>
                                        </div>
                                    </div>
                                    @endfor
                                    @endif
                             </div>
                        </div>



                    <div class="col-md-12" style="margin-bottom: 0px">
                        <div class="form-group">
                                <label class="control-label col-md-2"></label>
                                <div class="col-lg-6 col-md-6">

                                            <div class="input-group control-group increment" >
                                                {!! Form::file('images[]',null,['class' => 'form-control form-cascade-control input-small','accept'=>'image/*']) !!}
                                            <br>
                                                <div class="input-group-btn">
                                                    <button class="btn btn-success" type="button"><i class="glyphicon glyphicon-plus"></i>Add</button>
                                                </div>
                                            </div>

                                            <div class="clone hide">
                                                <div class="control-group input-group" style="margin-top:10px">
                                                    {!! Form::file('images[]',null,['class' => 'form-control form-cascade-control input-small','accept'=>'image/*'])  !!}
                                                    
                                                </div>
                                            </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
        </div>

        &nbsp; &nbsp;
        <div class="col-md-8">

        <div class="form-group pull-right ">
        {!! Form::submit('Save & Continue', ['class'=>'btn  btn-primary text-white','id'=>'save_continue']) !!}
            <input type="hidden" name="btn_name" id='btn_name' value="save_continue">
           {!! Form::submit('Save & Publish ', ['class'=>'btn  btn-success text-white','id'=>'save_publish']) !!}

            <a href="{{route('product')}}">
            {!! Form::button('Back', ['class'=>'btn btn-warning text-white',]) !!} </a>
        </div>
    </div>

</div>

</fieldset >
