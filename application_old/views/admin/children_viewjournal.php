<!-- children_viewjournal -->
        
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
        <div class="col-md-12 journal-view">
            <a href="<?php echo (empty($link_back) ? sbase_url().'admin/children/' : $link_back ) ?>" class="btn btn-default pull-right">Retour</a>
            <div class="main-header ">
                <h2><?php echo $child->lastname.' '.$child->firstname ?></h2>Vue journal
            </div>
        </div>
    </div>

<?php if(isset($nav)): ?>
    <div class="row">
        <div class="col-md-12">
            <a class="btn btn-default" href="<?php echo sbase_url().'admin/children/viewjournal/'.$child->id_child.'/'.date('Y-m-d') ?>">Aujourd'hui</a>
        <nav>
            <ul class="pagination">
            <?php foreach ($nav as $n): ?>
              <li class="<?php echo ($n['current'] ? 'active' : '') ?>"><a href="<?php echo sbase_url().'admin/children/viewjournal/'.$child->id_child.'/'.$n['date'] ?>" >
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

<div class="journal-view">
    <div class="journal-page">

    <div class="row">
        <div class="col-md-12">
            <h4>Journal du <?php echo getWeekDayName((int)date_format($date_journal, 'N')).' '.date_format($date_journal, 'd/m/Y') ?></h4>
        </div>
    </div>
    
        
    <div class="row">
        <div class="col-md-12 ">  
            
        <ul class="timeline">
<?php

    // Invert control
    $invert = false;

    foreach($journal as $j):
    
            // Skip
            $skip = false;
        
            // Set the label type
            $type = 'info';
            if(in_array($j->id_type, array('1')))
                $type = 'success';
            if(in_array($j->id_type, array('2')))
                $type = 'warning';
            if(in_array($j->id_type, array('3')))
                $type = 'danger';
        
        
        /*
         * Show checkin - left
         */
         if($j->id_type == 1):
             $invert = true;
             $skip = true;
?>
        <li>
            <div class="timeline-badge success"><i class="glyphicon glyphicon-check"></i></div>
                <div class="timeline-panel">
                    <div class="timeline-heading">
                        <h4 class="timeline-title"><?php echo $j->event_type ?></h4>
                        <p><small class="text-muted"><i class="glyphicon glyphicon-time"></i> <?php echo date_format(new DateTime($j->datetime_start), 'H:i').' - '.$j->start_user_firstname.' '.$j->start_user_lastname ?></small></p>
                    </div>
            </div>
        </li>
        <?php
            endif;
        ?>
          
        
        <?php
            /*
             * Show checkout - right
             */
             if($j->id_type == 2):
                 $invert = false;
                 $skip = true;
        ?>
        <li class="timeline-inverted">
            <div class="timeline-badge warning"><i class="glyphicon glyphicon-log-out"></i></div>
                <div class="timeline-panel">
                    <div class="timeline-heading">
                        <h4 class="timeline-title"><?php echo $j->event_type ?></h4>
                        <p><small class="text-muted"><i class="glyphicon glyphicon-time"></i> <?php echo date_format(new DateTime($j->datetime_start), 'H:i').' - '.$j->start_user_firstname.' '.$j->start_user_lastname ?></small></p>
                    </div>
            </div>
        </li>
        <?php
            endif;
        ?>
        
        
        
        <?php
            /*
             * Show - Is seek
             */
             if($j->id_type == 3):
                 $skip = true;
        ?>
        <li class=" <?php echo ($invert ? 'timeline-inverted' : '') ?>">
            <div class="timeline-badge danger"><i class="glyphicon glyphicon-log-out"></i></div>
                <div class="timeline-panel">
                    <div class="timeline-heading">
                        <h4 class="timeline-title"><?php echo $j->event_type ?></h4>
                        <p><small class="text-muted"><i class="glyphicon glyphicon-time"></i> <?php echo date_format(new DateTime($j->datetime_start), 'H:i').' - '.$j->start_user_firstname.' '.$j->start_user_lastname ?></small></p>
                    </div>
                <div class="timeline-body">
                    <?php if(!empty($j->id_smiley)): ?>
                        <p><?php echo imgSmiley($j->id_smiley, 24, null, 'margin-top:5px;') ?></p>
                    <?php endif; ?>
                    <?php if(!empty($j->memo)): ?>
                        <p><?php echo $j->memo ?></p>
                    <?php endif; ?>
                </div>
            </div>
        </li>
        <?php
                $invert = !$invert;
            endif;
        ?>
        
        
        <?php
            /*
             * Remaining events
             */
             if(!$skip):
                 $glyph = 'record';
                 if($j->id_type == 4)
                     $glyph = 'bed';
                 if($j->id_type == 5)
                     $glyph = 'leaf';
                 if($j->id_type == 6)
                     $glyph = 'comment';
                 if($j->id_type == 7)
                     $glyph = 'cutlery';
        ?>
        <li class=" <?php echo ($invert ? 'timeline-inverted' : '') ?>">
            <div class="timeline-badge"><i class="glyphicon glyphicon-<?php echo $glyph ?>"></i></div>
                <div class="timeline-panel">
                    <div class="timeline-heading">
                        <h4 class="timeline-title"><?php echo $j->event_type ?></h4>
                        <p><small class="text-muted"><i class="glyphicon glyphicon-time"></i> <?php echo date_format(new DateTime($j->datetime_start), 'H:i').' - '.$j->start_user_firstname.' '.$j->start_user_lastname ?></small></p>
                    </div>
                    
                <?php if(!empty($j->memo)): ?>    
                <div class="timeline-body">
                    <p>
                        <?php echo $j->memo ?>
                    </p>
                </div>
                <?php endif; ?>
                <?php if(!empty($j->id_smiley)): 
                    echo imgSmiley($j->id_smiley, 24, null, 'margin-top:5px;'); 
                endif; ?>
            </div>
        </li>
        <?php
                $invert = !$invert;
            endif;
        ?>
        
        
        
  
<?php
    endforeach;
?>
        </ul>

        </div>
    </div>


