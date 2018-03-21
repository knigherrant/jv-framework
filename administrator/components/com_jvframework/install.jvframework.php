<?php
/**
 # com_jvframework - JV Framework
 # @version		1.6.x
 # ------------------------------------------------------------------------
 # author    PHPKungfu Solutions Co
 # copyright Copyright (C) 2011 phpkungfu.club. All Rights Reserved.
 # @license - http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL or later.
 # Websites: http://www.phpkungfu.club
 # Technical Support:  http://www.phpkungfu.club/my-tickets.html
 */

// No direct access to this file
defined ( '_JEXEC' ) or die ( 'Restricted access' );

if(!class_exists('com_jvframeworkInstallerScript')){
	class com_jvframeworkInstallerScript {
		function install($parent) {
			JVInstall::processUpdate ( $parent );
		}
		
		function uninstall($parent)
		{
			JVInstall::uninstall ( $parent );
		}
		
		function update($parent)
		{
			JVInstall::processUpdate ( $parent );
		}
	}
}

if(!class_exists('JVInstall')){
class JVInstall {
	public static $extensions = array();
	
	public static function uninstall(&$component) {
		return true; // Keep user setting
		
		$db = JFactory::getDbo ();		
		
		$query = " DROP TABLE IF EXISTS `#__jv_typos`;";
		$db->setQuery ( $query );
		$db->query ();
	}
	
	public static function processUpdate(&$component) {		
		// Add table for theme managerment
		self::process ( $component );
	}
	
	public static function process(&$component) {
		self::addTableTypos ();
		
		$folder = $component->get ( 'parent' )->getPath ( 'source' );
		
		if(!class_exists('JVInstallerExtension'))
			require_once $folder.'/installer/adapters/extension.php';
			
		
			
		self::_install( JFolder::folders($folder.'/additional/plugin', '.', false, true), 'plugin');
		$lang = JFactory::getLanguage();
		$lang->load('plg_system_jvframework', JPATH_ADMINISTRATOR);
		JTable::addIncludePath(JPATH_ADMINISTRATOR.'/components/com_jvframework/tables');
		
		if(!class_exists('JV')){
			// Register JV Framework Loader
			if (is_file ( JPATH_ROOT . '/plugins/system/jvframework/framework/loader.php' )) {
				include_once (JPATH_ROOT . '/plugins/system/jvframework/framework/loader.php');
				
				// Load JVTheme to check is jvframework template
				JVFrameworkLoader::import ( 'factory' );
					
				// Load Framework
				JVFrameworkLoader::import ( 'framework' );
				JV::getInstance ();				
			}
		}
		
		self::_install( JFolder::folders($folder.'/additional/template', '.', false, true), 'template');	
		self::_install( JFolder::folders($folder.'/additional/extension', '.', false, true), 'extension');
		
		self::displayResults ();
	}
	
	public static function _install($extensions, $type){
		foreach ($extensions as $path) {
			if (JFolder::exists ( $path )) {	
				if($type =='extension'){
					$version = new JVersion;
					if($version->isCompatible('3.4')){
						if($version->isCompatible('3.4.8')) $installer = new JInstaller();
						else $installer = new JInstaller(__DIR__, 'JVInstaller' );
					}else $installer = new JInstaller();
				}else{
					$installer = new JInstaller();
				}
				$installer->setAdapter('extension', new JVInstallerExtension($installer, JFactory::getDbo()));
				$installed = $installer->install($path);	
				$manifest  = $installer->getManifest();				
				self::$extensions[] = array('installed' => $installed,'type' => $type, 'isUpgrade' => $installer->isUpgrade(), 'manifest' => $manifest);			
			}
		}
		
		
		
		
		
	}
		
	public static function addTableTypos() {
		$db = JFactory::getDbo ();
		
		$query = "			
			CREATE TABLE IF NOT EXISTS `#__jv_typos` (
			  `id` int(11) NOT NULL auto_increment,
			  `title` varchar(100) NOT NULL,
			  `tag` varchar(100) NOT NULL,
			  `replacement` text NOT NULL,
			  `example` text,
			  `ordering` int(11) NOT NULL default '1',
			  `published` tinyint(1) NOT NULL default '1',
			  PRIMARY KEY  (`id`)
			) ENGINE=MyISAM AUTO_INCREMENT=42 DEFAULT CHARSET=utf8;
		";
		
		$data = "
			-- ----------------------------
			-- Records of #_jv_typos
			-- ----------------------------
			INSERT INTO `#__jv_typos` VALUES (NULL, 'h3', 'h3', '<h3>{param}</h3>', '[h3]H3[/h3]', '1', '1');
			INSERT INTO `#__jv_typos` VALUES (NULL, 'h2', 'h2', '<h2 class=\"{option}\">{param}</h2>', '[h2=hidden1]abc1[/h2]', '2', '1');
			INSERT INTO `#__jv_typos` VALUES (NULL, 'Blocknumber 1', 'blocknumber1', '<p class=\"blocknumber\"><span class=\"bignumber-1\">{option}</span>{param}</p>', '[blocknumber1=01]Your content goes here![/blocknumber1]', '5', '1');
			INSERT INTO `#__jv_typos` VALUES (NULL, 'notice', 'notice', '<p class=\"error bg1\"><span class=\"icon\"> </span>{param}</p>', '[notice]Notice[/notice]', '11', '1');
			INSERT INTO `#__jv_typos` VALUES (NULL, 'url', 'url', '<a href=\"{option}\">{param}</a>', '[url=http://phpkungfu.club]phpkungfu.club[/url]', '3', '1');
			INSERT INTO `#__jv_typos` VALUES (NULL, 'Paragraph Style - Message', 'message', '<p class=\"message bg2\"><span class=\"icon\"></span>{param}</p>', '[message]Your text here[/message]', '12', '1');
			INSERT INTO `#__jv_typos` VALUES (NULL, 'Box Style - Sticky', 'sticky', '<p class=\"box-sticky\">{param}</p>', '[sticky]Your clip note goes here![/sticky]', '4', '1');
			INSERT INTO `#__jv_typos` VALUES (NULL, 'Paragraph Style - Photo', 'photo', '<p class=\"photo bg3\"><span class=\"icon\"> </span>{param}</p>', '[photo]Your message goes here![/photo]', '18', '1');
			INSERT INTO `#__jv_typos` VALUES (NULL, 'Blocknumber 2', 'blocknumber2', '<p class=\"blocknumber\"><span class=\"bignumber-2\">{option}</span>{param}</p>', '[blocknumber2=01]Your content goes here![/blocknumber2]', '6', '1');
			INSERT INTO `#__jv_typos` VALUES (NULL, 'Blocknumber 3', 'blocknumber3', '<p class=\"blocknumber\"><span class=\"bignumber-3\">{option}</span>{param}</p>', '[blocknumber3=01]Your content goes here![/blocknumber3]', '7', '1');
			INSERT INTO `#__jv_typos` VALUES (NULL, 'Tips', 'tips', '<p class=\"tips bg1\"><span class=\"icon\"> </span>{param}</p>', '[tips]Your content goes here![/tips]', '19', '1');
			INSERT INTO `#__jv_typos` VALUES (NULL, 'Key', 'key', '<p class=\"key bg2\"><span class=\"icon\"> </span>{param}</p>', '[key]Your content goes here![/key]', '20', '1');
			INSERT INTO `#__jv_typos` VALUES (NULL, 'Tag', 'tag', '<p class=\"tag bg4\"><span class=\"icon\"> </span>{param}</p>', '[tag]Your content goes here![/tag]', '17', '1');
			INSERT INTO `#__jv_typos` VALUES (NULL, 'Cart', 'cart', '<p class=\"cart bg1\"><span class=\"icon\"> </span>{param}</p>', '[cart]Your content goes here![/cart]', '15', '1');
			INSERT INTO `#__jv_typos` VALUES (NULL, 'Doc', 'doc', '<p class=\"doc bg5\"><span class=\"icon\"> </span>{param}</p>', '[doc]Your content goes here![/doc]', '14', '1');
			INSERT INTO `#__jv_typos` VALUES (NULL, 'Note', 'note', '<p class=\"note bg3\"><span class=\"icon\"> </span>{param}</p>', '[note]Your content goes here![/note]', '10', '1');
			INSERT INTO `#__jv_typos` VALUES (NULL, 'Mobi', 'mobi', '<p class=\"mobi bg2\"><span class=\"icon\"> </span>{param}</p>', '[mobi]Your content goes here![/mobi]', '16', '1');
			INSERT INTO `#__jv_typos` VALUES (NULL, 'Download', 'download', '<p class=\"download bg4\"><span class=\"icon\"></span>{param}</p>', '[download]Your content goes here![/download]', '13', '1');
			INSERT INTO `#__jv_typos` VALUES (NULL, 'Box Grey', 'box-grey', '<p class=\"box-grey\">{param}</p>', '[box-grey]Your content goes here![/box-grey]', '8', '1');
			INSERT INTO `#__jv_typos` VALUES (NULL, 'Box Hilite', 'box-hilite', '<p class=\"box-hilite\">{param}</p>', '[box-hilite]Your content goes here![/box-hilite]', '9', '1');
			INSERT INTO `#__jv_typos` VALUES (NULL, 'Legend', 'legend', '<div class=\"legend\"><h3 class=\"legend-title\">{option}</h3><p>{param}</p></div>', '[legend=Legend style]Your content goes here![/legend]', '26', '1');
			INSERT INTO `#__jv_typos` VALUES (NULL, 'Legend-Hilite', 'legend-hilite', '<div class=\"legend-hilite\"><h3 class=\"legend-title\">{option}</h3><p>{param}</p></div>', '[legend-hilite=style highlight]Your content goes here![/legend-hilite]', '27', '1');
			INSERT INTO `#__jv_typos` VALUES (NULL, 'badge', 'badge', '<div class=\"jv-module module-badge badge-{option}\"><span class=\"badge\"></span>{param}</div>', '[badge=top]<div style=\"padding: 30px 25px;\">Use module suffix: <strong>_badge badge-top</strong> to put this badge on any module you like!</div>[/badge]\r\n[badge=new]<div style=\"padding: 30px 25px;\">Use module suffix: <strong>_badge badge-new</strong> to put this badge on any module you like!</div>[/badge]\r\n[badge=hot]<div style=\"padding: 30px 25px;\">Use module suffix: <strong>_badge badge-hot</strong> to put this badge on any module you like!</div>[/badge]\r\n[badge=pick]<div style=\"padding: 30px 25px;\">Use module suffix: <strong>_badge badge-pick</strong> to put this badge on any module you like!</div>[/badge]', '22', '1');
			INSERT INTO `#__jv_typos` VALUES (NULL, 'Youtube', 'youtube', '<a class=\"btn\" data-toggle=\"modal\" href=\"#md{param}\">Watch Video</a>\r\n<div class=\"btmodal fade hide\" id=\"md{param}\">\r\n    <div class=\"modal-body\">\r\n        <iframe {option} src=\"http://www.youtube.com/embed/{param}\" frameborder=\"0\" allowfullscreen></iframe>\r\n    </div>\r\n</div>\r\n', '[youtube=width=\"530\" height=\"350\"]DgwtRpf60xI[/youtube]', '23', '1');
			INSERT INTO `#__jv_typos` VALUES (NULL, 'Vimeo', 'vimeo', '<a class=\"btn\" data-toggle=\"modal\" href=\"#md{param}\">Watch Video</a>\r\n<div class=\"btmodal fade hide\" id=\"md{param}\">\r\n    <div class=\"modal-body\">\r\n       <iframe {option} src=\"http://player.vimeo.com/video/{param}\" frameborder=\"0\" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe>\r\n    </div>\r\n</div>\r\n', '[vimeo=width=\"500\" height=\"281\"]46497874[/vimeo]', '24', '1');
			INSERT INTO `#__jv_typos` VALUES (NULL, 'Alerts ', 'alert', '<div class=\"alert {option}\">\r\n	<button class=\"close\" data-dismiss=\"alert\">×</button>\r\n	{param}\r\n</div>', '[alert=alert-block]<h4 class=\"alert-heading\">Warning!</h4> Best check yo self, you\'re not looking too good.[/alert]\r\n[alert=alert-error alert-block]<h4 class=\"alert-heading\">Oh snap!</h4> Change a few things up and try submitting again.[/alert]\r\n[alert=alert-success alert-block]<h4 class=\"alert-heading\">Well done!</h4> You successfully read this important alert message.[/alert]\r\n[alert=alert-info alert-block]<h4 class=\"alert-heading\">Heads up!</h4> This alert needs your attention, but it\'s not super important.[/alert]', '25', '1');
			INSERT INTO `#__jv_typos` VALUES (NULL, 'Icon', 'icon', '<i class=\"icon-{option}\">{param}</i>', '[icon=search][/icon]Graciously provided by Glyphicons\r\n<div class=\"input-prepend\"><span class=\"add-on\">[icon=envelope][/icon]</span><input type=\"text\" id=\"inputIcon\" class=\"span2\"></div>\r\n<a href=\"#\" class=\"btn btn-large\">[icon=comment][/icon] Comment</a>\r\n<a href=\"#\" class=\"btn btn-primary\">[icon=user icon-white][/icon] User</a>', '21', '1');
		";
		// Create table
		self::query($query);
		
		$db = JFactory::getDbo ();
		$db->setQuery("SELECT * FROM #__jv_typos");
		
		if($db->loadResult())
			return true;
			
		// Insert data
		self::query($data);
	}
	
	public static function query($query) {
		$db = JFactory::getDbo ();
		$queries = JInstallerHelper::splitSql ( $query );
			
			// Process each query in the $queries array (split out of sql file).
			foreach ( $queries as $query ) {
				$query = trim ( $query );
				
				if ($query != '' && $query {0} != '#') {
					$db->setQuery ( $query );

                    try{
                        $db->query ();
                    }catch (RuntimeException $e){
                        JFactory::getApplication()->enqueueMessage(JText::sprintf ( 'JLIB_INSTALLER_ERROR_SQL_ERROR', $e->getMessage() ), 'warning');
                    }

				}
			}
	}
	
	
public static function displayResults() {
		?>
<h3 style="
    border-top: 1px solid #CCC;
    padding-top: 30px;
    color: green;
    font-weight: bold;
    font-size: 18px;
">JV Framework Installation Status:</h3>
<table class="adminlist table table-striped">
	<thead>
		<tr>
			<th width="60%">Name</th>
			<th width="20%">Type</th>			
			<th width="20%">Status</th>
		</tr>
	</thead>	
	<tbody>
<?php 	foreach ( self::$extensions as $i => $extension ): ?>			
		<tr class="row<?php echo $i++ % 2; ?>">
			<td><?php echo $extension['manifest']->name; ?></td>
			<td><?php echo $extension['type']; ?></td>
			<td>
				<?php $style  = $extension['installed'] ? 'font-weight: bold; color: green;' : 'font-weight: bold; color: red;'; ?>
				<?php $update = $extension['isUpgrade'] ? 'Updated' : 'Installed'; ?>
				<span style="<?php echo $style; ?>"><?php echo JText::_($update. ($extension['installed'] ? ' successfully' : ' error')); ?></span>
			</td>
		</tr>
<?php 	endforeach; ?>
	</tbody>
	<tfoot>
		<tr>
			<td colspan="3">&nbsp;</td>
		</tr>
	</tfoot>
</table>

<?php
	
	}
}}