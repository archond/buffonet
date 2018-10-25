<?php

namespace App\Http\Controllers;

use App\Contact;
use Illuminate\Http\Request;
use Mail;

use App\Http\Requests;

class CronController extends Controller {


    function __destruct()
    {
        Mail::send('emails.system.cron-success', ['request' => []], function ($m)
        {

            $m->from(config('constants.CRON_EMAIL'), config('constants.APP_NAME'));
            $m->to(config('constants.CRON_EMAIL'), \Carbon\Carbon::now() )->subject(config('constants.APP_NAME') . ' - CRON EXECUTED ['.config('constants.APP_NAME').']');
        });
    }

    public function hourlyRun()
    {
        return $this->updateAverageRatings();
    }

    public function updateAverageRatings()
    {
        $contacts = Contact::with(['rating'=>function($q){
            $q->whereNotNull('complete_date');
        }])->get();
        $contacts->each(function($contact){
            $contact->rating_count =  $contact->rating->count();
            $contact->quality = $contact->rating->avg('quality');
            $contact->communication = $contact->rating->avg('communication');
            $contact->accurancy = $contact->rating->avg('accurancy');
            $contact->save();
        });
    }
}
