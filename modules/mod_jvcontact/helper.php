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


class modJVContactHelper extends JObject
{
	function __construct($moduleid,$params){
		
		
		$this->_moduleid = $moduleid;
		
		$myparams = $this->_getParams($params);
		$this->_params = $myparams;
		
		$this->_addAssets();
		
		
		return;
	}
	private function _getParams($params){
		
		$arr['moduleclass_sfx'] = htmlspecialchars($params->get('moduleclass_sfx'));
		$arr['textheader']		= $params->get('textheader');
		$arr['textfooter']		= $params->get('textfooter');
		$arr['thankyou']		= $params->get('thankyou','Thank you!');
		$arr['textsubmit']		= $params->get('textsubmit','Submit');
		$arr['moreinfo']		= $params->get('moreinfo');
		$arr['mailsubject']		= $params->get('mailsubject');
		$arr['mailcopy']		= $params->get('mailcopy');
		
		$arr['layout']			= $params->get('layout','default');
		$arr['customlayout']	= $params->get('customlayout');
		$arr['customcss']		= $params->get('customcss');
		
		$arr['mailto']			= $params->get('mailto');
		$arr['mailto2']			= $params->get('mailto2');
		
		$arr['showform']		= $params->get('showform',1);
		$arr['textinfield']		= $params->get('textinfield');
		$arr['customfield']		= $params->get('customfield');
		
		$arr['showsocial']		= $params->get('showsocial');
		$arr['showfacebook']	= $params->get('showfacebook',1);
		$arr['showtweeter']		= $params->get('showtweeter',1);
		$arr['showgplus']		= $params->get('showgplus',1);
		$arr['showlikein']		= $params->get('showlikein',1);
		$arr['showaddthismore']	= $params->get('showaddthismore',1);
		$arr['social']			= $this->_getSocial($arr);
		
		
		
		$arr['showcaptcha']			= $params->get('showcaptcha',1);
		$arr['captchapublickey']	= $params->get('captchapublickey');
		$arr['captchaprivatekey']	= $params->get('captchaprivatekey');
		$arr['captchatheme']		= $params->get('captchatheme','white');
		
		$arr['captcha_instructions_visual']		= $params->get('captcha_instructions_visual','Instructions visual');
		$arr['captcha_instructions_audio']		= $params->get('captcha_instructions_audio','Instructions audio');
		$arr['captcha_play_again']				= $params->get('captcha_play_again','Play again');
		$arr['captcha_cant_hear_this']			= $params->get('captcha_cant_hear_this','Cant hear this');
		$arr['captcha_visual_challenge']		= $params->get('captcha_visual_challenge','Visual challenge');
		$arr['captcha_audio_challenge']			= $params->get('captcha_audio_challenge','Audio challenge');
		$arr['captcha_refresh_btn']				= $params->get('captcha_refresh_btn','Refesh');
		$arr['captcha_help_btn']				= $params->get('captcha_help_btn','Help');
		$arr['captcha_incorrect_try_again']		= $params->get('captcha_incorrect_try_again','Incorrect try again');
		
		$arr['captcha']				= $this->_getCaptcha($arr);
		
		
		$arr['showmap']		= $params->get('showmap');
		$arr['map_width']	= $params->get('map_width','100%');
		$arr['map_height']	= $params->get('map_height','200px');
		$arr['map_lat']		= $params->get('map_lat','10.784513');
		$arr['map_long']	= $params->get('map_long','106.630744');
		$arr['map_address']	= $params->get('map_address','192 phu tho hoa, tan phu, ho chi minh, viet nam');
		$arr['map_icon']	= $params->get('map_icon');
		$arr['map_zoom']	= $params->get('map_zoom','17');
		$arr['map_apikey']	= $params->get('map_apikey','AIzaSyD7KJAbPjbKDmQxCVsiTlVOmQihmbOoFdY');
		
		$arr['map_infotext']	= $params->get('map_infotext',"I'm here");
		$arr['map_marker']		= $params->get('map_marker',"");
		
		
		$arr['map']			= $this->_getMap($arr);
		
		$arr['moduleid']	= $this->_moduleid;
		return $arr;
	}
	
	private function _getMap($myparams){
		
		if(!$myparams['showmap']) return;
		
		$doc = JFactory::getDocument();
		$doc->addScript('http://maps.googleapis.com/maps/api/js?key='.$myparams['map_apikey'].'&sensor=false');
		$doc->addScript(JURI::root().'modules/mod_jvcontact/assets/js/jvmap.js');
		
		$mapid = 'jvmap'.$this->_moduleid;
		
		$infotext = str_replace('"', '\"', $myparams['map_infotext']);
		$infotext = str_replace("\r\n", '<br/>', $infotext);
		
		
		$html = '<div style="width:'.$myparams['map_width'].';height:'.$myparams['map_height'].'" class="jvmapcontain" id="'.$mapid.'"></div>
		<script type="text/javascript">
		var myjvmap = new jvmap({
							jvmapid		:"'.$mapid.'",
							lat			:"'.$myparams['map_lat'].'",
							lng			:"'.$myparams['map_long'].'",
							address		:"'.$myparams['map_address'].'",
							zoom		:'.$myparams['map_zoom'].',
							iconmarker	:"'.$myparams['map_icon'].'",
							infotext	:"'.$infotext.'"
						});
		';
		$markers = $myparams['map_marker'];
		if($markers && isset($markers)) foreach($markers as $marker){
			$arr = explode('|',$marker);
			$arr[2] = str_replace("'", "\'", $arr[2]);
			$arr[2] = str_replace('"', '\"', $arr[2]);
			$html .= "myjvmap.placeMarker($arr[0],$arr[1],'$arr[2]');";
		}
		
		$html .= '</script>';
			
		return $html;
	}
	
	private function _checkCaptcha($privatekey){
		
		$post = JRequest::get('post');
		require_once(dirname(__FILE__).'/assets/recaptchalib.php');
		
		$url = JFactory::getURI()->toString();
		@$resp = recaptcha_check_answer(
				$privatekey,
				$url,
				$post["recaptcha_challenge_field"],
				$post["recaptcha_response_field"]
		);
		
		if (!$resp->is_valid) {
			return false;
		}
				
		return true;
	}
	function getUserEmail($userids){
		$db = JFactory::getDBO();
		$userids = implode(',',$userids);
		$query = "select email from #__users where id in ($userids)";
		$db->setquery($query);
		return $db->loadResultArray();
	}
	
	function sendMail($fields){
		
		$posts = JRequest::get('post');
		$myparams = $this->_params;
		$moduleid = $myparams['moduleid'];
		
		if($myparams['showcaptcha']){
			if(!$this->_checkCaptcha($myparams['captchaprivatekey'])) return 'Invalid Captcha!';
		}
		
		if(isset($posts['jvcontact'])) $post = $posts['jvcontact'][$moduleid];
		
		if(isset($post)){
			$token = JRequest::checkToken();
			if($token){
				$name = $post['name'];
				$email = $post['email'];
				$cc = $bcc = null;
				$subject = $post['subject']?$post['subject']:$myparams['mailsubject'];
				
				if(isset($posts['cbcopymail']) && $posts['cbcopymail']){
					$bcc = $email;
				}
				
				foreach($post as $key=>$p){
					if(is_array($p)){
						$post[$key] = implode(', ',$p);
					}
				}
					
				$mailto = $myparams['mailto'];
				$mailto2 = $myparams['mailto2'];
					
				if($mailto){
					$recipient = $this->getUserEmail($mailto);
				}
					
				if($mailto2){
					$mailto2 = explode("\r\n",$mailto2);
					foreach($mailto2 as $mail){
						if($mail!='') $recipient[] = $mail;
					}
				}
					
				$body = $this->getBodyMail($fields,$post);
					
				
				if($name && $email && $subject){
					$mail = new JMail();
					if($mail->sendMail($email, $name, $recipient, $subject, $body,1,$cc,$bcc)){
						return $myparams['thankyou'];
					}else{
						return 'Error in send mail!';
					}
				}else{
					return 'Invalid form!';
				}
			}else{
				return 'Invalid Token!';
			}
			
		}
		
		return;
	}
	
	public function getBodyMail($fields,$post){
		$html = '<table style="width:100%">';
		if($fields) foreach($fields as $field){
			$name = $field['name'];
			$html .= '<tr><td>'.$field['title'].'</td><td>'.$post[$name].'</td></tr>';
		}
		
		$html .= '</table>';
		
		$html = JString::str_ireplace("\r\n", "<br/>", $html);
		return $html;
	}
	
	private function _addAssets(){
		$myparams = $this->_params;
		$doc = JFactory::getDocument();
		
		JHTML::_('behavior.framework');
		
		$doc->addScript('modules/mod_jvcontact/assets/js/default.js');
		
		$myparams['layout'] = substr($myparams['layout'],2);
		
		if($myparams['layout']=='custom'){
			$doc->addStyleDeclaration($myparams['customcss']);
		}else{
			
			if($myparams['layout']){
				$doc->addStyleSheet('modules/mod_jvcontact/assets/css/'.$myparams['layout'].'.css');
			}
			
		}
		
		return;
	}
	
	function getFields(){
		$myparams = $this->_params;
		$moduleid = $myparams['moduleid'];
		$rows = array();
		$fields = $myparams['customfield'];
		$fields = JArrayHelper::fromObject($fields);
		if($fields) foreach ($fields as $k=>$field){
			$key = $field['name'];
			$rows[$key]['title'] = $field['title'];
			$rows[$key]['name'] = $field['name'];
			$fieldname = 'jvcontact['.$moduleid.']['.$field['name'].']';
			
			if($myparams['textinfield'] && ($field['type']=='text' || $field['type']=='textarea' || $field['type']=='name' || $field['type']=='email' || $field['type']=='subjectfield')){
				$field['value'] = $field['title'];
				$field['attribute'] = 'placeholder="'.$field['title'].'"';
				
			}else{
				$rows[$key]['label'] = $field['title'];
			}
			
			
			$field['validate'] .= ' field-'.$field['name'];
			switch($field['type']){
				case 'name':
				case 'email':
				case 'subjectfield':
				case 'text':
					$rows[$key]['input'] = '<input class="inputbox '.$field['validate'].'" type="text" name="'.$fieldname.'" value="" '.@$field['attribute'].'/>';
					
					break;
				case 'textarea':
					$rows[$key]['input'] = '<textarea class="inputbox '.$field['validate'].'" name="'.$fieldname.'" '.@$field['attribute'].'></textarea>';
					break;
				case 'radio':
					$options = explode("\r\n",$field['option']);
					$option = array();
					if($options) foreach($options as $opt){
						$option[] = JHTML::_('select.option',$opt,$opt);
					}
					
					$rows[$key]['input'] = JHTML::_('select.radiolist',$option,$fieldname,'class="btn-group"');
					
					break;
				case 'checkbox':
					$html = '';
					
					$options = explode("\r\n",$field['option']);
					
					if($options) foreach($options as $opt){
						$html .= '<input type="checkbox" id="'.$opt.'" name="'.$fieldname.'[]" value="'.$opt.'" />';
						$html .= '<label class="checkbtn" for="'.$opt.'">'.$opt.'</label>';
					} 
						
					
					$rows[$key]['input'] = $html;
					break;
				case 'select':
					$options = explode("\r\n",$field['option']);
					unset($option);
					if($options) foreach($options as $opt){
						$option[] = JHTML::_('select.option',$opt,$opt);
					}
						
					$html = JHTML::_('select.genericlist',$option,$fieldname);
					$rows[$key]['input'] = $html;
					break;
			}
		}
		return $rows;
	}
	
	private function _getSocial($myparams){
		
		$html = '';
		$showsocial = $myparams['showsocial'];
		
		
		if($showsocial){
			$html = '<script type="text/javascript" src="http://s7.addthis.com/js/250/addthis_widget.js#pubid=xa-4fac7257716dacd5"></script>';
			
			if($showsocial==3){
				if($myparams['showfacebook'])	$button[] = '<a class="addthis_button_facebook_like" fb:like:layout="button_count"></a>';
				if($myparams['showtweeter'])	$button[] = '<a class="addthis_button_tweet"></a>';
				if($myparams['showgplus'])		$button[] = '<a class="addthis_button_google_plusone" g:plusone:size="medium"></a>';
				if($myparams['showlikein'])		$button[] = '<a class="addthis_button_linkedin"></a>';
				if($myparams['showaddthismore']) $button[] = '<a class="addthis_counter addthis_pill_style"></a>';
				
				
				$button = $button?implode(' ',$button):'';
				
			}else{
				if($myparams['showfacebook']) 		$button[] = '<a class="addthis_button_facebook"></a>';
				if($myparams['showtweeter']) 		$button[] = '<a class="addthis_button_twitter"></a>';
				if($myparams['showgplus']) 			$button[] = '<a class="addthis_button_email"></a>';
				if($myparams['showlikein']) 		$button[] = '<a class="addthis_button_linkedin"></a>';
				if($myparams['showaddthismore']) 	$button[] = '<a class="addthis_button_compact"></a><a class="addthis_counter addthis_bubble_style"></a>';
				
				$button = $button?implode(' ',$button):'';
				
				if($showsocial==2)	$bigstyle = 'addthis_32x32_style';
				
			}
			
			$html .= '<div class="addthis_toolbox addthis_default_style '.@$bigstyle.'">'.$button.'</div>';
			
		}
		
		
		return $html;
	}
	
	private function _getCaptcha($myparams){		
		
		if($myparams['showcaptcha']){
			$captchaid = 'recaptcha'.rand(1, 9999);
			
			if($myparams['captchatheme']=='custom'){
				$html[0] = '<div id="'.$captchaid.'" style="display:none">
				
				<div id="recaptcha_image"></div>
				<div class="recaptcha_only_if_incorrect_sol" style="color:red">Incorrect please try again</div>
				
				<span class="recaptcha_only_if_image">Enter the words above:</span>
				<span class="recaptcha_only_if_audio">Enter the numbers you hear:</span>
				
				<input type="text" id="recaptcha_response_field" name="recaptcha_response_field" />
				
				<div><a href="javascript:Recaptcha.reload()">Get another CAPTCHA</a></div>
				<div class="recaptcha_only_if_image"><a href="javascript:Recaptcha.switch_type(\'audio\')">Get an audio CAPTCHA</a></div>
				<div class="recaptcha_only_if_audio"><a href="javascript:Recaptcha.switch_type(\'image\')">Get an image CAPTCHA</a></div>
				
				<div><a href="javascript:Recaptcha.showhelp()">Help</a></div>
				
				</div>
				
				<script type="text/javascript" src="http://www.google.com/recaptcha/api/challenge?k='.$myparams['captchapublickey'].'"></script>
				<noscript>
				<iframe src="http://www.google.com/recaptcha/api/noscript?k='.$myparams['captchapublickey'].'"
				height="300" width="500" frameborder="0"></iframe><br>
				<textarea name="recaptcha_challenge_field" rows="3" cols="40"></textarea>
				<input type="hidden" name="recaptcha_response_field" value="manual_challenge">
				</noscript>
				
				
				';
				$html[1] = '<script type="text/javascript">
					 var RecaptchaOptions = {
					    theme : "custom",
					    custom_theme_widget: "'.$captchaid.'"
					 };
				</script>';
				
				return $html;
			}else{				
				
				$html[0]= '<div id="'.$captchaid.'"></div>
				<script type="text/javascript" src="http://www.google.com/recaptcha/api/js/recaptcha_ajax.js"></script>
				<script type="text/javascript">
				Recaptcha.create("'.$myparams['captchapublickey'].'", "'.$captchaid.'", {
					theme: "'.$myparams['captchatheme'].'",
					//callback: Recaptcha.focus_response_field,
					custom_translations : {
                        instructions_visual : "'.$myparams['captcha_instructions_visual'].':",
                        instructions_audio : "'.$myparams['captcha_instructions_audio'].':",
                        play_again : "'.$myparams['captcha_play_again'].':",
                        cant_hear_this : "'.$myparams['captcha_cant_hear_this'].':",
                        visual_challenge : "'.$myparams['captcha_visual_challenge'].':",
                        audio_challenge : "'.$myparams['captcha_audio_challenge'].':",
                        refresh_btn : "'.$myparams['captcha_refresh_btn'].'",
                        help_btn : "'.$myparams['captcha_help_btn'].'",
                        incorrect_try_again : "'.$myparams['captcha_incorrect_try_again'].'"
                	}
				});
				</script>';
				
				return $html;
			}
			
		}
		
		return ;
	}
	
}
