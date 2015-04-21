<!-- groups_viewjournal -->
        
<?php if(isset($flash_success)): ?>
    <div class="row">
        <div class="col-md-12">
            <div class="alert alert-success">
                <?php echo $flash_success ?>
            </div>
        </div>
    </div>
        
<?php endif; ?>
        
    <div class="row">
        <div class="col-md-12">
            <a href="<?php echo (empty($link_back) ? sbase_url().'admin/groups/' : sbase_url().$link_back ) ?>" class="btn btn-default pull-right">Retour</a>
            <h3><?php echo $group->name ?></h3>
            <br />
        </div>
    </div>

<?php if(isset($nav)): ?>
    <div class="row">
        <div class="col-md-12">
            <a class="btn btn-default" href="<?php echo sbase_url().'admin/groups/viewjournal/'.$group->id_child_group.'/'.date('Y-m-d') ?>">Aujourd'hui</a>
        <nav>
            <ul class="pagination">
            <?php foreach ($nav as $n): ?>
              <li class="<?php echo ($n['current'] ? 'active' : '') ?>"><a href="<?php echo sbase_url().'admin/groups/viewjournal/'.$group->id_child_group.'/'.$n['date'] ?>" >
                    <?php
                    if(isset($n['backward']) && $n['backward']): 
                        echo '<span class="glyphicon glyphicon-backward"></span>';
                    elseif(isset($n['forward']) && $n['forward']): 
                        echo '<span class="glyphicon glyphicon-forward"></span>';
                    else:
                        echo $n['label'].' '.$n['d'].'/'.$n['m'];
                    endif;
                    ?>
                    </a>
              </li>
            <?php endforeach; ?>
            </ul>
        </nav> 
            
        </div>
    </div>
<?php endif; ?> 

    <div class="row">
        <div class="col-md-12">
            <h4>Journal du <?php echo getWeekDayName((int)date_format($date_journal, 'N')).' '.date_format($date_journal, 'd/m/Y') ?></h4>
        </div>
    </div>


<div class="group_viewjournal">
<?php
    foreach($journal as $child):
?>
<div class="row">    
    <div class="col-xm-12 col-sm-2">
        <div class="info-left">
            <img src="http://dinokid.local/admin/img/child/10/profilepicture.jpg" width="80px" height="80px"> 
            <h3><?php echo $child['firstname'] ?></h3>
        </div>
    </div>
    
    
    <div class="col-xm-12 col-sm-10">
        <!-- time header -->
        <div class="day-outer-wrapper">
            <?php for ($hr_w = 7; $hr_w <= 19; $hr_w++): ?>
                <?php for ($min_w = 0; $min_w <= 55; $min_w = $min_w+5): ?>
                    <div class="min-outer-wrapper-header <?php if($min_w == 0) echo 'hour_start' ?> " id="<?php echo $hr_w.'_'.$min_w ?>">
                        <?php if($min_w == 0): ?>
                        <div class="hour_flag"><?php echo $hr_w ?></div>
                        <?php endif; ?>
                        &nbsp;
                        <div class="clearfix"><br /></div>
                    </div>
                <?php endfor; ?> 
            <?php endfor; ?>
        </div>
        <div class="clearfix"></div>
        
        
        <?php
        $events = array();
        if(isset($child['events']) && is_array($child['events']))
            foreach ($child['events'] as $event)
            {                
                $events[0][date_format(new Datetime($event->datetime_start), 'Gi')] = $event;
                //$events[1][date_format($date_start, 'Gi')] = $event;
            }
        ?>
        
        <div class="day-outer-wrapper">
            <?php for ($hr_w = 7; $hr_w <= 19; $hr_w++): ?>
           
                <?php for ($min_w = 0; $min_w <= 55; $min_w = $min_w+5): ?>
                    
                    <div class="min-outer-wrapper <?php if($min_w == 0) echo 'hour_start' ?> " id="5_<?php echo $hr_w.'_'.$min_w ?>">
                        
                        
                        <?php
                            if(count($events)> 0):
        
                            foreach ($events as $k_row => $event_row):
                                foreach ($events[$k_row] as $ke => $e):
                                    $start = new DateTime($e->datetime_start);
                                    //var_dump($hr_w.sprintf('%02d',$min_w));
                                    //var_dump($ke);
                                    //sprintf('%08d', 1234567);
                                    //var_dump($ke);
                                    $cursor = $hr_w.sprintf('%02d',$min_w);
                        ?>
                            
                            
                        
                        
                            <?php
                                
                                if($ke >= $cursor && $ke < $cursor+5):
                                    $type_class = 'left_default';
                                    if($e->id_type == 1)$type_class = 'left_success';
                                    if($e->id_type == 2)$type_class = 'left_warning';
                                    if($e->id_type == 3)$type_class = 'left_danger';
                            ?>
                            <div class="event_wrapper <?php echo $type_class ?>">
                                <span class="title"><?php echo $e->event_type ?></span><br />
                                <span class="glyphicon glyphicon-time"></span><span class="event_time"> <?php echo date_format($start, 'G:i') ?> | <?php echo $e->start_user_firstname.' '.$e->start_user_lastname  ?></span>
                                <?php if(!empty($e->memo)): ?>
                                <p>
                                    <?php echo $e->memo ?>
                                </p>
                                <?php endif; ?>
                            </div>
                        
                            <?php endif; ?>
                        
                        
                            &nbsp;
                            <div class="clearfix"><br /></div>
                        <?php
                                endforeach;
                            endforeach;
                            endif;
                        ?>
                    </div>
            
                <?php endfor; ?>
                    
            <?php endfor; ?>
        </div>
        
        <div class="clearfix"></div>
    </div>
</div>
        
        
    
<?php
    endforeach;
?> 
</div>







<br />
<br />
<div class="group_viewjournal">

<div class="row">
    
    <div class="col-xm-12 col-sm-2">
        
        <div class="info-left">
            <img src="http://dinokid.local/admin/img/child/10/profilepicture.jpg" width="80px" height="80px"> 
            <h3><?php echo $child['firstname'] ?></h3>
        </div>
        
    </div>
    
    <div class="col-xm-12 col-sm-10">
        <div class="day-outer-wrapper">
            <?php for ($hr_w = 7; $hr_w <= 19; $hr_w++): ?>
            <!-- hour : <?php echo $hr_w ?> -->
                <?php for ($min_w = 0; $min_w <= 55; $min_w = $min_w+5): ?>
                    <!-- minute : <?php echo $min_w ?> -->
                    <div class="min-outer-wrapper-header <?php if($min_w == 0) echo 'hour_start' ?> " id="5_<?php echo $hr_w.'_'.$min_w ?>">
                        <?php if($min_w == 0): ?>
                        <div class="hour_flag"><?php echo $hr_w ?></div>
                        <?php endif; ?>
                        
                        &nbsp;
                        <div class="clearfix"><br /></div>
                    </div>
                <?php endfor; ?>
                    
            <?php endfor; ?>
        </div>
        
        <div class="clearfix"></div>
        <div class="day-outer-wrapper">
            <?php for ($hr_w = 7; $hr_w <= 19; $hr_w++): ?>
            <!-- hour : <?php echo $hr_w ?> -->
                <?php for ($min_w = 0; $min_w <= 55; $min_w = $min_w+5): ?>
                    <!-- minute : <?php echo $min_w ?> -->
                    <div class="min-outer-wrapper <?php if($min_w == 0) echo 'hour_start' ?> " id="5_<?php echo $hr_w.'_'.$min_w ?>">
                        
                        <?php if($hr_w == 7 && $min_w == 30): ?>
                        <div class="event_wrapper left_success">
                            <span class="title">Entrée</span><br />
                            <span class="glyphicon glyphicon-time"></span><span class="event_time"> 7:30 | Daniel Goncalves</span>
                        </div>
                        <?php endif; ?>
                        
                        
                        
                        &nbsp;
                        <div class="clearfix"><br /></div>
                    </div>
                <?php endfor; ?>
                    
            <?php endfor; ?>
        </div>
        
        <div class="clearfix"></div>
        <div class="day-outer-wrapper">
            <?php for ($hr_w = 7; $hr_w <= 19; $hr_w++): ?>
            <!-- hour : <?php echo $hr_w ?> -->
                <?php for ($min_w = 0; $min_w <= 55; $min_w = $min_w+5): ?>
                    <!-- minute : <?php echo $min_w ?> -->
                    <div class="min-outer-wrapper <?php if($min_w == 0) echo 'hour_start' ?> " id="5_<?php echo $hr_w.'_'.$min_w ?>">
                        
                        
                        <?php if($hr_w == 9 && $min_w == 05): ?>
                        <br />
                        <br />
                        <div class="event_wrapper left_danger">
                            <span class="title">Entrée</span><br />
                            <span class="glyphicon glyphicon-time"></span><span class="event_time"> 7:30 | Daniel Goncalves</span>
                            <p>
                                Pas beaucoup dormi cette nuit, il est fatigué
                            </p>
                        </div>
                        <?php endif; ?>
                        
                        &nbsp;
                        <div class="clearfix"><br /></div>
                    </div>
                <?php endfor; ?>
                    
            <?php endfor; ?>
        </div>
        
    </div>
    
</div>

</div>

  