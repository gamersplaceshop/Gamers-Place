/**
* This file is a dummy file that doesn't do anything except
* does a fake registration of every CartzillaGB block so that
* the WordPress plugin directory detects them and lists them
* in the CartzillaGB plugin page.
*
* This file is auto-generated from the build process.
*/

registerBlockType( 'czgb/accordion', {
	title: __( 'Accordion', i18n ),
	description: __( 'A title that your visitors can toggle to view more text. Use as FAQs or multiple ones for an Accordion.', i18n ),
	icon: AccordionIcon,
	category: 'cartzillagb',
	example: {},
	keywords: [
		__( 'Accordion', i18n ),
		__( 'Toggle', i18n ),
		__( 'CartzillaGB', i18n ),
	],
	attributes: schema,
	supports: {
		inserter: ! disabledBlocks.includes( name ), // Hide if disabled.
	},

	edit,
	save,

	// CartzillaGB modules.
	modules: {
		'advanced-responsive': true,
		'block-title': true,
	},
} )
registerBlockType( 'czgb/banner-with-products-carousel', {
	title: __( 'Banner With Products Carousel', i18n ),
	icon: HeaderIcon,
	category: 'cartzillagb',
	example: {},
	keywords: [
		__( 'CartzillaGb', i18n ),
	],
	attributes: schema,
	description: __( 'A styled banner with products carousel that you can add other blocks inside. Use this to create unique layouts.', i18n ),
	supports: {
		inserter: ! disabledBlocks.includes( name ), // Hide if disabled.
	},

	edit,
	save,

	// CartzillaGB modules.
	modules: {
		'advanced-general': true,
		'advanced-responsive': true,
		'advanced-block-spacing': true,
		'custom-css': {
			default: applyFilters( 'cartzillagb.banner-with-products-carousel.custom-css.default', '' ),
		},
	},
} )
registerBlockType( 'czgb/banner', {
    title: __( 'Banner', i18n ),
    description: __( 'Capture the attention of your audience with Banners that calls to an action.', i18n ),
    icon: HeaderIcon,
    category: 'cartzillagb',
    example: {},
    keywords: [
        __( 'Banner', i18n ),
        __( 'CartzillaGB', i18n ),
    ],
    attributes: schema,
    supports: {
        inserter: ! disabledBlocks.includes( name ), // Hide if disabled.
    },

    edit,
    save,

    // CartzillaGB modules.
    modules: {
        'advanced-responsive': true,
    },
} )
registerBlockType( 'czgb/blog-post', {
    title: __( 'Blog Posts', i18n ),
    description: __( 'Display a list of posts from your Blog.', i18n ),
    icon: BlogPostsIcon,
    example: {},
    category: 'cartzillagb',
    keywords: [
        __( 'Blog Posts Block', i18n ),
        __( 'CartzillaGB', i18n ),
    ],
    attributes: schema,
    supports: {
        inserter: ! disabledBlocks.includes( name ), // Hide if disabled.
    },

    edit,
    save,

    // cartzillaGB modules.
    modules: {
        'advanced-responsive': true,
        'block-title': true,
    },
} )
registerBlockType( 'czgb/brands', {
	title: __( 'Brands', i18n ),
	description: __( 'Add brands block.', i18n ),
	icon: HeaderIcon,
	example: {},
	category: 'cartzillagb',
	keywords: [
		__( 'Brands', i18n ),
		__( 'CartzillaGB', i18n ),
	],
	attributes: schema,
	supports: {
		inserter: ! disabledBlocks.includes( name ), // Hide if disabled.
	},

	edit,
	save,

	// cartzillaGB modules.
    modules: {
    	'advanced-responsive': true,
        'block-title': true,
    },
} )
registerBlockType( 'czgb/button', {
    title: __( 'Button', i18n ),
    icon: ButtonIcon,
    category: 'cartzillagb',
    example: {},
    keywords: [
        __( 'Button', i18n ),
        __( 'CartzillaGB', i18n ),
    ],
    attributes: schema,
    supports: {
        inserter: ! disabledBlocks.includes( name ), // Hide if disabled.
    },

    edit,
    save,

    // CartzillaGB modules.
    modules: {
        'advanced-responsive': true,
    },
} )
registerBlockType( 'czgb/cta', {
	title: __( 'Call to Action', i18n ),
	description: __( 'A small section you can use to call the attention of your visitors. Great for calling attention to your products or deals.', i18n ),
	icon: CTAIcon,
	category: 'cartzillagb',
	keywords: [
		__( 'Call to Action', i18n ),
		__( 'CartzillaGB', i18n ),
		__( 'CTA', i18n ),
	],
	attributes: schema,
	supports: {
		align: [ 'center', 'wide', 'full' ],
		inserter: ! disabledBlocks.includes( name ), // Hide if disabled.
	},

	deprecated,
	edit,
	save,

	// CartzillaGB modules.
	modules: {
		'advanced-general': true,
		'advanced-block-spacing': true,
		'advanced-column-spacing': {
			columnGap: false,
		},
		'advanced-responsive': true,
		'block-background': true,
		'block-separators': true,
		// 'block-title': true,
		'content-align': true,
		'block-designs': true,
		'custom-css': {
			default: applyFilters( 'cartzillagb.cta.custom-css.default', '' ),
		},
	},
} )
registerBlockType( 'czgb/cards', {
	title: __( 'Cards Block', i18n ),
	description: __( 'Describe a single subject in a small card. You can use this to describe your product, service or a person.', i18n ),
	icon: BlogPostsIcon,
	category: 'cartzillagb',
	example: {},
	keywords: [
		__( 'cards', i18n ),
		__( 'CartzillaGb', i18n ),
	],
	attributes: schema,
	supports: {
		inserter: ! disabledBlocks.includes( name ), // Hide if disabled.
	},

	edit,
	save,

	// CartzillaGB modules.
	modules: {
		'advanced-responsive': true,
	},
} )
registerBlockType( 'czgb/category-block', {
    title: __( 'Image Grid', i18n ),
    description: __( 'Display images in a grid with links.', i18n ),
    icon: HeaderIcon,
    category: 'cartzillagb',
    example: {},
    keywords: [
        __( 'Category Block', i18n ),
        __( 'CartzillaGB', i18n ),
    ],
    attributes: schema,
    supports: {
        inserter: ! disabledBlocks.includes( name ), // Hide if disabled.
    },

    edit,
    save,

    // CartzillaGB modules.
    modules: {
        'advanced-responsive': true,
    },
} )
registerBlockType( 'czgb/columns', {
    title: __( 'Columns', i18n ),
    description: __( 'The columns block lets you create multi-column layouts within your content area, and include other blocks inside each column.', i18n ),
    icon: ColumnsIcon,
    example: {},
    category: 'cartzillagb',
    keywords: [
        __( 'Columns', i18n ),
        __( 'cartzillaGB', i18n ),
    ],
    attributes: schema,

    supports: {
        inserter: ! disabledBlocks.includes( name ), // Hide if disabled.
    },

    edit,
    save,

    // CartzillaGB modules.
    modules: {
        'advanced-responsive': true,
    },
} )
registerBlockType( 'czgb/contact-details', {
	title: __( 'Contact Details', i18n ),
	description: __( 'Allows you to list various contact information in the Contact Page', i18n ),
	icon: IconListIcon,
	category: 'cartzillagb',
	example: {},
	keywords: [
		__( 'outlet-store', i18n ),
		__( 'CartzillaGb', i18n ),
	],
	attributes: schema,
	supports: {
		inserter: ! disabledBlocks.includes( name ), // Hide if disabled.
	},

	edit,
	save,

	// CartzillaGB modules.
	modules: {
		'advanced-responsive': true,
	},
} )
registerBlockType( 'czgb/container', {
	title: __( 'Container', i18n ),
	icon: ContainerIcon,
	category: 'cartzillagb',
	example: {},
	keywords: [
		__( 'container', i18n ),
		__( 'CartzillaGb', i18n ),
	],
	attributes: schema,
	description: __( 'A styled container that you can add other blocks inside. Use this to create unique layouts.', i18n ),
	supports: {
		inserter: ! disabledBlocks.includes( name ), // Hide if disabled.
	},

	edit,
	save,

	// CartzillaGB modules.
	modules: {
		'advanced-responsive': true,
	},
} )
registerBlockType( 'czgb/deals-block', {
	title: __( 'Deal Banner', i18n ),
	description: __( 'Capture your audience attention with a deal banner that has a countdown timer.', i18n ),
	icon: PricingBoxIcon,
	category: 'cartzillagb',
	example: {},
	keywords: [
        __( 'Deal Banner', i18n ),
        __( 'Countdown Timer', i18n ),
		__( 'deals-block', i18n ),
		__( 'CartzillaGB', i18n ),
	],
	attributes: schema,
	supports: {
		inserter: ! disabledBlocks.includes( name ), // Hide if disabled.
	},

	edit,
	save,

	// CartzillaGB modules.
	modules: {
		'advanced-responsive': true,
	},
} )
registerBlockType( 'czgb/features-list-block', {
	title: __( 'Features Block', i18n ),
	icon: IconBlock,
	category: 'cartzillagb',
	example: {},
	keywords: [
		__( 'features-blocks', i18n ),
		__( 'CartzillaGb', i18n ),
	],
	attributes: schema,
	supports: {
		inserter: ! disabledBlocks.includes( name ), // Hide if disabled.
	},

	edit,
	save,

	// CartzillaGB modules.
	modules: {
		'advanced-responsive': true,
	},
} )
registerBlockType( 'czgb/footer', {
    title: __( 'Footer' ),
    description: __( 'A website footer is found at the bottom of your site pages. It typically includes important informations.' ),
    icon: BlogPostsIcon,
    example: {},
    category: 'cartzillagb',
    keywords: [
        __( 'Footer' ),
        __( 'CartzillaGb' ),
    ],
    supports: {
        inserter: ! disabledBlocks.includes( name ), // Hide if disabled.
    },
    attributes: schema,

    edit,
    save,

    // CartzillaGB modules.
    // modules: {
    //     'advanced-responsive': true,
    // },
} )
registerBlockType( 'czgb/header', {
    title: __( 'Header' ),
    description: __( 'A large header title area. Typically used at the very top of a page.' ),
    icon: BlogPostsIcon,
    example: {},
    category: 'cartzillagb',
    keywords: [
        __( 'Header' ),
        __( 'CartzillaGb' ),
    ],
    supports: {
        inserter: ! disabledBlocks.includes( name ), // Hide if disabled.
    },
    attributes: schema,

    edit,
    save,

    // CartzillaGB modules.
    // modules: {
    //     'advanced-responsive': true,
    // },
} )
registerBlockType( 'czgb/hero-block', {
    title: __( 'Hero Block', i18n ),
    description: __( 'A large hero area. Typically used at the very top of a page.', i18n ),
    icon: HeaderIcon,
    category: 'cartzillagb',
    example: {},
    keywords: [
        __( 'Hero Block', i18n ),
        __( 'Cartzillagb', i18n ),
    ],
    attributes: schema,
    supports: {
        inserter: ! disabledBlocks.includes( name ), // Hide if disabled.
    },

    edit,
    save,

    // CartzillaGB modules.
    modules: {
        'advanced-responsive': true,
    },
} )
registerBlockType( 'czgb/hero-carousel', {
    title: __( 'Hero Carousel #1', i18n ),
    description: __( 'Start building your website with Hero carousel #1.', i18n ),
    icon: HeaderIcon,
    category: 'cartzillagb',
    example: {},
    keywords: [
        __( 'Hero Carousel', i18n ),
        __( 'CartzillaGb', i18n ),
    ],
    attributes: schema,
    supports: {
        inserter: ! disabledBlocks.includes( name ), // Hide if disabled.
    },

    edit,
    save,

    // CartzillaGB modules.
    modules: {
        'advanced-responsive': true,
        'custom-css': {
            default: applyFilters( 'cartzillagb.hero-carousel.custom-css.default', '' ),
        },
    },
} )
registerBlockType( 'czgb/hero-carousel-2', {
    title: __( 'Hero Carousel #2', i18n ),
    description: __( 'Start building your website with Hero carousel #2.', i18n ),
    icon: HeaderIcon,
    category: 'cartzillagb',
    example: {},
    keywords: [
        __( 'Hero Carousel 2', i18n ),
        __( 'CartzillaGb', i18n ),
    ],
    attributes: schema,
    supports: {
        inserter: ! disabledBlocks.includes( name ), // Hide if disabled.
    },

    edit,
    save,

    // CartzillaGB modules.
    modules: {
        'advanced-responsive': true,
        'custom-css': {
            default: applyFilters( 'cartzillagb.hero-carousel-2.custom-css.default', '' ),
        },
    },
} )
registerBlockType( 'czgb/hero-carousel-3', {
    title: __( 'Hero Carousel #3', i18n ),
    description: __( 'Start building your website with Hero carousel #3.', i18n ),
    icon: HeaderIcon,
    category: 'cartzillagb',
    example: {},
    keywords: [
        __( 'Hero Carousel', i18n ),
        __( 'CartzillaGb', i18n ),
    ],
    attributes: schema,
    supports: {
        inserter: ! disabledBlocks.includes( name ), // Hide if disabled.
    },

    edit,
    save,

    // CartzillaGB modules.
    modules: {
        'advanced-responsive': true,
        'custom-css': {
            default: applyFilters( 'cartzillagb.hero-carousel-3.custom-css.default', '' ),
        },
    },
} )
registerBlockType( 'czgb/icon-blocks', {
	title: __( 'Icon Blocks', i18n ),
	icon: IconBlock,
	category: 'cartzillagb',
	description: __( 'Start building your website with dozens of ready-to-use icon blocks.', i18n  ),
	example: {},
	keywords: [
		__( 'icon-blocks', i18n ),
		__( 'CartzillaGb', i18n ),
	],
	attributes: schema,
	supports: {
		inserter: ! disabledBlocks.includes( name ), // Hide if disabled.
	},

	edit,
	save,

	// CartzillaGB modules.
	modules: {
		'advanced-responsive': true,
	},
} )
registerBlockType( 'czgb/info-card', {
    title: __( 'Info Card', i18n ),
    description: __( 'Start building your website with info card.', i18n ),
    icon: InfoIcon,
    category: 'cartzillagb',
    example: {},
    keywords: [
        __( 'Info Card', i18n ),
        __( 'CartzillaGB', i18n ),
    ],
    attributes: schema,
    supports: {
        inserter: ! disabledBlocks.includes( name ), // Hide if disabled.
    },

    edit,
    save,

    // CartzillaGB modules.
    modules: {
        'advanced-responsive': true,
    },
} )
registerBlockType( 'czgb/info-section-1', {
	title: __( 'Info Section #1 Block', i18n ),
	description: __( 'Be creatively informative with Cartzillagb Info Sections.', i18n ),
	icon: BlogPostsIcon,
	category: 'cartzillagb',
	example: {},
	keywords: [
		__( 'Info Section', i18n ),
		__( 'CartzillaGb', i18n ),
	],
	attributes: schema,
	supports: {
		inserter: ! disabledBlocks.includes( name ), // Hide if disabled.
	},

	edit,
	save,

	// CartzillaGB modules.
	modules: {
		'advanced-responsive': true,
	},
} )
registerBlockType( 'czgb/info-section-2', {
	title: __( 'Info Section #2 Block', i18n ),
	description: __( 'Be creatively informative with Cartzillagb Info Sections.', i18n ),
	icon: BlogPostsIcon,
	category: 'cartzillagb',
	example: {},
	keywords: [
		__( 'Info Section', i18n ),
		__( 'CartzillaGb', i18n ),
	],
	attributes: schema,
	supports: {
		inserter: ! disabledBlocks.includes( name ), // Hide if disabled.
	},

	edit,
	save,

	// CartzillaGB modules.
	modules: {
		'advanced-responsive': true,
	},
} )
registerBlockType( 'czgb/market-button', {
    title: __( 'App Market Buttons', i18n ),
    description: __( 'Create app market buttons to link to app marketplaces like App Store, Google Play, Windows and Amazon.', i18n ),
    icon: ButtonIcon,
    category: 'cartzillagb',
    example: {},
    keywords: [
        __( 'App Market Buttons', i18n ),
        __( 'CartzillaGB', i18n ),
    ],
    attributes: schema,
    supports: {
        inserter: ! disabledBlocks.includes( name ), // Hide if disabled.
    },

    edit,
    save,

    // CartzillaGB modules.
    modules: {
        'advanced-responsive': true,
    },
} )
registerBlockType( 'czgb/megamenu-nav-menu', {
    title: __( 'Megamenu Nav Menu', i18n ),
    description: __( 'A Megamenu Nav Menu block given to a large panel of content which is displayed below a menu item when the user clicks or hovers over the menu item', i18n ),
    icon: BlogPostsIcon,
    example: {},
    category: 'cartzillagb',
    keywords: [
        __( 'Megamenu Nav Menu', i18n ),
        __( 'CartzillaGb', i18n ),
    ],
    supports: {
        inserter: ! disabledBlocks.includes( name ), // Hide if disabled.
    },
    attributes: schema,

    edit,
    save,

    // CartzillaGB modules.
    // modules: {
    //     'advanced-responsive': true,
    // },
} )
registerBlockType( 'czgb/outlet-store', {
	title: __( 'Stores', i18n ),
	description: __( 'Allows you to list information about your outlets in the Contact Page', i18n ),
	icon: BlogPostsIcon,
	category: 'cartzillagb',
	example: {},
	keywords: [
		__( 'outlet-store', i18n ),
		__( 'CartzillaGb', i18n ),
	],
	attributes: schema,
	supports: {
		inserter: ! disabledBlocks.includes( name ), // Hide if disabled.
	},

	edit,
	save,

	// CartzillaGB modules.
	modules: {
		'advanced-responsive': true,
	},
} )
registerBlockType( 'czgb/products-carousel', {
	title: __( 'Products Carousel', i18n ),
	icon: HeaderIcon,
	category: 'cartzillagb',
	example: {},
	keywords: [
		__( 'CartzillaGb', i18n ),
	],
	attributes: schema,
	description: __( 'A styled products carousel that you can add other blocks inside. Use this to create unique layouts.', i18n ),
	supports: {
		inserter: ! disabledBlocks.includes( name ), // Hide if disabled.
	},

	edit,
	save,

	// CartzillaGB modules.
	modules: {
		'advanced-general': true,
		'advanced-responsive': true,
		'advanced-block-spacing': true,
		'custom-css': {
			default: applyFilters( 'cartzillagb.products-carousel.custom-css.default', '' ),
		},
	},
} )
registerBlockType( 'czgb/products-list', {
	title: __( 'Products List Block', i18n ),
	description: __( 'Add products list block.', i18n ),
	icon: ButtonIcon,
	category: 'cartzillagb',
	example: {},
	keywords: [
		__( 'Products', i18n ),
		__( 'cartzillaGB', i18n ),
	],
	attributes: schema,
	supports: {
		inserter: ! disabledBlocks.includes( name ), // Hide if disabled.
	},

	edit,
	save,
} )
registerBlockType( 'czgb/products-with-header', {
	title: __( 'Products Block', i18n ),
	icon: HeaderIcon,
	category: 'cartzillagb',
	example: {},
	keywords: [
		__( 'Products', i18n ),
		__( 'CartzillaGb', i18n ),
	],
	attributes: schema,
	description: __( 'A styled products with header that you can add other blocks inside. Use this to create unique layouts.', i18n ),
	supports: {
		inserter: ! disabledBlocks.includes( name ), // Hide if disabled.
	},

	edit,
	save,

	// CartzillaGB modules.
	modules: {
		'advanced-general': true,
		'advanced-responsive': true,
		'advanced-block-spacing': true,
		'custom-css': {
			default: applyFilters( 'cartzillagb.products-with-header.custom-css.default', '' ),
		},
	},
} )
registerBlockType( 'czgb/review-carousel', {
	title: __( 'Testimonials', i18n ),
	description: __( 'Display reviews & testimonials from your customers in a carousel.', i18n ),
	icon: IconListIcon,
	category: 'cartzillagb',
	example: {},
	keywords: [
		__( 'review-carousel', i18n ),
		__( 'CartzillaGb', i18n ),
	],
	attributes: schema,
	supports: {
		inserter: ! disabledBlocks.includes( name ), // Hide if disabled.
	},

	edit,
	save,

	// CartzillaGB modules.
	modules: {
		'advanced-responsive': true,
	},
} )
registerBlockType( 'czgb/seller-block', {
	title: __( 'Seller Block', i18n ),
	icon: IconListIcon,
	category: 'cartzillagb',
	example: {},
	keywords: [
		__( 'CartzillaGb', i18n ),
	],
	attributes: schema,
	supports: {
		inserter: ! disabledBlocks.includes( name ), // Hide if disabled.
	},

	edit,
	save,

	// CartzillaGB modules.
	// modules: {
	// 	'advanced-responsive': true,
	// },
} )
registerBlockType( 'czgb/shortcode', {
	title: __( 'Advanced Shortcode', i18n ),
	description: __( 'Add a shortcode to your page.', i18n ),
	example: {},
	category: 'cartzillagb',
	keywords: [
		__( 'Advanced Shortcode', i18n ),
		__( 'CartzillaGB', i18n ),
	],
	attributes: schema,

	edit,
	save,

	supports: {
		inserter: ! disabledBlocks.includes( name ), // Hide if disabled.
	}
} )
registerBlockType( 'czgb/team-member', {
	title: __( 'Team Member', i18n ),
	icon: TeamMemberIcon,
	category: 'cartzillagb',
	example: {},
	keywords: [
		__( 'team-member', i18n ),
		__( 'CartzillaGb', i18n ),
	],
	attributes: schema,
	description: __( 'Display members of your team or your office. Use multiple Team Member blocks if you have a large team.', i18n ),
	supports: {
		inserter: ! disabledBlocks.includes( name ), // Hide if disabled.
	},

	edit,
	save,

	// CartzillaGB modules.
	modules: {
		'advanced-responsive': true,
	},
} )
registerBlockType( 'czgb/youtube-feed-block', {
	title: __( 'YouTube Feed Block', i18n ),
	icon: HeaderIcon,
	category: 'cartzillagb',
	example: {},
	keywords: [
		__( 'CartzillaGb', i18n ),
	],
	attributes: schema,
	description: __( 'Display a YouTube Feed like block in your website. ', i18n ),
	supports: {
		inserter: ! disabledBlocks.includes( name ), // Hide if disabled.
	},

	edit,
	save,

	// CartzillaGB modules.
	modules: {
		'advanced-responsive': true,
	},
} )