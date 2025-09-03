<?php
/*
 * This is the child theme for Astra theme, generated with Generate Child Theme plugin by catchthemes.
 *
 * (Please see https://developer.wordpress.org/themes/advanced-topics/child-themes/#how-to-create-a-child-theme)
 */
add_action( 'wp_enqueue_scripts', 'astra_child_enqueue_styles' );
function astra_child_enqueue_styles() {
    wp_enqueue_style( 'parent-style', get_template_directory_uri() . '/style.css' );
    wp_enqueue_style( 'child-style',
        get_stylesheet_directory_uri() . '/style.css',
        array( 'parent-style' )
    );
}

// Add floating WhatsApp button
function petslets_floating_whatsapp_button() {
    $whatsapp_number = '447956442632';
    $prefilled_text  = urlencode("Hi PetsLets! I found you on your website and I'm interested in your services.");
    $whatsapp_url    = "https://wa.me/{$whatsapp_number}?text={$prefilled_text}";
    ?>
    <style>
        .floating-whatsapp {
            position: fixed;
            bottom: 20px;
            right: 20px;
            background-color: #25D366;
            color: #fff;
            border-radius: 50%;
            width: 50px;
            height: 50px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.2);
            cursor: pointer;
            z-index: 9999;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }
        .floating-whatsapp:hover {
            transform: scale(1.1);
            box-shadow: 0 6px 12px rgba(0,0,0,0.3);
        }
        .floating-whatsapp svg {
            width: 26px;
            height: 26px;
        }
    </style>
    <a href="<?php echo esc_url($whatsapp_url); ?>" class="floating-whatsapp" target="_blank" aria-label="Chat with us on WhatsApp">
        <!-- WhatsApp SVG icon -->
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32 32" fill="#fff">
            <path d="M16 0C7.2 0 0 7.2 0 16c0 2.8.7 5.5 2 8L0 32l8-2c2.4 1.3 5.1 2 8 2 8.8 0 16-7.2 16-16S24.8 0 16 0zm0 29c-2.5 0-4.9-.6-7-1.8l-.5-.3-4.8 1.2 1.3-4.7-.3-.5C3.5 21.6 3 18.8 3 16 3 8.8 8.8 3 16 3s13 5.8 13 13-5.8 13-13 13zm7.2-9.8c-.4-.2-2.5-1.2-2.9-1.3-.4-.1-.7-.2-1 .2-.3.4-1.1 1.3-1.3 1.5-.2.2-.5.3-.9.1s-1.8-.7-3.5-2.2c-1.3-1.2-2.2-2.7-2.4-3.1-.2-.4 0-.7.2-.9.2-.2.4-.5.6-.7.2-.2.3-.4.4-.6.1-.2.1-.4 0-.6-.1-.2-1-2.4-1.4-3.3-.4-.9-.7-.8-1-.8h-.9c-.3 0-.6.1-.9.4-.3.3-1.2 1.2-1.2 3s1.2 3.5 1.4 3.7c.2.3 2.3 3.6 5.6 5 3.3 1.4 3.3.9 3.9.8.6-.1 2-1 2.3-1.9.3-.9.3-1.6.2-1.8-.1-.2-.4-.3-.8-.5z"/>
        </svg>
    </a>
    <?php
}
add_action('wp_footer', 'petslets_floating_whatsapp_button');

/*
 * Your code goes below
 */

require get_stylesheet_directory() . '/inc/custom-post-types.php';

