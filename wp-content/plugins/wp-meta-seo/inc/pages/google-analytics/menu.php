<h2 class="nav-tab-wrapper" style="display: none;">
    <a class="nav-tab <?php echo (empty($_GET['view']))?"nav-tab-active":"" ?>" href="<?php echo admin_url('admin.php?page=metaseo_google_analytics') ?>"><?php _e('Google Analytics Report','wp-meta-seo') ?></a>
    <a class="nav-tab <?php echo (isset($_GET['view']) && $_GET['view'] == 'wpmsga_trackcode')?"nav-tab-active":"" ?>" href="<?php echo admin_url('admin.php?page=metaseo_google_analytics&view=wpmsga_trackcode') ?>"><?php _e('Tracking code','wp-meta-seo') ?></a>
</h2>