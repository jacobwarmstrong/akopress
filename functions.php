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
    
    //I have bootstrap on all pages for now.. EXCEPT OUR WOOCOMMERCE PAGES AND CHECKOUT
    if( is_checkout() == false ) {
		wp_enqueue_style( 'bootstrap-style', "https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" );
	}
        
    
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

function ako_signs_custom_post_types() {
  register_post_type( 'sign-products',
    array(
      'labels' => array(
        'name' =>  'Sign Products' ,
        'singular_name' => 'Sign Product' 
      ),
      'public' => true,
      'has_archive' => false,
      'show_in_rest' => true,
      'supports' => array( 'title', 'editor', 'thumbnail')
    )
  );
}
add_action( 'init', 'ako_signs_custom_post_types' );

// add categories for attachments
function add_categories_for_attachments() {
    register_taxonomy_for_object_type( 'category', 'attachment' );
}
add_action( 'init' , 'add_categories_for_attachments' );

// add tags for attachments
function add_tags_for_attachments() {
    register_taxonomy_for_object_type( 'post_tag', 'attachment' );
}
add_action( 'init' , 'add_tags_for_attachments' );

//charmer specific img html output for gallery
function charmer_get_attachment_link($post_id, $tag = null) {
    //use wordpress functions to get our img info
    $img['src'] = wp_get_attachment_image_src($post_id, 'sign-gallery')[0];
    $img['title'] = get_the_title($post_id);
    $img['alt'] = get_post_meta($post_id, '_wp_attachment_image_alt', true);
    $img['uri'] = get_permalink($post_id);
    $img['class'] = 'gallery-thumb';
    
    //if tag is in arg, then add it to the uri
    if($tag) {
        $img['uri'] .= '?tag=' . $tag;
    }
    
    //assemble img html
    $html = '<a href="' . $img['uri'] . '">';
    $html .= '<div class="image-info-overlay d-flex justify-content-center align-items-center"><h3>'. $img['title']. '</h3></div>';
    $html .= '<img class="' . $img['class'] .'" src="' . $img['src'] . '" ';
    $html .= '"alt="' . $img['alt'] . '">';
    $html .= '</a>';
    
    //output img html to frontend
    echo $html;
}

// Get array of all sign products
function get_sign_products() {
    $args = [
        'numberposts' => -1,
        'post_type' => 'sign-products',
        'orderby' => 'title',
        'order' => 'ASC'
    ];
    
    $sign_products = get_posts($args);
    return $sign_products;
}

function get_gallery_images($category = null, $tag = null) {
    if (isset($category)) {
        $categoryList = $category;
    } else {
        $slugs = [];
        $sign_products = get_sign_products();
        foreach($sign_products as $sign_product) {
            array_push($slugs, $sign_product->post_name);
        }
        $categoryList = implode(',', $slugs);
    }
    //create args based on tag input or not
    $args = array('post_type' => 'attachment', 'post_status' => 'inherit', 'category_name' => $categoryList, 'numberposts' => -1 );
    //if tag is added, add to query arguments
    if( $tag != null ) {
        $args['tag_id'] = $tag;
    }
    $images = get_posts($args); 
    if ( $images ) {
        return $images;
    } else {
        // no posts found
    }
}

function get_all_tags_for_posts($posts) {
    $all_tags = [];
    foreach($posts as $post) {
        $post_tags = get_the_tags($post);

        if ($post_tags) {
            foreach($post_tags as $post_tag) {
                $tag = $post_tag->term_id;
                array_push($all_tags, $tag);
            }
        }
    }
    $all_tags = array_unique($all_tags);
    return $all_tags;
}


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

//checks if tag is in GET and either returns the tag value or returns false;
function the_selected_tag() {
    global $_GET;
    if ( isset($_GET['tag']) ) {
        $tag = $_GET['tag'];
        return $tag;
    } else {
        $tag = null;
        return false;
    }
}


//returns the current selected image info in our image lightbox
function get_current_img($id) {
    $current_img = [];
    $current_img['src'] = wp_get_attachment_image_src($id, 'original')[0];
    $current_img['alt'] = get_post_meta($id, '_wp_attachment_image_alt', true);
    return $current_img;
}

function get_order_of_image($images, $id) {
    for($i = 0; $i < count($images); $i++) {
        if($images[$i]->ID == $id) {
            $current_img_order = $i;
            return $current_img_order;
        }
    }
}

function append_tag_to_query($link, $tag) {
    $query = '/?tag=' . $tag;
    $newLink = $link . $query;
    return $newLink;
}

function the_next_image($images, $current_order, $tag = null) {
    if( $current_order < count($images) - 1) {
        $nextImg['image'] = $images[($current_order + 1)];
        $link = get_permalink($nextImg['image']);
        if ($tag) {
            $link .= "?tag=" . $tag;
        }
        $nextImg['link'] = $link;
    } else {
        $nextImg = null;
    }
    return $nextImg;
}

function the_previous_image($images, $current_order, $tag = null) {
        if( $current_order > 0 ) {
            $previousImg['image'] = $images[($current_order - 1)];
            $link = get_permalink($previousImg['image']);
            if ($tag) {
                $link .= "?tag=" . $tag;
            }
            $previousImg['link'] = $link;
        } else {
            $previousImg = null;
        }
    return $previousImg;
}


function setup_lightbox_images($id) {
        $category = get_the_category()[0];
        $the_selected_tag = the_selected_tag();
        $images = get_gallery_images( $category->slug, the_selected_tag() );
        $current_image = get_current_img($id);
        $current_order = get_order_of_image($images, $id);
        $next_image = the_next_image($images, $current_order, $the_selected_tag);
        $previous_image = the_previous_image($images, $current_order, $the_selected_tag);
        $data = ['id' => $id,
              'category' => $category,
              'tags' => get_the_tags(),
              'the_selected_tag' => $the_selected_tag,
              'current_image' => $current_image,
              'next_image' => $next_image,
              'previous_image' => $previous_image
             ];
        return $data;
}
add_filter('filter_images', 'setup_lightbox_images');
