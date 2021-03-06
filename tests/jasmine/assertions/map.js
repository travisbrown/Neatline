
/* vim: set expandtab tabstop=2 shiftwidth=2 softtabstop=2 cc=76; */

/**
 * @package     omeka
 * @subpackage  neatline
 * @copyright   2012 Rector and Board of Visitors, University of Virginia
 * @license     http://www.apache.org/licenses/LICENSE-2.0.html
 */


var NL = (function(NL) {


  /**
   * Assert the current viewport zoom and focus.
   *
   * @param {Number} lon: The focus longitude.
   * @param {Number} lat: The focus latitude.
   * @param {Number} zoom: The zoom.
   */
  NL.assertMapViewport = function(lon, lat, zoom) {
    expect(this.vw.MAP.map.getCenter().lon).toEqual(lon);
    expect(this.vw.MAP.map.getCenter().lat).toEqual(lat);
    expect(this.vw.MAP.map.getZoom()).toEqual(zoom);
  };


  /**
   * Assert that the last query was a map extent query.
   */
  NL.assertMapExtentQuery = function() {

    // Should trigger GET request to /records.
    this.assertLastRequestRoute(Neatline.global.records_api);
    this.assertLastRequestMethod('GET');

    // Should filter on extent and zoom.
    this.assertLastRequestHasGetParameter('extent');
    this.assertLastRequestHasGetParameter('zoom');

  };


  /**
   * Assert the number of vector layers.
   *
   * @param {Number} count: The number.
   */
  NL.assertVectorLayerCount = function(count) {
    expect(this.vw.MAP.getVectorLayers().length).toEqual(count);
  };


  /**
   * Assert the number of WMS layers.
   *
   * @param {Number} count: The number.
   */
  NL.assertWmsLayerCount = function(count) {
    expect(this.vw.MAP.getWmsLayers().length).toEqual(count);
  };


  /**
   * Assert that all features on a layer have the `default` intent.
   *
   * @param {OpenLayers.Layer.Vector} layer: The layer.
   */
  NL.assertDefaultIntent = function(layer) {
    _.each(layer.features, function(feature) {
      expect(feature.renderIntent).toEqual('default');
    });
  };


  /**
   * Assert that all features on a layer have the `temporary` intent.
   *
   * @param {OpenLayers.Layer.Vector} layer: The layer.
   */
  NL.assertTemporaryIntent = function(layer) {
    _.each(layer.features, function(feature) {
      expect(feature.renderIntent).toEqual('temporary');
    });
  };


  /**
   * Assert that all features on a layer have the `select` intent.
   *
   * @param {OpenLayers.Layer.Vector} layer: The layer.
   */
  NL.assertSelectIntent = function(layer) {
    _.each(layer.features, function(feature) {
      expect(feature.renderIntent).toEqual('select');
    });
  };


  return NL;


})(NL || {});
