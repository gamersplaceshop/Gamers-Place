<?php
if ( ! function_exists( 'cartzillagb_register_meta_fields' ) ) {
    function cartzillagb_register_meta_fields() {
        register_meta( 'post', '_bodyClasses', array(
            'object_subtype' => 'page',
            'show_in_rest' => true,
            'type' => 'string',
            'single' => true,
            'auth_callback' => function() { 
                return current_user_can( 'edit_pages' );
            }
        ) );
        register_meta( 'post', '_disableContainer', array(
            'object_subtype' => 'page',
            'show_in_rest' => true,
            'type' => 'boolean',
            'single' => true,
            'auth_callback' => function() { 
                return current_user_can( 'edit_pages' );
            }
        ) );
        register_meta( 'post', '_hidePageHeader', array(
            'object_subtype' => 'page',
            'show_in_rest' => true,
            'type' => 'boolean',
            'single' => true,
            'auth_callback' => function() { 
                return current_user_can( 'edit_pages' );
            }
        ) );
        register_meta( 'post', '_headerStyle', array(
            'object_subtype' => 'page',
            'show_in_rest' => true,
            'type' => 'string',
            'single' => true,
            'auth_callback' => function() { 
                return current_user_can( 'edit_pages' );
            }
        ) );
        register_meta( 'post', '_isCustomHeader', array(
            'object_subtype' => 'page',
            'show_in_rest' => true,
            'type' => 'boolean',
            'single' => true,
            'auth_callback' => function() { 
                return current_user_can( 'edit_pages' );
            }
        ) );
        register_meta( 'post', '_headerStaticContentID', array(
            'object_subtype' => 'page',
            'show_in_rest' => true,
            'type' => 'number',
            'single' => true,
            'auth_callback' => function() { 
                return current_user_can( 'edit_pages' );
            }
        ) );

        register_meta( 'post', '_isCustomFooter', array(
            'object_subtype' => 'page',
            'show_in_rest' => true,
            'type' => 'boolean',
            'single' => true,
            'auth_callback' => function() { 
                return current_user_can( 'edit_pages' );
            }
        ) );
        register_meta( 'post', '_footerStaticContentId', array(
            'object_subtype' => 'page',
            'show_in_rest' => true,
            'type' => 'number',
            'single' => true,
            'auth_callback' => function() { 
                return current_user_can( 'edit_pages' );
            }
        ) );
        register_meta( 'post', '_relatedPosts', array(
            'object_subtype' => 'post',
            'show_in_rest' => true,
            'type' => 'string',
            'single' => true,
            'auth_callback' => function() { 
                return current_user_can( 'edit_posts' );
            }
        ) );
    }
    add_action('init', 'cartzillagb_register_meta_fields');
}
