<!-- sites_list -->
<div class="row">
    <div class="col-md-12">
        <span class="pull-right"><a class="btn btn-default" href="<?php echo sbase_url() ?>admin/sites/add">Ajouter un site</a></span>
    </div>
</div>

<?php if(!$sites): ?>

<div class="row">
    <div class="col-md-12">&nbsp;
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="alert alert-info">
            <b>Info</b> : Actuellement aucun site ne fut ajouté !
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
            <th>Site</th>
            <th>Status</th>
            <th>Ordre</th>
            <th></th>
        </thead>
        <tbody>
            <?php
                // Determine the order
                $n = count($sites);
                for($i = 0; $i < $n; $i++){
                    $sites[$i]->id_previous = ($i == 0 ? null : $sites[$i - 1]->id_site);
                    $sites[$i]->id_next = ($i < $n-1 ? $sites[$i + 1]->id_site : null);
                }
                
                foreach ($sites as $site):
            ?>
                <tr>
                    <td><?php echo $site->id_site ?></td>
                    <td><?php echo $site->name ?></td>
                    <td><i class="<?php echo (empty($site->enabled)? 'glyphicon glyphicon-remove' : 'glyphicon glyphicon-ok') ?>"></i></td>
                    <td><?php if(!empty($site->id_previous)) : ?><a href="<?php echo sbase_url() ?>admin/sites/swap/<?php echo $site->id_site ?>/<?php echo $site->id_previous ?>" class="btn btn-default btn-xs"><i class="glyphicon glyphicon-chevron-up"></i></a>&nbsp;<?php endif; ?>
                        <?php if(!empty($site->id_next)) : ?><a href="<?php echo sbase_url() ?>admin/sites/swap/<?php echo $site->id_site ?>/<?php echo $site->id_next ?>" class="btn btn-default btn-xs"><i class="glyphicon glyphicon-chevron-down"></i></a><?php endif; ?>
                    </td>
                    <td>
                        <div class="btn-group ">
                            <button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown">
                                <span class="glyphicon glyphicon-edit"></span>&nbsp;&nbsp;<span class="caret"></span>
                            </button>
                            <ul class="dropdown-menu" role="menu">
                                <li><a href="<?php echo sbase_url() ?>admin/sites/edit/<?php echo $site->id_site ?>">Editer</a></li>
                                <li><a href="<?php echo sbase_url() ?>admin/sites/delete/<?php echo $site->id_site ?>" class="btdelete_site"><i class="icon-trash"></i> Supprimer</a></a></li>
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