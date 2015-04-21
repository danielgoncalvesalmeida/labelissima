<!-- children_edit -->

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
        <a href="<?php echo (empty($link_back) ? sbase_url().'admin/children/' : sbase_url().$link_back ) ?>" class="btn btn-default pull-right">Retour</a>
        <h3>Editer l'enfant : <?php echo $child->lastname.' '.$child->firstname ?></h3>
    </div>
</div>

<!-- Nav tabs -->
<div class="row">
    <div class="col-md-12">
       <ul class="nav nav-pills" id="nav_tab">
           <li class="active" id="nav_tab_child"><a href="#" >Enfant</a></li>
           <li id="nav_tab_info"><a href="#" >Instructions</a></li>
           <li id="nav_tab_authorisations"><a href="#">Autorisations</a></li>
           <li id="nav_tab_emergency"><a href="#">En cas d'urgence</a></li>
       </ul>
    </div>
</div>


<?php 
    $attributes = array('class' => 'form-horizontal', 'id' => 'frm_edit', 'role' => 'form');
    echo form_open_multipart('admin/children/edit/'.$child->id_child, $attributes);
?>
<input type="hidden" name="id" id="id" value="<?php echo $child->id_child ?>" >

<!-- Tab Child -->
<br />
    
<div class="row tab_content" id="tab_child">
    <div class="col-md-12">  
        
    <div class="form-group">
        <div class="col-xs-12 col-sm-offset-2 col-sm-4" id="div_profilepicture">
            <img src="<?php echo sbase_url() ?>admin/img/child/<?php echo $child->id_child ?>/profilepicture.jpg" alt="..." class="img-thumbnail" width="140" heigth="140">
            <?php if($hasprofilepicture): ?>
            <button id="btdeleteprofilepicture" class="btn btn-danger" data-id="<?php echo $child->id_child ?>"><span class="glyphicon glyphicon-remove"></span></button>
            <?php endif; ?>
        </div>
    </div>
        
    <div class="form-group <?php echo (strlen(form_error('edpictureprofile')) > 0 ? 'has-error' : '' ) ?>" id="cgPictureprofile">
        <div class="col-xs-12 col-sm-offset-2 col-sm-4">
            <input type="file" name="edpictureprofile" id="iPictureProfile" >
        </div>  
    </div>
    
    <div class="form-group <?php echo (strlen(form_error('edlastname')) > 0 ? 'has-error' : '' ) ?>" id="cgLastname">
        <label class="col-sm-2 control-label" for="iLastname">Nom</label>
        <div class="col-sm-4">
            <input class="form-control" type="text" name="edlastname" id="iLastname" placeholder="nom de l'enfant" value="<?php echo $child->lastname ?>">
            <span class="help-block msg-required" style="display:none" >Champ obligatoire</span>
            <?php if(strlen(form_error('edlastname')) > 0): ?>
                <span class="help-block"><?php echo form_error('edlastname') ?></span>
            <?php endif; ?>
        </div>  
    </div>
        
    <div class="form-group <?php echo (strlen(form_error('edfirstname')) > 0 ? 'has-error' : '' ) ?>" id="cgFirstname">
        <label class="col-sm-2 control-label" for="iFirstname">Prénom</label>
        <div class="col-sm-4">
            <input class="form-control" type="text" name="edfirstname" id="iFirstname" placeholder="prénom de l'enfant" value="<?php echo $child->firstname ?>">
            <span class="help-block msg-required" style="display:none">Champ obligatoire</span>
            <?php if(strlen(form_error('edfirstname')) > 0): ?>
                <span class="help-block"><?php echo form_error('edfirstname') ?></span>
            <?php endif; ?>
        </div>
    </div>
    
    <div class="form-group <?php echo (strlen(form_error('edsocialid')) > 0 ? 'has-error' : '' ) ?>" id="cgSocialid">
        <label class="col-sm-2 control-label" for="iSocialid">Numéro social</label>
        <div class="col-sm-4">
            <input class="form-control" type="text" name="edsocialid" id="iSocialid" placeholder="numéro social" value="<?php echo $child->socialid ?>">
            <span class="help-block msg-required" style="display:none" >Champ obligatoire</span>
            <span class="help-block msg-exists" style="display:none">Erreur : Ce numéro est déjà attribuée</span>
            <?php if(strlen(form_error('edsocialid')) > 0): ?>
                <span class="help-block"><?php echo form_error('edsocialid') ?></span>
            <?php endif; ?>
        </div>
    </div>
        
    <div class="form-group <?php echo (strlen(form_error('edbirthdate')) > 0 ? 'has-error' : '' ) ?>" id="cgBirthdate">
        <label class="col-sm-2 control-label" for="iBirthdate">Date de naissance</label>
        <div class="col-sm-4">
            <input class="form-control" type="text" name="edbirthdate" id="iBirthdate" placeholder="AAAA-MM-JJ" value="<?php echo $child->birthdate; ?>">
            <span class="help-block msg-required" style="display:none">Champ obligatoire</span>
            <span class="help-block msg-invalid" style="display:none">Date non valide</span>
            <?php if(strlen(form_error('edbirthdate')) > 0): ?>
                <span class="help-block"><?php echo form_error('edbirthdate') ?></span>
            <?php endif; ?>
        </div>
    </div>
        
    <div class="form-group">
        <div class="col-xs-12 col-sm-offset-2 col-sm-4">
            <label class="radio-inline">
                <input type="radio" name="edgender" id="iMale" value="1" <?php echo ($child->gender == 1 ? 'checked="checked"' : '') ?>> Garçon
            </label>
            <label class="radio-inline">
                <input type="radio" name="edgender" id="iFemale" value="2" <?php echo ($child->gender == 2 ? 'checked="checked"' : '') ?>> Fille
            </label>
        </div>
    </div>
        
    <div class="form-group <?php echo (strlen(form_error('edcitizenship')) > 0 ? 'has-error' : '' ) ?>" id="cgCitizenship">
        <label class="col-sm-2 control-label" for="iCitizenship">Nationalité</label>
        <div class="col-sm-4">
            <input class="form-control" type="text" name="edcitizenship" id="iCitizenship" placeholder="Exemple : luxembourgeois ou autre" value="<?php echo $child->citizenship ?>">
            <span class="help-block msg-required" style="display:none">Champ obligatoire</span>
            <?php if(strlen(form_error('edcitizenship')) > 0): ?>
                <span class="help-block"><?php echo form_error('edcitizenship') ?></span>
            <?php endif; ?>
        </div>
    </div>
        
    <input type="hidden" name="edparent1" id="edparent1" value="<?php echo $child->id_parent_1 ?>" >
    <div class="form-group <?php echo (strlen(form_error('edparent1')) > 0 ? 'has-error' : '' ) ?>" id="cgParent1">
        <label class="col-sm-2 control-label" for="iParent1">Parent 1</label>
        <div class="col-sm-4">
            <input class="form-control" type="text" name="edparent1_display" id="iParent1_display" value="<?php echo $child->p1_firstname.' '.$child->p1_lastname ?>" disabled>
            <?php if($child->id_parent_1 > 0): ?>
                <span class="help-block" ><button class="btn btn-danger" id="btdelparent1"><i class="glyphicon glyphicon-remove"></i></button></span>                        
            <?php else: ?>
                <span class="help-block" >
                    <button class="btn btn-primary" id="btaddparent1">Séléctionner</button>
                </span>
            <?php endif; ?>
        </div>
    </div>
            
    <input type="hidden" name="edparent2" id="edparent2" value="<?php echo $child->id_parent_2 ?>" >
    <div class="form-group <?php echo (strlen(form_error('edparent2')) > 0 ? 'has-error' : '' ) ?>" id="cgParent2">
        <label class="col-sm-2 control-label" for="iParent2">Parent 2</label>
        <div class="col-sm-4">
            <input class="form-control" type="text" name="edparent2_display" id="iParent2_display" value="<?php echo $child->p2_firstname.' '.$child->p2_lastname ?>" disabled>

            <?php if($child->id_parent_2 > 0): ?>
                <span class="help-block" ><button class="btn btn-danger" id="btdelparent2"><i class="glyphicon glyphicon-remove"></i></button></span>                        
            <?php else: ?>
                <span class="help-block" >
                    <button class="btn btn-primary" id="btaddparent2">Séléctionner</button> 
                </span>
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
                echo form_dropdown('edgroup', $options, $child->id_group, 'class="form-control"');
            ?>
            <span class="help-block msg-validation-error" ><?php echo form_error('edgroup') ?></span>
        </div>
    </div>
    
    </div>
</div>
<!-- /Tab Child -->
     
<!-- Tab Info -->
<div class="row tab_content" id="tab_info" style="display:none">
    <div class="col-md-12">
        
    <div class="form-group <?php echo (strlen(form_error('edinstructions')) > 0 ? 'has-error' : '' ) ?>" id="cgInstructions">
        <label class="col-sm-2 control-label" for="iInstructions">Instructions</label>
        <div class="col-sm-4">
            <textarea class="form-control" rows="3" name="edinstructions" id="iInstructions" placeholder="Instructions diverses" ><?php echo $child->instructions ?></textarea>
        </div>  
    </div>  
        
    <div class="form-group <?php echo (strlen(form_error('eddisease')) > 0 ? 'has-error' : '' ) ?>" id="cgDisease">
        <label class="col-sm-2 control-label" for="iDisease">Maladies / alergies</label>
        <div class="col-sm-4">
            <textarea class="form-control" rows="3" name="eddisease" id="iInstructions" placeholder="Maladies ou alergies etc" ><?php echo $child->disease ?></textarea>
        </div>  
    </div>
        
    <div class="form-group <?php echo (strlen(form_error('edprohibited_food')) > 0 ? 'has-error' : '' ) ?>" id="cgProhibited_Food">
        <label class="col-sm-2 control-label" for="iProhibited_Food">Aliments proibés et similaire</label>
        <div class="col-sm-4">
            <textarea class="form-control" rows="3" name="edprohibited_food" id="iProhibited_Food" placeholder="Aliments proibés etc" ><?php echo $child->prohibited_food ?></textarea>
        </div>  
    </div>
        
    <div class="form-group <?php echo (strlen(form_error('edreligious_notice')) > 0 ? 'has-error' : '' ) ?>" id="cgReligious_notice">
        <label class="col-sm-2 control-label" for="iReligious_notice">Religion et culte</label>
        <div class="col-sm-4">
            <textarea class="form-control" rows="3" name="edreligious_notice" id="iReligious_notice" placeholder="Notices religieuses et lièes au culte" ><?php echo $child->religious_notice ?></textarea>
        </div>  
    </div>
        
        
        
    </div> 
</div>

    
<!-- /Tab Info -->

<!-- Tab Emergency -->
<div class="row tab_content" id="tab_emergency" style="display:none">
    <div class="col-md-12">
        
    <div class="form-group <?php echo (strlen(form_error('edmergency_persons')) > 0 ? 'has-error' : '' ) ?>" id="cgEmergency_persons">
        <label class="col-sm-2 control-label" for="iEmergency_persons">Nom et téléphone des personnes à contacter</label>
        <div class="col-sm-4">
            <textarea class="form-control" rows="3" name="edemergency_persons" id="iEmergency_persons" placeholder="Personnes à contacter" ><?php echo $child->emergency_persons ?></textarea>
        </div>  
    </div>
        
        
    </div> 
</div>

    
<!-- /Tab Emergency -->


<!-- Tab Authorisations -->
<div class="row tab_content" id="tab_authorisations" style="display:none">
    <div class="col-md-12">
        
    <div class="form-group">
        <label class="col-sm-2 control-label" >Pris en photo</label>
        <div class="col-sm-4">
            <label class="radio-inline">
                <input type="radio" name="edpicture_capture" value="1" <?php echo ($child->picture_capture == 1 ? 'checked="checked"' : '') ?>> Autorisé
            </label>
            <label class="radio-inline">
                <input type="radio" name="edpicture_capture" value="0" <?php echo ($child->picture_capture == 0 ? 'checked="checked"' : '') ?>> Non autorisé
            </label>
        </div>
    </div>
        
    <div class="form-group">
        <label class="col-sm-2 control-label" >Publier photo</label>
        <div class="col-sm-4">
            <label class="radio-inline">
                <input type="radio" name="edpicture_public" value="1" <?php echo ($child->picture_public == 1 ? 'checked="checked"' : '') ?>> Autorisé
            </label>
            <label class="radio-inline">
                <input type="radio" name="edpicture_public" value="0" <?php echo ($child->picture_public == 0 ? 'checked="checked"' : '') ?>> Non autorisé
            </label>
        </div>
    </div>
        
    <div class="form-group">
        <label class="col-sm-2 control-label" >Droit d'administrer des médicaments apportés par les parents</label>
        <div class="col-sm-4">
            <label class="radio-inline">
                <input type="radio" name="edparents_drugs_allowed" value="1" <?php echo ($child->parents_drugs_allowed == 1 ? 'checked="checked"' : '') ?>> Autorisé
            </label>
            <label class="radio-inline">
                <input type="radio" name="edparents_drugs_allowed" value="0" <?php echo ($child->parents_drugs_allowed == 0 ? 'checked="checked"' : '') ?>> Non autorisé
            </label>
        </div>
    </div>
        
    <div class="form-group <?php echo (strlen(form_error('eddrugs_list')) > 0 ? 'has-error' : '' ) ?>" id="cgDrugs_list">
        <label class="col-sm-2 control-label" for="iDrugs_list">Médicaments autorisés</label>
        <div class="col-sm-4">
            <textarea class="form-control" rows="3" name="eddrugs_list" id="iDrugs_list" placeholder="Médicaments autorisés" ><?php echo $child->drugs_list ?></textarea>
        </div>  
    </div>
        
        
    </div> 
</div>

    
<!-- /Tab Authorisations -->



<!-- Save buttons -->
<br />
<div class="row">
    <div class="col-md-12">
    <div class="form-group">
        <div class="col-xs-12 col-sm-offset-2 col-sm-4">
            <button type="submit" class="btn btn-primary" name="submitAdd" value="1" id="submit">Enregistrer</button>
            &nbsp;&nbsp;
            <a class="btn btn-danger" href="<?php echo (empty($link_back) ? sbase_url().'admin/children/' : sbase_url().$link_back ) ?>">Annuler</a>
        </div>
    </div>
     
    </div>
</div>

</form>

<!-- Section for trustees -->
<br />
<div class="row">
    <div class="col-md-12">
        <h3>Personnes autorisées à venir chercher l'enfant</h3>
    </div>
</div>


<?php
    if(!$trustees):
?>
    <div class="row">
        <div class="col-md-12">
            <div class="alert alert-info">
                <b>Info</b> : Actuellement aucune personne autorisée !
            </div>
        </div>
    </div>

<?php
    else:
?>

<div class="row">      
        <?php 
            foreach ($trustees as $trustee):
        ?>

    <div class="col-xs-12 col-sm-3 col-md-2">
        <div class="panel panel-default pull-left">
            
            <div class="panel-body">
                <div class="pull-right" style="position:absolute;"><a href="<?php echo sbase_url().'admin/children/deletetrustee/'.$trustee->id_child_trustee.'/'.$child->id_child ?>" class="btn btn-xs btn-danger btdelete_trustee" id="bttrusteedelete_<?php echo $trustee->id_child_trustee ?>"><i class="glyphicon glyphicon-remove"></i></a></div>
                <img src="<?php echo sbase_url() ?>admin/img/trustee/<?php echo $trustee->id_child_trustee ?>/profilepicture.jpg" alt="..." class="img-thumbnail" width="140" heigth="140">
            </div>
            <div class="panel-footer">
                <?php echo $trustee->name ?>
                <br />
                <span class="glyphicon glyphicon-phone"></span> <?php echo (strlen($trustee->mobile_phone) > 3 ? $trustee->mobile_phone : 'néant') ?><br />
                <span class="glyphicon glyphicon-phone-alt"></span> <?php echo (strlen($trustee->phone) > 3 ? $trustee->phone : 'néant') ?><br />
                <a href="<?php echo sbase_url().'admin/children/edittrustee/'.$trustee->id_child_trustee ?>" class="btn btn-default btn-xs">Editer</a>
                
            </div>
        </div>
    </div>
      
        <?php
            endforeach;
        ?>
</div>  



<?php
    endif;
?>

<div class="row">
    <div class="col-md-12">
        <button id="btshowpaneladdtrustee" class="btn btn-default btshowpanel" data-target="pannelAddTrustee" data-hide="btshowpaneladdtrustee">Ajouter une personne autorisée</button>
    </div>
</div>

<div class="panel panel-default" id="pannelAddTrustee" style="display:none">
    <div class="panel-heading panel-primary">Ajouter une personne autorisée</div>
    <div class="panel-body">

<?php 
    $attributes = array('class' => 'form-horizontal', 'id' => 'frm_trustee', 'role' => 'form');
    echo form_open_multipart('admin/children/edit/'.$child->id_child, $attributes);
?>

    <div class="form-group <?php echo (strlen(form_error('edtrustname')) > 0 ? 'has-error' : '' ) ?>" id="cgTrustname">
        <label class="col-sm-2 control-label" for="iTrustname">Nom</label>
        <div class="col-sm-4">
            <input class="form-control" type="text" name="edtrustname" id="iTrustname" placeholder="nom et prénom de la personne" value="<?php echo set_value('edtrustname'); ?>">
            <span class="help-block msg-required" style="display:none" >Champ obligatoire</span>
            <?php if(strlen(form_error('edtrustname')) > 0): ?>
                <span class="help-block"><?php echo form_error('edtrustname') ?></span>
            <?php endif; ?>
        </div>  
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="form-group <?php echo (strlen(form_error('edtrustpicture')) > 0 ? 'has-error' : '' ) ?>" id="cgTrustpicture">
                <label class="col-sm-2 control-label" for="iTrustpicture">Photo de la personne</label>
                <div class="col-sm-4">
                    <input type="file" name="edtrustpicture" id="iTrustpicture" >
                </div>  
        </div>
        </div>
    </div>

    <div class="form-group <?php echo (strlen(form_error('edmobilephone')) > 0 ? 'has-error' : '' ) ?>" id="cgMobilephone">
        <label class="col-sm-2 control-label" for="iMobilephone">Téléphone portable</label>
        <div class="col-sm-4">
            <input class="form-control" type="text" name="edmobilephone" id="iMobilephone" placeholder="numéro de portable" value="<?php echo set_value('edmobilephone'); ?>">
            <span class="help-block msg-required" style="display:none" >Champ obligatoire</span>
            <?php if(strlen(form_error('edtrustname')) > 0): ?>
                <span class="help-block"><?php echo form_error('edmobilephone') ?></span>
            <?php endif; ?>
        </div>  
    </div>

    <div class="form-group <?php echo (strlen(form_error('edphone')) > 0 ? 'has-error' : '' ) ?>" id="cgPhone">
        <label class="col-sm-2 control-label" for="iPhone">Téléphone</label>
        <div class="col-sm-4">
            <input class="form-control" type="text" name="edphone" id="iPhone" placeholder="numéro de téléphone fixe" value="<?php echo set_value('edphone'); ?>">
            <span class="help-block msg-required" style="display:none" >Champ obligatoire</span>
            <?php if(strlen(form_error('edphone')) > 0): ?>
                <span class="help-block"><?php echo form_error('edphone') ?></span>
            <?php endif; ?>
        </div>  
    </div>

    <!-- Save buttons -->
    <br />
    <div class="row">
        <div class="col-md-12">
        <div class="form-group">
            <div class="col-xs-12 col-sm-offset-2 col-sm-4">
                <button type="submit" class="btn btn-primary" name="submitAddTrustee" value="1" id="submitAddTrustee">Enregistrer</button>
                &nbsp;&nbsp;
                <button class="btn btn-danger btshowpanel" data-target="btshowpaneladdtrustee" data-hide="pannelAddTrustee" >Annuler</a>
            </div>
        </div>

        </div>
    </div>

</form>

    </div>
</div>
<!-- /Section for trustees -->

<!-- Section for documents -->
<br />
<div class="row">
    <div class="col-md-12">
        <h3>Documents liés à l'enfant</h3>
    </div>
</div>


<?php
    if(!$documents):
?>
    <div class="row">
        <div class="col-md-12">
            <div class="alert alert-info">
                <b>Info</b> : Actuellement aucun document disponible !
            </div>
        </div>
    </div>

<?php
    else:
?>

 
        <?php 
            $count = 0;
            $n = 0;
            foreach ($documents as $document):
                ++$count;
                ++$n;
                if($count == 1 ):
        ?>
            <div class="row">  
        <?php 
            endif;
        ?>
   
    <div class="col-xs-12 col-sm-6 col-md-3">
        <div class="panel panel-default">
            
            <div class="panel-heading">
                <?php echo $document->docname ?>
            </div>
            
            <div class="panel-body">
                <?php
                    if(!empty($document->description))
                        echo $document->description.'<br />';
                ?>
                <a href="<?php echo sbase_url().'admin/viewfile/document/'.$document->id_child_document ?>"><i class="glyphicon glyphicon-download"></i> Télécharger le document</a>
            </div>
            <div class="panel-footer ">
                <a href="<?php echo sbase_url().'admin/children/deletedocument/'.$document->id_child_document.'/'.$child->id_child ?>" class="btn btn-xs btn-danger btdelete_document pull-right" id="btdocumentdelete_<?php echo $document->id_child_document ?>"><i class="glyphicon glyphicon-remove"></i></a>
                Ajouté le, <?php echo date_format(new DateTime($document->date_add),'d/m/Y') ?><br />
                <a href="<?php echo sbase_url().'admin/children/editdocument/'.$document->id_child_document ?>" class="btn btn-default btn-xs">Editer</a>
            </div>
        </div>
    </div>
        <?php        
                if($count == 4 || $n == count($documents)):
                    $count = 0;
        ?>
            </div>
        <?php 
            endif;
        ?>
            
        <?php
            endforeach;
        ?>
   

<?php
    endif;
?>

<div class="row">
    <div class="col-md-12">
        <button id="btshowpaneladddocument" class="btn btn-default btshowpanel" data-target="pannelAddDocument" data-hide="btshowpaneladddocument">Ajouter un document</button>
    </div>
</div>

<div class="panel panel-default" id="pannelAddDocument" style="display:none">
    <div class="panel-heading panel-primary">Ajouter un document</div>
    <div class="panel-body">

<?php 
    $attributes = array('class' => 'form-horizontal', 'id' => 'frm_documents', 'role' => 'form');
    echo form_open_multipart('admin/children/edit/'.$child->id_child, $attributes);
?>

    <div class="form-group <?php echo (strlen(form_error('eddocname')) > 0 ? 'has-error' : '' ) ?>" id="cgDocname">
        <label class="col-sm-2 control-label" for="iDocname">Libellé</label>
        <div class="col-sm-4">
            <input class="form-control" type="text" name="eddocname" id="iDocname" placeholder="ibellé du document" value="<?php echo set_value('eddocname'); ?>">
            <span class="help-block msg-required" style="display:none" >Champ obligatoire</span>
            <?php if(strlen(form_error('eddocname')) > 0): ?>
                <span class="help-block"><?php echo form_error('eddocname') ?></span>
            <?php endif; ?>
        </div>  
    </div>
        
    <div class="form-group <?php echo (strlen(form_error('eddocdescription')) > 0 ? 'has-error' : '' ) ?>" id="cgDocdescription">
        <label class="col-sm-2 control-label" for="iDocdescription">Description</label>
        <div class="col-sm-4">
            <textarea class="form-control" rows="3" name="eddocdescription" id="iDocdescription" placeholder="notice au sujet du document" ><?php echo set_value('eddocdescription'); ?></textarea>
        </div>  
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="form-group <?php echo (strlen(form_error('eddocfile')) > 0 ? 'has-error' : '' ) ?>" id="cgDocfile">
                <label class="col-sm-2 control-label" for="iDocfile">Fichier</label>
                <div class="col-sm-4">
                    <input type="file" name="eddocfile" id="iDocfile" >
                    <span class="help-block msg-required" style="display:none" >Champ obligatoire</span>
                    <?php if(strlen(form_error('eddocfile')) > 0): ?>
                        <span class="help-block"><?php echo form_error('eddocfile') ?></span>
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
                <button type="submit" class="btn btn-primary" name="submitAddDocument" value="1" id="submitAddDocument">Enregistrer</button>
                &nbsp;&nbsp;
                <button class="btn btn-danger btshowpanel" data-target="btshowpaneladddocument" data-hide="pannelAddDocument" >Annuler</a>
            </div>
        </div>

        </div>
    </div>

</form>

    </div>
</div>
<!-- /Section for documents -->