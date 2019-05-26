    <div class="sharp-card">

      <?php echo Form::open(['action' => '', 'method' => 'post', 'enctype' => 'multipart/form-data']); ?>
      <div class="grid-container">
        <div class="grid-x grid-padding-x">
          <div class="medium-6 cell">
            <label>Username
              <input type="text" name="email" placeholder="">
            </label>
            <label>Password
              <input type="password" name="password" placeholder="">
            </label>
          </div>
        </div>
        
        
        Don't have an account? <a href="<?php echo Uri::create('user/register'); ?>">Register Here.</a>
        <hr/>
        <?php echo Form::submit('LOGIN', 'LOGIN', ['class' => 'button primary']); ?>
      </div>
      <?php echo Form::close(); ?>
    <!-- </form> -->

  </div>
</div>
