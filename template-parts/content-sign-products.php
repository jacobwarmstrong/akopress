<?php
/**
 * Template part for displaying page content for the work page and sign product categories
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package charmer
 */

if (is_page('work')) {
    $category = null;
    $selected = 'All Sign Products';
} else {
    $category = $post->post_name;
    $selected = get_the_title();
}

if ( isset($_GET['tag']) ) {
    $tag = $_GET['tag'];
} else {
    $tag = null;
}
$sign_products = get_sign_products();
$images = get_gallery_images($category, $tag);
if(!empty($images)) {
    $tags = get_all_tags_for_posts($images);
}

?>

<header class="entry-header container">
    <span>Sign Product</span>
    <div class="dropdown show mr-5 my-3">
        <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><h2><?php echo $selected; ?></h2></a>
        <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
          <a class="dropdown-item" href="/work">All Sign Products</a>
          <?php
          foreach($sign_products as $sign_product) : ?>
          <a class="dropdown-item" href="<?php echo get_permalink($sign_product); ?>"><?php echo $sign_product->post_title; ?></a>
          <?php endforeach; ?>
        </div>
    </div>
    <?php if( !empty($tags) && $selected != 'All Sign Products' ) : ?>
        <div class="my-2">
            <span>Tags associated with <?php echo $selected; ?>:</span>
            <div class="d-flex flex-row flex-wrap my-2">
                <?php foreach($tags as $tag_id) :
                if($tag_id == $tag) {
                    $tag_class = 'badge-selected';
                } else {
                    $tag_class = 'badge-primary';
                }
                ?>
                <a href="?tag=<?php echo $tag_id; ?>" class="badge badge-pill my-1 <?php echo $tag_class; ?> p-2 mr-3"><?php echo get_tag($tag_id)->name; ?></a>
                <?php endforeach; ?>
            </div>
            <?php if ($tag) : ?>
                <a href="?reset=true" class="btn btn-outline-primary my-2">Reset Tag Filter</a>
            <?php endif; ?>
        </div>
    <?php endif; ?>
</header><!-- .entry-header -->

<div class="container">
    <?php if( !empty($images) ) : ?>
    <div class="charmer-gallery row">
        <?php foreach($images as $image) : ?>
            <div class="col-md-4 image-boundaries">
                <?php charmer_get_attachment_link($image->ID, $tag); ?>
            </div>
        <?php endforeach; ?>
    </div>
    <?php else: ?>
    <div class=" alert alert-info">AKO currently doesn't have any pictures of this product to show off! We blame our web developer.</div>
    <?php endif; ?>
</div><!-- .container -->

<?php if ( get_edit_post_link() ) : ?>

<?php endif; ?>
