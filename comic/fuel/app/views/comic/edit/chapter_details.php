    <div class="sharp-card">

      <?php echo Form::open(['action' => '', 'method' => 'post', 'enctype' => 'multipart/form-data']); ?>
      <div class="grid-container">
        <div class="grid-x grid-padding-x">

          <div class="medium-6 cell">
            <div class="empty-card">
              <div class="comic-thumb-container">
                <div class="comic-page">
                  <p>Chapter Cover</p>
                  <img src="<?php echo $imgurl.$chapter->imagename; ?>" class="comic-thumb" alt="missing image" />
                  <p><?php echo $chapter->imagename; ?></p>
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
                        <li><i class="fa fa-folder-o"></i> Chapter <?php echo $chapter->chapter; ?> : <?php echo $chapter->title; ?></li>
                          <ul>               
                            <li><i class="fa fa-file-text" aria-hidden="true"></i> Total Pages : <?php echo $total_pages; ?> </li>;
                          </ul>
                      </ul>
                    </li>
                  </ul>
                </li>
              </ul>
            </div><!-- end tree -->


          </div><!-- 6 cell -->

          <div class="medium-6 cell">

            <label>Chapter Title
              <input type="text" name="chapter_title" placeholder="<?php echo $chapter->title ?>" value="<?php echo $chapter->title  ?>">
            </label>
            <label>Author
              <input type="text" name="author" placeholder="<?php echo $series->author ?>" value="<?php echo $series->author  ?>">
            </label>
            <label>Illustrator
              <input type="text" name="illustrator" placeholder="<?php echo $series->illustrator ?>" value="<?php echo $series->illustrator  ?>">
            </label>
            <p>Replace chapter cover image</p>
            <label for="FileUpload" class="button">Upload File
            <?php echo Form::input('UploadImage[]', 'UploadImage[]', ['id' => 'FileUpload', 'class' => 'show-for-sr', 'type' => 'file']); ?>
            </label>
            <hr/>
            <?php echo Form::submit('SUBMIT', 'submit', ['class' => 'button primary']); ?>
          </div><!-- 6 cell -->

        </div><!-- grid -->

      </div>
      <?php echo Form::close(); ?>
    <!-- </form> -->

  </div>
</div>
