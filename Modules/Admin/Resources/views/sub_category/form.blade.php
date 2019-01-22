 <fieldset class="step ui-formwizard-content" id="step1" style="display: block;">
        
        <div class="row">

          
	    <div class="col-md-12"> 
            <div class="form-group {{ $errors->first('category_name', ' has-error') }}">
                 <label class="control-label col-md-2">Select  Category
                        <span class="required">  </span>
                    </label>
                <div class="col-md-6"> 
                {!!$sub_categories!!}
                    <span class="help-block">{{ $errors->first('category_name', ':message') }}</span>
                </div>
            </div> 
        </div>
        <div class="col-md-12">
            <div class="form-group {{ $errors->first('sub_category_name', ' has-error') }}
            @if(session('field_errors')) {{ 'has-error' }} @endif
            ">
                    <label class="control-label col-md-2">Sub Category Name <span class="required"> * </span></label>
                    <div class="col-md-6"> 
                        {!! Form::text('sub_category_name',null, ['class' => 'form-control','data-required'=>1])  !!} 
                        <span class="help-block">{{ $errors->first('sub_category_name', ':message') }} @if(session('field_errors')) {{ 'The Category name already been taken!' }} @endif </span>
                    </div>
                </div> 
                
        </div>

          <div class="col-md-12">
               
                <div class="form-group {{ $errors->first('commission', ' has-error') }}">
                    <label class="control-label col-md-2">Commission(%)<span class="required"> </span></label>
                       <div class="col-lg-6">
                        {!! Form::number('commission',null, ['class' => 'form-control ','data-required'=>1,'min'=>0])  !!} 
                        
                        <span class="help-block">{{ $errors->first('commission', ':message') }}</span>
                    </div>
                    </div>
              </div>

         
            
        <div class="col-md-12">
                <div class="form-group  {{ $errors->first('sub_category_image', ' has-error') }}">
                    <label class="control-label col-md-2"> Sub Category Image <span class="required"> * </span></label>
                    <div class="col-lg-6">
                        @if(isset($url))
                         <div class="fileinput-new thumbnail" style="width: 200px; height: 150px;">
                    <img src=" {{ $url ?? 'http://www.placehold.it/200x150/EFEFEF/AAAAAA&amp;text=no+image'}}" alt=""> </div>
                    @endif
                        <input type="file" class="file-input" name="sub_category_image">
                         <span class="help-block" style="color:#e73d4a">{{ $errors->first('sub_category_image', ':message') }}</span>
                    <a href="javascript:;" class="btn red fileinput-exists" data-dismiss="fileinput"> Remove </a>
                    </div>
                </div>
            </div>


        <div class="col-md-12">
            <div class="form-group {{ $errors->first('description', ' has-error') }}">
                <label class="control-label col-md-2">Description<span class="required"> </span></label>
                <div class="col-md-6"> 
                    {!! Form::textarea('description',null, ['class' => 'form-control summernote','data-required'=>1,'rows'=>3,'cols'=>5])  !!} 
                    
                    <span class="help-block">{{ $errors->first('description', ':message') }}</span>
                </div>
            </div> 
        </div>
                 
             
        <div class="col-md-8">
                  <div class="form-group pull-right ">
                {!! Form::submit(' Save ', ['class'=>'btn  btn-primary text-white','id'=>'saveBtn']) !!}

                 <a href="{{route('sub-category')}}">
            {!! Form::button('Back', ['class'=>'btn btn-warning text-white']) !!} </a>
                     </div>   
            </div> 

        </div> 
 
    </fieldset > 
 