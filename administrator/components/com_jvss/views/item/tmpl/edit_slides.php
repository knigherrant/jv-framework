<div role="tabpanel">

    <ul class="nav nav-tabs" role="tablist" 
    data-tag="sortslide" data-nitem="5" 
    data-sitem='[data-tag="rslides"] > .tab-pane'>
        <li class="no-drag">
            <a href="javascript:void(0)" data-action="new-slide" data-target='[data-tag="rslides"]'> 
            <span class="icon-new"></span> New Slide
            </a>
        </li>
    </ul><!-- Tab panes -->

    
    <div class="tab-content" data-tag="rslides">
        
    </div><!-- div.tab-content -->

</div><!-- [role="tabpanel"] -->

<textarea class="hidden" data-tmpl="tab-name">
    <li class="" data-tag="tab-name" data-sindex="${index}">
        <a href="#slide-${index}" data-toggle="tab">
            <span id="title-${index}">Slide</span>
        </a>
        <ul class="dropdown-menu hide" role="menu">
        
          <li><a href="#editor-${index}" data-action="add-layer" 
          data-index="${index}" data-layer='#layer-${index} > [data-tag="mark-content"]' data-toggle="tab">Add layer</a></li>
     
        </ul>
    </li>
</textarea>

<textarea class="hidden" data-tmpl="tab-content">
    <div id="slide-${index}" class="tab-pane tab-panel jsonf" name="${index}">

        <div class="xtab-pane sinfo" id="sinfo-${index}" data-sindex="${index}">
            <?php echo $this->loadTemplate('sinfo')?>    
        </div><!-- div.sinfo -->

        <div class="xtab-pane simg" data-sindex="${index}">
            <?php echo $this->loadTemplate('simg')?>
        </div><!-- div.simg -->
        
        <div class="xtab-pane editor jsonf" id="editor-${index}" 
        data-tag="editor" data-sindex="${index}"
        name="items">
            <div class="e-scroll" data-tag="scroll">
                <div id="layer-${index}" class="layer" data-tag="layer">
                    <div class="" data-tag="mark-content">
                        <div class="inner"></div>
                    </div>
                </div>
            </div>
        </div><!-- div.editor --> 

        <div class="bottom-mainimage">        
        
            <div class="column-config">  
                <?php echo $this->loadTemplate('config')?>
            </div>
        
            <div class="xtab-pane column-timeline">                                                             
                <div class="xpanel">
                    <div class="xpanel-heading">
                            <button
                            type="button"
                            data-action="add-layer" 
                            data-index="${index}"
                            data-layer='#layer-${index} > [data-tag="mark-content"]'
                            class="pull-right btn btn-success">
                                <span class="icon-new"></span>
                                Add layer
                            </button>
                        <h3 data-target="#timeline-item-${index}" data-toggle="collapse">
                            

                            
                          Timeline
                        </h3>
                    </div>
                    <div class="collapse in xpanel-body xpanel-body-timeline" id="timeline-item-${index}">
                        <div class="xpanel-inner">  
                            <div  class="timeline" data-child="#timeline-item" data-tag="timeline"></div>
                        </div>
                    </div>
                </div>
            </div> 
            
        </div>          
    </div>
</textarea>                                                             

<textarea id="timeline-item" class="hidden" data-tag="timeline-item">
    <div 
    id="timeline-item-${id}" 
    class="item clearfix"
    data-toggle="tooltip"
    data-container="body"
    title="Fdfdfdfd">
        <div class="btntimeline btn-group handle text-center">
        
            <button 
            type="button" 
            class="btn btn-small" 
            data-mce="item-mce-${id}" 
            data-toggle="tooltip" 
            data-container="body" 
            title="Preview">
                <i class="icon-eye"></i>
            </button>
            <button 
            type="button" 
            class="btn btn-small" 
            data-filter="item-mce-${id}"
            data-toggle="tooltip" 
            data-container="body" 
            title="Timing &amp; Sort">
                <i class="icon-filter"></i>
            </button>
            <button 
            type="button" 
            class="btn btn-small" 
            data-action="clone-layer" 
            data-target="item-mce-${id}"
            data-toggle="tooltip" 
            data-container="body" 
            title="Duplicate layer">
                <span class="icon-save-copy"></span>
            </button>
            <button
            type="button"
            class="btn btn-small"
            data-action="remove-layer"
            data-target="item-mce-${id}"
            data-msg="<?php echo JText::_( 'Are you want to continue ?' ); ?>"
            data-toggle="tooltip" 
            data-container="body" 
            title="Remove layer">
                <span class="icon-remove "></span>
            </button>
            
            
        </div>
        <div class="divtimeline">
            <input type="text" name="timeline"
            data-tag="range" data-type="double" data-min="0"
            data-drag-interval="true" data-grid="true" data-field="range"
            data-max="${max}" data-postfix="ms" value="${timeline}"
            data-gchild="${id}">
            <input type="hidden" name="zIndex"
            data-tag="zindex" value="${zIndex}" data-field="zindex"
            data-gchild="${id}">
        </div>
    </div>
</textarea>
 
<!-- Modal -->
<div id="imageok" class="modal hide fade" tabindex="-1" 
role="dialog" aria-labelledby="imageokLabel" aria-hidden="true"
data-path="<?php echo JUri::root()?>">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h3 id="imageokLabel">Image Manager</h3>
            </div>
            <div class="modal-body">
                <iframe data-tag="image"height="800"></iframe>
            </div>
        </div>
    </div> 
</div>
