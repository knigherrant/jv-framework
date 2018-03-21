<?php/** * plg_system_jvvmhelper - JV VM Helper * @version		1.0.0 * ------------------------------------------------------------------------ * author    PHPKungfu Solutions Co * copyright Copyright (C) 2015 phpkungfu.club. All Rights Reserved. * @license - http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL or later. * Websites: http://www.phpkungfu.club * Technical Support:  http://www.phpkungfu.club/my-tickets.html*------------------------------------------------------------------------*/// No direct access to this filedefined('_JEXEC') or die('Restricted access');jimport('joomla.plugin.plugin');JFactory::getLanguage()->load('plg_system_jvvmhelper', JPATH_ADMINISTRATOR);class plgSystemJVVMHelper extends JPlugin{        public $app;        public $option;        public $view;        public $input;		static $replace = array();            	function plgSystemJVVMHelper( &$subject, $params ){		parent::__construct( $subject, $params );			$this->app = JFactory::getApplication();			$this->input = $this->app->input;                		}        public function onAfterRoute(){}        public function onAfterDispatch(){}                public function isSite(){            $this->option = $this->input->getString('option');            $this->view = $this->app->input->getString('view');			if($this->app->getName() != 'site') return false;            return true;        }        		public function isAllow(){			$allow = (array) jvmLibs::getConfig()->get('allow','all');			if(in_array('all', $allow)) return true;			if(in_array('detail', $allow)){				if($this->option == 'com_virtuemart' && $this->view == 'productdetails' ) return true;			}			if(in_array('list', $allow)){				if($this->option == 'com_virtuemart' && ($this->view == 'category' || $this->view == 'virtuemart' )) return true;			}			return false;		}				        public function isUse($type = 'compare'){            $use = (array) jvmLibs::getConfig()->get('use','all');			if(in_array('all', $use)) return true;            if(in_array($type, $use)) return true;            return false;        }              public function addProductList(){            $buffer = $this->app->getBody();		            $jdoc = phpQuery::newDocumentHTML($buffer);            $cart = pq('form.product');            if($cart) foreach ($cart as $c){                $jCart = pq($c);                $inputs = pq($c)->find('input[type=hidden]');				if($inputs) foreach ($inputs as $input){					$jInput = pq($input);					if($jInput->attr('name') == 'virtuemart_product_id[]'){						$productid = $jInput->val();						if($productid){							$hiddren = '<input type="hidden" value="'.$productid.'" name="virtuemart_product_id[]">';							$tmpl = $hiddren . '<div class="jvvm-custom">';							if($this->isUse('compare')){								$tmpl .= $this->loadTmplCompare($productid);							}							if($this->isUse('wishlist')){								$tmpl .= $this->loadTmplWishlist($productid);							}							$tmpl .= '</div>';							$parten = '/<input\s+type\s*=\s*[\'|"]\s*hidden\s*[\'|"]\s+name\s*=\s*[\'|"]\s*virtuemart_product_id\[\]\s*[\'|"]\s+value\s*=\s*[\'|"]\s*'.$productid.'\s*[\'|"]\/>/i';							preg_match($parten, $buffer, $match);							if(!$match[0]){								$parten = '/<input\s+type\s*=\s*[\'|"]\s*hidden\s*[\'|"]\s+value\s*=\s*[\'|"]\s*'.$productid.'\s*[\'|"]\s+name\s*=\s*[\'|"]\s*virtuemart_product_id\[\]\s*[\'|"]\/>/';							}							if(isset(self::$replace[$productid]) and self::$replace[$productid] == true){								$buffer = preg_replace($parten, $hiddren, $buffer, 1);								self::$replace[$productid] = false;							}							else{								$buffer = preg_replace($parten, $tmpl, $buffer, 1);								self::$replace[$productid] = true;							}						}					}					//@self::$replace[$productid] = false;				}            }            $this->app->setBody($buffer);        }               public function onAfterRender(){            if(!$this->isSite()) return false;            if(!class_exists('phpQuery')) require_once JPATH_SITE.'/plugins/system/jvvmhelper/fields/phpQuery.php';            //$this->addProductDetail(); //BKA004195 //ADT SPS008272            if($this->isAllow()) $this->addProductList();                    }        public function onBeforeRender(){            if(!$this->isSite()) return;            $document = JFactory::getDocument();            if(version_compare(JVERSION, '3.0', '<')) $document->addScript(JUri::root().'plugins/system/jvvmhelper/assets/js/jquery.min.js');            else JHtml::_('Jquery.framework');            $document->addScript(JUri::root().'plugins/system/jvvmhelper/assets/js/jvvmhelper.js');            $document->addStyleSheet(JUri::root().'plugins/system/jvvmhelper/assets/css/jvvmhelper.css');        }        public function loadTmplWishlist($productid, $catid=0, $itemid=0){                $app = JFactory::getApplication();                if(!$itemid) $itemid = $app->input->getInt('Itemid');                if(!$catid) $catid = $app->input->getInt('virtuemart_category_id');		ob_start();		?>			<div class="jvWishlist">				<a title="<?php echo JText::_('PLG_SYSTEM_JVVM_ADD_TO_WISHLIST');?>" class="btn btn-primary <?php echo (jvmLibs::isAdded($productid))? 'jadded' : '';?>" data-task="addWishlist" data-catid="<?php echo $catid;?>" data-itemid="<?php echo $itemid; ?>" data-id="<?php echo $productid; ?>" href="javascript:void(0);">				<span><?php echo JText::_('PLG_SYSTEM_JVVM_ADD_TO_WISHLIST');?></span>				<i class="fa fa-heart"></i>				</a>					</div>		<?php 		$tmpl = ob_get_clean();		return $tmpl;	}                public function loadTmplCompare($productid, $catid=0, $itemid=0){                $app = JFactory::getApplication();                if(!$itemid) $itemid = $app->input->getInt('Itemid');                if(!$catid) $catid = $app->input->getInt('virtuemart_category_id');		ob_start();		?>		<div class="jvcompare">			<a title="<?php echo JText::_('PLG_SYSTEM_JVVM_ADD_TO_COMPARE');?>" class="btn btn-primary <?php echo (jvmLibs::hasCompare($productid))? 'jadded' : '';?>" data-task="addCompare" data-catid="<?php echo $catid;?>" data-itemid="<?php echo $itemid; ?>" data-id="<?php echo $productid; ?>" href="javascript:void(0);">			<span><?php echo JText::_('PLG_SYSTEM_JVVM_ADD_TO_COMPARE');?></span>			<i class="fa fa-check"></i>			</a>				</div>		<?php 		$tmpl = ob_get_clean();		return $tmpl;	}}class jvmLibs{            static $config;            public static function getConfig(){            if(!isset(self::$config)){                $plugin = JPluginHelper::getPlugin('system', 'jvvmhelper');                self::$config = new JRegistry($plugin->params);            }            return self::$config;        }	        public static function buildRoute($view){            $menu = JFactory::getApplication()->getMenu();            $items = $menu->getMenu();            $url = '';            foreach ($items as $id=>$item){                if(isset($item->query['option']) && $item->query['option']=='com_jvvmhelper'){                    if($item->query['view'] == $view){                        $url = 'index.php?option=com_jvvmhelper&Itemid='.$id;                    }                }            }            if(!$url){                $config = jvmLibs::getConfig();                $input = JFactory::getApplication()->input;                $url = 'index.php?option=com_jvvmhelper&view='.$view.'&Itemid='.$config->get('itemid_'.$view, $input->getInt('Itemid'));            }            return JRoute::_($url);        }        	public static function loadJCompare($productid, $catid=0, $itemid=0){            JPluginHelper::importPlugin('system', 'jvvmhelper');            $dispatcher	= JDispatcher::getInstance();            $compare = $dispatcher->trigger('loadTmplCompare',array($productid, $catid, $itemid));            return $compare[0];	}                public static function loadJWishlist($productid, $catid=0, $itemid=0){            JPluginHelper::importPlugin('system', 'jvvmhelper');            $dispatcher	= JDispatcher::getInstance();            $wishlist = $dispatcher->trigger('loadTmplWishlist',array($productid, $catid, $itemid));            return $wishlist[0];	}                public static function getCompare(){            $session = JFactory::getSession();            $compare = $session->get('jvmLibs',array());            return $compare;        }                public static function hasCompare($product_id){            $compare = self::getCompare();            if(in_array($product_id, $compare)) return true;            return false;        }                public static function addCompare($product_id){            $compare = self::getCompare();            $config = self::getConfig();            if(count($compare) >= $config->get('limit') ) return 2;            if(in_array($product_id, $compare)) return 3;            $compare[] = $product_id;            $session = JFactory::getSession();            $session->set('jvmLibs', $compare);            return true;        }                public static function removeCompare($product_id){            $compare = self::getCompare();            if(in_array($product_id, $compare)){                foreach ($compare as $i=>&$p) if($p == $product_id){                    unset ($compare[$i]);                    $session = JFactory::getSession();                    $session->set('jvmLibs', $compare);                    return true;                }            }            return false;        }                public static function getClient()	{		$ua = JFactory::getApplication()->client;		$uaString = $ua->userAgent;		$browserVersion = $ua->browserVersion;		$uaShort = str_replace($browserVersion, 'abcd', $uaString);		return md5(JUri::base() . $uaShort);	}                public static function msgCompare($i){            $message = array(                1 => JText::_('PLG_SYSTEM_JVVM_ADD_TO_COMPARE_SUCCESS'),                2 => JText::_('PLG_SYSTEM_JVVM_ADD_TO_COMPARE_LIMIT'),                3 => JText::_('PLG_SYSTEM_JVVM_ADD_TO_COMPARE_EXISTS'),            );            return isset($message[$i])? $message[$i] : JText::_('PLG_SYSTEM_JVVM_ADD_TO_COMPARE_ERROR');        }                public static function msgWishlist($i){            $message = array(                1 => JText::_('PLG_SYSTEM_JVVM_ADD_TO_WISHLIST_SUCCESS'),                2 => JText::_('PLG_SYSTEM_JVVM_ADD_TO_WISHLIST_EXISTS'),                3 => JText::_('PLG_SYSTEM_JVVM_PLEASE_LOGIN_FIRST'),            );            return isset($message[$i])? $message[$i] : JText::_('PLG_SYSTEM_JVVM_ADD_TO_WISHLIST_ERROR');        }                public static function isShow($name = 'all'){            $config = self::getConfig();            $show = (array)$config->get('showcol','all');            if(in_array('all', $show)) return true;            if(in_array($name, $show)) return true;            return false;        }                public static function addWishlist($pid){            $user = JFactory::getUser();            if(!$user->id) return 3;            if(!$pid) return false;            if(self::isAdded($pid)) return 2;            $db = JFactory::getDbo();            $created = JFactory::getDate()->toSql();            return $db->setQuery("INSERT INTO #__jvwishlist (product_id, userid, created) VALUES ('$pid','$user->id' ,'$created')")->execute();        }                public static function isAdded($pid){            $user = JFactory::getUser();            $db = JFactory::getDbo();            return $db->setQuery('SELECT id FROM #__jvwishlist WHERE product_id=' . (int)$pid . ' AND userid=' .$user->id )->loadResult();        }                public static function  getWishlist(){            $user = JFactory::getUser();            $db = JFactory::getDbo();            $productid =  $db->setQuery('SELECT product_id FROM #__jvwishlist WHERE userid=' .$user->id )->loadObjectList();            $ids = array();            foreach ($productid as $id){                $ids[] = $id->product_id;            }            return $ids;        }                public static function  removeWishlist($pid){            $user = JFactory::getUser();            if(!$user->id) return false;            $db = JFactory::getDbo();            return $db->setQuery('DELETE FROM #__jvwishlist WHERE product_id=' . (int)$pid . ' AND userid=' .$user->id )->execute();        }        public static function isWish($x){            return true;        }        }