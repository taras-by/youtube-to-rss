<?php

/**
 * @var $exception Throwable
 */

$meta_title = '500. Something went wrong';

?>
<div class="text-center mb-5">
    <div class="display-1">500</div>
    <div class="display-4">Something went wrong</div>
</div>

<?php if (getenv('APP_ENV') == 'DEV') { ?>
    <div class="card">
        <?php if ($exception->getMessage()) { ?>
            <div class="card-header lead">
                Message: <?= $exception->getMessage() ?>
            </div>
        <?php } ?>
        <div class="card-body">
            <div>Error in <?= $exception->getFile() ?>:<?= $exception->getLine() ?> </div>
            <div>Exception class: <?= get_class($exception) ?></div>
            <pre class="mb-0"><code><?= $exception->getTraceAsString() ?></code></pre>
        </div>
    </div>
<?php } ?>
