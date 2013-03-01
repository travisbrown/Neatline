<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4 cc=76; */

/**
 * Tests for `addField` on `NeatlinePlugin`.
 *
 * @package     omeka
 * @subpackage  neatline
 * @copyright   2012 Rector and Board of Visitors, University of Virginia
 * @license     http://www.apache.org/licenses/LICENSE-2.0.html
 */

class Neatline_NeatlinePluginTest_AddField
    extends Neatline_Test_AppTestCase
{


    /**
     * `addField` should add columns to the records table.
     */
    public function testAddField()
    {

        NeatlinePlugin::addField('test', 'INT UNSIGNED NULL');

        // Get columns.
        $name = $this->_recordsTable->getTableName();
        $recordCols = $this->db->describeTable($name);

        // Should have new `test` column.
        $this->assertArrayHasKey('test', $recordCols);
        $this->assertEquals($recordCols['test']['DATA_TYPE'], 'int');

    }


}