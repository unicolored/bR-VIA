<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    bR_VIA
 * @subpackage bR_VIA/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    bR_VIA
 * @subpackage bR_VIA/public
 * @author     Your Name <email@example.com>
 */
class bR_VIA_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $bR_VIA    The ID of this plugin.
	 */
	private $bR_VIA;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $bR_VIA       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $bR_VIA, $version ) {

		$this->br_via = $bR_VIA;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function wp_head() {


		// ...
		$canonical = false;
		$next = false;
		// ...
		$author = "Gilles Hoarau";
		$url = get_bloginfo( 'url' );
		$name = get_bloginfo( 'name' );
		$title = get_the_title();
		$description = get_bloginfo( 'description' );
		$version = wp_get_theme()->Version;
		$currentUrl = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
		$image = ''.$url.'/img/ico/gravatar.'.$version.'.jpg';
		$ogType = 'website';
		$ogArticle = false;
		$ogVideo = false;
		$twVideo = false;
		$ogProfile =
		"\n\t".'<meta property="profile:first_name" content="Gilles" />'.
		"\n\t".'<meta property="profile:last_name" content="Hoarau" />'.
		"\n\t".'<meta property="profile:username" content="Unicolored" />'.
		"\n\t".'<meta property="profile:gender" content="male" />'.
		"\n\t".'<meta property="fb:profile_id" content="https://www.facebook.com/gilles.wonder.hoarau" />';

		// CANONICAL & NEXT
		// CATEGORY
		////////////////////////////////////////////////////////////////////////////
		if ( is_category() ) {
			$catID = get_query_var('cat');
			$title = get_cat_name($catID);
			//$title = $titleSimple.' | '.$description;
			$description = strip_tags(sanitize_text_field(category_description($catID)).' '.$author);

			$currentUrl = get_category_link($catID);
			if ( is_paged() ) {
				//print get_query_var('paged');
				$paged = get_query_var('paged');
				$nextpaged = get_query_var('paged')+1;
				//print $nextpaged;
				$nextUrl = str_replace('page/'.$paged.'/','page/'.$nextpaged.'/',$currentUrl);
			}
			else {
				$nextUrl = $currentUrl.'page/2/';
			}
			$next = "\n\t".'<link rel="next" href="'.$nextUrl.'" />';
		}
		// SINGLE
		////////////////////////////////////////////////////////////////////////////
		if ( is_single() ) {
			// DESCRIPTION /////
			$p = get_post();
			$description = esc_html(wp_strip_all_tags($p->post_content,true));
			$description = substr($description,0,256).'&hellip;';
			// IMAGE ////
			// G+ image 800x1200;
			$attachment = wp_get_attachment_image_src( get_post_thumbnail_id(), 'medium' );
			$image = $attachment[0];
			// VIDEO /////
			$meta_videoCode = get_post_meta(get_the_ID(),'videoCode',true);
			if ( $meta_videoCode != "" ) {
				$videoUrl = 'https://www.youtube.com/embed/'.$meta_videoCode;
				$ogVideo = "\n\t".'<meta property="og:video:url" content="'.$videoUrl.'" />';
				$twVideo = "\n\t".'<meta name="twitter:player" content="'.$videoUrl.'"/>';
			}
			// TYPE ARTICLE /////
			$ogType = 'article';
			// Tags
			$posttags = get_the_tags();
			$tags ="";
			if ($posttags) {
				foreach($posttags as $tag) { $tags .= "\n\t".'<meta property="article:tags" content="'.$tag->name.'" />'; }
			}
			// Category
			$categories = get_the_category();
			$cats ="";
			$section = false;
			foreach($categories as $cat) {
				if ( $cat->category_parent != 0 ) {
					$section = $cat->name;
				}
			  if ( $section != "" ) {
					$section = $cat->name;
				}
			}
			$articleSection = $section != "" ? "\n\t".'<meta property="article:section" content="'.$section.'" />' : false;
			$ogArticle =
			"\n\t".'<meta property="article:published_time" content="'.get_the_date('Y-m-d').'" />'.
			"\n\t".'<meta property="article:published_time" content="'.get_the_modified_date('Y-m-d').'" />'.
			"\n\t".'<meta property="article:author" content="Gilles Hoarau" />'.
			$articleSection.
			$tags
			;
		}
	//////////////////////////////////////////////////////////////////////////////
	$canonical = sprintf("\n\t".'<link rel="canonical" href="%s" />',$currentUrl);

// PRINT

		print '<!-- br-via. -->'.
//"\n\t".'<title>'.$title.'</title>'.
"\n\t".'<meta name="description" content="'.$description.'">'.
"\n\t".'<link rel="image_src" href="'.$image.'" />'.
$canonical.
$next.
"\n\t".'<meta name="author" content="'.$author.'" />'.
"\n".
"\n\t".'<link rel="shortcut icon" href="'.$url.'/img/ico/favicon.'.$version.'.ico" />'.
"\n\t".'<link rel="apple-touch-icon-precomposed" sizes="144x144" href="'.$url.'/img/ico/144.'.$version.'.png" />'.
"\n".
"\n\t".'<link rel="alternate" type="application/rss+xml" title="Flux du site GillesHoarau.com" href="https://feeds.feedburner.com/gilleshoarau" />'.
"\n\t".'<link rel="shortlink" href="https://bit.ly/GillesH" />'.
"\n".
"\n".'<!-- Facebook -->'.
"\n\t".'<meta property="og:title" content="'.$title.'" />'.
"\n\t".'<meta property="og:description" content="'.$description.'" />'.
"\n\t".'<meta property="og:site_name" content="'.$name.'" />'.
"\n\t".'<meta property="og:url" content="'.$url.'" />'.
"\n\t".'<meta property="og:image" content="'.$image.'" />'.
"\n\t".'<meta property="og:locale" content="fr_FR" />'.
"\n\t".'<meta property="og:type" content="'.$ogType.'" />'.
$ogArticle.
$ogVideo.
$ogProfile.
"\n".
"\n".'<!-- Twitter -->'.
"\n\t".'<meta name="twitter:domain" content="'.$name.'"/>'.
"\n\t".'<meta name="twitter:title" content="'.$title.'"/>'.
"\n\t".'<meta name="twitter:description" content="'.$description.'"/>'.
"\n\t".'<meta name="twitter:site" content="@gilleshoarau"/>'.
"\n\t".'<meta name="twitter:site:id" content="603495197"/>'.
"\n\t".'<meta name="twitter:creator" content="@unicolored"/>'.
"\n\t".'<meta name="twitter:creator:id" content="603495197"/>'.
"\n\t".'<meta name="twitter:card" content="summary"/>'.
"\n\t".'<meta name="twitter:image" content="'.$image.'"/>'.
$twVideo.
"\n".
"\n".'<!-- Google+ -->'.
"\n\t".'<link rel="publisher" href="https://plus.google.com/+GillesHoarau1337"/>'.
"\n\t".'<meta itemprop="name" content="'.$title.'">'.
"\n\t".'<meta itemprop="description" content="'.$description.'">'.
"\n\t".'<meta itemprop="image" content="'.$image.'">'.
"\n".
"\n\t".'<script type="application/ld+json">{"@context":"http:\/\/schema.org","@type":"WebSite","url":"http:\/\/gilleshoarau.com\/","name":"GillesHoarau.com","alternateName":"Gilles Hoarau","potentialAction":{"@type":"SearchAction","target":"http:\/\/gilleshoarau.com\/?s={search_term}","query-input":"required name=search_term"}}</script>'.
"\n\t".'<script type="application/ld+json">{"@context":"http:\/\/schema.org","@type":"Person","url":"http:\/\/gilleshoarau.com","sameAs":["https:\/\/instagram.com\/gilleswonder\/","https:\/\/www.linkedin.com\/profile\/view?id=49193987","https:\/\/plus.google.com\/+GillesHoarau1337","https:\/\/www.youtube.com\/channel\/UClEDZEdssRgZtxi7dFvcqfQ","https:\/\/www.pinterest.com\/gilleshoarau\/","https:\/\/twitter.com\/gilleshoarau"],"name":"Gilles Hoarau"}</script>'.
"\n".
'<!-- / br-via. -->'.
"\n\n";

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in bR_VIA_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The bR_VIA_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		//wp_enqueue_style( $this->br_via, plugin_dir_url( __FILE__ ) . 'css/br-via-public.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in bR_VIA_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The bR_VIA_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		//wp_enqueue_script( $this->br_via, plugin_dir_url( __FILE__ ) . 'js/br-via-public.js', array( 'jquery' ), $this->version, false );

	}

}
