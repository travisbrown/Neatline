
/* vim: set expandtab tabstop=2 shiftwidth=2 softtabstop=2 cc=76; */

/**
 * @package     omeka
 * @subpackage  neatline
 * @copyright   2012 Rector and Board of Visitors, University of Virginia
 * @license     http://www.apache.org/licenses/LICENSE-2.0.html
 */


var NL = (function(NL) {


  /**
   * Load neatline application.
   */
  NL.loadNeatline = function() {
    loadFixtures('neatline-partial.html');
    loadStyleFixtures('neatline-public.css');
    this.__initNeatline();
  };


  /**
   * Load editor application.
   */
  NL.loadEditor = function() {
    loadFixtures('editor-partial.html');
    loadStyleFixtures('neatline-editor.css');
    this.__initEditor();
  };


  /**
   * Mock the server, start Neatline.
   */
  NL.__initNeatline = function() {
    this.server = sinon.fakeServer.create();
    this.startApplication();
    this.aliasNeatline();
  };


  /**
   * Mock the server, start the editor.
   */
  NL.__initEditor = function() {
    this.server = sinon.fakeServer.create();
    this.startApplication();
    this.aliasEditor();
    this.navigate('');
  };


  /**
   * (Re)start the application.
   */
  NL.startApplication = function() {
    window.location.hash = null;
    Backbone.history.stop();
    this.stopApplication();
    Neatline.start();
  };


  /**
   * Recursively stop all modules.
   */
  NL.stopApplication = function() {
    _.each(Neatline.submodules, function(m) { m.stop(); });
    Neatline._initCallbacks.reset();
  };


  /**
   * Navigate to a route, forcing refresh.
   *
   * @param {String} fragment: The URL fragment.
   */
  NL.navigate = function(fragment) {
    Backbone.history.fragment = null;
    Backbone.history.navigate(fragment, true);
  };


  /**
   * Simulate a click on an element.
   *
   * @param {Object} el: The anchor element.
   */
  NL.click = function(el) {
    el.click();
    this.navigate(el.attr('href'));
  };


  /**
   * Navigate to the record list.
   *
   * @param {Object} response: The response body.
   */
  NL.showRecordList = function(response) {
    this.navigate('records');
    this.respondLast200(response);
  };


  /**
   * Navigate to the edit form for the first record.
   *
   * @param {Object} response: The response body.
   */
  NL.showRecordForm = function(response) {
    this.navigate('record/'+JSON.parse(response).id);
    this.respondLast200(response);
  };


  /**
   * Navigate to the exhibit styles form.
   *
   * @param {Object} response: The response body.
   */
  NL.showStyles = function(response) {
    this.navigate('styles');
    this.respondLast200(response);
  };


  return NL;


})(NL || {});
