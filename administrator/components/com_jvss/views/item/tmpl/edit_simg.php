<div class="xpanel">
    <div class="xpanel-heading clearfix">
        <h3 data-toggle="xcollapse" data-target="#simg-zcontainer-${index}">Image / Background</h3>
    </div>
    <div class="xcollapse in xpanel-body" id="simg-zcontainer-${index}">
    	<div class="xpanel-inner">    
        	<div  class="zcontainer row-fluid">
            <div class="span4">
                <div class="control-group">
                    <div class="control-label">Ken Burns / Pan Zoom:</div>
                    <div class="controls">
                        <fieldset class="radio btn-group btn-group-yesno" data-toggle="buttons-radio">

                            <input
                            type="radio"
                            name="kenburns"
                            id="layer${index}_kenburns1"
                            value="off"
                            {{if kenburns}}
                                 {{if kenburns == 'off'}} checked="checked"{{/if}}
                            {{/if}}
                            data-field="kenburns"
                            >
                            <label
                            for="layer${index}_kenburns1"
                            class="btn" 
                            data-toggle="tab"
                            data-target="#layer${index}_kenburns0_tab">Off</label>

                            <input
                            type="radio"
                            name="kenburns"
                            id="layer${index}_kenburns0"
                            value="on"
                            {{if kenburns }}
                                 {{if kenburns == 'on'}} checked="checked"{{/if}}
                            {{/if}}
                            data-field="kenburns"
                            >
                            <label
                            for="layer${index}_kenburns0"
                            class="btn"
                            data-toggle="tab"
                            data-target="#layer${index}_kenburns1_tab">On</label>
                        </fieldset>
                    </div>
                    
                </div><!-- Ken Burns / Pan Zoom: -->

                <div class="tab-content">
                    <div class="tab-pane{{if kenburns }} {{if kenburns == 'off'}} active{{/if}} {{/if}}" id="layer${index}_kenburns0_tab">
                        <div class="control-group">
                            <div class="control-label">Background Fit:</div>
                            <div class="controls">
                                <div class="control-group">
                                    <select name="bgfit" id="" 
                                    class="chzn-custom-value" data-custom_group_text="Custom Position" 
                                    data-no_results_text="Add custom position" 
                                    data-placeholder="Type or Select a Position"
                                    data-change-editor="#layer-${index}" data-kcss="background-size"
                                    data-field="bgfit">
                                        <option value="cover"
                                        {{if bgfit}}
                                            {{if bgfit == 'cover'}}selected="selected" {{/if}}
                                        {{/if}}
                                        >cover</option>
                                        <option value="contain"
                                        {{if bgfit}}
                                             {{if bgfit == 'contain'}}selected="selected" {{/if}}
                                        {{/if}}>contain</option>
                                        <option value="normal"
                                        {{if bgfit}}
                                            {{if bgfit == 'normal'}}selected="selected" {{/if}}
                                        {{/if}}>normal</option>
                                    </select>
                                </div>

                            </div>

                        </div><!-- Background Fit: -->

                        <div class="control-group">
                            <div class="control-label">Background Repeat:</div>
                            <div class="controls">
                                <select name="bgrepeat" id=""
                                data-change-editor="#layer-${index}" data-kcss="background-repeat"
                                data-field="bgrepeat">
                                    <option value="no-repeat"
                                    {{if bgrepeat}}
                                        {{if bgrepeat == 'no-repeat'}} selected=""{{/if}}
                                    {{/if}}>no-repeat</option>
                                    <option value="repeat"
                                    {{if bgrepeat}}
                                        {{if bgrepeat == 'repeat'}} selected=""{{/if}}
                                    {{/if}}>repeat</option>
                                    <option value="repeat-x"
                                    {{if bgrepeat}}
                                        {{if bgrepeat == 'repeat-x'}} selected=""{{/if}}
                                    {{/if}}>repeat-x</option>
                                    <option value="repeat-y"
                                    {{if bgrepeat}}
                                        {{if bgrepeat == 'repeat-y'}} selected=""{{/if}}
                                    {{/if}}>repeat-y</option>
                                </select>
                            </div>
                        </div><!-- Background Repeat: -->

                        <div class="control-group">
                            <div class="control-label">Background Position:</div>
                            <div class="controls">
                                
                                <select name="bgposition" id="" 
                                class="chzn-custom-value" data-custom_group_text="Custom Position" 
                                data-no_results_text="Add custom position" data-placeholder="Type or Select a Position"
                                data-change-editor="#layer-${index}" data-kcss="background-position"
                                data-field="bgposition">
                                    <option value="center top"
                                    {{if bgposition}}
                                        {{if bgposition == 'center top'}} selected="selected"{{/if}}
                                    {{/if}}>center top</option>
                                    <option value="center right"
                                    {{if bgposition}}
                                        {{if bgposition == 'center right'}} selected="selected"{{/if}}
                                    {{/if}}>center right</option>
                                    <option value="center bottom"
                                    {{if bgposition}}
                                        {{if bgposition == 'center bottom'}} selected="selected"{{/if}}
                                    {{/if}}>center bottom</option>
                                    <option value="center center"
                                    {{if bgposition}}
                                        {{if bgposition == 'center center'}} selected="selected"{{/if}}
                                    {{/if}}>center center</option>
                                    <option value="left top"
                                    {{if bgposition}}
                                        {{if bgposition == 'left top'}} selected="selected"{{/if}}
                                    {{/if}}>left top</option>
                                    <option value="left center"
                                    {{if bgposition}}
                                        {{if bgposition == 'left center'}} selected="selected"{{/if}}
                                    {{/if}}>left center</option>
                                    <option value="left bottom"
                                    {{if bgposition}}
                                        {{if bgposition == 'left bottom'}} selected="selected"{{/if}}
                                    {{/if}}>left bottom</option>
                                    <option value="right top"
                                    {{if bgposition}}
                                        {{if bgposition == 'right top'}} selected="selected"{{/if}}
                                    {{/if}}>right top</option>
                                    <option value="right center"
                                    {{if bgposition}}
                                        {{if bgposition == 'right center'}} selected="selected"{{/if}}
                                    {{/if}}>right center</option>
                                    <option value="right bottom"
                                    {{if bgposition}}
                                        {{if bgposition == 'right bottom'}} selected="selected"{{/if}}
                                    {{/if}}>right bottom</option>
                                </select>

                            </div>
                        </div><!-- Background Position: -->    
                    </div>

                    <div class="tab-pane{{if kenburns }} {{if kenburns == 'on'}} active{{/if}} {{/if}}" id="layer${index}_kenburns1_tab">
                        <div class="control-group">
                            <div class="control-label">Start Position:</div>
                            <div class="controls">
                                
                                <select name="bgpositionstart" id="" class="chzn-custom-value" 
                                data-custom_group_text="Custom Position" 
                                data-no_results_text="Add custom position" 
                                data-placeholder="Type or Select a Position"
                                data-field="bgpositionstart">
                                    <option value="center top"
                                    {{if bgpositionstart}}
                                        {{if bgpositionstart == 'center top'}} selected="selected"{{/if}}
                                    {{/if}}>center top</option>
                                    <option value="center right"
                                    {{if bgpositionstart}}
                                        {{if bgpositionstart == 'center right'}} selected="selected"{{/if}}
                                    {{/if}}>center right</option>
                                    <option value="center bottom"
                                    {{if bgpositionstart}}
                                        {{if bgpositionstart == 'center bottom'}} selected="selected"{{/if}}
                                    {{/if}}>center bottom</option>
                                    <option value="center center"
                                    {{if bgpositionstart}}
                                        {{if bgpositionstart == 'center center'}} selected="selected"{{/if}}
                                    {{/if}}>center center</option>
                                    <option value="left top"
                                    {{if bgpositionstart}}
                                        {{if bgpositionstart == 'left top'}} selected="selected"{{/if}}
                                    {{/if}}>left top</option>
                                    <option value="left center"
                                    {{if bgpositionstart}}
                                        {{if bgpositionstart == 'left center'}} selected="selected"{{/if}}
                                    {{/if}}>left center</option>
                                    <option value="left bottom"
                                    {{if bgpositionstart}}
                                        {{if bgpositionstart == 'left bottom'}} selected="selected"{{/if}}
                                    {{/if}}>left bottom</option>
                                    <option value="right top"
                                    {{if bgpositionstart}}
                                        {{if bgpositionstart == 'right top'}} selected="selected"{{/if}}
                                    {{/if}}>right top</option>
                                    <option value="right center"
                                    {{if bgpositionstart}}
                                        {{if bgpositionstart == 'right center'}} selected="selected"{{/if}}
                                    {{/if}}>right center</option>
                                    <option value="right bottom"
                                    {{if bgpositionstart}}
                                        {{if bgpositionstart == 'right bottom'}} selected="selected"{{/if}}
                                    {{/if}}>right bottom</option>
                                </select>

                            </div>
                        </div><!-- Start Position: -->    

                        <div class="control-group">
                            <div class="control-label">End Position:</div>
                            <div class="controls">
                                
                                <select name="bgpositionend" id="" 
                                class="chzn-custom-value" data-custom_group_text="Custom Position" 
                                data-no_results_text="Add custom position" 
                                data-placeholder="Type or Select a Position"
                                data-field="bgpositionend">
                                    <option value="center top"
                                    {{if bgpositionend}}
                                        {{if bgpositionend == 'center top'}} selected="selected"{{/if}}
                                    {{/if}}>center top</option>
                                    <option value="center right"
                                    {{if bgpositionend}}
                                        {{if bgpositionend == 'center right'}} selected="selected"{{/if}}
                                    {{/if}}>center right</option>
                                    <option value="center bottom"
                                    {{if bgpositionend}}
                                        {{if bgpositionend == 'center bottom'}} selected="selected"{{/if}}
                                    {{/if}}>center bottom</option>
                                    <option value="center center"
                                    {{if bgpositionend}}
                                        {{if bgpositionend == 'center center'}} selected="selected"{{/if}}
                                    {{/if}}>center center</option>
                                    <option value="left top"
                                    {{if bgpositionend}}
                                        {{if bgpositionend == 'left top'}} selected="selected"{{/if}}
                                    {{/if}}>left top</option>
                                    <option value="left center"
                                    {{if bgpositionend}}
                                        {{if bgpositionend == 'left center'}} selected="selected"{{/if}}
                                    {{/if}}>left center</option>
                                    <option value="left bottom"
                                    {{if bgpositionend}}
                                        {{if bgpositionend == 'left bottom'}} selected="selected"{{/if}}
                                    {{/if}}>left bottom</option>
                                    <option value="right top"
                                    {{if bgpositionend}}
                                        {{if bgpositionend == 'right top'}} selected="selected"{{/if}}
                                    {{/if}}>right top</option>
                                    <option value="right center"
                                    {{if bgpositionend}}
                                        {{if bgpositionend == 'right center'}} selected="selected"{{/if}}
                                    {{/if}}>right center</option>
                                    <option value="right bottom"
                                    {{if bgpositionend}}
                                        {{if bgpositionend == 'right bottom'}} selected="selected"{{/if}}
                                    {{/if}}>right bottom</option>
                                </select>

                            </div>
                        </div><!-- End Position: -->    

                        <div class="control-group">
                            <div class="control-label">Start Fit: (in %)</div>
                            <div class="controls">
                                <input class="input-block-level" 
                                name="bgfitstart" 
                                type="number" min="0"
                                value="${bgfitstart}"
                                data-field="bgfitstart">
                            </div>
                        </div><!-- Start Fit: (in %) -->

                        <div class="control-group">
                            <div class="control-label">End Fit: (in %)</div>
                            <div class="controls">
                                <input class="input-block-level" 
                                name="bgfitend" 
                                type="number" min="0"
                                value="${bgfitend}"
                                data-field="bgfitend">
                            </div>
                        </div><!-- Start Fit: (in %) -->

                        <div class="control-group">
                            <div class="control-label">Easing:</div>
                            <div class="controls">
                                
                                <select name="ease" id=""
                                data-field="ease">
                                    <option value="Linear.easeNone"
                                    {{if ease}}
                                        {{if ease == 'Linear.easeNone'}} selected="selected"{{/if}}
                                    {{/if}}
                                    >Linear.easeNone</option>
                                    <option value="Power0.easeIn"
                                    {{if ease}}
                                        {{if ease == 'Power0.easeIn'}} selected="selected"{{/if}}
                                    {{/if}}>Power0.easeIn  (linear)</option>
                                    <option value="Power0.easeInOut"
                                    {{if ease}}
                                        {{if ease == 'Power0.easeInOut'}} selected="selected"{{/if}}
                                    {{/if}}>Power0.easeInOut  (linear)</option>
                                    <option value="Power0.easeOut"
                                    {{if ease}}
                                        {{if ease == 'Power0.easeOut'}} selected="selected"{{/if}}
                                    {{/if}}>Power0.easeOut  (linear)</option>
                                    <option value="Power1.easeIn"
                                    {{if ease}}
                                        {{if ease == 'Power1.easeIn'}} selected="selected"{{/if}}
                                    {{/if}}>Power1.easeIn</option>
                                    <option value="Power1.easeInOut"
                                    {{if ease}}
                                        {{if ease == 'Power1.easeInOut'}} selected="selected"{{/if}}
                                    {{/if}}>Power1.easeInOut</option>
                                    <option value="Power1.easeOut"
                                    {{if ease}}
                                        {{if ease == 'Power1.easeOut'}} selected="selected"{{/if}}
                                    {{/if}}>Power1.easeOut</option>
                                    <option value="Power2.easeIn"
                                    {{if ease}}
                                        {{if ease == 'Power2.easeIn'}} selected="selected"{{/if}}
                                    {{/if}}>Power2.easeIn</option>
                                    <option value="Power2.easeInOut"
                                    {{if ease}}
                                        {{if ease == 'Power2.easeInOut'}} selected="selected"{{/if}}
                                    {{/if}}>Power2.easeInOut</option>
                                    <option value="Power2.easeOut"
                                    {{if ease}}
                                        {{if ease == 'Power2.easeOut'}} selected="selected"{{/if}}
                                    {{/if}}>Power2.easeOut</option>
                                    <option value="Power3.easeIn"
                                    {{if ease}}
                                        {{if ease == 'Power3.easeIn'}} selected="selected"{{/if}}
                                    {{/if}}>Power3.easeIn</option>
                                    <option value="Power3.easeInOut"
                                    {{if ease}}
                                        {{if ease == 'Power3.easeInOut'}} selected="selected"{{/if}}
                                    {{/if}}>Power3.easeInOut</option>
                                    <option value="Power3.easeOut"
                                    {{if ease}}
                                        {{if ease == 'Power3.easeOut'}} selected="selected"{{/if}}
                                    {{/if}}>Power3.easeOut</option>
                                    <option value="Power4.easeIn"
                                    {{if ease}}
                                        {{if ease == 'Power4.easeIn'}} selected="selected"{{/if}}
                                    {{/if}}>Power4.easeIn</option>
                                    <option value="Power4.easeInOut"
                                    {{if ease}}
                                        {{if ease == 'Power4.easeInOut'}} selected="selected"{{/if}}
                                    {{/if}}>Power4.easeInOut</option>
                                    <option value="Power4.easeOut"
                                    {{if ease}}
                                        {{if ease == 'Power4.easeOut'}} selected="selected"{{/if}}
                                    {{/if}}>Power4.easeOut</option>
                                    <option value="Back.easeIn"
                                    {{if ease}}
                                        {{if ease == 'Back.easeIn'}} selected="selected"{{/if}}
                                    {{/if}}>Back.easeIn</option>
                                    <option value="Back.easeInOut"
                                    {{if ease}}
                                        {{if ease == 'Back.easeInOut'}} selected="selected"{{/if}}
                                    {{/if}}>Back.easeInOut</option>
                                    <option value="Back.easeOut"
                                    {{if ease}}
                                        {{if ease == 'Back.easeOut'}} selected="selected"{{/if}}
                                    {{/if}}>Back.easeOut</option>
                                    <option value="Bounce.easeIn"
                                    {{if ease}}
                                        {{if ease == 'Bounce.easeIn'}} selected="selected"{{/if}}
                                    {{/if}}>Bounce.easeIn</option>
                                    <option value="Bounce.easeInOut"
                                    {{if ease}}
                                        {{if ease == 'Bounce.easeInOut'}} selected="selected"{{/if}}
                                    {{/if}}>Bounce.easeInOut</option>
                                    <option value="Bounce.easeOut"
                                    {{if ease}}
                                        {{if ease == 'Bounce.easeOut'}} selected="selected"{{/if}}
                                    {{/if}}>Bounce.easeOut</option>
                                    <option value="Circ.easeIn"
                                    {{if ease}}
                                        {{if ease == 'Circ.easeIn'}} selected="selected"{{/if}}
                                    {{/if}}>Circ.easeIn</option>
                                    <option value="Circ.easeInOut"
                                    {{if ease}}
                                        {{if ease == 'Circ.easeInOut'}} selected="selected"{{/if}}
                                    {{/if}}>Circ.easeInOut</option>
                                    <option value="Circ.easeOut"
                                    {{if ease}}
                                        {{if ease == 'Circ.easeOut'}} selected="selected"{{/if}}
                                    {{/if}}>Circ.easeOut</option>
                                    <option value="Elastic.easeIn"
                                    {{if ease}}
                                        {{if ease == 'Elastic.easeIn'}} selected="selected"{{/if}}
                                    {{/if}}>Elastic.easeIn</option>
                                    <option value="Elastic.easeInOut"
                                    {{if ease}}
                                        {{if ease == 'Elastic.easeInOut'}} selected="selected"{{/if}}
                                    {{/if}}>Elastic.easeInOut</option>
                                    <option value="Elastic.easeOut"
                                    {{if ease}}
                                        {{if ease == 'Elastic.easeOut'}} selected="selected"{{/if}}
                                    {{/if}}>Elastic.easeOut</option>
                                    <option value="Expo.easeIn"
                                    {{if ease}}
                                        {{if ease == 'Expo.easeIn'}} selected="selected"{{/if}}
                                    {{/if}}>Expo.easeIn</option>
                                    <option value="Expo.easeInOut"
                                    {{if ease}}
                                        {{if ease == 'Expo.easeInOut'}} selected="selected"{{/if}}
                                    {{/if}}>Expo.easeInOut</option>
                                    <option value="Expo.easeOut"
                                    {{if ease}}
                                        {{if ease == 'Expo.easeOut'}} selected="selected"{{/if}}
                                    {{/if}}>Expo.easeOut</option>
                                    <option value="Sine.easeIn"
                                    {{if ease}}
                                        {{if ease == 'Sine.easeIn'}} selected="selected"{{/if}}
                                    {{/if}}>Sine.easeIn</option>
                                    <option value="Sine.easeInOut"
                                    {{if ease}}
                                        {{if ease == 'Sine.easeInOut'}} selected="selected"{{/if}}
                                    {{/if}}>Sine.easeInOut</option>
                                    <option value="Sine.easeOut"
                                    {{if ease}}
                                        {{if ease == 'Sine.easeOut'}} selected="selected"{{/if}}
                                    {{/if}}>Sine.easeOut</option>
                                    <option value="SlowMo.ease"
                                    {{if ease}}
                                        {{if ease == 'SlowMo.ease'}} selected="selected"{{/if}}
                                    {{/if}}>SlowMo.ease</option>
                                </select>

                            </div>
                        </div><!-- End Easing: -->

                        <div class="control-group">
                            <div class="control-label">Duration (in ms):</div>
                            <div class="controls">
                                <input class="input-block-level" 
                                name="duration" 
                                type="number" min="0"
                                value="${duration}"
                                data-field="duration">
                            </div>
                        </div><!-- Duration (in ms): -->

                    </div><!-- layer0_kenburns1_tab -->


                </div>    
            </div>

            <div class="span8">
                
                <div class="control-group">
                    <div class="control-label">Class: </div>
                    <div class="controls">
                        <input type="text" 
                        name="zclass" id="" class="span12"
                        value="${zclass}" data-field="zclass">
                        <span class="help-block">Adds a unique class to the li of the Slide like class="rev_special_class" (add only the classnames, seperated by space)</span>
                    </div>
                </div>

                <div class="control-group">
                    <div class="control-label">ID: </div>
                    <div class="controls">
                        <input type="text" 
                        name="id" id="" class="span12"
                        value="${id}" data-field="id">
                        <span class="help-block">     Adds a unique ID to the li of the Slide like id="rev_special_id" (add only the id)</span>
                    </div>
                </div>

                <div class="control-group">
                    <div class="control-label">Attribute: </div>
                    <div class="controls">
                        <input type="text" 
                        name="attr" id="" class="span12"
                        value="${attr}" data-field="attr">
                        <span class="help-block">Add as many attributes as you wish here. (i.e.: data-layer="firstlayer" data-custom="somevalue")</span>
                    </div>
                </div>
            

            </div>

        </div>
    	</div>
    </div>
</div>
