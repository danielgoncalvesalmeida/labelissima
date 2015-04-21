<!-- groups_list -->
<div class="row">
    <div class="col-md-12">
        <span class="pull-right"><a class="btn btn-default" href="<?php echo sbase_url() ?>admin/groups/add">Ajouter un group</a></span>
    </div>
</div>

<?php if(!$groups): ?>

<div class="row">
    <div class="col-md-12">&nbsp;
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="alert alert-info">
            <b>Info</b> : Actuellement aucun group ne fut ajouté !
        </div>
    </div>
</div>

<?php else: ?>

<div class="row">
    <div class="col-md-12">
        
    <div class="table-responsive">
    <table class="table table-striped">
        <thead>
            <th>#</th>
            <th>Nom</th>
            <th>Site</th>
            <th>Status</th>
            <th>Ordre</th>
            <th></th>
        </thead>
        <tbody>
            <?php
                // Determine the order
                $n = count($groups);
                for($i = 0; $i < $n; $i++){
                    $groups[$i]->id_previous = ($i == 0 ? null : $groups[$i - 1]->id_child_group);
                    $groups[$i]->id_next = ($i < $n-1 ? $groups[$i + 1]->id_child_group : null);
                }
                
                foreach ($groups as $group):
            ?>
                <tr>
                    <td><?php echo $group->id_child_group ?></td>
                    <td><?php echo $group->name ?></td>
                    <td><?php echo $group->site_name ?></td>
                    <td><i class="<?php echo (empty($group->enabled)? 'glyphicon glyphicon-remove' : 'glyphicon glyphicon-ok') ?>"></i></td>
                    <td><?php if(!empty($group->id_previous)) : ?><a href="<?php echo sbase_url() ?>admin/groups/swap/<?php echo $group->id_child_group ?>/<?php echo $group->id_previous ?>" class="btn btn-default btn-xs"><i class="glyphicon glyphicon-chevron-up"></i></a>&nbsp;<?php endif; ?>
                        <?php if(!empty($group->id_next)) : ?><a href="<?php echo sbase_url() ?>admin/groups/swap/<?php echo $group->id_child_group ?>/<?php echo $group->id_next ?>" class="btn btn-default btn-xs"><i class="glyphicon glyphicon-chevron-down"></i></a><?php endif; ?>
                    </td>
                    <td>
                        <div class="btn-group ">
                            <button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown">
                                <span class="glyphicon glyphicon-edit"></span>&nbsp;&nbsp;<span class="caret"></span>
                            </button>
                            <ul class="dropdown-menu" role="menu">
                                <li><a href="<?php echo sbase_url() ?>admin/groups/edit/<?php echo $group->id_child_group ?>">Editer</a></li>
                                <li><a href="<?php echo sbase_url() ?>admin/groups/delete/<?php echo $group->id_child_group ?>" class="btdelete_group"><i class="icon-trash"></i> Supprimer</a></a></li>
                            </ul>
                        </div>
                    </td>
                </tr>
            <?php
                endforeach;
            ?>
        </tbody>
    </table>
    </div>
        
    </div>
</div>

<?php endif; ?>