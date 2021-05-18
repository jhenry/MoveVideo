<?php
$this->view->options->disableView = true;


?>

<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">

    <title>Move Video to New Owner</title>
  </head>
  <body>
  <div class="container">

    <h1 class="mt-3">Move Video to New Owner</h1>

    <form method="GET">
      <div class="form-group">
        <label for="formGroupExampleInput">Show videos owned by a specific user: </label>
        <input type="text" name="search-user" class="form-control form-control-lg" id="formGroupExampleInput" placeholder="mkapoodl">
      </div>
      <button type="submit" class="btn btn-primary">Go</button>
    </form>

    <form method="GET">
      <div class="form-group">
        <label for="search-video">Find a video by its ID or private url string: </label>
        <input type="text" name="search-video" class="form-control form-control-lg" id="search-video" placeholder="3901">
      </div>
      <button type="submit" class="btn btn-primary">Go</button>
    </form>

<?php $videos = MoveVideo::getVideos(); ?>
<?php if ($videos): ?>
  <?php foreach ($videos as $video): ?>

  <div class="row">
    <div class="col-lg-6">
    <?php $videoService = new VideoService(); ?>
    <p class="video-link"><a href="<?= $videoService->getUrl($video) ?>/"><?= htmlspecialchars($video->title) ?></a>  
    </div>
    <div class="col-lg-4">
      <form method="POST">
          <input type="hidden" name="videoId" class="form-control form-control-lg"  id="videoId">
        <div class="form-group">
          <label for="destinationUserId">Set owner to: </label>
          <input type="text" name="destinationUserId" class="form-control form-control-lg" id="destinationUserId" placeholder="jdoe">
        </div>
        <button type="submit" class="btn btn-primary">Go</button>
      </form>
    </div>
  </div>

  <?php endforeach; ?>


<div class="mb-3">
  <label for="exampleFormControlTextarea1" class="form-label">Results/Log</label>
  <textarea class="form-control" id="exampleFormControlTextarea1" rows="10">

  <?= //file_get_contents(MOVEVIDEO_LOG); ?>
</textarea>
</div>
<?php endif; ?>

  </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>

  </body>
</html>
