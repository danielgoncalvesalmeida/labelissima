<!-- children_trusteeedit -->

<div id="modaldialogs"></div>


<?php if(isset($flash_success)): ?>
    <div class="row">
        <div class="col-md-12">
            <div class="alert alert-success" id="flash_success">
                <?php echo $flash_success ?>
            </div> 
        </div>
    </div>
<?php endif; ?>

<?php if(isset($flash_error)): ?>
    <div class="row">
        <div class="col-md-12">
            <div class="alert alert-danger" id="flash_error">
                <?php echo $flash_error ?>
            </div> 
        </div>
    </div>
<?php endif; ?>

<div class="row">
    <div class="col-md-12">
        <a href="<?php echo (empty($link_back) ? sbase_url().'admin/children/edit/'.$trustee->id_child : sbase_url().$link_back ) ?>" class="btn btn-default pull-right">Retour</a>
        <h3>Editer la personne autorisée pour : <?php echo $trustee->lastname.' '.$trustee->firstname ?></h3>
    </div>
</div>


<?php 
    $attributes = array('class' => 'form-horizontal', 'id' => 'frm_edit', 'role' => 'form');
    echo form_open_multipart('admin/children/edittrustee/'.$trustee->id_child_trustee, $attributes);
?>
<input type="hidden" name="id" id="id" value="<?php echo $trustee->id_child_trustee ?>" >
<input type="hidden" name="id_child" id="id_child" value="<?php echo $trustee->id_child ?>" >

    
<div class="row">
    <div class="col-md-12">  
        
    <div class="form-group">
        <div class="col-xs-12 col-sm-offset-2 col-sm-4" id="div_profilepicture">
            <img src="<?php echo sbase_url() ?>admin/img/trustee/<?php echo $trustee->id_child_trustee ?>/profilepicture.jpg" alt="..." class="img-thumbnail" width="140" heigth="140">
            <?php if($hasprofilepicture): ?>
            <button id="btdeletetrusteeprofilepicture" class="btn btn-danger" data-id="<?php echo $trustee->id_child_trustee ?>"><span class="glyphicon glyphicon-remove"></span></button>
            <?php endif; ?>
        </div>
    </div>
        
    <div class="form-group <?php echo (strlen(form_error('edpictureprofile')) > 0 ? 'has-error' : '' ) ?>" id="cgPictureprofile">
        <div class="col-xs-12 col-sm-offset-2 col-sm-4">
            <input type="file" name="edpictureprofile" id="iPictureProfile" >
        </div>  
    </div>
    
    <div class="form-group <?php echo (strlen(form_error('edname')) > 0 ? 'has-error' : '' ) ?>" id="cgName">
        <label class="col-sm-2 control-label" for="iName">Nom de la personne autorisée</label>
        <div class="col-sm-4">
            <input class="form-control" type="text" name="edname" id="iName" placeholder="nom de la personne autorisée" value="<?php echo $trustee->name ?>">
            <span class="help-block msg-required" style="display:none" >Champ obligatoire</span>
            <?php if(strlen(form_error('edname')) > 0): ?>
                <span class="help-block"><?php echo form_error('edname') ?></span>
            <?php endif; ?>
        </div>  
    </div>
        
    <div class="form-group <?php echo (strlen(form_error('edmobile_phone')) > 0 ? 'has-error' : '' ) ?>" id="cgMobilephone">
        <label class="col-sm-2 control-label" for="iMobilephone">Téléphone portable</label>
        <div class="col-sm-4">
            <input class="form-control" type="text" name="edmobilephone" id="iMobilephone" placeholder="téléphone portable" value="<?php echo $trustee->mobile_phone ?>">
            <span class="help-block msg-required" style="display:none">Champ obligatoire</span>
            <?php if(strlen(form_error('edmobilephone')) > 0): ?>
                <span class="help-block"><?php echo form_error('edmobilephone') ?></span>
            <?php endif; ?>
        </div>
    </div>
    
    <div class="form-group <?php echo (strlen(form_error('edphone')) > 0 ? 'has-error' : '' ) ?>" id="cgPhone">
        <label class="col-sm-2 control-label" for="iPhone">Téléphone social</label>
        <div class="col-sm-4">
            <input class="form-control" type="text" name="edphone" id="iPhone" placeholder="numéro téléphone" value="<?php echo $trustee->phone ?>">
            <span class="help-block msg-required" style="display:none" >Champ obligatoire</span>
            <span class="help-block msg-exists" style="display:none">Erreur : Ce numéro est déjà attribuée</span>
            <?php if(strlen(form_error('edphone')) > 0): ?>
                <span class="help-block"><?php echo form_error('edphone') ?></span>
            <?php endif; ?>
        </div>
    </div>
        
    
    
    </div>
</div>

<!-- Save buttons -->
<br />
<div class="row">
    <div class="col-md-12">
    <div class="form-group">
        <div class="col-xs-12 col-sm-offset-2 col-sm-4">
            <button type="submit" class="btn btn-primary" name="submitAdd" value="1" id="submit">Enregistrer</button>
            &nbsp;&nbsp;
            <a class="btn btn-danger" href="<?php echo (empty($link_back) ? sbase_url().'admin/children/edit/'.$trustee->id_child : sbase_url().$link_back ) ?>">Annuler</a>
        </div>
    </div>
     
    </div>
</div>

</form>

