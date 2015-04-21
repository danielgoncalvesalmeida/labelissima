<!-- profiles_edit -->

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
        <h3>Editer le profile : <?php echo $profile->name ?></h3>
    </div>
</div>

<?php 
    $attributes = array('class' => 'form-horizontal', 'id' => 'frm_edit', 'role' => 'form');
    echo form_open_multipart('admin/profiles/edit/'.$profile->id_right_profile,$attributes);
?>
    <input type="hidden" name="id" id="id" value="<?php echo $profile->id_right_profile ?>" >

    <div class="form-group <?php echo (strlen(form_error('edname')) > 0 ? 'has-error' : '' ) ?>" id="cgName">
        <label class="col-sm-2 control-label" for="iName">Nom du profile</label>
        <div class="col-sm-4">
            <input class="form-control" type="text" name="edname" id="iName" placeholder="nom" value="<?php echo $profile->name ?>">
            <span class="help-block msg-required" style="display:none" >Champ obligatoire</span>
            <span class="help-block msg-exists" style="display:none" >Info : Ce nom existe déjà</span>
            <?php if(strlen(form_error('edname')) > 0): ?>
                <span class="help-block"><?php echo form_error('edname') ?></span>
            <?php endif; ?>
        </div>  
    </div>
        
    <div class="row">
        <div class="col-md-12">
        <div class="form-group">
            <div class="col-xs-12 col-sm-offset-2 col-sm-4">
                <button type="submit" class="btn btn-primary" name="submitProfileSave" id="submitProfileSave">Enregistrer</button>
                &nbsp;&nbsp;
                <a class="btn btn-danger" href="<?php echo (empty($link_back) ? sbase_url().'admin/profiles/' : sbase_url().$link_back ) ?>">Annuler</a>
            </div>
        </div>

        </div>
    </div>

</form>
        
