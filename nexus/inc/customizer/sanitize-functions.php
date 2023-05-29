<?php
/**
 * Nexus Theme Options Sanitization Functions
 */

/**
 * Sanitization callback for 'select' and 'radio' type controls. This callback sanitizes `$input`
 * as a slug, and then validates `$input` against the choices defined for the control.
 *
 * @param string               $input   Slug to sanitize.
 * @param WP_Customize_Setting $setting Setting instance.
 * @return string Sanitized slug if it is a valid choice; otherwise, the setting default.
 */
function nexus_sanitize_select( $input, $setting ) {
    // Get list of choices from the control associated with the setting.
    $choices = $setting->manager->get_control( $setting->id )->choices;

    // If the input is a valid key, return it; otherwise, return the default.
    return ( array_key_exists( $input, $choices ) ? $input : $setting->default );
}

/**
 * Checkbox sanitization callback.
 *
 * Sanitization callback for 'checkbox' type controls. This callback sanitizes `$checked`
 * as a boolean value, either TRUE or FALSE.
 *
 * @param bool $checked Whether the checkbox is checked.
 * @return bool Whether the checkbox is checked.
 */
function nexus_sanitize_checkbox( $checked ) {
    // Boolean check.
    return ( ( isset( $checked ) && true == $checked ) ? true : false );
}

/**
 * Sanitizes page/post in slider
 * @param  $input raw page/post id
 * @return sanitized page/post id
 */
function nexus_sanitize_post( $input ) {
    // Ensure $input is an absolute integer.
    $page_id = absint( $input );
    // If $page_id is an ID of a published page, return it; otherwise, return false
    return ( 'publish' == get_post_status( $page_id ) ? $page_id : false );
}

/**
 * Image sanitization callback.
 *
 * Checks the image's file extension and mime type against a whitelist. If they're allowed,
 * send back the filename, otherwise, return the setting default.
 *
 * - Sanitization: image file extension
 * - Control: text, WP_Customize_Image_Control
 *
 * @param string               $image   Image filename.
 * @param WP_Customize_Setting $setting Setting instance.
 * @return string The image filename if the extension is allowed; otherwise, the setting default.
 */
function nexus_sanitize_image( $image, $setting ) {
    /*
     * Array of valid image file types.
     *
     * The array includes image mime types that are included in wp_get_mime_types()
     */
    $mimes = array(
        'jpg|jpeg|jpe' => 'image/jpeg',
        'gif'          => 'image/gif',
        'png'          => 'image/png',
        'bmp'          => 'image/bmp',
        'tif|tiff'     => 'image/tiff',
        'ico'          => 'image/x-icon'
    );
    // Return an array with file extension and mime_type.
    $file = wp_check_filetype( $image, $mimes );
    // If $image has a valid mime_type, return it; otherwise, return the default.
    return ( $file['ext'] ? $image : $setting->default );
}

/**
 * Sanitizes category list
 * @param  $input entered value
 * @return sanitized output
 */
function nexus_sanitize_category_list( $input ) {
    if ( is_array( $input ) && '' != $input ) {
        if ( in_array( 0, $input ) ) {
            return '0';
        }

        $args = array(
            'type'         => 'post',
            'child_of'     => 0,
            'parent'       => '',
            'orderby'      => 'name',
            'order'        => 'ASC',
            'hide_empty'   => 0,
            'hierarchical' => 0,
            'taxonomy'     => 'category',
        );

        $categories = get_categories( $args );

        $category_list  = array();

        foreach ( $categories as $category ) {
            $category_list  = array_merge( $category_list, array( $category->term_id ) );
        }

        if ( count( array_intersect( $input, $category_list ) ) == count( $input ) ) {
            return $input;
        } else {
            return '';
        }
    } else {
        return '';
    }
}


/**
 * Number Range sanitization callback.
 *
 * - Sanitization: number_range
 * - Control: number, tel
 *
 * Sanitization callback for 'number' or 'tel' type text inputs. This callback sanitizes
 * `$number` as an absolute integer within a defined min-max range.
 *
 * @param int                  $number  Number to check within the numeric range defined by the setting.
 * @param WP_Customize_Setting $setting Setting instance.
 * @return int|string The number, if it is zero or greater and falls within the defined range; otherwise,
 *                    the setting default.
 */
function nexus_sanitize_number_range( $number, $setting ) {

    // Ensure input is an absolute integer.
    $number = absint( $number );

    // Get the input attributes associated with the setting.
    $atts = $setting->manager->get_control( $setting->id )->input_attrs;


    // Get minimum number in the range.
    $min = ( isset( $atts['min'] ) ? $atts['min'] : $number );

    // Get maximum number in the range.
    $max = ( isset( $atts['max'] ) ? $atts['max'] : $number );

    // Get step.
    $step = ( isset( $atts['step'] ) ? $atts['step'] : 1 );

    // If the number is within the valid range, return it; otherwise, return the default
    return ( $min <= $number && $number <= $max && is_int( $number / $step ) ? $number : $setting->default );
}

/*
 * Sanitize fonts
 */


/**
 * Font sanitization callback.
 *
 * Sanitization callback for font select controls.
 */
function nexus_sanitize_fonts( $input ) {
    $valid = array(
        'Emilys Candy:' => 'Emilys Candy',
        'Poppins:0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900' => 'Poppins',
        'Source Sans Pro:400,700,400italic,700italic' => 'Source Sans Pro',
        'Open Sans:400italic,700italic,400,700' => 'Open Sans',
        'Oswald:400,700' => 'Oswald',
        'Playfair Display:400,700,400italic' => 'Playfair Display',
        'Montserrat:400,700' => 'Montserrat',
        'Raleway:400,700' => 'Raleway',
        'Droid Sans:400,700' => 'Droid Sans',
        'Lato:400,700,400italic,700italic' => 'Lato',
        'Arvo:400,700,400italic,700italic' => 'Arvo',
        'Lora:400,700,400italic,700italic' => 'Lora',
        'Merriweather:400,300italic,300,400italic,700,700italic' => 'Merriweather',
        'Oxygen:400,300,700' => 'Oxygen',
        'PT Serif:400,700' => 'PT Serif',
        'PT Sans:400,700,400italic,700italic' => 'PT Sans',
        'PT Sans Narrow:400,700' => 'PT Sans Narrow',
        'Cabin:400,700,400italic' => 'Cabin',
        'Fjalla One:400' => 'Fjalla One',
        'Francois One:400' => 'Francois One',
        'Josefin Sans:400,300,600,700' => 'Josefin Sans',
        'Libre Baskerville:400,400italic,700' => 'Libre Baskerville',
        'Arimo:400,700,400italic,700italic' => 'Arimo',
        'Ubuntu:400,700,400italic,700italic' => 'Ubuntu',
        'Bitter:400,700,400italic' => 'Bitter',
        'Droid Serif:400,700,400italic,700italic' => 'Droid Serif',
        'Roboto:400,400italic,700,700italic' => 'Roboto',
        'Open Sans Condensed:700,300italic,300' => 'Open Sans Condensed',
        'Roboto Condensed:400italic,700italic,400,700' => 'Roboto Condensed',
        'Roboto Slab:400,700' => 'Roboto Slab',
        'Yanone Kaffeesatz:400,700' => 'Yanone Kaffeesatz',
        'Rokkitt:400' => 'Rokkitt',
    );

    if ( array_key_exists( $input, $valid ) ) {
        return $input;
    } else {
        return '';
    }
}


