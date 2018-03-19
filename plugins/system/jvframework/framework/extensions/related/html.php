<?php 
$param = $this['option']->get('related');
$items = $this['option']->get('data');
$list = $items;
$columns = $param->columns;
if(count($items)){ ?>
    <div id="jvRelated" class="jvRelated">
    
    <h3>Related Article</h3>
               
                <?php if(isset($list->intros) && count($list->intros)){?> 
                    <div class="jvRelated-intro">
                        <?php  if($columns <1) $columns=1;
                        foreach ($list->intros as $index => $item){
                            if($index == 0) echo "<div class='row'>";            
                            elseif((($index)%$columns) == 0)  echo "</div><div class='row'>"; 
                            $thumbnail = @$item->thumbnails;
                            if( ($columns > 6) ) $columns = 6;
                            else if($columns==5) $columns = 4;
                            
                            ?><!----------------------------- INTRO ITEM ARTICLE ------------------------------->
                                <?php if($columns > 1){ ?>
                                <div class="<?php echo ' col-md-'.(12/$columns); ?>">
                                <?php } ?>
                                        <!-- Before title -->       
                                        <?php if($thumbnail != '' && $param->intro_thumbnail && $param->intro_thumbnail_position == 'before' ){?>
                                                <a class="thumbnail pull-<?php echo $param->intro_thumbnail_align; ?>  before <?php echo $param->intro_thumbnail_align; ?>" href="<?php echo $item->link; ?>">
                                                    <img src="<?php echo $thumbnail ?>" alt="<?php echo $item->title; ?>" title="<?php echo $item->title; ?>" />
                                                </a>
                                        <?php }?>

                                        <!-- Title -->   
                                        <?php if($param->show_title_intro) { ?>       
                                                <?php if((bool)$param->title_link_intro){?>
                                                       <h4 class="intro-title"> <a  href="<?php echo $item->link; ?>">
                                                        <?php echo $item->title; ?>  
                                                    </a>  </h4>   
                                                <?php } else { ?>
                                                    <span class="intro-title"><?php echo $item->title; ?></span>
                                                <?php } ?>                



                                        <?php } ?>
                                        <!-- Published details -->
                                        <?php if ( $param->show_intro_date) : ?>
                                            <div class="intro-detail">
                                            <?php if ($param->show_intro_date) : ?>
                                                <span class="detail-date">
                                                    <?php echo JHTML::_('date', $item->created, ($param->date_format)?$param->date_format:JText::_('DATE_FORMAT_LC3')) ?>
                                                </span>
                                            <?php endif; ?>
                                            </div>
                                        <?php endif; ?>


                                        <!-- After title -->
                                        <?php if($thumbnail != '' && $param->intro_thumbnail && $param->intro_thumbnail_position == 'after' ){?>
                                                <a class="intro-thumnail after <?php echo $param->intro_thumbnail_align; ?>" href="<?php echo $item->link; ?>">
                                                    <img src="<?php echo $thumbnail ?>" alt="<?php echo $item->title; ?>" title="<?php echo $item->title; ?>" />
                                                </a>
                                        <?php }?> 
                                        <!-- Content -->
                                        
                                        <?php if($param->show_intro_text){  ?>
                                            <div class="content_intro"><?php echo $item->text; ?>...</div>
                                        <?php } ?>

                                        <!-- Before Content -->       
                                        <?php if($thumbnail != '' && $param->intro_thumbnail && $param->intro_thumbnail_position== 'aftercontent' ){?>
                                                <a class="intro-thumnail before <?php echo $param->intro_thumbnail_align; ?>" href="<?php echo $item->link; ?>">
                                                    <img src="<?php echo $thumbnail ?>" alt="<?php echo $item->title; ?>" title="<?php echo $item->title; ?>" />
                                                </a>
                                        <?php }?>

                                       
                                <?php if($columns > 1){ ?> </div><?php } ?>
                            <!------------------------------- AND INTRO ITEM -------------------------->
                            <?php
                            if(($index+1) == count($list->intros)) echo "</div>";
                        }  ?>
                    </div>
                <?php } ?>
                <!------------------------------------------------LINK ITEM ----------------------------------------------->
                <?php if(isset($list->links) && count($list->links)){?> 
                    <ul class="jvRelated-link">
                    <?php  foreach ($list->links as $item){ ?>
                        <li class="link">     
                            <a href="<?php echo $item->link; ?>" class="more-link" title="<?php echo $item->title; ?>">
                                <?php echo $item->title; ?>
                            </a>
                        </li>
                    <?php }; ?>
                    </ul>
                <?php } ?>

    </div>
<?php } ?>
