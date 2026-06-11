<?php

get_header();

	$show_default_title = get_post_meta( get_the_ID(), '_et_pb_show_title', true );

	$is_page_builder_used = et_pb_is_pagebuilder_used( get_the_ID() );

	//VARIAVEIS DE IMAGENS, CATEGORIAS E DATA
	$date = get_the_date('M-d-Y', get_the_ID());
	$featured_image=WP_get_attachment_image_src(get_post_thumbnail_id(get_the_id() ),'single-post-thumbnail');
	$categories = get_the_category($post->ID);
	$author_name  = get_the_author_meta('display_name', $post->post_author);
	// $author_avatar  = get_avatar_url( get_the_author_meta( $post->post_author ), 32 );
	// $picture = get_the_author_meta('author_profile_picture', $post->post_author);
	$url = get_permalink($post->ID);
	$url = esc_url($url);
	$url = urlencode($url);

?>

<div id="main-content">
	<main class="blog-post">
		<section class="featured-image"
			style="background-image: url('<?php echo $featured_image[0] ?>');">

		</section>
		<?php get_template_part('content/blog/content','categories'); ?>

		<section class="blog-section">
			<div class="container">
				<div class="blog-post">
					<div class="row">
						<div class="col-sm-2">
							<div class="share">
								<ul>
										<li><a target='_blank' href="https://www.facebook.com/sharer/sharer.php?u=<?php echo $url;?>&t=<?php the_title();?>"><i class="fa-brands fa-facebook"></i></a></li>
										<li><a target='_blank' href="https://www.linkedin.com/shareArticle?mini=true&url=<?php echo $url;?>&title=<?php the_title();?>&summary=<?php the_excerpt();?>"><i class="fab fa-linkedin-in"></i></a></li>
										<li><a target='_blank' href="https://twitter.com/share?url=<?php echo $url;?>&title=<?php the_title();?>"><i class="fab fa-twitter"></i></a></li>
										<li><a target='_blank' href="whatsapp://send?text=<?php echo $url;?>"><i class="fab fa-whatsapp"></i></a></li>
								</ul>
							</div>
						</div>
						<div class="col-sm-10">
							<div class="post-header">
								<div class="row">
									<div class="col-sm-2">
											<div class="date">
													<?php echo $date; ?>
											</div>
									</div>
									<div class="col-sm-3">
											<div class="time">
													Reading time 2min
											</div>
									</div>
									<div class="col-sm-2" style="display:none;">
											<div class="author">
												<?php echo $author_name; ?>
											</div>
									</div>
									<div class="col-sm-5">
											<?php 
												foreach($categories as $cat_carrossel):
														$category_link = get_category_link( $cat_carrossel->cat_ID );
											?>
												<div class="category">
													<?php echo $cat_carrossel->name; ?>
												</div>
											<?php 
												endforeach;
											?>
									</div>
								</div>
							</div>
							<div class="post-title">
									<h1><?php the_title(); ?></h1>
							</div>
							<div class="post-body">
									<?php the_content() ?>
							</div>
						</div>
					</div>
				</div>
			</div>
		</section>

		<section class="related-post">
			<div class="container">
				<div class="row">
						<div class="col-sm-12">
								<h2><span>RELATED ARTICLES</span></h2>
						</div>
				</div>
				<div class="related-post-wrapper">
					<div class="row">

						<?php
							$args = array('category__in'   => wp_get_post_categories( $post->ID ),'posts_per_page' => 3, 'post_type' =>  'post','post__not_in'   => array( $post->ID ) ); 
							$postslist = get_posts( $args ); 
							foreach ($postslist as $post) :  setup_postdata($post); 
								$has_image = false;
								if (has_post_thumbnail( $post->ID ) ):
									$has_image = true;
									$featured_image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'single-post-thumbnail' );
								endif;

								// $categories = get_the_category( $post->ID );
								// $author  = get_the_author_meta('display_name', $post->post_author);
								// $date = get_the_date('j \d\e F \d\e Y', get_the_ID());
						?>


						<div class="col-sm-4 item">
								<div class="box-image">
										<img src="<?php echo $featured_image[0] ?>" class="img-fluid">
								</div>
								<div class="content-wrapper">
										<h3><?php the_title() ?></h3>
								</div>
								<div class="read-more">
										<a href="<?php the_permalink() ?>">+ read more</a>
								</div>
						</div>

						<?php endforeach; ?> 
					</div>
				</div>
				<div class="see-all">
						<a href="<?php echo get_category_link( wp_get_post_categories( $post->ID ) ); ?>" class="cta pink">See more related articles</a>
				</div>
			</div>
		</section>
	</main>
</div>

<?php

get_footer();
