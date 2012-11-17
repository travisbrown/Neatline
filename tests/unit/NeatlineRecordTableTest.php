<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4; */

/**
 * Data record table tests.
 *
 * @package     omeka
 * @subpackage  neatline
 * @copyright   2012 Rector and Board of Visitors, University of Virginia
 * @license     http://www.apache.org/licenses/LICENSE-2.0.html
 */

class Neatline_NeatlineRecordTableTest extends Neatline_Test_AppTestCase
{

    /**
     * createOrGetRecord() should return an existing record when one
     * exists.
     *
     * @return void.
     */
    public function testCreateOrGetRecordWithRecord()
    {

        // Create item, exhibit, and record.
        $item = $this->__item();
        $neatline = $this->__exhibit();
        $record1 = new NeatlineRecord($item, $neatline);
        $record1->save();
        $record2 = new NeatlineRecord(null, $neatline);
        $record2->save();

        // 2 records.
        $this->assertEquals($this->_recordsTable->count(), 2);

        // Get the record and check identity.
        $retrievedRecord = $this->_recordsTable->createOrGetRecord(
            $item, $neatline);
        $this->assertEquals($retrievedRecord->id, $record1->id);

        // Still 2 records.
        $this->assertEquals($this->_recordsTable->count(), 2);

    }

    /**
     * createOrGetRecord() should create a new record when one does
     * not exist.
     *
     * @return void.
     */
    public function testCreateOrGetRecordWithNoRecord()
    {

        // Create item, exhibit, and record.
        $item = $this->__item();
        $neatline = $this->__exhibit();

        // 0 records.
        $this->assertEquals($this->_recordsTable->count(), 0);

        // Get the record and check identity.
        $newRecord = $this->_recordsTable->createOrGetRecord(
            $item, $neatline);
        $this->assertEquals($newRecord->item_id, $item->id);

        // 1 record.
        $this->assertEquals($this->_recordsTable->count(), 1);

    }

    /**
     * getRecordByItemAndExhibit() should return boolean false when
     * there is no record for the given exhibit/item combination.
     *
     * @return void.
     */
    public function testGetRecordByItemAndExhibitWithNoRecord()
    {

        // Create item and exhibit.
        $item = $this->__item();
        $neatline = $this->__exhibit();

        // Try to get a non-existent record.
        $noRecord = $this->_recordsTable->getRecordByItemAndExhibit(
            $item, $neatline);
        $this->assertFalse($noRecord);

    }

    /**
     * getRecordByItemAndExhibit() should return the record when the
     * record exists.
     *
     * @return void.
     */
    public function testGetRecordByItemAndExhibitWithRecord()
    {

        // Create item, exhibit, and record.
        $item = $this->__item();
        $neatline = $this->__exhibit();
        $record = new NeatlineRecord($item, $neatline);
        $record->save();

        // Get the record.
        $retrievedRecord = $this->_recordsTable->getRecordByItemAndExhibit(
            $item, $neatline);
        $this->assertEquals($record->id, $retrievedRecord->id);

    }

    /**
     * getRecordByItemAndExhibit() should escape it's parameters.
     *
     * @return void
     * @author Eric Rochester <erochest@virginia.edu>
     **/
    public function testGetRecordByItemAndExhibitEscape()
    {
        $object = (object) array( 'id' => '0; syntax error;' );
        $record = $this->_recordsTable->getRecordByItemAndExhibit(
            $object, $object
        );
        $this->assertFalse($record);
    }

    /**
     * getRecordByExhibitAndSlug() should return boolean false when
     * there is no record for the given exhibit/slug combination.
     *
     * @return void.
     */
    public function testGetRecordByExhibitAndSlugWithNoRecord()
    {

        // Create item, exhibit, and record.
        $item = $this->__item();
        $neatline = $this->__exhibit();
        $record = new NeatlineRecord($item, $neatline);
        $record->save();

        // Get the record.
        $noRecord = $this->_recordsTable->getRecordByExhibitAndSlug(
            $neatline, 'test-slug');
        $this->assertFalse($noRecord);

    }

    /**
     * getRecordByExhibitAndSlug() should return the record when one
     * exists.
     *
     * @return void.
     */
    public function testGetRecordByExhibitAndSlugWithRecord()
    {

        // Create item, exhibit, and record.
        $item = $this->__item();
        $neatline = $this->__exhibit();
        $record = new NeatlineRecord($item, $neatline);
        $record->slug = 'test-slug';
        $record->save();

        // Get the record.
        $retrievedRecord = $this->_recordsTable->getRecordByExhibitAndSlug(
            $neatline, 'test-slug');
        $this->assertEquals($retrievedRecord->id, $record->id);

    }

    /**
     * getRecordByExhibitAndSlug() should escape the parameters.
     *
     * @return void
     * @author Eric Rochester <erochest@virginia.edu>
     **/
    public function testGetRecordByExhibitAndSlugEscape()
    {
        $obj1  = (object) array( 'id' => 1 );
        $obj2  = (object) array( 'id' => '0; syntax error;' );
        $slug1 = 'slug-1';
        $slug2 = '"; syntax error;';

        $this->assertFalse(
            $this->_recordsTable->getRecordByExhibitAndSlug($obj1, $slug1)
        );
        $this->assertFalse(
            $this->_recordsTable->getRecordByExhibitAndSlug($obj2, $slug1)
        );
        $this->assertFalse(
            $this->_recordsTable->getRecordByExhibitAndSlug($obj1, $slug2)
        );
        $this->assertFalse(
            $this->_recordsTable->getRecordByExhibitAndSlug($obj2, $slug2)
        );
    }

    /**
     * slugIsAvailable() should always return true when an empty string
     * is passed.
     *
     * @return void.
     */
    public function testSlugIsAvailableWithEmptyString()
    {

        // Create item and exhibit.
        $item = $this->__item();
        $exhibit = $this->__exhibit();

        // Create two records.
        $record1 = new NeatlineRecord($item, $exhibit);
        $record1->slug = 'test-slug';
        $record1->save();
        $record2 = new NeatlineRecord($item, $exhibit);
        $record2->slug = '';
        $record2->save();

        $this->assertTrue(
            $this->_recordsTable->slugIsAvailable($record1, $exhibit, '')
        );

    }

    /**
     * slugIsAvailable() should return false when there is a non-self
     * duplicate.
     *
     * @return void.
     */
    public function testSlugIsAvailableWithNonSelfDuplicate()
    {

        // Create item and exhibit.
        $item = $this->__item();
        $exhibit = $this->__exhibit();

        // Create two records.
        $record1 = new NeatlineRecord($item, $exhibit);
        $record1->slug = 'test-slug';
        $record1->save();
        $record2 = new NeatlineRecord($item, $exhibit);
        $record2->slug = 'another-slug';
        $record2->save();

        $this->assertFalse(
            $this->_recordsTable->slugIsAvailable(
                $record1, $exhibit, 'another-slug'
            )
        );

    }

    /**
     * slugIsAvailable() should return true when the duplicate is self.
     *
     * @return void.
     */
    public function testSlugIsAvailableWithSelfDuplicate()
    {

        // Create item and exhibit.
        $item = $this->__item();
        $exhibit = $this->__exhibit();

        // Create two records.
        $record1 = new NeatlineRecord($item, $exhibit);
        $record1->slug = 'test-slug';
        $record1->save();
        $record2 = new NeatlineRecord($item, $exhibit);
        $record2->slug = 'another-slug';
        $record2->save();

        $this->assertTrue(
            $this->_recordsTable->slugIsAvailable(
                $record1, $exhibit, 'test-slug'
            )
        );

    }

    /**
     * The getRecordsByExhibit() should return all data records associated
     * with a given Neatline exhibit.
     *
     * @return void.
     */
    public function testGetRecordsByExhibitWithRecords()
    {

        // Create two items and an exhibit.
        $item1 = $this->__item();
        $item2 = $this->__item();
        $neatline = $this->__exhibit();

        // Create two records.
        $record1 = new NeatlineRecord($item1, $neatline);
        $record1->save();
        $record2 = new NeatlineRecord($item2, $neatline);
        $record2->save();
        $record3 = new NeatlineRecord(null, $neatline);
        $record3->save();

        // Get the records and check result.
        $records = $this->_recordsTable->getRecordsByExhibit($neatline);
        $this->assertEquals(count($records), 3);
        $this->assertEquals($records[0]->id, $record1->id);
        $this->assertEquals($records[1]->id, $record2->id);
        $this->assertEquals($records[2]->id, $record3->id);

    }

    /**
     * When there are no records for an exhibit, getRecordsByExhibit()
     * should return false.
     *
     * @return void.
     */
    public function testGetRecordsByExhibitWithNoRecords()
    {

        // Create two items and an exhibit.
        $neatline = $this->__exhibit();

        // Get the records and check result.
        $records = $this->_recordsTable->getRecordsByExhibit($neatline);
        $this->assertFalse($records);

    }

    /**
     * getRecordsByExhibit() should escape SQL parameters.
     *
     * @return void
     * @author Eric Rochester <erochest@virginia.edu>
     **/
    public function testGetRecordsByExhibitEscape()
    {
        $nl = (object) array( 'id' => '; syntax error;' );
        $this->assertFalse($this->_recordsTable->getRecordsByExhibit($nl));
    }

    /**
     * getActiveRecordsByExhibit() should return all data records associated
     * with a given Neatline exhibit that have an active space or time record.
     *
     * @return void.
     */
    public function testGetActiveRecordsByExhibit()
    {

        // Create two items and an exhibit.
        $item1 = $this->__item();
        $item2 = $this->__item();
        $neatline = $this->__exhibit();

        // Create two records with inactive status settings.
        $record1 = new NeatlineRecord($item1, $neatline);
        $record1->save();
        $record2 = new NeatlineRecord($item2, $neatline);
        $record2->save();

        // Should return false.
        $records = $this->_recordsTable->getActiveRecordsByExhibit($neatline);
        $this->assertFalse($records);

        $record1->delete();
        $record2->delete();

        // Create two records, one with an active space status.
        $record1 = new NeatlineRecord($item1, $neatline);
        $record1->save();
        $record2 = new NeatlineRecord($item2, $neatline);
        $record2->map_active = 1;
        $record2->save();

        // Get the records and check result.
        $records = $this->_recordsTable->getActiveRecordsByExhibit($neatline);
        $this->assertEquals(count($records), 1);
        $this->assertEquals($records[0]->id, $record2->id);

    }

    /**
     * getActiveRecordsByExhibit() should escape SQL parameters.
     *
     * @return void
     * @author Eric Rochester <erochest@virginia.edu>
     **/
    public function testGetActiveRecordsByExhibitEscape()
    {
        $exhibit = (object) array( 'id' => '; syntax error;' );
        $this->assertFalse(
            $this->_recordsTable->getActiveRecordsByExhibit($exhibit)
        );
    }

    /**
     * updateRecord() should update all non-empty properties.
     *
     * @return void
     **/
    public function testUpdateRecord()
    {

        // Create record.
        $exhibit = $this->__exhibit();
        $record = $this->__record();

        // Set parameters.
        $record->title              = 'title';
        $record->description        = 'desc';
        $record->slug               = 'slug';
        $record->vector_color       = '#vector';
        $record->stroke_color       = '#stroke';
        $record->select_color       = '#select';
        $record->vector_opacity     = 1;
        $record->select_opacity     = 2;
        $record->stroke_opacity     = 3;
        $record->graphic_opacity    = 4;
        $record->stroke_width       = 5;
        $record->point_radius       = 6;
        $record->point_image        = 'file.png';
        $record->map_focus          = 'lat/lon';
        $record->map_zoom           = 7;
        $record->coverage           = 'kml';
        $record->map_active         = 1;

        // Mock values.
        $values = array(
            'id'                    => (string) $record->id,
            'item_id'               => null,
            'title'                 => 'title2',
            'description'           => 'desc2',
            'slug'                  => 'slug2',
            'vector_color'          => '#vector2',
            'stroke_color'          => '#stroke2',
            'select_color'          => '#select2',
            'vector_opacity'        => '10',
            'select_opacity'        => '20',
            'stroke_opacity'        => '30',
            'graphic_opacity'       => '40',
            'stroke_width'          => '50',
            'point_radius'          => '60',
            'point_image'           => 'file2.png',
            'map_focus'             => 'lat2/lon2',
            'map_zoom'              => '70',
            'coverage'              => 'kml2',
            'bounds'                => 'POLYGON((0 0,0 1,1 1,1 0))',
            'map_active'            => '0'
        );

        // Update, reget record.
        $this->_recordsTable->updateRecord($values);
        $record = $this->_recordsTable->find($record->id);

        // Check new values.
        $this->assertEquals($record->title, 'title2');
        $this->assertEquals($record->description, 'desc2');
        $this->assertEquals($record->slug, 'slug2');
        $this->assertEquals($record->vector_color, '#vector2');
        $this->assertEquals($record->stroke_color, '#stroke2');
        $this->assertEquals($record->select_color, '#select2');
        $this->assertEquals($record->vector_opacity, 10);
        $this->assertEquals($record->select_opacity, 20);
        $this->assertEquals($record->stroke_opacity, 30);
        $this->assertEquals($record->graphic_opacity, 40);
        $this->assertEquals($record->stroke_width, 50);
        $this->assertEquals($record->point_radius, 60);
        $this->assertEquals($record->point_image, 'file2.png');
        $this->assertEquals($record->map_focus, 'lat2/lon2');
        $this->assertEquals($record->map_zoom, 70);
        $this->assertEquals($record->coverage, 'kml2');
        $this->assertEquals($record->map_active, 0);

    }

    /**
     * buildRecordCollection() should construct a well-formed array of records
     * with all attributes needed for the front-end application.
     *
     * @return void.
     */
    public function testBuildRecordCollection()
    {

        // Create an exhibit and items.
        $exhibit = $this->__exhibit();
        $item1 = $this->__item();
        $item2 = $this->__item();

        // Create two records.
        $record1 = new NeatlineRecord($item1, $exhibit);
        $record2 = new NeatlineRecord($item2, $exhibit);

        // Map attributes.
        $record1->title             = 'Record 1 Title';
        $record2->title             = 'Record 2 Title';
        $record1->description       = 'Record 1 description.';
        $record2->description       = 'Record 2 description.';
        $record1->slug              = 'slug-1';
        $record2->slug              = 'slug-2';
        $record1->vector_color      = '#ffffff';
        $record2->vector_color      = '#000000';
        $record1->stroke_color      = '#ffffff';
        $record2->stroke_color      = '#000000';
        $record1->select_color      = '#ffffff';
        $record2->select_color      = '#000000';
        $record1->vector_opacity    = 60;
        $record2->vector_opacity    = 40;
        $record1->select_opacity    = 60;
        $record2->select_opacity    = 40;
        $record1->stroke_opacity    = 60;
        $record2->stroke_opacity    = 40;
        $record1->graphic_opacity   = 60;
        $record2->graphic_opacity   = 40;
        $record1->stroke_width      = 3;
        $record2->stroke_width      = 2;
        $record1->point_radius      = 3;
        $record2->point_radius      = 2;
        $record1->point_image       = 'http://test1.org';
        $record2->point_image       = 'http://test2.org';
        $record1->coverage          = 'kml1';
        $record2->coverage          = 'kml2';
        $record1->map_active        = 1;
        $record2->map_active        = 1;
        $record1->map_focus         = 'center1';
        $record2->map_focus         = 'center2';
        $record1->map_zoom          = 4;
        $record2->map_zoom          = 5;

        // Save.
        $record1->save();
        $record2->save();

        // Build the record array.
        $records = $this->_recordsTable->buildRecordCollection($exhibit);

        // Check result.
        $this->assertEquals(
            $records, array(
            array(
                'id'                => $record1->id,
                'item_id'           => $item1->id,
                'title'             => 'Record 1 Title',
                'description'       => 'Record 1 description.',
                'slug'              => 'slug-1',
                'vector_color'      => '#ffffff',
                'stroke_color'      => '#ffffff',
                'select_color'      => '#ffffff',
                'vector_opacity'    => 60,
                'select_opacity'    => 60,
                'stroke_opacity'    => 60,
                'graphic_opacity'   => 60,
                'stroke_width'      => 3,
                'point_radius'      => 3,
                'point_image'       => 'http://test1.org',
                'map_focus'         => 'center1',
                'map_zoom'          => 4,
                'coverage'          => 'kml1',
                'wmsAddress'        => null,
                'layers'            => null,
                'map_active'        => 1
            ),
            array(
                'id'                => $record2->id,
                'item_id'           => $item2->id,
                'title'             => 'Record 2 Title',
                'description'       => 'Record 2 description.',
                'slug'              => 'slug-2',
                'vector_color'      => '#000000',
                'stroke_color'      => '#000000',
                'select_color'      => '#000000',
                'vector_opacity'    => 40,
                'select_opacity'    => 40,
                'stroke_opacity'    => 40,
                'graphic_opacity'   => 40,
                'stroke_width'      => 2,
                'point_radius'      => 2,
                'point_image'       => 'http://test2.org',
                'map_focus'         => 'center2',
                'map_zoom'          => 5,
                'coverage'          => 'kml2',
                'wmsAddress'        => null,
                'layers'            => null,
                'map_active'        => 1
            )
            )
        );

    }

}
