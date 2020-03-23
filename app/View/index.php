<?php
/**
 * @var string $youtubeLink
 * @var string $generatedUrl
 * @var string $errorMessage
 * @var string $submit
 */

$meta_title = 'YouTube to RSS';
?>
<form class="card p-2 mb-3" action="" method="post">
    <div class="input-group">
        <input type="text" name="youtube_link" value="<?= $youtubeLink ?>"
               class="form-control<?= $submit ? ($errorMessage ? ' is-invalid' : ' is-valid') : '' ?>"
               placeholder="Link to YouTube channel, playlist, video"
               required>
        <div class="input-group-append">
            <button type="submit" class="btn btn-secondary">Generate</button>
        </div>
    </div>
</form>

<?php if ($errorMessage) { ?>
    <div class="text-center text-danger">
        <?= $errorMessage ?>
    </div>
<?php } ?>

<?php if ($generatedUrl) { ?>
    <div class="text-center">
        <a href="<?= $generatedUrl ?>" target="_blank"><?= $generatedUrl ?></a>
    </div>
<?php } ?>
