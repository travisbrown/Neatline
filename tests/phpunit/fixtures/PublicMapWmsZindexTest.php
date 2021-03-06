<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4 cc=76; */

/**
 * @package     omeka
 * @subpackage  neatline
 * @copyright   2012 Rector and Board of Visitors, University of Virginia
 * @license     http://www.apache.org/licenses/LICENSE-2.0.html
 */

class FixturesTest_PublicMapWmsZindex extends Neatline_Case_Fixture
{


    /**
     * `PublicMapWmsZindex.records.json`
     */
    public function testRecords()
    {

        $record1 = $this->__record($this->exhibit);
        $record2 = $this->__record($this->exhibit);

        $record1->title         = 'title1';
        $record2->title         = 'title2';
        $record1->wms_address   = 'address1';
        $record2->wms_address   = 'address2';
        $record1->wms_layers    = 'layers1';
        $record2->wms_layers    = 'layers2';
        $record1->zindex        = 1;
        $record2->zindex        = 2;

        $record1->save();
        $record2->save();

        $this->writeFixtureFromRoute('neatline/records',
            'PublicMapWmsZindex.records.json'
        );

    }


}
