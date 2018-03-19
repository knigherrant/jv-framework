<?php 
/**
 * @version		$Id: archive.php 1899 2013-02-08 18:57:03Z lefteris.kavadas $
 * @package		K2
 * @author		JoomlaWorks http://www.joomlaworks.net
 * @copyright	Copyright (c) 2006 - 2013 JoomlaWorks Ltd. All rights reserved.
 * @license		GNU/GPL license: http://www.gnu.org/copyleft/gpl.html
 */

// no direct access
defined('_JEXEC') or die;

?>
<div id="k2ModuleBox<?php echo $module->id; ?>" class="k2ArchivesBlock<?php if($params->get('moduleclass_sfx')) echo '-'.$params->get('moduleclass_sfx'); ?>">
  <ul class="list-unstyled">
    <?php foreach ($months as $key => $month): ?>
    <li data-key="0<?php echo ($key+1);?>" data-numitem="<?php echo $month->numOfItems; ?>">
      <a href="<?php echo $month->link; ?>">
        <i class="fa fa-angle-right"></i> <?php echo $month->name.' '.$month->y; ?>
        <?php if ($params->get('archiveItemsCounter')) echo '<span class="numOfItems"> ('.$month->numOfItems.')</span>'; ?>
      </a>
    </li>
    <?php endforeach; ?>
  </ul>
</div>
