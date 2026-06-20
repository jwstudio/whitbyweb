<?php
/**
 * Whitby Web — Theme Functions
 */

// ─── Assets ───────────────────────────────────────────────────────────────────

function whitbyweb_enqueue_assets() {
    wp_enqueue_style(
        'whitbyweb-fonts',
        'https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Outfit:wght@300;400;500;600;700;800&family=IBM+Plex+Mono:wght@400;500&display=swap',
        [],
        null
    );
    wp_enqueue_style(
        'whitbyweb-style',
        get_stylesheet_uri(),
        [ 'whitbyweb-fonts' ],
        '1.3.1'
    );
}
add_action( 'wp_enqueue_scripts', 'whitbyweb_enqueue_assets' );

// ─── Theme Support ────────────────────────────────────────────────────────────

function whitbyweb_setup() {
    add_theme_support( 'title-tag' );
    add_theme_support( 'post-thumbnails' );
}
add_action( 'after_setup_theme', 'whitbyweb_setup' );

// ─── Custom Post Types ────────────────────────────────────────────────────────

function whitbyweb_register_cpts() {

    register_post_type( 'testimonial', [
        'labels'       => [
            'name'          => 'Testimonials',
            'singular_name' => 'Testimonial',
            'add_new_item'  => 'Add New Testimonial',
            'edit_item'     => 'Edit Testimonial',
            'menu_name'     => 'Testimonials',
        ],
        'public'       => false,
        'show_ui'      => true,
        'show_in_menu' => true,
        'menu_icon'    => 'dashicons-format-quote',
        'supports'     => [ 'title', 'page-attributes' ],
        'has_archive'  => false,
        'rewrite'      => false,
    ] );

    register_post_type( 'project', [
        'labels'       => [
            'name'          => 'Projects',
            'singular_name' => 'Project',
            'add_new_item'  => 'Add New Project',
            'edit_item'     => 'Edit Project',
            'menu_name'     => 'Projects',
        ],
        'public'        => true,
        'show_ui'       => true,
        'show_in_menu'  => true,
        'menu_icon'     => 'dashicons-portfolio',
        'supports'      => [ 'title', 'thumbnail', 'page-attributes' ],
        'has_archive'   => true,
        'rewrite'       => [ 'slug' => 'work' ],
        'show_in_rest'  => true,
    ] );
}
add_action( 'init', 'whitbyweb_register_cpts' );

// ─── ACF Options Page ─────────────────────────────────────────────────────────

add_action( 'acf/init', 'whitbyweb_register_options_page' );

function whitbyweb_register_options_page() {
    if ( ! function_exists( 'acf_add_options_page' ) ) {
        return;
    }

    acf_add_options_page( [
        'page_title'  => 'Global Settings',
        'menu_title'  => 'Global Settings',
        'menu_slug'   => 'whitbyweb-global-settings',
        'capability'  => 'edit_posts',
        'icon_url'    => 'dashicons-admin-settings',
        'redirect'    => false,
    ] );
}

// ─── ACF Field Groups ─────────────────────────────────────────────────────────

add_action( 'acf/init', 'whitbyweb_register_acf_fields' );

function whitbyweb_register_acf_fields() {
    if ( ! function_exists( 'acf_add_local_field_group' ) ) {
        return;
    }

    // ════════════════════════════════════════════════════════════════════════
    // GLOBAL SETTINGS OPTIONS PAGE
    // ════════════════════════════════════════════════════════════════════════
    acf_add_local_field_group( [
        'key'      => 'group_global_settings',
        'title'    => 'Global Settings',
        'location' => [ [ [ 'param' => 'options_page', 'operator' => '==', 'value' => 'whitbyweb-global-settings' ] ] ],
        'fields'   => [

            // ── One-Page Promo ───────────────────────────────────────────
            [
                'key'   => 'field_tab_opp',
                'label' => 'One-Page Promo',
                'name'  => '',
                'type'  => 'tab',
            ],
            [
                'key'           => 'field_global_opp_eyebrow',
                'label'         => 'Eyebrow',
                'name'          => 'opp_eyebrow',
                'type'          => 'text',
                'default_value' => 'One-Page Websites',
            ],
            [
                'key'        => 'field_global_opp_heading_lines',
                'label'      => 'Heading Lines',
                'name'       => 'opp_heading_lines',
                'type'       => 'repeater',
                'instructions' => 'Each row = one line. Tick "Highlighted" for gradient colour.',
                'layout'     => 'table',
                'min'        => 1,
                'button_label' => 'Add Line',
                'sub_fields' => [
                    [
                        'key'   => 'field_global_opp_hl_text',
                        'label' => 'Text',
                        'name'  => 'text',
                        'type'  => 'text',
                    ],
                    [
                        'key'   => 'field_global_opp_hl_highlight',
                        'label' => 'Highlighted',
                        'name'  => 'highlighted',
                        'type'  => 'true_false',
                        'ui'    => 1,
                    ],
                ],
            ],
            [
                'key'   => 'field_global_opp_lead',
                'label' => 'Lead Paragraph',
                'name'  => 'opp_lead',
                'type'  => 'textarea',
                'rows'  => 3,
            ],
            [
                'key'          => 'field_global_opp_buttons',
                'label'        => 'Buttons',
                'name'         => 'opp_buttons',
                'type'         => 'repeater',
                'layout'       => 'table',
                'button_label' => 'Add Button',
                'sub_fields'   => [
                    [
                        'key'   => 'field_global_opp_btn_label',
                        'label' => 'Label',
                        'name'  => 'label',
                        'type'  => 'text',
                    ],
                    [
                        'key'   => 'field_global_opp_btn_url',
                        'label' => 'URL',
                        'name'  => 'url',
                        'type'  => 'url',
                    ],
                    [
                        'key'     => 'field_global_opp_btn_style',
                        'label'   => 'Style',
                        'name'    => 'style',
                        'type'    => 'select',
                        'choices' => [ 'primary' => 'Primary', 'secondary' => 'Secondary' ],
                        'default_value' => 'primary',
                    ],
                ],
            ],
            [
                'key'           => 'field_global_opp_card_eyebrow',
                'label'         => 'Feature Card Eyebrow',
                'name'          => 'opp_card_eyebrow',
                'type'          => 'text',
                'default_value' => "What's included",
            ],
            [
                'key'          => 'field_global_opp_features',
                'label'        => 'Features',
                'name'         => 'opp_features',
                'type'         => 'repeater',
                'layout'       => 'table',
                'button_label' => 'Add Feature',
                'sub_fields'   => [
                    [
                        'key'   => 'field_global_opp_feat_title',
                        'label' => 'Title',
                        'name'  => 'title',
                        'type'  => 'text',
                    ],
                    [
                        'key'   => 'field_global_opp_feat_sub',
                        'label' => 'Subtitle',
                        'name'  => 'sub',
                        'type'  => 'text',
                    ],
                ],
            ],

            // ── Global CTA Defaults ──────────────────────────────────────
            [
                'key'   => 'field_tab_cta',
                'label' => 'CTA Defaults',
                'name'  => '',
                'type'  => 'tab',
            ],
            [
                'key'           => 'field_global_cta_eyebrow',
                'label'         => 'Eyebrow',
                'name'          => 'cta_eyebrow',
                'type'          => 'text',
                'default_value' => 'Get in Touch',
            ],
            [
                'key'        => 'field_global_cta_heading_lines',
                'label'      => 'Heading Lines',
                'name'       => 'cta_heading_lines',
                'type'       => 'repeater',
                'layout'     => 'table',
                'min'        => 1,
                'button_label' => 'Add Line',
                'sub_fields' => [
                    [
                        'key'   => 'field_global_cta_hl_text',
                        'label' => 'Text',
                        'name'  => 'text',
                        'type'  => 'text',
                    ],
                    [
                        'key'   => 'field_global_cta_hl_highlight',
                        'label' => 'Highlighted',
                        'name'  => 'highlighted',
                        'type'  => 'true_false',
                        'ui'    => 1,
                    ],
                ],
            ],
            [
                'key'   => 'field_global_cta_lead',
                'label' => 'Lead Paragraph',
                'name'  => 'cta_lead',
                'type'  => 'textarea',
                'rows'  => 3,
            ],
            [
                'key'          => 'field_global_cta_buttons',
                'label'        => 'Buttons',
                'name'         => 'cta_buttons',
                'type'         => 'repeater',
                'layout'       => 'table',
                'button_label' => 'Add Button',
                'sub_fields'   => [
                    [
                        'key'   => 'field_global_cta_btn_label',
                        'label' => 'Label',
                        'name'  => 'label',
                        'type'  => 'text',
                    ],
                    [
                        'key'   => 'field_global_cta_btn_url',
                        'label' => 'URL',
                        'name'  => 'url',
                        'type'  => 'url',
                    ],
                    [
                        'key'     => 'field_global_cta_btn_style',
                        'label'   => 'Style',
                        'name'    => 'style',
                        'type'    => 'select',
                        'choices' => [ 'primary' => 'Primary', 'secondary' => 'Secondary' ],
                        'default_value' => 'primary',
                    ],
                ],
            ],
            [
                'key'           => 'field_global_cta_portrait',
                'label'         => 'Portrait Image',
                'name'          => 'cta_portrait',
                'type'          => 'image',
                'return_format' => 'array',
                'preview_size'  => 'medium',
            ],
        ],
    ] );

    // ════════════════════════════════════════════════════════════════════════
    // PAGE BUILDER — flexible content for Pages
    // ════════════════════════════════════════════════════════════════════════
    acf_add_local_field_group( [
        'key'      => 'group_69ee15c142a1b',
        'title'    => 'Page Builder',
        'location' => [ [ [ 'param' => 'post_type', 'operator' => '==', 'value' => 'page' ] ] ],
        'position' => 'normal',
        'fields'   => [
            [
                'key'          => 'field_69ee15c1db2c2',
                'label'        => 'Page Builder',
                'name'         => 'page_builder',
                'type'         => 'flexible_content',
                'button_label' => 'Add Block',
                'layouts'      => [

                    // ── Hero ─────────────────────────────────────────────
                    'layout_69ee15c7d18b7' => [
                        'key'        => 'layout_69ee15c7d18b7',
                        'name'       => 'hero',
                        'label'      => 'Hero',
                        'display'    => 'block',
                        'sub_fields' => [
                            [
                                'key'         => 'field_hero_pill_text',
                                'label'       => 'Pill Text',
                                'name'        => 'pill_text',
                                'type'        => 'text',
                                'placeholder' => 'e.g. Ask about our one-page websites',
                            ],
                            [
                                'key'          => 'field_hero_heading_lines',
                                'label'        => 'Heading Lines',
                                'name'         => 'heading_lines',
                                'type'         => 'repeater',
                                'instructions' => 'Each row = one line. Tick "Highlighted" for gradient colour.',
                                'layout'       => 'table',
                                'min'          => 1,
                                'button_label' => 'Add Line',
                                'sub_fields'   => [
                                    [
                                        'key'   => 'field_hero_hl_text',
                                        'label' => 'Text',
                                        'name'  => 'text',
                                        'type'  => 'text',
                                    ],
                                    [
                                        'key'   => 'field_hero_hl_highlight',
                                        'label' => 'Highlighted',
                                        'name'  => 'highlighted',
                                        'type'  => 'true_false',
                                        'ui'    => 1,
                                    ],
                                ],
                            ],
                            [
                                'key'   => 'field_hero_lead',
                                'label' => 'Lead Paragraph',
                                'name'  => 'lead',
                                'type'  => 'textarea',
                                'rows'  => 3,
                            ],
                            [
                                'key'          => 'field_hero_buttons',
                                'label'        => 'Buttons',
                                'name'         => 'buttons',
                                'type'         => 'repeater',
                                'layout'       => 'table',
                                'button_label' => 'Add Button',
                                'sub_fields'   => [
                                    [
                                        'key'   => 'field_hero_btn_label',
                                        'label' => 'Label',
                                        'name'  => 'label',
                                        'type'  => 'text',
                                    ],
                                    [
                                        'key'   => 'field_hero_btn_url',
                                        'label' => 'URL',
                                        'name'  => 'url',
                                        'type'  => 'url',
                                    ],
                                    [
                                        'key'     => 'field_hero_btn_style',
                                        'label'   => 'Style',
                                        'name'    => 'style',
                                        'type'    => 'select',
                                        'choices' => [ 'primary' => 'Primary', 'secondary' => 'Secondary' ],
                                        'default_value' => 'primary',
                                    ],
                                ],
                            ],
                            [
                                'key'           => 'field_hero_form_id',
                                'label'         => 'Formidable Form ID',
                                'name'          => 'form_id',
                                'type'          => 'number',
                                'instructions'  => 'The numeric ID of the Formidable form to embed in the card.',
                                'default_value' => 1,
                            ],
                            [
                                'key'           => 'field_hero_form_title',
                                'label'         => 'Form Card Title',
                                'name'          => 'form_title',
                                'type'          => 'text',
                                'default_value' => 'Get a free quote',
                            ],
                            [
                                'key'           => 'field_hero_form_subtitle',
                                'label'         => 'Form Card Subtitle',
                                'name'          => 'form_subtitle',
                                'type'          => 'text',
                                'default_value' => 'Tell us about your project. We reply within 24 hours.',
                            ],
                        ],
                    ],

                    // ── Reviews ──────────────────────────────────────────
                    'layout_reviews' => [
                        'key'        => 'layout_reviews',
                        'name'       => 'reviews',
                        'label'      => 'Reviews',
                        'display'    => 'block',
                        'sub_fields' => [
                            [
                                'key'           => 'field_reviews_eyebrow',
                                'label'         => 'Eyebrow Text',
                                'name'          => 'eyebrow',
                                'type'          => 'text',
                                'default_value' => 'Client Testimonials',
                            ],
                            [
                                'key'           => 'field_reviews_rating_text',
                                'label'         => 'Rating Text',
                                'name'          => 'rating_text',
                                'type'          => 'text',
                                'default_value' => '5.0 stars from all reviews',
                            ],
                            [
                                'key'           => 'field_reviews_limit',
                                'label'         => 'Number to Show',
                                'name'          => 'limit',
                                'type'          => 'number',
                                'instructions'  => 'Leave blank or -1 to show all.',
                                'default_value' => -1,
                                'min'           => -1,
                            ],
                            [
                                'key'   => 'field_reviews_show_all',
                                'label' => 'Show "See all reviews" button',
                                'name'  => 'show_all_link',
                                'type'  => 'true_false',
                                'ui'    => 1,
                            ],
                            [
                                'key'               => 'field_reviews_all_url',
                                'label'             => '"See all reviews" URL',
                                'name'              => 'all_url',
                                'type'              => 'url',
                                'default_value'     => '/reviews/',
                                'conditional_logic' => [
                                    [ [ 'field' => 'field_reviews_show_all', 'operator' => '==', 'value' => '1' ] ],
                                ],
                            ],
                        ],
                    ],

                    // ── Services (hardcoded — no sub_fields needed) ───────
                    'layout_services' => [
                        'key'        => 'layout_services',
                        'name'       => 'services',
                        'label'      => 'Services',
                        'display'    => 'block',
                        'sub_fields' => [],
                    ],

                    // ── Work / Projects ───────────────────────────────────
                    'layout_work' => [
                        'key'        => 'layout_work',
                        'name'       => 'work',
                        'label'      => 'Work / Projects',
                        'display'    => 'block',
                        'sub_fields' => [
                            [
                                'key'           => 'field_work_eyebrow',
                                'label'         => 'Eyebrow',
                                'name'          => 'eyebrow',
                                'type'          => 'text',
                                'default_value' => 'Our Work',
                            ],
                            [
                                'key'          => 'field_work_heading_lines',
                                'label'        => 'Heading Lines',
                                'name'         => 'heading_lines',
                                'type'         => 'repeater',
                                'layout'       => 'table',
                                'min'          => 1,
                                'button_label' => 'Add Line',
                                'sub_fields'   => [
                                    [
                                        'key'   => 'field_work_hl_text',
                                        'label' => 'Text',
                                        'name'  => 'text',
                                        'type'  => 'text',
                                    ],
                                    [
                                        'key'   => 'field_work_hl_highlight',
                                        'label' => 'Highlighted',
                                        'name'  => 'highlighted',
                                        'type'  => 'true_false',
                                        'ui'    => 1,
                                    ],
                                ],
                            ],
                            [
                                'key'   => 'field_work_lead',
                                'label' => 'Intro Paragraph',
                                'name'  => 'lead',
                                'type'  => 'textarea',
                                'rows'  => 2,
                            ],
                            [
                                'key'           => 'field_work_limit',
                                'label'         => 'Number of Projects to Show',
                                'name'          => 'limit',
                                'type'          => 'number',
                                'instructions'  => 'Leave blank or -1 to show all.',
                                'default_value' => -1,
                            ],
                            [
                                'key'   => 'field_work_show_all',
                                'label' => 'Show "See all projects" link',
                                'name'  => 'show_all_link',
                                'type'  => 'true_false',
                                'ui'    => 1,
                            ],
                            [
                                'key'               => 'field_work_all_url',
                                'label'             => 'View All URL',
                                'name'              => 'all_url',
                                'type'              => 'url',
                                'default_value'     => '/work/',
                                'conditional_logic' => [
                                    [ [ 'field' => 'field_work_show_all', 'operator' => '==', 'value' => '1' ] ],
                                ],
                            ],
                        ],
                    ],

                    // ── One-Page Promo (uses Global Settings) ─────────────
                    'layout_one_page_promo' => [
                        'key'        => 'layout_one_page_promo',
                        'name'       => 'one_page_promo',
                        'label'      => 'One-Page Promo',
                        'display'    => 'block',
                        'sub_fields' => [],
                    ],

                    // ── CTA Banner ────────────────────────────────────────
                    'layout_cta' => [
                        'key'        => 'layout_cta',
                        'name'       => 'cta',
                        'label'      => 'CTA Banner',
                        'display'    => 'block',
                        'sub_fields' => [
                            [
                                'key'           => 'field_cta_eyebrow',
                                'label'         => 'Eyebrow (leave blank to use Global default)',
                                'name'          => 'eyebrow',
                                'type'          => 'text',
                            ],
                            [
                                'key'          => 'field_cta_heading_lines',
                                'label'        => 'Heading Lines (leave empty to use Global default)',
                                'name'         => 'heading_lines',
                                'type'         => 'repeater',
                                'layout'       => 'table',
                                'button_label' => 'Add Line',
                                'sub_fields'   => [
                                    [
                                        'key'   => 'field_cta_hl_text',
                                        'label' => 'Text',
                                        'name'  => 'text',
                                        'type'  => 'text',
                                    ],
                                    [
                                        'key'   => 'field_cta_hl_highlight',
                                        'label' => 'Highlighted',
                                        'name'  => 'highlighted',
                                        'type'  => 'true_false',
                                        'ui'    => 1,
                                    ],
                                ],
                            ],
                            [
                                'key'   => 'field_cta_lead',
                                'label' => 'Lead Paragraph (leave blank to use Global default)',
                                'name'  => 'lead',
                                'type'  => 'textarea',
                                'rows'  => 3,
                            ],
                            [
                                'key'          => 'field_cta_buttons',
                                'label'        => 'Buttons (leave empty to use Global default)',
                                'name'         => 'buttons',
                                'type'         => 'repeater',
                                'layout'       => 'table',
                                'button_label' => 'Add Button',
                                'sub_fields'   => [
                                    [
                                        'key'   => 'field_cta_btn_label',
                                        'label' => 'Label',
                                        'name'  => 'label',
                                        'type'  => 'text',
                                    ],
                                    [
                                        'key'   => 'field_cta_btn_url',
                                        'label' => 'URL',
                                        'name'  => 'url',
                                        'type'  => 'url',
                                    ],
                                    [
                                        'key'     => 'field_cta_btn_style',
                                        'label'   => 'Style',
                                        'name'    => 'style',
                                        'type'    => 'select',
                                        'choices' => [ 'primary' => 'Primary', 'secondary' => 'Secondary' ],
                                        'default_value' => 'primary',
                                    ],
                                ],
                            ],
                            [
                                'key'           => 'field_cta_portrait',
                                'label'         => 'Portrait Image (leave blank to use Global default)',
                                'name'          => 'portrait',
                                'type'          => 'image',
                                'return_format' => 'array',
                                'preview_size'  => 'medium',
                            ],
                        ],
                    ],

                    // ── Contact ───────────────────────────────────────────
                    'layout_69fbb8ed71863' => [
                        'key'        => 'layout_69fbb8ed71863',
                        'name'       => 'contact',
                        'label'      => 'Contact',
                        'display'    => 'block',
                        'sub_fields' => [
                            [
                                'key'          => 'field_contact_heading_lines',
                                'label'        => 'Heading Lines',
                                'name'         => 'heading_lines',
                                'type'         => 'repeater',
                                'layout'       => 'table',
                                'min'          => 1,
                                'button_label' => 'Add Line',
                                'sub_fields'   => [
                                    [
                                        'key'   => 'field_contact_hl_text',
                                        'label' => 'Text',
                                        'name'  => 'text',
                                        'type'  => 'text',
                                    ],
                                    [
                                        'key'   => 'field_contact_hl_highlight',
                                        'label' => 'Highlighted',
                                        'name'  => 'highlighted',
                                        'type'  => 'true_false',
                                        'ui'    => 1,
                                    ],
                                ],
                            ],
                            [
                                'key'           => 'field_contact_subtext',
                                'label'         => 'Sub-text',
                                'name'          => 'subtext',
                                'type'          => 'text',
                                'default_value' => 'Tell us about your project. We aim to reply within 24 hours.',
                            ],
                            [
                                'key'           => 'field_contact_pill_text',
                                'label'         => 'Pill Text',
                                'name'          => 'pill_text',
                                'type'          => 'text',
                                'default_value' => 'Get in touch',
                            ],
                            [
                                'key'  => 'field_contact_email',
                                'label' => 'Email Address',
                                'name'  => 'email',
                                'type'  => 'email',
                            ],
                            [
                                'key'  => 'field_contact_fb_url',
                                'label' => 'Facebook URL',
                                'name'  => 'facebook_url',
                                'type'  => 'url',
                            ],
                            [
                                'key'  => 'field_contact_ig_url',
                                'label' => 'Instagram URL',
                                'name'  => 'instagram_url',
                                'type'  => 'url',
                            ],
                            [
                                'key'  => 'field_contact_li_url',
                                'label' => 'LinkedIn URL',
                                'name'  => 'linkedin_url',
                                'type'  => 'url',
                            ],
                            [
                                'key'           => 'field_contact_form_id',
                                'label'         => 'Formidable Form ID',
                                'name'          => 'form_id',
                                'type'          => 'number',
                                'default_value' => 1,
                            ],
                            [
                                'key'           => 'field_contact_form_title',
                                'label'         => 'Form Card Title',
                                'name'          => 'form_title',
                                'type'          => 'text',
                                'default_value' => 'Send a message',
                            ],
                            [
                                'key'           => 'field_contact_form_subtitle',
                                'label'         => 'Form Card Subtitle',
                                'name'          => 'form_subtitle',
                                'type'          => 'text',
                                'default_value' => "Fill out the form and we'll be in touch shortly.",
                            ],
                        ],
                    ],

                ],
            ],
        ],
    ] );

    // ════════════════════════════════════════════════════════════════════════
    // TESTIMONIAL FIELDS
    // ════════════════════════════════════════════════════════════════════════
    acf_add_local_field_group( [
        'key'      => 'group_testimonial',
        'title'    => 'Testimonial Details',
        'location' => [ [ [ 'param' => 'post_type', 'operator' => '==', 'value' => 'testimonial' ] ] ],
        'fields'   => [
            [
                'key'   => 'field_testimonial_review',
                'label' => 'Review',
                'name'  => 'review',
                'type'  => 'textarea',
                'rows'  => 4,
            ],
            [
                'key'         => 'field_testimonial_company',
                'label'       => 'Company / Role',
                'name'        => 'company',
                'type'        => 'text',
                'placeholder' => 'e.g. Owner, Bloom Floristry',
            ],
        ],
    ] );

    // ════════════════════════════════════════════════════════════════════════
    // PROJECT FIELDS
    // ════════════════════════════════════════════════════════════════════════
    acf_add_local_field_group( [
        'key'      => 'group_project',
        'title'    => 'Project Details',
        'location' => [ [ [ 'param' => 'post_type', 'operator' => '==', 'value' => 'project' ] ] ],
        'fields'   => [
            [
                'key'         => 'field_project_category',
                'label'       => 'Category',
                'name'        => 'project_category',
                'type'        => 'text',
                'placeholder' => 'e.g. E-commerce',
            ],
            [
                'key'           => 'field_project_tag_color',
                'label'         => 'Category Dot Colour',
                'name'          => 'project_tag_color',
                'type'          => 'color_picker',
                'default_value' => '#86c541',
            ],
            [
                'key'           => 'field_project_problem_label',
                'label'         => 'Problem Label',
                'name'          => 'project_problem_label',
                'type'          => 'text',
                'default_value' => 'The problem',
            ],
            [
                'key'   => 'field_project_body',
                'label' => 'Body',
                'name'  => 'project_body',
                'type'  => 'textarea',
                'rows'  => 4,
            ],
            [
                'key'          => 'field_project_outcomes',
                'label'        => 'Outcomes',
                'name'         => 'project_outcomes',
                'type'         => 'repeater',
                'layout'       => 'table',
                'button_label' => 'Add Outcome',
                'sub_fields'   => [
                    [
                        'key'   => 'field_project_outcome_text',
                        'label' => 'Outcome',
                        'name'  => 'text',
                        'type'  => 'text',
                    ],
                    [
                        'key'     => 'field_project_outcome_color',
                        'label'   => 'Colour',
                        'name'    => 'color',
                        'type'    => 'select',
                        'choices' => [ 'green' => 'Green', 'blue' => 'Blue', 'pink' => 'Pink' ],
                        'default_value' => 'green',
                    ],
                ],
            ],
            [
                'key'          => 'field_project_url',
                'label'        => 'Case Study URL',
                'name'         => 'project_url',
                'type'         => 'url',
                'instructions' => 'Leave blank to hide the "See the project" button.',
            ],
            [
                'key'         => 'field_project_browser_url',
                'label'       => 'Browser Bar URL',
                'name'        => 'project_browser_url',
                'type'        => 'text',
                'placeholder' => 'e.g. gardenbootcompany.co.uk',
            ],
            [
                'key'           => 'field_project_screenshot',
                'label'         => 'Screenshot',
                'name'          => 'project_screenshot',
                'type'          => 'image',
                'return_format' => 'array',
                'preview_size'  => 'medium',
                'instructions'  => 'If empty, a coloured placeholder is shown instead.',
            ],
            [
                'key'           => 'field_project_placeholder_color',
                'label'         => 'Placeholder Colour',
                'name'          => 'project_placeholder_color',
                'type'          => 'select',
                'choices'       => [ 'green' => 'Green', 'blue' => 'Blue', 'pink' => 'Pink' ],
                'default_value' => 'green',
                'instructions'  => 'Shown when no screenshot is uploaded.',
            ],
        ],
    ] );
}

// ─── Helpers ──────────────────────────────────────────────────────────────────

/**
 * Render heading lines from a repeater.
 * Works with both get_sub_field() context (inside flexible content)
 * and get_field($name, 'option') context (options page).
 *
 * @param array  $rows   Array of rows: [ ['text' => '', 'highlighted' => bool], ... ]
 * @param string $tag    HTML heading tag.
 * @param string $class  CSS class.
 */
function whitbyweb_render_heading_from_rows( array $rows, string $tag = 'h2', string $class = 'section-heading' ): void {
    if ( empty( $rows ) ) {
        return;
    }

    $lines = [];
    foreach ( $rows as $row ) {
        $text = esc_html( $row['text'] ?? '' );
        $lines[] = ! empty( $row['highlighted'] )
            ? '<span class="gradient">' . $text . '</span>'
            : $text;
    }

    printf( '<%1$s class="%2$s">%3$s</%1$s>', esc_attr( $tag ), esc_attr( $class ), implode( '<br>', $lines ) );
}

/**
 * Render heading lines from an ACF sub_field repeater (flexible content context).
 */
function whitbyweb_render_heading( string $field_name, string $tag = 'h2', string $class = 'section-heading' ): void {
    $rows = get_sub_field( $field_name );
    if ( $rows ) {
        whitbyweb_render_heading_from_rows( $rows, $tag, $class );
    }
}

/**
 * Render a button group from an array of button rows.
 *
 * @param array $buttons  Array of rows: [ ['label' => '', 'url' => '', 'style' => ''], ... ]
 */
function whitbyweb_render_buttons_from_rows( array $buttons ): void {
    if ( empty( $buttons ) ) {
        return;
    }

    $arrow = '<span class="btn-arrow"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg></span>';

    echo '<div class="btn-group">';
    foreach ( $buttons as $btn ) {
        $label = $btn['label'] ?? '';
        $url   = $btn['url'] ?? '';
        $style = $btn['style'] ?: 'primary';
        printf(
            '<a href="%s" class="btn btn-%s">%s%s</a>',
            esc_url( $url ),
            esc_attr( $style ),
            esc_html( $label ),
            $style === 'primary' ? $arrow : ''
        );
    }
    echo '</div>';
}

/**
 * Render a button group from an ACF sub_field repeater.
 */
function whitbyweb_render_buttons( string $field_name ): void {
    $rows = get_sub_field( $field_name );
    if ( $rows ) {
        whitbyweb_render_buttons_from_rows( $rows );
    }
}

/**
 * Return inline SVG for a named service icon.
 */
function whitbyweb_service_icon( string $icon ): string {
    $base  = 'width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round"';
    $paths = [
        'new-website' => "<svg $base><rect x='3' y='3' width='18' height='18' rx='2'/><path d='M3 9h18M9 21V9'/></svg>",
        'redesign'    => "<svg $base><path d='M12 20h9'/><path d='M16.5 3.5a2.121 2.121 0 013 3L7 19l-4 1 1-4L16.5 3.5z'/></svg>",
        'speed'       => "<svg $base><path d='M13 2L3 14h9l-1 8 10-12h-9l1-8z'/></svg>",
        'one-page'    => "<svg $base><path d='M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z'/><polyline points='14 2 14 8 20 8'/></svg>",
        'seo'         => "<svg $base><circle cx='11' cy='11' r='8'/><line x1='21' y1='21' x2='16.65' y2='16.65'/></svg>",
        'maintenance' => "<svg $base><path d='M14.7 6.3a1 1 0 000 1.4l1.6 1.6a1 1 0 001.4 0l3.77-3.77a6 6 0 01-7.94 7.94l-6.91 6.91a2.12 2.12 0 01-3-3l6.91-6.91a6 6 0 017.94-7.94l-3.76 3.76z'/></svg>",
        'ecommerce'   => "<svg $base><circle cx='9' cy='21' r='1'/><circle cx='20' cy='21' r='1'/><path d='M1 1h4l2.68 13.39a2 2 0 002 1.61h9.72a2 2 0 002-1.61L23 6H6'/></svg>",
    ];

    return $paths[ $icon ] ?? '';
}
