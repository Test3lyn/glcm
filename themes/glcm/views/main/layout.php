<script type="text/javascript">
var fb_lb_url = '//www.facebook.com/plugins/likebox.php?href=https%3A%2F%2Fwww.facebook.com%2FGreatLakesCommonsMap&amp;width=404&amp;height=728&amp;show_faces=false&amp;colorscheme=light&amp;stream=true&amp;show_border=false&amp;header=false';

$(function(){
	
	// show/hide report filters and layers boxes on home page map
	$("a.toggle").toggle(
		function() { 
			$($(this).attr("href")).show();
			$(this).addClass("active-toggle");
		},
		function() { 
			$($(this).attr("href")).hide();
			$(this).removeClass("active-toggle");
		}
	);
	
});

//Dynamically create fb like box (allows for equal column heights on main page)
$(document).ready(function() {
        // Reports total column height
        var reports_col_height = $('#block-reports:first-child .content-block').height();

        // Reports block height is table height + "view more" button height (incl. padding/margins)
        var fb_height = $('#block-reports:first-child table').height() + $('.more').outerHeight(true);
        var fb_lb_url = '//www.facebook.com/plugins/likebox.php?href=https://www.facebook.com/GreatLakesCommonsMap&width=404&show_faces=false&colorscheme=light&stream=true&show_border=false&header=false&height=' + fb_height;
        
        // Set container column height
        $('#block-facebook .content-block').height(reports_col_height);
        
        // Set FB iframe height (requires new request)
        $('#block-facebook .content-block iframe').attr('src', fb_lb_url);
});
</script>
<!-- main body -->
<div id="main" class="clearingfix">
	<div id="mainmiddle">
	<div class="home-box">
		<p>Share your worry and wisdom on this map to mark and make a new story for the Great Lakes.</p><br /> 
		<p>Water is not a product or playground, but a commons. Its value is based on how well we share it as a source of life, not as a resource. The Great Lakes are not an inheritance to gamble with, but a gift we are borrowing from future generations.</p><br />
	  	<p>Each dot on this map tells a story. Add yours to multiply the bonds and power between all those who are committed to revitalizing these amazing waters. Explore the rest of this site to learn more about a Great Lakes Commons and then please share your own story when ready.</p>
	</div>
		<!-- right column -->
		<div id="report-map-filter-box" class="clearingfix">
			<a class="btn toggle" id="filter-menu-toggle" class="" href="#the-filters"><?php echo Kohana::lang('ui_main.filter_reports_by'); ?><span class="btn-icon ic-right">&raquo;</span></a>
			
			<!-- filters box -->
			<div id="the-filters" class="map-menu-box">
			
				<?php
				// Action::main_sidebar_pre_filters - Add Items to the Entry Page before filters
				Event::run('ushahidi_action.main_sidebar_pre_filters');
				?>
				
				<!-- report category filters -->
				<div id="report-category-filter">
					<h3><?php echo Kohana::lang('ui_main.category');?></h3>
			
					<ul id="category_switch" class="category-filters">
					<?php
					$color_css = 'class="swatch" style="background-color:#'.$default_map_all.'"';
					$all_cat_image = '';
					if ($default_map_all_icon != NULL)
					{
						$all_cat_image = html::image(array(
							'src'=>$default_map_all_icon,
							'style'=>'float:left;padding-right:5px;'
						));
						$color_css = '';
					}
					?>
					<li>
						<a class="active" id="cat_0" href="#">
							<span <?php echo $color_css; ?>><?php echo $all_cat_image; ?></span>
							<span class="category-title"><?php echo Kohana::lang('ui_main.all_categories');?></span>
						</a>
					</li>
					<?php
						foreach ($categories as $category => $category_info)
						{
							$category_title = htmlentities($category_info[0], ENT_QUOTES, "UTF-8");
							$category_color = $category_info[1];
							$category_image = ($category_info[2] != NULL)
							    ? url::convert_uploaded_to_abs($category_info[2])
							    : NULL;
							$category_description = htmlentities(Category_Lang_Model::category_description($category), ENT_QUOTES, "UTF-8");
	
							$color_css = 'class="swatch" style="background-color:#'.$category_color.'"';
							if ($category_info[2] != NULL)
							{
								$category_image = html::image(array(
									'src'=>$category_image,
									'style'=>'float:left;padding-right:5px;'
									));
								$color_css = '';
							}
	
							echo '<li>'
							    . '<a href="#" id="cat_'. $category .'" title="'.$category_description.'">'
							    . '<span '.$color_css.'>'.$category_image.'</span>'
							    . '<span class="category-title">'.$category_title.'</span>'
							    . '</a>';
	
							// Get Children
							echo '<div class="hide" id="child_'. $category .'">';
							if (sizeof($category_info[3]) != 0)
							{
								echo '<ul>';
								foreach ($category_info[3] as $child => $child_info)
								{
									$child_title = htmlentities($child_info[0], ENT_QUOTES, "UTF-8");
									$child_color = $child_info[1];
									$child_image = ($child_info[2] != NULL)
									    ? url::convert_uploaded_to_abs($child_info[2])
									    : NULL;
									$child_description = htmlentities(Category_Lang_Model::category_description($child), ENT_QUOTES, "UTF-8");
									
									$color_css = 'class="swatch" style="background-color:#'.$child_color.'"';
									if ($child_info[2] != NULL)
									{
										$child_image = html::image(array(
											'src' => $child_image,
											'style' => 'float:left;padding-right:5px;'
										));
	
										$color_css = '';
									}
	
									echo '<li style="padding-left:20px;">'
									    . '<a href="#" id="cat_'. $child .'" title="'.$child_description.'">'
									    . '<span '.$color_css.'>'.$child_image.'</span>'
									    . '<span class="category-title">'.$child_title.'</span>'
									    . '</a>'
									    . '</li>';
								}
								echo '</ul>';
							}
							echo '</div></li>';
						}
					?>
					</ul>
					<!-- / category filters -->

				</div>
				<!-- / report category filters -->
				
				<!-- report type filters -->
				<div id="report-type-filter" class="filters">
					<h3><?php echo Kohana::lang('ui_main.type'); ?></h3>
						<ul>
							<li><a id="media_0" class="active" href="#"><span><?php echo Kohana::lang('ui_main.reports'); ?></span></a></li>
							<li><a id="media_4" href="#"><span><?php echo Kohana::lang('ui_main.news'); ?></span></a></li>
							<li><a id="media_1" href="#"><span><?php echo Kohana::lang('ui_main.pictures'); ?></span></a></li>
							<li><a id="media_2" href="#"><span><?php echo Kohana::lang('ui_main.video'); ?></span></a></li>
							<li><a id="media_0" href="#"><span><?php echo Kohana::lang('ui_main.all'); ?></span></a></li>
						</ul>
						<div class="floatbox">
								<?php
								// Action::main_filters - Add items to the main_filters
								Event::run('ushahidi_action.map_main_filters');
								?>
							</div>
							<!-- / report type filters -->
				</div>
			
				<?php
				// Action::main_sidebar_post_filters - Add Items to the Entry Page after filters
				Event::run('ushahidi_action.main_sidebar_post_filters');
				?>
						
			</div>
			<!-- / filters box -->
			
			<?php
			if ($layers)
			{
				?>
				<div id="layers-box">
					<a class="btn toggle" id="layers-menu-toggle" class="" href="#kml_switch"><?php echo Kohana::lang('ui_main.layers');?> <span class="btn-icon ic-right">&raquo;</span></a>
					<!-- Layers (KML/KMZ) -->
					<ul id="kml_switch" class="category-filters map-menu-box">
						<?php
						foreach ($layers as $layer => $layer_info)
						{
							$layer_name = $layer_info[0];
							$layer_color = $layer_info[1];
							$layer_url = $layer_info[2];
							$layer_file = $layer_info[3];
							$layer_link = (!$layer_url) ?
								url::base().Kohana::config('upload.relative_directory').'/'.$layer_file :
								$layer_url;
							echo '<li><a href="#" id="layer_'. $layer .'">
							<span class="swatch" style="background-color:#'.$layer_color.'"></span>
							<span class="layer-name">'.$layer_name.'</span></a></li>';
						}
						?>
					</ul>
				</div>
				<!-- /Layers -->
				<?php
			}
			?>
			
			
			<?php
			if (isset($shares))
			{
				?>
				<div id="other-deployments-box">
					<a class="btn toggle" id="other-deployments-menu-toggle" class="" href="#sharing_switch"><?php echo Kohana::lang('ui_main.other_ushahidi_instances');?> <span class="btn-icon ic-right">&raquo;</span></a>
					<!-- Layers (Other Ushahidi Layers) -->
					<ul id="sharing_switch" class="category-filters map-menu-box">
						<?php
						foreach ($shares as $share => $share_info)
						{
							$sharing_name = $share_info[0];
							$sharing_color = $share_info[1];
							echo '<li><a href="#" id="share_'. $share .'"><span class="swatch" style="background-color:#'.$sharing_color.'"></span>
							<span class="category-title">'.$sharing_name.'</span></a></li>';
						}
						?>
					</ul>
				</div>
				<!-- /Layers -->
				<?php
			}
			?>
			
			
			<!-- additional content -->
			<?php
			if (Kohana::config('settings.allow_reports'))
			{
				?>
				<a class="btn toggle" id="how-to-report-menu-toggle" class="" href="#how-to-report-box"><?php echo Kohana::lang('ui_main.how_to_report'); ?> <span class="btn-icon ic-question">&raquo;</span></a>
				<div id="how-to-report-box" class="map-menu-box">
					
					<div>

						<!-- Phone -->
						<?php if (!empty($phone_array)) { ?>
						<div style="margin-bottom:10px;">
							<?php echo Kohana::lang('ui_main.report_option_1'); ?>
							<?php foreach ($phone_array as $phone) { ?>
								<strong><?php echo $phone; ?></strong>
								<?php if ($phone != end($phone_array)) { ?>
									 <br/>
								<?php } ?>
							<?php } ?>
						</div>
						<?php } ?>
						
						<!-- External Apps -->
						<?php if (count($external_apps) > 0) { ?>
						<div style="margin-bottom:10px;">
							<strong><?php echo Kohana::lang('ui_main.report_option_external_apps'); ?>:</strong><br/>
							<?php foreach ($external_apps as $app) { ?>
								<a href="<?php echo $app->url; ?>"><?php echo $app->name; ?></a><br/>
							<?php } ?>
						</div>
						<?php } ?>

						<!-- Email -->
						<?php if (!empty($report_email)) { ?>
						<div style="margin-bottom:10px;">
							<strong><?php echo Kohana::lang('ui_main.report_option_2'); ?>:</strong><br/>
							<a href="mailto:<?php echo $report_email?>"><?php echo $report_email?></a>
						</div>
						<?php } ?>

						<!-- Twitter -->
						<?php if (!empty($twitter_hashtag_array)) { ?>
						<div style="margin-bottom:10px;">
							<strong><?php echo Kohana::lang('ui_main.report_option_3'); ?>:</strong><br/>
							<?php foreach ($twitter_hashtag_array as $twitter_hashtag) { ?>
								<span>#<?php echo $twitter_hashtag; ?></span>
								<?php if ($twitter_hashtag != end($twitter_hashtag_array)) { ?>
									<br />
								<?php } ?>
							<?php } ?>
						</div>
						<?php } ?>

						<!-- Web Form -->
						<div style="margin-bottom:10px;">
							<a href="<?php echo url::site() . 'reports/submit/'; ?>"><?php echo Kohana::lang('ui_main.report_option_4'); ?></a>
						</div>

					</div>

				</div>
			<?php } ?>
			<!-- / additional content -->
		</div>
		<!-- / right column -->

		<!-- content column -->
		<div id="content" class="clearingfix">
				<?php
				// Map and Timeline Blocks
				echo $div_map;
				echo $div_timeline;
				?>
			</div>
		</div>
		<!-- / content column -->
		<div class="home-box">
			<h6>How to explore this map?</h6>
			Use the + and – buttons on the top left side of the map to zoom in and out. Use your cursor to drag the map in any direction. Click on a coloured circle to read, watch, or comment on a Report (or story). Use the ‘Filter Reports By’ menu at the top left corner of the map to only show Reports in a chosen Category. Use the ‘Layers’ menu to learn more about the Great Lakes.
		</div>
	</div>
</div>
<!-- / main body -->


<!-- content -->
<div class="content-container">

	<!-- content blocks -->
	<div class="content-blocks clearingfix">
		<ul class="content-column">
			<?php blocks::render(); ?>
		</ul>
	</div>
	<!-- /content blocks -->

</div>
<!-- content -->
