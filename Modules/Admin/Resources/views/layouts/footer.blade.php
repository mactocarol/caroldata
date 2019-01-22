
    </div>
    <!-- /page content -->

  </div>


  <!-- Core JS files -->
  <script type="text/javascript" src="{{ URL::asset('assets/js/plugins/loaders/pace.min.js')}}"></script>
  <script type="text/javascript" src="{{ URL::asset('assets/js/core/libraries/jquery.min.js')}}"></script>
  <script type="text/javascript" src="{{ URL::asset('assets/js/core/libraries/bootstrap.min.js')}}"></script>
  <script type="text/javascript" src="{{ URL::asset('assets/js/plugins/loaders/blockui.min.js')}}"></script>
  <!-- /core JS files -->

  @if(isset($js))

  <!-- Theme JS files -->
  <script type="text/javascript" src="{{ URL::asset('assets/js/plugins/forms/styling/uniform.min.js')}}"></script>
  <script type="text/javascript" src="{{ URL::asset('assets/js/plugins/notifications/pnotify.min.js')}}"></script>
  <script type="text/javascript" src="{{ URL::asset('assets/js/plugins/forms/selects/bootstrap_multiselect.js')}}"></script>

  <script type="text/javascript" src="{{ URL::asset('assets/js/core/app.js')}}"></script>
  <script type="text/javascript" src="{{ URL::asset('assets/js/pages/form_multiselect.js')}}"></script>
  <!-- /theme JS files -->


  @else

  <!-- Theme JS files -->
  <script type="text/javascript" src="{{ URL::asset('assets/js/plugins/forms/styling/uniform.min.js')}}"></script>

  <script type="text/javascript" src="{{ URL::asset('assets/js/core/app.js')}}"></script>

  <script type="text/javascript" src="{{ URL::asset('assets/js/plugins/media/fancybox.min.js')}}"></script>

  <script type="text/javascript" src="{{ URL::asset('assets/js/pages/gallery.js')}}"></script>



  <!-- Theme JS files -->
  <script type="text/javascript" src="{{ URL::asset('assets/js/core/libraries/jquery_ui/core.min.js')}}"></script>

  <script type="text/javascript" src="{{ URL::asset('assets/js/plugins/forms/selects/select2.min.js')}}"></script>

  <script type="text/javascript" src="{{ URL::asset('assets/js/plugins/notifications/sweet_alert.min.js')}}"></script>

  <script src="{{ URL::asset('assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js')}}" type="text/javascript"></script>



  <script src="{{ URL::asset('assets/global/plugins/ladda/spin.min.js')}}" type="text/javascript"></script>

  <script src="{{ URL::asset('assets/global/plugins/ladda/ladda.min.js')}}" type="text/javascript"></script>


  <script src="{{ URL::asset('assets/pages/scripts/ui-buttons.min.js')}}" type="text/javascript"></script>


 

  <!-- Theme JS files -->
  <script type="text/javascript" src="{{ URL::asset('assets/js/core/libraries/jquery_ui/interactions.min.js')}}"></script> 

  <script type="text/javascript" src="{{ URL::asset('assets/js/pages/form_select2.js')}}"></script>


  <script type="text/javascript" src="{{ URL::asset('assets/js/plugins/editors/summernote/summernote.min.js')}}"></script>

  <script type="text/javascript" src="{{ URL::asset('assets/js/pages/editor_summernote.js')}}"></script>

  <script type="text/javascript" src="{{ URL::asset('assets/js/pages/wizard_steps.js')}}"></script>
  <script type="text/javascript" src="{{ URL::asset('assets/js/plugins/forms/wizards/steps.min.js')}}"></script>


  <!-- /core JS files product page --> 

  <script type="text/javascript" src="{{ URL::asset('assets/js/core/libraries/jasny_bootstrap.min.js')}}"></script>
  <script type="text/javascript" src="{{ URL::asset('assets/js/plugins/forms/validation/validate.min.js')}}"></script>
  <script type="text/javascript" src="{{ URL::asset('assets/js/plugins/extensions/cookie.js')}}"></script>
 
  <script type="text/javascript" src="{{ URL::asset('assets/js/plugins/uploaders/fileinput/plugins/purify.min.js')}}"></script>
  <script type="text/javascript" src="{{ URL::asset('assets/js/plugins/uploaders/fileinput/plugins/sortable.min.js')}}"></script>
  <script type="text/javascript" src="{{ URL::asset('assets/js/plugins/uploaders/fileinput/fileinput.min.js')}}"></script>


  <script type="text/javascript" src="{{ URL::asset('assets/js/pages/uploader_bootstrap.js')}}"></script>

<!-- meta tag add product ---> 

  <script type="text/javascript" src="{{ URL::asset('assets/js/plugins/forms/tags/tagsinput.min.js')}}"></script>
  <script type="text/javascript" src="{{ URL::asset('assets/js/plugins/forms/tags/tokenfield.min.js')}}"></script>
  <script type="text/javascript" src="{{ URL::asset('assets/js/plugins/ui/prism.min.js')}}"></script>
  <script type="text/javascript" src="{{ URL::asset('assets/js/plugins/forms/inputs/typeahead/typeahead.bundle.min.js')}}"></script>
 
  <script type="text/javascript" src="{{ URL::asset('assets/js/pages/form_tags_input.js')}}"></script> 

<!--vendor product add js -->
  <script type="text/javascript" src="{{ URL::asset('assets/js/plugins/forms/selects/bootstrap_multiselect.js')}}"></script>
  <script type="text/javascript" src="{{ URL::asset('assets/js/pages/form_multiselect.js')}}"></script>  
  <script type="text/javascript" src="{{ URL::asset('assets/js/plugins/notifications/pnotify.min.js')}}"></script>  


@endif
  

  <!-- common js-->

   <!-- END THEME LAYOUT SCRIPTS --> 

  <script src="{{ URL::asset('assets/global/plugins/jquery-validation/js/jquery.validate.min.js')}}" type="text/javascript"></script> 
  <script src="{{ URL::asset('assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js')}}" type="text/javascript"></script> 
  <script src="{{ URL::asset('assets/js/common.js')}}" type="text/javascript"></script>
  <script src="{{ URL::asset('assets/js/bootbox.js')}}" type="text/javascript"></script>


  <script type="text/javascript">
  var url = "{{url('/')}}";
  </script> 

</html>