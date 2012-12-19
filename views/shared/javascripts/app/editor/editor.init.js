
/* vim: set expandtab tabstop=2 shiftwidth=2 softtabstop=2 cc=76; */

/**
 * Neatline editor initializer. Enforces the correct startup sequence:
 * Editor => Neatline => Geometry module.
 *
 * @package     omeka
 * @subpackage  neatline
 * @copyright   2012 Rector and Board of Visitors, University of Virginia
 * @license     http://www.apache.org/licenses/LICENSE-2.0.html
 */

Neatline.module('Editor', { startWithParent: false,
  define: function(Editor, Neatline, Backbone, Marionette, $, _) {


  /**
   * Start the editor before running Neatline. This ordering is necessary
   * to ensure that the editor layout retine sets non-zero dimensions on
   * the map container before Neatline starts OpenLayers, which needs to
   * be instantiated on a space-occupying div.
   */
  Neatline.on('initialize:before', function() {
    Editor.start();
  });


  /**
   * Wait until Neatline is running before starting the geometry module,
   * which needs the application map view to be running.
   */
  Neatline.on('initialize:after', function() {
    Editor.Geometry.start();
  });


  /**
   * Initialize the layout.
   */
  Editor.addInitializer(function() {
    this.layout = new Editor.Layout();
  });


  /**
   * Start the router.
   */
  Editor.addInitializer(function() {
    this.router = new Editor.Router();
    Backbone.history.start();
  });


  /**
   * Stop the router.
   */
  Editor.addFinalizer(function() {
    Backbone.history.stop();
  });


}});
