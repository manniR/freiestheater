<div class="col-xs-12">
		<?php global $events; ?>
    <h4 class="panel-title text-right">
        <a data-toggle="collapse" data-parent="#accordion" href="#collapse<?= $events[0]->meta_id; ?>">Produktionsdetails</a>
    </h4>
    <div id="collapse<?= $events[0]->meta_id; ?>" class="panel-collapse collapse">
        <div class="panel-body">
            <?php
            // CONTENT BELOW MORE TAG
            the_content('', TRUE, '');
            ?>
        </div>

    </div>

</div>