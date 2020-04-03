<?php
/*
* @Author 		pickplugins
* Copyright: 	2015 pickplugins.com
*/

if ( ! defined('ABSPATH')) exit;  // if direct access


if(isset($_GET['keyword'])){
	
	$keyword = $_GET['keyword'];
	
	}



	/*More Query parameter string to array*/
	if(!empty($extra_query_parameter)){
		
		$extra_query_parameter = explode('&', $extra_query_parameter);
		

		
		foreach($extra_query_parameter as $parameter){
			

			
			$parameter = explode('=', $parameter);
			


				if (strpos($parameter[1], ',') !== false) {
					//var_dump('Comma found');
					$parameter_args = explode(',', $parameter[1]);
					$query_parameter[$parameter[0]] = $parameter_args;
					

					}
				else{
					$query_parameter[$parameter[0]] = $parameter[1];
					}

			
			
			}
		
		}
	else{
		
		$query_parameter = array();
		}





if(is_search()){
	
	$keyword = get_search_query();
	

	
	}



	$default_query = array (
			'post_type' => $post_types,
			'post_status' => $post_status,
			's' => $keyword,
			'post__not_in' => $exclude_post_id,
			'order' => $query_order,	
			'orderby' => $query_orderby,
			'meta_key' => $query_orderby_meta_key,
			'posts_per_page' => (int)$posts_per_page,
			'paged' => (int)$paged,
			'offset' => $offset,


			);
			

		
	$query_merge = array_merge($default_query, $query_parameter);

	$query_merge = apply_filters('post_grid_filter_query_args', $query_merge);	
	


	$wp_query = new WP_Query($query_merge);


	
	
	
	
	
	
	
	
	
	
	