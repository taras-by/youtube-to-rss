<?php
$meta_title = 'Thumbnails';
?>
    <h1>Thumbnails</h1>

<?php foreach ($items as $item) : ?>

    <?php if (isset($item->snippet->thumbnails->default)) : ?>
        <img src="<?php echo $item->snippet->thumbnails->default->url ?>"/>
    <?php endif; ?>

<?php endforeach; ?>