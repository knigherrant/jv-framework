<?php
/**
  # com_jvframwork - JV Framework
  # @version		1.5.x
  # ------------------------------------------------------------------------
  # author    PHPKungfu Solutions Co
  # copyright Copyright (C) 2011 phpkungfu.club. All Rights Reserved.
  # @license - http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL or later.
  # Websites: http://www.phpkungfu.club
  # Technical Support:  http://www.phpkungfu.club/my-tickets.html
  ------------------------------------------------------------------------- 
  */
// no direct access
defined ( '_JEXEC' ) or die ( 'Retricted Access' );
$extensions = JV::_('extension.getExtensionList');

foreach ($extensions as $extension => $options ) {
	$extensions[$extension] = (object) JApplicationHelper::parseXMLInstallFile($options);
}

?>
<table class="adminlist table table-strip">
 	<thead style="text-transform: capitalize;">
 	 <tr>
		  <th>name</th>
		  <th>creationDate</th>
		  <th>author</th>	
		  <th>authorEmail</th>
		  <th>authorUrl</th>	
		  <th>version</th>	
		  <th>description</th>    
	  </tr>
  </thead>
  <tbody>
	 <?php foreach ($extensions as $extension):?>
	 <tr>
		  <td><?php echo $extension->name; ?></td>
		  <td align="center"><?php echo $extension->creationDate; ?></td>
		  <td align="center"><?php echo $extension->author; ?></td>	
		  <td align="center"><?php echo $extension->authorEmail; ?></td>
		  <td align="center"><?php echo $extension->authorUrl; ?></td>	
		  <td align="center"><?php echo $extension->version; ?></td>	
		  <td><?php echo $extension->description; ?></td>   
	 </tr>
	<?php endforeach;?> 
	</tbody>
</table>

