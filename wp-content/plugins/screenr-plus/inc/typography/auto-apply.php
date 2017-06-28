<?php
/**
 * This file help load typography automatically
 *
 * Auto add style for typography settings
 *
 * @see screenr_typography_helper_auto_apply
 */
screenr_typography_helper_auto_apply(
    'screenr_typo_p', // customize setting ID
    'body' // CSS selector
);

screenr_typography_helper_auto_apply(
    'screenr_typo_menu', // customize setting ID
    '.main-navigation, .main-navigation a' // CSS selector
);

screenr_typography_helper_auto_apply(
    'screenr_typo_heading', // customize setting ID
    'body h1, body h2, body h3, body h4, body h5, body h6,
     body .section-title-area .section-title,
     body .section-title-area .section-subtitle, .section-news .entry-grid-title,
     .entry-header .entry-title' // CSS selector
);

screenr_typography_helper_auto_apply(
    'typo_slider_heading', // customize setting ID
    '.swiper-slide-intro h1, .swiper-slide-intro h2, .swiper-slide-intro h3, .swiper-slide-intro h4' // CSS selector
);

screenr_typography_helper_auto_apply(
    'typo_slider_desc', // customize setting ID
    '.swiper-slide-intro p, swiper-slide-intro div' // CSS selector
);

screenr_typography_helper_auto_apply(
    'typo_slider_btn', // customize setting ID
    '.swiper-slide-intro .btn, .swiper-slide-intro p .btn, swiper-slide-intro div .btn' // CSS selector
);

screenr_typography_helper_auto_apply(
    'screenr_typo_logo', // customize setting ID
    '.site-branding, .site-branding .site-title' // CSS selector
);
