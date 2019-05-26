<div class="empty-card">

  <?php 
      echo 'Page: '.$posts->page.'/'.$total_pages.'<br/>';
      echo '<img src="'.$pages.DIRECTORY_SEPARATOR.'img'.DIRECTORY_SEPARATOR.$posts->imagename.'" class="comic-flip" alt="missing image" />';

  ?>
  <!-- Pagination -->
    <?php 
    $next = $posts->page + 1; 
    $prev = $posts->page - 1; 
    ?>
    <div class="spacer"></div>
    <nav aria-label="Pagination">
      <ul class="pagination text-center">
        <li class="pagination-previous "><a href="/<?php echo $page_url.$prev ?>">Previous</a></li>
        <li class="current"><span class="show-for-sr">You're on page</span> 1</li>
        <li><a href="#" aria-label="Page 2">2</a></li>
        <li><a href="#" aria-label="Page 3">3</a></li>
        <li><a href="#" aria-label="Page 4">4</a></li>
        <li class="ellipsis"></li>
        <li><a href="#" aria-label="Page 12">12</a></li>
        <li><a href="#" aria-label="Page 13">13</a></li>
        <li id="add" class="pagination-next"><a href="/<?php echo $page_url.$next ?>" aria-label="Next page" >Next</a></li>
      </ul>
    </nav>
</div><!-- emmpty card -->

