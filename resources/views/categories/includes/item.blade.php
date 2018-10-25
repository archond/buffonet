<li>
    <div style="height: 33px " class="hoverDiv">

        @if($category['translation']['language_id'] == $selectedLanguage->id)
            {{$category['translation']['name']}}
        @endif

        <div class="pull-right">
            <a class="btn btn-success btn-xs" href="{{ route('categories.edit', $category['id']) }}"><i
                        class="fa fa-edit"></i></a>

            <div class="btn btn-red btn-xs btn-delete"
                 data-url="{{ route('category.delete', ['id'=>Crypt::encrypt($category['id'])  ] )}}"><i
                        class="fa fa-remove"></i>
            </div>
        </div>
    </div>


    <ul>

        @if(isset($category['all_children']))

            @foreach($category['all_children'] as $category)
                @include('categories.includes.item', ['categories'=>$category['children']])
            @endforeach

        @elseif(isset($category['children']))

            @foreach($category['children'] as $category)
                @include('categories.includes.item', ['categories'=>isset($category['children']) ? $category['children'] : [] ])
            @endforeach

        @endif
    </ul>
</li>