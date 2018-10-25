@foreach([_('quality'), _('accurancy'), _('communication')] as $item )
    <div class="{{isset($class) ? $class: 'pull-left'}} row">
        <div class="col-sm-6 text-right">{{$item}}:</div>
        <?
        $plusStars = isset($eachRating[$item]) ? $eachRating[$item] instanceOf stdClass ? $eachRating[$item] : $eachRating[$item] : 0;

        ?>
        <div class="col-sm-6 text-left">
            [{{ROUND($plusStars,2)}}]
            @for( $i =0; $i<(int)$plusStars; $i++)
                <i class="fa-star" style="color:yellow"></i>
            @endfor

            @for( $i =$i; $i< 5; $i++)
                <i class="fa-star-o" style="color:yellow"></i>
            @endfor

        </div>
    </div>
@endforeach

@if($showDetails ==1)

    <div class="{{isset($class) ? $class: 'pull-left'}} row">
        <div class="col-sm-6 text-right">{{_('Total raters')}}:</div>
        <div class="col-sm-6 text-left">
            ({{ $contact->rating_count ? $contact->rating_count : 0 }})
        </div>
    </div>
    <div class="{{isset($class) ? $class: 'pull-left'}} row">
        <div class="col-sm-6 text-right">{{_('Average rate')}}:</div>
        <div class="col-sm-6 text-left">
            ({{ number_format( (float)$contact->rating_overall, 2, '.', ',') }})
        </div>
    </div>

@endif

