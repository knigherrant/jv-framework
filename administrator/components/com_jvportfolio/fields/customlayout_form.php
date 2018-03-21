<input type="hidden" id="<?php echo $this->id; ?>" name="<?php echo $this->name; ?>" value="<?php echo $this->value; ?>">

<div class="clearfix" data-tag="customlayout">
	<div class="breakpoint span5" data-tag="bp">
		
		<div class="tabbable">
			<div class="control-group">
                <div class="control-label">Layout device:</div>
                <div class="controls">
                    <ul class="nav nav-pills" data-tag="title"></ul>
                </div>
            </div>
			<div class="tab-content" data-tag="content"></div>
		</div>
	</div>
	<div class="preview span7">
		<div class="control-group">
			<div class="pfo col4">
			</div>
			<div class="sizer" style="width: 25%"></div>
		</div>
		<div class="text-center">
			<button type="button" class="btn" data-action="load-more">
				<i class="icon-cog"></i>
				Load More
			</button>
		</div>
	</div>
</div>
<textarea class="hide" data-tmpl="tname">
	<li>
		<a href="#breakpoint-${index}" data-value="${index}" data-toggle="pill">${name}</a>
	</li>
</textarea>
<textarea class="hide" data-tmpl="tcontent">
	<div id="breakpoint-${index}" class="tab-pane" data-bp="${bp}">
		<div class="control-group">
			<div class="control-label">Column:</div>
			<div class="controls">
				<select data-field="w">
                    <option value=""></option>
					<option value="1"
					{{if w}}
					{{if w == '1'}} selected="" {{/if}}
					{{/if}}
					>One</option>
					<option value="2"
					{{if w}}
					{{if w == '2'}} selected="" {{/if}}
					{{/if}}>Two</option>
					<option value="3"
					{{if w}}
					{{if w == '3'}} selected="" {{/if}}
					{{/if}}>Three</option>
					<option value="4"
					{{if w}}
					{{if w == '4'}} selected="" {{/if}}
					{{/if}}>Four</option>
					<option value="6"
					{{if w}}
					{{if w == '6'}} selected="" {{/if}}
					{{/if}}>Six</option>
				</select>
			</div>
		</div>

		<div class="control-group">
			<div class="control-label">Min-height:</div>
			<div class="controls">
				<input type="text" value="${h}" data-field="h" class="span3">
			</div>
		</div>

		<input type="hidden" value="${name}" data-tag="name">
	</div>
</textarea>
<textarea data-tmpl="pfo-item" class="hide">
	<div class="item" style="background-color: ${color};"></div>
</textarea>
<div id="pfo-msizer" class="modal hide fade">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <a href="javascript:void(0);" data-action="save" class="btn btn-primary pull-right">Save changes</a>
        <h3>Sizer element</h3>
    </div>
    <div class="modal-body">
        <div class="tabtable">
            <div class="control-group">
                <div class="control-label">Layout device:</div>
                <div class="controls">
                    <ul class="nav nav-pills">
                        <li class="active"><a href="#sizer-md" data-toggle="pill">Desktop</a></li>
                        <li><a href="#sizer-sm" data-toggle="pill">Tablet</a></li>
                        <li><a href="#sizer-xs" data-toggle="pill">Mobile</a></li>
                    </ul>
                </div>
            </div>
            <div class="tab-content">
                <div class="tab-pane active" id="sizer-md" data-tag="md">
                    <div class="control-group">
                        <div class="control-label">Size:</div>
                        <div class="controls">
                            <select data-field="w">
                                <option value="1">sizer-1</option>
                                <option value="2">sizer-2</option>
                                <option value="3">sizer-3</option>
                                <option value="4">sizer-4</option>
                                <option value="5">sizer-5</option>
                                <option value="6">sizer-6</option>
                                <option value="7">sizer-7</option>
                                <option value="8">sizer-8</option>
                                <option value="9">sizer-9</option>
                                <option value="10">sizer-10</option>
                                <option value="11">sizer-11</option>
                                <option value="12">sizer-12</option>
                            </select>
                        </div>
                    </div>
                    <div class="control-group">
                        <div class="control-label">Height:</div>
                        <div class="controls"><input type="text" data-field="h"></div>
                    </div>
                </div>
                <div class="tab-pane" id="sizer-sm" data-tag="sm">
                    <div class="control-group">
                        <div class="control-label">Size:</div>
                        <div class="controls">
                            <select data-field="w">
                                <option value="1">sizer-1</option>
                                <option value="2">sizer-2</option>
                                <option value="3">sizer-3</option>
                                <option value="4">sizer-4</option>
                                <option value="5">sizer-5</option>
                                <option value="6">sizer-6</option>
                                <option value="7">sizer-7</option>
                                <option value="8">sizer-8</option>
                                <option value="9">sizer-9</option>
                                <option value="10">sizer-10</option>
                                <option value="11">sizer-11</option>
                                <option value="12">sizer-12</option>
                            </select>
                        </div>
                    </div>
                    <div class="control-group">
                        <div class="control-label">Height:</div>
                        <div class="controls"><input type="text" data-field="h"></div>
                    </div>
                </div>
                <div class="tab-pane" id="sizer-xs" data-tag="xs">
                    <div class="control-group">
                        <div class="control-label">Size:</div>
                        <div class="controls">
                            <select data-field="w">
                                <option value="1">sizer-1</option>
                                <option value="2">sizer-2</option>
                                <option value="3">sizer-3</option>
                                <option value="4">sizer-4</option>
                                <option value="5">sizer-5</option>
                                <option value="6">sizer-6</option>
                                <option value="7">sizer-7</option>
                                <option value="8">sizer-8</option>
                                <option value="9">sizer-9</option>
                                <option value="10">sizer-10</option>
                                <option value="11">sizer-11</option>
                                <option value="12">sizer-12</option>
                            </select>
                        </div>
                    </div>
                    <div class="control-group">
                        <div class="control-label">Height:</div>
                        <div class="controls"><input type="text" data-field="h"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
	window.JV = jQuery.extend( window.JV, {
        bpn: { md: 'Desktop', sm: 'Tablet', xs: 'Mobile' },
		bpd: {
			md: { w: 3, h: '' },
			sm: { w: 2, h: '' },
			xs: { w: 1, h: '' }
		},
		bp: ( function( d ) { return d || 0; } )( <?php echo $this->value; ?> )
	} );
</script>