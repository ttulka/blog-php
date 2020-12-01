<h1 class="blog-title"><?= $this->pageTitle() ?></h1>
<p class="blog-description"><?= $this->pageDescription() ?></p>

<hr>

<?php
if (!empty($this->tag.'')) { ?>
  <div class="search-tags">
    <span class="tag"><?= $this->tag ?></span>
  </div>
<?php } ?>

<?php
foreach ($this->posts as $post) { ?>
  <div class="blog-post">
    <h2 class="blog-post__title">
      <a href="/<?= $post->url ?>" class="h2"><?= $post->title ?></a>
    </h2>
    <p class="blog-post__meta">
      <?= gmdate("Y-m-d", $post->createdAt) ?> by <a href="/?author=<?= $post->authorId ?>"><?= $post->authorName ?></a>
    </p>
    <div><?= $post->summary ?></div>
  </div>
<?php } ?>
    
<nav class="blog-pagination">
  <?php
  if ($this->pagination->hasNext()) { ?>
    <a class="button-outline-primary" href="/<?= $this->pagination->nextUrl() ?>">Older</a>
  <?php } else { ?>
    <a class="button-outline-primary disabled" href="#">Older</a>
  <?php } ?>
  
  <?php
  if ($this->pagination->hasPrevious()) { ?>
    <a class="button-outline-secondary" href="/<?= $this->pagination->previousUrl() ?>">Newer</a>
  <?php } else { ?>
    <a class="button-outline-secondary disabled" href="#">Newer</a>
  <?php } ?>
</nav>