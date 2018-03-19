<?php
// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');
 
jimport('joomla.form.formfield');
 
// The class name must always be the same as the filename (in camel case)
class JFormFieldJvlnmArticle extends JFormField {
 
        //The field class must know its own type through the variable $type.
        protected $type = 'jvlnmarticle';
 
        public function getInput() 
        {
        	$allowEdit		= ((string) $this->element['edit'] == 'true') ? true : false;
			$allowClear		= ((string) $this->element['clear'] != 'false') ? true : false;

			// Load language
			JFactory::getLanguage()->load('com_content', JPATH_ADMINISTRATOR);

                        JHtml::_('behavior.modal', 'a.modal');
			$listVal = array();
			$countListVal = 0;
			$idNew = "jform_params_sp_article_".$countListVal;
			//exit($this->value);
			if ($this->value !== "" && $this->value !== ",")
			{
				$listVal = explode(",", $this->value); 
				$countListVal = count(array_filter($listVal));
			}
			else
			{
				$listVal = array('0'); 
				$countListVal = 1;
			}

			

			// Load the modal behavior script.
			//JHtml::_('behavior.modal', 'a.modal');

			// Build the script.
			$script = array();

			$script[] = 'id_sp_article_cur = "jform_params_sp_article_'.($countListVal-1).'"';
			$script[] = 'id_sp_article_cur = parseInt(id_sp_article_cur.substr(id_sp_article_cur.lastIndexOf("_")+1));';

			$script[] = 'function ossLoadModal(id){
				SqueezeBox.initialize({});
				SqueezeBox.assign($$(\'#item_jform_params_sp_article_\'+id+\' a.modal\'), {
					parse: \'rel\'
				});
			}';

			$script[] = 'function loadValSpArticle(){';
			$script[] = '	var lv = "";';
			$script[] = '	jQuery("#attrib-article .controls").find(".item_sp_article").each(function(){';
			$script[] = '		lv += jQuery(this).find(".input_item_sp_article").val()+",";';
			$script[] = '	});';
			$script[] = '	return lv;';
			$script[] = '}';

			for ($iilog = 0;$iilog <= $countListVal;$iilog++)
			{
				// Select button script
				$idNew = "jform_params_sp_article_".$iilog;
				$script[] = '	function jSelectArticle_'.$idNew.'(id, title, catid, object) {';
				$script[] = '		a = jQuery("#jform_params_sp_article_id_all").val();';
				$script[] = '		if (a.search(id) == -1){';
				$script[] = '		document.getElementById("'.$idNew.'_id").value = id;';
				$script[] = '		document.getElementById("jform_params_sp_article_id_all").value = loadValSpArticle();';
				$script[] = '		document.getElementById("'.$idNew.'_name").value = title;';

				if ($allowEdit)
				{
					$script[] = '		jQuery("#'.$idNew.'_edit").removeClass("hidden");';
				}

				if ($allowClear)
				{
					$script[] = '		jQuery("#'.$idNew.'_clear").removeClass("hidden");';
				}

				$script[] = '		SqueezeBox.close();';
				$script[] = '		}';
				$script[] = '	}';
			}
			

			// Clear button script
			static $scriptClear;

			if ($allowClear && !$scriptClear)
			{
				$scriptClear = true;

				$script[] = '	function jClearArticle(id) {';
				$script[] = '		a = document.getElementById(id + "_id").value;';
				$script[] = '		b = jQuery("#jform_params_sp_article_id_all").val();';
				$script[] = '		if (a !== ""){ c = b.replace(a+",","");';
				$script[] = '		jQuery("#jform_params_sp_article_id_all").val(c);}';
				$script[] = '		document.getElementById(id + "_id").value = "";';
				$script[] = '		document.getElementById(id + "_name").value = "'.htmlspecialchars(JText::_('COM_CONTENT_SELECT_AN_ARTICLE', true), ENT_COMPAT, 'UTF-8').'";';
				$script[] = '		jQuery("#"+id + "_clear").addClass("hidden");';
				$script[] = '		if (document.getElementById(id + "_edit")) {';
				$script[] = '			jQuery("#" + id + "_edit").addClass("hidden");';
				$script[] = '		}';
				$script[] = '		return false;';
				$script[] = '	}';
			}

			$script[] = 'function jOssAddArticle(id,el) { ';
			$script[] = '	if (jQuery("#jform_params_sp_article_"+id_sp_article_cur+"_id").val() == ""){';
			$script[] = '		alert(\''.JText::_('MOD_JVLATEST_NEWS_FIELD_ARTICLE_MESSERROR1').'\');';
			$script[] = '		return false;';
			$script[] = '	}';
			$script[] = '	id_sp_article_cur++;';
			$script[] = '	if (jQuery("#item_jform_params_sp_article_"+id_sp_article_cur).length){';
			$script[] = '		jQuery("#item_jform_params_sp_article_"+id_sp_article_cur).removeClass("hidden");';
			$script[] = '		jQuery("#jform_params_sp_article_"+(id_sp_article_cur)+"_add").removeClass("hidden");';
			$script[] = '		//return false;';
			$script[] = '	}else{';
			$script[] = '		a = jQuery("#jform_params_sp_article_orginal").html();';
			$script[] = '		b = jQuery(el).parents(".controls");';
			$script[] = '		c = parseInt(id.substr(id.lastIndexOf("_")+1));';
			$script[] = '		a = a.replace(/momo_0/g, \'article_\'+(id_sp_article_cur));';
			$script[] = '		b.append(a);';
			$script[] = '	}';
			$script[] = '	jQuery("#jform_params_sp_article_"+id_sp_article_cur+"_id").attr("value","");';
			$script[] = '	jQuery("#jform_params_sp_article_"+(id_sp_article_cur)+"_add").removeClass("hidden");';
			$script[] = '	jQuery("#jform_params_sp_article_"+(id_sp_article_cur)+"_clear").addClass("hidden");';
			$script[] = '	jQuery("#jform_params_sp_article_"+(id_sp_article_cur)+"_name").val("'.htmlspecialchars(JText::_('COM_CONTENT_SELECT_AN_ARTICLE', true), ENT_COMPAT, 'UTF-8').'");';
			$script[] = '	jQuery(el).addClass("hidden");';
			$script[] = '	ossLoadModal(id_sp_article_cur);';
			$script[] = '	return false;';
			$script[] = '}';

			$script[] = 'function jOssRemoveArticle(id,el) {';
			$script[] = '	a = parseInt(id.substr(id.lastIndexOf("_")+1));';
			$script[] = '	aa = jQuery("#" + id + "_id").val();';
			$script[] = '	bb = jQuery("#jform_params_sp_article_id_all").val();';
			$script[] = '	if (aa !== ""){ cc = bb.replace(aa+",","");';
			$script[] = '	jQuery("#jform_params_sp_article_id_all").val(cc);}';
			$script[] = '	if (a == id_sp_article_cur) {';
			$script[] = '		b = parseInt(jQuery(el).parents(".controls").children(".item_sp_article:not(.hidden)").length)-2;';
			$script[] = '		c = jQuery("#attrib-article .controls").find(".item_sp_article").eq(b);console.log(b);';
			$script[] = '		d = parseInt(c.attr("id").substr(c.attr("id").lastIndexOf("_")+1));';
			$script[] = '		c.find(".sp_article_add").removeClass("hidden");';
			$script[] = '		id_sp_article_cur = d;';
			$script[] = '	}';
			$script[] = '	jQuery("#item_"+id).addClass("hidden");';
			$script[] = '	jQuery("#item_"+id+" input").attr("value","");';
			$script[] = '	return false;';
			$script[] = '}';

			$script[] = 'jQuery(document).ready(function(){
				jQuery("#jform_params_sp_article_0_remove").addClass("hidden");
				jQuery("#jform_params_sp_article_orginal").clone().prependTo("#attrib-article");
				jQuery("#attrib-article .controls #jform_params_sp_article_orginal").remove();
			});';

			// Add the script to the document head.
			JFactory::getDocument()->addScriptDeclaration(implode("\n", $script));

			// Setup variables for display.
			$html	= array();
			$htmlOr = array();

			//if ($this->value !== "")
			//{	
				$iCol = 1;
				foreach ($listVal as $key => $value) 
				{ 
					if ($value !== "")
					{
						$idNew = "jform_params_sp_article_".$key;
						$link	= 'index.php?option=com_content&amp;view=articles&amp;layout=modal&amp;tmpl=component&amp;function=jSelectArticle_'.$idNew;

						if (isset($this->element['language']))
						{
							$link .= '&amp;forcedLanguage='.$this->element['language'];
						}

						if ((int) $value > 0)
						{
							$db	= JFactory::getDbo();
							$query = $db->getQuery(true)
								->select($db->quoteName('title'))
								->from($db->quoteName('#__content'))
								->where($db->quoteName('id') . ' = ' . (int) $value);
							$db->setQuery($query);

							try
							{
								$title = $db->loadResult();
							}
							catch (RuntimeException $e)
							{
								JError::raiseWarning(500, $e->getMessage());
							}
						}

						if (empty($title))
						{
							$title = JText::_('COM_CONTENT_SELECT_AN_ARTICLE');
						}
						$title = htmlspecialchars($title, ENT_QUOTES, 'UTF-8');

						// The active article id field.
						if (0 == (int) $value)
						{
							$value = '';
						}
						else
						{
							$value = (int) $value;
						}

						// The current article display field.
						$html[] = '<div id="item_'.$idNew.'" class="item_sp_article" style="margin-bottom: 20px">';
						$html[] = '<span class="input-append">';
						$html[] = '<input type="text" class="input-medium" id="'.$idNew.'_name" value="'.$title.'" disabled="disabled" size="35" />';
						$html[] = '<a class="modal btn hasTooltip" title="'.JHtml::tooltipText('COM_CONTENT_CHANGE_ARTICLE').'"  href="'.$link.'&amp;'.JSession::getFormToken().'=1" rel="{handler: \'iframe\', size: {x: 800, y: 450}}"><i class="icon-file"></i> '.JText::_('JSELECT').'</a>';

						// Edit article button
						if ($allowEdit)
						{
							$html[] = '<a class="btn hasTooltip'.($value ? '' : ' hidden').'" href="index.php?option=com_content&layout=modal&tmpl=component&task=article.edit&id=' . $value. '" target="_blank" title="'.JHtml::tooltipText('COM_CONTENT_EDIT_ARTICLE').'" ><span class="icon-edit"></span> ' . JText::_('JACTION_EDIT') . '</a>';
						}

						// Clear article button
						if ($allowClear)
						{
							$html[] = '<button id="'.$idNew.'_clear" class="btn'.($value ? '' : ' hidden').'" onclick="return jClearArticle(\''.$idNew.'\')"><span class="icon-remove"></span> ' . JText::_('JCLEAR') . '</button>';
						}
						$html[] = '<button id="'.$idNew.'_remove" class="btn sp_article_remove" onclick="return jOssRemoveArticle(\''.$idNew.'\',this)"><span class="icon-minus"></span> Remove</button>';


						$html[] = '</span>';

						if ($iCol == intval($countListVal))
							$html[] = '<button id="'.$idNew.'_add" class="btn sp_article_add" onclick="return jOssAddArticle(\''.$idNew.'\',this)"><span class="icon-plus"></span> Add</button>';	
						else
							$html[] = '<button id="'.$idNew.'_add" class="hidden btn sp_article_add" onclick="return jOssAddArticle(\''.$idNew.'\',this)"><span class="icon-plus"></span> Add</button>';	
						

						// class='required' for client side validation
						$class = '';
						if ($this->required)
						{
							$class = ' class="required modal-value input_item_sp_article"';
						}
						else
						{
							$class = 'class="input_item_sp_article"';
						}

						$html[] = '<input type="hidden" id="'.$idNew.'_id"'.$class.' name="" value="'.$value.'" />';
						$html[] = '</div>';

						if ($iCol == 1) $htmlOr = $html;

						$iCol++;
					}
				}
			//}

			

			$output = implode("\n", $html);
			$outputOr = implode("\n", $htmlOr);

			$ouput1 = '<div id="jform_params_sp_article_orginal" style="display:none">';
			$ouput1 .= $outputOr;
			$ouput1 .= '<script>';
			$ouput1 .= 'function jSelectArticle_jform_params_sp_article_0(id, title, catid, object) {
							a = jQuery("#jform_params_sp_article_id_all").val();
							if (a.search(id) == -1)
							{
								document.getElementById("jform_params_sp_article_0_id").value = id;
								document.getElementById("jform_params_sp_article_id_all").value = loadValSpArticle();
								document.getElementById("jform_params_sp_article_0_name").value = title;
								jQuery("#jform_params_sp_article_0_clear").removeClass("hidden");
								SqueezeBox.close();
							}
							else
							{
								alert(\''.JText::_('MOD_JVLATEST_NEWS_FIELD_ARTICLE_MESSERROR').'\');
							}
						}';
			$ouput1 .= '</script>';
			$ouput1 .= '</div>';

			$inputHidden = '<input type="hidden" id="jform_params_sp_article_id_all" name="'.$this->name.'" value="'.implode(',',$listVal).'" />';

			return $output.str_replace("article_0", "momo_0", $ouput1).$inputHidden;
        }
}