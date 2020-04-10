<main role="main" class="container">

  <h1 class="blog-title"><?= $this->post->title ?></h1>          
  
  <article class="blog-post">
      <p class="blog-post-meta">
          <?= gmdate("Y-m-d", $this->post->createdAt) ?>
          by <a href="/?author=<?= $this->post->authorId ?>"><?= $this->post->authorName ?></a></p>
      <p><?= $this->post->summary ?></p>
      <hr>
      <p><?= $this->post->body ?></p>
  </article>
  
  <aside class="blog-comments">
    <noscript>You need to enable JavaScript to see comments.</noscript>
    <comments-app id="comments" 
        service="https://<?= $_SERVER['SERVER_NAME'] ?>/" 
        postId="<?= $this->post->id ?>">
    </comments-app>
    <script src="/assets/js/comments.min.js"></script>
  </aside>

</main><!-- /.container -->
