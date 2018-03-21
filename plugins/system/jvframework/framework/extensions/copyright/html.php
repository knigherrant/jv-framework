
<?php 
if(($this['option']->get('global.copyright.enable')) || ($this['option']->get('global.copyright.joomlacopyright')) ||  ($this['option']->get('extension.copyright.fwcopyright')))
{
    echo '<div class="copyright">';
    
        if($this['option']->get('global.copyright.enable')):?>
            <div>
                <?php echo $this['option']->get('global.copyright.content'); ?>
            </div>
        <?php endif;
        
        if($this['option']->get('global.copyright.joomlacopyright')):?>
            <div><a href="http://www.joomla.org">Joomla!</a> is Free Software released under the <a href="http://www.gnu.org/licenses/gpl-2.0.html">GNU General Public License.</a></div>
        <?php endif;      
    echo '</div>';
	if($this['option']->get('global.copyright.fwcopyright')):?>
    <div id="jvframework-logo">
		<a  href="http://phpkungfu.club" title="JV Framework">
			<img src="<?php echo $this['path']->url('theme::img/powerby.png'); ?>" title="JV Framework" alt="JV Framework"/>
		</a>
    </div>    
<?php 
	endif;
}
 ?>
