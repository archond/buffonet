<script>
    $(document).ready(function () {
        $('form').on('click', '.image-delete-chk', function () {
//            console.log($(this).is(":checked"));
            var element = $(this).closest('.image-container').find('.new-file-path');
            if ($(this).is(":checked")) {
                element.prop('data-value', element.val());
                element.val('');
            } else {
                element.val(element.prop('data-value'));
                element.prop('data-value', '');
            }
        });
        $('form').on('click', '.add-button', function () {
            var element = $(this).closest('.input-group');
            var currentInputType = element.find('input').not('input[type="hidden"]').attr('type');
            var newElement = element.clone();
            if (currentInputType == 'file') {

                newElement.find('input[type=file]').css('background-color', "");

            }


            if (currentInputType != 'file') {
//                console.log(element.find('input').val());
                element.find('input').val('');
                element.find('textarea').val('');
            }
            var removeButton = '<span class="input-group-addon remove-button btn-danger"><i class="fa-remove"></i></span>';
            newElement.find('.add-button').after(removeButton);
            newElement.find('.add-button').remove();
            $(newElement).insertAfter(element);
            $().insertAfter(this);
        });
        $('form').on('click', '.remove-button', function () {
            var element = $(this).closest('.input-group');
            element.find('input[type="text"]').val('');
            element.find('input[type="select"]').val('');
//            element.hide();
//            element.addClass('hidden');
            element.remove();
        });
        $(".tagsinput").tagsinput({});
    });
</script>
<script>

    $('document').ready(function () {
        @if(!isset($categories) ||  count($categories) < 1 )
        $('.add-category-button').trigger('click');
//        console.log('L', $('.add-category-button').closest('.form-group').find('.myselect-country:first') );

        @endif
    });


    $('body').on('click', '.add-category-button', function () {
        var clonedDefaultDiv = $('#category-default-div, #category-default-div ~ *').clone();

        clonedDefaultDiv[0].className = 'input-group-A';

        clonedDefaultDiv[2].className = 'form-group-separator';

        $(clonedDefaultDiv[0]).find('select').removeClass('myselect0').addClass('myselect');

//        console.warn('clonedDefaultDiv[0]', $(clonedDefaultDiv[0]).find('select'));

//        console.warn(clonedDefaultDiv);

        clonedDefaultDiv.removeAttr('id').removeClass('category-default-div');

        clonedDefaultDiv.insertAfter($(this).closest('.panel-body').find('.place-here-new-cat-divs:first'));

        clonedDefaultDiv.addClass('load2levels');
        console.warn('clonedDefaultDiv', clonedDefaultDiv);


//        clonedDefaultDiv.find('select)').removeClass('myselect0').addClass('myselect');
//        console.warn('clonedDefaultDiv', clonedDefaultDiv.find('select'));

        if (clonedDefaultDiv.find('select:eq(0)').val() != 39) {
            clonedDefaultDiv.find('select:eq(0)').val(39).trigger('change');
        } else {
            clonedDefaultDiv.find('select:eq(0)').val(39).trigger('change');
        }

    });

    $('body').on('click', '.remove-category-button', function () {
//        console.log('remove-category-button !!!');
        var first = $(this).closest('.input-group-A');
        var second = first.next();
        var third = second.next();
        first.remove();
        second.remove();
        third.remove();


    });

    //markers
    var mapDivId = 0;

    $('document').ready(function () {


        @if(!isset($contact) || !(is_object($contact) && $contact->has('addresses') )  || count($contact['addresses']) < 1 )
        setTimeout(function () {
            clickAddMarkerButton($('.add-marker-button:first').get(0));
        }, 1500);


        @endif
    });


    $('body').on('click', '.add-marker-button', function () {

        console.log('ccc1 clicked');
        console.log('ccc2', this);

        clickAddMarkerButton(this);
    });

    function clickAddMarkerButton(that) {

        console.log('ccc3', that);


        var defaultElement = $(that).closest('.marker-btn-holder').parent().find('.input-group:first');
        var defaultElementId = defaultElement.attr('id');
        var clonedDefaultDiv = defaultElement.clone();
//        clonedDefaultDiv.removeClass('hidden').removeAttr('id');
        var divsId = 'mapdDiv_' + mapDivId++;
        clonedDefaultDiv.removeClass('hidden').removeClass('default-hidden-div').attr('id', divsId);

        clonedDefaultDiv.insertAfter($(that).closest('.marker-btn-holder'));

        setMap(clonedDefaultDiv);

        clonedDefaultDiv.find('.myselect-country:first').val('{{config('constants.SELECTED_COUNTRY_ID')}}').trigger('change');


        console.log('.myselect-country:first VALUE ', clonedDefaultDiv.find('.myselect-country:first').val());

        clonedDefaultDiv.find('input[type="text"]').val("");
    }
</script>
{{--@include('categories.includes.js')--}}
<script>
    $(document).ready(function () {


        $('body').on('change', '.myselect-country', function () {

            console.log('.myselect-country CHANGE');
            var changedElement = this;
            var id = changedElement.value;
            var url = '/{{$selectedLanguage['abbr']}}/country/' + id + '/get-cities';
            $.ajax({
                method: "GET",
                dataType: "json",
                url: url,
                success: function (data) {
                    var options = '';
                    $.each(data, function (key, value) {
                        options = options + '<option value=' + value.id + '>' + value.name + '</option>';
                    });
                    options = '<option value="">-</option>' + options;
                    if (!options) {
                        return false;
                    }
                    var divOptions = options;
                    var citySelect = $(changedElement).closest('.input-group').find('.myselect-city');
//
                    citySelect.find('option').remove();
                    citySelect.append(divOptions);
                }
            });
        });


        $('body').on('change', '.myselect', function () {

            var that_obj = this;

            @if( Route::currentRouteName() != 'contact.index')
            $(this).closest('.input-group-A').next('.FourthLevelCategoryForm:first').addClass('hidden').find('option').remove();
                    @endif

            var changedElement = $(this);
            changedElement.nextUntil('span').each(function () {
                this.remove();
            });

            var id = changedElement.val();
            changedElement.attr('name', changedElement.attr('data-name'));
            doDataFieldsUpdate($(this));

            var formGroupElement = changedElement.closest('.form-group');
            var url = '/{{$selectedLanguage['abbr']}}/category/' + id + '/get-children';
            $.ajax({
                method: "GET",
                dataType: "json",
                url: url,
                success: function (data) {

//                    console.log(data);
                    var options = '';
                    $.each(data, function (key, value) {
                        options = options + '<option value=' + value.category_id + '>' + value.name + '</option>';
                    });
                    if (data.length > 0) {
                        options = '<option value="">-</option>' + options;
                    }
                    if (!options) {
                        return false;
                    }
                    var divOptions = options;

                    var countOfSelectedCats = 0;
                            @if(Route::currentRouteName() != 'contacts.index')

                    var selectedCats = $(changedElement).parent().find('.myselect');

                    var countOfSelectedCats = 0;

                    selectedCats.each(function () {
                        if ($(this).val() != '' && $(this).val()) {
                            countOfSelectedCats++;
                        }
                    });

                    console.warn('countOfSelectedCats', countOfSelectedCats);

                    if (countOfSelectedCats > 1) {
                        changedElement.closest('.load2levels').removeClass('load2levels');
                    }


                    if (countOfSelectedCats == 3) {
                        console.log('specific form!');

                        divOptions = divOptions.replace('<option value="">-</option>', '');
                        console.warn('divOptions', divOptions);

                        var multiSelectElem = $(that_obj).closest('.input-group-A').next('.FourthLevelCategoryForm:first');
                        console.warn('multiSelectElem', multiSelectElem[0]);


                        multiSelectElem.removeClass('hidden');
                        console.warn('1223', multiSelectElem.find('.multi-select')[0])

                        console.warn('banana', multiSelectElem.find('.multi-select:first'));

                        multiSelectElem.find('.multi-select:first').append(divOptions);

                        multiSelectElem.find('.multi-select:first').multiSelect('refresh');
                        multiSelectElem.find('.ms-list').perfectScrollbar();
                        console.log('abs', multiSelectElem.find('.ms-list')[0]);


                    }
                    @endif




                    if (changedElement.val() != null && changedElement.val() != '' && countOfSelectedCats < 3) {

                        newElement = changedElement.clone();
                        // console.log('New Element value : ' + newElement.find('option').first().val() );
                        newElement.attr('name', 'xxxxxx');
                        newElement.find('option').remove();
                        newElement = newElement.append(divOptions);
                        $(newElement[0]).insertAfter(changedElement);

                    }


                }, complete: function () {

                    //  izvēlamies pirmās divas kategorijas automātā
                    if ($('.load2levels:first').find('select:eq(0)').val() != {{config('constants.SELECTED_FIRST_LEVEL_CATEGORY_ID')}} ) {
                        var element = $('.load2levels:first');
//                        element.removeClass('load2levels');
                        element.find('select:eq(0)').val({{env('SELECTED_FIRST_LEVEL_CATEGORY_ID')}}).trigger('change');
//                        $('.load2levels:first').removeClass('load2levels');
                    }
                    // pārbaudam, vai otrā līmeņa kataloga izvēl ir  13 (Transports), ja nav, tad izvēlamies
                    if ($('.load2levels:first').find('select:eq(1)').val() != {{config('constants.SELECTED_SECOND_LEVEL_CATEGORY_ID')}}) {
                        var element = $('.load2levels:first');
                        element.find('select:eq(1)').val({{config('constants.SELECTED_SECOND_LEVEL_CATEGORY_ID')}}).trigger('change');
//                        element.removeClass('load2levels');
                    }
                }
            });

//            var count1 = 0;
//            var countOfMySelects = $(this).parent().find('.myselect').each(function () {
//                if ($(this).val() != '') {
//                    count1++;
//                }
//            });
//
//            if (count1 == 3) {
//                console.log('countOfMySelects', count1);
//            }
        });
        $('.input-group').each(function (key, obj) {
            var elem = $(obj).find('.myselect').last();
            if (elem.get(0)) {
                var value = elem.get(0).value;
                $(elem).val(value).trigger('change');
            }
        });
    });
    function doDataFieldsUpdate(obj) {
//        var index = Math.floor((Math.random() * 10000));
        var index = Math.floor(Math.random() * 9000) + 1000;
        obj.closest('.input-group').find('[name]').each(function () {
            if ($(this).val() != null && $(this).val() != '-' && $(this).val() != '') {
                $(this).attr('name', $(this).attr('data-name'));
                var string = $(this).attr('name');
                string = string.slice(0, -6) + '[' + index + ']';
                // console.log(string);
                $(this).attr('name', string);
            } else {
                $(this).attr('name', 'xxxxxxxxxxxx');
            }
        });
    }

    $(document).ready(function () {

        $("form").submit(function (e) {
            e.preventDefault();

            var currentForm = this;

            var pattern = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
            var counOfUnvalidEmailFields = 0;

            $(currentForm).find('input[type=email]').each(function () {
//            console.log('email', $(this).val());
                if (!$(this).val().match(pattern)) {
                    if ($(this).val() != '') {
                        counOfUnvalidEmailFields++;
                        $(this).css('border-color', 'red');
                        jump(this.id);
                    }
                }
            });


            if (counOfUnvalidEmailFields > 0) {
                e.stopImmediatePropagation();
                alert("{{_('At least one email is not valid!')}}");
                return false;
            }

            $('.default-hidden-div').remove();


            // ------------------> sākam cat4ThLevel valdiation

            var categoriesIsSet = true;
            var existCategoriesForm = false;

            $(currentForm).find('select[name="selected_categories[]"]').each(function () {
//            $('select[name="selected_categories[]"').each(function () {
                if (existCategoriesForm === false) {
                    categoriesIsSet = false;
                    existCategoriesForm = true;
                }

                console.log('$(this).val()', $(this).val());
                if (categoriesIsSet == false && $(this).val() != '' && $(this).val() && $(this).val() != []) {
                    console.log('cat comes true');
                    categoriesIsSet = true;
                }
                console.log('categoriesIsSet0', categoriesIsSet);
            });

            console.log('categoriesIsSet1', categoriesIsSet);
            console.log('existCategoriesForm', existCategoriesForm);

            if (categoriesIsSet == false) {
                e.stopImmediatePropagation();
                alert("{{_('At least one Category of 4th level is required')}}");
                return false;
            }
            // ------------------< beidzam cat4ThLevel valdiation


            // ------------------> sākam phone valdiation
            var phoneValidation = true;
            var pattern = /^$|^[0-9]{8,15}$/;

            $(currentForm).find('.phone-validation').each(function () {
                if (!$(this).val().match(pattern)) {
                    phoneValidation = false
                    $(this).css('border-color', 'red')
                    jump(this.id);
                }
            });

            if (phoneValidation === false) {
                e.stopImmediatePropagation();
                alert("{{_('At least one phone is not valid!')}}");
                return false;
            }
            // ------------------< sākam phone valdiation


//            e.stopImmediatePropagation();
//            console.log('validation is passed!');
//            return false;


            $(currentForm).unbind('submit').submit();


        });
    });

    $(document).ready(function ($) {
        $('form').on('keyup', 'input[type=email]', function () {
            $(this).css('border-color', '');
        });

        $('form').on('keyup', '.phone-validation', function () {
            $(this).css('border-color', '');
        });
    });

    function jump(h){
        var top = document.getElementById(h).offsetTop;
        window.scrollTo(0, top);
    }



    $(document).ready(function ($) {


        $(".FourthLevelCategoryForm:not(.hidden) .multi-select").multiSelect({

            afterInit: function () {
                // Add alternative scrollbar to list
                this.$selectableContainer.add(this.$selectionContainer).find('.ms-list').perfectScrollbar();
            },
            afterSelect: function () {
                // Update scrollbar size
                this.$selectableContainer.add(this.$selectionContainer).find('.ms-list').perfectScrollbar('update');

            }
        });

        $('body').on('change', '.myselect0', function () {
            $(this).parent().find('.myselect0').removeClass('myselect0').addClass('myselect');
            $(this).trigger('change');

        });


    });

    $('body').on('change', 'input[type=file]', function () {
        $(this).on("click", false);

    });


</script>