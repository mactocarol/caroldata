<?php

namespace Modules\Admin\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

use Modules\Admin\Entities\AllLanguages; 
use Modules\Admin\Entities\Language; 
use View,Config;
use Form;

class LanguageController extends Controller
{
    
    public function __construct()
    { 
         
        View::share('viewPage', 'language'); 
        View::share('route_url', route('language'));
        View::share('heading', 'Language');

        $this->record_per_page = Config::get('app.record_per_page');
    }

    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        return view('admin::language.index');
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create(Language $language)
    {  
        $all_languages = Alllanguages::where('lang_code','!=','en')->orderBy('name')->get();
        return view('admin::language.create',compact('language','all_languages'));
    }

    /**
     * Store a newly created resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function store(Request $request)
    { 
       
         
        $language                   = new Language; 
        $language->language_id      = $request->languages;
        $language->is_default       = $request->default;
        $language->is_active        = $request->status;
 
        try
            {
                $language->save(); 
                $request->session()->flash('val', 1);
                $request->session()->flash('msg', "Language created successfully !");
                return response()->json(['status'=>true,'url'=>URL('o4k/language/'),'csrf' => csrf_token()]);
            
            }
            catch (\Exception $e)
            {
                $request->session()->flash('val', 0);
                $request->session()->flash('msg', "Language not created successfully.".$e->getMessage()); 
                return response()->json(['status'=>false,'csrf' => csrf_token()]);
       
            }
       
    }

    /**
     * Show the specified resource.
     * @return Response
     */
    public function show()
    {
        return view('admin::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @return Response
     */
    public function edit()
    {
        return view('admin::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function update(Request $request)
    {
    }

    /**
     * Remove the specified resource from storage.
     * @return Response
     */
    public function destroy()
    {
    }
}
