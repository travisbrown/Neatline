<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4 cc=76; */

/**
 * @package     omeka
 * @subpackage  neatline
 * @copyright   2012 Rector and Board of Visitors, University of Virginia
 * @license     http://www.apache.org/licenses/LICENSE-2.0.html
 */

class NeatlineRecordTableTest_GetSelect extends Neatline_Case_Default
{


    /**
     * `getSelect` should select the plain-text value of `coverage` when
     * the field is defined.
     */
    public function testSelectCoverageAsText()
    {

        $record = new NeatlineRecord();
        $record->coverage = 'POINT(1 1)';
        $record->save();

        // Query for the record.
        $record = $this->__records->fetchObject(
            $this->__records->getSelect()
        );

        // Coverage should be selected as plaintext.
        $this->assertEquals($record->coverage, 'POINT(1 1)');

    }


    /**
     * `getSelect` should select NULL for `coverage` when the plain-text
     * value of the field is `POINT(0 0)`.
     */
    public function testSelectEmptyCoverageAsNull()
    {

        $record = new NeatlineRecord();
        $record->coverage = 'POINT(0 0)';
        $record->save();

        // Query for the record.
        $record = $this->__records->fetchObject(
            $this->__records->getSelect()
        );

        // Coverage should be null.
        $this->assertNull($record->coverage);

    }


    /**
     * `getSelect` should order records by `added`.
     */
    public function testOrderByAdded()
    {

        $record1 = new NeatlineRecord();
        $record2 = new NeatlineRecord();
        $record3 = new NeatlineRecord();
        $record1->added = '2001-01-01';
        $record2->added = '2002-01-01';
        $record3->added = '2003-01-01';

        $record1->save();
        $record2->save();
        $record3->save();

        // Query for the records.
        $records = $this->__records->fetchObjects(
            $this->__records->getSelect()
        );

        // Should be in reverse chronological order.
        $this->assertEquals($records[0]->id, $record3->id);
        $this->assertEquals($records[1]->id, $record2->id);
        $this->assertEquals($records[2]->id, $record1->id);

    }


}
