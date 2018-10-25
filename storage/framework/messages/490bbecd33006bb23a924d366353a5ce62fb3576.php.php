                        <? 
                        $segments = Request::segments();
                        $currentLanguage = $segments[0];
                        ;?>


                        <li class="dropdown user-profile">
                        	<a href="#" data-toggle="dropdown">
                        		<span>
                        			<?php echo e(strtoupper($currentLanguage)); ?>

                        			<i class="fa-angle-down"></i>
                        		</span>
                        	</a>
                        	<ul class="dropdown-menu user-profile-menu list-unstyled">




                        		<?php foreach($languages as $language): ?>
                        		<?php if($language->abbr != $currentLanguage): ?>
                        		<li>
                        			<?
                        			$segments[0] = $language->abbr;
                        			$url = implode('/', $segments);

                        			?>
                        			<a href="<?php echo url($url); ?>">
                        				<!-- <i class="fa"></i> -->
                        				<?php echo e(strtoupper($language->abbr)); ?> 
                        			</a>
                        		</li>
                        		<?php endif; ?>
                        		<?php endforeach; ?>
                        	</ul>
                        </li>