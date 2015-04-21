<!-- parents_edit -->

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
            <a href="<?php echo (empty($link_back) ? sbase_url().'admin/parents/' : sbase_url().$link_back ) ?>" class="btn btn-default pull-right">Retour</a>
            <h3>Editer le parent : <?php echo $parent->lastname.' '.$parent->firstname ?></h3>
        </div>
    </div>
   

    <div class="row">
        <div class="col-md-12">
            
    <?php 
        $attributes = array('class' => 'form-horizontal', 'id' => 'frm_edit');
        echo form_open('admin/parents/edit/'.$parent->id_parent,$attributes);
    ?>
        <input type="hidden" name="id" id="id" value="<?php echo $parent->id_parent ?>" >
            
        <div class="form-group <?php echo (strlen(form_error('edlastname')) > 0 ? 'has-error' : '' ) ?>" id="cgLastname">
            <label class="col-sm-2 control-label" for="iLastname">Nom</label>
            <div class="col-sm-4">
                <input class="form-control" type="text" name="edlastname" id="iLastname" placeholder="nom du parent" value="<?php echo $parent->lastname ?>">
                <span class="help-block msg-required" style="display:none" >Champ obligatoire</span>
                <?php if(strlen(form_error('edlastname')) > 0): ?>
                    <span class="help-block"><?php echo form_error('edlastname') ?></span>
                <?php endif; ?>
            </div>

        </div>
        <div class="form-group <?php echo (strlen(form_error('edfirstname')) > 0 ? 'has-error' : '' ) ?>" id="cgFirstname">
            <label class="col-sm-2 control-label" for="iFirstname">Prénom</label>
            <div class="col-sm-4">
                <input class="form-control" type="text" name="edfirstname" id="iFirstname" placeholder="prénom du parent" value="<?php echo $parent->firstname ?>">
                <span class="help-block msg-required" style="display:none">Champ obligatoire</span>
                <?php if(strlen(form_error('edfirstname')) > 0): ?>
                    <span class="help-block"><?php echo form_error('edfirstname') ?></span>
                <?php endif; ?>
            </div>

        </div>
        <div class="form-group <?php echo (strlen(form_error('edsocialid')) > 0 ? 'has-error' : '' ) ?>" id="cgSocialid">
            <label class="col-sm-2 control-label" for="iSocialid">Numéro social</label>
            <div class="col-sm-4">
                <input class="form-control" type="text" name="edsocialid" id="iSocialid" placeholder="numéro social" value="<?php echo $parent->socialid ?>">
                <span class="help-block msg-required" style="display:none" >Champ obligatoire</span>
                <span class="help-block msg-exists" style="display:none">Erreur : Ce numéro est déjà attribuée</span>
                <?php if(strlen(form_error('edsocialid')) > 0): ?>
                    <span class="help-block"><?php echo form_error('edsocialid') ?></span>
                <?php endif; ?>
            </div>

        </div>
        <div class="form-group <?php echo (strlen(form_error('edemail')) > 0 ? 'has-error' : '' ) ?>" id="cgEmail">
            <label class="col-sm-2 control-label" for="iEmail">Email</label>
            <div class="col-sm-4">
                <input class="form-control" type="text" name="edemail" id="iEmail" placeholder="email du parent" value="<?php echo $parent->email ?>">
                <span class="help-block msg-required" style="display:none">Champ obligatoire</span>
                <span class="help-block msg-exists" style="display:none">Erreur : Cette adresse email est déjà attribuée</span>
                <?php if(strlen(form_error('edemail')) > 0): ?>
                    <span class="help-block"><?php echo form_error('edemail') ?></span>
                <?php endif; ?>
            </div>

        </div>

        <div class="form-group <?php echo (strlen(form_error('edmobile')) > 0 ? 'has-error' : '' ) ?>" id="cgMobile">
            <label class="col-sm-2 control-label" for="iMobile">Tél. mobile</label>
            <div class="col-sm-4">
                <input class="form-control" type="text" name="edmobile" id="iMobile" placeholder="téléphone mobile" value="<?php echo $parent->mobile ?>">
                <?php if(strlen(form_error('edmobile')) > 0): ?>
                    <span class="help-block"><?php echo form_error('edmobile') ?></span>
                <?php endif; ?>
            </div>

        </div>

        <div class="form-group <?php echo (strlen(form_error('edphonehome')) > 0 ? 'has-error' : '' ) ?>" id="cgPhonehome">
            <label class="col-sm-2 control-label" for="iPhonehome">Tél. du domicile</label>
            <div class="col-sm-4">
                <input class="form-control" type="text" name="edphonehome" id="iPhonehome" placeholder="téléphone du domicile" value="<?php echo $parent->phone_home ?>">
                <?php if(strlen(form_error('edphonehome')) > 0): ?>
                    <span class="help-block"><?php echo form_error('edphonehome') ?></span>
                <?php endif; ?>
            </div>

        </div>

        <div class="form-group <?php echo (strlen(form_error('edphonework')) > 0 ? 'has-error' : '' ) ?>" id="cgPhonework">
            <label class="col-sm-2 control-label" for="iPhonework">Tél. au travail</label>
            <div class="col-sm-4">
                <input class="form-control" type="text" name="edphonework" id="iPhonework" placeholder="téléphone au travail" value="<?php echo $parent->phone_work ?>">
                <?php if(strlen(form_error('edphonework')) > 0): ?>
                    <span class="help-block"><?php echo form_error('edphonework') ?></span>
                <?php endif; ?>
            </div>

        </div>

        <div class="form-group <?php echo (strlen(form_error('edaddress')) > 0 ? 'has-error' : '' ) ?>" id="cgAddress">
            <label class="col-sm-2 control-label" for="iAddress">Adresse</label>
            <div class="col-sm-4">
                <input class="form-control" type="text" name="edaddress" id="iAddress" placeholder="rue et numéro" value="<?php echo $parent->address ?>">
                <?php if(strlen(form_error('edaddress')) > 0): ?>
                    <span class="help-block"><?php echo form_error('edaddress') ?></span>
                <?php endif; ?>
            </div>

        </div>
        <div class="form-group <?php echo (strlen(form_error('edcity')) > 0 ? 'has-error' : '' ) ?>" id="cgCity">
            <label class="col-sm-2 control-label" for="iCity">Localité</label>
            <div class="col-sm-4">
                <input class="form-control" type="text" name="edcity" id="iCity" placeholder="localité" value="<?php echo $parent->city ?>">
                <?php if(strlen(form_error('edcity')) > 0): ?>
                    <span class="help-block"><?php echo form_error('edcity') ?></span>
                <?php endif; ?>
            </div>

        </div>
        <div class="form-group <?php echo (strlen(form_error('edcode')) > 0 ? 'has-error' : '' ) ?>" id="cgCode">
            <label class="col-sm-2 control-label" for="iCode">Code postal</label>
            <div class="col-sm-4">
                <input class="form-control" type="text" name="edcode" id="iCode" placeholder="code postal" value="<?php echo $parent->code ?>">
                <?php if(strlen(form_error('edcode')) > 0): ?>
                    <span class="help-block"><?php echo form_error('edcode') ?></span>
                <?php endif; ?>
            </div>

        </div>
        <div class="form-group <?php echo (strlen(form_error('edcountry')) > 0 ? 'has-error' : '' ) ?>" >
            <label class="col-sm-2 control-label" for="iCountry">Pays</label>
            <div class="col-sm-4">
                <?php 
                    $options = array(
                        'lu' => 'Luxembourg'
                    );

                    echo form_dropdown('edcountry', $options, $parent->country_iso, 'class="form-control"');
                ?>
                <span class="help-block msg-validation-error" ><?php echo form_error('edcountry') ?></span>
            </div>
        </div>
        
        <div class="form-group <?php echo (strlen(form_error('edlanguage')) > 0 ? 'has-error' : '' ) ?>" id="cgLanguage">
            <label class="col-sm-2 control-label" for="iLanguage">Langue(s) parlée(s)</label>
            <div class="col-sm-4">
                <textarea class="form-control" rows="3" name="edlanguage" id="iLanguage" placeholder="Exemple: FR, DE, PT" ><?php echo $parent->language ?></textarea>
            </div>  
        </div>

        <div class="form-group <?php echo (strlen(form_error('edsite')) > 0 ? 'has-error' : '' ) ?>" >
            <label class="col-sm-2 control-label" for="iSite">Site par défaut</label>
            <div class="col-sm-4">
                <?php 
                    $options = array();
                    foreach ($sites as $site) {
                        $options[$site->id_site] = $site->name;
                    }
                    echo form_dropdown('edsite', $options, $parent->id_site_default, 'class="form-control"');
                ?>
                <span class="help-block msg-validation-error" ><?php echo form_error('edsite') ?></span>
            </div>
        </div>



    <!-- Save buttons -->
    <br />
    <div class="row">
        <div class="col-md-12">
        <div class="form-group">
            <div class="col-xs-12 col-sm-offset-2 col-sm-4">
                <button type="submit" class="btn btn-primary" name="submitAdd" id="submitAdd">Enregistrer</button>
                &nbsp;&nbsp;
                <a class="btn btn-danger" href="<?php echo (empty($link_back) ? sbase_url().'admin/parents/' : sbase_url().$link_back ) ?>">Annuler</a>
            </div>
        </div>

        </div>
    </div>
        
        
        
        </form>
        

    </div>
</div>
