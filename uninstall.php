<?php

if (!defined('WP_UNINSTALL_PLUGIN')) {
    die;
}

$rdc_wcc_options = 'rdc_wcc_options';

delete_option($rdc_wcc_options);
delete_site_option($rdc_wcc_options);

?>
