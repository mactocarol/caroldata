<div class="tab-pane" id="tab_1_2">  
<div class="portlet light bordered">
 
 
<input type="hidden" name="tab" value="avtar">
    <div class="form-group">
         
        <div class="col-md-12">
        <div class="form-group  {{ $errors->first('profile_image', ' has-error') }}">
            <label class="control-label col-md-2"> Profile Image <span class="required"> * </span></label>
            <div class="col-lg-6">
                @if(isset($url))
                 <div class="fileinput-new thumbnail" style="width: 200px; height: 150px;">
            <img src=" {{ $url ?? 'http://www.placehold.it/200x150/EFEFEF/AAAAAA&amp;text=no+image'}}" alt=""> </div>
            @endif
                <input type="file" class="file-input" name="profile_image">
                 <span class="help-block" style="color:#e73d4a">{{ $errors->first('profile_image', ':message') }}</span>
            
            </div>
        </div>
    </div>
     <div class="col-md-12">
            <div class="margin-top-10"> 
                 <button type="submit" class="btn green btn-primary" value="avtar" name="submit"> Save Changes </button>
                <button type="submit" class="btn default "> Cancel </button>
            </div> 
           
            </div>
    </div>
          
</div>