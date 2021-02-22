<?php

if ( ! defined( '_S_VERSION' ) ) {
	// Replace the version number of the theme on each release.
	define( '_S_VERSION', '1.0.0' );
}

function akopress_scripts() {
    
    //update jquery to 3.1.1
    //required for custom image gallery. Consider dumping because generate press is against jquery apparantly
    wp_deregister_script('jquery');
	wp_enqueue_script('jquery', 'https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js', array(), null, true);
    
    wp_enqueue_script( 'navbar.js', get_stylesheet_directory_uri() . '/js/navbar.js', array('jquery'), '1.0.0', true);
    
    wp_enqueue_style( 'google-fonts-style', "https://fonts.googleapis.com/css2?family=Source+Sans+Pro:wght@900&display=swap" );
    
    //I have bootstrap on all pages for now..
        wp_enqueue_style( 'bootstrap-style', "https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" );
    
    //bootstrap gallery related enqueues
    if ( get_post_type() == 'attachment' ) {
        wp_enqueue_script( 'charmer-image-spinner', get_stylesheet_directory_uri() . '/js/image-loading-spinner.js', array('jquery'), _S_VERSION, true );
    }
    
    wp_enqueue_script( 'bootstrap-js-popper', "https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js", array('jquery'), _S_VERSION, true );
        
    wp_enqueue_script( 'bootstrap-js', "https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js", array('jquery'), _S_VERSION, true );
    
    if ( get_post_type() == 'attachment' ) {
        wp_enqueue_script( 'charmer-image-lightbox-hover', get_stylesheet_directory_uri() . '/js/image-lightbox.js', array('jquery'), _S_VERSION, true );
    }
    
    if ( get_post_type() == 'sign-products' || get_the_title() == 'Work' ) {
        wp_enqueue_script( 'charmer-thumbnail-scale', get_stylesheet_directory_uri() . '/js/thumbnail-scale-on-hover.js', array('jquery'), _S_VERSION, true );
    }

}

add_action('wp_enqueue_scripts', 'akopress_scripts');

add_action('wp_head', 'google_analytics_head', 20);
function google_analytics_head() {
    ?>
    <!-- Google Tag Manager -->
    <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
    new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
    j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
    'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
    })(window,document,'script','dataLayer','<?php echo GOOGLE_TAG_MANAGER_TRACKING_KEY; ?>');</script>
    <!-- End Google Tag Manager -->
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=<?php echo GOOGLE_ANALYTICS_TRACKING_KEY; ?>"></script>
    <script>
      window.dataLayer = window.dataLayer || [];
      function gtag(){dataLayer.push(arguments);}
      gtag('js', new Date());

      gtag('config', '<?php echo GOOGLE_ANALYTICS_TRACKING_KEY; ?>');
    </script>
    <?php
}

add_action('wp_body_open', 'google_tag_manager_body', 20);
function google_tag_manager_body() { ?>
    <!-- Google Tag Manager (noscript) -->
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=<?php echo GOOGLE_TAG_MANAGER_TRACKING_KEY; ?>"
    height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
    <!-- End Google Tag Manager (noscript) -->
    <?php
}
