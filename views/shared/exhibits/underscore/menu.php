<?php

/* vim: set expandtab tabstop=2 shiftwidth=2 softtabstop=2 cc=76; */

/**
 * @package     omeka
 * @subpackage  neatline
 * @copyright   2012 Rector and Board of Visitors, University of Virginia
 * @license     http://www.apache.org/licenses/LICENSE-2.0.html
 */

?>

<script id="exhibit-menu-template" type="text/templates">

  <!-- Back to Omeka. -->
  <a class="back" href="<?php echo url('neatline');?>">
    &larr; Back to Omeka
  </a>

  <!-- Exhibit title. -->
  <p class="lead"><?php echo nl_getExhibitField('title'); ?></p>

  <!-- Main navigation. -->
  <ul class="nav nav-pills">

    <li class="tab" data-slug="records">
      <a href="#records">Records</a>
    </li>
    <li class="tab" data-slug="styles">
      <a href="#styles">Styles</a>
    </li>

    <!-- Widget tabs. -->
    <?php echo $this->partial(
      'exhibits/underscore/partials/exhibit_tabs.php'
    ); ?>

  </ul>

</script>
