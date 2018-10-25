<ul id="main-menu" class="main-menu">
    <!-- add class "multiple-expanded" to allow multiple submenus to open -->
    <!-- class "auto-inherit-active-class" will automatically add "active" class for parent elements who are marked already with class "active" -->


    <?php if( Auth::check() ): ?>

        <li <?php if(Route::currentRouteName() == 'mainobjects.index'): ?> class='active' <?php endif; ?>>
            <a href="<?php echo e(URL::route('mainobjects.index')); ?>">
                <i class="fa fa-phone"></i> <span class="title"><?=_('Main Objects')?></span>
            </a>
        </li>


        <li <?php if(Route::currentRouteName() == 'contacts.index'): ?> class='active' <?php endif; ?>>
            <a href="<?php echo e(URL::route('contacts.index')); ?>">
                <i class="fa fa-book"></i> <span class="title"><?=_('Contacts')?></span>
            </a>
        </li>
        <li <?php if(Route::currentRouteName() == 'mainobjects.create'): ?> class='active' <?php endif; ?>>
            <a href="<?php echo e(URL::route('mainobjects.create')); ?>">
                <i class="fa fa-plus"></i> <span class="title"><?=_('Main object - create')?></span>
            </a>
        </li>


        <li <?php if(Route::currentRouteName() == 'categories.index'): ?> class='active' <?php endif; ?>>
            <a href="<?php echo e(URL::route('categories.index')); ?>">
                <i class="fa fa-ellipsis-v"></i> <span class="title"><?=_('Categories')?></span>
            </a>
        </li>


        <li <?php if(Route::currentRouteName() == 'countries.index'): ?> class='active' <?php endif; ?>>
            <a href="<?php echo e(URL::route('countries.index')); ?>">
                <i class="fa fa-map-o "></i> <span class="title"><?=_('Countries')?></span>
            </a>
        </li>

        <li <?php if(Route::currentRouteName() == 'cities.index'): ?> class='active' <?php endif; ?>>
            <a href="<?php echo e(URL::route('cities.index')); ?>">
                <i class="fa fa-map-signs "></i> <span class="title"><?=_('Cities')?></span>
            </a>
        </li>

        <li <?php if(Route::currentRouteName() == 'requests.index'): ?> class='active' <?php endif; ?>>
            <a href="<?php echo e(URL::route('requests.index')); ?>">
                <i class="fa fa-exchange "></i> <span class="title"><?=_('Requests')?></span>
            </a>
        </li>

        <li <?php if(Route::currentRouteName() == 'ratings.index'): ?> class='active' <?php endif; ?>>
            <a href="<?php echo e(URL::route('ratings.index')); ?>">
                <i class="fa fa-star "></i> <span class="title"><?=_('Ratings')?></span>
            </a>
        </li>

        <li <?php if(Route::currentRouteName() == 'contactdetails.index'): ?> class='active' <?php endif; ?> style="background-color:">
            <a href="<?php echo e(URL::route('contactdetails.index')); ?>">
                <i class="fa fa-object-group "></i> <span class="title"><?=_('ContactDetails')?></span>
            </a>
        </li>



    <?php /* DEVELOREP PART - starts */ ?>
        <?php if(Auth::user()->is_developer == 1): ?>
            <?php /*<hr>*/ ?>
            <li <?php if(Route::currentRouteName() == 'stages.index'): ?> class='active' <?php endif; ?> style="background-color:greenyellow">
                <a href="<?php echo e(URL::route('stages.index')); ?>">
                    <i class="fa fa-list-ul"></i> <span class="title"><?=_('Stages')?></span>
                </a>
            </li>


        <?php endif; ?>
        <?php /* DEVELOREP PART - ends */ ?>




    <?php endif; ?>


</ul>