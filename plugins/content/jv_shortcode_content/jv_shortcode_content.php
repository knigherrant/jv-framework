<?php
// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

class plgContentJv_shortcode_content extends JPlugin {
	public function onContentPrepare($context, &$article, &$params, $page = 0){
		$app = JFactory::getApplication();
		if($app->isAdmin()) return;
		
		$content = $article->text;
		require_once (JPATH_ROOT.'/plugins/system/jv_shortcode_system/shortcode/core/generator.php');
		global $shortcode_tags;
		Jv_shortcodeHelper::init();
		$content = do_shortcode($content);
		$article->text = $content;
	}
}