<div id="inline-scss" class="modal hide fade">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h3>Custom CSS</h3>
            </div>
            <div class="modal-body exclude-custom-param">
                <?php echo $this->form->getInput('customcss'); ?>
            </div><!-- modal-body -->

            <div class="modal-footer">
                <a href="#" class="btn btn-primary" data-dismiss="modal">Close</a>
            </div><!-- modal-footer -->    
        </div>    
    </div>
</div><!-- modal -->
<style>
<?php echo $this->item->customcss?>
</style>
