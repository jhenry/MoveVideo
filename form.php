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
    <div class="row my-3 p-2 border">
      <div class="col">

        <h2 class="my-3">Find Media to Move:</h2>
        <div class="row ">
          <div class="col">
            <form method="GET">
              <div class="form-group">
                <label for="formGroupExampleInput">Show videos owned by a specific user: </label>
                <div class="input-group">
                  <input type="text" name="search-user" class="form-control form-control-lg mr-2" id="formGroupExampleInput" placeholder="mkapoodl">
                  <button type="submit" class="btn btn-primary">Go</button>
                </div>
              </div>
            </form>
          </div>
          <div class="col text-center">
            <span class="h1">OR</span>
          </div>
          <div class="col">
            <form method="GET">
              <div class="form-group">
                <label for="search-video">Find a video by its ID or private url string: </label>
                <div class="input-group">
                  <input type="text" name="search-video" class="form-control form-control-lg mr-2" id="search-video" placeholder="3901">
                  <button type="submit" class="btn btn-primary">Go</button>
                </div>
              </div>
            </form>
          </div>
        </div>

      </div>
    </div>
    <?php $videos = MoveVideo::getVideoList(); ?>
    <?php if ($videos) : ?>
      <div class="row">
        <div class="col-8">
          <h2 class="mt-3">Move Video</h2>
          <ul class="list-group">

            <?php foreach ($videos as $video) : ?>

              <li class="list-group-item">
                <?php $videoService = new VideoService(); ?>
                <div class="row">
                  <div class="col-6">
                    <p class="video-link"><a href="<?= $videoService->getUrl($video) ?>/"><?= htmlspecialchars($video->title) ?></a> <br />Uploaded: <?=date('m/d/Y H:i', strtotime($video->dateCreated))?> by <?= $video->username ?> </p>
                  </div>
                  <div class="col-4">
                    <form method="POST">
                      <div class="form-group">
                        <input type="hidden" name="videoId" class="form-control form-control-lg" id="videoId">

                        <label for="destinationUserId">Set owner to: </label>
                        <div class="input-group mb-3">
                          <input type="text" name="destinationUserId" class="form-control mr-2" id="destinationUserId" placeholder="jdoe" aria-describedby="destination-user">
                          <button class="btn btn-outline-primary" type="submit" id="destination-user">Go</button>
                        </div>
                      </div>
                    </form>
                  </div>
                </div>
              </li>

            <?php endforeach; ?>
          </ul>
        </div>
      </div>


      <div class="mb-3">
        <label for="exampleFormControlTextarea1" class="form-label">Results/Log</label>
        <textarea class="form-control" id="exampleFormControlTextarea1" rows="10">

  <?php
      //file_get_contents(MOVEVIDEO_LOG); 
  ?>
</textarea>
      </div>
    <?php endif; ?>

  </div>

  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>

</body>

</html>