<?php	


/*
* @Author 		pickplugins
* Copyright: 	2015 pickplugins.com
*/

if ( ! defined('ABSPATH')) exit;  // if direct access



if(empty($_POST['post_grid_hidden']))
	{
		$post_grid_options = get_option( 'post_grid_options' );


	}
else
	{	
		if($_POST['post_grid_hidden'] == 'Y') {
			//Form data sent
			
			if(empty($_POST['post_grid_options']))
				{
					$_POST['post_grid_options'] = array();
				}
			
			$post_grid_options = stripslashes_deep($_POST['post_grid_options']);
			update_option('post_grid_options', $post_grid_options);
		

			?>
			<div class="updated"><p><strong><?php _e('Changes Saved.', post_grid_textdomain ); ?></strong></p></div>
	
			<?php
			} 
	}
	
	

	
	
?>





<div class="wrap">

	<div id="icon-tools" class="icon32"><br></div><?php echo "<h2>".post_grid_plugin_name.__(' - Settings', post_grid_textdomain)."</h2>";?>
		<form  method="post" action="<?php echo str_replace( '%7E', '~', $_SERVER['REQUEST_URI']); ?>">
	<input type="hidden" name="post_grid_hidden" value="Y">
        <?php settings_fields( 'post_grid_plugin_options' );
				do_settings_sections( 'post_grid_plugin_options' );
			
		?>

    <div class="para-settings post-grid-settings">
    
        <ul class="tab-nav"> 
            <li nav="1" class="nav1 active"><?php _e('Options',post_grid_textdomain); ?></li>             
   
        </ul> <!-- tab-nav end --> 
		<ul class="box">

            <li style="display: block;" class="box1 tab-box active">
				<div class="option-box">
                    <p class="option-title"><?php _e('Reset Content Layouts',post_grid_textdomain); ?></p>
                    <p class="option-info"><?php _e('you can reset content layouts here, saved & customized layout will reset permanetly.',post_grid_textdomain); ?></p>
                    
                    <div class="button reset-content-layouts">Reset Layouts</div>

                </div>
                
                
				<div class="option-box">
                    <p class="option-title"><?php _e('Export Content Layouts',post_grid_textdomain); ?></p>
                    <p class="option-info"><?php _e('You can export content layouts here. please make a backup on your local mechine for future use.',post_grid_textdomain); ?></p>
                    
                    <div class="button export-content-layouts"><?php _e('Export Layouts',post_grid_textdomain); ?></div>


					
                    <?php
                    
                        $dir_path = ABSPATH."wp-content/uploads/post-grid/";
                        $filenames=glob($dir_path."*.txt*");
						$count=count($filenames);
						if(!empty($filenames)){
							
							echo '<p class="option-info">Exported files.</p>';
							
							$i=0;
							while($i<$count)
								{
									$filename= str_replace($dir_path,"",$filenames[$i]);
									//var_dump($filelink);
									
									
									$filelink= get_bloginfo('url')."/wp-content/uploads/post-grid/".$filename;
									
									echo ($i+1).'. <a target="_blank" href="'.$filelink.'" >'.$filename.'</a> <span file-url="'.ABSPATH."/wp-content/uploads/post-grid/".$filename.'" class="remove_export_content_layout">Delete</span><br />';

									$i++;
								}

							
							}
						
						
					
					?>


                </div>                
                


				<div class="option-box">
                    <p class="option-title"><?php _e('Import Content Layouts',post_grid_textdomain); ?></p>
                    <p class="option-info"><?php _e('you can import content layouts here. please put serialized data.',post_grid_textdomain); ?></p>
                    <textarea class="import-content-layouts-data" ></textarea><br />
                    <div class="button import-content-layouts"><?php _e('Import Layouts',post_grid_textdomain); ?></div>

                    
                    
                </div> 



                
                
				<div class="option-box">
                    <p class="option-title"><?php _e('Remove Content Layouts',post_grid_textdomain); ?></p>
                    <p class="option-info"><?php _e('you can remove content layouts here.',post_grid_textdomain); ?></p>
					<ul class="layout-list">
					<?php
                    
					$post_grid_layout_content = get_option('post_grid_layout_content');


                    foreach($post_grid_layout_content as $layout_key=>$layout_info){
						?>
                        <li><span class="remove-layout" layout-id="<?php echo $layout_key; ?>" ><i class="fa fa-times"></i></span><b><?php echo $layout_key; ?></b></li>
                        <?php
						
						}

					
					?>
					</ul>
                </div>                
                

                
            </li>
          
        </ul>
    
    
		

        
    </div>




<!-- 

<p class="submit">
	<input class="button button-primary" type="submit" name="Submit" value="<?php _e('Save Changes',post_grid_textdomain ); ?>" />
</p>

-->


		</form>


</div>
