<select name="search_value_category[1234]" data-name="search_value_category[1234]" class="myselect form-control col-sm-12" name="category_id">

    @if(isset($value['options']))
        <option value=""></option>
        @foreach($value['options'] as $option)

            <option value="{{$option->id}}"
                    @if(isset( $value['value']) && $option['id'] == $value['value'] )
                    selected
                    @endif
            >{{$option['translation']['name']}}</option>
        @endforeach
    @endif
</select>