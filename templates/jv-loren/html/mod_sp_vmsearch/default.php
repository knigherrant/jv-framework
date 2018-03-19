<?php

    /**
    * VirtueMart Categories Module
    */
JHtml::_('formbehavior.chosen', 'select');
?>
<div class="<?php echo $moduleclass_sfx; ?> vmsearch" id="vmsearch-<?php echo $module_id ?>">
    <form action="<?php echo JRoute::_('index.php?option=com_virtuemart&view=category&virtuemart_category_id=0&search=true&limitstart=0' ); ?>" method="get">

        <div class="vmsearch-categorybox">


            <select name="virtuemart_category_id" class="vmsearch-categories">
                <option value="0" data-name="<?php echo JText::_('SP_VMSEARCH_ALL_CATEGORIES') ?>"><?php echo JText::_('SP_VMSEARCH_ALL_CATEGORIES') ?></option>
                <?php
                    echo $modSPVMSearchHelper->getTree();
                ?>
            </select>
        </div>

        <input type="hidden" name="limitstart" value="0" />
        <input type="hidden" name="option" value="com_virtuemart" />
        <input type="hidden" name="view" value="category" />
                    
        <div class="search-input-wrapper">
            <input type="text" name="keyword" autocomplete="off" class="vmsearch-box" value="<?php echo JRequest:: getVar('keyword') ?>" placeholder="<?php echo JText::_('TPL_SEARCH_PRODUCT_KEY_WORD')?>" />
        </div>
        <div class="vmsearch-button pull-right">
            <button type="submit" class="btn btn-default"><?php echo JText::_('SP_VMSEARCH_SEARCH_BUTTON') ?></button>
        </div>
    </form>
</div>


<script type="text/javascript">
    jQuery(function($){            
            // change even
            // typeahed
            $('#vmsearch-<?php echo $module_id ?> .vmsearch-box').typeahead({
                    items  : '<?php echo $max_search_suggest; ?>',
                    source : (function(query, process){
                            return $.post('<?php echo JURI::current() ?>', 
                                { 
                                    'module_id': '<?php echo $module_id; ?>',
                                    'char': query,
                                    'category': $('#vmsearch-<?php echo $module_id ?> .vmsearch-categories').val()
                                }, 
                                function (data) {
                                    return process(data);
                                },'json');
                    }),
            }); 
    });
    </script>