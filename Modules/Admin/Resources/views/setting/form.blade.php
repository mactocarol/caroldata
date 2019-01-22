<fieldset class="step ui-formwizard-content" id="step1" style="display: block;">
        
    <div class="row">
 
  <!--   <div class="alert alert-success display-hide">
        <button class="close" data-close="alert"></button> Your form validation is successful! </div>
-->
         @if(Session::has('flash_alert_notice'))
             <div class="alert alert-success alert-dismissable" style="margin:10px">
                <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
              <i class="icon fa fa-check"></i>  
             {{ Session::get('flash_alert_notice') }} 
             </div>
        @endif
 
        
        <div class="col-md-6"> 
            <div class="form-group {{ $errors->first('website_title', ' has-error') }}">
            <label>Website Title <span class="required"> * </span></label>
                {!! Form::text('website_title',null, ['class' => 'form-control','data-required'=>1])  !!} 
                
                <span class="help-block">{{ $errors->first('website_title', ':message') }}</span> 

            </div>
        </div> 

        <div class="col-md-6"> 
        <div class="form-group {{ $errors->first('website_url', ' has-error') }}">
            <label >Website Url <span class="required"> * </span></label>
            
                {!! Form::text('website_url',url('/'), ['class' => 'form-control','data-required'=>1])  !!} 
                
                <span class="help-block">{{ $errors->first('website_url', ':message') }}</span>
            </div>
        </div>


        <div class="col-md-6"> 
            <div class="form-group {{ $errors->first('phone', ' has-error') }}">
            <label class="control-label col-md-3">Phone <span class="required"> * </span></label>
            
                {!! Form::text('phone',null, ['class' => 'form-control','data-required'=>1])  !!} 
                <span class="help-block">{{ $errors->first('phone', ':message') }}</span>
            </div>
        </div>

         <div class="col-md-6">
            <div class="form-group {{ $errors->first('mobile', ' has-error') }}">
            <label class="control-label col-md-3">Mobile <span class="required"> * </span></label>
            
                {!! Form::text('mobile',null, ['class' => 'form-control','data-required'=>1])  !!} 
                <span class="help-block">{{ $errors->first('mobile', ':message') }}</span>
            </div>
        </div>

       <div class="col-md-6">
         <div class="form-group {{ $errors->first('website_url', ' has-error') }}">
            <label class="control-label col-md-3">Website Email <span class="required"> * </span></label>
            
                {!! Form::text('website_email',null, ['class' => 'form-control','data-required'=>1])  !!} 
                
                <span class="help-block">{{ $errors->first('website_email', ':message') }}</span>
            </div>
        </div>

        <div class="col-md-6"> 
            <div class="form-group {{ $errors->first('meta_title', ' has-error') }}">
            <label class="control-label col-md-3">Meta Title <span class="required"> * </span></label>
            
                {!! Form::text('meta_title',null, ['class' => 'form-control','data-required'=>1])  !!} 
                
                <span class="help-block">{{ $errors->first('meta_title', ':message') }}</span>
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group {{ $errors->first('meta_key', ' has-error') }}">
            <label class="control-label col-md-3">Meta Key  </label>
            
                {!! Form::text('meta_key',null, ['class' => 'form-control','data-required'=>1])  !!} 
                
                <span class="help-block">{{ $errors->first('meta_key', ':message') }}</span>
            </div>
        </div>

        <div class="col-md-6"> 
            <div class="form-group {{ $errors->first('meta_description', ' has-error') }}">
            <label class="control-label col-md-3">Meta Description  </label>
            
                {!! Form::text('meta_description',null, ['class' => 'form-control','data-required'=>1])  !!} 
                
                <span class="help-block">{{ $errors->first('meta_description', ':message') }}</span>
            </div>
        </div> 

         <div class="col-md-6"> 
            <div class="form-group {{ $errors->first('website_logo', ' has-error') }}">
                <label class="control-label col-md-3">Website Logo  </label>
            
                  <div class="row fileupload-buttonbar">
                     <div class="col-lg-12">
                       <span class="btn btn-success fileinput-button"> 
                                            
                        <input type="file" name="website_logo" multiple=""> </span>
                     </div>
                  </div> 
             <br>
              @if(isset($setting->website_logo))
              <img src="{!! asset('storage/uploads/img/'.$setting->website_logo) !!}" width="150px">
              @endif                                   
            <span class="label label-danger">{{ $errors->first('website_logo', ':message') }}</span>
            
            </div>
        </div> 

        <div class="col-md-6">
            <div class="form-group{{ $errors->first('company_address', ' has-error') }}">
            <label class="control-label col-md-3">Company Address</label>
        
            {!! Form::textarea('company_address',null, ['class' => 'form-control' ,'data-provide'=>"markdown"])  !!}
            <span class="label label-danger">{{ $errors->first('company_address', ':message') }}</span>
            
        </div>
      </div>
 

        <div class="col-md-6"> 
            <div class="form-group{{ $errors->first('website_description', ' has-error') }}">
                <label class="control-label col-md-3">Website Description</label>
            
                {!! Form::textarea('website_description',null, ['class' => 'form-control' ,'data-provide'=>"markdown"])  !!}
                <span class="label label-danger">{{ $errors->first('website_description', ':message') }}</span>
            </div>
      </div> 
        
        
        <div class="col-md-6"> 
            <div class="form-group{{ $errors->first('google_analytics_code', ' has-error') }}">
                <label class="control-label col-md-3">Google analytics code</label>
            
                {!! Form::textarea('google_analytics_code',null, ['class' => 'form-control' ,'data-provide'=>"markdown"])  !!}
                <span class="label label-danger">{{ $errors->first('google_analytics_code', ':message') }}</span>
             
            </div>
        </div> 
 
        <div class="col-md-6"> 
            <div class="form-group {{ $errors->first('facebook_url', 'has-error') }}">
            <label class="control-label col-md-3">Facebook Url  </label>
            
                {!! Form::text('facebook_url',isset($setting->facebook_url)?$setting->facebook_url:'https://www.facebook.com/1marketresearch/', ['class' => 'form-control'])  !!} 
                
                <span class="help-block">{{ $errors->first('facebook_url', ':message') }}</span>
            </div>
        </div> 



        <div class="col-md-6"> 
            <div class="form-group {{ $errors->first('linkedin_url', 'has-error') }}">
            <label class="control-label col-md-3">Linkedin Url  </label>
            
                {!! Form::text('linkedin_url',isset($setting->linkedin_url)?$setting->linkedin_url:'https://www.linkedin.com/company/1marketresearch.com/', ['class' => 'form-control'])  !!} 
                
                <span class="help-block">{{ $errors->first('linkedin_url', ':message') }}</span>
            </div>
        </div> 

        <div class="col-md-6">
            <div class="form-group {{ $errors->first('twitter_url', 'has-error') }}">
            <label class="control-label col-md-3">Twitter Url  </label>
             
                {!! Form::text('twitter_url',isset($setting->twitter_url)?$setting->twitter_url:'https://twitter.com/1marketresearc1', ['class' => 'form-control'])  !!} 
                
                <span class="help-block">{{ $errors->first('twitter_url', ':message') }}</span>
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group {{ $errors->first('MAIL_HOST', 'has-error') }}">
            <label class="control-label col-md-3">MAIL HOST  </label>
             
                {!! Form::text('MAIL_HOST',isset($setting->MAIL_HOST)?$setting->MAIL_HOST:'', ['class' => 'form-control'])  !!} 
                
                <span class="help-block">{{ $errors->first('MAIL_HOST', ':message') }}</span>
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group {{ $errors->first('MAIL_PORT', 'has-error') }}">
            <label class="control-label col-md-3">MAIL PORT  </label>
            
                {!! Form::text('MAIL_PORT',isset($setting->MAIL_PORT)?$setting->MAIL_PORT:'587', ['class' => 'form-control'])  !!} 
                
                <span class="help-block">{{ $errors->first('MAIL_PORT', ':message') }}</span>
            </div>
        </div>


        <div class="col-md-6">
            <div class="form-group {{ $errors->first('MAIL_USERNAME', 'has-error') }}">
            <label class="control-label col-md-3">MAIL USERNAME  </label>
            
                {!! Form::text('MAIL_USERNAME',isset($setting->MAIL_USERNAME)?$setting->MAIL_USERNAME:'', ['class' => 'form-control'])  !!} 
                
                <span class="help-block">{{ $errors->first('MAIL_USERNAME', ':message') }}</span>
            </div>
        </div>


        <div class="col-md-6">
        <div class="form-group {{ $errors->first('MAIL_PASSWORD', 'has-error') }}">
            <label class="control-label col-md-3">MAIL PASSWORD  </label>
             
                {!! Form::text('MAIL_PASSWORD',isset($setting->MAIL_PASSWORD)?$setting->MAIL_PASSWORD:'', ['class' => 'form-control'])  !!} 
                
                <span class="help-block">{{ $errors->first('MAIL_PASSWORD', ':message') }}</span>
            </div>
        </div>


        <div class="col-md-6">
            <div class="form-group {{ $errors->first('MAIL_ENCRYPTION', 'has-error') }}">
            <label class="control-label col-md-3">MAIL ENCRYPTION  </label>
            
                {!! Form::text('MAIL_ENCRYPTION',isset($setting->MAIL_ENCRYPTION)?$setting->MAIL_ENCRYPTION:'tls', ['class' => 'form-control'])  !!} 
                
                <span class="help-block">{{ $errors->first('MAIL_ENCRYPTION', ':message') }}</span>
            </div>
        </div>


        <div class="col-md-6">
            <div class="form-group {{ $errors->first('MAIL_FROM', 'has-error') }}">
            <label class="control-label col-md-3">MAIL FROM  </label>
            
                {!! Form::text('MAIL_FROM',isset($setting->MAIL_FROM)?$setting->MAIL_FROM:'1marketresearch', ['class' => 'form-control'])  !!} 
                
                <span class="help-block">{{ $errors->first('MAIL_FROM', ':message') }}</span>
            </div>
        </div>


        <div  class="col-md-6">
            <div class="form-group {{ $errors->first('MAIL_TO', 'has-error') }}">
            <label class="control-label col-md-3">MAIL TO  </label>
            
                {!! Form::text('MAIL_TO',isset($setting->MAIL_TO)?$setting->MAIL_TO:'admin@1marketresearch.com', ['class' => 'form-control'])  !!} 
                
                <span class="help-block">{{ $errors->first('MAIL_TO', ':message') }}</span>
            </div>
        </div> 
        <div class="col-md-12">
            <div class="form-group pull-right {{ $errors->first('MAIL_TO', 'has-error') }}">
             
             {!! Form::submit('Save Settings', ['class'=>'btn save btn-primary text-white','id'=>'saveBtn']) !!}
                 
            </div>
        </div>
       

    </div>
</fieldset>

 