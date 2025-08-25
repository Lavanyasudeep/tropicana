<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Title
    |--------------------------------------------------------------------------
    |
    | Here you can change the default title of your admin panel.
    |
    | For detailed instructions you can look the title section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Basic-Configuration
    |
    */

    'title' => 'Cold Storage Admin Panel',
    'title_prefix' => '',
    'title_postfix' => '',

    /*
    |--------------------------------------------------------------------------
    | Favicon
    |--------------------------------------------------------------------------
    |
    | Here you can activate the favicon.
    |
    | For detailed instructions you can look the favicon section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Basic-Configuration
    |
    */

    'use_ico_only' => false,
    'use_full_favicon' => false,

    /*
    |--------------------------------------------------------------------------
    | Google Fonts
    |--------------------------------------------------------------------------
    |
    | Here you can allow or not the use of external google fonts. Disabling the
    | google fonts may be useful if your admin panel internet access is
    | restricted somehow.
    |
    | For detailed instructions you can look the google fonts section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Basic-Configuration
    |
    */

    'google_fonts' => [
        'allowed' => true,
    ],

    /*
    |--------------------------------------------------------------------------
    | Admin Panel Logo
    |--------------------------------------------------------------------------
    |
    | Here you can change the logo of your admin panel.
    |
    | For detailed instructions you can look the logo section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Basic-Configuration
    |
    */

    // 'logo' => '<b>Cold Storage</b>',
    //'logo_img' => 'vendor/adminlte/dist/img/AdminLTELogo.png',
    'logo_img' => 'images/logo.jpeg',
    'logo_img_class' => 'brand-image',
    'logo_img_xl' => null,
    'logo_img_xl_class' => 'brand-image-xs',
    'logo_img_alt' => 'Admin Logo',

    /*
    |--------------------------------------------------------------------------
    | Authentication Logo
    |--------------------------------------------------------------------------
    |
    | Here you can setup an alternative logo to use on your login and register
    | screens. When disabled, the admin panel logo will be used instead.
    |
    | For detailed instructions you can look the auth logo section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Basic-Configuration
    |
    */

    'auth_logo' => [
        'enabled' => false,
        'img' => [
            'path' => 'vendor/adminlte/dist/img/AdminLTELogo.png',
            'alt' => 'Auth Logo',
            'class' => '',
            'width' => 50,
            'height' => 50,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Preloader Animation
    |--------------------------------------------------------------------------
    |
    | Here you can change the preloader animation configuration. Currently, two
    | modes are supported: 'fullscreen' for a fullscreen preloader animation
    | and 'cwrapper' to attach the preloader animation into the content-wrapper
    | element and avoid overlapping it with the sidebars and the top navbar.
    |
    | For detailed instructions you can look the preloader section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Basic-Configuration
    |
    */

    'preloader' => [
        'enabled' => true,
        'mode' => 'fullscreen',
        'img' => [
            'path' => 'vendor/adminlte/dist/img/AdminLTELogo.png',
            'alt' => 'AdminLTE Preloader Image',
            'effect' => 'animation__shake',
            'width' => 60,
            'height' => 60,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | User Menu
    |--------------------------------------------------------------------------
    |
    | Here you can activate and change the user menu.
    |
    | For detailed instructions you can look the user menu section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Basic-Configuration
    |
    */

    'usermenu_enabled' => true,
    'usermenu_header' => false,
    'usermenu_header_class' => 'bg-primary',
    'usermenu_image' => false,
    'usermenu_desc' => false,
    'usermenu_profile_url' => false,

    /*
    |--------------------------------------------------------------------------
    | Layout
    |--------------------------------------------------------------------------
    |
    | Here we change the layout of your admin panel.
    |
    | For detailed instructions you can look the layout section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Layout-and-Styling-Configuration
    |
    */

    'layout_topnav' => false,
    'layout_boxed' => null,
    'layout_fixed_sidebar' => false,
    'layout_fixed_navbar' => false,
    'layout_fixed_footer' => false,
    'layout_dark_mode' => false,

    /*
    |--------------------------------------------------------------------------
    | Authentication Views Classes
    |--------------------------------------------------------------------------
    |
    | Here you can change the look and behavior of the authentication views.
    |
    | For detailed instructions you can look the auth classes section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Layout-and-Styling-Configuration
    |
    */

    'classes_auth_card' => 'card-outline card-primary',
    'classes_auth_header' => '',
    'classes_auth_body' => '',
    'classes_auth_footer' => '',
    'classes_auth_icon' => '',
    'classes_auth_btn' => 'btn-flat btn-primary',

    /*
    |--------------------------------------------------------------------------
    | Admin Panel Classes
    |--------------------------------------------------------------------------
    |
    | Here you can change the look and behavior of the admin panel.
    |
    | For detailed instructions you can look the admin panel classes here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Layout-and-Styling-Configuration
    |
    */

    'classes_body' => '',
    'classes_brand' => '',
    'classes_brand_text' => '',
    'classes_content_wrapper' => '',
    'classes_content_header' => '',
    'classes_content' => '',
    'classes_sidebar' => 'sidebar-dark-primary elevation-4',
    'classes_sidebar_nav' => '',
    'classes_topnav' => 'navbar-white navbar-light',
    'classes_topnav_nav' => 'navbar-expand',
    'classes_topnav_container' => 'container',

    /*
    |--------------------------------------------------------------------------
    | Sidebar
    |--------------------------------------------------------------------------
    |
    | Here we can modify the sidebar of the admin panel.
    |
    | For detailed instructions you can look the sidebar section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Layout-and-Styling-Configuration
    |
    */

    'sidebar_mini' => 'lg',
    'sidebar_collapse' => false,
    'sidebar_collapse_auto_size' => false,
    'sidebar_collapse_remember' => false,
    'sidebar_collapse_remember_no_transition' => true,
    'sidebar_scrollbar_theme' => 'os-theme-light',
    'sidebar_scrollbar_auto_hide' => 'l',
    'sidebar_nav_accordion' => true,
    'sidebar_nav_animation_speed' => 300,

    /*
    |--------------------------------------------------------------------------
    | Control Sidebar (Right Sidebar)
    |--------------------------------------------------------------------------
    |
    | Here we can modify the right sidebar aka control sidebar of the admin panel.
    |
    | For detailed instructions you can look the right sidebar section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Layout-and-Styling-Configuration
    |
    */

    'right_sidebar' => false,
    'right_sidebar_icon' => 'fas fa-cogs',
    'right_sidebar_theme' => 'dark',
    'right_sidebar_slide' => true,
    'right_sidebar_push' => true,
    'right_sidebar_scrollbar_theme' => 'os-theme-light',
    'right_sidebar_scrollbar_auto_hide' => 'l',

    /*
    |--------------------------------------------------------------------------
    | URLs
    |--------------------------------------------------------------------------
    |
    | Here we can modify the url settings of the admin panel.
    |
    | For detailed instructions you can look the urls section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Basic-Configuration
    |
    */

    'use_route_url' => false,
    'dashboard_url' => 'admin/dashboard',
    'logout_url' => 'logout',
    'login_url' => 'login',
    'register_url' => 'register',
    'password_reset_url' => 'password/reset',
    'password_email_url' => 'password/email',
    'profile_url' => 'admin/profile',
    'disable_darkmode_routes' => false,

    /*
    |--------------------------------------------------------------------------
    | Laravel Asset Bundling
    |--------------------------------------------------------------------------
    |
    | Here we can enable the Laravel Asset Bundling option for the admin panel.
    | Currently, the next modes are supported: 'mix', 'vite' and 'vite_js_only'.
    | When using 'vite_js_only', it's expected that your CSS is imported using
    | JavaScript. Typically, in your application's 'resources/js/app.js' file.
    | If you are not using any of these, leave it as 'false'.
    |
    | For detailed instructions you can look the asset bundling section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Other-Configuration
    |
    */

    'laravel_asset_bundling' => false,
    'laravel_css_path' => 'resources/css/app.css',
    'laravel_js_path' => 'resources/js/app.js',

    /*
    |--------------------------------------------------------------------------
    | Menu Items
    |--------------------------------------------------------------------------
    |
    | Here we can modify the sidebar/top navigation of the admin panel.
    |
    | For detailed instructions you can look here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Menu-Configuration
    |
    */

    'menu' => [
        // Navbar items:
        [
            'type' => 'navbar-search',
            'text' => 'Search',
            'topnav_right' => true,
        ],
        [
            'type' => 'fullscreen-widget',
            'topnav_right' => true,
        ],

        // Sidebar items:
        [
            'type' => 'sidebar-menu-search',
            'text' => 'Search',
        ],
        // [
        //     'text' => 'blog',
        //     'url' => 'admin/blog',
        //     'can' => 'manage-blog',
        // ],
        [
            'text' => 'Dashboard',
            'url' => 'admin/dashboard',
            'icon' => 'fas fa-chart-pie',
            'label' => 4,
            'label_color' => 'success',
        ],
        [
            'text' => 'Flowboard',
            'url' => 'admin/product-flow',
            'icon' => 'fas fa-project-diagram',
        ],
        [
            'text' => 'Sales Module',
            'icon' => 'fas fa-file-alt',
            'submenu' => [
                [
                    'text' => 'Forms',
                    'icon' => 'fas fa-file-alt',
                    'submenu' => [
                        [
                            'text' => 'Customer Enquiry',
                            'url' => 'admin/sales/customer-enquiry',
                            'icon' => 'fas fa-file-alt',
                        ],
                        [
                            'text' => 'Sales Quotation',
                            'url' => 'admin/sales/sales-quotation',
                            'icon' => 'fas fa-file-signature',
                        ],
                        [
                            'text' => 'Sales Order',
                            'url' => '',
                            'icon' => 'fas fa-file-alt',
                        ],
                        [
                            'text' => 'Customer Contract',
                            'url' => '',
                            'icon' => 'fas fa-file-alt',
                        ]
                    ]
                ],
                [
                    'text' => 'Report',
                    'icon' => 'fas fa-file-alt',
                    'submenu' => [
                        [
                            'text' => 'Menu',
                            'url' => '',
                            'icon' => 'fas fa-file',
                        ]
                    ]
                ],
                [
                    'text' => 'Setup',
                    'icon' => 'fas fa-file-alt',
                    'submenu' => [
                        [
                            'text' => 'Customer',
                            'url' => 'admin/master/sales/customer',
                            'icon' => 'fas fa-user-tag',
                        ],
                    ]
                ]
            ]
        ],
        [
            'text' => 'Purchase Module',
            'icon' => 'fas fa-shopping-cart',
            'submenu' => [
                [
                    'text' => 'Forms',
                    'icon' => 'fas fa-file-alt',
                    'submenu' => [
                        [
                            'text' => 'Menu',
                            'url' => '',
                            'icon' => 'fas fa-file',
                        ]
                    ]
                ],
                [
                    'text' => 'Report',
                    'icon' => 'fas fa-file-alt',
                    'submenu' => [
                        [
                            'text' => 'Menu',
                            'url' => '',
                            'icon' => 'fas fa-file',
                        ]
                    ]
                ],
                [
                    'text' => 'Setup',
                    'icon' => 'fas fa-file-alt',
                    'submenu' => [
                        [
                            'text' => 'Supplier',
                            'url' => 'admin/master/purchase/supplier',
                            'icon' => 'fas fa-truck-loading',
                        ]
                    ]
                ]
            ]
        ],
        [
            'text' => 'Inventory Module',
            'icon' => 'fas fa-warehouse',
            'submenu' => [
                [
                    'text' => 'Forms',
                    'icon' => 'fas fa-file-alt',
                    'submenu' => [
                        [
                            'text' => 'Packing List',
                            'url' => 'admin/inventory/packing-list',
                            'icon' => 'fas fa-file',
                        ],
                        [
                            'text' => 'GRN',
                            'url' => 'admin/purchase/grn',
                            'icon' => 'fas fa-file-invoice',
                        ],
                        [
                            'text' => 'Inward',
                            'url' => 'admin/inventory/inward',
                            'icon' => 'fas fa-arrow-down',
                        ],
                        [
                            'text' => 'Pick List',
                            'url' => 'admin/inventory/pick-list',
                            'icon' => 'fas fa-dolly',
                        ],
                        [
                            'text' => 'Outward',
                            'url' => 'admin/inventory/outward',
                            'icon' => 'fas fa-arrow-up',
                        ],
                        [
                            'text' => 'Stock Adjustment',
                            'url' => 'admin/inventory/stock-adjustment',
                            'icon' => 'fas fa-exchange-alt',
                        ],
                        [
                            'text' => 'Storage Room',
                            'url' => 'admin/inventory/storage-room',
                            'icon' => 'fas fa-warehouse',
                        ],
                        [
                            'text' => 'Gatepass',
                            'url' => 'admin/inventory/gatepass',
                            'icon' => 'fas fa-id-badge',
                        ],
                    ]
                ],
                [
                    'text' => 'Reports',
                    'icon' => 'fas fa-file-alt',
                    'submenu' => [
                        [
                            'text' => 'Stock Summary Report',
                            'url' => 'admin/report/stock-summary',
                            'icon' => 'fas fa-file',
                        ],
                        [
                            'text' => 'Stock Detail Report',
                            'url' => 'admin/report/stock-detail',
                            'icon' => 'fas fa-file',
                        ],
                    ]
                ],
                [
                    'text' => 'Setup',
                    'icon' => 'fas fa-file-alt',
                    'submenu' => [
                        [
                            'text' => 'Room',
                            'url' => 'admin/master/inventory/rooms',
                            'icon' => 'fas fa-warehouse',
                        ],
                        [
                            'text' => 'Block',
                            'url' => 'admin/master/inventory/blocks',
                            'icon' => 'fas fa-cube',
                        ],
                        [
                            'text' => 'Rack',
                            'url' => 'admin/master/inventory/racks',
                            'icon' => 'fas fa-boxes',
                        ],
                        [
                            'text' => 'Slot',
                            'url' => 'admin/master/inventory/slots',
                            'icon' => 'fas fa-layer-group',
                        ],
                        [
                            'text' => 'Pallets',
                            'url' => 'admin/master/inventory/pallets',
                            'icon' => 'fas fa-pallet',
                        ],
                        [
                            'text' => 'Pallet Type',
                            'url' => 'admin/master/inventory/pallet-type',
                            'icon' => 'fas fa-clipboard-list',
                        ],
                        [
                            'text' => 'Box Count',
                            'url' => 'admin/master/inventory/box-count',
                            'icon' => 'fas fa-cubes',
                        ],
                        [
                            'text' => 'Product Attribute',
                            'url' => 'admin/master/inventory/product-attributes',
                            'icon' => 'fas fa-tags',
                        ],
                    ]
                ],
            ]
        ],
        [
            'text' => 'Accounting Module',
            'icon' => 'fas fa-wallet',
            'submenu' => [
                [
                    'text' => 'Forms',
                    'icon' => 'fas fa-file-alt',
                    'submenu' => [
                        [
                            'text' => 'Payment',
                            'url' => 'admin/accounting/payment',
                            'icon' => 'fas fa-file',
                        ],
                        [
                            'text' => 'Receipt',
                            'url' => '',
                            'icon' => 'fas fa-file',
                        ],
                        [
                            'text' => 'Journal',
                            'url' => '',
                            'icon' => 'fas fa-file',
                        ]
                    ]
                ],
                [
                    'text' => 'Report',
                    'icon' => 'fas fa-file-alt',
                    'submenu' => [
                        [
                            'text' => 'Supplier Ledger',
                            'url' => '',
                            'icon' => 'fas fa-file',
                        ],
                        [
                            'text' => 'General Ledger',
                            'url' => '',
                            'icon' => 'fas fa-file',
                        ]
                    ]
                ],
                [
                    'text' => 'Setup',
                    'icon' => 'fas fa-file-alt',
                    'submenu' => [
                        [
                            'text' => 'Chart of Account',
                            'url' => 'admin/master/accounting/chart-of-account',
                            'icon' => 'fas fa-sitemap',
                        ],
                        [
                            'text' => 'Analytical',
                            'url' => 'admin/master/accounting/analytical',
                            'icon' => 'fas fa-file',
                        ],
                        [
                            'text' => 'Payment Purpose',
                            'url' => 'admin/master/accounting/payment-purpose',
                            'icon' => 'fas fa-file',
                        ]
                    ]
                ]
            ]
        ],
        [
            'text' => 'HR Module',
            'icon' => 'fas fa-users',
            'submenu' => [
                [
                    'text' => 'Forms',
                    'icon' => 'fas fa-file-alt',
                    'submenu' => [
                        [
                            'text' => 'Menu',
                            'url' => '',
                            'icon' => 'fas fa-file',
                        ]
                    ]
                ],
                [
                    'text' => 'Report',
                    'icon' => 'fas fa-file-alt',
                    'submenu' => [
                        [
                            'text' => 'Menu',
                            'url' => '',
                            'icon' => 'fas fa-file',
                        ]
                    ]
                ],
                [
                    'text' => 'Setup',
                    'icon' => 'fas fa-file-alt',
                    'submenu' => [
                        [
                            'text' => 'Employee',
                            'url' => 'admin/master/hr/employee',
                            'icon' => 'fas fa-user-tie',
                        ],
                        [
                            'text' => 'User',
                            'url' => 'admin/master/hr/user',
                            'icon' => 'fas fa-user',
                        ],
                    ]
                ]
            ]
        ],
        [
            'text' => 'Admin Module',
            'icon' => 'fas fa-tools',
            'submenu' => [
                [
                    'text' => 'Master',
                    'icon' => 'fas fa-cogs',
                    'submenu' => [
                        [
                            'text' => 'Company',
                            'url' => 'admin/master/general/company',
                            'icon' => 'fas fa-building',
                        ],
                        [
                            'text' => 'Branch',
                            'url' => 'admin/master/general/branch',
                            'icon' => 'fas fa-cubes',
                        ],
                        [
                            'text' => 'Tax',
                            'url' => 'admin/master/general/tax',
                            'icon' => 'fas fa-receipt',
                        ],
                        [
                            'text' => 'Unit',
                            'url' => 'admin/master/general/unit',
                            'icon' => 'fas fa-ruler',
                        ],
                        [
                            'text' => 'Product Type',
                            'url' => 'admin/master/general/product-type',
                            'icon' => 'fas fa-box',
                        ],
                        [
                            'text' => 'Product Type Price',
                            'url' => 'admin/master/general/product-type-price',
                            'icon' => 'fas fa-rupee-sign',
                        ],
                        [
                            'text' => 'Menu',
                            'url' => 'admin/master/general/menu',
                            'icon' => 'fas fa-bars',
                        ],
                        [
                            'text' => 'Role',
                            'url' => 'admin/master/general/role',
                            'icon' => 'fas fa-user-shield',
                        ]
                    ],
                ],
                [
                    'text' => 'Bulk Import',
                    'icon' => 'fas fa-file-import',
                    'submenu' => [
                        [
                            'text' => 'Insert/Import',
                            'url' => 'admin/bulk-import/new',
                            'icon' => 'fas fa-plus-square',
                        ],
                        [
                            'text' => 'Update',
                            'url' => 'admin/bulk-import/existing',
                            'icon' => 'fas fa-edit',
                        ],
                    ],
                ],
                [
                    'text' => 'General',
                    'icon' => 'fas fa-tools',
                    'submenu' => [
                        [
                            'text' => 'Profile',
                            'url' => 'admin/profile',
                            'icon' => 'fas fa-fw fa-user',
                        ],
                        [
                            'text' => 'Change Password',
                            'url' => 'admin/change-password',
                            'icon' => 'fas fa-fw fa-lock',
                        ],
                        [
                            'text' => 'Settings',
                            'url' => 'admin/settings',
                            'icon' => 'fas fa-fw fa-cog',
                        ]
                    ],
                ],
            ]
        ]
        
        // ['header' => 'account_settings'],
        
        // [
        //     'text' => 'multilevel',
        //     'icon' => 'fas fa-fw fa-share',
        //     'submenu' => [
        //         [
        //             'text' => 'level_one',
        //             'url' => '#',
        //         ],
        //         [
        //             'text' => 'level_one',
        //             'url' => '#',
        //             'submenu' => [
        //                 [
        //                     'text' => 'level_two',
        //                     'url' => '#',
        //                 ],
        //                 [
        //                     'text' => 'level_two',
        //                     'url' => '#',
        //                     'submenu' => [
        //                         [
        //                             'text' => 'level_three',
        //                             'url' => '#',
        //                         ],
        //                         [
        //                             'text' => 'level_three',
        //                             'url' => '#',
        //                         ],
        //                     ],
        //                 ],
        //             ],
        //         ],
        //         [
        //             'text' => 'level_one',
        //             'url' => '#',
        //         ],
        //     ],
        // ],
        // ['header' => 'labels'],
        // [
        //     'text' => 'important',
        //     'icon_color' => 'red',
        //     'url' => '#',
        // ],
        // [
        //     'text' => 'warning',
        //     'icon_color' => 'yellow',
        //     'url' => '#',
        // ],
        // [
        //     'text' => 'information',
        //     'icon_color' => 'cyan',
        //     'url' => '#',
        // ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Menu Filters
    |--------------------------------------------------------------------------
    |
    | Here we can modify the menu filters of the admin panel.
    |
    | For detailed instructions you can look the menu filters section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Menu-Configuration
    |
    */

    'filters' => [
        JeroenNoten\LaravelAdminLte\Menu\Filters\GateFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\HrefFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\SearchFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\ActiveFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\ClassesFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\LangFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\DataFilter::class,
    ],

    /*
    |--------------------------------------------------------------------------
    | Plugins Initialization
    |--------------------------------------------------------------------------
    |
    | Here we can modify the plugins used inside the admin panel.
    |
    | For detailed instructions you can look the plugins section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Plugins-Configuration
    |
    */

    'plugins' => [
        'Datatables' => [
            'active' => true,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => true,
                    'location' => '//cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js',
                ],
                [
                    'type' => 'js',
                    'asset' => true,
                    'location' => '//cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js',
                ],
                [
                    'type' => 'css',
                    'asset' => true,
                    'location' => '//cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css',
                ],
            ],
        ],
        'Select2' => [
            'active' => true,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => true,
                    'location' => '//cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js',
                ],
                [
                    'type' => 'css',
                    'asset' => true,
                    'location' => '//cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.css',
                ],
            ],
        ],
        'Chartjs' => [
            'active' => false,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.0/Chart.bundle.min.js',
                ],
            ],
        ],
        'Sweetalert2' => [
            'active' => true,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => true,
                    'location' => '//cdn.jsdelivr.net/npm/sweetalert2@8',
                ],
            ],
        ],
        'Pace' => [
            'active' => false,
            'files' => [
                [
                    'type' => 'css',
                    'asset' => false,
                    'location' => '//cdnjs.cloudflare.com/ajax/libs/pace/1.0.2/themes/blue/pace-theme-center-radar.min.css',
                ],
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdnjs.cloudflare.com/ajax/libs/pace/1.0.2/pace.min.js',
                ],
            ],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | IFrame
    |--------------------------------------------------------------------------
    |
    | Here we change the IFrame mode configuration. Note these changes will
    | only apply to the view that extends and enable the IFrame mode.
    |
    | For detailed instructions you can look the iframe mode section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/IFrame-Mode-Configuration
    |
    */

    'iframe' => [
        'default_tab' => [
            'url' => null,
            'title' => null,
        ],
        'buttons' => [
            'close' => true,
            'close_all' => true,
            'close_all_other' => true,
            'scroll_left' => true,
            'scroll_right' => true,
            'fullscreen' => true,
        ],
        'options' => [
            'loading_screen' => 1000,
            'auto_show_new_tab' => true,
            'use_navbar_items' => true,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Livewire
    |--------------------------------------------------------------------------
    |
    | Here we can enable the Livewire support.
    |
    | For detailed instructions you can look the livewire here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Other-Configuration
    |
    */

    'livewire' => false,

    'assets' => [
        'css' => [
            'css/custom.css',  // Add this line
        ],
    ],
];
