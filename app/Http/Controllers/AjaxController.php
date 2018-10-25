<?php

namespace App\Http\Controllers;


use App\ContactDetailValue;
use App\Mainobject;
use App\Tag;
use Illuminate\Http\Request;

use App\Http\Requests;

class AjaxController extends Controller {

    public function getContactsEmails(Request $request)
    {


        if (!$request->has('q'))
        {
            return 'no data !';
        }


        $string = $request->get('q');

        return array_unique(ContactDetailValue::whereHas('contactDetail', function ($q) use ($string)
        {

            $q->where('value', 'LIKE', '%' . $string . '%')->where('name', 'e-mail');


        })->orderBy('value', 'asc')->get()->pluck('value')->toArray());
    }

    public function getContactsEmailsPhonesTags(Request $request){
        if (!$request->has('q'))
        {
            return 'no data !';
        }
        $string = $request->get('q');

        $mainPhonesArray = Mainobject::where('phone', 'LIKE', '%'.$string.'%')->get()->pluck('phone')->toArray();

        $emailsAndPhonesArray =  ContactDetailValue::whereHas('contactDetail', function ($q) use ($string)
        {
            $q->where('value', 'LIKE', '%' . $string . '%')->where(function($q){
                $q->where('name', 'e-mail')->orWhere('name', 'phone');
            });

        })->orderBy('value', 'asc')->get()->pluck('value')->toArray();

        $tagsArray= Tag::where('name', 'LIKE', '%'.$string.'%')->get()->pluck('name')->toArray();

        $mergedArray = array_merge($mainPhonesArray, $emailsAndPhonesArray, $tagsArray);

        asort($mergedArray);

        $mergedArray = array_values($mergedArray);

        return array_unique($mergedArray);

    }

    public function getContactsTags(Request $request){
        if (!$request->has('q'))
        {
            return 'no data !';
        }
        $string = $request->get('q');

        $tagsArray= Tag::where('name', 'LIKE', '%'.$string.'%')->get()->pluck('name')->toArray();

        asort($tagsArray);

        $tagsArray = array_values($tagsArray);

        return array_unique($tagsArray);

    }
}
