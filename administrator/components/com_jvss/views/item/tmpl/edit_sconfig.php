<div id="inline-config" class="modal hide fade">
    
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h3><?php echo JText::_( 'Slider Setting' ); ?></h3>
            </div>
            <div class="modal-body">
                
                <textarea data-tmpl="inline-settings" class="hidden">
                    <div class="tabs-left clearfix">
                        <ul class="nav nav-tabs">
                            <li class="active"><a href="#sconfig-main" data-toggle="tab"><?php echo JText::_( 'Main Slider Settings' ); ?></a></li>
                            <li class=""><a href="#sconfig-general" data-toggle="tab"><?php echo JText::_( 'General Settings' ); ?></a></li>

                            <li><a href="#sconfig-loop" data-toggle="tab"><?php echo JText::_( 'Loop and Progress' ); ?></a></li>

                            <li><a href="#sconfig-appeance" data-toggle="tab"><?php echo JText::_( 'Appearance' ); ?></a></li>
                            <li><a href="#sconfig-nav" data-toggle="tab"><?php echo JText::_( 'Navigation' ); ?></a></li>

                            <li><a href="#sconfig-thumb" data-toggle="tab"><?php echo JText::_( 'Thumbnails' ); ?></a></li>
                            <li><a href="#sconfig-spinner" data-toggle="tab"><?php echo JText::_( 'Spinner' ); ?></a></li>

                            <li><a href="#sconfig-parallax" data-toggle="tab"><?php echo JText::_( 'Parallax' ); ?></a></li>
                            <li><a href="#sconfig-mobile-touch" data-toggle="tab"><?php echo JText::_( 'Mobile Touch' ); ?></a></li>

                            <li><a href="#sconfig-mobile-visibility" data-toggle="tab"><?php echo JText::_( 'Mobile Visibility' ); ?></a></li>
                            <li><a href="#sconfig-alternative-frist-side" data-toggle="tab"><?php echo JText::_( 'Alternative First Slide' ); ?></a></li>
                        </ul>
                        <div class="tab-content">
                            
                            <div class="tab-pane active" id="sconfig-main">
                                <div class="control-group">
                                    <label class="control-label">Slider Layout:</label>
                                    <div class="controls">
                                      <fieldset class="radio btn-group">
                                          
                                          <input type="radio" name="slider_type" id="sconfig_layout1" value="fixed"
                                          {{if slider_type == 'fixed'}}  checked="checked"{{/if}}>
                                          <label for="sconfig_layout1" class="btn"
                                          data-toggle="tab" data-target="#sconfig_layout1_tab">Fixed</label>

                                          <input type="radio" name="slider_type" id="sconfig_layout2" value="responsitive"
                                          {{if slider_type == 'responsitive'}}  checked="checked"{{/if}}>
                                          <label for="sconfig_layout2" class="btn"
                                          data-toggle="tab" data-target="#sconfig_layout2_tab">Custom</label>

                                          <input type="radio" name="slider_type" id="sconfig_layout3" value="fullwidth"
                                          {{if slider_type == 'fullwidth'}}  checked="checked"{{/if}}>
                                          <label for="sconfig_layout3" class="btn" 
                                          data-toggle="tab" data-target="#sconfig_layout3_tab">Responsive</label>

                                          <input type="radio" name="slider_type" id="sconfig_layout4" value="fullscreen"
                                          {{if slider_type == 'fullscreen'}}  checked="checked"{{/if}}>
                                          <label for="sconfig_layout4" class="btn"
                                          data-toggle="tab" data-target="#sconfig_layout4_tab">Fullscreen</label>

                                      </fieldset>
                                    </div>
                                </div><!-- Slider Layout: -->

                                
                                <div class="tab-content-inner">
                                    
                                    <div class="tab-pane{{if slider_type == 'fixed'}}  active{{/if}}" id="sconfig_layout1_tab">
                                        
                                    </div><!-- Fixed -->
                                    
                                    <div class="tab-pane{{if slider_type == 'responsitive'}}  active{{/if}}" id="sconfig_layout2_tab">
                                        
                                        <div class="clearfix">
                                            <div class="span6">
                                                <div class="control-group">
                                                    <label class="control-label">Screen Width1:</label>
                                                    <div class="controls">
                                                        <input type="text" name="responsitive_w1"
                                                        value="${responsitive_w1}" class="span5">
                                                        <div class="help-inline">px</div>
                                                    </div>
                                                </div><!-- Screen Width1: -->
                                            </div>
                                        
                                            <div class="span6">
                                                

                                                <div class="control-group">
                                                    <label class="control-label">Slider Width1:</label>
                                                    <div class="controls">
                                                        <input type="text" name="responsitive_sw1"
                                                        value="${responsitive_sw1}" class="span5">
                                                        <div class="help-inline">px</div>
                                                    </div>
                                                </div><!-- Slider Width1: -->        

                                            </div>
                                            
                                        </div>

                                        <div class="clearfix">
                                            <div class="span6">
                                                <div class="control-group">
                                                    <label class="control-label">Screen Width2:</label>
                                                    <div class="controls">
                                                        <input type="text" name="responsitive_w2"
                                                        value="${responsitive_w2}" class="span5">
                                                        <div class="help-inline">px</div>
                                                    </div>
                                                </div><!-- Screen Width2: -->
                                            </div>
                                        
                                            <div class="span6">
                                                

                                                <div class="control-group">
                                                    <label class="control-label">Slider Width2:</label>
                                                    <div class="controls">
                                                        <input type="text" name="responsitive_sw2"
                                                        value="${responsitive_sw2}" class="span5">
                                                        <div class="help-inline">px</div>
                                                    </div>
                                                </div><!-- Slider Width2: -->        

                                            </div>
                                            
                                        </div>

                                        <div class="clearfix">
                                            <div class="span6">
                                                <div class="control-group">
                                                    <label class="control-label">Screen Width3:</label>
                                                    <div class="controls">
                                                        <input type="text" name="responsitive_w3"
                                                        value="${responsitive_w3}" class="span5">
                                                        <div class="help-inline">px</div>
                                                    </div>
                                                </div><!-- Screen Width3: -->
                                            </div>
                                        
                                            <div class="span6">
                                                

                                                <div class="control-group">
                                                    <label class="control-label">Slider Width3:</label>
                                                    <div class="controls">
                                                        <input type="text" name="responsitive_sw3"
                                                        value="${responsitive_sw3}" class="span5">
                                                        <div class="help-inline">px</div>
                                                    </div>
                                                </div><!-- Slider Width3: -->        

                                            </div>
                                            
                                        </div>

                                        <div class="clearfix">
                                            <div class="span6">
                                                <div class="control-group">
                                                    <label class="control-label">Screen Width4:</label>
                                                    <div class="controls">
                                                        <input type="text" name="responsitive_w4"
                                                        value="${responsitive_w4}" class="span5">
                                                        <div class="help-inline">px</div>
                                                    </div>
                                                </div><!-- Screen Width4: -->
                                            </div>
                                        
                                            <div class="span6">
                                                

                                                <div class="control-group">
                                                    <label class="control-label">Slider Width4:</label>
                                                    <div class="controls">
                                                        <input type="text" name="responsitive_sw4"
                                                        value="${responsitive_sw4}" class="span5">
                                                        <div class="help-inline">px</div>
                                                    </div>
                                                </div><!-- Slider Width4: -->        

                                            </div>
                                            
                                        </div>

                                        <div class="clearfix">
                                            <div class="span6">
                                                <div class="control-group">
                                                    <label class="control-label">Screen Width5:</label>
                                                    <div class="controls">
                                                        <input type="text" name="responsitive_w5"
                                                        value="${responsitive_w5}" class="span5">
                                                        <div class="help-inline">px</div>
                                                    </div>
                                                </div><!-- Screen Width5: -->
                                            </div>
                                        
                                            <div class="span6">
                                                

                                                <div class="control-group">
                                                    <label class="control-label">Slider Width5:</label>
                                                    <div class="controls">
                                                        <input type="text" name="responsitive_sw5"
                                                        value="${responsitive_sw5}" class="span5">
                                                        <div class="help-inline">px</div>
                                                    </div>
                                                </div><!-- Slider Width5: -->        

                                            </div>
                                            
                                        </div>
                                        <div class="clearfix">
                                            <div class="span6">
                                                <div class="control-group">
                                                    <label class="control-label">Screen Width6:</label>
                                                    <div class="controls">
                                                        <input type="text" name="responsitive_w6"
                                                        value="${responsitive_w6}" class="span5">
                                                        <div class="help-inline">px</div>
                                                    </div>
                                                </div><!-- Screen Width6: -->
                                            </div>
                                        
                                            <div class="span6">
                                                

                                                <div class="control-group">
                                                    <label class="control-label">Slider Width6:</label>
                                                    <div class="controls">
                                                        <input type="text" name="responsitive_sw6"
                                                        value="${responsitive_sw6}" class="span5">
                                                        <div class="help-inline">px</div>
                                                    </div>
                                                </div><!-- Slider Width6: -->        

                                            </div>
                                            
                                        </div>

                                        

                                    </div><!-- Custom -->
                                    
                                    <div class="tab-pane{{if slider_type == 'fullwidth'}}  active{{/if}}" id="sconfig_layout3_tab">
                                        
                                        <div class="control-group">
                                            <label class="control-label">Unlimited Height:</label>
                                            <div class="controls">
                                                <select name="auto_height" id="">
                                                    <option value="off"{{if auto_height == 'off'}} selected="selected"{{/if}}>False</option>
                                                    <option value="on"{{if auto_height == 'on'}} selected="selected"{{/if}}>True</option>
                                                </select>
                                            </div>
                                        </div><!-- Unlimited Height: -->

                                    </div><!-- Responsive -->

                                    <div class="tab-pane{{if slider_type == 'fullscreen'}}  active{{/if}}" id="sconfig_layout4_tab">
                                        
                                        <div class="control-group">
                                            <label class="control-label">Offset Containers:</label>
                                            <div class="controls">
                                                <input type="text" name="fullscreen_offset_container"
                                                value="${fullscreen_offset_container}">
                                                <div class="help-block">Example: #header or .header, .footer, #somecontainer | The height of fullscreen slider will be decreased with the height of these Containers to fit perfect in the screen</div>
                                            </div>
                                        </div><!-- Offset Containers: -->

                                        <div class="control-group">
                                            <label class="control-label">Offset Size:</label>
                                            <div class="controls">
                                                <input type="text" name="fullscreen_offset_size"
                                                value="${fullscreen_offset_size}">
                                                <div class="help-block">Defines an Offset to the top. Can be used with px and %. Example: 40px or 10%</div>
                                            </div>
                                        </div><!-- Offset Size: -->
                                        
                                        <div class="control-group">
                                            <label class="control-label">Min. Fullscreen Height:</label>
                                            <div class="controls">
                                                <input type="text" name="fullscreen_min_height"
                                                value="${fullscreen_min_height}">
                                            </div>
                                        </div><!-- Min. Height: -->

                                        <div class="control-group">
                                            <label class="control-label">FullScreen Align:</label>
                                            <div class="controls">
                                                <select name="full_screen_align_force" id="">
                                                    <option value="off"{{if full_screen_align_force == 'off'}} selected="selected"{{/if}}>False</option>
                                                    <option value="on"{{if full_screen_align_force == 'on'}} selected="selected"{{/if}}>True</option>
                                                </select>
                                            </div>
                                        </div><!-- FullScreen Align: -->

                                    </div><!-- Fullscreen -->

                                </div>

                                <div class="control-group">
                                    <label class="control-label">Force Full Width:</label>
                                    <div class="controls">
                                        <select name="force_full_width" id="">
                                            <option value="off"{{if force_full_width == 'off'}} selected="selected"{{/if}}>False</option>
                                            <option value="on"{{if force_full_width == 'on'}} selected="selected"{{/if}}>True</option>
                                        </select>
                                    </div>
                                </div><!-- Force Full Width: -->

                                <div class="control-group">
                                    <label class="control-label">Min. Height:</label>
                                    <div class="controls">
                                        <input type="text" name="min_height"
                                        value="${min_height}">
                                    </div>
                                </div><!-- Min. Height: -->

                                <div class="control-group">
                                    <label class="control-label">Grid Width:</label>
                                    <div class="controls">
                                        <input type="text" name="width"
                                        value="${width}" data-field="width">
                                    </div>
                                </div><!-- Grid Width: -->

                                <div class="control-group">
                                    <label class="control-label">Grid Height:</label>
                                    <div class="controls">
                                        <input type="text" name="height"
                                        value="${height}" data-field="height">
                                    </div>
                                </div><!-- Grid Height: -->


                            </div><!-- sconfig-main -->

                            <div class="tab-pane sconfig-general" id="sconfig-general">
                                
                                <div class="control-group">
                                    <label class="control-label">Delay:</label>
                                    <div class="controls">
                                        <input type="text" name="delay"
                                        value="${delay}" data-field="delay">
                                        <div class="help-block">The time one slide stays on the screen in milliseconds.</div>
                                    </div>
                                </div>

                                <div class="control-group">
                                    <label class="control-label">Shuffle Mode:</label>
                                    <div class="controls">
                                        <select name="shuffle" id="">
                                            <option value="off"{{if shuffle == 'off'}} selected="selected"{{/if}}>False</option>
                                            <option value="on"{{if shuffle == 'on'}} selected="selected"{{/if}}>True</option>
                                        </select>
                                        <div class="help-block">Turn Shufle Mode on and off! Will be randomized only once at the start.</div>
                                    </div>
                                </div>

                                <div class="control-group">
                                    <label class="control-label">Lazy Load:</label>
                                    <div class="controls">
                                        <select name="lazy_load" id="">
                                            <option value="off"{{if lazy_load == 'off'}} selected="selected"{{/if}}>False</option>
                                            <option value="on"{{if lazy_load == 'on'}} selected="selected"{{/if}}>True</option>
                                        </select>
                                        <div class="help-block">The lazy load means that the images will be loaded by demand, it speeds the loading of the slider.</div>
                                    </div>
                                </div>

                                <div class="control-group">
                                    <label class="control-label">Use Multi Language (WPML):</label>
                                    <div class="controls">
                                        <select name="use_wpml" id="">
                                            <option value="off"{{if use_wpml == 'off'}} selected="selected"{{/if}}>False</option>
                                            <option value="on"{{if use_wpml == 'on'}} selected="selected"{{/if}}>True</option>
                                        </select>
                                        <div class="help-block">Usethe slide as mutli language - show multi language controls across the slider. This available only when wpml plugin exists.</div>
                                    </div>
                                </div>

                                <div class="control-group">
                                    <label class="control-label">Enable Static Layers:</label>
                                    <div class="controls">
                                        <select name="enable_static_layers" id="">
                                            <option value="off"{{if enable_static_layers == 'off'}} selected="selected"{{/if}}>False</option>
                                            <option value="on"{{if enable_static_layers == 'on'}} selected="selected"{{/if}}>True</option>
                                        </select>
                                        <div class="help-block">This will enable the static layerss, giving you the option to have layers that stay on the slider on more then one slide.</div>
                                    </div>
                                </div>

                                <div class="control-group">
                                    <label class="control-label">Next Slide on Focus:</label>
                                    <div class="controls">
                                        <select name="next_slide_on_window_focus" id="">
                                            <option value="off"{{if next_slide_on_window_focus == 'off'}} selected=""{{/if}}>False</option>
                                            <option value="on"{{if next_slide_on_window_focus == 'on'}} selected=""{{/if}}>True</option>
                                        </select>
                                        <div class="help-block">Enabling this will move to the next slide if the Slider gets into focus if the user swithced between tabs.</div>
                                    </div>
                                </div>

                                <div class="control-group">
                                    <label class="control-label">Initialization Delay:</label>
                                    <div class="controls">
                                        <input type="text" name="start_js_after_delay"
                                        value="${start_js_after_delay}">
                                        <div class="help-block">Sets a delay before the Slider gets initialized.</div>
                                    </div>
                                </div>

                            </div><!-- sconfig-general -->
                            
                            <div class="tab-pane" id="sconfig-loop">

                                <div class="control-group">
                                    <label class="control-label">Stop Slider:</label>
                                    <div class="controls">
                                        <select name="stop_slider" id="">
                                            <option value="off"{{if stop_slider == 'off'}} selected="selected"{{/if}}>False</option>
                                            <option value="on"{{if stop_slider == 'on'}} selected="selected"{{/if}}>True</option>
                                        </select>
                                        <div class="help-block">On / Off to stop slider after some amount of loops / slides.</div>
                                    </div>
                                </div>

                                <div class="control-group">
                                    <label class="control-label">Stop After Loops:</label>
                                    <div class="controls">
                                        <input type="text" name="stop_after_loops"
                                        value="${stop_after_loops}">
                                        <div class="help-block">Stop the slider after certain amount of loops. 0 related to the first loop.</div>
                                    </div>
                                </div>

                                <div class="control-group">
                                    <label class="control-label">Stop At Slide:</label>
                                    <div class="controls">
                                        <input type="text" name="stop_at_slide"
                                        value="${stop_at_slide}">
                                        <div class="help-block">Stop the slider at the given slide.</div>
                                    </div>
                                </div>

                                <div class="control-group">
                                    <label class="control-label">Show Progressbar:</label>
                                    <div class="controls">
                                        <select name="show_timerbar" id="">
                                            <option value="top"
                                            {{if show_timerbar}}
                                                {{if show_timerbar == 'top'}} selected="selected"{{/if}}
                                            {{/if}}>Top</option>
                                            <option value="bottom"
                                            {{if show_timerbar}}
                                                {{if show_timerbar == 'bottom'}} selected="selected"{{/if}}
                                            {{/if}}>Bottom</option>
                                            <option value="hide"
                                            {{if show_timerbar}}
                                                {{if show_timerbar == 'hide'}} selected="selected"{{/if}}
                                            {{/if}}>Hide</option>
                                        </select>
                                        <div class="help-block">Show the top running progressbar.</div>
                                    </div>
                                </div>

                                <div class="control-group">
                                    <label class="control-label">Loop Single Slide:</label>
                                    <div class="controls">
                                        <select name="loop_slide" id="">
                                            <option value="loop"{{if loop_slide == 'loop'}} selected="selected"{{/if}}>False</option>
                                            <option value="noloop"{{if loop_slide == 'noloop'}} selected="selected"{{/if}}>True</option>
                                        </select>
                                        <div class="help-block">If only one Slide is in the Slider, you can choose wether the Slide shoudle loop or if it should stop.</div>
                                    </div>
                                </div>

                            </div><!-- sconfig-loop -->
                            
                            <div class="tab-pane" id="sconfig-appeance">

                                <div class="control-group">
                                    <label class="control-label">Dotted Overlay Size:</label>
                                    <div class="controls">
                                        <select name="background_dotted_overlay" id="">
                                            <option value="none"{{if background_dotted_overlay == 'none'}} selected="selected"{{/if}}>none</option>
                                            <option value="twoxtwo"{{if background_dotted_overlay == 'twoxtwo'}} selected="selected"{{/if}}>2 x 2 Black</option>
                                            <option value="twoxtwowhite"{{if background_dotted_overlay == 'twoxtwowhite'}} selected="selected"{{/if}}>2 x 2 White</option>
                                            <option value="threexthree"{{if background_dotted_overlay == 'threexthree'}} selected="selected"{{/if}}>3 x 3 Black</option>
                                            <option value="threexthreewhite"{{if background_dotted_overlay == 'threexthreewhite'}} selected="selected"{{/if}}>3 x 3 White</option>
                                        </select>
                                        <div class="help-block">Show a dotted overlay on the whole slider. choose width of dots.</div>
                                    </div>
                                </div>
                                
                                <div class="control-group">
                                    <label class="control-label">Shadow Type:</label>
                                    <div class="controls">
                                        <select name="shadow_type" id="">
                                            <option value="0"{{if shadow_type == '0'}} selected="selected"{{/if}}>No shadow</option>
                                            <option value="1"{{if shadow_type == '1'}} selected="selected"{{/if}}>1</option>
                                            <option value="2"{{if shadow_type == '2'}} selected="selected"{{/if}}>2</option>
                                            <option value="3"{{if shadow_type == '3'}} selected="selected"{{/if}}>3</option>
                                        </select>
                                        <div class="help-block">The Shadow display underneath the banner. The show apply to fixed and responsive modes only. the full width slider don;t have a shadow.</div>
                                    </div>
                                </div>

                                <div class="control-group">
                                    <label class="control-label">Background color:</label>
                                    <div class="controls">
                                        <input type="text" name="background_color"
                                        value="${background_color}" class="minicolors">
                                        <div class="help-block">Slider wrapper div background color, for transparent slider, leave empty.</div>
                                    </div>
                                </div>

                            </div><!-- sconfig-appeance -->
                            
                            <div class="tab-pane" id="sconfig-nav">
                                
                                <ul class="nav nav-pills">
                                    <li class="active">
                                        <a href="#sconfig-nav-general" data-toggle="tab">General</a>
                                    </li>
                                    <li>
                                        <a href="#sconfig-nav-bullets" data-toggle="tab">Bullets / Thumbnail Position</a>
                                    </li>
                                    <li>
                                        <a href="#sconfig-nav-left-arr" data-toggle="tab">Left Arrow Position</a>
                                    </li>
                                    <li>
                                        <a href="#sconfig-nav-right-arr" data-toggle="tab">Right Arrow Position</a>
                                    </li>
                                </ul><!-- ul.nav -->

                                <div class="tab-content">
                                    <div class="tab-pane active" id="sconfig-nav-general">
                                        <div class="control-group">
                                            <label class="control-label">Stop On Hover:</label>
                                            <div class="controls">
                                                <select name="stop_on_hover" id="">
                                                    <option value="off"{{if stop_on_hover == 'off'}} selected="selected"{{/if}}>False</option>
                                                    <option value="on"{{if stop_on_hover == 'on'}} selected="selected"{{/if}}>True</option>
                                                </select>
                                                <div class="help-block">Stop the Timer when hovering the slider.</div>
                                            </div>
                                        </div>

                                        <div class="control-group">
                                            <label class="control-label">Keyboard Navigation:</label>
                                            <div class="controls">
                                                <select name="keyboard_navigation" id="">
                                                    <option value="off"{{if keyboard_navigation == 'off'}} selected="selected"{{/if}}>False</option>
                                                    <option value="on"{{if keyboard_navigation == 'on'}} selected="selected"{{/if}}>True</option>
                                                </select>
                                                <div class="help-block">Allow/disallow to navigate the slider with keyboard.</div>
                                            </div>
                                        </div>

                                        <div class="control-group">
                                            <label class="control-label">Navigation Style:</label>
                                            <div class="controls">
                                                <select name="navigation_style" id="">
                                                    <option value="round"{{if navigation_style == 'round'}} selected="selected"{{/if}}>Round</option>
                                                    <option value="navbar"{{if navigation_style == 'navbar'}} selected="selected"{{/if}}>Navbar</option>
                                                    <option value="preview1"{{if navigation_style == 'preview1'}} selected="selected"{{/if}}>Preview 1</option>
                                                    <option value="preview2"{{if navigation_style == 'preview2'}} selected="selected"{{/if}}>Preview 2</option>
                                                    <option value="preview3"{{if navigation_style == 'preview3'}} selected="selected"{{/if}}>Preview 3</option>
                                                    <option value="preview4"{{if navigation_style == 'preview4'}} selected="selected"{{/if}}>Preview 4</option>
                                                    <option value="custom"{{if navigation_style == 'custom'}} selected="selected"{{/if}}>Custom</option>
                                                    <option value="round-old"{{if navigation_style == 'round-old'}} selected="selected"{{/if}}>Old Round</option>
                                                    <option value="square-old"{{if navigation_style == 'square-old'}} selected="selected"{{/if}}>Old Square</option>
                                                    <option value="navbar-old"{{if navigation_style == 'navbar-old'}} selected="selected"{{/if}}>Old Navbar</option>
                                                </select>
                                                <div class="help-block">Look of the navigation bullets. If you choose navbar, we recommend to choose Navigation Arrows to next to bullets.</div>
                                            </div>
                                        </div>

                                        <div class="control-group">
                                            <label class="control-label">Bullet Type:</label>
                                            <div class="controls">
                                                <select name="navigaion_type" id="">
                                                    <option value="none"{{if navigaion_type == 'none'}} selected="selected"{{/if}}>None</option>
                                                    <option value="bullet"{{if navigaion_type == 'bullet'}} selected="selected"{{/if}}>Bullet</option>
                                                    <option value="thumb"{{if navigaion_type == 'thumb'}} selected="selected"{{/if}}>Thumb</option>
                                                </select>
                                                <div class="help-block">Display type the navigation bar.</div>
                                            </div>
                                        </div>

                                        <div class="control-group">
                                            <label class="control-label">Navigation Arrows:</label>
                                            <div class="controls">
                                                <select name="navigation_arrows" id="">
                                                    <option value="nexttobullets"{{if navigation_arrows == 'nexttobullets'}} selected="selected"{{/if}}>With Bullets</option>
                                                    <option value="solo"{{if navigation_arrows == 'solo'}} selected="selected"{{/if}}>Solo</option>
                                                    <option value="none"{{if navigation_arrows == 'none'}} selected="selected"{{/if}}>None</option>
                                                </select>
                                                <div class="help-block">Display position of the Navigation Arrows ( By navigation Type Thumb arrows always centered or none visible ).</div>
                                            </div>
                                        </div>

                                        <div class="control-group">
                                            <label class="control-label">Always Show Navigation:</label>
                                            <div class="controls">
                                                <select name="navigaion_always_on" id="">
                                                    <option value="0"{{if navigaion_always_on == '0'}} selected="selected"{{/if}}>False</option>
                                                    <option value="1"{{if navigaion_always_on == '1'}} selected="selected"{{/if}}>True</option>
                                                </select>
                                                <div class="help-block">If only one Slide is in the Slider, you can choose wether the Slide shoudle loop or if it should stop.</div>
                                            </div>
                                        </div>

                                        <div class="control-group">
                                            <label class="control-label">Hide Navigation After:</label>
                                            <div class="controls">
                                                <input type="text" name="hide_thumbs"
                                                value="${hide_thumbs}">
                                                <div class="help-inline"> ms</div>
                                            </div>
                                        </div>        
                                    </div><!-- sconfig-nav-general -->

                                    <div class="tab-pane" id="sconfig-nav-bullets">
                                        
                                        <div class="control-group">
                                            <label class="control-label">Navigation Horizontal Align:</label>
                                            <div class="controls">
                                                <select name="navigaion_align_hor" id="">
                                                    <option value="left"{{if navigaion_align_hor == 'left'}} selected="selected"{{/if}}>Left</option>
                                                    <option value="center"{{if navigaion_align_hor == 'center'}} selected="selected"{{/if}}>Center</option>
                                                    <option value="right"{{if navigaion_align_hor == 'right'}} selected="selected"{{/if}}>Right</option>
                                                </select>
                                                <div class="help-block">Horizontal Align of Bullets / Thumbnails.</div>
                                            </div>
                                        </div>

                                        <div class="control-group">
                                            <label class="control-label">Navigation Vertical Align:</label>
                                            <div class="controls">
                                                <select name="navigaion_align_vert" id="">
                                                    <option value="top"{{if navigaion_align_vert == 'top'}} selected="selected"{{/if}}>Top</option>
                                                    <option value="center"{{if navigaion_align_vert == 'center'}} selected="selected"{{/if}}>Center</option>
                                                    <option value="bottom"{{if navigaion_align_vert == 'bottom'}} selected="selected"{{/if}}>Bottom</option>
                                                </select>
                                                <div class="help-block">Vertical Align of Bullets / Thumbnails.</div>
                                            </div>
                                        </div>

                                        <div class="control-group">
                                            <label class="control-label">Navigation Horizontal Offset:</label>
                                            <div class="controls">
                                                <input type="text" name="navigaion_offset_hor"
                                                value="${navigaion_offset_hor}">
                                                <div class="help-inline"> px</div>
                                            </div>
                                        </div>

                                        <div class="control-group">
                                            <label class="control-label">Navigation Vertical Offset:</label>
                                            <div class="controls">
                                                <input type="text" name="navigaion_offset_vert"
                                                value="${navigaion_offset_vert}">
                                                <div class="help-inline"> px</div>
                                            </div>
                                        </div>

                                    </div><!-- sconfig-nav-bullets -->

                                    <div class="tab-pane" id="sconfig-nav-left-arr">
                                        
                                        <div class="control-group">
                                            <label class="control-label">Left Arrow Horizontal Align:</label>
                                            <div class="controls">
                                                <select name="leftarrow_align_hor" id="">
                                                    <option value="left"{{if leftarrow_align_hor == 'left'}} selected="selected"{{/if}}>Left</option>
                                                    <option value="center"{{if leftarrow_align_hor == 'center'}} selected="selected"{{/if}}>Center</option>
                                                    <option value="right"{{if leftarrow_align_hor == 'right'}} selected="selected"{{/if}}>Right</option>
                                                </select>
                                                <div class="help-block">Horizonal Align of left Arrow (only if arrow is not next to bullets).</div>
                                            </div>
                                        </div>

                                        <div class="control-group">
                                            <label class="control-label">Left Arrow Vertical Align:</label>
                                            <div class="controls">
                                                <select name="leftarrow_align_vert" id="">
                                                    <option value="top"{{if leftarrow_align_vert == 'top'}} selected="selected"{{/if}}>Top</option>
                                                    <option value="center"{{if leftarrow_align_vert == 'center'}} selected="selected"{{/if}}>Center</option>
                                                    <option value="bottom"{{if leftarrow_align_vert == 'bottom'}} selected="selected"{{/if}}>Bottom</option>
                                                </select>
                                                <div class="help-block">Vertial ALign of left Arrow (only if arrow is not next to bullets).</div>
                                            </div>
                                        </div>

                                        <div class="control-group">
                                            <label class="control-label">Left Arrow Horizontal Offset:</label>
                                            <div class="controls">
                                                <input type="text" name="leftarrow_offset_hor"
                                                value="${leftarrow_offset_hor}">
                                                <div class="help-inline"> px</div>
                                            </div>
                                        </div>

                                        <div class="control-group">
                                            <label class="control-label">Left Arrow Vertical Offset:</label>
                                            <div class="controls">
                                                <input type="text" name="leftarrow_offset_vert"
                                                value="${leftarrow_offset_vert}">
                                                <div class="help-inline"> px</div>
                                            </div>
                                        </div>

                                    </div><!-- sconfig-nav-left-arr -->

                                    <div class="tab-pane" id="sconfig-nav-right-arr">
                                        
                                        <div class="control-group">
                                            <label class="control-label">Right Arrow Horizontal Align:</label>
                                            <div class="controls">
                                                <select name="rightarrow_align_hor" id="">
                                                    <option value="left"{{if rightarrow_align_hor == 'left'}} selected="selected"{{/if}}>Left</option>
                                                    <option value="center"{{if rightarrow_align_hor == 'center'}} selected="selected"{{/if}}>Center</option>
                                                    <option value="right"{{if rightarrow_align_hor == 'right'}} selected="selected"{{/if}}>Right</option>
                                                </select>
                                                <div class="help-block">Horizontal ALign of right Arrow (only if arrow is not next to bullets).</div>
                                            </div>
                                        </div>

                                        <div class="control-group">
                                            <label class="control-label">Right Arrow Vertical Align:</label>
                                            <div class="controls">
                                                <select name="rightarrow_align_vert" id="">
                                                    <option value="top"{{if rightarrow_align_vert == 'top'}} selected="selected"{{/if}}>Top</option>
                                                    <option value="center"{{if rightarrow_align_vert == 'center'}} selected="selected"{{/if}}>Center</option>
                                                    <option value="bottom"{{if rightarrow_align_vert == 'bottom'}} selected="selected"{{/if}}>Bottom</option>
                                                </select>
                                                <div class="help-block">Vertical Align of right Arrow (only if arrwos is not next to bullets).</div>
                                            </div>
                                        </div>

                                        <div class="control-group">
                                            <label class="control-label">Right Arrow Horizontal Offset:</label>
                                            <div class="controls">
                                                <input type="text" name="rightarrow_offset_hor"
                                                value="${rightarrow_offset_hor}">
                                                <div class="help-inline"> px</div>
                                            </div>
                                        </div>

                                        <div class="control-group">
                                            <label class="control-label">Right Arrow Vertical Offset:</label>
                                            <div class="controls">
                                                <input type="text" name="rightarrow_offset_vert"
                                                value="${rightarrow_offset_vert}">
                                                <div class="help-inline"> px</div>
                                            </div>
                                        </div>

                                    </div><!-- sconfig-nav-right-arr -->

                                </div><!-- tab-content -->

                                
                            </div><!-- sconfig-nav -->

                            <div class="tab-pane" id="sconfig-thumb">
                                <div class="control-group">
                                    <label class="control-label">Thumb Width:</label>
                                    <div class="controls">
                                        <input type="text" name="thumb_width"
                                        value="${thumb_width}">
                                        <div class="help-inline"> px</div>
                                    </div>
                                </div>

                                <div class="control-group">
                                    <label class="control-label">Thumb Height:</label>
                                    <div class="controls">
                                        <input type="text" name="thumb_height"
                                        value="${thumb_height}">
                                        <div class="help-inline"> px</div>
                                    </div>
                                </div>

                                <div class="control-group">
                                    <label class="control-label">Thumb Amount:</label>
                                    <div class="controls">
                                        <input type="text" name="thumb_amount"
                                        value="${thumb_amount}">
                                        <div class="help-inline"> px</div>
                                    </div>
                                </div>
                            </div><!-- sconfig-thumb -->
                            
                            <div class="tab-pane" id="sconfig-spinner">
                                <div class="control-group">
                                    <label class="control-label">Choose Spinner:</label>
                                    <div class="controls">
                                        <select name="use_spinner" id="">
                                            <option value="-1"{{if use_spinner == '-1'}} selected="selected"{{/if}}>Off</option>
                                            <option value="0"{{if use_spinner == '0'}} selected="selected"{{/if}}>0</option>
                                            <option value="1"{{if use_spinner == '1'}} selected="selected"{{/if}}>1</option>
                                            <option value="2"{{if use_spinner == '2'}} selected="selected"{{/if}}>2</option>
                                            <option value="3"{{if use_spinner == '3'}} selected="selected"{{/if}}>3</option>
                                            <option value="4"{{if use_spinner == '4'}} selected="selected"{{/if}}>4</option>
                                            <option value="5"{{if use_spinner == '5'}} selected="selected"{{/if}}>5</option>
                                        </select>
                                        <div class="help-block">Select a Spinner for your Slider.</div>
                                    </div>
                                </div>

                                <div class="control-group">
                                    <label class="control-label">Spinner Color:</label>
                                    <div class="controls">
                                        <input type="text" name="spinner_color"
                                        value="${spinner_color}" class="minicolors">
                                        <div class="help-block">The Color the Spinner will be shown in</div>
                                    </div>
                                </div>
                            </div><!-- sconfig-spinner -->

                            <div class="tab-pane" id="sconfig-parallax">
                                
                                <div class="control-group">
                                    <label class="control-label">Enable Parallax:</label>
                                    <div class="controls">
                                      <fieldset class="radio btn-group">
                                          
                                          <input type="radio" name="use_parallax" 
                                          id="sconfig_parallax1" value="off"
                                          {{if use_parallax == 'off'}}checked="checked"{{/if}}>
                                          <label for="sconfig_parallax1" class="btn"
                                          data-toggle="tab" data-target="#sconfig_parallax1_tab">Off</label>

                                          <input type="radio" name="use_parallax" 
                                          id="sconfig_parallax2" value="on"
                                          {{if use_parallax == 'on'}}checked="checked"{{/if}}>
                                          <label for="sconfig_parallax2" class="btn"
                                          data-toggle="tab" data-target="#sconfig_parallax2_tab">On</label>

                                      </fieldset>
                                    </div>
                                </div>

                                <div class="tab-content">
                                    
                                    <div class="tab-pane" id="sconfig_parallax1_tab">
                                        
                                    </div><!-- sconfig_parallax1_tab -->

                                    <div class="tab-pane{{if use_parallax == 'on'}} active{{/if}}" id="sconfig_parallax2_tab">
                                        
                                        <div class="span6">
                                            <div class="control-group">
                                                <label class="control-label">Disable on Mobile:</label>
                                                <div class="controls">
                                                    <select name="disable_parallax_mobile" id="">
                                                        <option value="on"{{if disable_parallax_mobile == 'on'}} selected="selected"{{/if}}>On</option>
                                                        <option value="off"{{if disable_parallax_mobile == 'off'}} selected="selected"{{/if}}>Off</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="control-group">
                                                <label class="control-label">Type:</label>
                                                <div class="controls">
                                                    <select name="parallax_type" id="">
                                                        <option value="mouse"{{if parallax_type == 'mouse'}} selected="selected"{{/if}}>Mouse Position</option>
                                                        <option value="scroll"{{if parallax_type == 'scroll'}} selected="selected"{{/if}}>Scroll Position</option>
                                                        <option value="mouse+scroll"{{if parallax_type == 'mouse+scroll'}} selected="selected"{{/if}}>Mouse and Scroll</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="control-group">
                                                <label class="control-label">BG Freeze:</label>
                                                <div class="controls">
                                                    <select name="parallax_bg_freeze" id="">
                                                        <option value="on"{{if parallax_bg_freeze == 'on'}} selected="selected"{{/if}}>On</option>
                                                        <option value="off"{{if parallax_bg_freeze == 'off'}} selected="selected"{{/if}}>Off</option>
                                                    </select>
                                                </div>
                                            </div>
                                            
                                            <div class="control-group">
                                                <label class="control-label">Level Depth 1:</label>
                                                <div class="controls">
                                                    <input type="text" class="span12" name="parallax_level_1"
                                                    value="${parallax_level_1}">
                                                </div>
                                            </div>

                                            <div class="control-group">
                                                <label class="control-label">Level Depth 2:</label>
                                                <div class="controls">
                                                    <input type="text" class="span12" name="parallax_level_2"
                                                    value="${parallax_level_2}">
                                                </div>
                                            </div>

                                            <div class="control-group">
                                                <label class="control-label">Level Depth 3:</label>
                                                <div class="controls">
                                                    <input type="text" class="span12" name="parallax_level_3"
                                                    value="${parallax_level_3}">
                                                </div>
                                            </div>

                                            <div class="control-group">
                                                <label class="control-label">Level Depth 4:</label>
                                                <div class="controls">
                                                    <input type="text" class="span12" name="parallax_level_4"
                                                    value="${parallax_level_4}">
                                                </div>
                                            </div>
                                            
                                        </div><!-- span6 -->

                                        <div class="span6">

                                            <div class="control-group">
                                                <label class="control-label">Level Depth 5:</label>
                                                <div class="controls">
                                                    <input type="text" class="span12" name="parallax_level_5"
                                                    value="${parallax_level_5}">
                                                </div>
                                            </div>

                                            <div class="control-group">
                                                <label class="control-label">Level Depth 6:</label>
                                                <div class="controls">
                                                    <input type="text" class="span12" name="parallax_level_6"
                                                    value="${parallax_level_6}">
                                                </div>
                                            </div>

                                            <div class="control-group">
                                                <label class="control-label">Level Depth 7:</label>
                                                <div class="controls">
                                                    <input type="text" class="span12" name="parallax_level_7"
                                                    value="${parallax_level_7}">
                                                </div>
                                            </div>

                                            <div class="control-group">
                                                <label class="control-label">Level Depth 8:</label>
                                                <div class="controls">
                                                    <input type="text" class="span12" name="parallax_level_8"
                                                    value="${parallax_level_8}">
                                                </div>
                                            </div>

                                            <div class="control-group">
                                                <label class="control-label">Level Depth 9:</label>
                                                <div class="controls">
                                                    <input type="text" class="span12" name="parallax_level_9"
                                                    value="${parallax_level_9}">
                                                </div>
                                            </div>
                                            
                                            <div class="control-group">
                                                <label class="control-label">Level Depth 10:</label>
                                                <div class="controls">
                                                    <input type="text" class="span12" name="parallax_level_10"
                                                    value="${parallax_level_10}">
                                                </div>
                                            </div>

                                        </div><!-- span6 -->
                                        


                                    </div><!-- sconfig_parallax2_tab -->

                                </div><!-- tab-content -->

                            </div><!-- sconfig-parallax -->
                            
                            <div class="tab-pane" id="sconfig-mobile-touch">
                                
                                <div class="control-group">
                                    <label class="control-label">Touch Enabled:</label>
                                    <div class="controls">
                                        <select name="touchenabled" id="">
                                            <option value="on"{{if touchenabled == 'on'}} selected="selected"{{/if}}>On</option>
                                            <option value="off"{{if touchenabled == 'off'}} selected="selected"{{/if}}>Off</option>
                                        </select>
                                        <div class="help-block">Enable Swipe Function on touch devices.</div>
                                    </div>
                                </div>
                                
                                <div class="control-group">
                                    <label class="control-label">Drag Block Vertical:</label>
                                    <div class="controls">
                                        <select name="drag_block_vertical" id="">
                                            <option value="true"{{if drag_block_vertical == 'true'}} selected="selected"{{/if}}>On</option>
                                            <option value="false"{{if drag_block_vertical == 'false'}} selected="selected"{{/if}}>Off</option>
                                        </select>
                                        <div class="help-block">Scroll below slider on vertical swipe.</div>
                                    </div>
                                </div>

                                <div class="control-group">
                                    <label class="control-label">Swipe Treshhold (0 - 200):</label>
                                    <div class="controls">
                                        <input type="text" class="" name="swipe_velocity"
                                        value="${swipe_velocity}">
                                        <div class="help-block">Defines the sensibility of gestures. Smaller values mean a higher sensibility.</div>
                                    </div>
                                </div>
                                
                                <div class="control-group">
                                    <label class="control-label">Swipe Min Finger:</label>
                                    <div class="controls">
                                        <input type="text" class="" name="swipe_min_touches"
                                        value="${swipe_min_touches}">
                                    </div>
                                </div>
                                
                                <div class="control-group">
                                    <label class="control-label">Swipe Max Finger:</label>
                                    <div class="controls">
                                        <input type="text" class="" name="swipe_max_touches"
                                        value="${swipe_max_touches}">                                                                               
                                    </div>
                                </div>

                                <div class="control-group">
                                    <label class="control-label">Drag Block Vertical:</label>
                                    <div class="controls">
                                        <select name="drag_block_vertical">
                                            <option value="false"{{if drag_block_vertical == 'false'}} selected="selected"{{/if}}>Off</option>
                                            <option value="true"{{if drag_block_vertical == 'true'}} selected="selected"{{/if}}>On</option>
                                        </select>
                                        <div class="help-block">Desifines how many fingers are needed minimum for swiping.</div>
                                    </div>
                                </div>


                            </div><!-- sconfig-mobile-touch -->

                            <div class="tab-pane" id="sconfig-mobile-visibility">
                                
                                <div class="control-group">
                                    <label class="control-label">Disable Slider on Mobile:</label>
                                    <div class="controls">
                                        <select name="disable_on_mobile" id="">
                                            <option value="on"{{if disable_on_mobile == 'on'}} selected="selected"{{/if}}>On</option>
                                            <option value="off"{{if disable_on_mobile == 'on'}} selected="selected"{{/if}}>Off</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="control-group">
                                    <label class="control-label">Disable KenBurn On Mobile:</label>
                                    <div class="controls">
                                        <select name="disable_kenburns_on_mobile" id="">
                                            <option value="on"{{if disable_kenburns_on_mobile == 'on'}} selected="selected"{{/if}}>On</option>
                                            <option value="off"{{if disable_kenburns_on_mobile == 'off'}} selected="selected"{{/if}}>Off</option>
                                        </select>
                                    </div>
                                </div>
                                
                                <div class="control-group">
                                    <label class="control-label">Hide Slider Under Width:</label>
                                    <div class="controls">
                                        <input type="text" name="hide_slider_under"
                                        value="${hide_slider_under}">
                                        <div class="help-inline"> px</div>
                                    </div>
                                </div>

                                <div class="control-group">
                                    <label class="control-label">Hide Defined Layers Under Width:</label>
                                    <div class="controls">
                                        <input type="text" name="hide_defined_layers_under"
                                        value="${hide_defined_layers_under}">
                                        <div class="help-inline"> px</div>
                                    </div>
                                </div>

                                <div class="control-group">
                                    <label class="control-label">Hide All Layers Under Width:</label>
                                    <div class="controls">
                                        <input type="text" name="hide_all_layers_under"
                                        value="${hide_all_layers_under}">
                                        <div class="help-inline"> px</div>
                                    </div>
                                </div>

                                <div class="control-group">
                                    <label class="control-label">Hide Arrows on Mobile:</label>
                                    <div class="controls">
                                        <select name="hide_arrows_on_mobile" id="">
                                            <option value="on"{{if hide_arrows_on_mobile == 'off'}} selected="selected"{{/if}}>On</option>
                                            <option value="off"{{if hide_arrows_on_mobile == 'off'}} selected="selected"{{/if}}>Off</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="control-group">
                                    <label class="control-label">Hide Bullets on Mobile:</label>
                                    <div class="controls">
                                        <select name="hide_bullets_on_mobile" id="">
                                            <option value="on"{{if hide_bullets_on_mobile == 'off'}} selected="selected"{{/if}}>On</option>
                                            <option value="off"{{if hide_bullets_on_mobile == 'off'}} selected="selected"{{/if}}>Off</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="control-group">
                                    <label class="control-label">Hide Thumbnails on Mobile:</label>
                                    <div class="controls">
                                        <select name="hide_thumbs_on_mobile" id="">
                                            <option value="on"{{if hide_thumbs_on_mobile == 'on'}} selected="selected"{{/if}}>On</option>
                                            <option value="off"{{if hide_thumbs_on_mobile == 'off'}} selected="selected"{{/if}}>Off</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="control-group">
                                    <label class="control-label">Hide Thumbs Under Width:</label>
                                    <div class="controls">
                                        <input type="text" name="hide_thumbs_under_resolution"
                                        value="${hide_thumbs_under_resolution}">
                                        <div class="help-inline"> px</div>
                                    </div>
                                </div>

                                <div class="control-group">
                                    <label class="control-label">Hide Mobile Nav After:</label>
                                    <div class="controls">
                                        <input type="text" name="hide_thumbs_delay_mobile"
                                        value="${hide_thumbs_delay_mobile}">
                                        <div class="help-inline"> ms</div>
                                    </div>
                                </div>

                            </div><!-- sconfig-mobile-visibility -->

                            <div class="tab-pane" id="sconfig-alternative-frist-side">
                                
                                <div class="control-group">
                                    <label class="control-label">First Transition Type:</label>
                                    <div class="controls">
                                        <select name="first_transition_type" id="">
                                            <optgroup label="RANDOM TRANSITIONS">
                                                
                                                <option value="random-selected" {{if first_transition_type == 'random-selected'}} selected="selected"{{/if}}>Random of Selected</option>
                                                <option value="random-static" {{if first_transition_type == 'random-static'}} selected="selected"{{/if}}>Random Flat</option>
                                                <option value="random-premium" {{if first_transition_type == 'random-premium'}} selected="selected"{{/if}}>Random Premium</option>
                                                <option value="random" {{if first_transition_type == 'random'}} selected="selected"{{/if}}>Random Flat and Premium</option>
                                                
                                            </optgroup>

                                            <optgroup label="SLIDING TRANSITIONS">

                                                <option value="slideup" {{if first_transition_type == 'slideup'}} selected="selected"{{/if}}>Slide To Top</option>
                                                <option value="slidedown" {{if first_transition_type == 'slidedown'}} selected="selected"{{/if}}>Slide To Bottom</option>
                                                <option value="slideright" {{if first_transition_type == 'slideright'}} selected="selected"{{/if}}>Slide To Right</option>
                                                <option value="slideleft" {{if first_transition_type == 'slideleft'}} selected="selected"{{/if}}>Slide To Left</option>
                                                <option value="slidehorizontal" {{if first_transition_type == 'slidehorizontal'}} selected="selected"{{/if}}>Slide Horizontal (depending on Next/Previous)</option>
                                                <option value="slidevertical" {{if first_transition_type == 'slidevertical'}} selected="selected"{{/if}}>Slide Vertical (depending on Next/Previous)</option>
                                                <option value="boxslide" {{if first_transition_type == 'boxslide'}} selected="selected"{{/if}}>Slide Boxes</option>
                                                <option value="slotslide-horizontal" {{if first_transition_type == 'slotslide-horizontal'}} selected="selected"{{/if}}>Slide Slots Horizontal</option>
                                                <option value="slotslide-vertical" {{if first_transition_type == 'slotslide-vertical'}} selected="selected"{{/if}}>Slide Slots Vertical</option>
                                                
                                            </optgroup>
                                            
                                            <optgroup label="FADE TRANSITIONS">
                                                
                                                <option value="notransition" {{if first_transition_type == 'notransition'}} selected="selected"{{/if}}>No Transition</option>
                                                <option value="fade" {{if first_transition_type == 'fade'}} selected="selected"{{/if}}>Fade</option>
                                                <option value="boxfade" {{if first_transition_type == 'boxfade'}} selected="selected"{{/if}}>Fade Boxes</option>
                                                <option value="slotfade-horizontal" {{if first_transition_type == 'slotfade-horizontal'}} selected="selected"{{/if}}>Fade Slots Horizontal</option>
                                                <option value="slotfade-vertical" {{if first_transition_type == 'slotfade-vertical'}} selected="selected"{{/if}}>Fade Slots Vertical</option>
                                                <option value="fadefromright" {{if first_transition_type == 'fadefromright'}} selected="selected"{{/if}}>Fade and Slide from Right</option>
                                                <option value="fadefromleft" {{if first_transition_type == 'fadefromleft'}} selected="selected"{{/if}}>Fade and Slide from Left</option>
                                                <option value="fadefromtop" {{if first_transition_type == 'fadefromtop'}} selected="selected"{{/if}}>Fade and Slide from Top</option>
                                                <option value="fadefrombottom" {{if first_transition_type == 'fadefrombottom'}} selected="selected"{{/if}}>Fade and Slide from Bottom</option>
                                                <option value="fadetoleftfadefromright" {{if first_transition_type == 'fadetoleftfadefromright'}} selected="selected"{{/if}}>Fade To Left and Fade From Right</option>
                                                <option value="fadetorightfadefromleft" {{if first_transition_type == 'fadetorightfadefromleft'}} selected="selected"{{/if}}>Fade To Right and Fade From Left</option>
                                                <option value="fadetotopfadefrombottom" {{if first_transition_type == 'fadetotopfadefrombottom'}} selected="selected"{{/if}}>Fade To Top and Fade From Bottom</option>
                                                <option value="fadetobottomfadefromtop" {{if first_transition_type == 'fadetobottomfadefromtop'}} selected="selected"{{/if}}>Fade To Bottom and Fade From Top</option>

                                            </optgroup>
                                            
                                            <optgroup label="PARALLAX TRANSITIONS">
                                                
                                                <option value="parallaxtoright" {{if first_transition_type == 'parallaxtoright'}} selected="selected"{{/if}}>Parallax to Right</option>
                                                <option value="parallaxtoleft" {{if first_transition_type == 'parallaxtoleft'}} selected="selected"{{/if}}>Parallax to Left</option>
                                                <option value="parallaxtotop" {{if first_transition_type == 'parallaxtotop'}} selected="selected"{{/if}}>Parallax to Top</option>
                                                <option value="parallaxtobottom" {{if first_transition_type == 'parallaxtobottom'}} selected="selected"{{/if}}>Parallax to Bottom</option>
                                                <option value="parallaxhorizontal" {{if first_transition_type == 'parallaxhorizontal'}} selected="selected"{{/if}}>Parallax Horizontal</option>
                                                <option value="parallaxvertical" {{if first_transition_type == 'parallaxvertical'}} selected="selected"{{/if}}>Parallax Vertical</option>

                                            </optgroup>

                                            <optgroup label="ZOOM TRANSITIONS">
                                                
                                                <option value="scaledownfromright" {{if first_transition_type == 'scaledownfromright'}} selected="selected"{{/if}}>Zoom Out and Fade From Right</option>
                                                <option value="scaledownfromleft" {{if first_transition_type == 'scaledownfromleft'}} selected="selected"{{/if}}>Zoom Out and Fade From Left</option>
                                                <option value="scaledownfromtop" {{if first_transition_type == 'scaledownfromtop'}} selected="selected"{{/if}}>Zoom Out and Fade From Top</option>
                                                <option value="scaledownfrombottom" {{if first_transition_type == 'scaledownfrombottom'}} selected="selected"{{/if}}>Zoom Out and Fade From Bottom</option>
                                                <option value="zoomout" {{if first_transition_type == 'zoomout'}} selected="selected"{{/if}}>ZoomOut</option>
                                                <option value="zoomin" {{if first_transition_type == 'zoomin'}} selected="selected"{{/if}}>ZoomIn</option>
                                                <option value="slotzoom-horizontal" {{if first_transition_type == 'slotzoom-horizontal'}} selected="selected"{{/if}}>Zoom Slots Horizontal</option>
                                                <option value="slotzoom-vertical" {{if first_transition_type == 'slotzoom-vertical'}} selected="selected"{{/if}}>Zoom Slots Vertical</option>
                                                
                                            </optgroup>

                                            <optgroup label="CURTAIN TRANSITIONS">
                                                
                                                <option value="curtain-1" {{if first_transition_type == 'curtain-1'}} selected="selected"{{/if}}>Curtain from Left</option>
                                                <option value="curtain-2" {{if first_transition_type == 'curtain-2'}} selected="selected"{{/if}}>Curtain from Right</option>
                                                <option value="curtain-3" {{if first_transition_type == 'curtain-3'}} selected="selected"{{/if}}>Curtain from Middle</option>

                                            </optgroup>

                                            <optgroup label="PREMIUM TRANSITIONS">
                                                
                                                <option value="3dcurtain-horizontal" {{if first_transition_type == '3dcurtain-horizontal'}} selected="selected"{{/if}}>3D Curtain Horizontal</option>
                                                <option value="3dcurtain-vertical" {{if first_transition_type == '3dcurtain-vertical'}} selected="selected"{{/if}}>3D Curtain Vertical</option>
                                                <option value="cube" {{if first_transition_type == 'cube'}} selected="selected"{{/if}}>Cube Vertical</option>
                                                <option value="cube-horizontal" {{if first_transition_type == 'cube-horizontal'}} selected="selected"{{/if}}>Cube Horizontal</option>
                                                <option value="incube" {{if first_transition_type == 'incube'}} selected="selected"{{/if}}>In Cube Vertical</option>
                                                <option value="incube-horizontal" {{if first_transition_type == 'incube-horizontal'}} selected="selected"{{/if}}>In Cube Horizontal</option>
                                                <option value="turnoff" {{if first_transition_type == 'turnoff'}} selected="selected"{{/if}}>TurnOff Horizontal</option>
                                                <option value="turnoff-vertical" {{if first_transition_type == 'turnoff-vertical'}} selected="selected"{{/if}}>TurnOff Vertical</option>
                                                <option value="papercut" {{if first_transition_type == 'papercut'}} selected="selected"{{/if}}>Paper Cut</option>
                                                <option value="flyin" {{if first_transition_type == 'flyin'}} selected="selected"{{/if}}>Fly In</option>

                                            </optgroup>
                                        </select>
                                        <div class="help-block">First slide transition type.</div>
                                    </div>
                                </div>

                                <div class="control-group">
                                    <label class="control-label">First Transition Active:</label>
                                    <div class="controls">
                                        <select name="first_transition_active" id="">
                                            <option value="true" {{if first_transition_active == 'true'}} selected="selected"{{/if}}>On</option>
                                            <option value="false" {{if first_transition_active == 'false'}} selected="selected"{{/if}}>Off</option>
                                        </select>
                                        <div class="help-block">First slide transition type.</div>
                                    </div>
                                </div>

                                <div class="control-group">
                                    <label class="control-label">Start With Slide:</label>
                                    <div class="controls">
                                        <input type="text" name="start_with_slide"
                                        value="${start_with_slide}">
                                        <div class="help-block">if active, it will overwrite the first slide transition. Use it when you want a special transition for the first slide only.</div>
                                    </div>
                                </div>

                                <div class="control-group">
                                    <label class="control-label">First Transition Duration:</label>
                                    <div class="controls">
                                        <input type="text" name="first_transition_duration"
                                        value="${first_transition_duration}">
                                        <div class="help-inline"> ms</div>
                                        <div class="help-block">First slide transition duration (Default: 300, min: 100, max: 2000).</div>
                                    </div>
                                </div>

                                <div class="control-group">
                                    <label class="control-label">First Transition Slot Amount:</label>
                                    <div class="controls">
                                        <input type="text" name="first_transition_slot_amount"
                                        value="${first_transition_slot_amount}">
                                        <div class="help-inline"> ms</div>
                                        <div class="help-block">The number of slots or boxes the slide is divided into. If you use boxfade, over 7 slots can be juggy.</div>
                                    </div>
                                </div>

                            </div><!-- sconfig-alternative-frist-side -->

                        </div>    
                    </div>
                </textarea>            

            </div><!-- modal-body -->

            <div class="modal-footer">
                <a href="#" class="btn btn-primary" data-active="save" data-dismiss="modal">Save changes</a>
            </div><!-- modal-footer -->
        </div>
    </div>

</div><!-- modal -->
