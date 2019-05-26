 <?php 
   // get the user session
   $username = Session::get('username');
   $email = Session::get('email');
 ?>


  <div class="top-bar slim">
    <div class="top-bar-left">
      <ul>
        <!-- HAMBURGER -->
        <li><a id="hamburger" href="#" style="color: #9293a5; font-size: 13px;"><i class="fa fa-bars" aria-hidden="true"></i></a></li>
      </ul>
    </div>
    <?php if(Auth::check()) {
      echo 'Welcome: '.$username; 
      echo '<li class="button" style="margin-right: 5px; margin-left: 5px;"><a href="'.Uri::create('user/logout').'">Logout</a></li>';
    } 
    else {
      echo '
      <div class="top-bar-right">
        <ul>
          <li class="button" style="margin-right: 5px; margin-left: 5px;"><a href="'.Uri::create('user/login').'">Login</a></li>
        </ul>
      </div>';
    }
    ?>
  </div><!-- top-bar slim -->

  <div class="top-bar">
    <div class="top-bar-left">
      <ul class="dropdown menu" data-dropdown-menu>
        <li class="title">KITSUNE</li>
        <li><a id="cheeseburger" href="#" style="color: #9293a5; font-size: 13px;"><i class="fa fa-bars" aria-hidden="true"></i></a></li>
      </ul>
    </div>

    <div class="top-bar-right">
      <ul class="menu">
          <li><a href="/">HOME</a></li>     
          <li><a href="home/shop">SHOP</a></li>  
          <li><a href="home/comic">COMIC</a></li>  
          <li><a href="home/faq">FAQ</a></li>  
          <li><a href="home/about">ABOUT</a></li>  
          <li><a href="home/contact">CONTACT</a></li> 
        </ul>
    </div>

  </div><!-- END top-bar -->


  <!----------------------------------------- FLASH MESSAGE---------------------------------------->
  <div class="container">
      
      <?php if(Session::get_flash('success')) : ?>
          <div class="alert success">
            <i class="fa fa-exclamation-circle" aria-hidden="true"></i>
              <?php echo Session::get_flash('success'); echo '<br/>'; ?>
          </div>
      <?php endif; ?>
      
      <?php if(Session::get_flash('error')) : ?>
          <div class="alert danger">
            <i class="fa fa-exclamation-circle" aria-hidden="true"></i>
              <?php echo Session::get_flash('error'); echo '<br/>'; ?>
          </div>
      <?php endif; ?>
      
  </div>

  