    <div class="text-center">
        <div class="icon-object border-slate-300 text-slate-300"><i class="icon-reading"></i></div>
        <h3 class="content-group">Login to your account </h3> 
        <p><small class="display-block" style="color: #8290a3; font-size: 15px"> Enter your credentials below</small> </p>
    </div>
    @if (count($errors) > 0)
    <div class="alert alert-danger">
    <button class="close" data-close="alert"></button>
    <span> 

    @foreach ($errors->all() as $error)
    {{ $error }}
    @endforeach

    </span>
    </div>
    @endif
    <div class="form-group{{ $errors->first('email', ' has-error') }}">
    <label class="control-label visible-ie8 visible-ie9"> email <span class="error">*</span></label>
    <div class="input-icon">

    {!! Form::email('email',null, ['class' => 'form-control placeholder-no-fix', 'placeholder'=>'Email' ])  !!} 
    </div>
    </div>
    <div class="form-group{{ $errors->first('password', ' has-error') }}">
    <label class="control-label visible-ie8 visible-ie9">Password</label>
    <div class="input-icon">


    {!! Form::password('password', ['class' => 'form-control placeholder-no-fix', 'placeholder'=>'Password' ])  !!} 

    </div>
    </div>
 
    <div class="form-actions">  
    <button type="submit" class="btn btn-primary uppercase">Login</button>
    <label class="rememberme check mt-checkbox mt-checkbox-outline">
    <input type="checkbox" name="remember" value="1" />Remember
    <span></span>
    </label>
    <a href="{{url('admin/forgot-password')}}" id="forget-password" class="forget-password">Forgot Password?</a>
    </div>

    <div class="create-account" style="background: #2196F3">
    <p>
    <a href="javascript:;"  class="uppercase"></a>
    </p>
    </div>