<?php
/**
 * Ajax Fuctions
 *
 * @since 	0.1
 * @package ElectroGB
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

if ( ! function_exists( 'cartzillagb_get_products_shortcode_atts' ) ) {
    function cartzillagb_get_products_shortcode_atts( $attributes ) {

        extract( $attributes );

        $shortcode_atts = array(
            'limit' => 3,
            'columns' => 3
        );

        if( isset( $limit ) ) {
            $shortcode_atts['limit'] = $limit;
        }

        if( isset( $columns ) ) {
            $shortcode_atts['columns'] = $columns;
        }

        if( isset( $orderby ) ) {
            $shortcode_atts['orderby'] = $orderby;
        }

        if( isset( $order ) ) {
            $shortcode_atts['order'] = $order;
        }

        if( isset( $onSale ) && $onSale ) {
            $shortcode_atts['on_sale'] = $onSale;
        } elseif( isset( $bestSelling ) && $bestSelling ) {
            $shortcode_atts['best_selling'] = $bestSelling;
        } elseif( isset( $topRated ) && $topRated ) {
            $shortcode_atts['top_rated'] = $topRated;
        }

        if( isset( $type ) && ( $type === 'products' ) && ! empty( $products ) && is_array( $products ) ) {
            $shortcode_atts['ids'] = implode( ',', $products );
        }

        if( isset( $type ) && ( $type === 'categories' ) && ! empty( $categories ) && is_array( $categories ) ) {
            $shortcode_atts['category'] = implode( ',', $categories );
            if( isset( $catOperator ) && $catOperator == 'all' ) {
                $shortcode_atts['cat_operator'] = 'AND';
            }
        }

        if( isset( $type ) && ( $type === 'tags' ) && ! empty( $tags ) && is_array( $tags ) ) {
            $tag_slugs = [];
            foreach ( $tags as $tag_id ) {
                $tag = get_term_by( 'id', $tag_id, 'product_tag' );
                if( is_object( $tag ) && isset( $tag->slug ) ) {
                    $tag_slugs[] = $tag->slug;
                }
            }
            $shortcode_atts['tag'] = implode( ',', $tag_slugs );
            if( isset( $tagOperator ) && $tagOperator == 'all' ) {
                $shortcode_atts['tag_operator'] = 'AND';
            }
        }

        if( isset( $type ) && ( $type === 'attributes' ) && ! empty( $attribute ) && is_array( $attribute ) ) {
            $terms = array();
            foreach ( $attribute as $term ) {
                $terms[] = $term['id'];
                $shortcode_atts['attribute'] = $term['attr_slug'];
            }

            $shortcode_atts['terms'] = implode( ',', $terms );
            if( isset( $attrOperator ) && $attrOperator == 'all' ) {
                $shortcode_atts['terms_operator'] = 'AND';
            }
        }

        if( isset( $visibility ) ) {
            $shortcode_atts['visibility'] = $visibility;
        }

        return $shortcode_atts;
    }
}

if ( ! function_exists( 'cartzillagb_products_block_output' ) ) {
    /**
     * Products Block.
     */
    function cartzillagb_products_block_output() {

        if( isset( $_POST['attributes'] ) ) {
            $attributes = $_POST['attributes'];

            if( isset( $attributes['attributes'] ) ) {
                unset( $attributes['attributes'] );
            }

            $design = isset( $attributes['design'] ) ? $attributes['design'] : 'style-v1' ;

            if( isset( $attributes['design'] ) ) {
                unset( $attributes['design'] );
            }

            $view = function_exists( 'cartzilla_wc_view_current' ) ? cartzilla_wc_view_current() : 'grid';

            if( $design === 'style-v3' ) {
                if( function_exists( 'cartzilla_wc_loop_product_v3_add_to_cart_link' ) ) {
                    add_filter( 'woocommerce_loop_add_to_cart_link', 'cartzilla_wc_loop_product_v3_add_to_cart_link', 70, 2 );
                }

                if( function_exists( 'cartzilla_grocery_add_to_cart_text' ) ) {
                    add_filter( 'woocommerce_product_add_to_cart_text', 'cartzilla_grocery_add_to_cart_text', 15 );
                }

                if( function_exists( 'cartzilla_add_shop_loop_item_v3_hooks' ) ) {
                    cartzilla_add_shop_loop_item_v3_hooks();
                }
            } else if( $design === 'style-v2' ) {
                if( function_exists( 'cartzilla_wc_loop_product_v2_add_to_cart_args' ) ) {
                    add_filter( 'woocommerce_loop_add_to_cart_args', 'cartzilla_wc_loop_product_v2_add_to_cart_args', 70, 2 );
                }

                if( function_exists( 'cartzilla_wc_loop_product_v2_add_to_cart_link' ) ) {
                    add_filter( 'woocommerce_loop_add_to_cart_link', 'cartzilla_wc_loop_product_v2_add_to_cart_link', 70, 2 );
                }

                if( function_exists( 'cartzilla_add_shop_loop_item_v2_hooks' ) ) {
                    cartzilla_add_shop_loop_item_v2_hooks();
                }
            } else {
                add_filter( 'cartzilla_wc_view_current', function() {
                    return 'grid';
                } );
            }

            $shortcode_atts = cartzillagb_get_products_shortcode_atts( $attributes );

            if( ! isset( $GLOBALS['post'] ) ) {
                $GLOBALS['post'] = array();
            }

            $output = cartzillagb_do_shortcode( 'products', $shortcode_atts );

            if( isset( $GLOBALS['post'] ) && empty( $GLOBALS['post'] ) ) {
                unset( $GLOBALS['post'] );
            }

            if( $design === 'style-v3' ) {
                if( function_exists( 'cartzilla_remove_shop_loop_item_v3_hooks' ) ) {
                    cartzilla_remove_shop_loop_item_v3_hooks();
                }

                remove_filter( 'woocommerce_product_add_to_cart_text', 'cartzilla_grocery_add_to_cart_text', 15 );
                remove_filter( 'woocommerce_loop_add_to_cart_link', 'cartzilla_wc_loop_product_v3_add_to_cart_link', 70, 2 );
            } else if( $design === 'style-v2' ) {
                if( function_exists( 'cartzilla_remove_shop_loop_item_v2_hooks' ) ) {
                    cartzilla_remove_shop_loop_item_v2_hooks();
                }

                remove_filter( 'woocommerce_loop_add_to_cart_args', 'cartzilla_wc_loop_product_v2_add_to_cart_args', 70, 2 );
                remove_filter( 'woocommerce_loop_add_to_cart_link', 'cartzilla_wc_loop_product_v2_add_to_cart_link', 70, 2 );
            } else {
                if( $view !== 'grid' ) {
                    add_filter( 'cartzilla_wc_view_current', function() use ($view) {
                        return $view;
                    } );
                }
            }
        }

        if( ! empty( $output ) ) {
            $data = array(
                'success' => true,
                'output' => $output,
            );
        } else {
            $data = array(
                'error' => true,
            );
        }

        wp_send_json( $data );
    }

    add_action( 'wp_ajax_nopriv_cartzillagb_products_block_output', 'cartzillagb_products_block_output' );
    add_action( 'wp_ajax_cartzillagb_products_block_output', 'cartzillagb_products_block_output' );
}

if ( ! function_exists( 'cartzillagb_products_list_block_output' ) ) {
    /**
     * Products List Block.
     */
    function cartzillagb_products_list_block_output() {

        if( class_exists( 'WooCommerce' ) && class_exists( 'Cartzilla_Products' ) && isset( $_POST['attributes'] ) ) {
            $attributes = $_POST['attributes'];

            if( isset( $attributes['attributes'] ) ) {
                unset( $attributes['attributes'] );
            }

            $shortcode_atts = cartzillagb_get_products_shortcode_atts( $attributes );

            if( isset( $shortcode_atts['limit'] ) ) {
                $shortcode_atts['per_page'] = $shortcode_atts['limit'];
                unset( $shortcode_atts['limit'] );
            }

            $shortcode_atts['columns'] = '1';

            $products_additional_class = 'products-list';
            $products = Cartzilla_Products::products( $shortcode_atts );

            ob_start();
            if ( ! empty( $products ) ) : 
                
                if ( $products->have_posts() ) { ?>


                    <ul class="list-unstyled">
                        <?php while ( $products->have_posts() ) : $products->the_post();

                            wc_get_template_part( 'templates/contents/content', 'product-list' );

                        endwhile; ?>
                    </ul><?php

                }

                woocommerce_reset_loop();
                wp_reset_postdata();
            endif;
            $output = ob_get_clean();
        }

        if( isset( $output ) && ! empty( $output ) ) {
            $data = array(
                'success' => true,
                'output' => $output,
            );
        } else {
            $data = array(
                'error' => true,
            );
        }

        wp_send_json( $data );
    }

    add_action( 'wp_ajax_nopriv_cartzillagb_products_list_block_output', 'cartzillagb_products_list_block_output' );
    add_action( 'wp_ajax_cartzillagb_products_list_block_output', 'cartzillagb_products_list_block_output' );
}

if ( ! function_exists( 'cartzillagb_blog_post_block_output' ) ) {
    /**
     * Blog Post Block.
     */
    function cartzillagb_blog_post_block_output() {

        if( isset( $_POST['attributes'] ) ) {
            $attributes = $_POST['attributes'];

            if( isset( $attributes['attributes'] ) ) {
                unset( $attributes['attributes'] );
            }

            extract( $attributes );

            $default_args = array(
                'post_type'         => 'post',
                'orderby'           => $attributes['orderBy'],
                'order'             => $attributes['order'],
                'posts_per_page'    => ! empty( $attributes['postsToShow'] ) ? $attributes['postsToShow'] : 3,
                'post__in'          => ( ! empty( $attributes['posts'] ) && is_array($attributes['posts']) ) ? array_column($attributes['posts'], 'id') : '',
            );

            $posts = get_posts( apply_filters( 'cartzillagb_render_blog_post_args', $default_args ) );

            if( $posts ) {
                ob_start();
                global $post;

                $postperslide = $attributes['postperSlide'];

                $defaultCarouselOptions = array (
                    'slidesToShow'=> 5,
                    'slidesToScroll'=> 1,
                    'dots' => true,
                    'arrows' => true,
                    'adaptiveHeight' => true,
                    'prevArrow'=> '<i class="czi-arrow-left"></i>',
                    'nextArrow'=> '<i class="czi-arrow-right"></i>',
                    'speed'=> 500,
                    'pauseOnHover'=> true,
                    'responsive' => array( 
                        array(
                            'breakpoint'    => 1198.98,
                            'settings'      => array(
                                'slidesToShow'      => 3,
                                'slidesToScroll'    => 3,
                            )
                        ),
                        array(
                            'breakpoint'    => 991.98,
                            'settings'      => array(
                                'slidesToShow'      => 3,
                                'slidesToScroll'    => 3,
                            )
                        ),
                        array(
                            'breakpoint'    => 575.98,
                            'settings'      => array(
                                'slidesToShow'      => 1,
                                'slidesToScroll'    => 1,
                            )
                        ),
                    )
                );

                $carouselOptions = array (
                    'slidesToShow'=> $postperslide,
                    'dots'=> true,
                    'arrows'=> true,
                    'responsive' => array( 
                        array(
                            'breakpoint'    => 1198.98,
                            'settings'      => array(
                                'slidesToShow'      => 3,
                                'slidesToScroll'    => 3,
                            )
                        ),
                        array(
                            'breakpoint'    => 991.98,
                            'settings'      => array(
                                'slidesToShow'      => 3,
                                'slidesToScroll'    => 3,
                            )
                        ),
                        array(
                            'breakpoint'    => 575.98,
                            'settings'      => array(
                                'slidesToShow'      => 1,
                                'slidesToScroll'    => 1,
                            )
                        ),
                    )
                );

                $carouselOptions = wp_parse_args($carouselOptions, $defaultCarouselOptions);

                $slickAtts = htmlspecialchars( json_encode( $carouselOptions ), ENT_QUOTES, 'UTF-8' );
        
                ?>
                <div class="js-slick-carousel" data-slick="<?php echo esc_attr( $slickAtts ); ?>">
                    <?php foreach ( $posts as $post ) : setup_postdata( $post ); ?>
                        <div>
                            <div class="card">
                                <a class="blog-entry-thumb" href="<?php echo esc_url( get_permalink() ); ?>">
                                    <?php echo wp_get_attachment_image( get_post_thumbnail_id( $post->ID ), array('600', '333'), "", array( "class" => "card-img-top" ) );  ?>
                                </a>
                                <div class="card-body">
                                    <?php if ( $attributes['displayPostTitle'] == 'true' ): ?>
                                        <h2 class="h6 blog-entry-title"><a href="<?php echo esc_url( get_permalink() ); ?>"><?php echo get_the_title( $post->ID ); ?></a></h2>
                                    <?php endif ?>
                                    <?php if ( $attributes['displayPostContent'] == 'true' ): ?>
                                        <p class="font-size-sm">
                                            <?php
                                                if( ! empty( $post->post_excerpt ) ) {
                                                    echo wp_kses_post( $post->post_excerpt );
                                                } else {
                                                    echo wp_kses_post( $post->post_content );
                                                }
                                            ?>
                                        </p>
                                    <?php endif;
                                    ?><div class="font-size-xs text-nowrap">
                                        <a class="blog-entry-meta-link text-nowrap" href="#"><?php echo get_the_date('M d');?></a>
                                        <?php if ( ( $post->comment_count ) != 0 ): ?>
                                        <span class="blog-entry-meta-divider mx-2"></span>
                                            <a class="blog-entry-meta-link text-nowrap" href="blog-single.html#comments">
                                                <i class="czi-message"></i>
                                                <?php echo $post->comment_count ?>
                                            </a>
                                        <?php endif ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
                <?php
                wp_reset_postdata();
                $output = ob_get_clean();
            } else {
                $output = '<p class="text-danger text-center font-size-2">' . esc_html__( 'No posts available.', 'cartzillagb' ) . '</p>';
            }
        }

        if( ! empty( $output ) ) {
            $data = array(
                'success' => true,
                'output' => $output,
            );
        } else {
            $data = array(
                'error' => true,
            );
        }

        wp_send_json( $data );
    }

    add_action( 'wp_ajax_nopriv_cartzillagb_blog_post_block_output', 'cartzillagb_blog_post_block_output' );
    add_action( 'wp_ajax_cartzillagb_blog_post_block_output', 'cartzillagb_blog_post_block_output' );
}

if ( ! function_exists( 'cartzillagb_brands_block_output' ) ) {
    /**
     * Brands Block.
     */
    function cartzillagb_brands_block_output() {

        if( isset( $_POST['attributes'] ) ) {
            $attributes = $_POST['attributes'];

            if( isset( $attributes['attributes'] ) ) {
                unset( $attributes['attributes'] );
            }

            if( class_exists( 'Mas_WC_Brands' ) ) {
                global $mas_wc_brands;
                $brand_taxonomy = $mas_wc_brands->get_brand_taxonomy();

                if( ! empty( $brand_taxonomy ) ) {
                    $default_args = apply_filters( 'cartzillagb_brands_block_default_args', array(
                        'columns'       => 4,
                        'hide_empty'    => 0,
                        'orderby'       => 'name',
                        'order'         => '',
                        'slug'          => '',
                        'include'       => '',
                        'exclude'       => '',
                        'number'        => '',
                        'image_size'    => '',
                        'fluid_columns' => false
                    ) );

                    $args = wp_parse_args( $attributes, $default_args );

                    extract( $args );

                    $exclude = array_map( 'intval', explode(',', $exclude) );
                    
                    if( empty( $order ) ) {
                        $order = $orderby === 'name' ? 'asc' : 'desc';
                    }

                    $taxonomy_args = array(
                        'taxonomy'      => $brand_taxonomy,
                        'hide_empty'    => wp_validate_boolean( $hide_empty ),
                        'orderby'       => $orderby,
                        'slug'          => $slug,
                        'include'       => $include,
                        'exclude'       => $exclude,
                        'number'        => $number,
                        'order'         => $order
                    );

                    $brands = get_terms( $taxonomy_args );

                    if ( ! $brands || ! is_array( $brands ) ) {
                        return;
                    }

                    $wrapper_class = 'columns-' . $columns;
                    if ( wp_validate_boolean( $fluid_columns ) ) {
                        $wrapper_class .= ' fluid-columns';
                    }

                    $count = 0;
                    $style_att = '';

                    $brands = array_values( $brands );

                    if ( wp_validate_boolean( $enableCarousel ) ) {
                        $wrapper_class .= ' js-slick-carousel mx-0 columns-' . $slidesToShow;
                        if( count( $brands ) >= $slidesToShow ) {
                            $wrapper_class .= ' border-right';
                        }
                    }

                    $defaultCarouselOptions = apply_filters( '', array(
                        'slidesToShow'=> 4,
                        'slidesToScroll'=> 1,
                        'dots' => false,
                        'arrows' => false,
                        'prevArrow'=> '<i class="czi-arrow-left"></i>',
                        'nextArrow'=> '<i class="czi-arrow-right"></i>',
                    ) );

                    $carouselOptions = array (
                        'slidesToShow' => $slidesToShow,
                        'responsive' => array(
                            'breakpoint' => 1199.98,
                            'settings' => array (
                                'slidesToShow' => $slidesToShowLaptop,
                            ),
                        ),
                        'responsive' => array(
                            'breakpoint' => 991.98,
                            'settings' => array (
                                'slidesToShow' => $slidesToShowTablet,
                            ),
                        ),
                        'responsive' => array(
                            'breakpoint' => 575.98,
                            'settings' => array (
                                'slidesToShow' => $slidesToShowMobile,
                            ),
                        ),
                    );

                    $carouselOptions = wp_parse_args( $carouselOptions, $defaultCarouselOptions );

                    $carouselArgs = htmlspecialchars( json_encode( $carouselOptions ), ENT_QUOTES, 'UTF-8' );

                    ob_start();
                    ?>
                    <div class="brand-thumbnails <?php echo esc_attr( $wrapper_class ); ?>" data-slick="<?php echo esc_attr( $carouselArgs ); ?>">
                        <?php foreach ( $brands as $index => $brand ) :
                            $count++;
                            $class = 'thumbnail';

                            if ( 0 === $count % 2 ) {
                                $class .= ' even';
                            } else {
                                $class .= ' odd';
                            }

                            if ( $index === 0 || $index % $columns === 0 ) {
                                $class .= ' first';
                            } elseif ( ( $index + 1 ) % $columns === 0 ) {
                                $class .= ' last';
                            }

                            if ( '' === $wrapper_class ) {
                                $width = floor( ( ( 100 - ( ( $columns - 1 ) * 2 ) ) / $columns ) * 100 ) / 100;
                                $style_att = ' style="width: ' . intval( $width ) . '%;"';
                            }

                            $anchor_class = 'd-block bg-white';

                            $anchor_class .= wp_validate_boolean( $enableCarousel ) ? ' border py-4 py-sm-5 px-2' : ' box-shadow-sm rounded-lg py-3 py-sm-4 mb-grid-gutter'

                            ?>
                            <?php if( ! wp_validate_boolean( $enableCarousel ) ) : ?>
                                <div class="<?php echo esc_attr( $class ); ?>">
                            <?php endif; ?>
                                <a class="<?php echo esc_attr( $anchor_class ); ?>" href="<?php echo esc_url( get_term_link( $brand->slug, $brand_taxonomy ) ); ?>" title="<?php echo esc_attr( $brand->name ); ?>" style="<?php echo wp_validate_boolean( $enableCarousel ) ? 'margin-right: -.0625rem;' : '';?>">
                                    <?php echo mas_wcbr_get_brand_thumbnail_image( $brand, $image_size );  ?>
                                </a>
                            <?php if( ! wp_validate_boolean( $enableCarousel ) ) : ?>
                                </div>
                            <?php endif; ?>

                        <?php endforeach; ?>
                    </div>
                    <?php
                    $output = ob_get_clean();
                }
            }
        }

        if( ! empty( $output ) ) {
            $data = array(
                'success' => true,
                'output' => $output,
            );
        } else {
            $data = array(
                'error' => true,
            );
        }

        wp_send_json( $data );
    }

    add_action( 'wp_ajax_nopriv_cartzillagb_brands_block_output', 'cartzillagb_brands_block_output' );
    add_action( 'wp_ajax_cartzillagb_brands_block_output', 'cartzillagb_brands_block_output' );
}

if ( ! function_exists( 'cartzillagb_seller_block_output' ) ) {
    /**
     * Seller Block.
     */
    function cartzillagb_seller_block_output() {

        if( class_exists( 'WeDevs_Dokan' ) && isset( $_POST['attributes'] ) ) {
            $attributes = $_POST['attributes'];

            $design = isset( $attributes['design'] ) ? $attributes['design'] : 'style-v1' ;

            if( isset( $attributes['design'] ) ) {
                unset( $attributes['design'] );
            }

            $view = function_exists( 'cartzilla_wc_view_current' ) ? cartzilla_wc_view_current() : 'grid';

            if( $design === 'style-v3' ) {
                if( function_exists( 'cartzilla_wc_loop_product_v3_add_to_cart_link' ) ) {
                    add_filter( 'woocommerce_loop_add_to_cart_link', 'cartzilla_wc_loop_product_v3_add_to_cart_link', 70, 2 );
                }

                if( function_exists( 'cartzilla_grocery_add_to_cart_text' ) ) {
                    add_filter( 'woocommerce_product_add_to_cart_text', 'cartzilla_grocery_add_to_cart_text', 15 );
                }

                if( function_exists( 'cartzilla_add_shop_loop_item_v3_hooks' ) ) {
                    cartzilla_add_shop_loop_item_v3_hooks();
                }
            } else if( $design === 'style-v2' ) {
                if( function_exists( 'cartzilla_wc_loop_product_v2_add_to_cart_args' ) ) {
                    add_filter( 'woocommerce_loop_add_to_cart_args', 'cartzilla_wc_loop_product_v2_add_to_cart_args', 70, 2 );
                }

                if( function_exists( 'cartzilla_wc_loop_product_v2_add_to_cart_link' ) ) {
                    add_filter( 'woocommerce_loop_add_to_cart_link', 'cartzilla_wc_loop_product_v2_add_to_cart_link', 70, 2 );
                }

                if( function_exists( 'cartzilla_add_shop_loop_item_v2_hooks' ) ) {
                    cartzilla_add_shop_loop_item_v2_hooks();
                }
            } else {
                add_filter( 'cartzilla_wc_view_current', function() {
                    return 'grid';
                } );
            }

            $user_id = isset( $attributes['users'] ) && isset( $attributes['users'][0] ) && isset( $attributes['users'][0]['id'] ) ? $attributes['users'][0]['id'] : 0;
            $user_data = get_userdata( $user_id );
            $store_info = dokan_get_store_info( $user_id );
            $storename = isset( $store_info['store_name'] ) && ! empty( $store_info['store_name'] ) ? $store_info['store_name'] : ( is_object( $user_data ) ? $user_data->display_name : '' );

            $products = dokan()->product->all( [
                'author'         => $user_id,
                'posts_per_page' => $attributes['limit'],
                'orderby'        => $attributes['orderby'],
                'order'          => $attributes['order'],
                'post_status'    => 'publish',
            ] );

            ob_start();
            if ( ! empty( $products ) ) :
                ?>
                <div class="row">
                    <div class="col-lg-4 text-center text-lg-left pb-3 pt-lg-2">
                        <div class="d-inline-block text-left">
                            <div class="media media-ie-fix align-items-center pb-3">
                                <div class="img-thumbnail rounded-circle position-relative" style="width: 6.375rem;">
                                    <img class="rounded-circle" src="<?php echo get_avatar_url( $user_id ); ?>" alt="<?php echo esc_attr( $storename ); ?>">
                                </div>
                                <div class="media-body pl-3">
                                    <h3 class="font-size-lg mb-0">
                                        <?php echo esc_html( $storename ); ?>
                                    </h3><span class="d-block text-muted font-size-ms pt-1 pb-2">
                                        <?php  printf( '%s %s', apply_filters( 'cartzillagb_seller_block_output_seller_memeber_since_text', esc_html__( 'Member Since', 'cartzillagb' ) ), date( "F Y", strtotime( $user_data->user_registered ) ) ); ?>
                                    </span>
                                    <a class="btn btn-primary btn-sm" href="<?php echo esc_url( dokan_get_store_url( $user_id ) ); ?>">
                                        <?php echo apply_filters( 'cartzillagb_seller_block_output_seller_button_text', esc_html__( 'View products', 'cartzillagb' ) ); ?>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-8">
                        <div class="cz-carousel">
                            <div class="cz-custom-controls"></div>
                            <?php
                            woocommerce_product_loop_start();

                            while ( $products->have_posts() ) : $products->the_post();

                                wc_get_template_part( 'content', 'product' );

                            endwhile; // end of the loop.

                            woocommerce_product_loop_end();
                            ?>
                        </div>
                    </div>
                </div>
                <?php
            endif;
            $output = ob_get_clean();

            if( $design === 'style-v3' ) {
                if( function_exists( 'cartzilla_remove_shop_loop_item_v3_hooks' ) ) {
                    cartzilla_remove_shop_loop_item_v3_hooks();
                }

                remove_filter( 'woocommerce_product_add_to_cart_text', 'cartzilla_grocery_add_to_cart_text', 15 );
                remove_filter( 'woocommerce_loop_add_to_cart_link', 'cartzilla_wc_loop_product_v3_add_to_cart_link', 70, 2 );
            } else if( $design === 'style-v2' ) {
                if( function_exists( 'cartzilla_remove_shop_loop_item_v2_hooks' ) ) {
                    cartzilla_remove_shop_loop_item_v2_hooks();
                }

                remove_filter( 'woocommerce_loop_add_to_cart_args', 'cartzilla_wc_loop_product_v2_add_to_cart_args', 70, 2 );
                remove_filter( 'woocommerce_loop_add_to_cart_link', 'cartzilla_wc_loop_product_v2_add_to_cart_link', 70, 2 );
            } else {
                if( $view !== 'grid' ) {
                    add_filter( 'cartzilla_wc_view_current', function() use ($view) {
                        return $view;
                    } );
                }
            }
        }

        if( isset( $output ) && ! empty( $output ) ) {
            $data = array(
                'success' => true,
                'output' => $output,
            );
        } else {
            $data = array(
                'error' => true,
            );
        }

        wp_send_json( $data );
    }

    add_action( 'wp_ajax_nopriv_cartzillagb_seller_block_output', 'cartzillagb_seller_block_output' );
    add_action( 'wp_ajax_cartzillagb_seller_block_output', 'cartzillagb_seller_block_output' );
}
