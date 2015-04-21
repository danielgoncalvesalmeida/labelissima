<!-- group_children -->
<div id="modaldialogs"></div>


<div class="row">
    <div class="col-md-12">
        <a href="<?php echo (empty($link_back) ? sbase_url().'admin/desktop/' : sbase_url().$link_back ) ?>" class="btn btn-default pull-right">Retour</a>        
        <div class="desktop-group-view">
            <div class="header">
                <h3 class="pull-left"><?php echo $group->name ?></h3>Groupe
            </div>
        </div>
    </div>
</div>


<br />


<?php if($children): ?>
<div class="row">
    <div class="col-md-12">
        
        <div class="btn-group">
            <button type="button" class="btn btn-default" id="bt_filter_noshow">Enfants "Sans entrée" <span class="glyphicon glyphicon-unchecked"></span></button>
            <button type="button" class="btn btn-success" id="bt_filter_in">Enfants "Présents" <span class="glyphicon glyphicon-check"></span></button>
            <button type="button" class="btn btn-danger" id="bt_filter_out">Enfants "Sortis" <span class="glyphicon glyphicon-log-out"></span></button>
            <button type="button" class="btn btn-primary" id="bt_all">Voir tous <span class="glyphicon glyphicon-th-large"></span></button>
        </div>
        
    </div>
</div>
<?php endif; ?>

<?php if(!$children): ?>

<div class="row">
    <div class="col-md-12">
        <div class="alert alert-info">
            <b>Info</b> : Actuellement ce groupe ne dispose pas d'enfants !
        </div>
    </div>
</div>

<?php else: ?>

<!-- Childs not checked in neither checked out -->
<div id="container_noshow" class="container_status" style="<?php echo ($viewmode == 1 ? '':'display:none;') ?>">    

    <div class="row">
        <div class="col-md-12">
            <h2>Enfants "Sans entrée" <span class="glyphicon glyphicon-unchecked"></span></h2>
            <br />
        </div>
    </div>

        <?php
                        
            $i = 0;
            $perrow = 3;
            $cnt = count($children_unchecked);
            $n = 0;
            foreach ($children_unchecked as $child):
                if(isset($children_all_events[$child->id_child]['checkin_status_now']['status']))
                    $status_now = $children_all_events[$child->id_child]['checkin_status_now']['status'];
                else 
                    $status_now = null; 
        ?>
        <?php if( $i == 0 ): ?>
            <div class="row">
        <?php endif; ?>
            
                <div class="col-xs-12 col-sm-4">
                <?php 
                    $block_status = '';
                    if($status_now == 1)
                        $block_status = 'desktop-group-manage-child-wrapper-isin';
                    if($status_now == 2)
                        $block_status = 'desktop-group-manage-child-wrapper-isout';
                ?>
                
                <div class="desktop-group-manage-child-wrapper <?php echo $block_status; ?> ">
                    <div class="row">
                        
                        <div class="col-xm-12 col-sm-4">
                            <div class="left">
                                <a href="<?php echo sbase_url() ?>admin/children/view/<?php echo $child->id_child ?>?backgroup=<?php echo $group->id_child_group ?>&viewmode=1"><img src="<?php echo getProfileLink($child->id_child) ?>" alt="..." class="img-thumbnail" width="140" heigth="140"></a>
                                <h5><?php echo $child->firstname.'<br />'.$child->lastname ?></h5>
                            </div>
                        </div>
                        <div class="col-xm-12 col-sm-8">
                            <div class="right">
                                <div class="mini-dashboard">
                                    <ul>
                                        <li>Notices<span class="label label-default"><?php echo (isset($children_notices[$child->id_child]))? $children_notices[$child->id_child]['total'] : 0 ; ?></span></li>
                                        <li>Malades<span class="label label-danger">0</span></li>
                                    </ul>
                                </div> 
                                <p>
                                    <?php   if ($status_now == 1): ?>
                                        <a class="btn btn-danger" href="<?php echo sbase_url() ?>admin/children/checkout/<?php echo $child->id_child ?>?backgroup=<?php echo $group->id_child_group ?>&viewmode=1" >Sortie <span class="glyphicon glyphicon-log-out"></span></a><br />
                                    <?php else: ?>
                                        <a class="btn btn-success" href="<?php echo sbase_url() ?>admin/children/checkin/<?php echo $child->id_child ?>?backgroup=<?php echo $group->id_child_group ?>&viewmode=1" >Entrée <span class="glyphicon glyphicon-log-out"></span></a><br />
                                    <?php endif; ?>
                                        

                                    <div class="btn-group ">
                                        <a type="button" class="btn btn-primary" href="<?php echo sbase_url() ?>admin/children/addevent/<?php echo $child->id_child ?>?backgroup=<?php echo $group->id_child_group ?>&viewmode=1">Notice</a>
                                        <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown"><span class="caret"></span></button>
                                        <ul class="dropdown-menu dropdown-menu-right" role="menu">
                                            <li><a href="<?php echo sbase_url() ?>admin/children/viewjournal/<?php echo $child->id_child ?>?backgroup=<?php echo $group->id_child_group ?>&viewmode=1">Voir journal</a></li>
                                            <li><a href="<?php echo sbase_url() ?>admin/children/view/<?php echo $child->id_child ?>?backgroup=<?php echo $group->id_child_group ?>&viewmode=1">Voir infos</a></li>
                                        </ul>
                                    </div>
                                </p>    
                                    
                                    
                                
                                
                            </div>
                        </div>
                        <div class="row-status-wrapper">
                            &nbsp;
                            <?php
                                if($status_now == 1):
                            ?>
                                <span class="label label-success">Entrée : <?php echo date_format(new datetime($children_all_events[$child->id_child]['checkin_status_now']['datetime_start']), 'G:i') ?></span>
                            <?php
                                endif;
                            ?>
                            <?php
                                if($status_now == 2):
                            ?>
                                <span class="label label-danger">Sortie : <?php echo date_format(new datetime($children_all_events[$child->id_child]['checkin_status_now']['datetime_end']), 'G:i') ?></span>
                            <?php
                                endif;
                            ?>
                                
                        </div>
                    </div>
                </div>

            </div>
                

        <?php
            $i++;
            $n++;
            if(($i % $perrow) == 0 || $n == $cnt):
                $i = 0;
        ?>
            </div>
        <?php endif; ?>
        
                
        <?php
            endforeach;
        ?>
</div>
<!-- /noshow -->



<!-- Childs checked in -->
<div id="container_in" class="container_status" style="<?php echo ($viewmode == 2 ? '':'display:none;') ?>">
    <div class="row">
        <div class="col-md-12">
            <h2>Enfants "Présents" <span class="glyphicon glyphicon-check"></span></h2>
            <br />
        </div>
    </div>

        
        <?php
            $i = 0;
            $perrow = 3;
            $cnt = count($children_checkedin);
            $n = 0;
            foreach ($children_checkedin as $child):
                $dstart = new datetime($child->datetime_start);
      
                if(isset($children_all_events[$child->id_child]['checkin_status_now']['status']))
                    $status_now = $children_all_events[$child->id_child]['checkin_status_now']['status'];
                else 
                    $status_now = null; 
        ?>
        <?php if( $i == 0 ): ?>
            <div class="row">
        <?php endif; ?>
            
                <div class="col-xs-12 col-sm-4">
                <?php 
                    $block_status = '';
                    if($status_now == 1)
                        $block_status = 'desktop-group-manage-child-wrapper-isin';
                    if($status_now == 2)
                        $block_status = 'desktop-group-manage-child-wrapper-isout';
                ?>
                
                <div class="desktop-group-manage-child-wrapper <?php echo $block_status; ?> ">
                    <div class="row">
                        
                        <div class="col-xm-12 col-sm-4">
                            <div class="left">
                                <a href="<?php echo sbase_url() ?>admin/children/view/<?php echo $child->id_child ?>?backgroup=<?php echo $group->id_child_group ?>&viewmode=2"><img src="<?php echo getProfileLink($child->id_child) ?>" alt="..." class="img-thumbnail" width="140" heigth="140"></a>
                                <h5><?php echo $child->firstname.'<br />'.$child->lastname ?></h5>
                            </div>
                        </div>
                        <div class="col-xm-12 col-sm-8">
                            <div class="right">
                                <div class="mini-dashboard">
                                    <ul>
                                        <li>Notices<span class="label label-default"><?php echo (isset($children_notices[$child->id_child]))? $children_notices[$child->id_child]['total'] : 0 ; ?></span></li>
                                        <li>Malades<span class="label label-danger">0</span></li>
                                    </ul>
                                </div> 
                                <p>
                                    <?php   if ($status_now == 1): ?>
                                        <a class="btn btn-danger" href="<?php echo sbase_url() ?>admin/children/checkout/<?php echo $child->id_child ?>?backgroup=<?php echo $group->id_child_group ?>&viewmode=2" >Sortie <span class="glyphicon glyphicon-log-out"></span></a><br />
                                    <?php else: ?>
                                        <a class="btn btn-success" href="<?php echo sbase_url() ?>admin/children/checkin/<?php echo $child->id_child ?>?backgroup=<?php echo $group->id_child_group ?>&viewmode=2" >Entrée <span class="glyphicon glyphicon-log-out"></span></a><br />
                                    <?php endif; ?>
                                        
                                    
                                    
                                    <div class="btn-group ">
                                        <a type="button" class="btn btn-primary" href="<?php echo sbase_url() ?>admin/children/addevent/<?php echo $child->id_child ?>?backgroup=<?php echo $group->id_child_group ?>&viewmode=2">Notice</a>
                                        <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown"><span class="caret"></span></button>
                                        <ul class="dropdown-menu dropdown-menu-right" role="menu">
                                            <li><a href="<?php echo sbase_url() ?>admin/children/viewjournal/<?php echo $child->id_child ?>?backgroup=<?php echo $group->id_child_group ?>?backgroup=<?php echo $group->id_child_group ?>&viewmode=2">Voir journal</a></li>
                                            <li><a href="<?php echo sbase_url() ?>admin/children/view/<?php echo $child->id_child ?>?backgroup=<?php echo $group->id_child_group ?>&viewmode=2">Voir infos</a></li>
                                        </ul>
                                    </div>
                                    
                                    
                                    
                                </p>
                                
                            </div>
                        </div>
                        <div class="row-status-wrapper">
                            &nbsp;
                            <?php
                                if($status_now == 1):
                            ?>
                                <span class="label label-success">Entrée : <?php echo date_format(new datetime($children_all_events[$child->id_child]['checkin_status_now']['datetime_start']), 'G:i') ?></span>
                            <?php
                                endif;
                            ?>
                            <?php
                                if($status_now == 2):
                            ?>
                                <span class="label label-danger">Sortie : <?php echo date_format(new datetime($children_all_events[$child->id_child]['checkin_status_now']['datetime_end']), 'G:i') ?></span>
                            <?php
                                endif;
                            ?>
                                
                        </div>
                    </div>
                </div>

            </div>
                
        <?php
            $i++;
            $n++;
            if(($i % $perrow) == 0 || $n == $cnt):
                $i = 0;
        ?>
            </div>
        <?php endif; ?>
        
    
                
        <?php
            endforeach;
        ?>
       

</div>
<!-- /in -->




<!-- Childs checked out -->
<div id="container_out" class="container_status" style="<?php echo ($viewmode == 3 ? '':'display:none;') ?>">
    <div class="row">
        <div class="col-md-12">
            <h2>Enfants "Sortis" <span class="glyphicon glyphicon-log-out"></span></h2>
            <br />
        </div>
    </div>

        <?php
            $i = 0;
            $perrow = 3;
            $cnt = count($children_checkedout);
            $n = 0;
            foreach ($children_checkedout as $child):
                if(isset($children_all_events[$child->id_child]['checkin_status_now']['status']))
                    $status_now = $children_all_events[$child->id_child]['checkin_status_now']['status'];
                else 
                    $status_now = null;     
        ?>
        
        <?php if( $i == 0 ): ?>
            <div class="row">
        <?php endif; ?>
            
                <div class="col-xs-12 col-sm-4">
                <?php 
                    $block_status = '';
                    if($status_now == 1)
                        $block_status = 'desktop-group-manage-child-wrapper-isin';
                    if($status_now == 2)
                        $block_status = 'desktop-group-manage-child-wrapper-isout';
                ?>
                
                <div class="desktop-group-manage-child-wrapper <?php echo $block_status; ?> ">
                    <div class="row">
                        
                        <div class="col-xm-12 col-sm-4">
                            <div class="left">
                                <a href="<?php echo sbase_url() ?>admin/children/view/<?php echo $child->id_child ?>?backgroup=<?php echo $group->id_child_group ?>&viewmode=3"><img src="<?php echo getProfileLink($child->id_child) ?>" alt="..." class="img-thumbnail" width="140" heigth="140"></a>
                                <h5><?php echo $child->firstname.'<br />'.$child->lastname ?></h5>
                            </div>
                        </div>
                        <div class="col-xm-12 col-sm-8">
                            <div class="right">
                                <div class="mini-dashboard">
                                    <ul>
                                        <li>Notices<span class="label label-default"><?php echo (isset($children_notices[$child->id_child]))? $children_notices[$child->id_child]['total'] : 0 ; ?></span></li>
                                        <li>Malades<span class="label label-danger">0</span></li>
                                    </ul>
                                </div> 
                                <p>
                                    <?php   if ($status_now == 1): ?>
                                        <a class="btn btn-danger" href="<?php echo sbase_url() ?>admin/children/checkout/<?php echo $child->id_child ?>?backgroup=<?php echo $group->id_child_group ?>&viewmode=3" >Sortie <span class="glyphicon glyphicon-log-out"></span></a><br />
                                    <?php else: ?>
                                        <a class="btn btn-success" href="<?php echo sbase_url() ?>admin/children/checkin/<?php echo $child->id_child ?>?backgroup=<?php echo $group->id_child_group ?>&viewmode=3" >Entrée <span class="glyphicon glyphicon-log-out"></span></a><br />
                                    <?php endif; ?>
                                        
                                    
                                    
                                    <div class="btn-group ">
                                        <a type="button" class="btn btn-primary" href="<?php echo sbase_url() ?>admin/children/addevent/<?php echo $child->id_child ?>?backgroup=<?php echo $group->id_child_group ?>&viewmode=3">Notice</a>
                                        <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown"><span class="caret"></span></button>
                                        <ul class="dropdown-menu dropdown-menu-right" role="menu">
                                            <li><a href="<?php echo sbase_url() ?>admin/children/viewjournal/<?php echo $child->id_child ?>?backgroup=<?php echo $group->id_child_group ?>&viewmode=3">Voir journal</a></li>
                                            <li><a href="<?php echo sbase_url() ?>admin/children/view/<?php echo $child->id_child ?>?backgroup=<?php echo $group->id_child_group ?>&viewmode=3">Voir infos</a></li>
                                        </ul>
                                    </div>
                                    
                                    
                                    
                                </p>
                                
                            </div>
                        </div>
                        <div class="row-status-wrapper">
                            &nbsp;
                            <?php
                                if($status_now == 1):
                            ?>
                                <span class="label label-success">Entrée : <?php echo date_format(new datetime($children_all_events[$child->id_child]['checkin_status_now']['datetime_start']), 'G:i') ?></span>
                            <?php
                                endif;
                            ?>
                            <?php
                                if($status_now == 2):
                            ?>
                                <span class="label label-danger">Sortie : <?php echo date_format(new datetime($children_all_events[$child->id_child]['checkin_status_now']['datetime_end']), 'G:i') ?></span>
                            <?php
                                endif;
                            ?>
                                
                        </div>
                    </div>
                </div>

            </div>
                
        
        <?php
            $i++;
            $n++;
            if(($i % $perrow) == 0 || $n == $cnt):
                $i = 0;
        ?>
            </div>
        <?php endif; ?>
        
    
                
        <?php
            endforeach;
        ?>

</div>
<!-- /not in -->





<!-- Childs view all -->
<div id="container_all" class="container_status" style="<?php echo ($viewmode == 4 ? '':'display:none;') ?>">

    <div class="row">
        <div class="col-md-12">
            <h2>Tous les enfants <span class="glyphicon glyphicon-th-large"></span></h2>
            <br />
        </div>
    </div>


    <?php

        $i = 0;
        $perrow = 3;
        $cnt = count($children);
        $n = 0;
        foreach ($children as $child):
            if(isset($children_all_events[$child->id_child]['checkin_status_now']['status']))
                $status_now = $children_all_events[$child->id_child]['checkin_status_now']['status'];
            else 
                $status_now = null;
    ?>
            
    <?php if( $i == 0 ): ?>
    <div class="row">
    <?php endif; ?>
                    
            <div class="col-xs-12 col-sm-4">
                <?php 
                    $block_status = '';
                    if($status_now == 1)
                        $block_status = 'desktop-group-manage-child-wrapper-isin';
                    if($status_now == 2)
                        $block_status = 'desktop-group-manage-child-wrapper-isout';
                ?>
                
                <div class="desktop-group-manage-child-wrapper <?php echo $block_status; ?> ">
                    <div class="row">
                        
                        <div class="col-xm-12 col-sm-4">
                            <div class="left">
                                <a href="<?php echo sbase_url() ?>admin/children/view/<?php echo $child->id_child ?>?backgroup=<?php echo $group->id_child_group ?>&viewmode=4"><img src="<?php echo getProfileLink($child->id_child) ?>" alt="..." class="img-thumbnail" width="140" heigth="140"></a>
                                <h5><?php echo $child->firstname.'<br />'.$child->lastname ?></h5>
                            </div>
                        </div>
                        <div class="col-xm-12 col-sm-8">
                            <div class="right">
                                <div class="mini-dashboard">
                                    <ul>
                                        <li>Notices<span class="label label-default"><?php echo (isset($children_notices[$child->id_child]))? $children_notices[$child->id_child]['total'] : 0 ; ?></span></li>
                                        <li>Malades<span class="label label-danger">0</span></li>
                                    </ul>
                                </div> 
                                <p>
                                    <?php if ($status_now == 1): ?>
                                        <a class="btn btn-danger" href="<?php echo sbase_url() ?>admin/children/checkout/<?php echo $child->id_child ?>?backgroup=<?php echo $group->id_child_group ?>&viewmode=4" >Sortie <span class="glyphicon glyphicon-log-out"></span></a><br />
                                    <?php else: ?>
                                        <a class="btn btn-success" href="<?php echo sbase_url() ?>admin/children/checkin/<?php echo $child->id_child ?>?backgroup=<?php echo $group->id_child_group ?>&viewmode=4" >Entrée <span class="glyphicon glyphicon-log-out"></span></a><br />
                                    <?php endif; ?>
                                        
                                    
                                    
                                    <div class="btn-group ">
                                        <a type="button" class="btn btn-primary" href="<?php echo sbase_url() ?>admin/children/addevent/<?php echo $child->id_child ?>?backgroup=<?php echo $group->id_child_group ?>&viewmode=4">Notice</a>
                                        <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown"><span class="caret"></span></button>
                                        <ul class="dropdown-menu dropdown-menu-right" role="menu">
                                            <li><a href="<?php echo sbase_url() ?>admin/children/viewjournal/<?php echo $child->id_child ?>?backgroup=<?php echo $group->id_child_group ?>&viewmode=4">Voir journal</a></li>
                                            <li><a href="<?php echo sbase_url() ?>admin/children/view/<?php echo $child->id_child ?>?backgroup=<?php echo $group->id_child_group ?>&viewmode=4">Voir infos</a></li>
                                        </ul>
                                    </div>
                                    
                                    
                                    
                                </p>
                                
                            </div>
                        </div>
                        <div class="row-status-wrapper">
                            &nbsp;
                            <?php
                                if($status_now == 1):
                            ?>
                                <span class="label label-success">Entrée : <?php echo date_format(new datetime($children_all_events[$child->id_child]['checkin_status_now']['datetime_start']), 'G:i') ?></span>
                            <?php
                                endif;
                            ?>
                            <?php
                                if($status_now == 2):
                            ?>
                                <span class="label label-danger">Sortie : <?php echo date_format(new datetime($children_all_events[$child->id_child]['checkin_status_now']['datetime_end']), 'G:i') ?></span>
                            <?php
                                endif;
                            ?>
                                
                        </div>
                    </div>
                </div>

            </div>
                    
    <?php
        $i++;
        $n++;
        if(($i % $perrow) == 0 || $n == $cnt):
            $i = 0;
    ?>
    </div><!-- row -->
    <?php endif; ?>
        
    
                
        <?php
            endforeach;
        ?>

</div>
<!-- /all -->

<?php endif; ?>
