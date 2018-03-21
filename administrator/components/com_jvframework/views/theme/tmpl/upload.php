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
-------------------------------------------------------------------------*/
//no direct access
defined( '_JEXEC' ) or die( 'Retricted Access' );
?>

<form action="" method="post" name="adminForm" id="adminForm" class="uploadform" enctype="multipart/form-data">
     <table class="adminlist" border="0">
        <tr>
            <td>
                <fieldset>
                    <legend><?php echo JText::_('Upload Package File') ?></legend>
                    <label class="title" for="file_upload">Upload File</label>
                    <input type="file" name="file_upload" id="file_upload" size="50" />
                    <button type="button" onclick="javascript:submitbutton('theme.upload');return false;">Install</button>
                </fieldset>
                     
            </td>
        </tr>
        <tr>
            <td>
                <fieldset>
                    <legend><?php echo JText::_('Install from URL') ?></legend>
                    <label class="title" for="file_tran">Install from url</label>
                    <input type="text" name="file_tran" id="file_tran" />
                    <button type="button" onclick="javascript:submitbutton('theme.transfer'); return false;">Install</button> 
                </fieldset>
                
            </td>
        </tr>
     </table>     
	<input type="hidden" name="task" value="" />
	<?php echo JHtml::_('form.token'); ?>     
</form>