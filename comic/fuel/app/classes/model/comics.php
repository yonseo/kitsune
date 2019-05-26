<?php

class Model_Comics extends Orm\Model
{
    public static function fetchURL($array=NULL)
    {
        //fetch all needed URL directories
        $series = Model_Series::find($array[0]);
        $chapter = Model_Chapters::find($array[1]);
        //create dir
        $comic = DIRECTORY_SEPARATOR.'assets'.DIRECTORY_SEPARATOR.'uploads'.DIRECTORY_SEPARATOR.'comic';
        if($series !== NULL or !empty($series))
        {
            $string = str_replace(' ', '', $series->title);
            $folder_name = strtolower($string);
            $bookcover = $comic.DIRECTORY_SEPARATOR.$folder_name.DIRECTORY_SEPARATOR.'cover';
            $series_dir = $comic.DIRECTORY_SEPARATOR.$folder_name;
        }
        else
        {
            $bookcover = NULL;
            $series_dir = NULL;
        }
        if($chapter !== NULL or !empty($chapter))
        {
            $series = Model_Series::find($chapter->group);
            $string = str_replace(' ', '', $series->title);
            $folder_name = strtolower($string);
            $chapter_cover = $comic.DIRECTORY_SEPARATOR.$folder_name.DIRECTORY_SEPARATOR.'chapter_'.$chapter->chapter.DIRECTORY_SEPARATOR.'cover';
            $pages = $comic.DIRECTORY_SEPARATOR.$folder_name.DIRECTORY_SEPARATOR.'chapter_'.$chapter->chapter.DIRECTORY_SEPARATOR.'pages';
        }
        else
        {
            $chapter_cover = NULL;
            $pages = NULL;
        }
        $dir = [$comic, $series_dir, $bookcover, $chapter_cover, $pages];
        return $dir;
    }

    public static function fetchDir($array=NULL)
    {
        //fetch all needed folder directories
        $series = Model_Series::find($array[0]);
        $chapter = Model_Chapters::find($array[1]);
        //create dir
        $comic = DOCROOT.'assets'.DIRECTORY_SEPARATOR.'uploads'.DIRECTORY_SEPARATOR.'comic';
        if($series !== NULL or !empty($series))
        {
            $string = str_replace(' ', '', $series->title);
            $folder_name = strtolower($string);
            $bookcover = $comic.DIRECTORY_SEPARATOR.$folder_name.DIRECTORY_SEPARATOR.'cover';
            $series_dir = $comic.DIRECTORY_SEPARATOR.$folder_name;
        }
        else
        {
            $bookcover = NULL;
            $series_dir = NULL;
        }
        if($chapter !== NULL or !empty($chapter))
        {
            $series = Model_Series::find($chapter->group);
            $string = str_replace(' ', '', $series->title);
            $folder_name = strtolower($string);
            $chapter_cover = $comic.DIRECTORY_SEPARATOR.$folder_name.DIRECTORY_SEPARATOR.'chapter_'.$chapter->chapter.DIRECTORY_SEPARATOR.'cover';
            $pages = $comic.DIRECTORY_SEPARATOR.$folder_name.DIRECTORY_SEPARATOR.'chapter_'.$chapter->chapter.DIRECTORY_SEPARATOR.'pages';
        }
        else
        {
            $chapter_cover = NULL;
            $pages = NULL;
        }
        $dir = [$comic, $series_dir, $bookcover, $chapter_cover, $pages];
        return $dir;
    }

    public static function deleteImageFromDir($image_name=NULL, $dir=NULL)
    {
        // delete an image from a directory
        $image_exists = file_exists($dir.DIRECTORY_SEPARATOR.$image_name);
        $is_dir = is_dir($dir);
        //check if file exists in folder directory 
        if($image_exists == true && !empty($image_name) && $image_name !== NULL && $is_dir == true)
        {
            //delete old file from dir
            $delete_image = unlink($dir.DIRECTORY_SEPARATOR.$image_name);
            if($delete_image == true)
            {
                return true;
            }
            else
            {
                return false;
            }
        }
        else
        {
            return false;
        }
    }

    public static function getSeries($id=NULL)
    {
        // get single series from id
        $posts = Model_Series::find('first', [
            'where' => ['id' => $id]
        ]);
        if($posts && $posts !== NULL)
        {
            return $posts;
        }
        else
        {
            return NULL;
        }
    }

	public static function getChapterFromSeriesID($series_id=NULL)
    {
        // get single chapter from series id and chapter number
        $posts = Model_Chapters::find('first', [
            'where' => ['group' => $series_id]
        ]);
        return $posts;
    }

    public static function getChapterFromPageID($id=NULL)
    {
        $page = Model_Pages::find($id);
        // get single chapter from page id
        $posts = Model_Chapters::find('first', [
            'where' => ['id' => $page->group]
        ]);

        return $posts;
    }

    public static function getAllChaptersFromSeriesID($id=NULL)
    {
        // get all chapters from series id
        $chapters = Model_Chapters::find('all', [
            'where' => ['group' => $id]
        ]);
        if(is_numeric($id) && $chapters !== NULL)
        {
            return $chapters;
        }
        else
        {
            return NULL;
        }
    }

    public static function getAllPagesFromChapterID($chapter_id=NULL)
    {
        if(is_numeric($chapter_id) && $chapter_id !== NULL)
        {
            // get all pages from single chapter id
            $pages = Model_Pages::find('all', [
                'where' => ['group' => $chapter_id]
            ]);
            if($pages !== NULL && !empty($pages))
            {              
                return $pages;
            }
            else
            {
                return NULL;
            }

        }
    }
    public static function getPageFromChapterID($chapter_id=NULL, $page_num=NULL)
    {
        if(is_numeric($chapter_id) && $chapter_id !== NULL && is_numeric($page_num) && $page_num !== NULL)
        {
            // get single page from chapter id
            $page = Model_Pages::find('first', [
                'where' => ['group' => $chapter_id, 'page' => $page_num]
            ]);          
            if($page !== NULL && !empty($page))
            {              
                return $page;
            }
            else
            {
                return NULL;
            }

        }
    }

    public static function uploadImages($dir=NULL)
    {
        // get a directory
        // 

        if($dir !== NULL)
        {
            $folder = $dir.DIRECTORY_SEPARATOR.'img';
            $img = $dir.DIRECTORY_SEPARATOR.'img';
            $thumb = $dir.DIRECTORY_SEPARATOR.'thumb'; 
            $config = [
                'path' => $folder,
                'randomize' => true,
                'ext_whitelist' => array('img', 'jpg', 'jpeg', 'gif', 'png'),
                'prefix'      => 'image_'
            ];
            //set allowed upload size
            Upload::process($config, [
                //3mb = 3072kb
                'max_size'    => 3072               
            ]); 
            // if a valid file is passed than the function will save, or if it's NOT empty
            if (Upload::is_valid())
            {
                //create new series folder
                if (!is_dir($dir)) 
                {
                    mkdir($dir, 0777, true);      
                    if (!is_dir($img)) 
                    {
                        mkdir($img, 0777, true);     
                    }
                    if (!is_dir($thumb)) 
                    {
                        mkdir($thumb, 0777, true);     
                    }
                }
                //upload the new image file to dir
                Upload::save();
                //get all the image files that were uploaded
                $value = Upload::get_files();
                foreach ($value as $page)
                {
                    //foreach image create a thumbnail and save to db               
                    $file_name = $page['saved_as']; 
                    $thumb_name = str_replace('image_', 'thumb_', $file_name);
                    $thumb_file  = $thumb.DIRECTORY_SEPARATOR.$thumb_name;

                    //copy the uploaded file to create a thumbnail
                    $copied = copy($folder.DIRECTORY_SEPARATOR.$file_name , $thumb_file);
                    if($copied == true)
                    {
                       //resize image to thumbnail size
                    }
                    else 
                    {
                        echo 'Failed to make thumbnail image from book cover!';
                        die();
                    }
                }
                //upload success
                return $value;
            }
            else
            {
                return false;
            }
        }
        else
        {
            return false;
        }
        
    }

    /*
    public static function uploadImages($array=NULL)
    {
        // get an array with data id's
        // [$type, $series_id, $chapter_id, $page_id, $folder_name]
        // 
        //# folder name is to create a new folder with that name
        //# there are several types of upload
        // 0 = series book cover image
        // 1 = chapter cover image
        // 2 = single image page
        // 3 = many image pages

        // 
        if($array !== NULL && isset($array))
        {
            //prepare data
            $type = $array[0];
            $series = Model_Series::find($array[1]);
            $chapter = Model_Chapters::find($array[2]);
            $page = Model_Pages::find($array[3]);
            //prepare directories
            $comic_dir = 'assets'.DIRECTORY_SEPARATOR.'uploads'.DIRECTORY_SEPARATOR.'comic';
            if($series !== NULL && isset($series))
            {
                $string = str_replace(' ', '', $series->title);
                $series_folder = strtolower($string);
                $series_dir = 'assets'.DIRECTORY_SEPARATOR.'uploads'.DIRECTORY_SEPARATOR.'comic'
                    .DIRECTORY_SEPARATOR.$series_folder.DIRECTORY_SEPARATOR;
                $bookcover_dir = $series_dir.'bookcover';
                //if directory does not exist create one
                if (!is_dir($bookcover_dir)) 
                {
                    mkdir($bookcover_dir, 0777, true);         
                }
            }
            if($chapter !== NULL && isset($chapter))
            {
                $chapter_dir = $series_dir.'chapter_'.$chapter->chapter;
                $thumb_dir = $chapter_dir.DIRECTORY_SEPARATOR.'thumb'; 
                $cover_dir = $chapter_dir.DIRECTORY_SEPARATOR.'cover';
                //if directory does not exist create one
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
            }
            //set dir
            if($type == 0 && $array[4] !== NULL && !empty($array[4]))
            {
                $string = str_replace(' ', '', $array[4]);
                $series_folder = strtolower($string);
                //create a new series folder
                if (!is_dir($comic_dir.DIRECTORY_SEPARATOR.$series_folder)) 
                {
                    mkdir($comic_dir.DIRECTORY_SEPARATOR.$series_folder, 0777, true);         
                }  
                if (!is_dir($comic_dir.DIRECTORY_SEPARATOR.$series_folder.DIRECTORY_SEPARATOR.'bookcover')) 
                {
                    mkdir($comic_dir.DIRECTORY_SEPARATOR.$series_folder.DIRECTORY_SEPARATOR.'bookcover', 0777, true);         
                }  
                //set dir to series book cover image
                $dir = $comic_dir.DIRECTORY_SEPARATOR.$series_folder.DIRECTORY_SEPARATOR.'bookcover';
            }
            if($type == 0 && $series !== NULL && $array[4] == NULL)
            {
                //series book cover image
                $dir = $bookcover_dir;
            }
            if($type == 1 && $chapter !== NULL && $array[4] == NULL)
            {
                //chapter cover image
                $dir = $cover_dir;
            }
            if($type == 2)
            {
                //single image page
                $dir = $chapter_dir;
            }
            if($type == 3)
            {
                //many image pages
                $dir = $chapter_dir;
            }
            //check if dir has been set
            if(empty($dir) or !$dir or $dir == NULL)
            {
                return false;
            }
            //prepare configuration for image upload
            $config = [
                'path' => $dir,
                'randomize' => true,
                'ext_whitelist' => array('img', 'jpg', 'jpeg', 'gif', 'png'),
                'prefix'      => 'image_'
            ];
            //set allowed upload size
            Upload::process($config, [
                //3mb = 3072kb
                'max_size'    => 3072               
            ]); 
            // if a valid file is passed than the function will save, or if it's NOT empty
            if (Upload::is_valid())
            {
                //upload the new image file to dir
                Upload::save();
                //get all the image files that were uploaded
                $value = Upload::get_files();
                foreach ($value as $page)
                {
                    //foreach image create a thumbnail and save to db               
                    $file_name = $page['saved_as']; 
                    $thumb_name = str_replace('image_', 'thumb_', $file_name);
                    $thumb_file  = $dir.DIRECTORY_SEPARATOR.$thumb_name;

                    //fetch old image files from db to delete from directory
                    if(!$series or $series == NULL)
                    {
                        $result = Model_Comics::deleteImageFromDir($file_name, $dir);
                        $result = Model_Comics::deleteImageFromDir($thumb_name, $dir);
                        //copy the uploaded file to create a thumbnail
                        $copied = copy($dir.DIRECTORY_SEPARATOR.$file_name , $thumb_file);
                        if($copied == true)
                        {
                           //resize image to thumbnail size
                        }
                        else 
                        {
                            echo 'Failed to make thumbnail image from book cover!';
                            die();
                        }
                    }
                    else
                    {
                        $result = Model_Comics::deleteImageFromDir($series->imagename, $dir);
                        $result = Model_Comics::deleteImageFromDir($series->thumbname, $dir);
                        //copy the uploaded file to create a thumbnail
                        $copied = copy($dir.DIRECTORY_SEPARATOR.$file_name , $thumb_file);
                        if($copied == true)
                        {
                           //resize image to thumbnail size
                        }
                        else 
                        {
                            echo 'Failed to make thumbnail image from book cover!';
                            die();
                        }
                    }

                }
                //UPLOAD SUCCESS
                return $value;             
            }
            else
            {
                //file upload is empty
                //ERROR
                return false;
            }
        }
    } */


}