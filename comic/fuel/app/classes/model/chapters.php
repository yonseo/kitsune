<?php

class Model_Chapters extends Orm\Model
{
    protected static $_properties = [
        'id',
        'title',
        'pages',
        'imagename',
        'thumbname',
        'group',
        'chapter'
    ];

	public static function getAllChaptersFromSeries($id)
    {
        // get all pages from series
        $posts = Model_Chapters::find('all', [
            'where' => ['group' => $id]
        ]);
        return $posts;
    }

    public static function uploadChapterCover($series_id)
    {
        //upload a new cover image for comic chapter
        $series = Model_Series::find($series_id);
        $total_chapters = Model_Comics::getAllChaptersFromSeriesID($series->id);
        if($total_chapters !== NULL){ $new_chapter = count($total_chapters) + 1; }else { $new_chapter = 1; }

        if($series !== NULL)
        {
            //chapter exists and page number has been set
            //directory to save image
            $string = str_replace(' ', '', $series->title);
            $series_folder = strtolower($string);
            $series_dir = 'assets'.DIRECTORY_SEPARATOR.'uploads'.DIRECTORY_SEPARATOR.'comic'
                .DIRECTORY_SEPARATOR.$series_folder.DIRECTORY_SEPARATOR;
            $chapter_dir = $series_dir.'chapter_'.$new_chapter;
            $thumb_dir = $chapter_dir.DIRECTORY_SEPARATOR.'thumb'; 
            $cover_dir = $chapter_dir.DIRECTORY_SEPARATOR.'cover';
            $bookcover_dir = $series_dir.'bookcover';
            //check if folder exists, if not create one
            if (!is_dir($chapter_dir)) 
            {
                mkdir($chapter_dir, 0777, true);         
            }
            if (!is_dir($thumb_dir)) 
            {
                mkdir($thumb_dir, 0777, true);         
            }
            if (!is_dir($cover_dir)) 
            {
                mkdir($cover_dir, 0777, true);         
            }
            if (!is_dir($bookcover_dir)) 
            {
                mkdir($bookcover_dir, 0777, true);         
            }    

            $config = [
                'path' => $cover_dir,
                'randomize' => true,
                'ext_whitelist' => array('img', 'jpg', 'jpeg', 'gif', 'png'),
                'prefix'      => 'image_'
            ];
        
            //set the directory to upload file                  
            Upload::process($config, [
                //3mb = 3072kb
                'max_size'    => 3072               
            ]); 
            $errors = 0;                
            //check for empty input values
            if(empty(Input::post('chapter_title')) or Input::post('chapter_title') == NULL)
            {
                $errors++;
            }
            // if a valid file is passed than the function will save, or if it's not empty
            if (Upload::is_valid() && $errors == 0)
            {
                //upload the current image file into chapter_dir
                Upload::save();
                //get all the image files that were uploaded
                $value = Upload::get_files();
                foreach ($value as $page)
                {
                    //foreach image create a thumbnail and save to db               
                    $file_name = $page['saved_as']; 
                    $thumb_name = str_replace('image_', 'thumb_', $file_name);
                    $thumb_file  = $thumb_dir.DIRECTORY_SEPARATOR.$thumb_name;
                    
                    //save new image file to the database
                    $chapter = new Model_Chapters();
                    $chapter->title = Input::post('chapter_title');
                    $chapter->imagename = $file_name;                  
                    $chapter->chapter = $new_chapter;
                    $chapter->pages = 0;
                    $chapter->group = $series->id;
                    $chapter->save();

                }
                //UPLOAD SUCCESS
                return true;             
            }
            else
            {
                //file upload is empty
                //ERROR
                return false;
            }
        }
        else
        {
            //chapter not found
            //ERROR
            return false;
        }

    }

    public static function replaceChapterCover($chapter_id)
    {
        //replace chapter cover image on upload
        $chapter = Model_Chapters::find($chapter_id);
        $series = Model_Series::find($chapter->group);

        if($chapter !== NULL && $series !== NULL)
        {
            //directory to save image
            $string = str_replace(' ', '', $series->title);
            $series_folder = strtolower($string);
            $series_dir = 'assets'.DIRECTORY_SEPARATOR.'uploads'.DIRECTORY_SEPARATOR.'comic'
                .DIRECTORY_SEPARATOR.$series_folder.DIRECTORY_SEPARATOR;
            $chapter_dir = $series_dir.'chapter_'.$chapter->chapter;
            $cover_dir = $chapter_dir.DIRECTORY_SEPARATOR.'cover';
            //check if folder exists, if not create one
            if (!is_dir($chapter_dir)) 
            {
                mkdir($chapter_dir, 0777, true);         
            }
            if (!is_dir($cover_dir)) 
            {
                mkdir($cover_dir, 0777, true);         
            }  

            $config = [
                'path' => $cover_dir,
                'randomize' => true,
                'ext_whitelist' => array('img', 'jpg', 'jpeg', 'gif', 'png'),
                'prefix'      => 'cover_'
            ];
        
            //set the directory to upload file                  
            Upload::process($config, [
                //3mb = 3072kb
                'max_size'    => 3072               
            ]); 
            $error = 0;                
            //check for empty input values
            if(empty(Input::post('chapter_title')) or Input::post('chapter_title') == NULL)
            {
                $error++;
            }
            if(empty(Input::post('illustrator')) or Input::post('illustrator') == NULL)
            {
                $error++;
            }
            if(empty(Input::post('author')) or Input::post('author') == NULL)
            {
                $error++;
            }
            // if a valid file is passed than the function will save, or if it's not empty
            if (Upload::is_valid() && $error == 0)
            {
                //upload the current image file into chapter_dir
                Upload::save();
                //get all the image files that were uploaded
                $value = Upload::get_files();
                foreach ($value as $page)
                {
                    //delete old cover image
                    $cover_exists = file_exists(DOCROOT.$cover_dir.DIRECTORY_SEPARATOR.$chapter->imagename);
                    //check if old file exists from folder directory 
                    if($cover_exists == true && !empty($chapter->imagename) && $chapter->imagename !== NULL)
                    {
                        //delete old file
                        $delete_image = unlink(DOCROOT.$cover_dir.DIRECTORY_SEPARATOR.$chapter->imagename);
                        if($delete_image == false)
                        {
                            echo "An error occurred deleting the image file from directory : ".$chapter->imagename;
                            die();
                        }
                    }
                    
                    //foreach image create a thumbnail and save to db               
                    $file_name = $page['saved_as']; 
                    //save new image file to the database
                    $chapter->title = Input::post('chapter_title');
                    $chapter->chapter = $chapter->chapter;
                    $chapter->imagename = $file_name;  
                    $chapter->group = $chapter->group;
                    $chapter->pages = 1;
                    //$chapter->thumbname = $thumb_name;                
                    $chapter->save();               
                }
                //UPLOAD SUCCESS
                return true;             
            }
            else
            {
                //file upload is empty
                //ERROR
                return false;
            }
        }
        else
        {
            //chapter not found
            //ERROR
            return false;
        }

    }



}