<!-- children_add -->
        
<?php if(isset($flash_success)): ?>
    <div class="row">
        <div class="col-md-12">
            <div class="alert alert-success">
                <?php echo $flash_success ?>
            </div>
        
            <div class="form-group">
                <div class="controls">
                    <a class="btn btn-default" href="<?php echo (empty($link_back) ? sbase_url().'admin/children/' : sbase_url().$link_back ) ?>">OK</a>
                    
                    <?php if(isset($id_child)): ?><a class="btn btn-default" href="<?php echo sbase_url().'admin/children/edit/'.$id_child ?>">Editer</a><?php endif; ?>
                </div>
            </div>
        </div>
    </div>
        
<?php else: ?>
        
    <div class="row">
        <div class="col-md-12">
            <a href="<?php echo (empty($link_back) ? sbase_url().'admin/children/' : sbase_url().$link_back ) ?>" class="btn btn-default pull-right">Retour</a>
            <h3>Ajouter un enfant</h3>
            <br />
        </div>
    </div>

        <?php 
            $attributes = array('class' => 'form-horizontal', 'id' => 'frm_add', 'role' => 'form');
            echo form_open('admin/children/add',$attributes);
        ?>

    
     
    <div class="form-group <?php echo (strlen(form_error('edlastname')) > 0 ? 'has-error' : '' ) ?>" id="cgLastname">
        <label class="col-sm-2 control-label" for="iLastname">Nom</label>
        <div class="col-sm-4">
            <input class="form-control" type="text" name="edlastname" id="iLastname" placeholder="nom de l'enfant" value="<?php echo set_value('edlastname'); ?>">
            <span class="help-block msg-required" style="display:none" >Champ obligatoire</span>
            <?php if(strlen(form_error('edlastname')) > 0): ?>
                <span class="help-block"><?php echo form_error('edlastname') ?></span>
            <?php endif; ?>
        </div>
    </div>

    <div class="form-group <?php echo (strlen(form_error('edfirstname')) > 0 ? 'has-error' : '' ) ?>" id="cgFirstname">
        <label class="col-sm-2 control-label" for="iFirstname">Prénom</label>
        <div class="col-sm-4">
            <input class="form-control" type="text" name="edfirstname" id="iFirstname" placeholder="prénom de l'enfant" value="<?php echo set_value('edfirstname'); ?>">
            <span class="help-block msg-required" style="display:none">Champ obligatoire</span>
            <?php if(strlen(form_error('edfirstname')) > 0): ?>
                <span class="help-block"><?php echo form_error('edfirstname') ?></span>
            <?php endif; ?>
        </div>
    </div>
        
    <div class="form-group <?php echo (strlen(form_error('edsocialid')) > 0 ? 'has-error' : '' ) ?>" id="cgSocialid">
        <label class="col-sm-2 control-label" for="iSocialid">Numéro social</label>
        <div class="col-sm-4">
            <input class="form-control" type="text" name="edsocialid" id="iSocialid" placeholder="numéro social" value="<?php echo set_value('edsocialid'); ?>">
            <span class="help-block msg-required" style="display:none" >Champ obligatoire</span>
            <span class="help-block msg-exists" style="display:none">Erreur : Ce numéro est déjà attribué</span>
            <?php if(strlen(form_error('edsocialid')) > 0): ?>
                <span class="help-block"><?php echo form_error('edsocialid') ?></span>
            <?php endif; ?>
        </div>
    </div>
            
    <div class="form-group <?php echo (strlen(form_error('edbirthdate')) > 0 ? 'has-error' : '' ) ?>" id="cgBirthdate">
        <label class="col-sm-2 control-label" for="iBirthdate">Date de naissance</label>
        <div class="col-sm-4">
            <input class="form-control" type="text" name="edbirthdate" id="iBirthdate" placeholder="AAAA-MM-JJ" value="<?php echo set_value('edbirthdate'); ?>">
            <span class="help-block msg-required" style="display:none">Champ obligatoire</span>
            <span class="help-block msg-invalid" style="display:none">Date non valide</span>
            <?php if(strlen(form_error('edbirthdate')) > 0): ?>
                <span class="help-block"><?php echo form_error('edbirthdate') ?></span>
            <?php endif; ?>
        </div>
    </div>
        
    <div class="form-group">
        <div class="col-xs-12 col-sm-offset-2 col-sm-4">
            <label class="radio-inline" >
                <input type="radio" name="edgender" id="iMale" value="1" <?php echo set_radio('edgender', '1', true); ?> > Garçon
            </label>
            <label class="radio-inline" >
                <input type="radio" name="edgender" id="iFemale" value="2" <?php echo set_radio('edgender', '2'); ?> > Fille
            </label>
        </div>
    </div>

    <div class="form-group <?php echo (strlen(form_error('edcitizenship')) > 0 ? 'has-error' : '' ) ?>" id="cgCitizenship">
        <label class="col-sm-2 control-label" for="iCitizenship">Nationalité</label>
        <div class="col-sm-4">
            <input class="form-control" type="text" name="edcitizenship" id="iCitizenship" placeholder="Exemple : luxembourgeois ou autre" value="<?php echo set_value('edcitizenship'); ?>">
            <span class="help-block msg-required" style="display:none">Champ obligatoire</span>
            <?php if(strlen(form_error('edcitizenship')) > 0): ?>
                <span class="help-block"><?php echo form_error('edcitizenship') ?></span>
            <?php endif; ?>
        </div>
    </div>

        
    <div class="form-group <?php echo (strlen(form_error('edgroup')) > 0 ? 'has-error' : '' ) ?>" >
        <label class="col-sm-2 control-label" for="iGroup">Groupe</label>
        <div class="col-sm-4">
            <?php 
                $options = array();
                foreach ($groups as $group) {
                    $options[$group->id_child_group] = $group->name;
                }
                echo form_dropdown('edgroup', $options, null, 'class="form-control"');
            ?>
            <span class="help-block msg-validation-error" ><?php echo form_error('edgroup') ?></span>
        </div>
    </div>
        
       
            
    <div class="form-group">
        <div class="col-xs-12 col-sm-offset-2 col-sm-4">
            <button type="submit" class="btn btn-primary" name="submitAdd" id="submitAdd">Enregistrer</button>
            &nbsp;&nbsp;
            <a class="btn btn-danger" href="<?php echo (empty($link_back) ? sbase_url().'admin/children/' : sbase_url().$link_back ) ?>">Annuler</a>
        </div>
    </div>
        
    </form>
    
        
<?php endif ?>

