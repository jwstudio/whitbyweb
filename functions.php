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
        '1.3.0'
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

// ─── ACF Field Groups ─────────────────────────────────────────────────────────

add_action( 'acf/init', 'whitbyweb_register_acf_fields' );

function whitbyweb_register_acf_fields() {
    if ( ! function_exists( 'acf_add_local_field_group' ) ) {
        return;
    }

    // ── Heading Lines sub-fields (reused across multiple layouts) ────────────
    $heading_lines_field = [
        'key'        => 'field_heading_lines',
        'label'      => 'Heading Lines',
        'name'       => 'heading_lines',
        'type'       => 'repeater',
        'instructions' => 'Each row is one line of the heading. Tick "Highlighted" to wrap that line in the gradient colour.',
        'layout'     => 'table',
        'min'        => 1,
        'button_label' => 'Add Line',
        'sub_fields' => [
            [
                'key'          => 'field_heading_line_text',
                'label'        => 'Text',
                'name'         => 'text',
                'type'         => 'text',
                'column_width' => '75',
            ],
            [
                'key'          => 'field_heading_line_highlight',
                'label'        => 'Highlighted',
                'name'         => 'highlighted',
                'type'         => 'true_false',
                'ui'           => 1,
                'column_width' => '25',
            ],
        ],
    ];

    // ── Button repeater sub-fields ───────────────────────────────────────────
    $buttons_field = [
        'key'          => 'field_buttons',
        'label'        => 'Buttons',
        'name'         => 'buttons',
        'type'         => 'repeater',
        'layout'       => 'table',
        'button_label' => 'Add Button',
        'sub_fields'   => [
            [
                'key'   => 'field_btn_label',
                'label' => 'Label',
                'name'  => 'label',
                'type'  => 'text',
            ],
            [
                'key'   => 'field_btn_url',
                'label' => 'URL',
                'name'  => 'url',
                'type'  => 'url',
            ],
            [
                'key'     => 'field_btn_style',
                'label'   => 'Style',
                'name'    => 'style',
                'type'    => 'select',
                'choices' => [
                    'primary'   => 'Primary',
                    'secondary' => 'Secondary',
                ],
                'default_value' => 'primary',
            ],
        ],
    ];

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
                                'key'   => 'field_hero_pill_text',
                                'label' => 'Pill Text',
                                'name'  => 'pill_text',
                                'type'  => 'text',
                                'placeholder' => 'e.g. Ask about our one-page websites',
                            ],
                            whitbyweb_make_unique( $heading_lines_field, 'hero' ),
                            [
                                'key'   => 'field_hero_lead',
                                'label' => 'Lead Paragraph',
                                'name'  => 'lead',
                                'type'  => 'textarea',
                                'rows'  => 3,
                            ],
                            whitbyweb_make_unique( $buttons_field, 'hero' ),
                            [
                                'key'         => 'field_hero_form_id',
                                'label'       => 'Formidable Form ID',
                                'name'        => 'form_id',
                                'type'        => 'number',
                                'instructions' => 'The numeric ID of the Formidable form to embed in the card.',
                                'default_value' => 1,
                            ],
                            [
                                'key'   => 'field_hero_form_title',
                                'label' => 'Form Card Title',
                                'name'  => 'form_title',
                                'type'  => 'text',
                                'default_value' => 'Get a free quote',
                            ],
                            [
                                'key'   => 'field_hero_form_subtitle',
                                'label' => 'Form Card Subtitle',
                                'name'  => 'form_subtitle',
                                'type'  => 'text',
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
                        ],
                    ],

                    // ── Services ─────────────────────────────────────────
                    'layout_services' => [
                        'key'        => 'layout_services',
                        'name'       => 'services',
                        'label'      => 'Services',
                        'display'    => 'block',
                        'sub_fields' => [
                            [
                                'key'           => 'field_services_eyebrow',
                                'label'         => 'Eyebrow',
                                'name'          => 'eyebrow',
                                'type'          => 'text',
                                'default_value' => 'What We Do',
                            ],
                            whitbyweb_make_unique( $heading_lines_field, 'services' ),
                            [
                                'key'   => 'field_services_lead',
                                'label' => 'Lead Paragraph',
                                'name'  => 'lead',
                                'type'  => 'textarea',
                                'rows'  => 3,
                            ],
                            [
                                'key'          => 'field_services_cards',
                                'label'        => 'Service Cards',
                                'name'         => 'service_cards',
                                'type'         => 'repeater',
                                'layout'       => 'block',
                                'button_label' => 'Add Service',
                                'sub_fields'   => [
                                    [
                                        'key'     => 'field_svc_icon',
                                        'label'   => 'Icon',
                                        'name'    => 'icon',
                                        'type'    => 'select',
                                        'choices' => [
                                            'new-website'  => 'New Website',
                                            'redesign'     => 'Redesign & Rebuild',
                                            'speed'        => 'Speed Optimisation',
                                            'one-page'     => 'One-Page Website',
                                            'seo'          => 'SEO',
                                            'maintenance'  => 'Maintenance',
                                            'ecommerce'    => 'E-commerce',
                                            'custom'       => 'Custom (paste SVG below)',
                                        ],
                                        'default_value' => 'new-website',
                                    ],
                                    [
                                        'key'          => 'field_svc_icon_custom',
                                        'label'        => 'Custom Icon SVG',
                                        'name'         => 'icon_custom',
                                        'type'         => 'textarea',
                                        'instructions' => 'Paste the full &lt;svg&gt; tag here. Only used when Icon = "Custom".',
                                        'rows'         => 4,
                                        'conditional_logic' => [
                                            [ [ 'field' => 'field_svc_icon', 'operator' => '==', 'value' => 'custom' ] ],
                                        ],
                                    ],
                                    [
                                        'key'   => 'field_svc_title',
                                        'label' => 'Title',
                                        'name'  => 'title',
                                        'type'  => 'text',
                                    ],
                                    [
                                        'key'   => 'field_svc_body',
                                        'label' => 'Body',
                                        'name'  => 'body',
                                        'type'  => 'textarea',
                                        'rows'  => 3,
                                    ],
                                    [
                                        'key'          => 'field_svc_tags',
                                        'label'        => 'Tags',
                                        'name'         => 'tags',
                                        'type'         => 'text',
                                        'instructions' => 'Comma-separated. e.g. Design, Development, WordPress',
                                    ],
                                ],
                            ],
                            [
                                'key'   => 'field_services_cta_eyebrow',
                                'label' => 'CTA Card — Eyebrow',
                                'name'  => 'cta_eyebrow',
                                'type'  => 'text',
                                'default_value' => 'Based in Devon',
                            ],
                            whitbyweb_make_unique( $heading_lines_field, 'services_cta' ),
                            [
                                'key'   => 'field_services_cta_body',
                                'label' => 'CTA Card — Body',
                                'name'  => 'cta_body',
                                'type'  => 'textarea',
                                'rows'  => 2,
                            ],
                            whitbyweb_make_unique( $buttons_field, 'services_cta' ),
                            [
                                'key'   => 'field_services_cta_photo',
                                'label' => 'CTA Card — Photo',
                                'name'  => 'cta_photo',
                                'type'  => 'image',
                                'return_format' => 'array',
                                'preview_size'  => 'medium',
                            ],
                        ],
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
                            whitbyweb_make_unique( $heading_lines_field, 'work' ),
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
                                'instructions'  => 'Leave blank or set to -1 to show all.',
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

                    // ── One-Page Promo ────────────────────────────────────
                    'layout_one_page_promo' => [
                        'key'        => 'layout_one_page_promo',
                        'name'       => 'one_page_promo',
                        'label'      => 'One-Page Promo',
                        'display'    => 'block',
                        'sub_fields' => [
                            [
                                'key'           => 'field_opp_eyebrow',
                                'label'         => 'Eyebrow',
                                'name'          => 'eyebrow',
                                'type'          => 'text',
                                'default_value' => 'One-Page Websites',
                            ],
                            whitbyweb_make_unique( $heading_lines_field, 'opp' ),
                            [
                                'key'   => 'field_opp_lead',
                                'label' => 'Lead Paragraph',
                                'name'  => 'lead',
                                'type'  => 'textarea',
                                'rows'  => 3,
                            ],
                            whitbyweb_make_unique( $buttons_field, 'opp' ),
                            [
                                'key'           => 'field_opp_card_eyebrow',
                                'label'         => 'Feature Card Eyebrow',
                                'name'          => 'card_eyebrow',
                                'type'          => 'text',
                                'default_value' => "What's included",
                            ],
                            [
                                'key'          => 'field_opp_features',
                                'label'        => 'Features',
                                'name'         => 'features',
                                'type'         => 'repeater',
                                'layout'       => 'table',
                                'button_label' => 'Add Feature',
                                'sub_fields'   => [
                                    [
                                        'key'   => 'field_opp_feat_title',
                                        'label' => 'Title',
                                        'name'  => 'title',
                                        'type'  => 'text',
                                    ],
                                    [
                                        'key'   => 'field_opp_feat_sub',
                                        'label' => 'Subtitle',
                                        'name'  => 'sub',
                                        'type'  => 'text',
                                    ],
                                ],
                            ],
                        ],
                    ],

                    // ── CTA ───────────────────────────────────────────────
                    'layout_cta' => [
                        'key'        => 'layout_cta',
                        'name'       => 'cta',
                        'label'      => 'CTA Banner',
                        'display'    => 'block',
                        'sub_fields' => [
                            [
                                'key'           => 'field_cta_eyebrow',
                                'label'         => 'Eyebrow',
                                'name'          => 'eyebrow',
                                'type'          => 'text',
                                'default_value' => 'Get in Touch',
                            ],
                            whitbyweb_make_unique( $heading_lines_field, 'cta' ),
                            [
                                'key'   => 'field_cta_lead',
                                'label' => 'Lead Paragraph',
                                'name'  => 'lead',
                                'type'  => 'textarea',
                                'rows'  => 3,
                            ],
                            whitbyweb_make_unique( $buttons_field, 'cta' ),
                            [
                                'key'            => 'field_cta_portrait',
                                'label'          => 'Portrait Image',
                                'name'           => 'portrait',
                                'type'           => 'image',
                                'return_format'  => 'array',
                                'preview_size'   => 'medium',
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
                            whitbyweb_make_unique( $heading_lines_field, 'contact' ),
                            [
                                'key'   => 'field_contact_subtext',
                                'label' => 'Sub-text',
                                'name'  => 'subtext',
                                'type'  => 'text',
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
                                'key'   => 'field_contact_email',
                                'label' => 'Email Address',
                                'name'  => 'email',
                                'type'  => 'email',
                            ],
                            [
                                'key'   => 'field_contact_fb_url',
                                'label' => 'Facebook URL',
                                'name'  => 'facebook_url',
                                'type'  => 'url',
                            ],
                            [
                                'key'   => 'field_contact_ig_url',
                                'label' => 'Instagram URL',
                                'name'  => 'instagram_url',
                                'type'  => 'url',
                            ],
                            [
                                'key'   => 'field_contact_li_url',
                                'label' => 'LinkedIn URL',
                                'name'  => 'linkedin_url',
                                'type'  => 'url',
                            ],
                            [
                                'key'         => 'field_contact_form_id',
                                'label'       => 'Formidable Form ID',
                                'name'        => 'form_id',
                                'type'        => 'number',
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
                        'choices' => [
                            'green' => 'Green',
                            'blue'  => 'Blue',
                            'pink'  => 'Pink',
                        ],
                        'default_value' => 'green',
                    ],
                ],
            ],
            [
                'key'           => 'field_project_url',
                'label'         => 'Case Study URL',
                'name'          => 'project_url',
                'type'          => 'url',
                'instructions'  => 'Leave blank to hide the "See the project" button.',
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
                'instructions'  => 'If empty, a placeholder is shown instead.',
            ],
            [
                'key'           => 'field_project_placeholder_color',
                'label'         => 'Placeholder Colour',
                'name'          => 'project_placeholder_color',
                'type'          => 'select',
                'choices'       => [
                    'green' => 'Green',
                    'blue'  => 'Blue',
                    'pink'  => 'Pink',
                ],
                'default_value' => 'green',
                'instructions'  => 'Shown when no screenshot is uploaded.',
                'conditional_logic' => [
                    [ [ 'field' => 'field_project_screenshot', 'operator' => '==', 'value' => '' ] ],
                ],
            ],
        ],
    ] );
}

// ─── Helpers ──────────────────────────────────────────────────────────────────

/**
 * Clone a shared sub-field array with unique keys for each layout context.
 * ACF requires every field key to be globally unique.
 */
function whitbyweb_make_unique( array $field, string $context ): array {
    $field['key']  = $field['key'] . '_' . $context;
    $field['name'] = $field['name'];  // name stays the same — accessed via get_sub_field()

    if ( ! empty( $field['sub_fields'] ) ) {
        foreach ( $field['sub_fields'] as &$sub ) {
            $sub['key'] = $sub['key'] . '_' . $context;
            if ( ! empty( $sub['sub_fields'] ) ) {
                foreach ( $sub['sub_fields'] as &$subsub ) {
                    $subsub['key'] = $subsub['key'] . '_' . $context;
                }
            }
        }
        unset( $sub );
    }

    return $field;
}

/**
 * Render heading lines from a repeater field.
 * Each row: text (string) + highlighted (bool).
 * Outputs lines joined with <br>, wrapping highlighted ones in .gradient span.
 *
 * @param string $field_name  ACF field name (e.g. 'heading_lines').
 * @param string $tag         HTML tag: h1, h2, h3 …
 * @param string $class       CSS class for the element.
 */
function whitbyweb_render_heading( string $field_name, string $tag = 'h2', string $class = 'section-heading' ): void {
    if ( ! have_rows( $field_name ) ) {
        return;
    }

    $lines = [];
    while ( have_rows( $field_name ) ) {
        the_row();
        $text        = get_sub_field( 'text' );
        $highlighted = get_sub_field( 'highlighted' );
        $lines[]     = $highlighted
            ? '<span class="gradient">' . esc_html( $text ) . '</span>'
            : esc_html( $text );
    }

    printf(
        '<%1$s class="%2$s">%3$s</%1$s>',
        esc_attr( $tag ),
        esc_attr( $class ),
        implode( '<br>', $lines )
    );
}

/**
 * Render a button group from a repeater field.
 *
 * @param string $field_name  ACF field name (e.g. 'buttons').
 */
function whitbyweb_render_buttons( string $field_name ): void {
    if ( ! have_rows( $field_name ) ) {
        return;
    }

    echo '<div class="btn-group">';
    $arrow = '<span class="btn-arrow"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg></span>';

    while ( have_rows( $field_name ) ) {
        the_row();
        $label  = get_sub_field( 'label' );
        $url    = get_sub_field( 'url' );
        $style  = get_sub_field( 'style' ) ?: 'primary';
        $is_primary = $style === 'primary';

        printf(
            '<a href="%s" class="btn btn-%s">%s%s</a>',
            esc_url( $url ),
            esc_attr( $style ),
            esc_html( $label ),
            $is_primary ? $arrow : ''
        );
    }

    echo '</div>';
}

/**
 * Return inline SVG for a named service icon.
 */
function whitbyweb_service_icon( string $icon ): string {
    $base = 'width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round"';

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
