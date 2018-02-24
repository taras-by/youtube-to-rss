<?php
$meta_title = 'Welcome!';
?>
    <h1>Posts</h1>

<?php foreach ($posts as $post) : ?>
    <p><small><?= $post->date ?></small> <?= $post->title ?></p>
<?php endforeach; ?>