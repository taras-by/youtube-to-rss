<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title><?= $meta_title ?? 'Empty title' ?></title>
    <link href="https://getbootstrap.com/docs/4.4/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="/assets/fontello/css/icons.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container">
    <div class="py-5 text-center">

        <a href="/" class="display-3 text-danger"><i class="demo-icon icon-youtube-squared">&#xf166;</i><i
                    class="demo-icon icon-right-thin">&#xe800;</i><i class="demo-icon icon-rss-squared">&#xf143;</i></a>
        <h1>YouTube to RSS</h1>
        <p class="lead">Service that helps to generate RSS feed for YouTube channel</p>
    </div>

    <?= $content ?? 'Empty content' ?>

    <footer class="my-5 pt-5 text-muted text-center text-small">
        <ul class="list-inline">
            <li class="list-inline-item"><a href="https://github.com/taras-by/youtube-to-rss" target="_blank">github.com</a></li>
            <li class="list-inline-item">&copy; 2018-<?= date('Y') ?> YouTube to RSS</li>
        </ul>
    </footer>
</div>
<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js"></script>
</body>
</html>
