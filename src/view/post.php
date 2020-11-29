<article class="blog-post">
    
    <h1 class="blog-post__title"><?= $this->post->title ?></h1>

    <p class="blog-post__meta">
        <?= gmdate("Y-m-d", $this->post->createdAt) ?>
        by <a href="/?author=<?= $this->post->authorId ?>"><?= $this->post->authorName ?></a></p>
    
    <?= $this->post->summary ?>
    
    <hr>
    
    <?= $this->post->body ?>

</article>

<?php 
if (!empty($this->post->tags)) { ?>

    <aside class="blog-tags">
        <?php
        foreach ($this->post->tags as $tag) { ?>
            <a href="/?tag=<?= urlencode($tag) ?>" class="tag"><?= $tag ?></a> 
        <?php } ?>
    </aside>

<?php } ?>

<aside class="blog-comments">
  <noscript>You need to enable JavaScript to see comments.</noscript>
  <comments-app id="comments" 
      service="https://<?= $_SERVER['SERVER_NAME'] ?>/" 
      postId="<?= $this->post->id ?>">
  </comments-app>
  <script src="/assets/js/comments.min.js" async></script>
</aside>
