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
    <div id="comments" postId="<?= $this->post->id ?>">Rendering comments...</div>
    <script src="/assets/js/comments.min.js"></script>
    <link href="/assets/css/comments.min.css" rel="stylesheet"> 
  </aside>

</main><!-- /.container -->