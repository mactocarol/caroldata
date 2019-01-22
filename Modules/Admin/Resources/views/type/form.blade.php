
    <fieldset class="step ui-formwizard-content" id="step1" style="display: block;">

        <div class="row">
            <div class="col-md-12">
                <div class="form-group {{ $errors->first('name', ' has-error') }}  @if(session('field_errors')) {{ 'has-error' }} @endif">
                    <label class="control-label col-md-2">Type Name <span class="required"> * </span></label>
                    <div class="col-md-6">
                        {!! Form::text('name',null, ['class' => 'form-control','data-required'=>1,'placeholder'=>'Example : Single, Bundle, Packet'])  !!}

                        <span class="help-block" style="color:red">{{ $errors->first('name', ':message') }} @if(session('field_errors')) {{ 'The Product type already been taken!' }} @endif</span>
                    </div>
                </div>
            </div>

             <div class="col-md-12">
                <div class="form-group pull-right ">
                   {!! Form::submit(' Save ', ['class'=>'btn  btn-primary text-white']) !!}
                    <a href="{{route('product-type')}}">
                   {!! Form::button('Back', ['class'=>'btn btn-warning text-white']) !!} </a>
                </div>
            </div>

        </div>

    </fieldset >
