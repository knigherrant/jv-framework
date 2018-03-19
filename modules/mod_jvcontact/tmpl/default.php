<?php
/**
 # Module		JV Contact
 # @version		3.0.1
 # ------------------------------------------------------------------------
 # author    Open Source Code Solutions Co
 # copyright Copyright © 2008-2012 joomlavi.com. All Rights Reserved.
 # @license - http://www.gnu.org/licenses/gpl-3.0.html GNU/GPL or later.
 # Websites: http://www.joomlavi.com
 # Technical Support:  http://www.joomlavi.com/my-tickets.html
-------------------------------------------------------------------------*/

// No direct access to this file
defined( '_JEXEC' ) or die( 'Restricted access' );

?>

<!-- design -->
<div class="formcontact">

<?php echo @$myparams['captcha'][1];?>
<form id="jvcontact<?php echo $moduleid;?>" action="" method="post">
	<div class="innerform">
	
	 	<?php echo $myparams['social'];?>
	 	<?php echo $myparams['map'];?>
	 	
		<?php if($myparams['textheader']){?>
    	<div class="textheader titleform"><?php echo $myparams['textheader'];?></div>
    	<?php }?>
    	
    	<?php if($myparams['moreinfo']){?>
    	<div class="moreinfo"><?php echo $myparams['moreinfo'];?></div>
    	<?php }?>
    	
        <?php if($myparams['showform']){?>
        <div class="form">
			
	        <?php if($fields) foreach($fields as $key=>$field){ ?>
	        	<p class="input-<?php echo $key; ?>"><?php echo @$field['label'];?> <?php echo $field['input'];?></p>
	        <?php }?>
	       
        </div>
        
        <div class="mailcopy">
		                
		        <?php if($myparams['mailcopy']){?>
		        	<span style="float:left;width:100%">
			        	<input name="cbcopymail" type="checkbox" value=1 />
			        	<label for="cbcopymail"><?php echo $myparams['mailcopy'];?></label>
			        </span>
		        <?php }?>
		     </div>
    	<?php }?>
    	
    	<div class="msgfooter"><?php echo $myparams['textfooter'];?></div>
    	
    	
    </div>
    
    <div class="msgsendmailok" id="<?php echo $divmsgid?>">
        <?php
        if($msgthankyou && @$post['jvcontact'][$moduleid]){
        	echo '<div class="msgthankyou">'.$msgthankyou.'</div>';
        }
        ?>
	</div>
    <div class="wrap_btncontact"><a href="javascript:void(0);" class="button" onclick="formsubmit('jvcontact<?php echo $moduleid;?>');"><?php echo $myparams['textsubmit'];?></a></div>
    
    
   <?php echo $myparams['captcha'][0];?>
    <?php echo JHTML::_('form.token');?>
    
</form>


</div>
