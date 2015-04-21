<!-- groups_list -->
<?php if(!$groups): ?>

<div class="row">
    <div class="col-md-12">
        <div class="alert alert-info">
            <b>Info</b> : Actuellement aucun groupe n'est défini !
        </div>
    </div>
</div>

<?php else: ?>


        
        <?php
            $i = 0;
            foreach ($groups as $group):
                $i++; 
                $perrow = 2;
        ?>
            <?php if( $i == 1 ): ?>
                <div class="row">
            <?php endif; ?>
                    
            <div class="col-xs-12 col-sm-6">
        
                <div class="desktop-group-wrapper">
                    <div class="title">
                        <h4><?php echo $group->name ?></h4>Groupe
                    </div>
                    <br />
                    <div class="mini-dashboard">
                        <ul>
                            <li>Enfants<span class="label label-default"><?php echo $group->children_count ?></span>&nbsp;<span class="label label-success"></li>
                            
                            <li>Notices<span class="label label-default"><?php echo $group->notices_count ?></span></li>
                            <li>Malades<span class="label label-danger"><?php echo $group->notices_danger_count ?></span></li>
                            <li>Entrées / Sorties<span class="label label-warning"><?php echo $group->checkout_count ?></span><span>&nbsp;</span><span class="label label-success"><?php echo $group->checkin_count ?></span></li>
                        </ul>
                    </div>
                    
                    <span class="label label-default">Site : <?php echo $group->site_name ?></span>
                    <br /><br />
                    <a href="<?php echo sbase_url() ?>admin/desktop/viewgroup/<?php echo $group->id_child_group ?>" class="btn btn-primary">Gérer</a>
                    <a href="<?php echo sbase_url() ?>admin/groups/viewjournal/<?php echo $group->id_child_group ?>" class="btn btn-default">Journal</a>

                    
                </div>
                
            </div>
                    
            <?php
                if($i == $perrow):
                    $i = 0;
            ?>
                </div>
            <?php endif; ?>
        
        <?php
                
            endforeach;
        ?>
        
    </div>
</div>

<?php endif; ?>