@extends('layouts.app')

@section('content')

    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title">{{_('Compare received data with existing')}}</h3>
        </div>
    </div>

    <div class="col-sm-12">
        <div class="col-sm-6">
            {{--<div class="panel panel-default">--}}
            {{--<div class="panel-body">--}}

            {{--                    {{ Form::model('contact', ['class'=>'form-horizontal', 'method'=>'post','files'=>'true','route' => ['contacts.update', $contact->id ]]) }}--}}

            <?
            $showAverageRating = 1;
            $showRatingDataInForm = 1;
            ?>
            @include('contacts.form', ['stages'])

        </div>


        <div class="col-sm-6">

            {!! Form::open(['class'=>'form-horizontal', 'method'=>'put','files'=>'true','route' => ['requests.admin-process-save', $myRequest->id, $contact->id  ], 'novalidate' ] ) !!}


            <?
            $stages1 = $stages->each(function ($stage, $stageKey) use ($stages) {
                $stage = $stage->contactDetails->each(function ($detail, $detailKey) use ($stageKey, $stages) {

                    $detail->setAttribute('values', collect($detail->valuesUpdated));
                    return $detail;
                });

                return $stage;
            });

            $languageId = unserialize($myRequest->request_data)['language_id'];


            $stages1 = (new App\Http\Controllers\ContactController())->setTranslatableFieldsIfNotTranslations($stages1, $contactDetailValues);
            $stages1 = (new App\Http\Controllers\ContactController())->setCategoryParentCategories($stages1);

            $stages = $stages1;

//                dd($stages[5]);

//                dd($stages[0]->contactDetails[2]->values);


            $tagList = $tagListNew;

            $doNotLoadJsTwice = true;
//            $showRatingDataInForm = true;

            $categories = $categoriesNew;
            $addresses = $addressesNew;



            ?>

            {{--<pre>--}}
                {{--{{var_dump($stages)}}--}}
            {{--</pre>--}}

            {{--@include('contacts.form', ['stages', 'doNotLoadJsTwice', 'showRatingDataInForm', '$showAverageRating', 'showRatingDataInForm', 'languageId', 'categories'])--}}
            @include('contacts.form', ['stages', 'doNotLoadJsTwice', 'showRatingDataInForm','languageId', 'categories'])


            <div class="form-group col-sm-12">
                {!! Form::label('', '', ['class'=>'col-sm-2 control-label']) !!}
                <div class="col-sm-10">
                    {!! Form::submit(_('Save received data'), ['class'=>'btn'])!!}
                    <a href="{{route('requests.admin-process-reject', $myRequest->id)}}"
                       class="btn btn-red">{{_('Reject received data')}}</a>
                </div>
            </div>
            {!! Form::close() !!}

            {{--</div>--}}
            {{--</div>--}}
        </div>
    </div>

@stop