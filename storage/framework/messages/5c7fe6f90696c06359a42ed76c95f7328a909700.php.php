<?php

namespace App\Http\Controllers;

use App\StageTranslation;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Stage;
use App\ContactDetail;
use App\InputField;
use Illuminate\Support\Facades\Crypt;

class StageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $stages = Stage::get();
        return view('stages.index', compact('stages'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('stages.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();
        $stage = new Stage();
        $stage = $stage->create($data);

        $this->saveDetailTranslations($stage->id, $data);

        return redirect()->route('stages.index')->with('success', true)->with('form_message', 'Stage is created successfully!');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $inputFields = InputField::get();
        // $contactdetails = ContactDetail::get();
        $stage = Stage::with(['contactdetails'=>function($q){
            $q->with('inputField')->orderBy('order', 'asc');
            // $q; 
        }])->find($id);

        // return $stage;



        return view('stages.show', compact('stage', 'inputFields'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $stage = Stage::with('contactDetails', 'translations')->find($id);
        $contactDetails = ContactDetail::get();
//        return $stage;
        return view('stages.edit', compact('stage', 'contactDetails'));  
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data = $request->all();
        $stage = Stage::find($id);
        $stage->update($data);

        $this->saveDetailTranslations($id, $data);

        return redirect()->route('stages.index')->with('success', true)->with('form_message', 'Stage is updated successfully!');
    }

    public function updateContactDetails(Request $request, $id){
        $data = $request->all();
        
        // 1 update existing
        if(isset($data['name']) ){
            foreach($data['name'] as $contactDetailId => $name){ 
                $dataArray = [
                'stage_id'=>$id,
                'name'=>$name, 
                'input_field_id'=>$data['input_field_id'][$contactDetailId], 
                'order'=>$data['order'][$contactDetailId]
                ];
                ContactDetail::find($contactDetailId)->update($dataArray); 
            }
        }
        // 2. add new
        if(isset($data['name_new']) ){
            foreach($data['name_new'] as $key => $name){
                $dataArray = [
                'stage_id'=>(int)$id, 
                'name'=>$name, 
                'input_field_id'=>$data['input_field_id_new'][$key], 
                'order'=>$data['order_new'][$key] 
                ];
                // echo '<pre>';
                // var_dump($dataArray);
                // echo '</pre>';
                ContactDetail::insert($dataArray); 
            }
        }
        return redirect()->route('stages.show', $id)->with('success', true)->with('form_message', 'Stage input fileds updated successfully!');


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        $encodedId = Crypt::decrypt($id);
        $stage = Stage::with('contactDetails', 'translations')->find($encodedId);

//        dd($stage);

//        dd($stage->contactDetails->count());

        if($stage->contactDetails->count() != 0){
            return redirect()->route('stages.index')->with('warning', true)->with('form_message', _('Stage has assigned ContactDetails, you cant delete Stage'));
        }

        $stage->translations()->delete();
        $stage->delete();

        return redirect()->route('stages.index')->with('success', true)->with('form_message', _('Stage is deleted successfully'));
    }

    public function saveDetailTranslations($id, $data)
    {

        if( isset($data['translations']) ){
            foreach($data['translations'] as $languageId => $translationValue) {

                $language = $this->languages->find($languageId);

                $translationModel = StageTranslation::where('stage_id', $id)->where('language_id', $languageId)->first();

                if(!$translationValue || $translationValue == ''){
                    $translationValue = isset($data['name']) ? $data['name'] : null;

                    $translationValue = $translationValue.' in '.strtoupper($language->abbr).' language';
                }

                if($translationModel){
                    $translationModel->update(['name'=>$translationValue]);
                } else{
                    $array = [
                        'stage_id' => $id,
                        'language_id' => $languageId,
                        'name' => $translationValue
                    ];
                    StageTranslation::create($array);
                }
            }
        }
        return;
    }
}
