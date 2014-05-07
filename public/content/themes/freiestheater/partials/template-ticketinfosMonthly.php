
<?php $fields = (object) get_fields();?>
<?php global $events;?>
<?php if($fields->eintritt): ?>
    <div class="col-xs-3 col-sm-3 col-md-2 paddR0">
        <span class="ticket-symbol"></span>
    </div>
    <div class="col-xs-8">
        <p>
            <span class="bb"><?= $fields->eintritt ?></span> <?= $fields->text_eintritt ?>
            <?php if($fields->ermaessigt): ?>
                <span class="bb"><?= $fields->ermaessigt ?></span> <?= $fields->text_ermaessigt ?>
            <?php endif; ?>
            <br><span class="bb"><?= get_free_seats($id, $events[0]->meta_key) ?></span> freie Plätze
        </p>
    </div>
<?php endif; ?>
