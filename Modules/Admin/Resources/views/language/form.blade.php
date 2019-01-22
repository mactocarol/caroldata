
    <fieldset class="step ui-formwizard-content" id="step1" style="display: block;">
        
        <div class="row">

            <div class="col-md-4">
                <div class="form-group">
                    <label>Select Language:</label>
                    <select name="location" data-placeholder="Select position" class="select">
                        <option></option>
                        <optgroup label="North America">
                            <option value="1">United States</option>
                            <option value="2">Canada</option>
                        </optgroup>

                        <optgroup label="Europe">
                            <option value="8">Croatia</option>
                            <option value="9">Hungary</option>
                            <option value="10">Ukraine</option>
                            <option value="11">Greece</option>
                            <option value="12">Norway</option>
                            <option value="13">Germany</option>
                            <option value="14">United Kingdom</option>
                        </optgroup>
                    </select>
                </div>
            </div>



            <div class="col-md-4">
                <div class="form-group">
                    <label>Make Default:</label>
                    <select name="location" data-placeholder="Select position" class="select">
                        <option></option>
                       
                            <option value="1">Default</option>
                            <option value="2">No Default</option> 
                        
                    </select>
                </div>
            </div>

             <div class="col-md-4">
                <div class="form-group">
                    <label>Make Default:</label>
                    <select name="location" data-placeholder="Select position" class="select">
                        <option></option>
                       
                            <option value="1">Default</option>
                            <option value="2">No Default</option> 
                        
                    </select>
                </div>
            </div>

 
            




             <div class="col-md-12">
                <div class="form-group {{ $errors->first('description', ' has-error') }}">
                    <label>Description: <span class="text-danger">*</span></label> 
                     {!! Form::text('description',null, ['class' => 'form-control required' ,'data-required'=>1])  !!} 
                      <span class="help-block">{{ $errors->first('description', ':message') }}</span>
                </div>
            </div>

 

             <div class="col-md-12">
                
                  <div class="form-group pull-right ">
                {!! Form::submit(' Save ', ['class'=>'btn  btn-primary text-white','id'=>'saveBtn']) !!}


                <a href="{{route('role')}}">
                    {!! Form::button('Back', ['class'=>'btn btn-warning text-white']) !!} </a>
                     </div>   
            </div> 

        </div> 
 
    </fieldset >