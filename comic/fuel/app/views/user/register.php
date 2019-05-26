    <div class="sharp-card">

      <?php echo Form::open(['action' => '', 'method' => 'post', 'enctype' => 'multipart/form-data']); ?>
      <div class="grid-container">
        <div class="grid-x grid-padding-x">
          <div class="medium-6 cell">
            <label>Username
              <input type="text" name="username" placeholder="">
            </label>
            <label>Email
              <input type="email" name="email" placeholder="">
            </label>
            <label>Password
              <input type="password" name="password" placeholder="">
            </label>
            <label>Confirm Password
              <input type="password" name="password_confirm" placeholder="">
            </label>
          </div>
        </div>
        
        
        Already have an account? <a href="<?php echo Uri::create('user/login'); ?>">Login Here. </a>
        <hr/>
        <?php echo Form::submit('REGISTER', 'REGISTER', ['class' => 'button primary']); ?>
      </div>
      <?php echo Form::close(); ?>
    <!-- </form> -->

  </div>
</div>