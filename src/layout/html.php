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
                    
    <link href="/assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="/assets/css/blog.css" rel="stylesheet">
    <link href="/assets/css/syntaxhighlighter-theme-eclipse.css" rel="stylesheet">
  </head>
  <body>
    <header>
      <div class="blog-masthead">
        <div class="container">
          <div class="row no-gutters">
            <nav class="nav col">
              <a class="nav-link <?= $this->isActiveCaption() ? 'active' : '' ?>" href="/">Home</a>
              <?php
              foreach ($this->blogCategories() as $c) { ?>
                <a class="nav-link extended-nav <?= $this->isActiveCaption($c->id) ? 'active' : '' ?>" href="/?category=<?= $c->id ?>"><?= $c->name ?></a>
              <?php } ?>
              <a class="nav-link <?= $this->isActiveCaption('about') ? 'active' : '' ?>" href="/about">About</a>
            </nav>
            <div class="ext-links">
              <a href="https://twitter.com/tomas_tulka"><img src="/assets/img/twitter.png"></a>
              <a href="https://github.com/ttulka"><img src="/assets/img/github.png"></a>
            </div>
          </div>
        </div>
      </div>  
    </header>

    <?= $this->content() ?>

    <footer class="blog-footer">
      <div class="container">
        <div class="row no-gutters">
          <div class="col extended-nav">© <?= date('Y') ?> Tomas Tulka, NET21 s.r.o.</div>
          <div class="col footer-menu">
            <a href="/">Home</a> |
            <a href="/privacypolicy">Privacy Policy</a>
          </div>
        </div>
      </div>
    </footer>
    
    <script src="/assets/js/jquery-3.2.1.slim.min.js"></script>
    <script src="/assets/js/popper.min.js"></script>
    <script src="/assets/js/bootstrap.min.js"></script>
    <script src="/assets/js/syntaxhighlighter.min.js"></script>                
  </body>
</html>