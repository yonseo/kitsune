
<div class="empty-card">
  <?php foreach ($posts as $series) {
    echo '<div class="comic-thumb-container">';
      echo '<div class="comic-page">';
        echo '<p>'.$series->title.'<a href="'.Uri::create('comic/view/'.$series->id).'"><i class="fa fa-pencil-square fa-lg" style="float: right;" aria-hidden="true"></i></a></p>';
          $string = str_replace(' ', '', $series->title);
          $series_name = strtolower($string);
        echo '<img src="'.$imgurl.$series_name.DIRECTORY_SEPARATOR.'cover'.DIRECTORY_SEPARATOR.'thumb'.DIRECTORY_SEPARATOR.$series->thumbname.'" class="comic-thumb" alt="missing image" />';
        echo '<p> Author: '.$series->author.'</p>';
        $series_dir = 'comic'.DIRECTORY_SEPARATOR.$series_name;
        echo '<p> Dir: '.$series_dir.'</p>';
        echo '<p>'.$series->id.'</p>';
      echo '</div>';
    echo '</div>';
  } ?>
  <!-- Pagination -->
    <div class="spacer"></div>
    <nav aria-label="Pagination">
      <ul class="pagination text-center">
        <li class="pagination-previous disabled">Previous</li>
        <li class="current"><span class="show-for-sr">You're on page</span> 1</li>
        <li><a href="#" aria-label="Page 2">2</a></li>
        <li><a href="#" aria-label="Page 3">3</a></li>
        <li><a href="#" aria-label="Page 4">4</a></li>
        <li class="ellipsis"></li>
        <li><a href="#" aria-label="Page 12">12</a></li>
        <li><a href="#" aria-label="Page 13">13</a></li>
        <li class="pagination-next"><a href="#" aria-label="Next page">Next</a></li>
      </ul>
    </nav>
</div>