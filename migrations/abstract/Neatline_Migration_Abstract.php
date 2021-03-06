<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4 cc=76; */

/**
 * @package     omeka
 * @subpackage  neatline
 * @copyright   2012 Rector and Board of Visitors, University of Virginia
 * @license     http://www.apache.org/licenses/LICENSE-2.0.html
 */

abstract class Neatline_Migration_Abstract
{


    protected $_db;


    /**
     * Set the database object, call `migrate`.
     */
    public function __construct()
    {
        $this->_db = Zend_Registry::get('bootstrap')->getResource('Db');
        $this->migrate();
    }


    /**
     * Perform a migration.
     */
    abstract public function migrate();


}
