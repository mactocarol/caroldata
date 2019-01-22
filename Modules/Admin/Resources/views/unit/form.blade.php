
    <fieldset class="step ui-formwizard-content" id="step1" style="display: block;">

        <div class="row">
            <div class="col-md-12">
                <div class="form-group {{ $errors->first('name', ' has-error') }}  @if(session('field_errors')) {{ 'has-error' }} @endif">
                    <label class="control-label col-md-2">Unit Name <span class="required"> * </span></label>
                    <div class="col-md-6">
                        {!! Form::text('name',null, ['class' => 'form-control','data-required'=>1,'placeholder'=>'Example : Kg, Litre'])  !!}

                        <span class="help-block" style="color:red">{{ $errors->first('name', ':message') }}  </span>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="form-group {{ $errors->first('full_name', ' has-error') }}  @if(session('field_errors')) {{ 'has-error' }} @endif">
                    <label class="control-label col-md-2">Full  Name <span class="required"> * </span></label>
                    <div class="col-md-6">
                        {!! Form::text('full_name',null, ['class' => 'form-control','data-required'=>1,'placeholder'=>'Example : Full Name'])  !!}

                        <span class="help-block" style="color:red">
                            {{ $errors->first('full_name', ':message') }}   </span>
                    </div>
                </div>
            </div>

             <div class="col-md-12">
                <div class="form-group {{ $errors->first('description', ' has-error') }}  @if(session('field_errors')) {{ 'has-error' }} @endif">
                    <label class="control-label col-md-2">Description<span class="required"> * </span></label>
                    <div class="col-md-6">
                        {!! Form::textarea('description',null, ['class' => 'form-control','data-required'=>1,'placeholder'=>'Example : Description'])  !!}

                        <span class="help-block" style="color:red">{{ $errors->first('description', ':message') }} </span>
                    </div>
                </div>
            </div>

             <div class="col-md-12">
                <div class="form-group pull-right ">
                   {!! Form::submit(' Save ', ['class'=>'btn  btn-primary text-white','id'=>'saveBtn']) !!}
                    <a href="{{route('product-unit')}}">
                   {!! Form::button('Back', ['class'=>'btn btn-warning text-white']) !!} </a>
                </div>
            </div>

        </div>

    </fieldset>
