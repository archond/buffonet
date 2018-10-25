


            {{--<select name="contact_detail[{{ isset($detail['id']) ? $detail['id'] : null }}][val][{{isset($index) ? $index : 'wwww'}}]"--}}
                    {{--data-name="contact_detail[{{ isset($detail['id']) ? $detail['id'] : null }}][val][{{isset($index) ? $index : 'wwww'}}]"--}}
                    {{--class="myselect form-control" name="category_id">--}}

                {{--@if(isset($value['options']))--}}
                    {{--<option value="">-</option>--}}
                    {{--@foreach($value['options'] as $option)--}}

                        {{--<option value="{{$option->id}}"--}}
                                {{--@if(isset( $value['value']) && $option['id'] == $value['value'] )--}}
                                {{--selected--}}
                                {{--@endif--}}
                        {{-->{{$option['translation'][0]['name']}}</option>--}}
                    {{--@endforeach--}}
                {{--@endif--}}
            {{--</select>--}}

            {{--{{dd($category)}}--}}
            <select class="myselect0 form-control">

                @if(isset($category['brothers']))
                    <option value="">-</option>
                    @foreach($category['brothers'] as $option)

                        <option value="{{$option->id}}"
                                @if(isset( $category['id']) && $option['id'] == $category['id'] )
                                selected
                                @endif
                        >{{$option['translation']['name']}}</option>
                    @endforeach
                @endif
            </select>

