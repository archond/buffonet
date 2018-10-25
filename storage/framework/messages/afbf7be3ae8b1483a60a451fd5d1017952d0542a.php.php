<?php

namespace App\Http\Controllers;

use App\ContactDetailsOptionsTranslation;
use App\ContactDetailsTranslation;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\ContactDetail;
use App\Stage;
use App\ContactDetailOption;
use App\InputField;
use Crypt;

class ContactdetailController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data = $request->all();

        $contactDetails = ContactDetail::with('stage', 'values');

        if (isset($data['stage_id']) && $data['stage_id']) {
            $contactDetails = $contactDetails->where('stage_id', $data['stage_id']);
        }

        $contactDetails = $contactDetails->get();

        $stages = Stage::get();

        // return  $contactDetail; 

        return view('contactdetails.index', compact('contactDetails', 'stages'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // $contactDetail = ContactDetail::with('options')->find($id);
        $stages = Stage::get();
        $inputFields = InputField::get();


        return view('contactdetails.create', compact('stages', 'inputFields'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();

        $detail = new ContactDetail();

        $detail->stage_id = $data['stage_id'];
        $detail->input_field_id = $data['input_field_id'];
        $detail->name = $data['name'];
        $detail->save();

        $this->saveDetailTranslations($detail->id, $data);


        $this->saveDetailOptions($detail->id, $data);


        return redirect()->route('contactdetails.index')->with('success', true)->with('form_message', 'Contact detail is created successfully!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $contactDetail = ContactDetail::with('options', 'translations')->find($id);

//        return $contactDetail;
        $stages = Stage::orderBy('name', 'asc')->get();

        $inputFields = InputField::get();

//        return $contactDetail;

        return view('contactdetails.edit', compact('contactDetail', 'stages', 'inputFields'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        $data = $request->all();

        ContactDetail::find($id)->update($data);

        $this->saveDetailTranslations($id, $data);

        $this->saveDetailOptions($id, $data);

        return redirect()->route('contactdetails.index')->with('success', true)->with('form_message', 'Contact detail is updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $detail = ContactDetail::with('options')->find(Crypt::decrypt($id));
        $detail->options()->delete();
        $detail->translations()->delete();
        $detail->delete();

        return redirect()->route('contactdetails.index')->with('success', true)->with('form_message', 'Contact detail is deleted successfully!');
    }

    public function saveDetailTranslations($detailId, $data)
    {

        if (isset($data['translations'])) {
            foreach ($data['translations'] as $languageId => $translationValue) {

                $language = $this->languages->find($languageId);

                $translationModel = ContactDetailsTranslation::where('contactdetail_id', $detailId)->where('language_id', $languageId)->first();

                if (!$translationValue || $translationValue == '') {
                    $translationValue = isset($data['name']) ? $data['name'] : null;

                    $translationValue = $translationValue . ' in ' . strtoupper($language->abbr) . ' language';
                }

                if ($translationModel) {
                    $translationModel->update(['name' => $translationValue]);
                } else {
                    $array = [
                        'contactdetail_id' => $detailId,
                        'language_id' => $languageId,
                        'name' => $translationValue
                    ];
                    ContactDetailsTranslation::create($array);
                }
            }
        }
        return;
    }

    public function saveDetailOptions($id, $data){

        $existingOptions = ContactDetailOption::where('contactdetail_id', $id)->get();
        if ($existingOptions) {
            $existingOptions = $existingOptions->pluck('id', 'id');
        }

        if (isset($data['optionname'])) {
            foreach ($data['optionname'] as $detailId => $value) {
                if (is_integer($detailId)) {
                    $option = ContactDetailOption::find($detailId);
                }

                if (!isset($option) || $option == null) {
                    $option = new ContactDetailOption();
                }

                $option->name = $value;
                $option->contactdetail_id = $id;
                $option->save();

                if (isset($data['optionTranslations'][$detailId])) {
                    foreach ($data['optionTranslations'][$detailId] as $languageId => $translation){
                        $optionTranslation = ContactDetailsOptionsTranslation::where('language_id',$languageId )->where('contactdetails_option_id', $detailId)
                            ->where('contactdetails_option_id', $option->id)->first();
                        if(!$optionTranslation || !is_integer($detailId)){
                            $optionTranslation = new ContactDetailsOptionsTranslation();
                            $optionTranslation->contactdetails_option_id = $option->id;
                            $optionTranslation->language_id = $languageId;
                        }

                        if($translation == ''){
                            $languageAbbr = $this->languages->filter(function($language) use ($languageId){
                                return $language->id == $languageId;
                            })->first()->abbr;

                            $translation = $option->name.' in '.strtoupper($languageAbbr);
                        }
                        $optionTranslation->name = $translation;
                        $optionTranslation->save();
                    }
                }

                unset($option);
                unset($existingOptions[$detailId]);
            }
        }

        if ($existingOptions) {
            ContactDetailOption::whereIn('id', $existingOptions)->delete();
            ContactDetailsOptionsTranslation::whereIn('contactdetails_option_id', $existingOptions)->delete();
        }
        return;
    }
}
