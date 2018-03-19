<div class="xtab-pane">
    <div class="xpanel config" id="config-${index}" data-sindex="${index}">
        
        <div class="xpanel-heading">
            <h3 data-target="#zcontainer-${index}" data-toggle="collapse">Configuration</h3>
        </div>
        
        <div class="collapse in xpanel-body" id="zcontainer-${index}">
    	    <div class="xpanel-inner">
        	    <div  class="zcontainer">
            
                <div class="control-group">
                    <div class="control-label"><?php echo JText::_( 'Transitions: ' ); ?></div>
                    <div class="controls">
                        <select name="transition" id="" multiple="" 
                        class="span12" data-field="transition">
                            <optgroup label="RANDOM TRANSITIONS">
                                <option value="random-selected"
                                {{if transition}}
                                    {{if JV.inTransit('random-selected', transition)}}
                                        selected="selected" 
                                    {{/if}}
                                {{/if}}><?php echo JText::_( 'Random of Selected' ); ?></option>
                                <option value="random-static"
                                {{if transition}}
                                    {{if JV.inTransit('random-static', transition)}}
                                        selected="selected" 
                                    {{/if}}
                                {{/if}}><?php echo JText::_( 'Random Flat' ); ?></option>
                                <option value="random-premium"
                                {{if transition}}
                                    {{if JV.inTransit('random-premium', transition)}}
                                        selected="selected" 
                                    {{/if}}
                                {{/if}}><?php echo JText::_( 'Random Premium' ); ?></option>
                                <option value="random"
                                {{if transition}}
                                    {{if JV.inTransit('random', transition)}}
                                        selected="selected" 
                                    {{/if}}
                                {{/if}}><?php echo JText::_( 'Random Flat and Premium' ); ?></option>
                            </optgroup>
                            
                            <optgroup label="<?php echo JText::_( 'SLIDING TRANSITIONS' ); ?>">
                                <option value="slideup"
                                {{if transition}}
                                    {{if JV.inTransit('slideup', transition)}}
                                        selected="selected" 
                                    {{/if}}
                                {{/if}}><?php echo JText::_( 'Slide To Top' ); ?></option>
                                <option value="slidedown"
                                {{if transition}}
                                    {{if JV.inTransit('slidedown', transition)}}
                                        selected="selected" 
                                    {{/if}}
                                {{/if}}><?php echo JText::_( 'Slide To Bottom' ); ?></option>
                                <option value="slideright"
                                {{if transition}}
                                    {{if JV.inTransit('slideright', transition)}}
                                        selected="selected" 
                                    {{/if}}
                                {{/if}}><?php echo JText::_( 'Slide To Right' ); ?></option>
                                <option value="slideleft"
                                {{if transition}}
                                    {{if JV.inTransit('slideleft', transition)}}
                                        selected="selected" 
                                    {{/if}}
                                {{/if}}><?php echo JText::_( 'Slide To Left' ); ?></option>
                                <option value="slidehorizontal"
                                {{if transition}}
                                    {{if JV.inTransit('slidehorizontal', transition)}}
                                        selected="selected" 
                                    {{/if}}
                                {{/if}}><?php echo JText::_( 'Slide Horizontal (depending on Next/Previous)' ); ?></option>
                                <option value="slidevertical"
                                {{if transition}}
                                    {{if JV.inTransit('slidevertical', transition)}}
                                        selected="selected" 
                                    {{/if}}
                                {{/if}}><?php echo JText::_( 'Slide Vertical (depending on Next/Previous)' ); ?></option>
                                <option value="boxslide"
                                {{if transition}}
                                    {{if JV.inTransit('boxslide', transition)}}
                                        selected="selected" 
                                    {{/if}}
                                {{/if}}>Slide Boxes</option>
                                <option value="slotslide-horizontal"
                                {{if transition}}
                                    {{if JV.inTransit('slotslide-horizontal', transition)}}
                                        selected="selected" 
                                    {{/if}}
                                {{/if}}>Slide Slots Horizontal</option>
                                <option value="slotslide-vertical"
                                {{if transition}}
                                    {{if JV.inTransit('slotslide-vertical', transition)}}
                                        selected="selected" 
                                    {{/if}}
                                {{/if}}>Slide Slots Vertical</option>
                            </optgroup>

                            <optgroup label="FADE TRANSITIONS">
                                <option value="notransition"
                                {{if transition}}
                                    {{if JV.inTransit('notransition', transition)}}
                                        selected="selected" 
                                    {{/if}}
                                {{/if}}>No Transition</option>
                                <option value="fade"
                                {{if transition}}
                                    {{if JV.inTransit('fade', transition)}}
                                        selected="selected" 
                                    {{/if}}
                                {{/if}}>Fade</option>
                                <option value="boxfade"
                                {{if transition}}
                                    {{if JV.inTransit('boxfade', transition)}}
                                        selected="selected" 
                                    {{/if}}
                                {{/if}}>Fade Boxes</option>
                                <option value="slotfade-horizontal"
                                {{if transition}}
                                    {{if JV.inTransit('slotfade-horizontal', transition)}}
                                        selected="selected" 
                                    {{/if}}
                                {{/if}}>Fade Slots Horizontal</option>
                                <option value="slotfade-vertical"
                                {{if transition}}
                                    {{if JV.inTransit('slotfade-vertical', transition)}}
                                        selected="selected" 
                                    {{/if}}
                                {{/if}}>Fade Slots Vertical</option>
                                <option value="fadefromright"
                                {{if transition}}
                                    {{if JV.inTransit('fadefromright', transition)}}
                                        selected="selected" 
                                    {{/if}}
                                {{/if}}>Fade and Slide from Right</option>
                                <option value="fadefromleft"
                                {{if transition}}
                                    {{if JV.inTransit('fadefromleft', transition)}}
                                        selected="selected" 
                                    {{/if}}
                                {{/if}}>Fade and Slide from Left</option>
                                <option value="fadefromtop"
                                {{if transition}}
                                    {{if JV.inTransit('fadefromtop', transition)}}
                                        selected="selected" 
                                    {{/if}}
                                {{/if}}>Fade and Slide from Top</option>
                                <option value="fadefrombottom"
                                {{if transition}}
                                    {{if JV.inTransit('fadefrombottom', transition)}}
                                        selected="selected" 
                                    {{/if}}
                                {{/if}}>Fade and Slide from Bottom</option>
                                <option value="fadetoleftfadefromright"
                                {{if transition}}
                                    {{if JV.inTransit('fadetoleftfadefromright', transition)}}
                                        selected="selected" 
                                    {{/if}}
                                {{/if}}>Fade To Left and Fade From Right</option>
                                <option value="fadetorightfadefromleft"
                                {{if transition}}
                                    {{if JV.inTransit('fadetorightfadefromleft', transition)}}
                                        selected="selected" 
                                    {{/if}}
                                {{/if}}>Fade To Right and Fade From Left</option>
                                <option value="fadetotopfadefrombottom"
                                {{if transition}}
                                    {{if JV.inTransit('fadetotopfadefrombottom', transition)}}
                                        selected="selected" 
                                    {{/if}}
                                {{/if}}>Fade To Top and Fade From Bottom</option>
                                <option value="fadetobottomfadefromtop"
                                {{if transition}}
                                    {{if JV.inTransit('fadetobottomfadefromtop', transition)}}
                                        selected="selected" 
                                    {{/if}}
                                {{/if}}>Fade To Bottom and Fade From Top</option>
                            </optgroup>
                            
                            <optgroup label="PARALLAX TRANSITIONS">
                                <option value="parallaxtoright"
                                {{if transition}}
                                    {{if JV.inTransit('parallaxtoright', transition)}}
                                        selected="selected" 
                                    {{/if}}
                                {{/if}}>Parallax to Right</option>
                                <option value="parallaxtoleft"
                                {{if transition}}
                                    {{if JV.inTransit('parallaxtoleft', transition)}}
                                        selected="selected" 
                                    {{/if}}
                                {{/if}}>Parallax to Left</option>
                                <option value="parallaxtotop"
                                {{if transition}}
                                    {{if JV.inTransit('parallaxtotop', transition)}}
                                        selected="selected" 
                                    {{/if}}
                                {{/if}}>Parallax to Top</option>
                                <option value="parallaxtobottom"
                                {{if transition}}
                                    {{if JV.inTransit('parallaxtobottom', transition)}}
                                        selected="selected" 
                                    {{/if}}
                                {{/if}}>Parallax to Bottom</option>
                                <option value="parallaxhorizontal"
                                {{if transition}}
                                    {{if JV.inTransit('parallaxhorizontal', transition)}}
                                        selected="selected" 
                                    {{/if}}
                                {{/if}}>Parallax Horizontal</option>
                                <option value="parallaxvertical"
                                {{if transition}}
                                    {{if JV.inTransit('parallaxvertical', transition)}}
                                        selected="selected" 
                                    {{/if}}
                                {{/if}}>Parallax Vertical</option>
                            </optgroup>
                            
                            <optgroup label="ZOOM TRANSITIONS">
                                <option value="scaledownfromright"
                                {{if transition}}
                                    {{if JV.inTransit('scaledownfromright', transition)}}
                                        selected="selected" 
                                    {{/if}}
                                {{/if}}>Zoom Out and Fade From Right</option>
                                <option value="scaledownfromleft"
                                {{if transition}}
                                    {{if JV.inTransit('scaledownfromleft', transition)}}
                                        selected="selected" 
                                    {{/if}}
                                {{/if}}>Zoom Out and Fade From Left</option>
                                <option value="scaledownfromtop"
                                {{if transition}}
                                    {{if JV.inTransit('scaledownfromtop', transition)}}
                                        selected="selected" 
                                    {{/if}}
                                {{/if}}>Zoom Out and Fade From Top</option>
                                <option value="scaledownfrombottom"
                                {{if transition}}
                                    {{if JV.inTransit('scaledownfrombottom', transition)}}
                                        selected="selected" 
                                    {{/if}}
                                {{/if}}>Zoom Out and Fade From Bottom</option>
                                <option value="zoomout"
                                {{if transition}}
                                    {{if JV.inTransit('zoomout', transition)}}
                                        selected="selected" 
                                    {{/if}}
                                {{/if}}>ZoomOut</option>
                                <option value="zoomin"
                                {{if transition}}
                                    {{if JV.inTransit('zoomin', transition)}}
                                        selected="selected" 
                                    {{/if}}
                                {{/if}}>ZoomIn</option>
                                <option value="slotzoom-horizontal"
                                {{if transition}}
                                    {{if JV.inTransit('slotzoom-horizontal', transition)}}
                                        selected="selected" 
                                    {{/if}}
                                {{/if}}>Zoom Slots Horizontal</option>
                                <option value="slotzoom-vertical"
                                {{if transition}}
                                    {{if JV.inTransit('slotzoom-vertical', transition)}}
                                        selected="selected" 
                                    {{/if}}
                                {{/if}}>Zoom Slots Vertical</option>
                                <option value="notselectable6"
                                {{if transition}}
                                    {{if JV.inTransit('notselectable6', transition)}}
                                        selected="selected" 
                                    {{/if}}
                                {{/if}}>CURTAIN TRANSITIONS</option>
                                <option value="curtain-1"
                                {{if transition}}
                                    {{if JV.inTransit('curtain-1', transition)}}
                                        selected="selected" 
                                    {{/if}}
                                {{/if}}>Curtain from Left</option>
                                <option value="curtain-2"
                                {{if transition}}
                                    {{if JV.inTransit('curtain-2', transition)}}
                                        selected="selected" 
                                    {{/if}}
                                {{/if}}>Curtain from Right</option>
                                <option value="curtain-3"
                                {{if transition}}
                                    {{if JV.inTransit('curtain-3', transition)}}
                                        selected="selected" 
                                    {{/if}}
                                {{/if}}>Curtain from Middle</option>
                                    
                            </optgroup>
                            
                            <optgroup label="PREMIUM TRANSITIONS">
                                <option value="3dcurtain-horizontal"
                                {{if transition}}
                                    {{if JV.inTransit('3dcurtain-horizontal', transition)}}
                                        selected="selected" 
                                    {{/if}}
                                {{/if}}>3D Curtain Horizontal</option>
                                <option value="3dcurtain-vertical"
                                {{if transition}}
                                    {{if JV.inTransit('3dcurtain-vertical', transition)}}
                                        selected="selected" 
                                    {{/if}}
                                {{/if}}>3D Curtain Vertical</option>
                                <option value="cube"
                                {{if transition}}
                                    {{if JV.inTransit('cube', transition)}}
                                        selected="selected" 
                                    {{/if}}
                                {{/if}}>Cube Vertical</option>
                                <option value="cube-horizontal"
                                {{if transition}}
                                    {{if JV.inTransit('cube-horizontal', transition)}}
                                        selected="selected" 
                                    {{/if}}
                                {{/if}}>Cube Horizontal</option>
                                <option value="incube"
                                {{if transition}}
                                    {{if JV.inTransit('incube', transition)}}
                                        selected="selected" 
                                    {{/if}}
                                {{/if}}>In Cube Vertical</option>
                                <option value="incube-horizontal"
                                {{if transition}}
                                    {{if JV.inTransit('incube-horizontal', transition)}}
                                        selected="selected" 
                                    {{/if}}
                                {{/if}}>In Cube Horizontal</option>
                                <option value="turnoff"
                                {{if transition}}
                                    {{if JV.inTransit('turnoff', transition)}}
                                        selected="selected" 
                                    {{/if}}
                                {{/if}}>TurnOff Horizontal</option>
                                <option value="turnoff-vertical"
                                {{if transition}}
                                    {{if JV.inTransit('turnoff-vertical', transition)}}
                                        selected="selected" 
                                    {{/if}}
                                {{/if}}>TurnOff Vertical</option>
                                <option value="papercut",
                                {{if transition}}
                                    {{if JV.inTransit('papercut', transition)}}
                                        selected="selected" 
                                    {{/if}}
                                {{/if}}>Paper Cut</option>
                                <option value="flyin"
                                {{if transition}}
                                    {{if JV.inTransit('flyin', transition)}}
                                        selected="selected" 
                                    {{/if}}
                                {{/if}}>Fly In</option>
                            </optgroup>
                        </select>
                        <span class="help-block">The appearance transitions of this slide.</span>
                    </div>
                </div>

                <div class="control-group">
                    <div class="control-label">Slot Amount: </div>
                    <div class="controls">
                        <input type="number" min="0" 
                        name="slotamount" id="" class="span4"
                        value="${slotamount}" data-field="slotamount">
                        <span class="help-block">The number of slots or boxes the slide is divided into. If you use boxfade, over 7 slots can be juggy.</span>
                    </div>
                </div>

                <div class="control-group">
                    <div class="control-label">Rotation: </div>
                    <div class="controls">
                        <input type="number" min="-720" max="720" 
                        name="rotate" id="" class="span4"
                        value="${rotate}" data-field="rotate">
                        <span class="help-block">Rotation (-720 -> 720, 999 = random) Only for Simple Transitions.</span>
                    </div>
                </div>

                <div class="control-group">
                    <div class="control-label">Save Performance:</div>
                    <div class="controls">
                        <select name="saveperformance" id="" class="span12"
                        data-field="saveperformance">
                            <option value="off"
                            {{if saveperformance}}
                                {{if saveperformance == 'off'}}selected="selected"{{/if}}
                            {{/if}}>False</option>
                            <option value="on"
                            {{if saveperformance}}
                                {{if saveperformance == 'on'}}selected="selected"{{/if}}
                            {{/if}}>True</option>
                        </select>
                    </div>
                </div>

                <div class="control-group">
                    <div class="control-label">Transition Duration: </div>
                    <div class="controls">
                        <input type="number" name="masterspeed" 
                        min"100" value="300" max="2000" id="" class="span4"
                        value="${masterspeed}" data-field="masterspeed">
                        <span class="help-block">The duration of the transition (Default:300, min: 100 max 2000). </span>
                    </div>
                </div>

                <div class="control-group">
                    <div class="control-label">Delay: </div>
                    <div class="controls">
                        <input type="number" min="0" name="delay" 
                        id="" class="span4"
                        value="${delay}" data-field="delay">
                        <span class="help-block">A new delay value for the Slide. If no delay defined per slide, the delay defined via Options (9000ms) will be used</span>
                    </div>
                </div>

            </div>
	        </div>
        </div>
                        
    </div><!-- div.config -->
</div>