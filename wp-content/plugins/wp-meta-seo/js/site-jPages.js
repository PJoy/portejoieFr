(function ($) {
    $(document).ready(function () {
        
        /*
         * Paging list pages
         */
        $(".holder_sitemaps_pages").jPages({
            containerID: "sitemap_pages",
            previous: "←",
            next: "→",
            perPage: 50,
            delay: 20
        });
        
        /*
         * Paging list posts
         */
        $(".holder_sitemaps_posts").jPages({
            containerID: "sitemap_posts",
            previous: "←",
            next: "→",
            perPage: 50,
            delay: 20
        });
        
        /*
         * Paging list menus
         */
        $.each(wpms_avarible.wpms_display_column_menus, function (i, v) {
            $(".holder_sitemaps_menus_" + i).jPages({
                containerID: "sitemap_menus_" + i,
                previous: "←",
                next: "→",
                perPage: 50,
                delay: 20
            });
        });

    });
}(jQuery));