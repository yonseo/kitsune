    <div class="sharp-card">

      <?php echo Form::open(['action' => '', 'method' => 'post', 'enctype' => 'multipart/form-data']); ?>
      <div class="grid-container">
        <div class="grid-x grid-padding-x">
          <div class="medium-6 cell">
            <label>Series Title
              <input type="text" name="series_title" placeholder="<?php echo $series->title ?>">
            </label>
            <label>Chapter Title
              <input type="text" name="chapter_title" placeholder="<?php echo $chapter->title ?>">
            </label>
          </div>
          <div class="medium-6 cell">
            <label>Chapter Number
              <input type="text" placeholder="<?php echo $chapter->chapter ?>">
            </label>
            <label>Chapter Number
              <input type="text" placeholder="<?php ?>">
            </label>
          </div>
        </div>
        
        <label for="FileUpload" class="button">Upload File</label>
        <?php echo Form::input('UploadImage[]', 'UploadImage[]', ['id' => 'FileUpload', 'class' => 'show-for-sr', 'type' => 'file', 'multiple' => '']); ?>
        <hr/>
        <?php echo Form::submit('SUBMIT', 'submit', ['class' => 'button primary']); ?>
      </div>
      <?php echo Form::close(); ?>
    <!-- </form> -->

  </div>
</div>
