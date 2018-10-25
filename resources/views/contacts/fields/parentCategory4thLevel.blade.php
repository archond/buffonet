{{--{{var_dump($category['selectedIds'])}}--}}

<div class="FourthLevelCategoryForm fromDb">
    <select class=" multi-select"  multiple="multiple" name="selected_categories[]">
        @if(isset($category['brothers']))
        {{--<option value="">-</option>--}}
        @foreach($category['brothers'] as $option)

        <option value="{{$option->id}}"
        @if( in_array($option['id'], $category['selectedIds']) )
        selected
        @endif
        >{{$option['translation']['name']}}  </option>

        @endforeach
        @endif
    </select>
</div>


<script>
    {{--var data = "{{  implode(',', $category['selectedIds'] ) }}";--}}
    {{--var presetValArray = data.split(",");--}}

</script>

