<?php

/**
 * @var $exception Throwable
 */

$meta_title = '500. Something went wrong';

?>
<div class="text-center">
    <div class="display-1">500</div>
    <div class="display-4">Something went wrong</div>
</div>

<div class="lead">Message: <?= $exception->getMessage() ? $exception->getMessage() : '-' ?></div>
<div>in <?= $exception->getFile() ?>:<?= $exception->getLine() ?> </div>
<div>Exception class: <?= get_class($exception) ?></div>
<pre><code><?= $exception->getTraceAsString() ?></code></pre>
