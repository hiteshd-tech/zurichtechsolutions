<?php
function my_theme_enqueue_styles() { 
    wp_enqueue_style( 'parent-style', get_template_directory_uri() . '/style.css' );
    
    wp_enqueue_style( 'slick-theme-style', get_stylesheet_directory_uri() . '/css/slick-theme.css', array( 'parent-style' ) );
    wp_enqueue_style( 'slick-style', get_stylesheet_directory_uri() . '/css/slick.css', array( 'parent-style' ) );
    wp_enqueue_style( 'home-style', get_stylesheet_directory_uri() . '/css/home.css', array( 'home-style' ) );
    wp_enqueue_style( 'service-style', get_stylesheet_directory_uri() . '/css/service.css', array( 'service-style' ) );
    wp_enqueue_style( 'custom-style', get_stylesheet_directory_uri() . '/css/custom_style.css', array( 'custom-style' ) );

    wp_enqueue_script('slick-main', get_stylesheet_directory_uri() . '/js/slick.js', array('jquery'), true);
    wp_enqueue_script('slick-min-main', get_stylesheet_directory_uri() . '/js/slick.min.js', array('jquery'), true);
    wp_enqueue_script('custom-jquery', get_stylesheet_directory_uri().'/js/custom.js', array('jquery'), true);
}
add_action( 'wp_enqueue_scripts', 'my_theme_enqueue_styles' );

// remove defualt Projects CPT
function remove_divi_projects(){
    unregister_post_type( 'project' );
}
add_action('init','remove_divi_projects');

// Load custom Blog Module start
function divi_custom_blog_module() { 
    get_template_part( '/includes/Blog' ); 
    $dcfm = new custom_ET_Builder_Module_Blog(); 
    remove_shortcode( 'et_pb_blog' ); 

    add_shortcode( 'et_pb_blog', array( $dcfm, '_shortcode_callback' ) );
} 
add_action( 'et_builder_ready', 'divi_custom_blog_module' ); 

function divi_custom_blog_class( $classlist ) { 
    // Blog Module 'classname' overwrite. 
    $classlist['et_pb_blog'] = array( 'classname' => 'custom_ET_Builder_Module_Blog',); 
    return $classlist; 
} 
add_filter( 'et_module_classes', 'divi_custom_blog_class' );
// Load custom Blog Module end

// Homepage manufacture slider start
function manufacture_slider( $atts ) {
    ob_start();
    $args = array(
        'post_type'   => array( 'zurich_client' ),
        'post_status' => array( 'publish' ),
        'order'       => 'DESC',
        'orderby'     => 'id',
    );

    // The Query
    $zurich_client_slider = new WP_Query( $args );
    echo '<div class="zurich_client_slider_wrapper">';
    // The Loop
    if ( $zurich_client_slider->have_posts() ) {
        while ( $zurich_client_slider->have_posts() ) {
            $zurich_client_slider->the_post();
            $client_slider_img = get_post_meta( get_the_ID(), '_thumbnail_id', true );
            if ( ! empty( $client_slider_img ) ) {
                $client_slider_img_url = wp_get_attachment_url( $client_slider_img );
                echo '<img src="'.$client_slider_img_url.'" class="client_cpt_slider_img">';
            }
        }
    }
    echo '</div>';

    wp_reset_postdata();
    return ob_get_clean();
}
add_shortcode( 'manufacture_slider', 'manufacture_slider' );
// Homepage manufacture slider end

// our services grid start [our_services_grid_hp_sc post_type="" taxonomy="" terms="" posts_per_page=""]
function our_services_grid_hp_sc( $atts ) {
    ob_start();

    extract( shortcode_atts( array(
        'posts_per_page'    => '',
        'post_type'         => '',
        'taxonomy'          => '',
        'terms'             => '',
    ), $atts, 'our_services_grid_hp_sc' ) );

    $args = array(
        'post_type'      => $post_type,
        'post_status'    => array( 'publish' ),
        'tax_query'      => array(
                                array(
                                    'taxonomy'  => $taxonomy,
                                    'field'     => 'slug',
                                    'terms'     => $terms,
                                )
                            ),
        'order'          => 'DESC',
        'orderby'        => 'id',
        'posts_per_page' => $posts_per_page,
    );

    // The Query
    $our_services = new WP_Query( $args );

    echo '<div class="our_services_wrapper container">';
    // The Loop
    if ( $our_services->have_posts() ) {
        while ( $our_services->have_posts() ) {
            $our_services->the_post();
            $service_title = get_the_title();
            if( have_rows('description_link') ):
                while( have_rows('description_link') ): the_row();
                    $description            = get_sub_field( 'description' );
                    $link                   = get_sub_field( 'link' );
                    $button_text            = get_sub_field( 'button_text' );
                    $link_target            = get_sub_field( 'link_target' );
                    
                    if('Blank' == $link_target['value']){
                        $link_target = '_blank';
                    } else {
                        $link_target = '_self';
                    }
                endwhile;
            endif;

            if( have_rows('colors') ):
                while( have_rows('colors') ): the_row();
                    $title_text_color       = get_sub_field( 'title_text_color' );
                    $description_text_color = get_sub_field( 'description_text_color' );
                endwhile;
            endif;
                    
            if( have_rows('icon') ):
                while( have_rows('icon') ): the_row();
                    $icon_code              = get_sub_field( 'icon_code' );
                    $icon_background_color  = get_sub_field( 'icon_background_color' );
                    $icon_border_color      = get_sub_field( 'icon_border_color' );
                    $icon_color             = get_sub_field( 'icon_color' );
                    $icon_color_2           = get_sub_field( 'icon_color_2' );
                    $icon_shape             = get_sub_field( 'icon_shape' );
                    $icon_size              = get_sub_field( 'icon_size' );
                endwhile;
            endif;

            echo '<div class="our_service_grid column">';
                echo '<a href="'.$link.'" target="'.$link_target.'">';
                    echo '<div class="icon_wrapper" style="background-color:'.$icon_background_color.';border: 2px solid '.$icon_border_color.';border-radius: 25px;width: 45px;height: 45px;">';
                        echo '<span style="color:'.$icon_color.'">'.$icon_code.'</span>';
                    echo '</div>';
                    echo '<div class="content_wrapper">';
                        echo '<h3 style="color:'.$title_text_color.'">'.$service_title.'</h3>';
                        echo '<p style="color:'.$description_text_color.'">'.$description.'</p>';
                    echo '</div>';
                echo '</a>';
                
            echo '</div>';
        }
    }
    echo '</div>';

    wp_reset_postdata();
    return ob_get_clean();
}
add_shortcode( 'our_services_grid_hp_sc', 'our_services_grid_hp_sc' );

// our services grid start

// testimonials slider start
function testimonials_slider( $atts ) {
    ob_start();
    $args = array(
        'post_type'   => array( 'zurich_testimonial' ),
        'post_status' => array( 'publish' ),
        'order'       => 'DESC',
        'orderby'     => 'id',
    );

    // The Query
    $testimonials_slider = new WP_Query( $args );
    echo '<div class="testimonials_slider_wrapper">';
    // The Loop
    if ( $testimonials_slider->have_posts() ) {
        while ( $testimonials_slider->have_posts() ) {
            $testimonials_slider->the_post();

            if( have_rows('testimonials_settings') ):
                while( have_rows('testimonials_settings') ): the_row();
                    $name = get_sub_field( 'name' );
                    $company = get_sub_field( 'company' );
                    $position = get_sub_field( 'position' );
                    $link = get_sub_field( 'link' );
                    $link_target = get_sub_field( 'link_target' );
                endwhile;
            endif;
            echo "<div class='testimonials_inner_wrap'>";
            echo "<span>".$name."</span>";
            echo the_content();
            echo "</div>";
        }
    }
    echo '</div>';

    wp_reset_postdata();
    return ob_get_clean();
}
add_shortcode( 'testimonials_slider', 'testimonials_slider' );
// testimonials slider end

// team shortocde start [team_list_sc post_type="zurich_team_person" taxonomy="zurich_teams" terms="executives" posts_per_page="2" style="grid"]
function team_list_sc( $atts ) {
    ob_start();

    extract( shortcode_atts( array(
        'posts_per_page'    => '',
        'post_type'         => '',
        'taxonomy'          => '',
        'terms'             => '',
        'style'             => '',
    ), $atts, 'team_list_sc' ) );

    $args = array(
        'post_type'      => $post_type,
        'post_status'    => array( 'publish' ),
        'tax_query'      => array(
                                array(
                                    'taxonomy'  => $taxonomy,
                                    'field'     => 'slug',
                                    'terms'     => $terms,
                                )
                            ),
        'order'          => 'DESC',
        'orderby'        => 'id',
        'posts_per_page' => $posts_per_page,
    );

    // The Query
    $team = new WP_Query( $args );

    echo '<div class="team_wrapper '.$style.'">';
    // The Loop
    if ( $team->have_posts() ) {
        $count = 0;
        while ( $team->have_posts() ) {
            $team->the_post();
            $team_person_title = get_the_title();
            $team_person_content = get_the_content();
            if( have_rows('person_settings') ):
                while( have_rows('person_settings') ): the_row();
                    $name           = get_sub_field( 'name' );
                    $position       = get_sub_field( 'position' );
                    $phone          = get_sub_field( 'phone' );
                    $email          = get_sub_field( 'email' );
                    $hide_email     = get_sub_field( 'hide_email' ); // true/false
                    $link           = get_sub_field( 'link' );
                    $link_target    = get_sub_field( 'link_target' );
                    $social_profile = get_sub_field( 'social_profile' ); // group

                    // if('Blank' == $link_target['value']){
                    //     $link_target = '_blank';
                    // } else {
                    //     $link_target = '_self';
                    // }
                    
                    if( have_rows('social_profile') ):
                        while( have_rows('social_profile') ): the_row();
                            $facebook_profile       = get_sub_field( 'facebook_profile' );
                            $google_plus_profile    = get_sub_field( 'google_plus_profile' );
                            $twitter_profile        = get_sub_field( 'twitter_profile' );
                            $linkedin_profile       = get_sub_field( 'linkedin_profile' );
                            $instagram_profile      = get_sub_field( 'instagram_profile' );
                            $skype_profile          = get_sub_field( 'skype_profile' );
                        endwhile;
                    endif;
                    
                endwhile;
            endif;

            echo '<div class="team_member '.(++$count%2 ? "odd" : "even").'">';
                echo '<div class="team_inner_wrapper">';
                    echo '<div class="team_img_wrap">';
                        $featured_img_url = get_the_post_thumbnail_url(get_the_ID(),'full');
                        if (empty($link)) {
                            $link = 'javascript:(void);';
                        }
                        echo '<a href="'.$link.'" target="'.$link_target.'"><img src="'.$featured_img_url.'"></a>';
                    echo '</div>';
                    echo '<div class="team_info_wrap">';
                        echo '<h4>'.$name.'</h4>';
                        echo '<span>'.$position.'</span>';

                        if( 'list' == $style) {
                            echo '<p>'.$team_person_content.'</p>';
                        }

                        if(!empty($phone) || !empty($email)){
                            echo '<div class="team_meta">';
                                if (!empty($phone)) {
                                    echo '<span class="et_phone_meta"><i class="fa-solid fa-phone"></i> '.$phone.'</span>';
                                }

                                if (!empty($email)) {
                                    echo '<span class="et_email_meta">';
                                    if ($hide_email == true) {
                                        echo '<a href="mailto:'.$email.'"><span><i class="fa-solid fa-envelope"></i> Send Message</span></a>';
                                    } else {
                                        echo '<a href="mailto:'.$email.'"><span><i class="fa-solid fa-envelope"></i> '.$email.'</span></a>';
                                    }
                                    echo '</span>';
                                }
                            echo '</div>';
                        }
                        if (!empty($facebook_profile) || !empty($google_plus_profile) || !empty($twitter_profile) || !empty($linkedin_profile) || !empty($instagram_profile) || !empty($skype_profile)) {
                            echo '<div class="team_social"><ul>';
                                if (!empty($facebook_profile)) {
                                    echo '<li><a href="'.$facebook_profile.'" target="_blank"><span><i class="fa-brands fa-facebook-f"></i></span></a></li>';
                                }
                                if (!empty($google_plus_profile)) {
                                    echo '<li><a href="'.$google_plus_profile.'" target="_blank"><span><i class="fa-brands fa-google-plus-g"></i></span></a></li>';
                                }
                                if (!empty($twitter_profile)) {
                                    echo '<li><a href="'.$twitter_profile.'" target="_blank"><span><i class="fa-brands fa-twitter"></i></span></a></li>';
                                }
                                if (!empty($linkedin_profile)) {
                                    echo '<li><a href="'.$linkedin_profile.'" target="_blank"><span><i class="fa-brands fa-linkedin-in"></i></span></a></li>';
                                }
                                if (!empty($instagram_profile)) {
                                    echo '<li><a href="'.$instagram_profile.'" target="_blank"><span><i class="fa-brands fa-instagram"></i></span></a></li>';
                                }
                                if (!empty($skype_profile)) {
                                    echo '<li><a href="'.$skype_profile.'" target="_blank"><span><i class="fa-brands fa-skype"></i></span></a></li>';
                                }
                            echo '</ul></div>';
                        }
                    echo '</div>';
                echo '</div>';
            echo '</div>';
        }
    }
    echo '</div>';

    wp_reset_postdata();
    return ob_get_clean();
}
add_shortcode( 'team_list_sc', 'team_list_sc' );

// team shortocde end

// get title of current post start
function get_post_title_sc() {
    ob_start();
    global $post;
    $post_id = ( empty( $post->ID ) ) ? get_the_ID() : $post->ID;
    $post_title = $post->post_title;
    echo '<div class="page_sub_head_title"><h1>'.$post_title.'</h1></div>';
    return ob_get_clean();
}
add_shortcode( 'get_post_title_sc', 'get_post_title_sc' );
// get title of current post end

// get title, logo & ecxerpt of current post start
function partner_header_sc() {
    ob_start();
    global $post; 
    $post_id = ( empty( $post->ID ) ) ? get_the_ID() : $post->ID;
    $post_title = $post->post_title;
    $post_excerpt = $post->post_excerpt;
    $post_logo_img = get_field( "header_logo", $post_id );
    $partner_img = "<img src='".$post_logo_img."'>";
    echo '<div class="page_sub_head_title"><h1>'.$partner_img.'  <span class="sub_head_static_title"> & ZURICH</h1></div>';
    echo '<div class="page_sub_head_subtitle"><p>'.$post_excerpt.'</p></div>';
    return ob_get_clean();
}
add_shortcode( 'partner_header_sc', 'partner_header_sc' );
// get title, logo & ecxerpt of current post start

//For Partner page get slider images start

function partner_gallery_slider() {
    ob_start();
    global $post; 
    $post_id = ( empty( $post->ID ) ) ? get_the_ID() : $post->ID; ?>

    <div class="zurich_partner_gallery_slider">
        <?php if( have_rows('slider_gallery') ): ?>
            <?php while( have_rows('slider_gallery') ): the_row(); 
                $image = get_sub_field('slider_image');
                if(!empty($image)) {
            ?>
                <img src="<?php echo $image; ?>" />
            <?php } endwhile; ?>
        <?php endif;
        return ob_get_clean(); ?>
    </div>
<?php }
add_shortcode( 'partner_gallery_slider', 'partner_gallery_slider' );
//For Partner page get slider images end

// Filter except length to 20 words.
function custom_excerpt_length( $length ) {
	return 20;
}
add_filter( 'excerpt_length', 'custom_excerpt_length', 999 );

// Filter the "read more" excerpt
function excerpt_more( $more ) {
	return "...";
}
add_filter( 'excerpt_more', 'excerpt_more' );

function get_breadcrumb() {

    echo '<a href="'.home_url().'" rel="nofollow">Home</a>';
    if (is_category()) {

        echo "<span class='divider'></span>";

        $cat_id = get_queried_object_id();

        $category = get_category($cat_id);

        $parent = $category->parent;
        $parent_name = get_category($parent);
        $parent_name = $parent_name->name;
        // echo $parent_name;

        if (!empty($parent_name)) {
            echo '<span class="parent_cat">'.$parent_name.'</span>';
            echo "<span class='divider'></span>";
            echo "<span class='current_cat'>Blog Category</span>";
        } else {
            echo "<span class='current_cat'>Blog Category</span>";
        }
        
    } 
    
}
