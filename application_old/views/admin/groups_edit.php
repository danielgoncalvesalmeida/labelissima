<!-- groups_edit -->

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
        <a href="<?php echo (empty($link_back) ? sbase_url().'admin/groups/' : sbase_url().$link_back ) ?>" class="btn btn-default pull-right">Retour</a>
        <h3>Editer le group : <?php echo $group->name ?></h3>
    </div>
</div>

<?php 
    $attributes = array('class' => 'form-horizontal', 'id' => 'frm_edit', 'role' => 'form');
    echo form_open_multipart('admin/groups/edit/'.$group->id_child_group,$attributes);
?>
    <input type="hidden" name="id" id="id" value="<?php echo $group->id_child_group ?>" >

    <div class="form-group <?php echo (strlen(form_error('edname')) > 0 ? 'has-error' : '' ) ?>" id="cgName">
        <label class="col-sm-2 control-label" for="iName">Nom du group</label>
        <div class="col-sm-4">
            <input class="form-control" type="text" name="edname" id="iName" placeholder="nom" value="<?php echo $group->name ?>">
            <span class="help-block msg-required" style="display:none" >Champ obligatoire</span>
            <span class="help-block msg-exists" style="display:none" >Info : Ce nom existe déjà</span>
            <?php if(strlen(form_error('edname')) > 0): ?>
                <span class="help-block"><?php echo form_error('edname') ?></span>
            <?php endif; ?>
        </div>  
    </div>

    <div class="form-group <?php echo (strlen(form_error('edsite')) > 0 ? 'has-error' : '' ) ?>" >
        <label class="col-sm-2 control-label" for="iSite">Site</label>
        <div class="col-sm-4">
            <?php 
                $options = array();
                foreach ($sites as $site) {
                    $options[$site->id_site] = $site->name;
                }
                echo form_dropdown('edsite', $options, $group->id_site, 'class="form-control"');
            ?>
            <span class="help-block msg-validation-error" ><?php echo form_error('edsite') ?></span>
        </div>
    </div>
            
    <div class="form-group">
        <div class="col-xs-12 col-sm-offset-2 col-sm-4">
            <label class="radio-inline" >
                <input type="radio" name="edenabled" id="iEnabled" value="1" <?php echo ($group->enabled == 1 ? 'checked="checked"' : '') ?> > Actif
            </label>
            <label class="radio-inline" >
                <input type="radio" name="edenabled" id="iDisabled" value="0" <?php echo ($group->enabled == 0 ? 'checked="checked"' : '') ?> > Désactivé
            </label>
        </div>
    </div>   
        
    <div class="row">
        <div class="col-md-12">
        <div class="form-group">
            <div class="col-xs-12 col-sm-offset-2 col-sm-4">
                <button type="submit" class="btn btn-primary" name="submitGroupSave" id="submitGroupSave">Enregistrer</button>
                &nbsp;&nbsp;
                <a class="btn btn-danger" href="<?php echo (empty($link_back) ? sbase_url().'admin/groups/' : sbase_url().$link_back ) ?>">Annuler</a>
            </div>
        </div>

        </div>
    </div>

</form>
        
