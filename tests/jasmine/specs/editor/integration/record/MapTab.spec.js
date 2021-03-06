
/* vim: set expandtab tabstop=2 shiftwidth=2 softtabstop=2 cc=76; */

/**
 * @package     omeka
 * @subpackage  neatline
 * @copyright   2012 Rector and Board of Visitors, University of Virginia
 * @license     http://www.apache.org/licenses/LICENSE-2.0.html
 */

describe('Record Form Map Tab', function() {


  var el, fx = {
    record: read('EditorRecord.record.json')
  };


  beforeEach(function() {

    NL.loadEditor();
    NL.showRecordForm(fx.record);
    NL.vw.RECORD.activateTab('map');

    el = {
      pan:      NL.vw.RECORD.$('input[value="pan"]'),
      point:    NL.vw.RECORD.$('input[value="point"]'),
      line:     NL.vw.RECORD.$('input[value="line"]'),
      poly:     NL.vw.RECORD.$('input[value="poly"]'),
      svg:      NL.vw.RECORD.$('input[value="svg"]'),
      regPoly:  NL.vw.RECORD.$('input[value="regPoly"]'),
      modify:   NL.vw.RECORD.$('input[value="modify"]'),
      rotate:   NL.vw.RECORD.$('input[value="rotate"]'),
      resize:   NL.vw.RECORD.$('input[value="resize"]'),
      drag:     NL.vw.RECORD.$('input[value="drag"]'),
      remove:   NL.vw.RECORD.$('input[value="remove"]'),
      coverage: NL.vw.RECORD.$('textarea[name="coverage"]'),
      clear:    NL.vw.RECORD.$('a[name="clear"]'),
      parse:    NL.vw.RECORD.$('a[name="parse"]')
    };

  });


  it('should set draw point mode', function() {

    // --------------------------------------------------------------------
    // The "Draw Point" radio should enable point-drawing on the map.
    // --------------------------------------------------------------------

    // Check "Draw Point".
    el.pan.removeAttr('checked');
    el.point.attr('checked', 'checked').trigger('change');

    // "Draw Point" should be active.
    expect(NL.vw.MAP.controls.point.active).toBeTruthy();

  });


  it('should set draw line mode', function() {

    // --------------------------------------------------------------------
    // The "Draw Line" radio should enable line-drawing on the map.
    // --------------------------------------------------------------------

    // Check "Draw Line".
    el.pan.removeAttr('checked');
    el.line.attr('checked', 'checked').trigger('change');

    // "Draw Line" should be active.
    expect(NL.vw.MAP.controls.line.active).toBeTruthy();

  });


  it('should set draw polygon mode', function() {

    // --------------------------------------------------------------------
    // The "Draw Polygon" radio should enable polygon-drawing on the map.
    // --------------------------------------------------------------------

    // Check "Draw Polygon".
    el.pan.removeAttr('checked');
    el.poly.attr('checked', 'checked').trigger('change');

    // "Draw Polygon" should be active.
    expect(NL.vw.MAP.controls.poly.active).toBeTruthy();

  });


  it('should set draw SVG mode', function() {

    // --------------------------------------------------------------------
    // The "Draw SVG" radio should enable SVG-drawing on the map.
    // --------------------------------------------------------------------

    // Check "Draw SVG".
    el.pan.removeAttr('checked');
    el.svg.attr('checked', 'checked').trigger('change');

    // "Draw SVG" should be active.
    expect(NL.vw.MAP.controls.svg.active).toBeTruthy();

  });


  it('should set draw regular polygon mode', function() {

    // --------------------------------------------------------------------
    // The "Draw Regular Polygon" radio should enable regular-polygon-
    // drawing on the map.
    // --------------------------------------------------------------------

    // Check "Draw Regular Polygon".
    el.pan.removeAttr('checked');
    el.regPoly.attr('checked', 'checked').trigger('change');

    // "Draw Regular Polygon" should be active.
    expect(NL.vw.MAP.controls.regPoly.active).toBeTruthy();

  });


  it('should set sides', function() {

    // --------------------------------------------------------------------
    // When the value in "Sides" input is changed, the `sides` property on
    // the modifyFeature control should be updated.
    // --------------------------------------------------------------------

    // Set sides.
    NL.vw.SPATIAL.__ui.sides.val('10').trigger('change');

    // "Sides" should be updated.
    expect(NL.vw.MAP.controls.regPoly.handler.sides).toEqual(10);

  });


  it('should block invalid sides', function() {

    // --------------------------------------------------------------------
    // When a value below 3 or a string is entered into the "Sides" input,
    // the `sides` property should default to 3.
    // --------------------------------------------------------------------

    // Numbers below 3:
    _.each(_.range(-1, 2), function(v) {
      NL.vw.SPATIAL.__ui.sides.val(v).trigger('change');
      expect(NL.vw.MAP.controls.regPoly.handler.sides).toEqual(3);
    });

    // String:
    NL.vw.SPATIAL.__ui.sides.val('invalid').trigger('change');
    expect(NL.vw.MAP.controls.regPoly.handler.sides).toEqual(3);

  });


  it('should set snap angle', function() {

    // --------------------------------------------------------------------
    // When the value in "Snap Angle" is changed, the `snapAngle` property
    // on the modifyFeature control should be updated.
    // --------------------------------------------------------------------

    // Set snap angle.
    NL.vw.SPATIAL.__ui.snap.val('45').trigger('change');

    // "Snap Angle" should be updated.
    expect(NL.vw.MAP.controls.regPoly.handler.snapAngle).toEqual(45);

  });


  it('should block invalid snap angle', function() {

    // --------------------------------------------------------------------
    // When a negative value or a string is entered into the "Snap Angle"
    // input, the `snapAngle` property should default to 0.
    // --------------------------------------------------------------------

    // Negative number:
    NL.vw.SPATIAL.__ui.snap.val('-1').trigger('change');
    expect(NL.vw.MAP.controls.regPoly.handler.snapAngle).toEqual(0);

    // String:
    NL.vw.SPATIAL.__ui.snap.val('invalid').trigger('change');
    expect(NL.vw.MAP.controls.regPoly.handler.snapAngle).toEqual(0);

  });


  it('should set irregular', function() {

    // --------------------------------------------------------------------
    // When the "Irregular" checkbox is changed, the `irregular` property
    // on the modifyFeature control should be updated.
    // --------------------------------------------------------------------

    // Set irregular.
    NL.vw.SPATIAL.__ui.irreg.attr('checked', 'checked').trigger('change');

    // "Irregular" be active.
    expect(NL.vw.MAP.controls.regPoly.handler.irregular).toEqual(true);

    // Unset irregular.
    NL.vw.SPATIAL.__ui.irreg.removeAttr('checked').trigger('change');

    // "Irregular" should be inactive.
    expect(NL.vw.MAP.controls.regPoly.handler.irregular).toEqual(false);

  });


  it('should set modify shape mode', function() {

    // --------------------------------------------------------------------
    // When the "Modify Shape" radio button is selected, the corresponding
    // modifyFeature control should be activated on the map.
    // --------------------------------------------------------------------

    // Check "Modify Shape".
    el.pan.removeAttr('checked');
    el.modify.attr('checked', 'checked').trigger('change');

    // Edit control should be active.
    expect(NL.vw.MAP.controls.edit.active).toBeTruthy();

    // Reshape should be active.
    expect(NL.vw.MAP.controls.edit.mode).toEqual(
      OpenLayers.Control.ModifyFeature.RESHAPE
    );

  });


  it('should set rotate shape mode', function() {

    // --------------------------------------------------------------------
    // When the "Rotate Shape" radio button is selected, the corresponding
    // modifyFeature control should be activated on the map.
    // --------------------------------------------------------------------

    // Check "Rotate Shape".
    el.pan.removeAttr('checked');
    el.rotate.attr('checked', 'checked').trigger('change');

    // Edit control should be active.
    expect(NL.vw.MAP.controls.edit.active).toBeTruthy();

    // Rotate should be active.
    expect(NL.vw.MAP.controls.edit.mode).toEqual(
      OpenLayers.Control.ModifyFeature.ROTATE
    );

  });


  it('should set resize shape mode', function() {

    // --------------------------------------------------------------------
    // When the "Resize Shape" radio button is selected, the corresponding
    // modifyFeature control should be activated on the map.
    // --------------------------------------------------------------------

    // Check "Resize Shape".
    el.pan.removeAttr('checked');
    el.resize.attr('checked', 'checked').trigger('change');

    // Edit control should be active.
    expect(NL.vw.MAP.controls.edit.active).toBeTruthy();

    // Resize should be active.
    expect(NL.vw.MAP.controls.edit.mode).toEqual(
      OpenLayers.Control.ModifyFeature.RESIZE
    );

  });


  it('should set drag shape mode', function() {

    // --------------------------------------------------------------------
    // When the "Drag Shape" radio button is selected, the corresponding
    // modifyFeature control should be activated on the map.
    // --------------------------------------------------------------------

    // Check "Drag Shape".
    el.pan.removeAttr('checked');
    el.drag.attr('checked', 'checked').trigger('change');

    // Edit control should be active.
    expect(NL.vw.MAP.controls.edit.active).toBeTruthy();

    // Resize should be active.
    expect(NL.vw.MAP.controls.edit.mode).toEqual(
      OpenLayers.Control.ModifyFeature.DRAG
    );

  });


  it('should set delete shape mode', function() {

    // --------------------------------------------------------------------
    // When the "Delete Shape" radio button is selected, the corresponding
    // modifyFeature control should be activated on the map.
    // --------------------------------------------------------------------

    // Check "Delete Shape".
    el.pan.removeAttr('checked');
    el.remove.attr('checked', 'checked').trigger('change');

    // "Delete Shape" should be active.
    expect(NL.vw.MAP.controls.remove.active).toBeTruthy();

  });


  it('should update coverage on point add', function() {

    // --------------------------------------------------------------------
    // When a new point is added to the map, the coverage text area should
    // be updated with the new WKT string.
    // --------------------------------------------------------------------

    // Add a point.
    var pt = new OpenLayers.Geometry.Point(3,4);
    NL.vw.MAP.controls.point.drawFeature(pt);

    // "Coverage" should be updated.
    expect(el.coverage.val()).toEqual(
      'GEOMETRYCOLLECTION(POINT(1 2),POINT(3 4))'
    );

  });


  it('should update coverage on line add', function() {

    // --------------------------------------------------------------------
    // When a new line is added to the map, the coverage text area should
    // be updated with the new WKT string.
    // --------------------------------------------------------------------

    // Add line.
    var pt1   = new OpenLayers.Geometry.Point(3,4);
    var pt2   = new OpenLayers.Geometry.Point(5,6);
    var line  = new OpenLayers.Geometry.LineString([pt1,pt2]);
    NL.vw.MAP.controls.line.drawFeature(line);

    // "Coverage" should be updated.
    expect(el.coverage.val()).toEqual(
      'GEOMETRYCOLLECTION(POINT(1 2),LINESTRING(3 4,5 6))'
    );

  });


  it('should update coverage on polygon add', function() {

    // --------------------------------------------------------------------
    // When a new polygon is added to the map, the coverage text area
    // should be updated with the new WKT string.
    // --------------------------------------------------------------------

    // Add a polygon.
    var pt1   = new OpenLayers.Geometry.Point(3,4);
    var pt2   = new OpenLayers.Geometry.Point(5,6);
    var pt3   = new OpenLayers.Geometry.Point(7,8);
    var ring  = new OpenLayers.Geometry.LinearRing([pt1,pt2,pt3]);
    var poly  = new OpenLayers.Geometry.Polygon([ring]);
    NL.vw.MAP.controls.poly.drawFeature(poly);

    // "Coverage" should be updated.
    expect(el.coverage.val()).toEqual(
      'GEOMETRYCOLLECTION(POINT(1 2),POLYGON((3 4,5 6,7 8,3 4)))'
    );

  });


  it('should update coverage on svg add', function() {

    // --------------------------------------------------------------------
    // When a new SVG-backed geometry collection is added to the map, the
    // coverage text area should be updated with the new WKT string.
    // --------------------------------------------------------------------

    // Add a geometry collection.
    var pt1 = new OpenLayers.Geometry.Point(3,4);
    var pt2 = new OpenLayers.Geometry.Point(5,6);
    var collection = new OpenLayers.Geometry.Collection([pt1, pt2]);
    NL.vw.MAP.controls.svg.drawFeature(collection);

    // "Coverage" should be updated.
    expect(el.coverage.val()).toEqual(
      'GEOMETRYCOLLECTION(POINT(1 2),POINT(3 4),POINT(5 6))'
    );

  });


  it('should update coverage on svg polygon add', function() {

    // --------------------------------------------------------------------
    // When a new SVG-backed polygon is added to the map, the coverage
    // text area should be updated with the new WKT string.
    // --------------------------------------------------------------------

    // Add a polygon.
    var pt1   = new OpenLayers.Geometry.Point(1,2);
    var pt2   = new OpenLayers.Geometry.Point(3,4);
    var pt3   = new OpenLayers.Geometry.Point(5,6);
    var ring  = new OpenLayers.Geometry.LinearRing([pt1,pt2,pt3]);
    var poly  = new OpenLayers.Geometry.Polygon([ring]);
    NL.vw.MAP.controls.svg.drawFeature(poly);

    // "Coverage" should be updated.
    expect(el.coverage.val()).toEqual(
      'GEOMETRYCOLLECTION(POINT(1 2),POLYGON((1 2,3 4,5 6,1 2)))'
    );

  });


  it('should update coverage on regular polygon add', function() {

    // --------------------------------------------------------------------
    // When a new regular polygon is added to the map, the coverage text
    // area should be updated with the new WKT string.
    // --------------------------------------------------------------------

    // Add a polygon.
    var pt1   = new OpenLayers.Geometry.Point(1,2);
    var pt2   = new OpenLayers.Geometry.Point(3,4);
    var pt3   = new OpenLayers.Geometry.Point(5,6);
    var ring  = new OpenLayers.Geometry.LinearRing([pt1,pt2,pt3]);
    var poly  = new OpenLayers.Geometry.Polygon([ring]);
    NL.vw.MAP.controls.regPoly.drawFeature(poly);

    // "Coverage" should be updated.
    expect(el.coverage.val()).toEqual(
      'GEOMETRYCOLLECTION(POINT(1 2),POLYGON((1 2,3 4,5 6,1 2)))'
    );

  });


  it('should update coverage on feature edit', function() {

    // --------------------------------------------------------------------
    // When an existing geometry is edited, the coverage text area should
    // be updated with the new WKT string.
    // --------------------------------------------------------------------

    // Edit feature, set new point coords.
    var feature = NL.vw.MAP.editLayer.features[0];
    NL.vw.MAP.controls.edit.feature = feature;
    feature.geometry.x = 2;
    feature.geometry.y = 3;

    // Trigger modification.
    NL.vw.MAP.controls.edit.dragComplete();

    // "Coverage" should be updated.
    expect(el.coverage.val()).toEqual(
      'GEOMETRYCOLLECTION(POINT(2 3))'
    );

  });


  it('should update coverage on feature delete', function() {

    // --------------------------------------------------------------------
    // When an existing geometry is deleted, the coverage text area should
    // be updated with the new WKT string.
    // --------------------------------------------------------------------

    // Edit feature, set new point coords.
    var feature = NL.vw.MAP.editLayer.features[0];

    // Trigger modification.
    NL.vw.MAP.controls.remove.selectFeature(feature);

    // "Coverage" should be updated.
    expect(el.coverage.val()).toEqual('');

  });


  it('should not save sketch geometry', function() {

    // --------------------------------------------------------------------
    // When geometry modified, the drag handle points added to the feature
    // should not be saved as part of the coverage.
    // --------------------------------------------------------------------

    // Add a new line.
    var pt1   = new OpenLayers.Geometry.Point(3,4);
    var pt2   = new OpenLayers.Geometry.Point(5,6);
    var line  = new OpenLayers.Geometry.LineString([pt1,pt2]);
    NL.vw.MAP.controls.line.drawFeature(line);

    // Select line, triger modify.
    var feature = NL.vw.MAP.editLayer.features[1];
    NL.vw.MAP.controls.edit.selectFeature(feature);
    NL.vw.MAP.controls.edit.dragComplete();

    // "Coverage" should be updated.
    expect(el.coverage.val()).toEqual(
      'GEOMETRYCOLLECTION(POINT(1 2),LINESTRING(3 4,5 6))'
    );

  });


  it('should remove all features on reset', function() {

    // --------------------------------------------------------------------
    // When the "Clear all Geometry" button is clicked, all features on
    // the edit layer should be deleted.
    // --------------------------------------------------------------------

    // Click "Clear all Geometry".
    el.clear.trigger('click');

    // All features should be removed.
    expect(NL.vw.MAP.editLayer.features.length).toEqual(0);

    // "Coverage" should be updated.
    expect(el.coverage.val()).toEqual('');

  });


  it('should revert to "Navigate" mode when tab is closed', function() {

    // --------------------------------------------------------------------
    // The geometry editing controls should revert to "Navigate" mode when
    // the spatial tab is deactivated.
    // --------------------------------------------------------------------

    // Activate "Draw Polygon".
    el.pan[0].checked = false; el.poly[0].checked = true;

    // Activate "Text" tab.
    NL.vw.RECORD.activateTab('text');

    // "Navigate" mode should be active.
    expect(NL.vw.SPATIAL.getEditMode()).toEqual('pan');

  });


});
