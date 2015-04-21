<!-- groups_list -->
<?php if(!$groups): ?>

<div class="row">
    <div class="col-md-12">
        <div class="alert alert-info">
            <b>Info</b> : Actuellement aucun groupe n'est défini !
        </div>
    </div>
</div>

<?php else: ?>

<div class="row">
    <div class="col-md-12">
        <ul class="desktop_container">
        <?php
            foreach ($groups as $group):
        ?>
            <li>
                <div id="desktop_groups">
                    <h4><?php echo $group->name ?></h4>
                    <ul>
                        <li>Enfants : <?php echo $group->children_count ?></li>
                    </ul>
                    <br /><br />
                    <p class="button-p"><a href="<?php echo sbase_url() ?>admin/desktop/viewgroup/<?php echo $group->id_child_group ?>" class="btn btn-primary">Visualiser</a></p>
                    <p class="button-p"><a href="<?php echo sbase_url() ?>admin/groups/viewjournal/<?php echo $group->id_child_group ?>" class="btn btn-default">Journal</a></p>
                </div>
            </li>    
        <?php
            endforeach;
        ?>
        </ul> 
    </div>
</div>

<?php endif; ?>