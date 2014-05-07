<div class="col-xs-12">
    <h4 class="panel-title text-right">
        <a data-toggle="collapse" data-parent="#accordion" href="#collapse<?= $post->ID; ?>">Produktionsdetails</a>
    </h4>
    <div id="collapse<?= $post->ID; ?>" class="panel-collapse collapse">
        <div class="panel-body">
            <?php
            // CONTENT BELOW MORE TAG
            the_content('', TRUE, '');
            ?>
        </div>
        <div class="termine">
            <?php global $events; foreach($events as $event): ?>
                <div class="row">
                    <div class="col-xs-4 paddR0"><p><?= strftime('<span class="bb">%a %d.</span> %B %Y %H:%M', date($event->meta_value)); ?></p></div>
                    <div class="col-xs-8 paddL0">
                        <div class="col-xs-4 paddLR0"><p><span class="bb"><?= get_free_seats($id, $event->meta_key) ?></span> freie Plätze</p></div>
                        <div class="col-xs-8 paddL0 ticket"><p><!--<a href="#" data-eventID="<?/*= $event->meta_id */?>">Tickets reservieren</a>--></p></div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

</div>