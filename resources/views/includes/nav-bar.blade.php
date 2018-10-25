<ul id="main-menu" class="main-menu">
    <!-- add class "multiple-expanded" to allow multiple submenus to open -->
    <!-- class "auto-inherit-active-class" will automatically add "active" class for parent elements who are marked already with class "active" -->


    @if( Auth::check() && Auth::user()->is_admin==1 )

        <li @if(Route::currentRouteName() == 'mainobjects.index') class='active' @endif>
            <a href="{{ URL::route('mainobjects.index') }}">
                <i class="fa fa-phone"></i> <span class="title"><?=_('Main Objects')?></span>
            </a>
        </li>


        <li @if(Route::currentRouteName() == 'contacts.index') class='active' @endif>
            <a href="{{ URL::route('contacts.index') }}">
                <i class="fa fa-book"></i> <span class="title"><?=_('Contacts')?></span>
            </a>
        </li>
        <li @if(Route::currentRouteName() == 'mainobjects.create') class='active' @endif>
            <a href="{{ URL::route('mainobjects.create') }}">
                <i class="fa fa-plus"></i> <span class="title"><?=_('Main object - create')?></span>
            </a>
        </li>


        <li @if(Route::currentRouteName() == 'categories.index') class='active' @endif>
            <a href="{{ URL::route('categories.index') }}">
                <i class="fa fa-ellipsis-v"></i> <span class="title"><?=_('Categories')?></span>
            </a>
        </li>


        <li @if(Route::currentRouteName() == 'countries.index') class='active' @endif>
            <a href="{{ URL::route('countries.index') }}">
                <i class="fa fa-map-o "></i> <span class="title"><?=_('Countries')?></span>
            </a>
        </li>

        <li @if(Route::currentRouteName() == 'cities.index') class='active' @endif>
            <a href="{{ URL::route('cities.index') }}">
                <i class="fa fa-map-signs "></i> <span class="title"><?=_('Cities')?></span>
            </a>
        </li>

        <li @if(Route::currentRouteName() == 'requests.index') class='active' @endif>
            <a href="{{ URL::route('requests.index') }}">
                <i class="fa fa-exchange "></i> <span class="title"><?=_('Requests')?></span>
            </a>
        </li>

        <li @if(Route::currentRouteName() == 'ratings.index') class='active' @endif>
            <a href="{{ URL::route('ratings.index') }}">
                <i class="fa fa-star "></i> <span class="title"><?=_('Ratings')?></span>
            </a>
        </li>

        <li @if(Route::currentRouteName() == 'contactdetails.index') class='active' @endif style="background-color:">
            <a href="{{ URL::route('contactdetails.index') }}">
                <i class="fa fa-object-group "></i> <span class="title"><?=_('ContactDetails')?></span>
            </a>
        </li>

        <li @if(Route::currentRouteName() == 'users.index') class='active' @endif style="background-color:">
            <a href="{{ URL::route('users.index') }}">
                <i class="fa fa-users "></i> <span class="title"><?=_('Users')?></span>
            </a>
        </li>



    {{-- DEVELOREP PART - starts --}}
        @if(Auth::user()->is_developer == 1)
            {{--<hr>--}}
            <li @if(Route::currentRouteName() == 'stages.index') class='active' @endif style="background-color:greenyellow">
                <a href="{{ URL::route('stages.index') }}">
                    <i class="fa fa-list-ul"></i> <span class="title"><?=_('Stages')?></span>
                </a>
            </li>


        @endif
        {{-- DEVELOREP PART - ends --}}




    @endif


</ul>