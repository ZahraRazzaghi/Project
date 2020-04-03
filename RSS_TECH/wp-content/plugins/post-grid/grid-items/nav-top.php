<?php
/*
* @Author 		pickplugins
* Copyright: 	2015 pickplugins.com
*/

if ( ! defined('ABSPATH')) exit;  // if direct access


	if($nav_top_filter=='yes'){
		
		$html.= '<div class="nav-filter">';
		
		
		if(!empty($categories)){

			foreach($categories as $category){
				
				$tax_cat = explode(',',$category);
				
				$categories_info[] = array($tax_cat[1],$tax_cat[0]);
				
				}
			
			$html.= '<div class="filter filter-'.$post_id.'" data-filter="all">'.__('All', post_grid_textdomain).'</div>';
		
			foreach($categories_info as $term_info)
				{
					
					$term = get_term( $term_info[0], $term_info[1] );
					$term_slug = $term->slug;
					$term_name = $term->name;
					$html .= '<div class="filter filter-'.$post_id.'" terms-id="'.$term_info[0].'" data-filter=".'.$term_slug.'" >'.$term_name.'</div>';
				}
			
		}
		
		$html.= '</div>';
		
		
		
	/*	
		
			$html .= '<script>
				jQuery(document).ready(function($) {

// init Isotope
var $grid = $(".grid-items").isotope({
	layoutMode: "masonry",
	masonry: { 
		isFitWidth: true 
	  },
	filter: ".'.$active_filter.'" 
  
  });


// filter items on button click
$(".nav-filter").on( "click", ".filter", function() {
	
	var filterValue = $(this).attr("data-filter");
	$grid.isotope({ filter: filterValue });
});			

				});		
			</script>';	
		
*/

//var_dump($active_filter);
	
		$html .= '<script>
			jQuery(document).ready(function($) {
				
					$(function(){
					
						$("#post-grid-'.$post_id.'").mixItUp({
				pagination: {
					limit: '.$filterable_post_per_page.',
					prevButtonHTML: "'.$pagination_prev_text.'",
					nextButtonHTML: "'.$pagination_next_text.'",

					

				},
				selectors: {
					pagersWrapper: ".pager-list-'.$post_id.'",
					filter: ".filter-'.$post_id.'",
					
				},';
				
		if(!empty($active_filter) && $active_filter!= 'all')
			{
			

			$html .= '
			load: {
				filter: ".'.$active_filter.'"
			}, ';

			}

				$html .= 'controls: {
					enable: true
				}
				
						});
					
					});
					
			
					
					
			});		
		</script>';	

		
		
		$html .= '<style type="text/css">
		
				#post-grid-'.$post_id.' .grid-items .mix{
				  display: none;
				}
	
				
				</style>
				';
		
		
		
		}
	if($nav_top_search=='yes'){
		
if(isset($_GET['keyword'])){
	
	$keyword = $_GET['keyword'];
	
	}
		
		$html.= '<div class="nav-search">'; 
		$html.= '<input grid_id="'.$post_id.'"  placeholder="'.__('Start typing...', post_grid_textdomain).'" class="search" type="text" value="'.$keyword.'" name="" />';		
		
		$html.= '</div>';
		}


