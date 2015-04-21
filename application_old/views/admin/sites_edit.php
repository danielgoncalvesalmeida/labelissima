<!-- sites_add -->

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
        <a href="<?php echo (empty($link_back) ? sbase_url().'admin/sites/' : sbase_url().$link_back ) ?>" class="btn btn-default pull-right">Retour</a>
        <h3>Editer le site : <?php echo $site->name ?></h3>
    </div>
</div>

<?php 
    $attributes = array('class' => 'form-horizontal', 'id' => 'frm_edit', 'role' => 'form');
    echo form_open_multipart('admin/sites/edit/'.$site->id_site,$attributes);
?>
    <input type="hidden" name="id" id="id" value="<?php echo $site->id_site ?>" >

    <div class="form-group <?php echo (strlen(form_error('edname')) > 0 ? 'has-error' : '' ) ?>" id="cgName">
        <label class="col-sm-2 control-label" for="iName">Nom du site</label>
        <div class="col-sm-4">
            <input class="form-control" type="text" name="edname" id="iName" placeholder="nom" value="<?php echo $site->name ?>">
            <span class="help-block msg-required" style="display:none" >Champ obligatoire</span>
            <span class="help-block msg-exists" style="display:none" >Info : Ce nom existe déjà</span>
            <?php if(strlen(form_error('edname')) > 0): ?>
                <span class="help-block"><?php echo form_error('edname') ?></span>
            <?php endif; ?>
        </div>  
    </div>
            
    <div class="form-group">
        <div class="col-xs-12 col-sm-offset-2 col-sm-4">
            <label class="radio-inline" >
                <input type="radio" name="edenabled" id="iEnabled" value="1" <?php echo ($site->enabled == 1 ? 'checked="checked"' : '') ?> > Actif
            </label>
            <label class="radio-inline" >
                <input type="radio" name="edenabled" id="iDisabled" value="0" <?php echo ($site->enabled == 0 ? 'checked="checked"' : '') ?> > Désactivé
            </label>
        </div>
    </div>   
        
    <div class="row">
        <div class="col-md-12">
        <div class="form-group">
            <div class="col-xs-12 col-sm-offset-2 col-sm-4">
                <button type="submit" class="btn btn-primary" name="submitSiteSave" id="submitSiteSave">Enregistrer</button>
                &nbsp;&nbsp;
                <a class="btn btn-danger" href="<?php echo (empty($link_back) ? sbase_url().'admin/sites/' : sbase_url().$link_back ) ?>">Annuler</a>
            </div>
        </div>

        </div>
    </div>

</form>
        
