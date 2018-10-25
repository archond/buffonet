{{--{{dd($value)}}--}}


{{--<div class="pull-right btn">@if(isset($value->parent)) <span class="fa-chevron-right"></span> @endif {{isset($value->translations[0]) ? $value->translations[0]->name : _('No category assigned to object')}} </div>--}}

{{--@if(isset($value->parent))--}}
{{--@include('contacts.show-category', ['value'=>$value->parent])--}}
{{--@endif--}}

{{--{{dd($categories)}}--}}

<ul>
    @foreach($categories as $category)

        <li>

            @if(isset($category['parent']->parentCategory->parentCategory->brothers))
                {{ $category['parent']->parentCategory->parentCategory->brothers->where('id', $category['parent']->parentCategory->parentCategory->id)->first()->translation->name }}
                <span class="fa fa-chevron-right "></span>
            @endif

            @if(isset($category['parent']->parentCategory->brothers))
                {{ $category['parent']->parentCategory->brothers->where('id', $category['parent']->parentCategory->id)->first()->translation->name }}
                <span class="fa fa-chevron-right "></span>
            @endif


            @if(isset($category['parent']['brothers']))
                {{ $category['parent']['brothers']->where('id', $category['parent']['id'])->first()->translation->name }}
                :
                <ul>
                    @foreach($category['brothers'] as $brother)
                        @if(in_array($brother->id, $category['selectedIds']))
                            <li style="display: inline;">{{$brother->translation->name }}</li>;
                        @endif
                    @endforeach

                </ul>
            @endif
        </li>

        {{--<li></li>--}}


    @endforeach
</ul>

