<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4 cc=76; */

/**
 * PHPUnit runner.
 *
 * @package     omeka
 * @subpackage  neatline
 * @copyright   2012 Rector and Board of Visitors, University of Virginia
 * @license     http://www.apache.org/licenses/LICENSE-2.0.html
 */


define('NL_DIR', dirname(dirname(dirname(__FILE__))));
define('OMEKA_DIR', dirname(dirname(NL_DIR)));

// Bootstrap Omeka, load Neatline plugin.
require_once OMEKA_DIR . '/application/tests/bootstrap.php';
require_once NL_DIR . '/NeatlinePlugin.php';

// Load abstract test cases, mock filters.
require_once 'cases/Neatline_Case_Abstract.php';
require_once 'cases/Neatline_Case_Default.php';
require_once 'cases/Neatline_Case_Fixture.php';
require_once 'mocks/filters.php';
