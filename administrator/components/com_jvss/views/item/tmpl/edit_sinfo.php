        
<div class="xpanel">
    <div class="xpanel-heading">
        <div class="pull-right">                                                                  
            <button
            type="button"
            class="btn btn-success aspin"
            data-action="clone"
            data-builder='[data-action="new-slide"]'
            data-region='#slide-${index}'
            data-msg="<?php echo JText::_( 'Are you want to continue ?' ); ?>">
                <span class="icon-save-copy" ></span> Duplicate this slide
            </button> &nbsp;
            <button
            type="button"
            data-sindex="${index}"
            data-action="remove-slide"
            data-target-title='[data-tag="tab-name"][data-sindex="${index}"]'
            data-target='#slide-${index}'
            class="btn btn-inverse aspin"
            data-msg="<?php echo JText::_( 'Are you want to continue ?' ); ?>">
                <span class="icon-remove "></span>Remove
            </button>
        </div>    
        <h3 data-target="#sinfo-xpane-${index}">General Slide Settings</h3>
    </div>

    <div id="sinfo-xpane-${index}" class="xpanel-body">
        <div class="xpanel-inner">  
    	    <div class="row-fluid">
            <div class="span3">
                <div class="control-group iname">
                    <div class="control-label">Slide Title:</div>
                    <div class="xcontrols">
                        <input type="text" name="title" value="${title}" 
                        data-view="#title-${index}" data-field="title"
                        class="span10">
                    </div>
                </div><!-- div.iname -->
            </div>

            <div class="span3">
                <div class="control-group istate">
                    <div class="control-label">State:</div>
                    <div class="xcontrols">
                        <select name="state" data-field="state">
                            <option value="1"
                            {{if state}}
                                {{if state == 1}} selected="selected"{{/if}}
                            {{/if}}
                            >True</option>
                            <option value="0"
                            {{if state}}
                                 {{if state == 0}} selected="selected"{{/if}}
                            {{/if}}>False</option>
                        </select>
                    </div>
                </div><!-- div.istate -->
            </div>
            
            <div class="span2">
                <div class="control-group">
                    <div class="control-label">Solid Colored:</div>
                    <div class="xcontrols"><input type="text" name="bgcolor" 
                    class="minicolors span12" data-change-editor="#layer-${index}"
                    value="${bgcolor}"
                    data-kcss="background-color"
                    data-field="bgcolor"></div>
                </div><!-- Solid Colored: -->
            </div>

            <div class="span4">
                <div class="control-group">
                    <div class="control-label">Background Source:</div>
                        <div class="xcontrols">
                            <div class="input-append">
                                <input id="layer_${index}_bgsrc" 
                                type="text" class=""
                                data-change-editor="#layer-${index}"  
                                name="bgsrc" 
                                value="${bgsrc}"
                                data-kcss="background-image"
                                data-field="bgsrc">
                                <a
                                class="btn"
                                href="<?php echo JUri::root(); ?>administrator/components/com_jvss/assets/editors/tinymce/plugins/filemanager/dialog.php?type=1&editor=imageok&lang=undefined&subfolder=&base_url=<?php echo rtrim( JUri::root(), '/' ); ?>&field_id=layer_${index}_bgsrc"
                                data-target="#imageok"
                                data-tag="browse-img">Browse</a>
                            </div>
                        </div>
                    </div><!-- Background Source: -->
                </div>
            
            </div>
	    </div>
    </div>
</div>