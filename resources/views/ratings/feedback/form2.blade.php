<hr>
<div class="form-group">
    {!! Form::label('', _('Email'), ['class'=>'col-sm-2 control-label']) !!}
    <div class="col-sm-10 ">
        {{isset($rating->email) ? $rating->email : '-'}}
    </div>
</div>

<div class="form-group">
    {!! Form::label('', _('Sentdate'), ['class'=>'col-sm-2 control-label']) !!}
    <div class="col-sm-10 ">
        {{isset($rating->sent_date) ? $rating->sent_date : '-'}}
    </div>
</div>




<div class="form-group">
    {!! Form::label('', _('Complete date'), ['class'=>'col-sm-2 control-label']) !!}
    <div class="col-sm-10 ">
        {{isset($rating->complete_date) ? $rating->complete_date : '-'}}
    </div>
</div>

