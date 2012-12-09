<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4 cc=76; */

/**
 * Table class for exhibits.
 *
 * @package     omeka
 * @subpackage  neatline
 * @copyright   2012 Rector and Board of Visitors, University of Virginia
 * @license     http://www.apache.org/licenses/LICENSE-2.0.html
 */

class NeatlineExhibitTable extends Omeka_Db_Table
{


    /**
     * Find exhibit by slug.
     *
     * @param string $slug The slug.
     * @return Omeka_record $exhibit The exhibit.
     */
    public function findBySlug($slug)
    {
        $select = $this->getSelect()->where('slug=?', $slug);
        return $this->fetchObject($select);
    }


}
