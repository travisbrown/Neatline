
/* vim: set expandtab tabstop=2 shiftwidth=2 softtabstop=2 cc=76; */

/**
 * Editor router test.
 *
 * @package     omeka
 * @subpackage  neatline
 * @copyright   2012 Rector and Board of Visitors, University of Virginia
 * @license     http://www.apache.org/licenses/LICENSE-2.0.html
 */

describe('Router', function() {


  beforeEach(function() {
    _t.loadEditor();
  });


  it('#records', function() {

    // --------------------------------------------------------------------
    // #records should display the editor menu, search, and record list.
    // --------------------------------------------------------------------

    _t.navigate('records');

    // Menu, search, and records displayed.
    expect(_t.el.editor).toContain(_t.el.menu);
    expect(_t.el.editor).toContain(_t.el.search);
    expect(_t.el.editor).toContain(_t.el.records);

  });


  it('#record/:id', function() {

    // --------------------------------------------------------------------
    // #records/:id should display a record edit form.
    // --------------------------------------------------------------------

    var recordRows = _t.getRecordRows();
    _t.navigate($(recordRows[0]).attr('href'));
    expect(_t.el.editor).toContain(_t.el.record);

  });


  it('#record/add', function() {

    // --------------------------------------------------------------------
    // #records/add should display a record add form.
    // --------------------------------------------------------------------

    _t.navigate('records/add');
    expect(_t.el.editor).toContain(_t.el.record);

  });


});
