<?php get_header(); ?>

<div id="main-content">
	<div class="blog-container">
		<div id="content-area" class="clearfix">
			<main class="blog-listing">

				<section class="featured-post">
					<div class="row">
					<?php
						$counterFeatured = 0;
						while ( have_posts() ) : the_post();
							if(get_post_type() == 'post') {
								get_template_part('content/blog/content','featured-post');
								$counterFeatured++;
								if ($counterFeatured == 2){
									break;
								}   
							}
						endwhile;
					?>
					</div>
				</section>

				<section class="post-listing">
					<div class="post-wrapper">
						<div class="row">                    
							<?php
								if ( have_posts() ) :
									while ( have_posts() ) : the_post();
									if(get_post_type() == 'post') { ?>
										<div class="col-sm-6 col-md-4 col-lg-3">
											<?php get_template_part('content/blog/content','blog-item'); ?>  
										</div>
									<?php } endwhile;
								endif;       
							?>
						</div>
						<div class="row">
							<div class="col-sm-12 pagination">
							<?php // the_posts_pagination( array(
								// 'mid_size'  => 2,
								// 'prev_text' => __( '< PREV', 'textdomain' ),
								// 'next_text' => __( 'NEXT >', 'textdomain' ),
								// 'screen_reader_text' => __( '&nbsp;' )
							// ) ); ?>
							</div>
						</div>
					</div>
				</section>
		
			</main>
		</div>
	</div>
</div>

<?php

get_footer();
