                        <? 
                        $segments = Request::segments();
                        $currentLanguage = $segments[0];
                        ;?>


                        <li class="dropdown user-profile">
                        	<a href="#" data-toggle="dropdown">
                        		<span>
                        			{{strtoupper($currentLanguage)}}
                        			<i class="fa-angle-down"></i>
                        		</span>
                        	</a>
                        	<ul class="dropdown-menu user-profile-menu list-unstyled">




                        		@foreach($languages as $language)
                        		@if($language->abbr != $currentLanguage)
                        		<li>
                        			<?
                        			$segments[0] = $language->abbr;
                        			$url = implode('/', $segments);

                        			?>
                        			<a href="{!! url($url) !!}">
                        				<!-- <i class="fa"></i> -->
                        				{{strtoupper($language->abbr)}} 
                        			</a>
                        		</li>
                        		@endif
                        		@endforeach
                        	</ul>
                        </li>