    <div class="sharp-card">

      <?php echo Form::open(['action' => '', 'method' => 'post', 'enctype' => 'multipart/form-data']); ?>
      <div class="grid-container">
        <div class="grid-x grid-padding-x">
          <div class="medium-6 cell">
            <label>Series Title
              <input type="text" name="series_title">
            </label>
            <label>Genre
              <input type="text" name="genre">
            </label>
          </div>
          <div class="medium-6 cell">
            <label>Author
              <input type="text" name="author">
            </label>
            <label>Illustrator
              <input type="text" name="illustrator">
            </label>
          </div>
        </div>
        
        <label for="FileUpload" class="button">Upload File</label>
        <?php echo Form::input('UploadImage', 'UploadImage', ['id' => 'FileUpload', 'class' => 'show-for-sr', 'type' => 'file']); ?>
        <hr/>
        <?php echo Form::submit('SUBMIT', 'submit', ['class' => 'button primary']); ?>
      </div>
      <?php echo Form::close(); ?>
    <!-- </form> -->

  </div>
</div>
