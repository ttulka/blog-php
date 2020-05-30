<!doctype html>
<html lang="en">
  <head>
    <title><?= $this->pageTitle() ?></title>
    <meta name="description" content="<?= $this->pageDescription() ?>">
    <meta name="author" content="<?= $this->pageAuthor() ?>">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="shortcut icon" type="image/x-icon" href="/assets/favicon.png">
    
    <meta name="twitter:card" content="summary">
    <meta name="twitter:site" content="@tomas_tulka">
    <meta name="twitter:creator" content="@tomas_tulka">
    <meta name="twitter:title" content="<?= $this->pageTitle() ?>">
    <meta property="og:url" content="https://<?= $_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'] ?>" />
    <meta property="og:type" content="article" />
    <meta property="og:title" content="<?= $this->pageTitle() ?>" />
                    
    <link href="/assets/css/syntaxhighlighter.css" rel="stylesheet">
    <link href="/assets/css/blog.css" rel="stylesheet">
  </head>
  <body>

    <header class="header">
      <div class="container">
        <nav class="nav">
          <a class="<?= $this->isActiveCaption() ? 'active' : '' ?>" href="/">Home</a>
          <?php
          foreach ($this->blogCategories() as $c) { ?>
            <a class="extended <?= $this->isActiveCaption($c->id) ? 'active' : '' ?>" href="/?category=<?= $c->id ?>"><?= $c->name ?></a>
          <?php } ?>
          <a class="<?= $this->isActiveCaption('about') ? 'active' : '' ?>" href="/about">About</a>
        </nav>
        <div class="ext-links">
          <a href="https://twitter.com/tomas_tulka"><img src="/assets/img/twitter.png"></a>
          <a href="https://github.com/ttulka"><img src="/assets/img/github.png"></a>
        </div>
      </div>
    </header>

    <main class="main">
      
      <?= $this->content() ?>

    </main>

    <footer class="footer">
      <div class="container">
        <div class="footer__extended">© <?= date('Y') ?> Tomas Tulka (ttulka)</div>
        <div class="footer__menu">
          <a href="/">Home</a> |
          <a href="/privacypolicy">Privacy Policy</a>
        </div>
      </div>
    </footer>

    <script src="/assets/js/syntaxhighlighter.min.js"></script> 
    
  </body>
</html>