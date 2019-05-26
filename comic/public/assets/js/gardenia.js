//=========================================== SIDEBAR NAV TREE ==========================================================

  $(document).ready(function() {
    
    var $menu_link = $('.menu-link');
    var $sub_menu = $('.sub-menu');

    $menu_link.on('click', function() {

      if (!$(this).hasClass('active')) {
        $sub_menu.slideUp(300,'swing');
        $(this).next().stop(true,true).slideToggle(300);
        $menu_link.removeClass('active');
        $(this).addClass('active');
      }
      else {
        $sub_menu.slideUp(300);
        $menu_link.removeClass('active');
      }

    });

  });

// ====== SIDEBAR TOGGLE ======

  var $i = 0; //open sidebar first
  //when $i = 2 //both sidebars are open
  var $sidebar = $('#sidebar-wrapper');
  var $sidebar_second = $('#sidebar-second');
  var $body = $('#main-wrapper');
  var $footer = $('.footer');

    $cheese = $('.cheeseburger');
    //$cheese.on('click', toggleSidebarSecond);

    //execute function on click
    $button_ham = $('#hamburger');
    $button_ham.on('click', toggleSidebar);

    $button_cheese = $('#cheeseburger');
    $button_cheese.on('click', toggleSidebar);
    $button_cheese.on('click', bodyZero);

    /* function toggleSidebarSecond() {
      if($i==0){
        //open second sidebar
        document.getElementById("second-sidebar").style.left = "150px";
        document.getElementById("main-wrapper").style.left = "350px";
        $i=2; //both sidebars are open
      } else{
        //close second sidebar
        document.getElementById("second-sidebar").style.left = "-80px";
        document.getElementById("main-wrapper").style.left = "150px";
        $i=0;
      }
    } */


  function bodyZero() {
    //if id cheeseburger is clicked make the main-wrapper left: 0px
    document.getElementById("main-wrapper").style.left = "0px";
  }
  function toggleSidebar() {
      $sidebar.toggle('left: 0;');
      if($i==0 || $i==2){
        //move main-wrapper left
        document.getElementById("main-wrapper").style.left = "0px";
        document.getElementById("cheeseburger").style.marginLeft = "90px";
        //document.getElementById("second-sidebar").style.left = "-80px";
        $i=1;
      } else{
        //move main-wrapper right
        document.getElementById("main-wrapper").style.left = "200px";
        document.getElementById("cheeseburger").style.marginLeft = "0px";
        $i=0;
      }

    }
