<?// $isCollectableCounter++?>
@if( !isset($counter2) || $counter2 == 0)
<div>
    <div id="category-default-div" class=" hidden input-group-A">

        <div class="col-sm-12 ">
            {{--šis DIVs ir obligāts jquery elementu klonešanai--}}
            <div class="form-group">
                <div class="input-group">

                    {{--{!! Form::hidden('contact_detail['.$detail['id'].'][values_id][wwww]', null) !!}--}}
                    <div>
                        @include('contacts.fields.parentCategory', ['category'=>$topCategories])
                    </div>

                    <span class="input-group-addon remove-category-button"><i class="fa-minus"></i></span>

                </div>
            </div>
        </div>

    </div>
    <div class="FourthLevelCategoryForm hidden">
        <select class=" multi-select" multiple="multiple" name="selected_categories[]">

        </select>
    </div>
    <div class="form-group-separator hidden1"></div>
</div>

<div id="place-here-new-cat-divs" class="place-here-new-cat-divs"></div>

@endif

@foreach($categories as $category)
@if( isset($category['parent']->parentCategory->parentCategory) )
<div class="input-group-A">

    <div class="col-sm-12 ">
        <div class="input-group form-group">
            <? $index = str_random(4)?>
            {!! Form::hidden('contact_detail['.$detail['id'].'][values_id]['.$index .']', isset($value['id']) ? $value['id'] : null) !!}


            {{--@if(isset($value->parent->parent->parent))--}}
            {{--@include('contacts.fields.parentCategory', ['value'=>$value->parent->parent->parent, 'index'=>$index])--}}
            {{--@endif--}}


            {{--@if(isset($value->parent->parent))--}}
            {{--@include('contacts.fields.parentCategory', ['value'=>$value->parent->parent, 'index'=>$index])--}}
            {{--@endif--}}

            {{--{{ dd($category['parent']->parentCategory) }}--}}


            @include('contacts.fields.parentCategory', ['category'=>$category['parent']->parentCategory->parentCategory] )
            @include('contacts.fields.parentCategory', ['category'=>$category['parent']->parentCategory] )
            @include('contacts.fields.parentCategory', ['category'=>$category['parent']])
            @include('contacts.fields.parentCategory4thLevel', $category)



            {{--@if( isset($value->value) )--}}
            <span class="input-group-addon remove-category-button"><i class="fa-minus"></i></span>
            {{--@endif--}}

        </div>
    </div>
</div>
@endif


<div class="FourthLevelCategoryForm hidden">
    <select class=" multi-select" multiple="multiple" name="selected_categories[]">

    </select>
</div>
<br>
{{--&nbsp;--}}
{{--<div class="form-group-separator"></div>--}}
@endforeach


<? $categoriesNeed4thLevelSet = 1?>
<script>
    @if(isset($categoriesNeed4thLevelSet) && $categoriesNeed4thLevelSet ==1 && Route::currentRouteName() != 'contacts.index' )

    //$categgoriesNeed4thLevelSet comes from contacts\fields\category.bade.php

    {{--    $("form").submit(function (e) { --}}
            {{--e.preventDefault();--}}
        {{--var categoriesIsSet = true;--}}

        {{--$('select[name="selected_categories[]"').each(function () {--}}
            {{--console.log('$(this).val()', $(this).val());--}}
            {{--if (categoriesIsSet == false && $(this).val() != '' && $(this).val()) {--}}
                {{--categoriesIsSet = true;--}}
            {{--}--}}
            {{--console.log('categoriesIsSet', categoriesIsSet);--}}
        {{--});--}}


        {{--console.log('categoriesIsSet', categoriesIsSet);--}}

        {{--if (categoriesIsSet == false) {--}}
            {{--e.stopImmediatePropagation();--}}
            {{--alert("{{_('At least one Category of 4th level is required')}}");--}}
            {{--return false;--}}
        {{--}--}}
        {{--$("form").unbind('submit').submit();--}}
{{--    });--}}

    @endif
</script>


