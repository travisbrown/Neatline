<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4 cc=76; */

/**
 * @package     omeka
 * @subpackage  neatline
 * @copyright   2012 Rector and Board of Visitors, University of Virginia
 * @license     http://www.apache.org/licenses/LICENSE-2.0.html
 */

class NeatlineRecordTest_PullStyles extends Neatline_Case_Default
{


    /**
     * `pullStyles` should update record values to match exhibit CSS.
     */
    public function testPullStyles()
    {

        $exhibit = $this->__exhibit();
        $exhibit->styles = "
            .tag1 {
              fill-color: 1;
              fill-color-select: 2;
            }
            .tag2 {
              stroke-color: 3;
              stroke-color-select: 4;
            }
            .tag3 {
              zindex: 5;
              weight: 6;
            }
        ";

        $exhibit->save();
        $record = new NeatlineRecord($exhibit);

        // Pull `tag1` and `tag2`.
        $record->pullStyles(array('tag1', 'tag2'));
        $record->save();
        $record = $this->reload($record);

        // Should pull `tag1` and `tag2`.
        $this->assertEquals($record->fill_color, '1');
        $this->assertEquals($record->fill_color_select, '2');
        $this->assertEquals($record->stroke_color, '3');
        $this->assertEquals($record->stroke_color_select, '4');

        // Should not pull `tag3`.
        $this->assertNull($record->zindex);
        $this->assertNull($record->weight);

    }


    /**
     * `pullStyles` should pull values from the `all` selector.
     */
    public function testPullAllTag()
    {

        $exhibit = $this->__exhibit();
        $exhibit->styles = "
            .all {
              fill-color: 1;
            }
            .tag {
              stroke-color: 2;
            }
        ";

        $exhibit->save();
        $record = new NeatlineRecord($exhibit);

        // Pull `tag`.
        $record->pullStyles(array('tag'));
        $record->save();
        $record = $this->reload($record);

        // Should pull `tag` and `all`.
        $this->assertEquals($record->fill_color, '1');
        $this->assertEquals($record->stroke_color, '2');

    }


    /**
     * Rules with `auto` values should be ignored.
     */
    public function testAutoValues()
    {

        $exhibit = $this->__exhibit();
        $exhibit->styles = "
            .tag {
              fill-color: auto;
            }
        ";

        $exhibit->save();
        $record = new NeatlineRecord($exhibit);

        // Pull `tag`.
        $record->pullStyles(array('tag'));
        $record->save();
        $record = $this->reload($record);

        // `auto` value should be ignored.
        $this->assertNull($record->fill_color);

    }


    /**
     * Rules with invalid selectors should be ignored.
     */
    public function testInvalidSelectors()
    {

        $exhibit = $this->__exhibit();
        $exhibit->styles = "
            .tag {
              fill-color: color;
              invalid: value;
            }
        ";

        $exhibit->save();
        $record = new NeatlineRecord($exhibit);

        // Pull `tag`.
        $record->pullStyles(array('tag'));
        $record->save();
        $record = $this->reload($record);

        // Invalid property should be ignored.
        $this->assertEquals($record->fill_color, 'color');

    }


    /**
     * Rules with `none` values should be pulled as NULL.
     */
    public function testNoneCssValues()
    {

        $exhibit = $this->__exhibit();
        $exhibit->styles = "
            .tag {
              point-image: none;
            }
        ";

        $exhibit->save();
        $record = new NeatlineRecord($exhibit);

        // Pull `tag`.
        $record->pullStyles(array('tag'));
        $record->save();
        $record = $this->reload($record);

        // `none` should be cast to NULL.
        $this->assertNull($record->point_image);

    }


}
