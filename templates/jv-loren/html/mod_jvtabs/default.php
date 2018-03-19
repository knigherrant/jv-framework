<?php
$moduleId = 'JVTab'.$module->id;

?>
<div id="<?php echo $moduleId?>" class=" <?php echo $dataConfigs->suffix?> modJvtab jvtabs mb-50">
    <ul class="nav nav-pills item-4">
        <?php foreach($dataTabs as $key => $tab): ?>
            <li class="<?php echo ($key==0)?'active':''; ?>"><a href="#<?php echo $tab->id ?>" data-toggle="tab"><span><?php echo $tab->title ?></span></a></li>
        <?php endforeach;?>
    </ul>
    <div class="tab-content">
        <?php foreach($dataTabs as  $key => $tab): ?>
            <div id="<?php echo $tab->id ?>" class="tab-pane <?php echo ($key==0)?'active':''; ?>"><?php echo $tab->content ?></div>
        <?php endforeach;?>
    </div>
</div>