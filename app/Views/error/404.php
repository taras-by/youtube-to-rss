<?php

/**
 * @var string $message
 */

$meta_title = '404. ' . ($message ? $message : 'Page not found!');

?>
<div class="text-center">
    <div class="display-1">404</div>
    <div class="display-4"><?= $message ? $message : 'Sorry that page can\'t be found' ?></div>
</div>
