<?php
    get_header();
?>

<section id="primary" class="site-blog-content">
    <div id="page-title" class="page-title-block page-title-alignment-center">
        <div class="container">
            <div class="page-title-title">
                <h1><?php echo single_cat_title(); ?></h1>
            </div>
        </div>
        <div class="breadcrumbs-container">
            <div class="container">
                <div class="breadcrumbs">
                    <?php echo get_breadcrumb(); ?>
                </div>
            </div>
        </div>
    </div>

    <div class="block-content">
        <div class="panel row">
            <div class="panel-center col-xs-12">
                <?php
                    // The Loop
                    $i = 1;
                    while ( have_posts() ) : the_post(); 
                
                    $featured_image = WP_get_attachment_image_src(get_post_thumbnail_id($post->ID),'full');
                ?>
                <article id="post-<?php the_ID(); ?>" class="post type-post status-publish format-standard">
                    <div class="item-post-container">
                    <div class="item-post clearfix">
                        <div class="post-image">
                            <a href="<?php the_permalink() ?>">
                                <img src="<?php echo $featured_image[0]; ?>">
                            </a>
                        </div>

                        <div class="post-meta date-color">
                            <div class="entry-meta clearfix gem-post-date">
                                <div class="post-meta-right">
                                    <span class="comments-link"><?php comments_popup_link(0, 1, '%'); ?></span>
                                    <?php //echo $post->comment_count; ?>
                                </div>
                                <div class="post-meta-left">
                                    <span class="post-meta-author"> By <?php the_author_posts_link() ?></span>
                                    <?php 
                                    $categories = wp_get_post_categories( $post->ID, array( 'fields' => 'all' ) );
                                    ?>
                                        <span class="post-meta-categories">
                                            <?php foreach($categories as $category) {
                                                    if( wp_is_mobile() ){ 
                                                        echo '<a href="' . get_category_link($category->term_id) . '">' . $category->name . '</a>';
                                                    } else {
                                                        echo '| <a href="' . get_category_link($category->term_id) . '">' . $category->name . '</a>';
                                                    }
                                                }
                                            ?>
                                        </span>
                                </div>
                            </div>
                        </div>
                        
                        <div class="post-title">
                            <h3 class="entry-title"><a href="<?php the_permalink() ?>"><?php echo get_the_date('d M'); ?>: <span class=""><?php the_title(); ?></span></a></h3>
                        </div>
                        
                        <div class="post-text">
                            <div class="summary">
                                <?php the_excerpt(); ?>
                            </div>
                        </div>

                        <div class="post-footer">
                            <div class="post-footer-sharing" data-div="blog-<?php echo $i; ?>">
                                <div class="sharing-popup">
                                    <div class="socials-sharing socials">
                                        <a class="socials-item" target="_blank" href="https://www.facebook.com/sharer/sharer.php?u=<?php echo esc_url( get_permalink() ); ?>" title="Facebook"><i class="fa-brands fa-facebook-f"></i></a>
                                        <a class="socials-item" target="_blank" href="https://twitter.com/intent/tweet?text=<?php echo esc_html( get_the_title() ); ?>&url=<?php echo esc_url( get_permalink() ); ?>" title="Twitter"><i class="fa-brands fa-twitter"></i></a>
                                        <a class="socials-item" target="_blank" href="https://plus.google.com/share?url=<?php echo esc_url( get_permalink() );?>" title="Google Plus"><i class="fa-brands fa-google-plus-g"></i></a>
                                        <a class="socials-item" target="_blank" href="https://www.pinterest.com/pin/create/button/?url=<?php echo esc_url( get_permalink() );?>&description=<?php echo esc_html( get_the_title() ); ?>&media=<?php echo $featured_image[0]; ?>" title="Pinterest"><i class="fa-brands fa-pinterest-p"></i></a>
                                        <a class="socials-item" target="_blank" href="http://tumblr.com/widgets/share/tool?canonicalUrl=<?php echo esc_url( get_permalink() );?>" title="Tumblr"><i class="fa-brands fa-tumblr"></i></a>
                                        <a class="socials-item" target="_blank" href="https://www.linkedin.com/shareArticle?mini=true&url=<?php echo esc_url( get_permalink() ); ?>&title=<?php echo esc_html( get_the_title() ); ?>&summary=&source=<?php echo esc_url( get_site_url() ); ?>" title="LinkedIn"><i class="fa-brands fa-linkedin-in"></i></a>
                                        <a class="socials-item" target="_blank" href="https://www.stumbleupon.com/submit?url=<?php echo esc_url( get_permalink() ); ?>&title=<?php echo esc_html( get_the_title() ); ?>" title="StumbleUpon"><i class="fa-brands fa-stumbleupon"></i></a>
                                    </div>
                                    <svg class="sharing-styled-arrow"><use xlink:href="https://zurich.optimumhost.me/wp-content/uploads/2023/09/post-arrow.svg#dec-post-arrow"></use></svg>
                                </div>
                                <div class="social-share-button">
                                    <a href="javascript:void(0)" class="socialShare"><i class="fa-solid fa-square-share-nodes"></i></a>
                                </div>                  
                            </div>
                            <div class="post-read-more"><a href="<?php the_permalink() ?>">Read More</a></div>
                        </div>
                    </div>
                    </div>
                </article>
                <?php $i++; endwhile;  ?>
            </div>
        </div>
    </div>
</section>

<?php
    get_footer();
?>