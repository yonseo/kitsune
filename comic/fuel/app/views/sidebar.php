<!-- FIRST SIDEBAR -->
  <div class="sidebar">
    <div class="logo">
        
    </div>
    <ul class="side-nav" id="first-sidebar">
      <label>MAIN</label>
      <li><a href="<?php echo Uri::create('/'); ?>"><i class="fa fa-home" aria-hidden="true"></i> HOME</a></li>   
      <hr/>  
      <label>COMIC</label>
      <?php //echo $navlinks; ?>
      <?php //foreach ($posts as $post) {
        //echo '<li><a href="#" class="cheeseburger"><i class="fa fa-shopping-cart" aria-hidden="true"></i>'.$post->title.'</a></li>';  
      //}
      ?>
      <li><a href="#" class="cheeseburger"><i class="fa fa-shopping-cart" aria-hidden="true"></i> SHOP</a></li>  
      <a class="menu-link" href="#" class="cheeseburger"><i class="fa fa-book" aria-hidden="true"></i> COMIC</a>
        <ul class="sub-menu">
          <li><a href="<?php echo Uri::create('comic'); ?>">Series</a></li>
          <li><a href="<?php echo Uri::create('comic/read/1/1/1'); ?>">Read</a></li>
          <li><a href="<?php echo Uri::create('comic/create/series/new'); ?>">Create Series</a></li>
            <li><a href="<?php echo Uri::create('comic/create/chapter/1'); ?>">Create Chapter</a></li>
          <li><a href="#">Option</a></li>
        </ul> 
      <li><a href="#" class="cheeseburger"><i class="fa fa-question" aria-hidden="true"></i> FAQ</a></li>  
      <li><a href="#" class="cheeseburger"><i class="fa fa-coffee" aria-hidden="true"></i> ABOUT</a></li>  
      <li><a href="#" class="cheeseburger"><i class="fa fa-envelope" aria-hidden="true"></i> CONTACT</a></li> 
      <li><a href="#" class="cheeseburger"><i class="fa fa-user" aria-hidden="true"></i> LOGIN</a></li>
      <hr/>
      <label>OPTIONS</label>
      <li><a href="#" class="cheeseburger"><i class="fa fa-cog" aria-hidden="true"></i> SETTINGS</a></li>  
    </ul>
  </div>


<!-- SECOND SIDEBAR -->

    <div class="sidebar" id="second-sidebar" style="z-index: 8;">
    <div class="spacer"></div>
    <ul class="side-nav">
      <label>PAGES</label>
      <a class="menu-link" href="#"><i class="fa fa-cog" aria-hidden="true"></i> Comic</a>
        <ul class="sub-menu">
          <li><a href="<?php //echo Uri::create('comic'); ?>">Series</a></li>
          <li><a href="<?php //echo Uri::create('comic/read/1/1/1'); ?>">Read</a></li>
          <li><a href="<?php //echo Uri::create('comic/create/series/new'); ?>">Create Series</a></li>
            <li><a href="<?php //echo Uri::create('comic/create/chapter/1'); ?>">Create Chapter</a></li>
          <li><a href="#">Option</a></li>
        </ul>   
      <a class="menu-link" href="#"><i class="fa fa-cog" aria-hidden="true"></i> LINK</a>
        <ul class="sub-menu">
          <li><a href="#">Option</a></li>
          <li><a href="#">Option</a></li>
          <li><a href="#">Option</a></li>
        </ul>    
      <a class="menu-link" href="#"><i class="fa fa-cog" aria-hidden="true"></i> LINK</a>
        <ul class="sub-menu">
          <li><a href="#">Option</a></li>
          <li><a href="#">Option</a></li>
          <li><a href="#">Option</a></li>
        </ul>     
    </ul>
  </div> 



  