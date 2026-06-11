<?php 
    if(has_post_thumbnail($post->ID)):
    $featured_image=WP_get_attachment_image_src(get_post_thumbnail_id($post->ID),'single-post-thumbnail');
    endif;

    // $date = get_the_date('j \d\e F \d\e Y', get_the_ID());
    $day = get_the_date('d', get_the_ID());
    $month = get_the_date('M', get_the_ID());
    $year = get_the_date('Y', get_the_ID());
    $categories = get_the_category($post->ID);
    $author_name  = get_the_author_meta('display_name', $post->post_author);
?>
<div class="post-item" style="background-image: url('<?php echo $featured_image[0]; ?>');">
    <div class="date">
        <span><?php echo $month; ?></span>
        <span><?php echo $day; ?></span>
        <span><?php echo $year; ?></span>
    </div>
        <h1><?php the_title() ?></h1>
    <div class="overlay">
        <div class="excerpt-wrapper">
            <div class="excerpt">
                <p><?php the_excerpt(); ?></p>
            </div>
            <div class="read-more text-center">
                <a class="cta white" href="<?php the_permalink() ?>">Read More</a>
            </div>
        </div>
        <div class="post-footer">
            <div class="row">
                <div class="col-sm-6 author">
                    <i class="fas fa-user"></i><span><?php echo $author_name; ?></span>
                </div>
            </div>
        </div> 
    </div>
    
</div>