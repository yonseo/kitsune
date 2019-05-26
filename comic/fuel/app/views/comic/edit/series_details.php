    <div class="sharp-card">

      <?php echo Form::open(['action' => '', 'method' => 'post', 'enctype' => 'multipart/form-data']); ?>
      <div class="grid-container">
        <div class="grid-x grid-padding-x">

          <div class="medium-6 cell">
            <div class="empty-card">
              <div class="comic-thumb-container">
                <div class="comic-page">
                  <p>Book Cover</p>
                  <img src="<?php echo $imgurl; ?>" class="comic-thumb" alt="missing image" />
                  <p><?php echo $series->imagename; ?></p>
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
                        <li><i class="fa fa-folder-o"></i> Total Chapters : <?php echo $total_chapters; ?></li>

                      </ul>
                    </li>
                  </ul>
                </li>
              </ul>
            </div><!-- end tree -->


          </div><!-- 6 cell -->

          <div class="medium-6 cell">

            <label>Series Title
              <input type="text" name="series_title" placeholder="<?php echo $series->title ?>" value="<?php echo $series->title  ?>">
            </label>
            <label>Genre
              <input type="text" name="genre" placeholder="<?php echo $series->genre ?>" value="<?php echo $series->genre  ?>">
            </label>
            <label>Author
              <input type="text" name="author" placeholder="<?php echo $series->author ?>" value="<?php echo $series->author  ?>">
            </label>
            <label>Illustrator
              <input type="text" name="illustrator" placeholder="<?php echo $series->illustrator ?>" value="<?php echo $series->illustrator  ?>">
            </label>
            <p>Replace book cover image</p>
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
