<!-- profiles_permissions -->

<?php if(isset($flash_success)): ?>
    <div class="row">
        <div class="col-md-12">
            <div class="alert alert-success" id="flash_success">
                <?php echo $flash_success ?>
            </div> 
        </div>
    </div>
<?php endif; ?>

<div class="row">
    <div class="col-md-12">
        <a href="<?php echo (empty($link_back) ? sbase_url().'admin/profiles/' : sbase_url().$link_back ) ?>" class="btn btn-default pull-right">Retour</a>
        <h3>Editer les permissions du profile : <?php echo $profile->name ?></h3>
    </div>
</div>

<?php 
    $attributes = array('class' => 'form-horizontal', 'id' => 'frm_edit', 'role' => 'form');
    echo form_open_multipart('admin/profiles/permissions/'.$profile->id_right_profile,$attributes);
?>
    <input type="hidden" name="id" id="id" value="<?php echo $profile->id_right_profile ?>" >

<?php
    foreach ($permissions as $key => $permission):
?>
    <div class="form-group" >
        <div class="col-xs-12 col-sm-11 col-sm-offset-1" style="border-top: 1px solid #ccc"><h4><?php echo $permission->right_name ?></h4></div>
    </div>
    <div class="form-group">
        <label class="col-xm-8 col-sm-2 control-label" for="id_<?php echo $permission->id_right_assign ?>_create">Visualiser</label>
        <div class="col-xm-4 col-sm-1">
            <input type="checkbox" name="view[<?php echo $permission->id_right_assign ?>]" id="id_<?php echo $permission->id_right_assign ?>_view" value="1" <?php echo ($permission->view == 1 ? 'checked="checked"' : '') ?> >
        </div>
        <label class="col-xm-8 col-sm-2 control-label" for="id_<?php echo $permission->id_right_assign ?>_create">Créer</label>
        <div class="col-xm-4 col-sm-1">
            <input type="checkbox" name="create[<?php echo $permission->id_right_assign ?>]" id="id_<?php echo $permission->id_right_assign ?>_create" value="1" <?php echo ($permission->create == 1 ? 'checked="checked"' : '') ?> >
        </div>
        <label class="col-xm-8 col-sm-2 control-label" for="id_<?php echo $permission->id_right_assign ?>_create">Editer</label>
        <div class="col-xm-4 col-sm-1">
            <input type="checkbox" name="edit[<?php echo $permission->id_right_assign ?>]" id="id_<?php echo $permission->id_right_assign ?>_edit" value="1" <?php echo ($permission->edit == 1 ? 'checked="checked"' : '') ?> >
        </div>
        <label class="col-xm-8 col-sm-2 control-label" for="id_<?php echo $permission->id_right_assign ?>_create">Supprimer</label>
        <div class="col-xm-4 col-sm-1">
            <input type="checkbox" name="delete[<?php echo $permission->id_right_assign ?>]" id="id_<?php echo $permission->id_right_assign ?>_delete" value="1" <?php echo ($permission->delete == 1 ? 'checked="checked"' : '') ?> >
        </div>
        
    </div>
<?php
    endforeach;
?>
        
    <div class="row">
        <div class="col-md-12">
        <div class="form-group">
            <div class="col-xs-12 col-sm-offset-2 col-sm-4">
                <button type="submit" class="btn btn-primary" name="submitPermissionsSave" id="submitPermissionsSave">Enregistrer</button>
                &nbsp;&nbsp;
                <a class="btn btn-danger" href="<?php echo (empty($link_back) ? sbase_url().'admin/profiles/' : sbase_url().$link_back ) ?>">Annuler</a>
            </div>
        </div>

        </div>
    </div>

</form>
        
