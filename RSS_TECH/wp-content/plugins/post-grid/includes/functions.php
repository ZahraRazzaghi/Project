<?php

/*
* @Author 		pickplugins
* Copyright: 	2015 pickplugins.com
*/

if ( ! defined('ABSPATH')) exit;  // if direct access


/*

function post_grid_filter_media_source_extra($media_source){
	
	$media_source_extra = array(
							'media_source_new' =>array('id'=>'media_source_new','title'=>'Media source new','checked'=>'yes'),					
																																							
						);
	return array_merge($media_source, $media_source_extra);							
											
	}

add_filter('post_grid_filter_media_source','post_grid_filter_media_source_extra');


*/

function w4dev_custom_loop_shortcode( $atts ){
	static $w4dev_custom_loop;
	if( !isset($w4dev_custom_loop) )
		$w4dev_custom_loop = 1;
	else
		$w4dev_custom_loop ++;

	$atts = shortcode_atts( array(
		'paging'		=> 'pg'. $w4dev_custom_loop,
		'post_type' 		=> 'post',
		'posts_per_page' 	=> '5',
		'post_status' 		=> 'publish'
	), $atts );

	$paging = $atts['paging'];
	unset( $atts['paging'] );

	if( isset($_GET[$paging]) )
		$atts['paged'] = $_GET[$paging];
	else
		$atts['paged'] = 1;

	$html  = '';
	$custom_query = new WP_Query( $atts );


	

	if( $custom_query->have_posts() ):
	$html .= '<ul>';
		while( $custom_query->have_posts()) : $custom_query->the_post();
		$html .= sprintf( 
			'<li><a href="%1$s">%2$s</a></li>',
			get_permalink(),
			get_the_title()
		);
		endwhile;
	$html .= '</ul>';
	endif;

$pagination_base = add_query_arg( $paging, '%#%' );

	$html .= paginate_links( array(
		'type' 		=> '',
		'base' 		=> $pagination_base,
		'format' 	=> '?'. $paging .'=%#%',
		'current' 	=> max( 1, $custom_query->get('paged') ),
		'total' 	=> $custom_query->max_num_pages
	));

	return $html;
}
//add_shortcode( 'w4dev_custom_loop', 'w4dev_custom_loop_shortcode' );




function post_grid_add_shortcode_column( $columns ) {
    return array_merge( $columns, 
        array( 'shortcode' => __( 'Shortcode', 'post_grid' ) ) );
}
add_filter( 'manage_post_grid_posts_columns' , 'post_grid_add_shortcode_column' );


function post_grid_posts_shortcode_display( $column, $post_id ) {
    if ($column == 'shortcode'){
		?>
        <input style="background:#bfefff" type="text" onClick="this.select();" value="[post_grid <?php echo 'id=&quot;'.$post_id.'&quot;';?>]" /><br />
      <textarea cols="50" rows="1" style="background:#bfefff" onClick="this.select();" ><?php echo '<?php echo do_shortcode("[post_grid id='; echo "'".$post_id."']"; echo '"); ?>'; ?></textarea>
        <?php		
		
    }
}
add_action( 'manage_post_grid_posts_custom_column' , 'post_grid_posts_shortcode_display', 10, 2 );







function post_grid_get_media($media_source, $featured_img_size, $thumb_linked){
		
		
		$post_grid_post_settings = get_post_meta(get_the_ID(), 'post_grid_post_settings');
		
		if(!empty($post_grid_post_settings[0]['custom_thumb_source'])){
			$custom_thumb_source = $post_grid_post_settings[0]['custom_thumb_source'];
			
			}
		else{
			$custom_thumb_source = post_grid_plugin_url.'assets/frontend/css/images/placeholder.png';
			
			}
			
		if(!empty($post_grid_post_settings[0]['font_awesome_icon'])){
			$font_awesome_icon = $post_grid_post_settings[0]['font_awesome_icon'];
			
			}
		else{
			$font_awesome_icon = '';
			
			}			
			
		if(!empty($post_grid_post_settings[0]['font_awesome_icon_color'])){
			$font_awesome_icon_color = $post_grid_post_settings[0]['font_awesome_icon_color'];
			
			}
		else{
			$font_awesome_icon_color = '#737272';
			
			}
			
			
		if(!empty($post_grid_post_settings[0]['font_awesome_icon_size'])){
			$font_awesome_icon_size = $post_grid_post_settings[0]['font_awesome_icon_size'];
			
			}
		else{
			$font_awesome_icon_size = '50px';
			
			}
			
			
		if(!empty($post_grid_post_settings[0]['custom_youtube_id'])){
			$custom_youtube_id = $post_grid_post_settings[0]['custom_youtube_id'];
			}
		else{
			$custom_youtube_id = '';
			
			}	
			
		if(!empty($post_grid_post_settings[0]['custom_vimeo_id'])){
			$custom_vimeo_id = $post_grid_post_settings[0]['custom_vimeo_id'];
			}
		else{
			$custom_vimeo_id = '';
			
			}		
			
			
		if(!empty($post_grid_post_settings[0]['custom_dailymotion_id'])){
			$custom_dailymotion_id = $post_grid_post_settings[0]['custom_dailymotion_id'];
			}
		else{
			$custom_dailymotion_id = '';
			
			}			
			
		if(!empty($post_grid_post_settings[0]['custom_mp3_url'])){
			$custom_mp3_url = $post_grid_post_settings[0]['custom_mp3_url'];
			}
		else{
			$custom_mp3_url = '';
			
			}			
					
			
		if(!empty($post_grid_post_settings[0]['custom_soundcloud_id'])){
			$custom_soundcloud_id = $post_grid_post_settings[0]['custom_soundcloud_id'];
			}
		else{
			$custom_soundcloud_id = '';
			
			}									
		
		
		//echo '<pre>'.var_export($post_grid_post_settings).'</pre>';
		
		$html_thumb = '';
		
		
		if($media_source == 'featured_image'){
				$thumb = wp_get_attachment_image_src( get_post_thumbnail_id(get_the_ID()), $featured_img_size );
				
				//var_dump();
				
				$alt_text = get_post_meta(get_post_thumbnail_id(get_the_ID()), '_wp_attachment_image_alt', true);
				
				$thumb_url = $thumb['0'];
				

				if(!empty($thumb_url)){
					if($thumb_linked=='yes'){
						$html_thumb.= '<a href="'.get_permalink().'"><img alt="'.$alt_text.'" src="'.$thumb_url.'" /></a>';
						}
					else{
						$html_thumb.= '<img alt="'.$alt_text.'" src="'.$thumb_url.'" />';
						}
					
					
					}
				else{
					
					$html_thumb.= '';
					}

			}
			
			
		elseif($media_source == 'empty_thumb'){

				
				if($thumb_linked=='yes'){
					$html_thumb.= '<a class="custom" href="'.get_permalink().'"><img src="'.post_grid_plugin_url.'assets/frontend/css/images/placeholder.png" /></a>';
					}
				else{
					$html_thumb.= '<img class="custom" src="'.post_grid_plugin_url.'assets/frontend/css/images/placeholder.png" />';
					}


			}			
			
			
		elseif($media_source == 'custom_thumb'){

				if(!empty($custom_thumb_source)){
					
					if($thumb_linked=='yes'){
						$html_thumb.= '<a href="'.get_permalink().'"><img src="'.$custom_thumb_source.'" /></a>';
						}
					else{
						$html_thumb.= '<img src="'.$custom_thumb_source.'" />';
						}
					
					}


			}
			
			
		elseif($media_source == 'font_awesome'){

				if(!empty($custom_thumb_source)){
					
					if($thumb_linked=='yes'){
						$html_thumb.= '<a href="'.get_permalink().'"><i style="color:'.$font_awesome_icon_color.';font-size:'.$font_awesome_icon_size.'" class="fa '.$font_awesome_icon.'"></i></a>';
						}
					else{
						$html_thumb.= '<i style="color:'.$font_awesome_icon_color.';font-size:'.$font_awesome_icon_size.'" class="fa '.$font_awesome_icon.'"></i>';
						}
					
					}


			}					
			
			
			
		elseif($media_source == 'first_image'){

			//global $post, $posts;
			$post = get_post(get_the_ID());
			$post_content = $post->post_content;

			//var_dump('Hello');


			$first_img = '';
			ob_start();
			ob_end_clean();
			$output = preg_match_all('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $post_content, $matches);
			
			if(!empty($matches[1][0]))
			$first_img = $matches[1][0];
			
			if(empty($first_img)) {
				$html_thumb.= '';
				}
			else{
				
				if($thumb_linked=='yes'){
					$html_thumb.= '<a href="'.get_permalink().'"><img src="'.$first_img.'" /></a>';
					}
				else{
					$html_thumb.= '<img src="'.$first_img.'" />';
					}

				
				}

			
			}	
			
		elseif($media_source == 'first_gallery'){
				
			$gallery = get_post_gallery( get_the_ID(), false );
			
			
			
			if(!empty($gallery)){
			$html_thumb.= '<div class="gallery owl-carousel">';

			if(!empty($gallery['ids'])){
				$ids = $gallery['ids'];
				$ids = explode(',',$ids);
				
				}
			else{
				
				$ids = array();
				}

		
				//var_dump($ids);
				
				foreach($ids as $id ){
					
					$src = wp_get_attachment_url( $id);
					$alt_text = get_post_meta($id, '_wp_attachment_image_alt', true);
					
					$html_thumb .= '<img src="'.$src.'" class="gallery-item" alt="'.$alt_text.'" />';
					
					}
					
				$html_thumb.= '</div>';
				}

			}	
			
		elseif($media_source == 'first_youtube'){

			$post = get_post(get_the_ID());
			
			$post_type = $post->post_type;
			//var_dump($post_type);
			
			if($post_type=='page'){
				$content = '';
				$html_thumb.= '';
				}
			else{
				
				$content = do_shortcode( $post->post_content );
				}
			
			$embeds = get_media_embedded_in_content( $content );
				
				
			foreach($embeds as $key=>$embed){

				if(strchr($embed,'youtube')){

					$embed_youtube = $embed;
					}

				}

			if(!empty($embed_youtube) ){
				$html_thumb.= $embed_youtube;
				}
			else{
				$html_thumb.= '';
				}

			}

		elseif($media_source == 'first_vimeo'){

			$post = get_post(get_the_ID());
			$post_type = $post->post_type;
			//var_dump($post_type);
			
			if($post_type=='page'){
				$content = '';
				$html_thumb.= '';
				}
			else{
				
				$content = do_shortcode( $post->post_content );
				}
			$embeds = get_media_embedded_in_content( $content );
				
			foreach($embeds as $key=>$embed){

				if(strchr($embed,'vimeo')){

					$embed_youtube = $embed;
					}

				}

			if(!empty($embed_youtube) ){
				$html_thumb.= $embed_youtube;
				}
			else{
				$html_thumb.= '';
				}
			
			}
			
			
			
		elseif($media_source == 'first_dailymotion'){

			$post = get_post(get_the_ID());
			$post_type = $post->post_type;
			//var_dump($post_type);
			
			if($post_type=='page'){
				$content = '';
				$html_thumb.= '';
				}
			else{
				
				$content = do_shortcode( $post->post_content );
				}
			$embeds = get_media_embedded_in_content( $content );
				
			foreach($embeds as $key=>$embed){

				if(strchr($embed,'dailymotion')){

					$embed_youtube = $embed;
					}

				}

			if(!empty($embed_youtube) ){
				$html_thumb.= $embed_youtube;
				}
			else{
				$html_thumb.= '';
				}
			
			}			
			

			
						
		elseif($media_source == 'first_mp3'){

			$post = get_post(get_the_ID());
			$post_type = $post->post_type;
			//var_dump($post_type);
			
			if($post_type=='page'){
				$content = '';
				$html_thumb.= '';
				}
			else{
				
				$content = do_shortcode( $post->post_content );
				}
			$embeds = get_media_embedded_in_content( $content );
				
			foreach($embeds as $key=>$embed){

				if(strchr($embed,'mp3')){

					$embed_youtube = $embed;
					}

				}

			if(!empty($embed_youtube) ){
				$html_thumb.= $embed_youtube;
				}
			else{
				$html_thumb.= '';
				}
			
			}		
			
		elseif($media_source == 'first_soundcloud'){

			$post = get_post(get_the_ID());
			$post_type = $post->post_type;
			//var_dump($post_type);
			
			if($post_type=='page'){
				$content = '';
				$html_thumb.= '';
				}
			else{
				
				$content = do_shortcode( $post->post_content );
				}
			$embeds = get_media_embedded_in_content( $content );
				
			foreach($embeds as $key=>$embed){

				if(strchr($embed,'soundcloud')){

					$embed_youtube = $embed;
					}

				}

			if(!empty($embed_youtube) ){
				$html_thumb.= $embed_youtube;
				}
			else{
				$html_thumb.= '';
				}
			
			}

			
		elseif($media_source == 'custom_youtube'){
				
				if(!empty($custom_youtube_id)){
					$html_thumb.= '<iframe frameborder="0" allowfullscreen="" src="http://www.youtube.com/embed/'.$custom_youtube_id.'?feature=oembed"></iframe>';
					
					}
				

			}			
			
			
			
		elseif($media_source == 'custom_vimeo'){
				
				if(!empty($custom_vimeo_id)){
					$html_thumb.= '<iframe frameborder="0" allowfullscreen="" mozallowfullscreen="" webkitallowfullscreen="" src="https://player.vimeo.com/video/'.$custom_vimeo_id.'"></iframe>';
					
					}
				

			}
			
			
		elseif($media_source == 'custom_dailymotion'){
				
				if(!empty($custom_dailymotion_id)){
					$html_thumb.= '<iframe frameborder="0" allowfullscreen="" mozallowfullscreen="" webkitallowfullscreen="" src="//www.dailymotion.com/embed/video/'.$custom_dailymotion_id.'"></iframe>';
					
					}
				

			}			
			
			
			
		elseif($media_source == 'custom_mp3'){
				
				if(!empty($custom_mp3_url)){
					$html_thumb.= do_shortcode('[audio src="'.$custom_mp3_url.'"]');
					
					}

			}		
			
			
		elseif($media_source == 'custom_soundcloud'){
				
				if(!empty($custom_soundcloud_id)){
					$html_thumb.= '<iframe width="100%" scrolling="no" frameborder="no" src="https://w.soundcloud.com/player/?url=https%3A//api.soundcloud.com/tracks/'.$custom_soundcloud_id.'&amp;auto_play=false&amp;hide_related=false&amp;show_comments=true&amp;show_user=true&amp;show_reposts=false&amp;visual=true"></iframe>';
					
					}

			}				
					
	
				

		return $html_thumb;
				
			
	
	
	}





function post_grid_remove_content_layout_ajax(){
	
	$layout_id = $_POST['layout_id'];
	
	$post_grid_layout_content = get_option('post_grid_layout_content');
	
	//var_dump($post_grid_layout_content[$layout_id]);
	
	unset($post_grid_layout_content[$layout_id]);
	
	update_option('post_grid_layout_content',$post_grid_layout_content);
	
	
	die();
	
	}


add_action('wp_ajax_post_grid_remove_content_layout_ajax', 'post_grid_remove_content_layout_ajax');
add_action('wp_ajax_nopriv_post_grid_remove_content_layout_ajax', 'post_grid_remove_content_layout_ajax');




function post_grid_reset_content_layouts(){
	

	$class_post_grid_functions = new class_post_grid_functions();
	$layout_content_list = $class_post_grid_functions->layout_content_list();
	update_option('post_grid_layout_content', $layout_content_list);
	
	die();
	}


add_action('wp_ajax_post_grid_reset_content_layouts', 'post_grid_reset_content_layouts');
add_action('wp_ajax_nopriv_post_grid_reset_content_layouts', 'post_grid_reset_content_layouts');







function post_grid_import_content_layouts(){
	
	$layouts_data = stripslashes($_POST['layouts_data']);
	$layouts_data = unserialize($layouts_data);
	
	//update_option('post_grid_layout_content', $layouts_data);
	
	if(!empty($layouts_data)){
		
		$post_grid_layout_content = get_option('post_grid_layout_content');
		$post_grid_layout_content = array_merge($post_grid_layout_content,$layouts_data);
		
		update_option('post_grid_layout_content', $post_grid_layout_content);
		
		}

	
	die();
	}


add_action('wp_ajax_post_grid_import_content_layouts', 'post_grid_import_content_layouts');
add_action('wp_ajax_nopriv_post_grid_import_content_layouts', 'post_grid_import_content_layouts');










function post_grid_export_content_layouts(){
	

	$post_grid_layout_content = get_option('post_grid_layout_content');
	
	$export_data = serialize($post_grid_layout_content);
	
	
	//$myfile = fopen(post_grid_plugin_dir."/export/export-layout-content-".date('Y-m-d-h').'-'.time().".txt", "w");
	
	$myfile = fopen(ABSPATH."wp-content/uploads/post-grid/export-layout-content-".date('Y-m-d-h').'-'.time().".txt", "w");	
	

	fwrite($myfile, $export_data);

		$file_url = get_bloginfo('url')."/wp-content/uploads/post-grid/export-layout-content-".date('Y-m-d-h').'-'.time().".txt";		
		//$file_url = post_grid_plugin_url."export/export-layout-content-".date('Y-m-d-h').'-'.time().".txt";
		
		
		
		echo $file_url;
		
	fclose($myfile);
	
	
	die();
	}


add_action('wp_ajax_post_grid_export_content_layouts', 'post_grid_export_content_layouts');
add_action('wp_ajax_nopriv_post_grid_export_content_layouts', 'post_grid_export_content_layouts');




function post_grid_ajax_remove_export_content_layout(){
	
	$file_url = $_POST['file_url'];
	
	unlink($file_url);
	
	
	die();
	}


add_action('wp_ajax_post_grid_ajax_remove_export_content_layout', 'post_grid_ajax_remove_export_content_layout');
add_action('wp_ajax_nopriv_post_grid_ajax_remove_export_content_layout', 'post_grid_ajax_remove_export_content_layout');






function post_grid_term_slug_list($post_id){
	$term_slug_list = '';
	
	$post_taxonomies = get_post_taxonomies($post_id);
	
	foreach($post_taxonomies as $taxonomy){
		
		$term_list[] = wp_get_post_terms(get_the_ID(), $taxonomy, array("fields" => "all"));
		
		}

	if(!empty($term_list)){
		foreach($term_list as $term_key=>$term) 
			{
				foreach($term as $term_id=>$term){
					$term_slug_list .= $term->slug.' ';
					}
			}
		
		}


	return $term_slug_list;

	}






function post_grid_meta_query_args($meta_query){
	
	foreach($meta_query as $key=>$meta_info){
		
		?>
		<div class="items">
			<div class="header"><span class="remove"><i class="fa fa-times"></i></span><?php echo $key; ?></div>
			<div class="options">
       
			Key<br />
			<input type="text" name="post_grid_meta_options[meta_query][<?php echo $key; ?>][key]" value="<?php echo $meta_info['key']; ?>" /><br>
			Value<br />
			<input type="text" name="post_grid_meta_options[meta_query][<?php echo $key; ?>][value]" value="<?php echo $meta_info['value']; ?>" /><br>
			Compare<br />                    
			<input type="text" name="post_grid_meta_options[meta_query][<?php echo $key; ?>][compare]" value="<?php echo $meta_info['compare']; ?>" /><br>
			Type<br />                    
			<input type="text" name="post_grid_meta_options[meta_query][<?php echo $key; ?>][type]" value="<?php echo $meta_info['type']; ?>" /><br>                            
									  
			</div>                        
		</div>
		<?php
	
		}

	
	}






function post_grid_posttypes($post_types){

	$html = '';
	$html .= '<select post_id="'.get_the_ID().'" class="post_types" multiple="multiple" size="6" name="post_grid_meta_options[post_types][]">';
	
		$post_types_all = get_post_types( '', 'names' ); 
		foreach ( $post_types_all as $post_type ) {

			global $wp_post_types;
			$obj = $wp_post_types[$post_type];
			
			if(in_array($post_type,$post_types)){
				$selected = 'selected';
				}
			else{
				$selected = '';
				}

			$html .= '<option '.$selected.' value="'.$post_type.'" >'.$obj->labels->singular_name.'</option>';
		}
		
	$html .= '</select>';
	return $html;
	}






function post_grid_layout_content_ajax(){
	
	$layout_key = $_POST['layout'];
	
	$class_post_grid_functions = new class_post_grid_functions();
	
	
	$post_grid_layout_content = get_option( 'post_grid_layout_content' );
	
	if(empty($post_grid_layout_content)){
		$layout = $class_post_grid_functions->layout_content($layout_key);
		}
	else{
		$layout = $post_grid_layout_content[$layout_key];
		
		}
	
	//$layout = $class_post_grid_functions->layout_content($layout_key);
	
	

	?>
    <div class="<?php echo $layout_key; ?>">
    <?php
    
		foreach($layout as $item_key=>$item_info){
			$item_key = $item_info['key'];
			?>
			

				<div class="item <?php echo $item_key; ?>" style=" <?php echo $item_info['css']; ?> ">
				
				<?php
				
				if($item_key=='thumb'){
					
					?>
					<img src="<?php echo post_grid_plugin_url; ?>assets/admin/images/thumb.png" />
					<?php
					}
					
				elseif($item_key=='title'){
					
					?>
					Lorem Ipsum is simply
					
					<?php
					}								
					
				elseif($item_key=='excerpt'){
					
					?>
					Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text
					<?php
					}	
					
				elseif($item_key=='excerpt_read_more'){
					
					?>
					Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text <a href="#">Read more</a>
					<?php
					}					
					
				elseif($item_key=='read_more'){
					
					?>
					<a href="#">Read more</a>
					<?php
					}												
					
				elseif($item_key=='post_date'){
					
					?>
					18/06/2015
					<?php
					}	
					
				elseif($item_key=='author'){
					
					?>
					PickPlugins
					<?php
					}					
					
				elseif($item_key=='categories'){
					
					?>
					<a hidden="#">Category 1</a> <a hidden="#">Category 2</a>
					<?php
					}
					
				elseif($item_key=='tags'){
					
					?>
					<a hidden="#">Tags 1</a> <a hidden="#">Tags 2</a>
					<?php
					}	
					
				elseif($item_key=='comments_count'){
					
					?>
					3 Comments
					<?php
					}
					
					// WooCommerce
				elseif($item_key=='wc_full_price'){
					
					?>
					<del>$45</del> - <ins>$40</ins>
					<?php
					}											
				elseif($item_key=='wc_sale_price'){
					
					?>
					$45
					<?php
					}					
									
				elseif($item_key=='wc_regular_price'){
					
					?>
					$45
					<?php
					}	
					
				elseif($item_key=='wc_add_to_cart'){
					
					?>
					Add to Cart
					<?php
					}	
					
				elseif($item_key=='wc_rating_star'){
					
					?>
					*****
					<?php
					}					
										
				elseif($item_key=='wc_rating_text'){
					
					?>
					2 Reviews
					<?php
					}	
				elseif($item_key=='wc_categories'){
					
					?>
					<a hidden="#">Category 1</a> <a hidden="#">Category 2</a>
					<?php
					}					
					
				elseif($item_key=='wc_tags'){
					
					?>
					<a hidden="#">Tags 1</a> <a hidden="#">Tags 2</a>
					<?php
					}
					
				elseif($item_key=='edd_price'){
					
					?>
					$45
					<?php
					}					
																										
					
				else{
					
					echo $item_info['name'];
					
					}
				
				?>
				
				
				
				</div>
				<?php
			}
	
	?>
    </div>
    <?php
	
	die();
	
	}
	
add_action('wp_ajax_post_grid_layout_content_ajax', 'post_grid_layout_content_ajax');
add_action('wp_ajax_nopriv_post_grid_layout_content_ajax', 'post_grid_layout_content_ajax');


















function post_grid_layout_hover_ajax(){
	
	$layout_key = $_POST['layout'];
	
	$class_post_grid_functions = new class_post_grid_functions();
	$layout = $class_post_grid_functions->layout_hover($layout_key);
	
	

	?>
    <div class="<?php echo $layout_key; ?>">
    <?php
    
		foreach($layout as $item_key=>$item_info){
			
			?>
			

				<div class="item <?php echo $item_key; ?>" style=" <?php echo $item_info['css']; ?> ">
				
				<?php
				
				if($item_key=='thumb'){
					
					?>
					<img src="<?php echo post_grid_plugin_url; ?>assets/admin/images/thumb.png" />
					<?php
					}
					
				elseif($item_key=='title'){
					
					?>
					Lorem Ipsum is simply
					
					<?php
					}								
					
				elseif($item_key=='excerpt'){
					
					?>
					Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text
					<?php
					}	
					
				elseif($item_key=='excerpt_read_more'){
					
					?>
					Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text <a href="#">Read more</a>
					<?php
					}					
					
				elseif($item_key=='read_more'){
					
					?>
					<a href="#">Read more</a>
					<?php
					}												
					
				elseif($item_key=='post_date'){
					
					?>
					18/06/2015
					<?php
					}	
					
				elseif($item_key=='author'){
					
					?>
					PickPlugins
					<?php
					}					
					
				elseif($item_key=='categories'){
					
					?>
					<a hidden="#">Category 1</a> <a hidden="#">Category 2</a>
					<?php
					}
					
				elseif($item_key=='tags'){
					
					?>
					<a hidden="#">Tags 1</a> <a hidden="#">Tags 2</a>
					<?php
					}	
					
				elseif($item_key=='comments_count'){
					
					?>
					3 Comments
					<?php
					}
					
					// WooCommerce
				elseif($item_key=='wc_full_price'){
					
					?>
					<del>$45</del> - <ins>$40</ins>
					<?php
					}											
				elseif($item_key=='wc_sale_price'){
					
					?>
					$45
					<?php
					}					
									
				elseif($item_key=='wc_regular_price'){
					
					?>
					$45
					<?php
					}	
					
				elseif($item_key=='wc_add_to_cart'){
					
					?>
					Add to Cart
					<?php
					}	
					
				elseif($item_key=='wc_rating_star'){
					
					?>
					*****
					<?php
					}					
										
				elseif($item_key=='wc_rating_text'){
					
					?>
					2 Reviews
					<?php
					}	
				elseif($item_key=='wc_categories'){
					
					?>
					<a hidden="#">Category 1</a> <a hidden="#">Category 2</a>
					<?php
					}					
					
				elseif($item_key=='wc_tags'){
					
					?>
					<a hidden="#">Tags 1</a> <a hidden="#">Tags 2</a>
					<?php
					}																						
					
				else{
					
					echo $item_info['name'];
					
					}
				
				?>
				
				
				
				</div>
				<?php
			}
	
	?>
    </div>
    <?php
	
	die();
	
	}
	
add_action('wp_ajax_post_grid_layout_hover_ajax', 'post_grid_layout_hover_ajax');
add_action('wp_ajax_nopriv_post_grid_layout_hover_ajax', 'post_grid_layout_hover_ajax');








function post_grid_layout_add_elements(){
	
	$item_key = $_POST['item_key'];
	$layout = $_POST['layout'];	
	$unique_id = $_POST['unique_id'];	

	$class_post_grid_functions = new class_post_grid_functions();
	$layout_items = $class_post_grid_functions->layout_items();



	$html = array();
	$html['item'] = '';
	$html['item'].= '<div class="item '.$item_key.'" >';	

    
    if($item_key=='thumb'){
		
        $html['item'].= '<img style="width:100%;" src="'.post_grid_plugin_url.'assets/admin/images/thumb.png" />';

        }
		
    elseif($item_key=='thumb_link'){
        
		$html['item'].= '<a href="#"><img style="width:100%;" src="'.post_grid_plugin_url.'assets/admin/images/thumb.png" /></a>';

        }		
		
        
    elseif($item_key=='title'){
        
		$html['item'].= 'Lorem Ipsum is simply';

        }
		
    elseif($item_key=='title_link'){
        
		$html['item'].= '<a href="#">Lorem Ipsum is simply</a>';

        }		
									
        
    elseif($item_key=='excerpt'){
        $html['item'].= 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text';
		

        }	
        
    elseif($item_key=='excerpt_read_more'){
        $html['item'].= 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text <a href="#">Read more</a>';

        }					
        
    elseif($item_key=='read_more'){
        $html['item'].= '<a href="#">Read more</a>';

        }												
        
    elseif($item_key=='post_date'){
        $html['item'].= '18/06/2015';

        }	
        
    elseif($item_key=='author'){
        $html['item'].= 'PickPlugins';

        }					
        
    elseif($item_key=='categories'){
        $html['item'].= '<a hidden="#">Category 1</a> <a hidden="#">Category 2</a>';

        }
        
    elseif($item_key=='tags'){
        $html['item'].= '<a hidden="#">Tags 1</a> <a hidden="#">Tags 2</a>';

        }	
        
    elseif($item_key=='comments_count'){
         $html['item'].= '3 Comments';

        }
        
        // WooCommerce
    elseif($item_key=='wc_full_price'){
        $html['item'].= '<del>$45</del> - <ins>$40</ins>';

        }											
    elseif($item_key=='wc_sale_price'){
        $html['item'].= '$45';

        }					
                        
    elseif($item_key=='wc_regular_price'){
         $html['item'].= '$45';

        }	
        
    elseif($item_key=='wc_add_to_cart'){
        $html['item'].= 'Add to Cart';

        }	
        
    elseif($item_key=='wc_rating_star'){
        $html['item'].= '*****';

        }					
                            
    elseif($item_key=='wc_rating_text'){
        $html['item'].= '2 Reviews';

        }	
    elseif($item_key=='wc_categories'){
        $html['item'].= '<a href="#">Category 1</a> <a href="#">Category 2</a>';

        }					
        
    elseif($item_key=='wc_tags'){
         $html['item'].= '<a href="#" >Tags 1</a> <a href="#">Tags 2</a>';

        }	
		
	/* WP eCommerce Stuff*/
		
    elseif($item_key=='WPeC_old_price'){
         $html['item'].= '$45';

        }
		
    elseif($item_key=='WPeC_sale_price'){
         $html['item'].= '$40';

        }		
    elseif($item_key=='WPeC_add_to_cart'){
         $html['item'].= 'Add to Cart';

        }		
		
    elseif($item_key=='WPeC_rating_star'){
         $html['item'].= '*****';

        }			
    elseif($item_key=='WPeC_categories'){
         $html['item'].= '<a href="#">Category 1</a> <a href="#">Category 2</a>';

        }		
		
		
    elseif($item_key=='meta_key'){
         $html['item'].= 'Meta Key';

        }			
			
			
    elseif($item_key=='html'){
         $html['item'].= 'HTML';

        }			
			
																							
        
    else{
        
        echo '';
        
        }
     $html['item'].= '</div>';

	$html['options'] = '';
	$html['options'].= '<div class="items" id="'.$unique_id.'">';
	$html['options'].= '<div class="header"><span class="remove"><i class="fa fa-times"></i></span>'.$layout_items[$item_key].'</div>';
	$html['options'].= '<div class="options">';
	
	if($item_key=='meta_key'){
		
		$html['options'].= 'Meta Key: <br /><input type="text" value="" name="post_grid_layout_content['.$layout.']['.$unique_id.'][field_id]" /><br /><br />';
		$html['options'].= 'Wrapper: <br />use %s where you want to repalce the meta value. Example<pre>&lt;div&gt;%s&lt;/div&gt;</pre> <br /><input type="text" value="%s" name="post_grid_layout_content['.$layout.']['.$unique_id.'][wrapper]" /><br /><br />';		
		
		
		}
		
	if($item_key=='html'){
		
		$html['options'].= 'Custom HTML: <br /><input type="text" value="" name="post_grid_layout_content['.$layout.']['.$unique_id.'][html]" /><br /><br />';		

		}		
		
		
		
	if($item_key=='read_more'){
		
		$html['options'].= 'Read more text: <br /><input type="text" value="" name="post_grid_layout_content['.$layout.']['.$unique_id.'][read_more_text]" /><br /><br />';
		}		
		
		
		
	if($item_key=='title'  || $item_key=='title_link'  || $item_key=='excerpt' || $item_key=='excerpt_read_more' ){
		
		$html['options'].= 'Character limit: <br /><input type="text" value="20" name="post_grid_layout_content['.$layout.']['.$unique_id.'][char_limit]" /><br /><br />';
		}
		
	if($item_key=='title_link' || $item_key=='read_more' || $item_key=='excerpt_read_more'  ){
		
		$html['options'].= 'Link target: <br />
		<select name="post_grid_layout_content['.$layout.']['.$unique_id.'][link_target]" >
		<option value="_blank">_blank</option>
		<option value="_parent">_parent</option>
		<option value="_self">_self</option>
		<option value="_top">_top</option>
		<option value="new">new</option>
		 </select><br /><br />';
		}		
		
		
		
		
		
		
		
		

	$html['options'].= '
	<input type="hidden" value="'.$item_key.'" name="post_grid_layout_content['.$layout.']['.$unique_id.'][key]" />
	<input type="hidden" value="'.$layout_items[$item_key].'" name="post_grid_layout_content['.$layout.']['.$unique_id.'][name]" />
	CSS: <br />
	<a target="_blank" href="http://www.pickplugins.com/demo/post-grid/sample-css-for-layout-editor/">Sample css</a><br />
	<textarea class="custom_css" name="post_grid_layout_content['.$layout.']['.$unique_id.'][css]" item_id="'.$item_key.'" style="width:50%" spellcheck="false" autocapitalize="off" autocorrect="off">font-size:12px;display:block;padding:10px;</textarea><br /><br />
	
	CSS Hover: <br />
	<textarea class="custom_css" name="post_grid_layout_content['.$layout.']['.$unique_id.'][css_hover]" item_id="'.$item_key.'" style="width:50%" spellcheck="false" autocapitalize="off" autocorrect="off"></textarea>';
	
	
	
	
	
	
	$html['options'].= '</div>';
	$html['options'].= '</div>';	



	echo json_encode($html);


	
	die();
	
	}
	
add_action('wp_ajax_post_grid_layout_add_elements', 'post_grid_layout_add_elements');
add_action('wp_ajax_nopriv_post_grid_layout_add_elements', 'post_grid_layout_add_elements');














function post_grid_ajax_load_more(){
		
		$html = '';
		$post_id = (int)$_POST['grid_id'];
		$per_page = (int)$_POST['per_page'];
		$terms = (int)$_POST['terms'];
		
		
		include post_grid_plugin_dir.'/grid-items/variables.php';
		
		$paged = (int)$_POST['paged'];
		
		include post_grid_plugin_dir.'/grid-items/query.php';
		
		if ( $wp_query->have_posts() ) :
			while ( $wp_query->have_posts() ) : $wp_query->the_post();

			
			$html.='<div class="item skin '.$skin.' '.post_grid_term_slug_list(get_the_ID()).'">';
			
			include post_grid_plugin_dir.'/grid-items/layer-media.php';
			include post_grid_plugin_dir.'/grid-items/layer-content.php';
			include post_grid_plugin_dir.'/grid-items/layer-hover.php';	
			
			$html.='</div>';  // .item		
	
			endwhile;
			wp_reset_query();
		else:
		
		if($pagination_type=='load_more'){
			$html.= '<script>
			jQuery(document).ready(function($)
				{
					$("#post-grid-'.$post_id.' .load-more").html("'.__('No more post',post_grid_textdomain).'");
					$("#post-grid-'.$post_id.' .load-more").addClass("no-post");				
	
					})
			
			
			</script>';
			}


		
		
		endif;
		
		echo $html;
		
		die();
		
	}

add_action('wp_ajax_post_grid_ajax_load_more', 'post_grid_ajax_load_more');
add_action('wp_ajax_nopriv_post_grid_ajax_load_more', 'post_grid_ajax_load_more');








function post_grid_ajax_search(){
		
		$html = '';
		$post_id = (int)$_POST['grid_id'];

		include post_grid_plugin_dir.'/grid-items/variables.php';
		$keyword = sanitize_text_field($_POST['keyword']);
		
		include post_grid_plugin_dir.'/grid-items/query.php';
		
		if ( $wp_query->have_posts() ) :
			while ( $wp_query->have_posts() ) : $wp_query->the_post();

			
			$html.='<div class="item skin '.$skin.' '.post_grid_term_slug_list(get_the_ID()).'">';
			
			include post_grid_plugin_dir.'/grid-items/layer-media.php';
			include post_grid_plugin_dir.'/grid-items/layer-content.php';
			include post_grid_plugin_dir.'/grid-items/layer-hover.php';	
			
			$html.='</div>';  // .item		
	
			endwhile;
			wp_reset_query();
		else:
		
			$html.='<div class="item">';
			$html.=__('No Post found',post_grid_textdomain);  // .item	
			$html.='</div>';  // .item	
				
		endif;
		
		echo $html;
		
		die();
		
	}

add_action('wp_ajax_post_grid_ajax_search', 'post_grid_ajax_search');
add_action('wp_ajax_nopriv_post_grid_ajax_search', 'post_grid_ajax_search');


function post_grid_active_filter(){
		
		$html = '';
		$categories = $_POST['categories'];
		
		//var_dump($categories).'<br>';
		
		$html .= '<select class="" name="post_grid_meta_options[nav_top][active_filter]">';
		$html .= '<option  value="all">All</option>';
		foreach($categories as $tax_terms){
			
			$tax_terms = explode(',',$tax_terms);
			
			
			$terms_info = get_term_by('id', $tax_terms[1], $tax_terms[0]);
			//var_dump($terms_info);
			$html .= '<option  value="'.$terms_info->slug.'">'.$terms_info->name.'</option>';

			}
		
		$html .= '</select>';

		echo $html;
		
		die();
		
	}


add_action('wp_ajax_post_grid_active_filter', 'post_grid_active_filter');
add_action('wp_ajax_nopriv_post_grid_active_filter', 'post_grid_active_filter');






	
	function post_grid_share_plugin(){
			
			?>
<iframe src="https://www.facebook.com/plugins/like.php?href=https%3A%2F%2Fwordpress.org%2Fplugins%2Fpost-grid%2F&width=450&layout=standard&action=like&show_faces=true&share=true&height=80&appId" width="450" height="80" style="border:none;overflow:hidden" scrolling="no" frameborder="0" allowTransparency="true"></iframe>
            
            <br />
            <!-- Place this tag in your head or just before your close body tag. -->
            <script src="https://apis.google.com/js/platform.js" async defer></script>
            
            <!-- Place this tag where you want the +1 button to render. -->
            <div class="g-plusone" data-size="medium" data-annotation="inline" data-width="300" data-href="<?php echo post_grid_share_url; ?>"></div>
            
            <br />
            <br />
            <a href="https://twitter.com/share" class="twitter-share-button" data-url="<?php echo post_grid_share_url; ?>" data-text="<?php echo post_grid_plugin_name; ?>" data-via="ParaTheme" data-hashtags="WordPress">Tweet</a>
            <script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');</script>



            <?php

		
		}
	
	
	
	
/*

	function post_grid_admin_notices()
		{
			$post_grid_license_key = get_option('post_grid_license_key');
			
			$html= '';

			if(empty($post_grid_license_key))
				{
					$admin_url = get_admin_url();
					
					$html.= '<div class="update-nag">';
					$html.= 'Please activate your license for <b>'.post_grid_plugin_name.' &raquo; <a href="'.$admin_url.'edit.php?post_type=post_grid&page=post_grid_menu_license">License</a></b>';
					$html.= '</div>';	
				}
			else
				{

				}

			echo $html;
		}
	
	add_action('admin_notices', 'post_grid_admin_notices');

*/
		
		
		
		
		
		
	


	function post_grid_upgrade_notice()
		{
			$post_grid_upgrade = get_option('post_grid_upgrade');
			
			
			$html= '';

			if(($post_grid_upgrade == 'done') || (version_compare(post_grid_version, '3.0.0') >= 0) )
				{
					
				}
			else{
				$html.= '<div class="update-nag">';
				$html.='Data update required for Post grid latest version. <span id="post-grid-upgrade">Click to update</span>';
				$html.= '</div>';
				}


			echo $html;
		}
	
	add_action('admin_notices', 'post_grid_upgrade_notice');



				

	function post_grid_upgrade_action()
		{
			$post_grid_upgrade = get_option('post_grid_upgrade');
			if($post_grid_upgrade=='done' ){
				
				}
			else{
				$wp_query = new WP_Query(
										array (
											'post_type' => 'post_grid',
											'post_status' => 'publish',

											) );
			
						
			if ( $wp_query->have_posts() ) :
				while ( $wp_query->have_posts() ) : $wp_query->the_post();

					$post_grid_themes = get_post_meta( get_the_ID(), 'post_grid_themes', true );
					
					if($post_grid_themes=='mixit' || $post_grid_themes=='isotope' || $post_grid_themes=='isotope-lite'){
						$filter = 'yes';
						}
					else{
						$filter = 'no';
						}
					
					
					
					$post_grid_masonry_enable = get_post_meta( get_the_ID(), 'post_grid_masonry_enable', true );		
					
					$post_grid_bg_img = get_post_meta( get_the_ID(), 'post_grid_bg_img', true );		
					$post_grid_thumb_size = get_post_meta( get_the_ID(), 'post_grid_thumb_size', true );
					$post_grid_empty_thumb = get_post_meta( get_the_ID(), 'post_grid_empty_thumb', true );		
						
					$post_grid_post_per_page = get_post_meta( get_the_ID(), 'post_grid_post_per_page', true );		
					$post_grid_pagination_display = get_post_meta( get_the_ID(), 'post_grid_pagination_display', true );		
					
					if($post_grid_pagination_display=='no'){
						
						$post_grid_pagination_display='none';
						}
					
					
					$post_grid_excerpt_count = get_post_meta( get_the_ID(), 'post_grid_excerpt_count', true );		
					$post_grid_read_more_text = get_post_meta( get_the_ID(), 'post_grid_read_more_text', true );					
					$post_grid_exclude_post_id = get_post_meta( get_the_ID(), 'post_grid_exclude_post_id', true );		
					
					$post_grid_bg_img = get_post_meta( get_the_ID(), 'post_grid_bg_img', true );
					
					$post_grid_items_width = get_post_meta( get_the_ID(), 'post_grid_items_width', true );
					$post_grid_items_width_mobile = get_post_meta( get_the_ID(), 'post_grid_items_width_mobile', true );				
					$post_grid_thumb_height = get_post_meta( get_the_ID(), 'post_grid_thumb_height', true );	
				
					$post_grid_query_order = get_post_meta( get_the_ID(), 'post_grid_query_order', true );
					$post_grid_query_orderby = get_post_meta( get_the_ID(), 'post_grid_query_orderby', true );
							
					$post_grid_posttype = get_post_meta( get_the_ID(), 'post_grid_posttype', true );
					$post_grid_taxonomy = get_post_meta( get_the_ID(), 'post_grid_taxonomy', true );
					$post_grid_taxonomy_category = get_post_meta( get_the_ID(), 'post_grid_taxonomy_category', true );				
					
					if(!empty($post_grid_taxonomy_category)){
						
						$i= 0;
						foreach($post_grid_taxonomy_category as $term){
							
							$terms[$i] = $post_grid_taxonomy.','.$term;
							$i++;
							}
						$post_grid_taxonomy_category = $terms;
						}
					else{
						$post_grid_taxonomy_category = array();
						}			

					
					$post_grid_meta_author_display = get_post_meta( get_the_ID(), 'post_grid_meta_author_display', true );
					$post_grid_meta_avatar_display = get_post_meta( get_the_ID(), 'post_grid_meta_avatar_display', true );			
					$post_grid_meta_date_display = get_post_meta( get_the_ID(), 'post_grid_meta_date_display', true );				
					$post_grid_meta_categories_display = get_post_meta( get_the_ID(), 'post_grid_meta_categories_display', true );
					$post_grid_meta_tags_display = get_post_meta( get_the_ID(), 'post_grid_meta_tags_display', true );		
					$post_grid_meta_comments_display = get_post_meta( get_the_ID(), 'post_grid_meta_comments_display', true );		
					
					
					
					$post_grid_items = get_post_meta( get_the_ID(), 'post_grid_items', true );		
					$post_grid_wrapper = get_post_meta( get_the_ID(), 'post_grid_wrapper', true );
					$post_grid_before_after = get_post_meta( get_the_ID(), 'post_grid_before_after', true );			
					$post_grid_items_display = get_post_meta( get_the_ID(), 'post_grid_items_display', true );		
					
					$post_grid_post_title_linked = get_post_meta( get_the_ID(), 'post_grid_post_title_linked', true );		
					$post_grid_post_thumbnail_linked = get_post_meta( get_the_ID(), 'post_grid_post_thumbnail_linked', true );
					$post_grid_post_thumbnail_external = get_post_meta( get_the_ID(), 'post_grid_post_thumbnail_external', true );					
					
					$post_grid_hover_items_zoom_display = get_post_meta( get_the_ID(), 'post_grid_hover_items_zoom_display', true );			
					$post_grid_hover_items_link_display = get_post_meta( get_the_ID(), 'post_grid_hover_items_link_display', true );		
					$post_grid_hover_items_share_display = get_post_meta( get_the_ID(), 'post_grid_hover_items_share_display', true );		
					
					$post_grid_title_color = get_post_meta( get_the_ID(), 'post_grid_title_color', true );
					$post_grid_title_font_size = get_post_meta( get_the_ID(), 'post_grid_title_font_size', true );
				
					$post_grid_content_color = get_post_meta( get_the_ID(), 'post_grid_content_color', true );
					$post_grid_content_font_size = get_post_meta( get_the_ID(), 'post_grid_content_font_size', true );
					
					$post_grid_hover_items_hover_effect_in = get_post_meta( get_the_ID(), 'post_grid_hover_items_hover_effect_in', true );
					
					$post_grid_mixitup_post_per_page = get_post_meta( get_the_ID(), 'post_grid_mixitup_post_per_page', true );
					$post_grid_mixitup_default_filter = get_post_meta( get_the_ID(), 'post_grid_mixitup_default_filter', true );		
						
					$terms_info = get_term_by('slug', $post_grid_mixitup_default_filter, $post_grid_taxonomy);
						
					$post_grid_mixitup_default_filter = $terms_info->term_id;
						
					$post_grid_custom_css = get_post_meta( get_the_ID(), 'post_grid_custom_css', true ); /*ok*/	
				
				
				
				
				
				/*
				
					$post_grid_meta_options = array(
					
													'post_types'=>$post_grid_posttype,
													'categories'=>$post_grid_taxonomy_category,													
													'categories_relation'=>'OR',
													'post_status'=>array('publish'),													
													'offset'=>0,													
													'posts_per_page'=>$post_grid_post_per_page,													
													'exclude_post_id'=>$post_grid_exclude_post_id,
													'query_order'=>$post_grid_query_order,													
													'query_orderby'=>array($post_grid_query_orderby),														
													'query_orderby_meta_key'=>'',
													'meta_query'=>array(),
													'meta_query_relation'=>'OR',
													'keyword'=>'',
													'layout'=>array(
																	'content'=>'flat',
																	'hover'=>'flat',
																	),
													
													'skin'=>'flat',	
													'custom_js'=>'',
													'custom_css'=>$post_grid_custom_css,
													'width'=>array(
																	'desktop'=>$post_grid_items_width,
																	'tablet'=>$post_grid_items_width,
																	'mobile'=>$post_grid_items_width_mobile,																	
																	),
																	
													'height'=>array(
																	'style'=>'auto_height',
																	'fixed_height'=>$post_grid_thumb_height,															
																	),																	
													'media_source'=>array(
																		'featured_image' => array ('id' => 'featured_image','title' => 'Featured Image','checked' => 'yes',),
																		'first_image' => array ('id' => 'first_image','title' => 'First images from content','checked' => 'yes',),
																		'first_gallery' => array ('id' => 'first_gallery','title' => 'First gallery from content','checked' => 'yes',),
																		'first_youtube' => array ('id' => 'first_youtube','title' => 'First youtube video from content','checked' => 'yes',),
																		'first_vimeo' => array ('id' => 'first_vimeo','title' => 'First vimeo video from content','checked' => 'yes',),
																		'first_mp3' => array ('id' => 'first_mp3','title' => 'First MP3 from content','checked' => 'yes',),
																		'first_soundcloud' => array ('id' => 'first_soundcloud','title' => 'First SoundCloud from content','checked' => 'yes',),
																		'empty_thumb' => array ('id' => 'empty_thumb','title' => 'Empty thumbnail','checked' => 'yes',),
										  ),																	
													'featured_img_size'=>$post_grid_thumb_size,																		
													'margin'=>'5px',																													
													
													'container'=>array(
																	'padding'=>'10px',
																	'bg_color'=>'',
																	'bg_image'=>$post_grid_bg_img,																	
																	),
																	
																	
													'nav_top'=>array(
																	'filter'=>$filter,
																	'active_filter'=>$post_grid_mixitup_default_filter,																	
																	'search'=>'none',																
																	),
																																		
													'nav_bottom'=>array(
																	'pagination_type'=>$post_grid_pagination_display,
																	'pagination_theme'=>'lite',																
																	),
																	

														);
				
				*/
				

					$post_grid_meta_options = array(
					
													'post_types'=>'',
													'categories'=>'',													
													'categories_relation'=>'OR',
													'post_status'=>array('publish'),													
													'offset'=>0,													
													'posts_per_page'=>'',													
													'exclude_post_id'=>'',
													'query_order'=>'',													
													'query_orderby'=>array(),														
													'query_orderby_meta_key'=>'',
													'meta_query'=>array(),
													'meta_query_relation'=>'OR',
													'keyword'=>'',
													'layout'=>array(
																	'content'=>'flat',
																	'hover'=>'flat',
																	),
													
													'skin'=>'flat',	
													'custom_js'=>'',
													'custom_css'=>'',
													'width'=>array(
																	'desktop'=>'',
																	'tablet'=>'',
																	'mobile'=>'',																	
																	),
																	
													'height'=>array(
																	'style'=>'auto_height',
																	'fixed_height'=>'',															
																	),																	
													'media_source'=>array(
																		'featured_image' => array ('id' => 'featured_image','title' => 'Featured Image','checked' => 'yes',),
																		'first_image' => array ('id' => 'first_image','title' => 'First images from content','checked' => 'yes',),
																		'first_gallery' => array ('id' => 'first_gallery','title' => 'First gallery from content','checked' => 'yes',),
																		'first_youtube' => array ('id' => 'first_youtube','title' => 'First youtube video from content','checked' => 'yes',),
																		'first_vimeo' => array ('id' => 'first_vimeo','title' => 'First vimeo video from content','checked' => 'yes',),
																		'first_mp3' => array ('id' => 'first_mp3','title' => 'First MP3 from content','checked' => 'yes',),
																		'first_soundcloud' => array ('id' => 'first_soundcloud','title' => 'First SoundCloud from content','checked' => 'yes',),
																		'empty_thumb' => array ('id' => 'empty_thumb','title' => 'Empty thumbnail','checked' => 'yes',),
										  ),																	
													'featured_img_size'=>'',																		
													'margin'=>'5px',																													
													
													'container'=>array(
																	'padding'=>'10px',
																	'bg_color'=>'',
																	'bg_image'=>'',																	
																	),
																	
																	
													'nav_top'=>array(
																	'filter'=>'',
																	'active_filter'=>'',																	
																	'search'=>'none',																
																	),
																																		
													'nav_bottom'=>array(
																	'pagination_type'=>'',
																	'pagination_theme'=>'lite',																
																	),
																	

														);	
				
				
				
				
				
				
					update_post_meta(get_the_ID(), 'post_grid_meta_options', $post_grid_meta_options );
				
				endwhile;
				wp_reset_query();
			endif;
	
				}
	
			update_option('post_grid_upgrade','done');
			die();
			
		}	
		
		
		
add_action('wp_ajax_post_grid_upgrade_action', 'post_grid_upgrade_action');
add_action('wp_ajax_nopriv_post_grid_upgrade_action', 'post_grid_upgrade_action');
		
		