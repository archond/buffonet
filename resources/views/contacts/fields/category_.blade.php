<?// $isCollectableCounter++?>
@if( !isset($counter2) || $counter2 == 0)
<div>
    <div id="category-default-div" class=" hidden input-group-A">

        <div class="col-sm-12 ">
            {{--šis DIVs ir obligāts jquery elementu klonešanai--}}
            <div class="form-group">
                <div class="input-group">

                    {!! Form::hidden('contact_detail['.$detail['id'].'][values_id][wwww]', null) !!}
                    <div>
                        @include('contacts.fields.parentCategory', ['value'=>$detail->top_categories, 'index' => 'wwww'])
                    </div>

                    <span class="input-group-addon remove-category-button"><i class="fa-minus"></i></span>

                </div>
            </div>
        </div>

    </div>
    <div class="FourthLevelCategoryForm hidden">
        <select class=" multi-select"  multiple="multiple" name="selected_categories[]">

        </select>
    </div>
    <div class="form-group-separator hidden1"></div>
</div>

<div id="place-here-new-cat-divs"></div>


{{--{{dd($detail)}}--}}
{{--pārbaudam, vai ir jau irpeikš uzstādītavismaz viena kategorija!--}}
@if(!is_object($detail['values']) || $detail['values']->count() ==0 )
{{--ja == 0, tad izvadam otreiz default categories, jo kategoriju vispār nav --}}

{{--<div class="col-sm-12 load2levels">--}}
    {{--šis DIVs ir obligāts jquery elementu klonešanai--}}
    {{--<div class="form-group">--}}
        {{--<div class="input-group">--}}
            {{--{!! Form::hidden('contact_detail['.$detail['id'].'][values_id][eeee]', null) !!}--}}
            {{--<div>--}}
                {{--@include('contacts.fields.parentCategory', ['value'=>$detail->top_categories, 'index' => 'eeee'])--}}
            {{--</div>--}}



            {{--<div  class="FourthLevelCategoryForm hidden">--}}
                {{--<select class=" multi-select" idtt="multi-select" name="selected_categories[]">--}}

                    {{--</select>--}}

            {{--</div>--}}


            {{--<span class="input-group-addon remove-category-button"><i class="fa-minus"></i></span>--}}
        {{--</div>--}}

    {{--</div>--}}

{{--</div>--}}


@endif

@endif


<div class="input-group-A">

    <div class="col-sm-12 ">
        <div class="input-group form-group">
            <? $index = str_random(4)?>
            {!! Form::hidden('contact_detail['.$detail['id'].'][values_id]['.$index .']', isset($value['id']) ? $value['id'] : null) !!}


            {{--@if(isset($value->parent->parent->parent->parent->parent->parent->parent))--}}
                {{--@include('contacts.fields.parentCategory', ['value'=>$value->parent->parent->parent->parent->parent->parent->parent, 'index'=>$index])--}}
            {{--@endif--}}

            {{--@if(isset($value->parent->parent->parent->parent->parent->parent))--}}
                {{--@include('contacts.fields.parentCategory', ['value'=>$value->parent->parent->parent->parent->parent->parent, 'index'=>$index])--}}
            {{--@endif--}}

            {{--@if(isset($value->parent->parent->parent->parent->parent))--}}
                {{--@include('contacts.fields.parentCategory', ['value'=>$value->parent->parent->parent->parent->parent, 'index'=>$index])--}}
            {{--@endif--}}

            {{----}}

            {{--@if(isset($value->parent->parent->parent->parent))--}}
                {{--@include('contacts.fields.parentCategory', ['value'=>$value->parent->parent->parent->parent, 'index'=>$index])--}}
            {{--@endif--}}



            @if(isset($value->parent->parent->parent))
                @include('contacts.fields.parentCategory', ['value'=>$value->parent->parent->parent, 'index'=>$index])
            @endif


            @if(isset($value->parent->parent))
                @include('contacts.fields.parentCategory', ['value'=>$value->parent->parent, 'index'=>$index])
            @endif

            @if(isset($value->parent))
                @include('contacts.fields.parentCategory', ['value'=>$value->parent, 'index'=>$index])
            @endif

            @if(isset($value) && isset($value->value) )

                @include('contacts.fields.parentCategory4thLevel', ['value'=>$value, 'index'=>$index])
            @endif




            {{--</div>--}}
            {{--</div>--}}

            @if( isset($value->value) )
                <span class="input-group-addon remove-category-button"><i class="fa-minus"></i></span>
            @endif

        </div>
    </div>
</div>

{{--<div id="4thLevelCategoryForm"  class="panel-body hidden">--}}
{{--<div class="form-group">--}}
{{--<div class="col-sm-12">--}}
{{--<script type="text/javascript">--}}
{{--jQuery(document).ready(function ($) {--}}
{{--$("#multi-select").multiSelect({--}}
{{--afterInit: function () {--}}
{{--// Add alternative scrollbar to list--}}
{{--this.$selectableContainer.add(this.$selectionContainer).find('.ms-list').perfectScrollbar();--}}
{{--},--}}
{{--afterSelect: function () {--}}
{{--// Update scrollbar size--}}
{{--this.$selectableContainer.add(this.$selectionContainer).find('.ms-list').perfectScrollbar('update');--}}
{{--}--}}
{{--});--}}
{{--});--}}
{{--</script>--}}
{{--<select class="form-control" multiple="multiple" id="multi-select" name="my-selected_categories[]">--}}
{{--<option value="19" selected>Healing in the Silence</option>--}}
{{--</select>--}}

{{--</div>--}}
{{--</div>--}}
{{--</div>--}}


{{--<div id="4thLevelCategoryForm" class="hidden">--}}
{{--<select class="form-control1 multi-select" multiple="multiple" id="multi-select" name="selected_categories">--}}
{{--<option value="19" selected>Healing in the Silence</option>--}}
{{--</select>--}}
{{--</div>--}}


<div class="FourthLevelCategoryForm hidden">
    <select class=" multi-select"  multiple="multiple" name="selected_categories[]">

    </select>
</div>