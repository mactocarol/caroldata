 
 @if($errors->any())
 <div class="row">
  <div class="col-md-10" style="margin: 0 10% 0 10%">
 <div class="alert alert-danger">
    @foreach ($errors->all() as $error)
      <li>  {{ $error }} </li>
    @endforeach
    </div>
  </div>
</div>
@endif

            <h6>Account Information</h6>
            <fieldset> 
              <div class="row">

              <div class="col-md-6">
                  <div class="form-group {{ $errors->first('first_name', ' has-error') }}  @if(session('field_errors')) {{ 'has-error' }} @endif">
                      <label class="control-label  ">First name:<span class="required"> * </span></label>
                          {!! Form::text('first_name',null, ['class' => 'form-control','data-required'=>1])  !!} 
                          <span class="help-block" style="color:red">{{ $errors->first('first_name', ':message') }} </span>
                  </div> 
              </div>

               <div class="col-md-6">
                  <div class="form-group {{ $errors->first('last_name', ' has-error') }}  @if(session('field_errors')) {{ 'has-error' }} @endif">
                      <label class="control-label  ">Last name:<span class="required"> * </span></label>
                          {!! Form::text('last_name',null, ['class' => 'form-control','data-required'=>1])  !!} 
                          <span class="help-block" style="color:red">{{ $errors->first('last_name', ':message') }} </span>
                  </div> 
              </div>

              <input type="hidden" name="role_type" value="{{$role_id}}">
              <div class="col-md-6">
                  <div class="form-group {{ $errors->first('email', ' has-error') }}  @if(session('field_errors')) {{ 'has-error' }} @endif">
                      <label class="control-label  ">Email Address:<span class="required"> * </span></label>
                          {!! Form::text('email',null, ['class' => 'form-control','data-required'=>1])  !!} 
                          <span class="help-block" style="color:red">{{ $errors->first('email', ':message') }} </span>
                  </div> 
              </div>

              <div class="col-md-6">
                  <div class="form-group {{ $errors->first('password', ' has-error') }}  @if(session('field_errors')) {{ 'has-error' }} @endif">
                      <label class="control-label  ">Password:<span class="required"> * </span></label>
                          {!! Form::password('password',['class' => 'form-control','data-required'=>1])  !!} 
                          <span class="help-block" style="color:red">{{ $errors->first('password', ':message') }} </span>
                  </div> 
              </div>


               <div class="col-md-6">
                  <div class="form-group {{ $errors->first('mobile', ' has-error') }}  @if(session('field_errors')) {{ 'has-error' }} @endif">
                      <label class="control-label  ">Mobile:<span class="required"> * </span></label>
                          {!! Form::text('mobile',null, ['class' => 'form-control','data-required'=>1])  !!} 
                          <span class="help-block" style="color:red">{{ $errors->first('mobile', ':message') }} </span>
                  </div> 
              </div>

               <div class="col-md-6">
                  <div class="form-group {{ $errors->first('phone', ' has-error') }}  @if(session('field_errors')) {{ 'has-error' }} @endif">
                      <label class="control-label  ">Phone:<span class="required"> * </span></label>
                          {!! Form::text('phone',null, ['class' => 'form-control','data-required'=>1])  !!} 
                          <span class="help-block" style="color:red">{{ $errors->first('phone', ':message') }} </span>
                  </div> 
              </div>
 
              <div class="col-md-6">
                  <div class="form-group {{ $errors->first('commission', ' has-error') }}  @if(session('field_errors')) {{ 'has-error' }} @endif">
                      <label class="control-label  ">Commision(%):<span class="required"> * </span></label>
                          {!! Form::number('commission',null, ['class' => 'form-control','data-required'=>1])  !!} 
                          <span class="help-block" style="color:red">{{ $errors->first('commission', ':message') }} </span>
                  </div> 
              </div>
 

              </div> 
  
            </fieldset>

            <h6>Shop Details</h6>
            <fieldset>
              <div class="row">
                
               <div class="col-md-6">
                  <div class="form-group {{ $errors->first('shop_name', ' has-error') }}  @if(session('field_errors')) {{ 'has-error' }} @endif">
                      <label class="control-label  ">Shop name:<span class="required"> * </span></label>
                          {!! Form::text('shop_name',null, ['class' => 'form-control','data-required'=>1])  !!} 
                          <span class="help-block" style="color:red">{{ $errors->first('shop_name', ':message') }} </span>
                  </div> 
              </div>


              <div class="col-md-6">
                  <div class="form-group {{ $errors->first('type', ' has-error') }}  @if(session('field_errors')) {{ 'has-error' }} @endif">
                      <label class="control-label  ">Shop type:<span class="required"> * </span></label>
                          {!! Form::text('type',null, ['class' => 'form-control tokenfield-primary','data-required'=>1])  !!} 
                          <span class="help-block" style="color:red">{{ $errors->first('type', ':message') }} </span>
                  </div> 
              </div>
 

              <div class="col-md-6">
                  <div class="form-group {{ $errors->first('gst', ' has-error') }}  @if(session('field_errors')) {{ 'has-error' }} @endif">
                      <label class="control-label  ">Gst Number:<span class="required"> * </span></label>
                          {!! Form::text('gst',null, ['class' => 'form-control','data-required'=>1])  !!} 
                          <span class="help-block" style="color:red">{{ $errors->first('gst', ':message') }} </span>
                  </div> 
              </div>

              <div class="col-md-6">
                  <div class="form-group {{ $errors->first('pincode', ' has-error') }}  @if(session('field_errors')) {{ 'has-error' }} @endif">
                      <label class="control-label  ">Pincode:<span class="required"> * </span></label>
                          {!! Form::text('pincode',null, ['class' => 'form-control','data-required'=>1])  !!} 
                          <span class="help-block" style="color:red">{{ $errors->first('pincode', ':message') }} </span>
                  </div> 
              </div>

              <div class="col-md-6">
                  <div class="form-group {{ $errors->first('address', ' has-error') }}  @if(session('field_errors')) {{ 'has-error' }} @endif">
                      <label class="control-label  ">Address:<span class="required"> * </span></label>
                          {!! Form::textarea('address',null, ['class' => 'form-control','data-required'=>1])  !!} 
                          <span class="help-block" style="color:red">{{ $errors->first('address', ':message') }} </span>
                  </div> 
              </div> 
            </div>
 
            </fieldset>

            <h6>Photo/Pictures</h6>
            <fieldset>
               <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label class="display-block">Shop Logo:</label>
                          <input type="file" name="logo" class="file-styled">
                          <span class="help-block" style="color:red">{{ $errors->first('logo', ':message') }} </span>
                  </div>
                </div>

                <div class="col-md-6">
                  <div class="form-group">
                    <label class="display-block">Profile Picture:</label>
                          <input type="file" name="profile_picture" class="file-styled">
                          <span class="help-block" style="color:red">{{ $errors->first('profile_picture', ':message') }} </span>
                  </div>
                </div>
 
              </div>
            </fieldset>

            <h6>Additional info</h6>
            <fieldset>
              <h1>Kyc</h1>
              <div class="row">
                
              <div class="col-md-6">
                  <div class="form-group {{ $errors->first('document_name', ' has-error') }}  @if(session('field_errors')) {{ 'has-error' }} @endif">
                      <label class="control-label  ">Adhar Card:<span class="required"> * </span></label>
                          <input type="file" name="document_name['adhar']" class="file-styled">
                          <span class="help-block" style="color:red">{{ $errors->first('document_name', ':message') }} </span>
                  </div> 
              </div>

              <div class="col-md-6">
                  <div class="form-group {{ $errors->first('document_name', ' has-error') }}  @if(session('field_errors')) {{ 'has-error' }} @endif">
                      <label class="control-label  ">Pan Card:<span class="required"> * </span></label>
                          <input type="file" name="document_name['pan']" class="file-styled">
                          <span class="help-block" style="color:red">{{ $errors->first('document_name', ':message') }} </span>
                  </div> 
              </div>

              <div class="col-md-6">
                  <div class="form-group {{ $errors->first('document_name', ' has-error') }}  @if(session('field_errors')) {{ 'has-error' }} @endif">
                      <label class="control-label  ">Voter Id:<span class="required"> * </span></label>
                          <input type="file" name="document_name['voter_id']" class="file-styled">
                          <span class="help-block" style="color:red">{{ $errors->first('document_name', ':message') }} </span>
                  </div> 
              </div>


              <div class="col-md-6">
                  <div class="form-group {{ $errors->first('document_name', ' has-error') }}  @if(session('field_errors')) {{ 'has-error' }} @endif">
                      <label class="control-label  ">License:<span class="required"> * </span></label>
                          <input type="file" name="document_name['license']" class="file-styled">
                          <span class="help-block" style="color:red">{{ $errors->first('document_name', ':message') }} </span>
                  </div> 
              </div>


              <div class="col-md-6">
                  <div class="form-group {{ $errors->first('is_verified', ' has-error') }}  @if(session('field_errors')) {{ 'has-error' }} @endif">
                      <label class="control-label  ">Verified:<span class="required"> * </span></label>
                          <select name="is_verified" class="form-control">
                            <option value="">Select</option>
                            <option value="Yes" @if(isset($vendor) && $vendor->is_verified=='Yes') selected @endif >Yes</option>
                            <option value="No" @if(isset($vendor) && $vendor->is_verified=='No') selected @endif>No</option>
                          </select>
                  </div> 
              </div>


               <div class="col-md-6">
                  <div class="form-group {{ $errors->first('status', ' has-error') }}  @if(session('field_errors')) {{ 'has-error' }} @endif">
                      <label class="control-label">Status:<span class="required"> * </span></label>
                          <select name="status" class="form-control">
                            <option value="">Select</option>
                            <option value="Approved" @if(isset($vendor) && $vendor->is_verified=='option') selected @endif >Approved</option>
                            <option value="Pending" @if(isset($vendor) && $vendor->is_verified=='Pending') selected @endif >Pending</option>
                          </select>
                  </div> 
              </div>


                <div class="col-md-6">
                  <div class="form-group {{ $errors->first('verified_by', ' has-error') }}  @if(session('field_errors')) {{ 'has-error' }} @endif">
                      <label class="control-label  ">Verified By:<span class="required"> * </span></label>
                          {!! Form::text('verified_by',null, ['class' => 'form-control','data-required'=>1])  !!} 
                          <span class="help-block" style="color:red">{{ $errors->first('verified_by', ':message') }} </span>
                  </div> 
              </div> 

              <div class="col-md-6">
                  <div class="form-group {{ $errors->first('remark', ' has-error') }}  @if(session('field_errors')) {{ 'has-error' }} @endif">
                      <label class="control-label  ">Remark:<span class="required"> * </span></label>
                          {!! Form::textarea('remark',null, ['class' => 'form-control','data-required'=>1])  !!} 
                          <span class="help-block" style="color:red">{{ $errors->first('remark', ':message') }} </span>
                  </div> 
              </div>

              

              </div> 
 
        </fieldset> 