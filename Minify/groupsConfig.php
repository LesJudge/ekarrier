<?php
/**
 * Groups configuration for default Minify implementation
 * @package Minify
 */
/**
 * You may wish to use the Minify URI Builder app to suggest
 * changes. http://yourdomain/min/builder/
 *
 * See http://code.google.com/p/minify/wiki/CustomSource for other ideas
 * */
$domain = "/" . str_replace("Minify/index.php", "", $_SERVER["PHP_SELF"]);
return array(
    'admin_ugyfelkezelo_edit_js' => array(
        $domain . 'js/tinymce/jscripts/tiny_mce/tiny_mce.js',
        $domain . 'js/dropzone/dropzone.min.js',
        $domain . 'js/uniweb/uniweb.prototype.js',
        $domain . 'js/uniweb/helper/uniweb.helper.uniform.js',
        $domain . 'js/uniweb/helper/uniweb.helper.datetime.js',
        $domain . 'js/uniweb/plugin/jquery.uniweb.clientBaseWidget.js',
        $domain . 'js/uniweb/plugin/jquery.uniweb.clientContact.js',
        $domain . 'js/uniweb/modul/ugyfel/ugyfel_edit_new.js',
        $domain . 'js/uniweb/modul/ugyfel/uniweb.ugyfelkezelo.helper.js',
        $domain . 'modul/ugyfel/Assets/Js/Form/Client/Admin/SheepItEdit.js',
        $domain . 'modul/ugyfel/Assets/Js/Admin/Client/Form/functions.js',
        $domain . 'modul/ugyfel/Assets/Js/Form/Client.js'
    ),
    'admin_ugyfelkezelo_edit_css' => array(
        $domain . 'css/uniweb/sheepit-form.css',
        $domain . 'js/dropzone/css/dropzone.css',
        $domain . 'modul/ugyfel/Assets/Css/Admin/Client/Form/form.css',
        $domain . 'modul/ugyfel/Assets/Css/Admin/Client/Form/tab_contact.css',
        $domain . 'modul/ugyfel/Assets/Css/Admin/Client/Form/tab_document.css',
        $domain . 'modul/ugyfel/Assets/Css/Admin/Client/Form/tab_project.css',
    ),
    'admin_js' => array(
        $domain . '/js/jquery.min.js',
        $domain . '/js/jquery-ui.1.8.6.min.js',
        $domain . '/js/cookie.js',
        $domain . '/js/jquery-validate/jquery.validate.js',
        $domain . '/js/jquery-validate/additional-methods.js',
        $domain . '/js/jquery-validate/localization/messages_hu.js',
        $domain . '/js/jquery.qtip.min.js',
        $domain . '/js/jquery.uniform.min.js',
        $domain . '/js/jquery-ui-timepicker-addon.js',
        $domain . '/js/ui/i18n/jquery.ui.datepicker-hu.js',
        $domain . '/js/jquery-multiselect/jquery.multiselect.min.js',
        $domain . '/js/jquery-multiselect/jquery.multiselect.filter.min.js',
        $domain . '/js/jquery-multiselect2/ui.multiselect.js',
        $domain . '/js/admin/jquery.removeAccents.js',
        $domain . '/js/admin/jquery.autoSuggest.js',
        $domain . '/js/ui/jquery.ui.tabs.js',
        $domain . '/js/fg.menu.js',
        $domain . '/js/jquery.qtip.min.js',
        $domain . '/js/admin/admin.js'
    ),
    'admin_css' => array(
        $domain . '/css/custom-theme/jquery-ui-1.8.6.custom.css',
        $domain . '/css/reset.css',
        $domain . '/css/jquery/uniform/uniform.default.css',
        $domain . '/css/admin_style.css',
        $domain . '/css/theme/blue.css',
        $domain . '/css/admin_fluid.css',
        $domain . '/css/jquery.multiselect.css',
        $domain . '/css/jquery.multiselect.filter.css',
        $domain . '/css/autoSuggest.css'
    ),
    'site_js' => array(
        //$domain.'/js/jquery.min.js',
        $domain . '/js/jquery-1.11.0.min.js',
        //$domain.'/js/jquery-1.7.1.min.js',
        $domain . '/js/jquery-ui-1.10.3.custom.js',
        $domain . '/js/jquery.tip.custom.js',
        $domain . '/js/superfish.js',
        $domain . '/js/jquery-validate/jquery.validate.js',
        $domain . '/js/jquery-validate/additional-methods.js',
        $domain . '/js/jquery-validate/localization/messages_hu.js',
        $domain . '/js/jquery.prettyPhoto.js',
        $domain . '/js/jquery.bxslider.js',
        $domain . '/js/jquery.labelInField.js',
        $domain . '/js/jquery-multiselect/jquery.multiselect.min.js',
        $domain . '/js/jquery-multiselect/jquery.multiselect.filter.min.js',
        $domain . '/js/jquery-multiselect2/ui.multiselect.js',
        $domain . '/js/raphael.js',
        $domain . '/js/raphael.svg.font.js',
        $domain . '/js/jquery.customInputs.js',
        $domain . '/js/site.js'
    ),
    'site_css' => array(
        $domain . '/css/bootstrap.min.css',
        $domain . '/css/fonts/icomoon-style.css',
        $domain . '/css/uw_common_styles.css',
        $domain . '/css/prettyPhoto.css',
        $domain . '/css/custom-theme/jquery-ui-1.10.3.custom.css',
        $domain . '/css/jquery.bxslider.css',
        $domain . '/css/jquery.customInputs.css',
        $domain . '/css/jquery.multiselect.css',
        $domain . '/css/jquery.multiselect.filter.css',
        $domain . '/js/tinymce/jscripts/tiny_mce/themes/advanced/skins/o2k7/user.css',
        $domain . '/css/site.css'
    )
);
