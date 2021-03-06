<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4 cc=76; */

/**
 * @package     omeka
 * @subpackage  neatline
 * @copyright   2012 Rector and Board of Visitors, University of Virginia
 * @license     http://www.apache.org/licenses/LICENSE-2.0.html
 */


/**
 * Include static files for the exhibit form.
 */
function nl_queueExhibitForm()
{
    queue_css_file('payloads/exhibit-form');
    queue_js_file('payloads/exhibit-form');
}


/**
 * Include static files for the exhibit.
 *
 * @param NeatlineExhibit The exhibit.
 */
function nl_queueNeatlinePublic($exhibit)
{

    nl_queueGoogleMapsApi();

    queue_css_file('payloads/neatline-public');
    queue_js_file('payloads/neatline-public');
    queue_js_file('bootstrap');

    fire_plugin_hook('neatline_public_static', array(
        'exhibit' => $exhibit
    ));

}


/**
 * Include static files for the editor.
 *
 * @param NeatlineExhibit The exhibit.
 */
function nl_queueNeatlineEditor($exhibit)
{

    nl_queueGoogleMapsApi();

    queue_css_file('payloads/neatline-editor');
    queue_js_file('payloads/neatline-editor');
    queue_js_file('payloads/ckeditor/ckeditor');
    queue_js_file('bootstrap');

    fire_plugin_hook('neatline_editor_static', array(
        'exhibit' => $exhibit
    ));

}


/**
 * Include exhibit-specific theme assets.
 *
 * @param NeatlineExhibit $exhibit The exhibit.
 */
function nl_queueExhibitTheme($exhibit)
{
    nl_queueExhibitCss($exhibit);
    nl_queueExhibitJs($exhibit);
}


/**
 * Include exhibit-specific CSS assets.
 *
 * @param NeatlineExhibit $exhibit The exhibit.
 */
function nl_queueExhibitCss($exhibit)
{
    foreach (glob(nl_getExhibitThemeDir($exhibit).'/*.css') as $file) {
        queue_css_file(basename($file, '.css'), null, false,
            "exhibits/themes/$exhibit->slug"
        );
    }
}


/**
 * Include exhibit-specific JS assets.
 *
 * @param NeatlineExhibit $exhibit The exhibit.
 */
function nl_queueExhibitJs($exhibit)
{
    foreach (glob(nl_getExhibitThemeDir($exhibit).'/*.js') as $file) {
        queue_js_file(basename($file, '.js'),
            "exhibits/themes/$exhibit->slug"
        );
    }
}


/**
 * Include the Google Maps API.
 */
function nl_queueGoogleMapsApi()
{
    nl_appendScript(
        'http://maps.google.com/maps/api/js?sensor=false'
    );
}


/**
 * Append a script to the <head> tag.
 *
 * @param string $script The script location.
 */
function nl_appendScript($script)
{
    get_view()->headScript()->appendScript(
        '', 'text/javascript', array('src' => $script)
    );
}


/**
 * Form the path to an exhibit's custom theme assets.
 *
 * @param string The theme path.
 */
function nl_getExhibitThemeDir($exhibit)
{

    return PUBLIC_THEME_DIR.'/'.get_option('public_theme').
        "/neatline/exhibits/themes/$exhibit->slug";

}
