
  <div class="sharp-card">


      <div class="grid-container">
        <div class="grid-x grid-padding-x">

          <div class="medium-6 cell"> 
            <div class="empty-card">
              <div class="comic-thumb-container">
                <div class="comic-page">
                  <p>PAGE <?php echo $page->page; ?> </p>
                  <img src="<?php echo $page_url.DIRECTORY_SEPARATOR.'thumb'.DIRECTORY_SEPARATOR.$page->thumbname; ?>" style="width: 100%; height: auto;" alt="missing image" />
                  <p><?php echo $page->imagename; ?></p>
                </div>
              </div>
            </div>

            <div class="tree">
              <ul>
                <!--root-->
                <li><i class="fa fa-folder-open-o"></i> <b>Comic</b>
                  <ul>
                    <!--factories-->
                    <li><i class="fa fa-folder-open-o"></i> <?php echo $series->title; ?>
                      <ul>
                        <!--children-->
                        <li><i class="fa fa-folder-o"></i> Chapter <?php echo $chapter->chapter.' : '.$chapter->title; ?></li>
                          <ul>
                            <li><i class="fa fa-file-text" aria-hidden="true"></i> <b>Page <?php echo $page->page; ?></b></li>
                          </ul>
                      </ul>
                    </li>
                  </ul>
                </li>
              </ul>
            </div><!-- end tree -->

          </div><!-- 6-cell -->

          <div class="medium-6 cell"> 
            <?php echo Form::open(['action' => '', 'method' => 'post', 'enctype' => 'multipart/form-data']); ?>
            <p style="color: #9295ad;">Replace an image</p>
            <label for="FileUpload" class="button">Upload File</label>
            <?php echo Form::input('UploadImage', 'UploadImage', ['id' => 'FileUpload', 'class' => 'show-for-sr', 'type' => 'file']); ?>
            <hr/>
            <?php echo Form::submit('UPLOAD', 'submit', ['class' => 'button primary']); ?>
          </div><!-- 6-cell -->

        <?php echo Form::close(); ?>
      </div><!-- grid-padding -->
      </div><!-- grid-container -->
  </div><!-- sharp-card -->


