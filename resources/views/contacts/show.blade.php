@extends('layouts.app')

@section('content')


    <style>
        .left-column {
            width: 200px;
        }

        .hoverDiv:hover {
            background-color: #EEEEEE;
            overflow: hidden;
        }

    </style>

    <div class="row">
        <div class="panel panel-flat">
            <div class="panel-heading">
                {{--<div>{{$contact->name}}</div>--}}
                <div class="form-group pull-right">
                    <a class="btn btn-info pull-righ1t"
                       href="{{route('contacts.create-ask-request', $contact->id)}}">{{_('Request to update contacts info')}}</a>
                    <a class="btn btn-info pull-right1"
                       href="{{route('contacts.send-mail-create', $contact->id)}}">{{_('Send Mail to contact')}}</a>

                    <a class="btn btn-info pull-right1"
                       href="{{route('contacts.edit', $contact->id)}}">{{_('Edit to contact')}}</a>
                </div>


            </div>

            <div class="panel-body ">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        {{$contact->mainobejects->phone}}
                    </div>
                </div>
            </div>

            @if( isset($contact->mainobejects->contacts) && $contact->mainobejects->contacts->count() > 1 )

                <div class="panel-body ">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            {{_('Related objects')}}:
                            <div class="btn btn-info pull-right"
                                 id="show-hide-related-objects-btn">{{_('Show / hide related contacts')}}</div>
                        </div>
                        <div class="panel-body " id="related-objects-div">
                            <div class="form-group row">
                                <label class="col-sm-2 form-control-label">{{_('Related contacts')}}</label>
                                <div class="col-sm-10">
                                    @if( isset($contact->mainobejects->contacts) )
                                        <ul>
                                            @foreach($contact->mainobejects->contacts as $relatedContact)

                                                @if($contact->id !== $relatedContact->id)
                                                    <li>
                                                        {{--{{dd($relatedContact->contactDetailValue)}}--}}
                                                        <a href="{{route('contacts.show', $relatedContact->id) }}">
                                                            {{  isset( $relatedContact->contactDetailValue->value)
                                                 ? $relatedContact->contactDetailValue->value : _('Contact without title')}}
                                                        </a>
                                                    </li>
                                                @endif
                                            @endforeach
                                        </ul>
                                </div>
                            </div>

                            @else
                                {{_('Contact do not have any related object')}}
                            @endif
                        </div>

                    </div>
                </div>
            @endif

            <div class="panel-body ">


                @foreach($stages as $stage)
                    <div class="panel panel-default">
                        <div class="panel-heading">

                            <div>{{$stage->name}}:</div>

                            {{--{{dd($stage)}}--}}

                        </div>
                        <div class="panel-body ">

                            @foreach($stage->contactDetails as $detail)

                                <? $counter = -1?>

                                <div class="form-group row">
                                    <label class="col-sm-2 form-control-label">{{$detail->translation->name}}</label>
                                    <div class="col-sm-10">

                                        @if($detail->name =='phone')
                                            @if($detail->values && count($detail->values) ==0 )
                                                {{$contact->mainobejects->phone}}
                                            @endif

                                        @endif


                                        @if($detail->values && count($detail->values) !=0 )

                                            @foreach($detail->values as $value)


                                                <? $counter++?>

                                                @if($detail->inputField->name == 'file')

                                                    <a href="{{  route('imagecache', ['template'=>'original', 'filename'=>$value['value'] ])  }}"
                                                       data-lightbox="roadtrip">
                                                        <img src="{{  route('imagecache', ['template'=>'smallCustom', 'filename'=>$value['value'] ])  }}" style="margin:2px" >
                                                    </a>

                                                @elseif($detail->name == 'web')
                                                    <a href="{{url($value->value)}}"
                                                       target="_blank">{{$value->value}}</a>
                                                @elseif($detail->name == 'social networks')
                                                    <a href="{{$value->value}}" target="_blank">
                                                        @if(strpos($value->value, 'youtube.com') !== false)
                                                            <span class="fa fa-youtube fa-3x"></span>
                                                        @elseif(strpos($value->value, 'twitter.com') !== false)
                                                            <span class="fa fa-twitter fa-3x"></span>
                                                        @elseif(strpos($value->value, 'facebook.com') !== false)
                                                            <span class="fa fa-facebook-square fa-3x"></span>
                                                        @elseif(strpos($value->value, 'google.com') !== false)
                                                            <span class="fa fa-google-plus-square fa-3x"></span>
                                                        @elseif(strpos($value->value, 'vk.com') !== false)
                                                            <span class="fa fa-vk fa-3x"></span>

                                                        @elseif(strpos($value->value, 'linkedin.com') !== false)
                                                            <span class="fa fa-linkedin-square fa-3x"></span>

                                                        @else
                                                            {{$value->value}}
                                                        @endif
                                                    </a>
                                                @elseif($detail->model == 'Video')
                                                    {{--{{ last(explode('/',$value['value'])) }}--}}
                                                    <embed width="120" height="100"
                                                           src="http://img.youtube.com/vi/{{last(explode('/',$value['value'])) }}/0.jpg"
                                                           class="video-env"
                                                           data-src="{{$value['value']}}?version=3&enablejsapi=1&playerapiid=AIzaSyAdwo9TTBY5YyhpNGtgRVZMqryZDzMewGE"/>
                                                @elseif($detail->model == 'Category' )
                                                    @if($counter==0)
                                                        <div class="col-sm-12">
                                                            <div class="pull-left">

                                                                @include('contacts.show-category')

                                                            </div>
                                                        </div>
                                                    @endif
                                                @elseif(isset($detail->options) AND count($detail->options) !=0 )
                                                    @foreach($detail->options as $option)
                                                        {{--{{dd($value->id)}}--}}
                                                        @if($option->id == $value['value'] )
                                                            {{$option->name}}
                                                        @endif
                                                    @endforeach
                                                @elseif($detail->is_translatable)

                                                    @if($value->language_id == $selectedLanguage['id'])
                                                        {{$value->value}}
                                                    @endif

                                                @else


                                                    {{-- 36 => comments --}}
                                                    @if($value->contactdetail_id == '36')
                                                        <div class="col-sm-12" style="margin-top: 5px;">
                                                            {!! nl2br($value->value) !!}
                                                            <div style=" font-size: 10px;    position:absolute;   bottom:0; right:0;  ">
                                                                [{{\Carbon\Carbon::createFromFormat('Y-m-d H:i:s',$value->created_at)->timeZone('Europe/Riga')->format('d.m.Y H:i:s')}}
                                                                ]
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-12">
                                                            <hr>
                                                        </div>
                                                    @else

                                                        {{$value->value}}
                                                    @endif
                                                @endif
                                            @endforeach

                                        @else
                                            @if($detail->model == "Tag")
                                                @foreach( explode(',',trim($tagList[$selectedLanguage->id]) ) as $key => $tag)
                                                    @if($tag)
                                                        <div class="btn btn-info">{{$tag}}</div>
                                                    @endif
                                                @endforeach
                                            @elseif($detail->model == "Rating")

                                                <div class="row">
                                                    <div class="text-center">
                                                        @include('contacts.show-rating', ['eachRating'=>$contact, 'showDetails'=>1, 'class'=>'col-sm-12e' ])
                                                        <div class="btn btn-info pull-right"
                                                             id="show-hide-reviews-btn">{{_('Show / hide reviews')}}</div>
                                                    </div>
                                                </div>


                                                    <div class="hidden" id="review-block">
                                                    @foreach($contact['rating'] as $eachRating)
                                                        <div class="col-sm-12">

                                                            <blockquote class="blockquote blockquote-default">
                                                                <div>
                                                                    <div style="font-size: 10px"
                                                                         class="pull-right">

                                                                    {{\Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $eachRating->complete_date)->timezone('Europe/Riga')}}

                                                                    </div>
                                                                    <div class="row">
                                                                        <p>
                                                                            <strong>{{$eachRating->author_name}}</strong>
                                                                            - {{$eachRating->email}}</p>
                                                                    </div>
                                                                </div>
                                                                <p>
                                                                    <small>{{$eachRating->review}} </small>
                                                                </p>
                                                                <div style="font-size: 10px">
                                                                    <div class="row">
                                                                        @include('contacts.show-rating', ['eachRating'=>$eachRating, 'class'=>'col-sm-8 col-md-8 col-lg-4','showDetails'=>0 ])
                                                                    </div>
                                                                </div>
                                                            </blockquote>

                                                        </div>

                                                    @endforeach
                                                </div>
                                            @elseif($detail->model == "Marker")

                                                <div class="row">
                                                    <div class="text-center">
                                                        @include('contacts.index-map', ['contacts'=> [$contact], ])

                                                    </div>
                                                    <ul>
                                                        @foreach($contact['addresses'] as $address)
                                                            <li>
                                                                {{$address->marker_address}}{{$address->marker_address && $address->city->name ? ',': null}}
                                                                {{$address->city->name}}{{$address->country->name ? ',': null}}
                                                                {{$address->country->name}}{{$address->marker_zip ? ',': null}}
                                                                {{$address->marker_zip}}
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                </div>

                                            @endif
                                        @endif

                                        @if(Auth::check())
                                            <div class="row">
                                                @if($detail->name == 'comment')
                                                    @include('contacts.show-comments-form')
                                                @endif
                                            </div>
                                        @endif
                                    </div>


                                </div>




                            @endforeach

                        </div>
                    </div>

                @endforeach
            </div>


        </div>
    </div>
@stop

@section('modal')

    <!-- Gallery Modal Image -->
    <div class="modal fade" id="gallery-image-modal">
        <div class="modal-dialog">
            <div class="modal-content1">

                <div class="modal-gallery-image1">
                    <img src="" id="gallery_modal_imnage_src" class="img-responsive"/>
                </div>
                {{--<div class="modal-body">--}}
                {{--</div>--}}
                <div class="modal-footer modal-gallery-top-controls">
                    <button type="button" class="btn btn-xs btn-white" data-dismiss="modal">close</button>
                </div>
            </div>
        </div>
    </div>


    <!-- Video Modal Image -->
    <div class="modal fade" id="video-modal">
        <div class="modal-dialog">
            <div class="modal-content1">

                <div class="modal-gallery-image1">
                    {{--<embed width="500" height="350" id="video_modal_src" class="img-responsive1"/>--}}
                    <iframe width="560" height="560" id="video_modal_src" class="img-responsive1"
                            frameborder="0"
                            allowfullscreen="true"></iframe>
                </div>
                {{--<div class="modal-body">--}}
                {{--</div>--}}
                <div class="modal-footer modal-gallery-top-controls">
                    <button type="button" class="btn btn-xs btn-white close-btn" data-dismiss="modal">close
                    </button>
                </div>
            </div>
        </div>
    </div>


    <script>
        $(document).ready(function ($) {
            // Gallery Modal
            $('.gallery-env').on('click', function (ev) {
                ev.preventDefault();
                var pictureUrlSmall = $(this).attr('src');
                var pictureUrlMedium = pictureUrlSmall.replace('/smallCustom/', '/original/');
                $('#gallery_modal_imnage_src').attr('src', pictureUrlMedium);
                $("#gallery-image-modal").modal('show');
            });

            // Video Modal
            $('.video-env').on('click', function (ev) {
                ev.preventDefault();
                var videoUrl = $(this).attr('data-src');

                $('#video_modal_src').attr('src', videoUrl);
                $("#video-modal").modal('show');
            });

            $('#video-modal').on('click', '.close-btn', function () {
                $('#video_modal_src')[0].contentWindow.postMessage('{"event":"command","func":"' + 'stopVideo' + '","args":""}', '*');
            });

            $('#show-hide-reviews-btn').click(function () {
                $('#review-block').toggleClass('hidden');
            });


            $('#show-hide-related-objects-btn').click(function () {
                $('#related-objects-div').toggleClass('hidden');
            });


        });


    </script>
@stop
