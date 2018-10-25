<?
$disabled = '';
if (isset($showAverageRating) && $showAverageRating)
{
    $quality = (int)ROUND($contact['quality']);
    $accurancy = (int)ROUND($contact['accurancy']);
    $communication = (int)ROUND($contact['communication']);
    $disabled= 'disabled';

} else{
    $quality = isset($newData['quality']) ? $newData['quality'] : '';
    $accurancy = isset($newData['accurancy']) ? $newData['accurancy'] : '';
    $communication = isset($newData['communication']) ? $newData['communication'] : '';
}


?>

@if(isset($showAverageRating) && $showAverageRating)
    <strong>{{_('Average ratings')}}</strong>
@endif

@if(!isset($showAverageRating) || !$showAverageRating)
    <div class="form-group">
        {{ Form::label('author_is_legal', _('Type'), ['class'=>'col-sm-4'] ) }}
        <div class="col-sm-8">
            {!! Form::select('author_is_legal', [''=>'-',0=>'individual', 1=>'legal'],
            isset($showRatingDataInForm ) && $showRatingDataInForm  && isset($newData['author_is_legal'])
            ? $newData['author_is_legal']
            : null
            ,  ['class'=>'form-control'] ) !!}
        </div>
    </div>
    <br>

    <div class="form-group">
        {{ Form::label('author_name', _('Name'), ['class'=>'col-sm-4'] ) }}
        <div class="col-sm-8">
            {{ Form::text('author_name',
            isset($showRatingDataInForm ) && $showRatingDataInForm  && isset($newData['author_name'])
            ? $newData['author_name']
            : null
            , ['class'=>'form-control'] )  }}
        </div>
    </div>
    <br>
    <div class="form-group">
        {{ Form::label('author_phone', _('Phone'), ['class'=>'col-sm-4'] ) }}
        <div class="col-sm-8">
            {{ Form::text('author_phone',
            isset($showRatingDataInForm ) && $showRatingDataInForm  && isset($newData['author_phone'])
            ? $newData['author_phone']
            : null
            , ['class'=>'form-control'] )  }}
        </div>
    </div>
    <br>
@endif



<div class="form-group">
    {{ Form::label('accurancy', _('Accurancy'), ['class'=>'col-sm-4'] ) }}
    <div class="col-sm-8">
        @foreach([1,2,3,4,5] as $key=> $option)
            <label class="radio-inline">
                <input type="radio" name="accurancy" value="{{$option}}" {{isset($showRatingDataInForm ) && $showRatingDataInForm  && isset($accurancy) && $option === $accurancy ? 'checked="checked"' : null}} {{$disabled}}>
                {!! $option !!}
            </label>
        @endforeach
    </div>
</div>
<br>

<div class="form-group">
    {{ Form::label('quality', _('Quality'), ['class'=>'col-sm-4'] ) }}
    <div class="col-sm-8">
        @foreach([1,2,3,4,5] as $key=> $option)
            <label class="radio-inline">
                <input type="radio" name="quality" value="{{$option}}" {{isset($showRatingDataInForm ) && $showRatingDataInForm  && isset($quality) && $option === $quality ? 'checked="checked"' : null}} {{$disabled}}>
                {!! $option !!}
            </label>
        @endforeach
    </div>
</div>
<br>
<div class="form-group">
    {{ Form::label('communication', _('Communication'), ['class'=>'col-sm-4'] ) }}
    <div class="col-sm-8">
        @foreach([1,2,3,4,5] as $key=> $option)
            <label class="radio-inline">
                <input type="radio" name="communication" value="{{$option}}" {{isset($showRatingDataInForm ) && $showRatingDataInForm  && isset($communication) && $option === $communication ? 'checked="checked"' : null}} {{$disabled}}>
                {!! $option !!}
            </label>
        @endforeach
    </div>
</div>
<br>

@if(!isset($showAverageRating) || !$showAverageRating)
    <div class="form-group">
        {{ Form::label('review', _('Review'), ['class'=>'col-sm-4'] ) }}
        <div class="col-sm-8">
            {{ Form::textarea('review',
            isset($showRatingDataInForm ) && $showRatingDataInForm  && isset($newData['review'])
            ? $newData['review']
            : null
            , ['class'=>'form-control'] )  }}
        </div>
    </div>
    <br>
@endif

