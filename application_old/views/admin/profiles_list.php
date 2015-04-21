<!-- profiles_list -->
<div class="row">
    <div class="col-md-12">
        <span class="pull-right"><a class="btn btn-default" href="<?php echo sbase_url() ?>admin/profiles/add">Ajouter un profile</a></span>
    </div>
</div>

<?php if(isset($flash_error)): ?>
    <div class="row">
        <div class="col-md-12">
            <div class="alert alert-danger" id="flash_error">
                <?php echo $flash_error ?>
            </div> 
        </div>
    </div>
<?php endif; ?>

<?php if(!$profiles): ?>

<div class="row">
    <div class="col-md-12">&nbsp;
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="alert alert-info">
            <b>Info</b> : Actuellement aucun profile ne fut ajouté !
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
            <th>Nbre utilisateurs</th>
            <th></th>
        </thead>
        <tbody>
            <?php
                foreach ($profiles as $profile):
            ?>
                <tr>
                    <td><?php echo $profile->id_right_profile ?></td>
                    <td><?php echo $profile->name ?></td>
                    <td><?php echo $profile->users_count ?></td>
                    <td>
                        <div class="btn-group ">
                            <button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown">
                                <span class="glyphicon glyphicon-edit"></span>&nbsp;&nbsp;<span class="caret"></span>
                            </button>
                            <ul class="dropdown-menu" role="menu">
                                <li><a href="<?php echo sbase_url() ?>admin/profiles/edit/<?php echo $profile->id_right_profile ?>">Editer</a></li>
                                <li><a href="<?php echo sbase_url() ?>admin/profiles/permissions/<?php echo $profile->id_right_profile ?>">Permissions</a></li>
                                <li><a href="<?php echo sbase_url() ?>admin/profiles/delete/<?php echo $profile->id_right_profile ?>" class="btdelete_profile"><i class="icon-trash"></i> Supprimer</a></a></li>
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