<?php
/**
 # JV Framework
 # @version		1.5.x
 # ------------------------------------------------------------------------
 # author    PHPKungfu Solutions Co
 # copyright Copyright (C) 2011 phpkungfu.club. All Rights Reserved.
 # @license - http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL or later.
 # Websites: http://www.phpkungfu.club
 # Technical Support:  http://www.phpkungfu.club/my-tickets.html
 */
defined ( '_JEXEC' ) or die ( 'Restricted access' );

class JVFrameworkHelperManifest extends JVFrameworkHelper {
	protected $_name = 'manifest';
	protected static $positions = null;
	
	public function __construct() {
		parent::__construct ();
		
		if (! class_exists ( 'phpQuery' )) {
			require_once $this ['path']->findPath ( 'phpQuery.php', 'classes' );
		}
	}
	
	public function getPositions($position = null) {		
		if(!self::$positions){						
			phpQuery::newDocumentFileXML ( $this ['path']->findPath ( 'templateDetails.xml', 'theme' ), $charset = 'utf-8' );
			self::$positions = pq ( 'position' );
		}
		
		$regex = '#^'.$position.'-\d(\d?)#';
		$positions = array();
		foreach ( self::$positions as $node ) {
                   
			if (is_null ( $position )) {
				$positions [] = $node->nodeValue;
				
			} else {
				if(preg_match($regex, $node->nodeValue) || ($position == $node->nodeValue) ){
					$positions [] = $node->nodeValue;
				}
			}
		
		}

		return $positions;
	}
	
	
}

?>