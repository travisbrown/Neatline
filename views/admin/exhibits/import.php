<?php

/* vim: set expandtab tabstop=2 shiftwidth=2 softtabstop=2 cc=76; */

/**
 * @package     omeka
 * @subpackage  neatline
 * @copyright   2012 Rector and Board of Visitors, University of Virginia
 * @license     http://www.apache.org/licenses/LICENSE-2.0.html
 */

?>

<?php
  echo head(array(
    'title' => __('Neatline | Import Items from Omeka'),
    'content_class' => 'neatline'
  ));
?>

<div id="primary">

  <?php echo flash(); ?>

  <form method="POST" action="#">

    <div id="search-keywords" class="field">
      <div class="two columns alpha">
        <?php
          echo $this->formLabel(
            'keyword-search', __('Search by Keywords')
          );
        ?>
      </div>
      <div class="five columns omega inputs">
      <?php
        echo $this->formText(
          'search',
          @$_REQUEST['search'],
          array('id' => 'keyword-search', 'size' => '40')
        );
      ?>
      </div>
    </div>

    <div id="search-range" class="field">
      <div class="two columns alpha">
        <?php
          echo $this->formLabel(
            'range', __('Search by a range of ID#s (eg: 1-4, 156, 79)')
          );
        ?>
      </div>
      <div class="five columns omega inputs">
      <?php
        echo $this->formText('range', @$_GET['range'],
          array('size' => '40')
        );
      ?>
      </div>
    </div>

    <div id="search-by-collection" class="field">
      <div class="two columns alpha">
        <?php
          echo $this->formLabel(
            'collection-search', __('Search By Collection')
          );
        ?>
      </div>
      <div class="five columns omega inputs">
      <?php
        echo $this->formSelect(
          'collection',
          @$_REQUEST['collection'],
          array('id' => 'collection-search'),
          get_table_options('Collection')
        );
      ?>
        </div>
    </div>

    <div id="search-by-type" class="field">
      <div class="two columns alpha">
        <?php
          echo $this->formLabel(
            'item-type-search', __('Search By Type')
          );
        ?>
      </div>
      <div class="five columns omega inputs">
      <?php
        echo $this->formSelect(
          'type',
          @$_REQUEST['type'],
          array('id' => 'item-type-search'),
          get_table_options('ItemType')
        );
      ?>
        </div>
    </div>

    <div class="field">
      <div class="two columns alpha">
        <?php
          echo $this->formLabel(
            'tag-search', __('Search By Tags')
          );
        ?>
      </div>
      <div class="five columns omega inputs">
      <?php
        echo $this->formText(
          'tags',
          @$_REQUEST['tags'],
          array('size' => '40', 'id' => 'item-type-search')
        );
      ?>
      </div>
    </div>

    <div>
    <input
      type="submit"
      id="submit_search_advanced"
      class="submit big green button"
      name="submit_search"
      value="<?php echo __('Import Items'); ?>" />
    </div>

  </form>

</div>

<?php echo foot(); ?>
