
      <div class="sharp-card">
          <button><a class="button" href="/comic/create/chapter/<?php echo $series->id ?>">New chapter</a></button><br/>
          <button><a class="button" href="/comic/edit/bookcover/<?php echo $series->id ?>">Edit Series Details</a></button><br/>
        <img src="<?php echo $comic_cover.DIRECTORY_SEPARATOR.'thumb'.DIRECTORY_SEPARATOR.$series->thumbname; ?>" />
        <p><b>Series:</b> <?php echo $series->title; ?></p>
        <p><b>Author:</b> <?php echo $series->author; ?></p>
        <p><b>Total Chapters:</b> <?php echo $total_chapters; ?></p>
        <?php 
          $string = str_replace(' ', '', $series->title);
          $folder_name = strtolower($string);
        ?>
        <p><span class="label"><b>Series Directory:</b> <?php echo $comic_dir.DIRECTORY_SEPARATOR.$folder_name; ?></span></p>
      </div>
      <div class="empty-card">
      <?php foreach ($posts as $chapter) {
        echo '<div class="comic-thumb-container">';
          echo '<div class="comic-page">';
            echo '<p>Chapter '.$chapter->chapter.' 
            <a href="'.Uri::create('comic/edit/'.$chapter->group.'/'.$chapter->id).'"><i class="fa fa-pencil-square fa-lg" style="float:right;" aria-hidden="true"></i></a>
            <a href="'.Uri::create('comic/read/'.$chapter->group.'/'.$chapter->id.'/1').'"><i class="fa fa-eye fa-lg" style="float:right;" aria-hidden="true"></i></a>
            </p>';
            echo '<img src="'.$comic_dir.DIRECTORY_SEPARATOR.$folder_name.DIRECTORY_SEPARATOR.'chapter_'.$chapter->chapter.DIRECTORY_SEPARATOR.'cover'.DIRECTORY_SEPARATOR.'thumb'.DIRECTORY_SEPARATOR.$chapter->thumbname.'" class="comic-thumb" alt="missing image" />';
            echo '<p>'.$chapter->title.'</p>';
          echo '</div>';
        echo '</div>';
      } ?>

      </div><!-- sharp-card -->