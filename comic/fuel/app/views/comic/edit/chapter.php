
      <div class="sharp-card">
        <div class="grid-x">
          <div class="cell small-6">
            <button><a class="button" href="/comic/create/pages/<?php echo $chapter_id ?>">Upload Pages</a></button><br/>
            <button><a class="button" href="/comic/edit/cover/<?php echo $chapter_id ?>">Edit Details</a></button><br/>
            <div class="image-container"><img src="<?php echo $chaptercover; ?>" alt="missing image" /></div>
          </div><!-- END cell 6 -->

        <div class="cell small-6">
          <div class="tree">
            <ul>
              <!--root-->
              <li><i class="fa fa-folder-open-o"></i> <b>Comic</b>
                <ul>
                  <!--factories-->
                  <li><i class="fa fa-folder-open-o"></i> <?php echo $series; ?>
                    <ul>
                      <!--children-->
                      <li><i class="fa fa-folder-o"></i> Chapter <?php echo $chapter; ?></li>
                        <ul>
                          <?php foreach ($posts as $page) {                  
                          echo '<li><i class="fa fa-file-text" aria-hidden="true"></i> Page '.$page->page.'</li>';
                          } ?>
                        </ul>
                    </ul>
                  </li>
                </ul>
              </li>
            </ul>
          </div><!-- end tree -->
    
          <p><b>Series:</b> <?php echo $series; ?></p>
          <p><b>Chapter Title:</b> <?php echo $chapter_name; ?></p>
          <p><b>Chapter:</b> <?php echo $chapter; ?></p>
          <p><b>Author:</b> <?php echo $author; ?></p>
          <p><b>Number of pages:</b> <?php echo $total_pages; ?></p>
          <p><b>Total Chapters:</b> <?php echo $total_chapters; ?></p>
          <p><span class="label"><b>Series Directory:</b> <?php echo $series_dir; ?></span></p>
          <p><span class="label warning"><b>Chapter Directory:</b> <?php echo $chapter_dir; ?></span></p>

        </div><!-- END cell 6 -->
        </div><!-- END grid-x -->

      </div><!-- sharp-card -->

      <!-- Display Pages -->
      <div class="empty-card">
      <?php foreach ($posts as $page) {
        echo '<div class="comic-thumb-container">';
          echo '<div class="comic-page">';
            echo '<p>PAGE '.$page->page.' <a href="'.Uri::create('comic/edit/page/'.$page->id).'"><i class="fa fa-pencil-square fa-lg" style="float: right;" aria-hidden="true"></i></a></p>';
            echo '<img src="'.$page_dir.DIRECTORY_SEPARATOR.'thumb'.DIRECTORY_SEPARATOR.$page->thumbname.'" class="comic-thumb" alt="missing image" />';
            echo '<p>'.$page->imagename.'</p>';
          echo '</div>';
        echo '</div>';
      } ?>
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

      </div><!-- sharp-card -->