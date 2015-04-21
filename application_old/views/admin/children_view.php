<!-- children_view -->

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
        <div class="col-md-12 profile-view">
            <?php if(_cr('children', 'e')): ?><a href="<?php echo sbase_url().'admin/children/edit/'.$child->id_child ?>" class="btn btn-default pull-right">Editer</a><?php endif; ?>
            <a href="<?php echo (empty($link_back) ? sbase_url().'admin/children/' : $link_back ) ?>" class="btn btn-default pull-right">Retour</a>
            <div class="main-header">
                <h2>Enfant</h2>Vue profile
            </div>
            
        </div>
    </div>

<div class="row">
    <div class="col-md-12">
       <ul class="nav nav-pills" id="nav_tab">
           <li class="active" id="view_nav_tab_child"><a href="#" >Profile</a></li>
           <li id="view_nav_tab_info"><a href="#" >Instructions</a></li>
           <li id="view_nav_tab_authorisations"><a href="#">Autorisations</a></li>
           <li id="view_nav_tab_emergency"><a href="#">En cas d'urgence</a></li>
           <li id="view_nav_tab_trustees"><a href="#">Personnes autorisées</a></li>
           <li id="view_nav_tab_documents"><a href="#">Documents</a></li>
       </ul>
    </div>
</div>

<div class="profile-view">
    <div class="profile-page">
<!-- Begin of tab -->
<div class="tab_content" id="tab_child">
    
    <div class="row">
        <div class="col-md-3">
            <div class="profile-info-left">
            <img src="<?php echo getProfileLink($child->id_child) ?>" alt="..." class="img-thumbnail" width="140" heigth="140">
            <h3><?php echo $child->lastname.' '.$child->firstname ?></h3>
            </div>
        </div>
        <div class="col-md-9">
            <div class="profile-info-right">
                <div class="info-section">
                    <h4><span class="glyphicon glyphicon-stop"></span>&nbsp;Informations</h4>
                </div>
                
                <div class="row data-row">
                    <div class="col-xs-3 data-name">Numéro social</div>
                    <div class="col-xs-9 data-value"><?php echo $child->socialid ?></div>
                </div>
                <div class="row data-row">
                    <div class="col-xs-3 data-name">Date naissance</div>
                    <div class="col-xs-9 data-value"><?php echo $child->birthdate ?></div>
                </div>
                <?php
                    $date1 = new DateTime( $child->birthdate );
					$date2 = new DateTime( date('Y-m-d') );
					$age = date_diff($date2, $date1);
					$agemois = $age->y*12 + $age->m;
                ?>
                <div class="row data-row">
                    <div class="col-xs-3 data-name">Age</div>
                    <div class="col-xs-9 data-value"><?php echo ($age->y == 1 ? $age->y.' an': '') . ($age->y > 1 ? $age->y.' ans': '') .' '. ($age->m > 0 ? $age->m.' mois': '') ?></div>
                </div>
                <div class="row data-row">
                    <div class="col-xs-3 data-name">Genre</div>
                    <div class="col-xs-9 data-value"><?php echo ($child->gender == 1 ? 'Garçon' : 'Fille') ?></div>
                </div>
                <div class="row data-row">
                    <div class="col-xs-3 data-name">Nationalitée</div>
                    <div class="col-xs-9 data-value"><?php echo $child->citizenship ?></div>
                </div>
                
                
                <div class="info-section">
                    <h4><span class="glyphicon glyphicon-stop"></span>&nbsp;Parents</h4>
                </div>
                <?php
                    if($parents):
                    foreach ($parents as $p):
                ?>
                    <div class="row data-row">
                        <div class="col-xs-3 data-name">Nom et prénom</div>
                        <div class="col-xs-9 data-value"><strong><?php echo $p->lastname.' '.$p->firstname ?></strong></div>
                    </div>
                    <?php if(!empty($p->email)): ?>
                    <div class="row data-row">
                        <div class="col-xs-3 data-name">Email</div>
                        <div class="col-xs-9 data-value"><?php echo $p->email ?></div>
                    </div>
                    <?php endif; ?>
                    <?php if(!empty($p->mobile)): ?>
                    <div class="row data-row">
                        <div class="col-xs-3 data-name">Mobile</div>
                        <div class="col-xs-9 data-value"><?php echo $p->mobile ?></div>
                    </div>
                    <?php endif; ?>
                    <?php if(!empty($p->phone_home)): ?>
                    <div class="row data-row">
                        <div class="col-xs-3 data-name">Tél. domicile</div>
                        <div class="col-xs-9 data-value"><?php echo $p->phone_home ?></div>
                    </div>
                    <?php endif; ?>
                    <?php if(!empty($p->phone_work)): ?>
                    <div class="row data-row">
                        <div class="col-xs-3 data-name">Tél. travail</div>
                        <div class="col-xs-9 data-value"><?php echo $p->phone_work ?></div>
                    </div>
                    <?php endif; ?>
                    <br />
                    <?php if(!empty($p->address)): ?>
                    <div class="row data-row">
                        <div class="col-xs-3 data-name">Adresse</div>
                        <div class="col-xs-9 data-value"><?php echo $p->address ?></div>
                    </div>
                    <div class="row data-row">
                        <div class="col-xs-3 data-name">Localité</div>
                        <div class="col-xs-9 data-value"><?php echo $p->city ?></div>
                    </div>
                    <div class="row data-row">
                        <div class="col-xs-3 data-name">Code postal</div>
                        <div class="col-xs-9 data-value"><?php echo $p->code ?></div>
                    </div>
                    <div class="row data-row">
                        <div class="col-xs-3 data-name">Pays</div>
                        <div class="col-xs-9 data-value"><?php echo $p->country_iso ?></div>
                    </div>
                    <?php endif; ?>
                    <br />
                <?php
                    endforeach;
                    else:
                ?>
                    <div class="alert alert-warning" role="alert">Pas de parents assignés</div>
                <?php
                    endif;
                ?>
                
                
            </div>
        </div>
    </div>
    
    
</div>
<!-- End of tab -->
 
<!-- Begin of tab -->
<div class="tab_content" id="tab_info" style="display:none">
    <div class="row">
        <div class="col-md-12">
            <div class="profile-info-right">
                <div class="info-section">
                    <h4><span class="glyphicon glyphicon-stop"></span>&nbsp;Instructions</h4>
                </div>
                <div class="row data-row-double">
                    <div class="col-xs-3 data-name">Instructions</div>
                    <div class="col-xs-9 data-value"><?php echo $child->instructions ?></div>
                </div>
                
                <div class="row data-row-double">
                    <div class="col-xs-3 data-name">Maladies / alergies</div>
                    <div class="col-xs-9 data-value"><?php echo $child->disease ?></div>
                </div>
                
                <div class="row data-row-double">
                    <div class="col-xs-3 data-name">Aliments proibés ou similaire</div>
                    <div class="col-xs-9 data-value"><?php echo $child->prohibited_food ?></div>
                </div>
                
                <div class="row data-row-double">
                    <div class="col-xs-3 data-name">Religion et culte</div>
                    <div class="col-xs-9 data-value"><?php echo $child->religious_notice ?></div>
                </div>
                
            </div>
        </div>
    </div>
</div>
<!-- End of tab -->


<!-- Begin of tab -->
<div class="tab_content" id="tab_authorisations" style="display:none">
    <div class="row">
        <div class="col-md-12">
            <div class="profile-info-right">
                <div class="info-section">
                    <h4><span class="glyphicon glyphicon-stop"></span>&nbsp;Autorisations</h4>
                </div>
                <div class="row data-row-double">
                    <div class="col-xs-3 data-name">Prise en photo</div>
                    <div class="col-xs-9 data-value"><?php if($child->picture_capture): ?><span class="glyphicon glyphicon-ok"></span><?php else: ?><span class="glyphicon glyphicon-remove"></span><?php endif; ?></div>
                </div>
                
                <div class="row data-row-double">
                    <div class="col-xs-3 data-name">Publier photo</div>
                    <div class="col-xs-9 data-value"><?php if($child->picture_public): ?><span class="glyphicon glyphicon-ok"></span><?php else: ?><span class="glyphicon glyphicon-remove"></span><?php endif; ?></div>
                </div>
                
                <div class="row data-row-double">
                    <div class="col-xs-3 data-name">Droit d'administrer des médicaments apportés par les parents</div>
                    <div class="col-xs-9 data-value"><?php if($child->parents_drugs_allowed): ?><span class="glyphicon glyphicon-ok"></span><?php else: ?><span class="glyphicon glyphicon-remove"></span><?php endif; ?></div>
                </div>
                
                <div class="row data-row-double">
                    <div class="col-xs-3 data-name">Médicaments</div>
                    <div class="col-xs-9 data-value"><?php echo $child->drugs_list ?></div>
                </div>
                
            </div>
        </div>
    </div>
</div>
<!-- End of tab -->



<!-- Begin of tab -->
<div class="tab_content" id="tab_emergency" style="display:none">
    <div class="row">
        <div class="col-md-12">
            <div class="profile-info-right">
                <div class="info-section">
                    <h4><span class="glyphicon glyphicon-stop"></span>&nbsp;En cas d'urgence</h4>
                </div>
                
                <div class="row data-row-double">
                    <div class="col-xs-3 data-name">Nom et téléphone des personnes à contacter</div>
                    <div class="col-xs-9 data-value"><?php echo $child->emergency_persons ?></div>
                </div>
                
            </div>
        </div>
    </div>
</div>
<!-- End of tab -->

<!-- Begin of tab -->
<div class="tab_content" id="tab_trustees" style="display:none">
    
                
                
                <?php
                    if($trustees):
                    foreach ($trustees as $t):
                ?>
                
                <div class="row" >
                    <!-- left side -->
                    <div class="col-md-3">
                        <div class="profile-info-left">
            
                        <img src="<?php echo sbase_url() ?>admin/img/trustee/<?php echo $t->id_child_trustee ?>/profilepicture.jpg" alt="..." class="img-thumbnail" width="140" heigth="140">
                        <h3><?php echo $t->name ?></h3>
                        
                        </div>
                    </div>
                    
                    <!-- right side -->
                    <div class="col-md-9">
                        <div class="profile-info-right">
                
                    <div class="info-section">
                        <h4><span class="glyphicon glyphicon-stop"></span>&nbsp;Contact</h4>
                    </div>
                
                    <div class="row data-row">
                        <div class="col-xs-3 data-name">Mobile</div>
                        <div class="col-xs-9 data-value"><?php echo $t->mobile_phone ?></div>
                    </div>

                    <div class="row data-row">
                        <div class="col-xs-3 data-name">Téléphone</div>
                        <div class="col-xs-9 data-value"><?php echo $t->phone ?></div>
                    </div>
                    
                    <div class="hidden-xs hidden-sm">
                    <br />
                    <br />
                    <br />
                    <br />
                    <br />
                    </div>

                    
                        </div>
                    </div>
                </div>   
                <div class="clearfix"><br /><br /></div>
                    
                <?php
                    endforeach;
                    else:
                ?>
                    <div class="alert alert-warning" role="alert">Pas de personnes autorisées</div>
                <?php
                    endif;
                ?>
                

    
</div>
<!-- End of tab -->

<!-- Begin of tab -->
<div class="tab_content" id="tab_documents" style="display:none">
                <?php
                    if($documents):
                    foreach ($documents as $d):
                ?>
                
                <div class="row" >
                    <!-- left side -->
                    <div class="col-md-3">
                        <div class="profile-info-left">
                            <a href="<?php echo sbase_url().'admin/viewfile/document/'.$d->id_child_document ?>">
                                <?php
                                    if(stripos($d->mime, 'pdf') !== false):
                                ?>
                                    <img src="<?php echo sbase_url() ?>assets/img/pdf-icon.png" alt="..." class="img-thumbnail" width="140" heigth="140">
                                <?php
                                    else:
                                ?>
                                    <img src="<?php echo sbase_url() .'admin/viewfile/document_img/'.$d->id_child_document ?>" alt="..." class="img-thumbnail" width="140" heigth="140">
                                <?php
                                    endif;
                                ?>
                                
                            </a>
                        <h5><?php echo $d->docname ?></h5>
                        
                        </div>
                    </div>
                    
                    <!-- right side -->
                    <div class="col-md-9">
                        <div class="profile-info-right">
                
                    <div class="info-section">
                        <h4><span class="glyphicon glyphicon-stop"></span>&nbsp;Infos document</h4>
                    </div>
                
                    <div class="row data-row">
                        <div class="col-xs-3 data-name">Nom</div>
                        <div class="col-xs-9 data-value"><?php echo $d->docname ?></div>
                    </div>

                    <div class="row data-row">
                        <div class="col-xs-3 data-name">Description</div>
                        <div class="col-xs-9 data-value"><?php echo $d->description ?></div>
                    </div>
                           
                    <div class="row data-row">
                        <div class="col-xs-3 data-name">Date dérnière mise à jour</div>
                        <div class="col-xs-9 data-value"><?php echo $d->date_upd ?></div>
                    </div>
                    
                    <div class="hidden-xs hidden-sm">
                    <br />
                    <br />
                    <br />
                    </div>

                    
                        </div>
                    </div>
                </div>   
                <div class="clearfix"><br /><br /></div>
                    
                <?php
                    endforeach;
                    else:
                ?>
                    <div class="alert alert-warning" role="alert">Pas de documents</div>
                <?php
                    endif;
                ?>
</div>
<!-- End of tab -->



    </div>
</div>
            
     
    

