<?php
/*
	Plugin Name:Popular Posts Views
	Plugin URI:http://mdnesarmridha.com/plugins/popular-posts-views/
	Author:MD NESAR MRIDHA
	Author URI:https://www.facebook.com/md.nesar.mridha.165
	Version:1.0
	Description:This plugin use popular posts views In shortcode [popular_posts_views] and popular posts views count.
 */
//Enqueue Style for Plugin
function mdppv_script(){
	wp_enqueue_style('mdppv-main-css',plugins_url( '/css/style.css', __FILE__ ));
}
add_action('wp_enqueue_scripts','mdppv_script');

//Register Shortcode
function more_display_popular_post_views($attrs,$content=NULL){
	ob_start();
	extract(shortcode_atts(array(
		'pcount'	=>3,
		'ccount'		=>10,
	),$attrs));
	if(function_exists('the_views')):
	?>
	<!--Popular post view area-->
	<div class="popular-post-view-area">
	<?php
		if (function_exists('the_views')){
			$more_count = 'views';
		}else{
			$more_count = 'more_views';
		}
		$show_post = new WP_Query(array(
			'posts_per_page' =>$pcount,
			'post_type'		=>'post',
			'order'			=>'DESC',
			'meta_key'		=>$more_count,
			'orderby'		=>'meta_value_num',

		));

		if($show_post->have_posts()):while($show_post->have_posts()):$show_post->the_post();

		?>
			<h2><?php the_title();?><span>(<?php if(function_exists('the_views')) { the_views(); }else{echo get_post_meta(get_the_ID(),'more_views',true);} ?>)</span></h2>
			<p><?php echo wp_trim_words(get_the_content(),$ccount,NULL);?></p>

		<?php endwhile;endif;?>
	</div><!--/Popular post view area-->
	<?php else:?>
		<p>Please install this Plugin <a href="https://wordpress.org/plugins/wp-postviews/" target="_blank">WP-PostViews</a></p> for work.
		<?php endif;?>
	<?php
	return ob_get_clean();
}
add_shortcode('popular_posts_views','more_display_popular_post_views');

