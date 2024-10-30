<?php
/*
Plugin Name: Hexa Team Responsive Grid Free
Plugin URI: http://worldclassthemes.com/hexa-team-grid
Description: Add Beautiful Responsive Hexagon Team Grid to your Website Pages.
Version: 2.3
Author: Suhail Ahmad
Author URI: http://worldclassthemes.com
Text Domain: hexa-team-grid
*/

add_action('init', 'htg_custom_post_team');
function htg_custom_post_team()
{
  $labels = array(
    'name' => _x('Team', 'post type general name', 'hexa-team-grid'),
    'singular_name' => _x('Team Member', 'post type singular name', 'hexa-team-grid'),
    'add_new' => _x('Add New', 'Team Member', 'hexa-team-grid'),
    'add_new_item' => __('Add New Team Member', 'hexa-team-grid'),
    'edit_item' => __('Edit Team Member', 'hexa-team-grid'),
    'new_item' => __('New Team Member', 'hexa-team-grid'),
    'view_item' => __('View Team Member', 'hexa-team-grid'),
    'search_items' => __('Search Team Members', 'hexa-team-grid'),
    'not_found' =>  __('No Team Member found', 'hexa-team-grid'),
    'not_found_in_trash' => __('No Team Member found in Trash', 'hexa-team-grid'),
    'parent_item_colon' => ''
  );
  $args = array(
    'labels' => $labels,
    'public' => true,
    'publicly_queryable' => true,
    'show_ui' => true,
    'query_var' => true,
    'rewrite' => true,
    'capability_type' => 'post',
    'hierarchical' => false,
    'menu_position' => 5,
	'rewrite' => true,
	'taxonomies' => array('post_tag'),
    'supports' => array('title','editor','thumbnail', 'thumbnail')
  );
  register_post_type('wct_team',$args);
}

add_action("admin_init", "htg_extra_custom_fields");
 
function htg_extra_custom_fields(){
  add_meta_box("htg_position_box", "Information (Just leave a field empty to hide it)", "htg_position_box", array("wct_team"), "normal", "low");
}

function htg_position_box(){
  global $post;
  $custom = get_post_custom($post->ID);
  $position = $custom["wct_position"][0];
  $facebook = $custom["wct_facebook"][0];
  $twitter = $custom["wct_twitter"][0];
  $linkedin = $custom["wct_linkedin"][0];
  $instagram = $custom["wct_instagram"][0];
 ?>
    <label>Please Select Position of the team member</label><br />
    <input type="text" name="wct_position" placeholder="position" value="<?php echo $position; ?>" />
    
    <br /><br />
    
    <label>Please Enter Facebook profile Link of the Member</label><br />
    <input type="text" name="wct_facebook" placeholder="Facebook Link" value="<?php echo $facebook; ?>" />
    
    <br /><br />
    
    <label>Please Enter Twitter profile Link of the Member</label><br />
    <input type="text" name="wct_twitter" placeholder="Twitter Link" value="<?php echo $twitter; ?>" />
    
    <br /><br />
    
    <label>Please Enter Linkedin Profile Link of the Member</label><br />
    <input type="text" name="wct_linkedin" placeholder="Linkedin Link" value="<?php echo $linkedin; ?>" />
    
    <br /><br />
    
    <label>Please Enter Instagram Profile Link of the Member</label><br />
    <input type="text" name="wct_instagram" placeholder="Instagram Link" value="<?php echo $instagram; ?>" />
    
    <br /><br />

    <?php 
}

add_action('save_post', 'htg_save_details');

function htg_save_details(){
	
  	global $post;
	
	if(isset($_POST["wct_position"])){
		update_post_meta($post->ID, "wct_position", sanitize_text_field($_POST["wct_position"]));
	}
	if(isset($_POST["wct_facebook"])){
		update_post_meta($post->ID, "wct_facebook", sanitize_text_field($_POST["wct_facebook"]));
	}
	if(isset($_POST["wct_twitter"])){
		update_post_meta($post->ID, "wct_twitter", sanitize_text_field($_POST["wct_twitter"]));
	}
	if(isset($_POST["wct_linkedin"])){
		update_post_meta($post->ID, "wct_linkedin", sanitize_text_field($_POST["wct_linkedin"]));
	}
	if(isset($_POST["wct_instagram"])){
		update_post_meta($post->ID, "wct_instagram", sanitize_text_field($_POST["wct_instagram"]));
	}
}

function htg_enqueue_scripts() 
{
    //wp_enqueue_style( 'hexa-css', plugins_url( '/assets/hexagons.css', __FILE__ ) );
	wp_enqueue_style( 'hexa-css-2', 'https://maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css' );
}

add_action('admin_enqueue_scripts', 'htg_enqueue_scripts');


// create custom plugin settings menu
add_action('admin_menu', 'htg_grid_plugin_menu');

function htg_grid_plugin_menu() {

	//create new top-level menu
	add_menu_page('Add Hexa Grid', 'Hexa Team', 'administrator', __FILE__, 'wct_hexa_grid_plugin_page', plugins_url('/images/hexa-icon.png', __FILE__) );

	//call register settings function
	add_action( 'admin_init', 'register_wct_grid_plugin' );
}


function register_wct_grid_plugin() {
	//register our settings
	register_setting( 'wct-grid-plugin-settings-group', 'cat' );
	register_setting( 'wct-grid-plugin-settings-group', 'background_color' );
	register_setting( 'wct-grid-plugin-settings-group', 'add_to_cart_1_color' );
	register_setting( 'wct-grid-plugin-settings-group', 'add_to_cart_2_color' );
	register_setting( 'wct-grid-plugin-settings-group', 'view_1_color' );
	register_setting( 'wct-grid-plugin-settings-group', 'view_2_color' );
	register_setting( 'wct-grid-plugin-settings-group', 'product_title_color' );
	register_setting( 'wct-grid-plugin-settings-group', 'font_color' );
	register_setting( 'wct-grid-plugin-settings-group', 'num_prod' );
	register_setting( 'wct-grid-plugin-settings-group', 'title_size' );
	register_setting( 'wct-grid-plugin-settings-group', 'option_etc' );
}

function wct_hexa_grid_plugin_page() {
	wp_enqueue_script( 'js-color', plugins_url( '/js-color/jscolor.js', __FILE__ ) );
	?>
    
    
    
    <h1>Shortcode</h1>
    
    <p>Use this shortcode to to show the WCT Team Grid on any of your page.</p>
    <input value="[wct_team_grid]" type="text" />
    
    <br /><br /><br />
    <form method="post" action="options.php">
    
    <?php settings_fields( 'wct-grid-plugin-settings-group' ); ?>
    <?php do_settings_sections( 'wct-grid-plugin-settings-group' ); ?>
	<?php //echo get_option('background_color'); ?>
    <br />
    Number of Members: <input name="num_prod" type="number" value="<?php if(get_option('num_prod')!=NULL){ echo esc_attr( get_option('num_prod') ); } else { echo "10"; } ?>"><br /><br />
    Title Font Size: <input name="title_size" type="number" value="<?php if(get_option('title_size')!=NULL){ echo esc_attr( get_option('title_size') ); } else { echo "20"; } ?>"><br /><br />
    Background Color: <input name="background_color" class="" type="color" value="<?php if(get_option('background_color')!=NULL){ echo esc_attr( get_option('background_color') ); } else { echo "0066FF"; } ?>"><br /><br />
    <!--Add to cart button Color: <input name="add_to_cart_1_color" class="jscolor" value="<?php if(get_option('add_to_cart_1_color')!=NULL){ echo esc_attr( get_option('add_to_cart_1_color') ); } else { echo "060"; } ?>"> to <input name="add_to_cart_2_color" class="jscolor" value="<?php if(get_option('add_to_cart_2_color')!=NULL){ echo esc_attr( get_option('add_to_cart_2_color') ); } else { echo "090"; } ?>"><br /><br />
    View product button Color: <input name="view_1_color" class="jscolor" value="<?php if(get_option('view_1_color')!=NULL){ echo esc_attr( get_option('view_1_color') ); } else { echo "999"; } ?>"> to <input name="view_2_color" class="jscolor" value="<?php if(get_option('view_2_color')!=NULL){ echo esc_attr( get_option('view_2_color') ); } else { echo "ccc"; } ?>"><br /><br />
	Product Title Color: <input name="product_title_color" class="jscolor" value="<?php if(get_option('product_title_color')!=NULL){ echo esc_attr( get_option('product_title_color') ); } else { echo "fff"; } ?>"><br /><br />
    Font Color: <input name="font_color" class="jscolor" value="<?php if(get_option('font_color')!=NULL){ echo esc_attr( get_option('font_color') ); } else { echo "fff"; } ?>">-->
    
    
    <?php submit_button(); ?>
    
	</form>
    
    
<?php

} 

function htg_dynamic_grid(){

	wp_enqueue_style( 'hexa-css', plugins_url( '/assets/hexagons.css', __FILE__ ) );
	wp_enqueue_style( 'hexa-css-2', 'https://maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css' );

	$team = get_posts(array("post_type"=>"wct_team", "posts_per_page"=>get_option('num_prod')));
	
	//echo get_option('num_prod');
	
?>

<ul id="hexGrid">
	
    <?php foreach($team as $one){ ?>
    <?php
		$custom = get_post_custom($one->ID);
		$position = $custom["wct_position"][0];
		$facebook = $custom["wct_facebook"][0];
		$twitter = $custom["wct_twitter"][0];
		$linkedin = $custom["wct_linkedin"][0];
		$instagram = $custom["wct_instagram"][0];
		
		$post_array = get_post($one->ID);
	?>
      <li class="hex">
        <div class="hexIn">
          <div class="hexLink" href="#">
            <img src="<?php echo get_the_post_thumbnail_url($one->ID); ?>" alt="" />
            <h1><?php echo get_the_title($one->ID); ?></h1>
            <p>
            	<?php if($facebook!=NULL){ ?><a href="<?php echo esc_url($facebook); ?>" class="social-icon fa fa-facebook"></a><?php } ?>
            	<?php if($twitter!=NULL){ ?><a href="<?php echo esc_url($twitter); ?>" class="social-icon fa fa-twitter"></a><?php } ?>
                <?php if($linkedin!=NULL){ ?><a href="<?php echo esc_url($linkedin); ?>" class="social-icon fa fa-linkedin"></a><?php } ?>
                <?php if($instagram!=NULL){ ?><a href="<?php echo esc_url($instagram); ?>" class="social-icon fa fa-instagram"></a><?php } ?>
                
            	<span><?php if($post_array->post_content!=NULL){echo substr(esc_html(__($post_array->post_content, "")), 0, 100)."..."; } ?></span>
            </p>
          </div>
        </div>
      </li>
    <?php } ?>
      
    </ul>
    
    <style>
		.hex h1, .hex p {
			background-color: <?php if(get_option('background_color')!=NULL){ echo esc_attr( get_option('background_color') ); } else { echo "0066FF"; } ?> !important;
			opacity:0.8;
		}
	</style>


<?php

}

add_shortcode( 'wct_team_grid', 'htg_dynamic_grid' );


function wct_pagination($offset, $paged) {
	?>
    <div class="wct_pagination">
        <?php if($paged>1){ ?><a href="<?php echo get_permalink(); ?>/page/<?php echo $paged-1; ?>"><span>Prev</span></a><?php } ?>
        <!--<span class="active">1</span>
       	<a href=""><span>2</span></a>
        <span>...</span>
        <a href=""><span>10</span></a>-->
        <a href="<?php echo get_permalink(); ?>/page/<?php echo $paged+1; ?>"><span>Next</span></a>
    </div>
    <?php
}