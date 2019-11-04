<div class="blog-header">
  <div class="container">
    <h1 class="blog-title"><?= $this->pageTitle() ?></h1>
    <p class="lead blog-description"><?= $this->pageDescription() ?></p>
  </div>
</div>

<main role="main" class="container">          
  <?php
  foreach ($this->posts as $post) { ?>
    <div class="blog-post">
        <h2 class="blog-post-title">
            <a href="/<?= $post->url ?>" class="h2"><?= $post->title ?></a></h2>
        <p class="blog-post-meta"><?= gmdate("Y-m-d", $post->createdAt) ?>
            by <a href="/?author=<?= $post->authorId ?>"><?= $post->authorName ?></a></p>
        <p><?= $post->summary ?></p>
    </div>
  <?php } ?>
    
    <nav class="blog-pagination">
      <?php
      if ($this->pagination->hasNext()) { ?>
        <a class="btn btn-outline-primary" href="/<?= $this->pagination->nextUrl() ?>">Older</a>
      <?php } else { ?>
        <a class="btn btn-outline-primary disabled" href="#">Older</a>
      <?php } ?>
      
      <?php
      if ($this->pagination->hasPrevious()) { ?>
        <a class="btn btn-outline-secondary" href="/<?= $this->pagination->previousUrl() ?>">Newer</a>
      <?php } else { ?>
        <a class="btn btn-outline-secondary disabled" href="#">Newer</a>
      <?php } ?>
    </nav>

</main><!-- /.container -->