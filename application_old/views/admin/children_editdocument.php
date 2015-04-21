<!-- children_documentedit -->

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
        <a href="<?php echo (empty($link_back) ? sbase_url().'admin/children/edit/'.$document->id_child : sbase_url().$link_back ) ?>" class="btn btn-default pull-right">Retour</a>
        <h3>Editer le document pour : <?php echo $document->lastname.' '.$document->firstname ?></h3>
    </div>
</div>


<?php 
    $attributes = array('class' => 'form-horizontal', 'id' => 'frm_edit', 'role' => 'form');
    echo form_open_multipart('admin/children/editdocument/'.$document->id_child_document, $attributes);
?>
<input type="hidden" name="id" id="id" value="<?php echo $document->id_child_document ?>" >
<input type="hidden" name="id_child" id="id_child" value="<?php echo $document->id_child ?>" >

    
<div class="row">
    <div class="col-md-12">  
        
    <div class="form-group" style="display:none">
        <div class="col-xs-12 col-sm-offset-2 col-sm-4" id="div_profilepicture">
            <img src="<?php echo sbase_url() ?>admin/img/trustee/<?php echo $document->id_child_document ?>/profilepicture.jpg" alt="..." class="img-thumbnail" width="140" heigth="140">
            <?php if($hasprofilepicture): ?>
            <button id="btdeletetrusteeprofilepicture" class="btn btn-danger" data-id="<?php echo $document->id_child_document ?>"><span class="glyphicon glyphicon-remove"></span></button>
            <?php endif; ?>
        </div>
    </div>
        
    <div class="form-group <?php echo (strlen(form_error('edpictureprofile')) > 0 ? 'has-error' : '' ) ?>" id="cgPictureprofile" style="display:none">
        <div class="col-xs-12 col-sm-offset-2 col-sm-4">
            <input type="file" name="edpictureprofile" id="iPictureProfile" >
        </div>  
    </div>
    
    <div class="form-group <?php echo (strlen(form_error('edname')) > 0 ? 'has-error' : '' ) ?>" id="cgName">
        <label class="col-sm-2 control-label" for="iName">Libellé</label>
        <div class="col-sm-4">
            <input class="form-control" type="text" name="edname" id="iName" placeholder="nom de la personne autorisée" value="<?php echo $document->docname ?>">
            <span class="help-block msg-required" style="display:none" >Champ obligatoire</span>
            <?php if(strlen(form_error('edname')) > 0): ?>
                <span class="help-block"><?php echo form_error('edname') ?></span>
            <?php endif; ?>
        </div>  
    </div>
        
    <div class="form-group <?php echo (strlen(form_error('eddescription')) > 0 ? 'has-error' : '' ) ?>" id="cgDescription">
        <label class="col-sm-2 control-label" for="iDescription">Description</label>
        <div class="col-sm-4">
            <textarea class="form-control" rows="3" name="eddescription" id="iDescription" placeholder="Description du contenu" ><?php echo $document->description ?></textarea>
            <span class="help-block msg-required" style="display:none">Champ obligatoire</span>
            <?php if(strlen(form_error('eddescription')) > 0): ?>
                <span class="help-block"><?php echo form_error('eddescription') ?></span>
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
            <a class="btn btn-danger" href="<?php echo (empty($link_back) ? sbase_url().'admin/children/edit/'.$document->id_child : sbase_url().$link_back ) ?>">Annuler</a>
        </div>
    </div>
     
    </div>
</div>

</form>

