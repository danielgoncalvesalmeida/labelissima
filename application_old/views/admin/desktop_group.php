<!-- group_children -->
<div id="modaldialogs"></div>


<div class="row">
    <div class="col-md-12">
        <h3 class="pull-left">Groupe : <?php echo $group->name ?></h3>
        <a href="<?php echo (empty($link_back) ? sbase_url().'admin/desktop/' : sbase_url().$link_back ) ?>" class="btn btn-default pull-right">Retour</a>
    </div>
</div>

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

<div id="container_noshow" class="container_status">
    
<!-- Childs not checked in neither checked out -->
<div class="row">
    <div class="col-md-12">
        <h2>Enfants "Sans entrée" <span class="glyphicon glyphicon-unchecked"></span></h2>
        <br />
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <?php
            foreach ($children_unchecked as $child):
                if(isset($children_notices[$child->id_child]['severity']) && $children_notices[$child->id_child]['severity'] == 'danger')
                    $n_class = 'danger';
                elseif(isset($children_notices[$child->id_child]) && $children_notices[$child->id_child]['total'] > 0)
                    $n_class = 'info';
                else 
                    $n_class = 'default';
        ?>
            <div class="panel panel-default panel-child col-md-2 col-sm-3 col-xs-6 panel-child">
                <div class="panel-heading">
                    <div class="panel-title"><?php echo $child->firstname.' '.$child->lastname ?></div>
                </div>
                <div class="panel-body">
                    <img src="<?php echo sbase_url() ?>admin/img/child/<?php echo $child->id_child ?>/profilepicture.jpg" class="img-thumbnail">
                    
                    <br /><br />
                    <div class="btn-group-vertical full-width">
                        <a class="btn btn-default" href="<?php echo sbase_url() ?>admin/children/addevent/<?php echo $child->id_child ?>" >Notice <span class="glyphicon glyphicon-pencil"></span></a>
                        <a class="btn btn-success" href="<?php echo sbase_url() ?>admin/children/checkin/<?php echo $child->id_child ?>" >Entrée <span class="glyphicon glyphicon-log-in"></span></a>
                        <a class="btn btn-default" href="<?php echo sbase_url() ?>admin/children/viewjournal/<?php echo $child->id_child ?>?backgroup=<?php echo $group->id_child_group ?>" >Notices <span class="label label-<?php echo $n_class ?>"><?php echo (isset($children_notices[$child->id_child]))? $children_notices[$child->id_child]['total'] : 0 ; ?></span></a>
                    </div>
                    
                </div>
            </div>
        
        <?php
            endforeach;
        ?>
    </div>
</div>
</div>
<!-- /noshow -->



<!-- Childs checked in -->
<div id="container_in" class="container_status">
<div class="row">
    <div class="col-md-12">
        <h2>Enfants "Présents" <span class="glyphicon glyphicon-check"></span></h2>
        <br />
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        
        <?php
            foreach ($children_checkedin as $child):
                $dstart = new datetime($child->datetime_start);
                if(isset($children_notices[$child->id_child]['severity']) && $children_notices[$child->id_child]['severity'] == 'danger')
                    $n_class = 'danger';
                elseif(isset($children_notices[$child->id_child]) && $children_notices[$child->id_child]['total'] > 0)
                    $n_class = 'info';
                else 
                    $n_class = 'default';
        ?>
            <div class="panel panel-success panel-child col-md-2 col-sm-3 col-xs-6 panel-child">
                <div class="panel-heading">
                    <div class="panel-title"><?php echo $child->firstname.' '.$child->lastname ?></div>
                </div>
                <div class="panel-body">
                    <img src="<?php echo sbase_url() ?>admin/img/child/<?php echo $child->id_child ?>/profilepicture.jpg" class="img-thumbnail">
                    <br /><br />
                    <ul class="list-group">
                        <li class="list-group-item list-group-item-success">Entrée : <?php echo date_format(new datetime($child->datetime_start), 'G:i') ?></li>           
                    </ul>
                    <div class="btn-group-vertical full-width">
                        <a class="btn btn-default" href="<?php echo sbase_url() ?>admin/children/addevent/<?php echo $child->id_child ?>" >Notice <span class="glyphicon glyphicon-pencil"></span></a>
                        <a class="btn btn-danger" href="<?php echo sbase_url() ?>admin/children/checkout/<?php echo $child->id_child ?>" >Sortie <span class="glyphicon glyphicon-log-out"></span></a>
                        <a class="btn btn-default" href="<?php echo sbase_url() ?>admin/children/viewjournal/<?php echo $child->id_child ?>?backgroup=<?php echo $group->id_child_group ?>" >Notices <span class="label label-<?php echo $n_class ?>"><?php echo (isset($children_notices[$child->id_child]))? $children_notices[$child->id_child]['total'] : 0 ; ?></span></a>
                    </div>
                    
                </div>
            </div>
        
        <?php
            endforeach;
        ?>
       
    </div>
</div>
</div>
<!-- /in -->

<!-- Childs checked out -->
<div id="container_out" class="container_status">
<div class="row">
    <div class="col-md-12">
        <h2>Enfants "Sortis" <span class="glyphicon glyphicon-log-out"></span></h2>
        <br />
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <?php
            foreach ($children_checkedout as $child):
                if(isset($children_notices[$child->id_child]['severity']) && $children_notices[$child->id_child]['severity'] == 'danger')
                    $n_class = 'danger';
                elseif(isset($children_notices[$child->id_child]) && $children_notices[$child->id_child]['total'] > 0)
                    $n_class = 'info';
                else 
                    $n_class = 'default';
        ?>
            <div class="panel panel-danger panel-child col-md-2 col-sm-3 col-xs-6 panel-child">
                <div class="panel-heading">
                    <div class="panel-title"><?php echo $child->firstname.' '.$child->lastname ?></div>
                </div>
                <div class="panel-body">
                    <img src="<?php echo sbase_url() ?>admin/img/child/<?php echo $child->id_child ?>/profilepicture.jpg" class="img-thumbnail">
                    <br /><br />
                    <ul class="list-group">
                        <li class="list-group-item list-group-item-danger">Sortie : <?php echo date_format(new datetime($child->datetime_end), 'G:i') ?></li>           
                    </ul>
                    <div class="btn-group-vertical full-width">
                        <a class="btn btn-default" href="<?php echo sbase_url() ?>admin/children/addevent/<?php echo $child->id_child ?>" >Notice <span class="glyphicon glyphicon-pencil"></span></a>
                        <a class="btn btn-success" href="<?php echo sbase_url() ?>admin/children/checkin/<?php echo $child->id_child ?>" >Entrée <span class="glyphicon glyphicon-log-in"></span></a>
                        <a class="btn btn-default" href="<?php echo sbase_url() ?>admin/children/viewjournal/<?php echo $child->id_child ?>?backgroup=<?php echo $group->id_child_group ?>" >Notices <span class="label label-<?php echo $n_class ?>"><?php echo (isset($children_notices[$child->id_child]))? $children_notices[$child->id_child]['total'] : 0 ; ?></span></a>
                    </div>
                    
                </div>
            </div>
        
        <?php
            endforeach;
        ?>
    </div>
</div>
</div>
<!-- /not in -->


<div id="container_all" class="container_status">
<!-- Childs not checked in neither checked out -->
<div class="row">
    <div class="col-md-12">
        <h2>Tous les enfants <span class="glyphicon glyphicon-th-large"></span></h2>
        <br />
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <?php
            foreach ($children as $child):
                if(isset($children_all_events[$child->id_child]['checkin_status_now']['status']))
                    $status_now = $children_all_events[$child->id_child]['checkin_status_now']['status'];
                else 
                    $status_now = null;
                switch ($status_now)
                {
                    case 1:
                        $panelcss = 'success';
                        break;
                    case 2:
                        $panelcss = 'danger';
                        break;
                    default:
                        $panelcss = 'default';
                        break;
                }
                if(isset($children_notices[$child->id_child]['severity']) && $children_notices[$child->id_child]['severity'] == 'danger')
                    $n_class = 'danger';
                elseif(isset($children_notices[$child->id_child]) && $children_notices[$child->id_child]['total'] > 0)
                    $n_class = 'info';
                else 
                    $n_class = 'default';
        ?>
            <div class="panel panel-<?php echo $panelcss ?> panel-child col-md-2 col-sm-3 col-xs-6 panel-child">
                
                <div class="panel-heading">
                    <div class="panel-title"><?php echo $child->firstname.' '.$child->lastname ?></div>
                </div>
                <div class="panel-body">
                    <img src="<?php echo sbase_url() ?>admin/img/child/<?php echo $child->id_child ?>/profilepicture.jpg" class="img-thumbnail">
                    <br /><br />
                    <?php if(isset($children_all_events[$child->id_child]['checkin_status_now']['datetime_start'])): ?>
                    <ul class="list-group">
                        <li class="list-group-item list-group-item-success">Entrée : <?php echo date_format(new datetime($children_all_events[$child->id_child]['checkin_status_now']['datetime_start']), 'G:i') ?></li>           
                    </ul>
                    <?php endif; ?>
                    <?php if(isset($children_all_events[$child->id_child]['checkin_status_now']['datetime_end'])): ?>
                    <ul class="list-group">
                        <li class="list-group-item list-group-item-danger">Sortie : <?php echo date_format(new datetime($children_all_events[$child->id_child]['checkin_status_now']['datetime_end']), 'G:i') ?></li>           
                    </ul>
                    <?php endif; ?>
                    <div class="btn-group-vertical full-width">
                        <button class="btn btn-default" onclick="eventdialog(<?php echo $child->id_child ?>)">Notice <span class="glyphicon glyphicon-pencil"></span></button>
                        <?php   if ($status_now == 1): ?>
                            <button class="btn btn-danger" onclick="checkout(<?php echo $child->id_child ?>)" >Sortie <span class="glyphicon glyphicon-log-out"></span></button>
                        <?php else: ?>
                            <button class="btn btn-success" onclick="checkin(<?php echo $child->id_child ?>)" >Entrée <span class="glyphicon glyphicon-log-in"></span></button>
                        <?php endif; ?>
                        <a class="btn btn-default" href="<?php echo sbase_url() ?>admin/children/viewjournal/<?php echo $child->id_child ?>?backgroup=<?php echo $group->id_child_group ?>" >Notices <span class="label label-<?php echo $n_class ?>"><?php echo (isset($children_notices[$child->id_child]))? $children_notices[$child->id_child]['total'] : 0 ; ?></span></a>
                    </div>
                    
                </div>
            </div>
        
        <?php
            endforeach;
        ?>
    </div>
</div>
</div>
<!-- /all -->

<?php endif; ?>


<!-- Sample for later on show the children
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-danger col-md-2 col-sm-3 col-xs-6">
            <div class="panel-body">
        Enfants sans "entrée"</div>
        </div>
        
        
    </div>
</div>

-->