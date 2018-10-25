


{{--{{dd($searchedCategory)}}--}}

@if( !isset($searchedCategory) || !$searchedCategory)

    {{--dd('!!!!!!!!!!!!!!');--}}

    {{--{{dd($detail->top_categories)}}--}}
    <div class="">
        {{--šis DIVs ir obligāts jquery elementu klonešanai--}}
        <div class="form-group ">
            <div class="input-group col-md-12 col-sm-12 col-xs-12">
                {{--{!! Form::hidden('contact_detail['.$detail['id'].'][values_id][eeee]', null) !!}--}}
                <div>
                    @include('contacts.search.category-parent', ['value'=>$detail->top_categories, 'index' => '1234'])
                </div>
                {{--<span class="input-group-addon remove-category-button"><i class="fa-minus"></i></span>--}}
            </div>
        </div>
    </div>

    {{---------------------}}

@else


    <?
    $index = str_random(5);
    ?>



    {{--@if(isset($searchedCategory->parent->parent->parent->parent->parent->parent->parent))--}}
    {{--@include('contacts.search.category-parent', ['value'=>$searchedCategory->parent->parent->parent->parent->parent->parent->parent, 'index'=>$index])--}}
    {{--@endif--}}

    {{--@if(isset($searchedCategory->parent->parent->parent->parent->parent->parent))--}}
    {{--@include('contacts.search.category-parent', ['value'=>$searchedCategory->parent->parent->parent->parent->parent->parent, 'index'=>$index])--}}
    {{--@endif--}}

    {{--@if(isset($searchedCategory->parent->parent->parent->parent->parent))--}}
    {{--@include('contacts.search.category-parent', ['value'=>$searchedCategory->parent->parent->parent->parent->parent, 'index'=>$index])--}}
    {{--@endif--}}

    {{----}}

    {{--@if(isset($searchedCategory->parent->parent->parent->parent))--}}
    {{--6--}}
    {{--@include('contacts.search.category-parent', ['value'=>$searchedCategory->parent->parent->parent->parent, 'index'=>$index])--}}
    {{--@endif--}}

    {{--@if(isset($searchedCategory->parent->parent->parent))--}}

    {{--5--}}
    {{--@include('contacts.search.category-parent', ['value'=>$searchedCategory->parent->parent->parent, 'index'=>$index])--}}
    {{--@endif--}}
    {{----}}

    @if(isset($searchedCategory->parent->parent))
        {{--4--}}
        @include('contacts.search.category-parent', ['value'=>$searchedCategory->parent->parent, 'index'=>$index])
    @endif

    @if(isset($searchedCategory->parent))
        {{--3--}}
        @include('contacts.search.category-parent', ['value'=>$searchedCategory->parent, 'index'=>$index])
    @endif
    {{--2--}}
    @if(isset($searchedCategory) && isset($searchedCategory->value) )
        {{--1--}}
        @include('contacts.search.category-parent', ['value'=>$searchedCategory, 'index'=>$index])
    @endif

@endif

