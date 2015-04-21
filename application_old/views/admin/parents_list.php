<!-- groups_list -->
<div class="row">
    <div class="col-md-12">
        <h2 class="pull-left">Parents</h2>
        <?php if(_cr('parents', 'c')): ?>
        <span class="pull-right"><a class="btn btn-default" href="<?php echo sbase_url() ?>admin/parents/add">Ajouter un parent</a></span>
        <?php endif; ?>
    </div>
</div>

<?php if(!$parents): ?>

<div class="row">
    <div class="col-md-12">&nbsp;
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="alert alert-info">
            <b>Info</b> : Actuellement aucun parent ne fut ajouté !
        </div>
    </div>
</div>

<?php else: ?>

<div class="row">
    <div class="col-md-12">
        
    <div class="table-responsive">
    <table class="table table-striped">
        <thead>
            <th>Nom</th>
            <th>Prénom</th>
            <th>Numéro social</th>
            <th>Tel. Mobile</th>
            <th class="visible-sm visible-md visible-lg">Email</th>
            <th class="hidden-xs hidden-sm">Localité</th>
            <th class="hidden-xs">Enfants</th>
            <th></th>
        </thead>
        <tbody>
            <?php  
                foreach ($parents as $parent):
            ?>
                <tr>
                    <td><?php echo $parent->lastname ?></td>
                    <td><?php echo $parent->firstname ?></td>
                    <td><?php echo $parent->socialid ?></td>
                    <td><?php echo $parent->mobile ?></td>
                    <td class="visible-sm visible-md visible-lg"><?php echo $parent->email ?></td>
                    <td class="hidden-xs hidden-sm"><?php echo $parent->city ?></td>
                    <td class="hidden-xs"><?php echo $parent->count_childs ?></td>
                    <td>
                        <div class="btn-group ">
                            <a type="button" class="btn btn-danger" href="<?php echo sbase_url() ?>admin/parents/view/<?php echo $parent->id_parent ?>"><span class="glyphicon glyphicon-zoom-in"></span></a>
                            <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown"><span class="caret"></span></button>
                            <ul class="dropdown-menu dropdown-menu-right" role="menu">
                                <?php if(_cr('parents', 'e')): ?><li><a href="<?php echo sbase_url() ?>admin/parents/edit/<?php echo $parent->id_parent ?>">Editer</a></li><?php endif; ?>
                                <?php if(_cr('parents', 'd')): ?><li><a href="<?php echo sbase_url() ?>admin/parents/delete/<?php echo $parent->id_parent ?>" class="btdelete_parent"><i class="icon-trash"></i> Supprimer</a></a></li><?php endif; ?>
                            </ul>
                        </div>
                    </td>
                </tr>
            <?php
                endforeach;
            ?>
        </tbody>
    </table>
    </div>
        
    </div>
    
</div>


<!-- Listing footer -->
    <div class="row">
        <div class="col-md-12">
            
        <span class="label label-info">Total : <?php echo $parents_count ?></span>
 <?php 
    if(!empty($p) && !empty($parents_count) && $parents_count > $this->config->item('results_per_page_default')):
        $pages = ceil($parents_count / $this->config->item('results_per_page_default'));
?>           
        <!-- pagination -->    
        <ul class="pagination pagination-sm pull-right">
            <?php
                if($p > 1):
            ?>
                <li><a href="<?php echo sbase_url() ?>admin/parents/?p=<?php echo $p - 1  ?>&n=<?php echo $this->config->item('results_per_page_default') ?>">&laquo;</a></li>
            <?php
                endif;
            ?>
            <?php
              for ($i = 1; $i <= $pages ; $i++):
            ?>
              <li class="<?php echo (!empty($p) && $p == $i ? 'active' : '') ?>"><a  href="<?php echo sbase_url() ?>admin/parents/?p=<?php echo $i ?>&n=<?php echo $this->config->item('results_per_page_default') ?>"><?php echo $i ?></a></li>
            <?php
              endfor;
            ?>
            <?php
                if($p < $pages):
            ?>
                <li><a href="<?php echo sbase_url() ?>admin/parents/?p=<?php echo $p + 1  ?>&n=<?php echo $this->config->item('results_per_page_default') ?>">&raquo;</a></li>
            <?php
                endif;
            ?>
        </ul>
<?php
    endif;
?>
        </div>
    </div>
<!-- /Listing footer -->


<?php endif; ?>