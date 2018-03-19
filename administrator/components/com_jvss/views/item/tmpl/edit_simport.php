<div id="inline-simport" class="modal hide fade">
    <div class="modal-dialog">
        <form class="modal-content" action="<?php echo JRoute::_("index.php?option=com_jvss&task=item.import")?>" enctype="multipart/form-data" method="post">
            <div class="modal-body">
                <div class="control-group">
                    <div class="control-label">Template package file</div>
                    <div class="controls"><input type="file" name="pkg"></div>
                </div>
            </div><!-- modal-body -->

            <div class="modal-footer">
                <button class="btn btn-primary">Import</button>
                <button class="btn btn-default" data-dismiss="modal">Cancel</button>
            </div><!-- modal-footer -->
            <input type="hidden" name="id" value="<?php echo JRequest::getInt( 'id', 0) ?>"/>
        </form><!-- modal -->
    </div>
</div>