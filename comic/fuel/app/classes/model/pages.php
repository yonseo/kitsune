<?php

class Model_Pages extends Orm\Model
{
    protected static $_properties = [
        'id',
        'page',
        'group',
        'imagename',
        'thumbname',
    ];


	public static function getAllSeries()
    {
        // get all Links
        $posts = Model_Series::find('all');
        return $posts;
    }

    public static function getAllPages()
    {
        // get all Links
        $posts = Model_Series::find('all');
        return $posts;
    }

    public static function getSinglePage($id=NULL)
    {
        // get single page from id
        $posts = Model_Pages::find($id);
        return $posts;
    }

    public static function getAllPagesFromChapter($chapter)
    {
        if(is_numeric($series) && is_numeric($chapter))
        { 
            // get all pages from series/chapter
            $series_id = Model_Chapters::find($series);
            $posts = Model_Pages::find('all', [
                'where' => ['group' => $chapter, '']
            ]);
            return $posts;
        }
    }

    public static function uploadPages($chapter_id)
    {
        //upload multiple images to a single comic chapter
        $chapter = Model_Chapters::find($chapter_id);

        if($chapter !== NULL)
        {
            //chapter exists and page number has been set
            //directory to save image
            $series = Model_Series::find($chapter->group);
            $chapter = Model_Chapters::find($chapter_id);
            $string = str_replace(' ', '', $series->title);
            $series_folder = strtolower($string);
            $series_dir = 'assets'.DIRECTORY_SEPARATOR.'uploads'.DIRECTORY_SEPARATOR.'comic'
                .DIRECTORY_SEPARATOR.$series_folder.DIRECTORY_SEPARATOR;
            $chapter_dir = $series_dir.'chapter_'.$chapter->chapter;
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
                'path' => $chapter_dir,
                'randomize' => true,
                'ext_whitelist' => array('img', 'jpg', 'jpeg', 'gif', 'png'),
                'prefix'      => 'image_'
            ];
        
            //set the directory to upload file                  
            Upload::process($config, [
                //3mb = 3072kb
                'max_size'    => 3072               
            ]);                 

            // if a valid file is passed than the function will save, or if it's not empty
            if (Upload::is_valid())
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
                    $new_page = new Model_Pages();            
                    $new_page->imagename = $file_name;
                    $new_page->thumbname = $thumb_name;
                    $pages = Model_Comics::getAllPagesFromChapterID($chapter->id);
                    if($pages !== NULL && $pages){ $page_number = count($pages) + 1; }else { $page_number = 1; }
                    $new_page->page = $page_number;
                    $new_page->group = $chapter->id;
                    $new_page->save();
                    
                    //copy the file to thumb directory
                    $copied = copy($chapter_dir.DIRECTORY_SEPARATOR.$file_name , $thumb_file);
                    if($copied == true)
                    {
                       //resize image to thumbnail size
                    }
                    else 
                    {
                        echo 'Failed to make thumbnail image!';
                        die();
                    }
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

    public static function replaceSinglePage($page_id)
    {
        //upload single image to a single comic chapter
        $page = Model_Pages::find($page_id);

        if($page !== NULL && isset($page))
        {
            //chapter exists and page number has been set
            //directory to save image
            $chapter = Model_Chapters::find($page->group);
            $series = Model_Series::find($chapter->group);
            $string = str_replace(' ', '', $series->title);
            $series_folder = strtolower($string);
            $series_dir = 'assets'.DIRECTORY_SEPARATOR.'uploads'.DIRECTORY_SEPARATOR.'comic'
                .DIRECTORY_SEPARATOR.$series_folder.DIRECTORY_SEPARATOR;
            $chapter_dir = $series_dir.'chapter_'.$chapter->chapter;
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
                'path' => $chapter_dir,
                'randomize' => true,
                'ext_whitelist' => array('img', 'jpg', 'jpeg', 'gif', 'png'),
                'prefix'      => 'image_'
            ];
        
            //set the directory to upload file                  
            Upload::process($config, [
                //3mb = 3072kb
                'max_size'    => 3072               
            ]);                 

            // if a valid file is passed than the function will save, or if it's not empty
            if (Upload::is_valid())
            {
                //upload the current image file into chapter_dir
                Upload::save();
                //get all the image files that were uploaded
                $value = Upload::get_files();
                foreach ($value as $file)
                {
                    //delete old image
                    $image_exists = file_exists(DOCROOT.$chapter_dir.DIRECTORY_SEPARATOR.$page->imagename);
                    $thumb_exists = file_exists(DOCROOT.$thumb_dir.DIRECTORY_SEPARATOR.$page->thumbname);
                    //check if old file exists from folder directory 
                    if($image_exists == true && !empty($page->imagename) && $page->imagename !== NULL)
                    {
                        //delete old file
                        $delete_image = unlink(DOCROOT.$chapter_dir.DIRECTORY_SEPARATOR.$page->imagename);
                        if($delete_image == false)
                        {
                            echo "An error occurred deleting the image file from directory : ".$page->imagename;
                            die();
                        }
                    }
                    if($thumb_exists == true && !empty($page->thumbname) && $page->thumbname !== NULL)
                    {
                        //delete old file
                        $delete_image = unlink(DOCROOT.$thumb_dir.DIRECTORY_SEPARATOR.$page->thumbname);
                        if($delete_image == false)
                        {
                            echo "An error occurred deleting the thumbnail image file from directory : ".$page->thumbname;
                            die();
                        }
                    }
                    //foreach image create a thumbnail and save to db               
                    $file_name = $file['saved_as']; 
                    $thumb_name = str_replace('image_', 'thumb_', $file_name);
                    $thumb_file  = $thumb_dir.DIRECTORY_SEPARATOR.$thumb_name;
                    
                    //save image file to the database         
                    $page->imagename = $file_name;
                    $page->thumbname = $thumb_name;
                    $page->page = $page->page;
                    $page->group = $chapter->id;
                    $page->save();
                    
                    //copy the file to thumb directory
                    $copied = copy($chapter_dir.DIRECTORY_SEPARATOR.$file_name , $thumb_file);
                    if($copied == true)
                    {
                       //resize image to thumbnail size
                    }
                    else 
                    {
                        echo 'Failed to make thumbnail image!';
                        die();
                    }
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
            //page not found
            //ERROR
            return false;
        }

    }


} //end object