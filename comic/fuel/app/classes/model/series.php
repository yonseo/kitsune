<?php

class Model_Series extends Orm\Model
{
    protected static $_properties = [
        'id',
        'title',
        'author',
        'imagename',
        'thumbname',
        'illustrator',
        'genre'
    ];

	public static function getAllSeries()
    {
        // get all Links
        $posts = Model_Series::find('all');
        return $posts;
    }

    public static function getSeriesByTitle($title=NULL)
    {
        // get single series title name
        $post = Model_Series::find('first');
        return $post->title;
    }

    public static function replaceSeriesBookcover($series_id)
    {
        //replace cover image for series comic bookcover
        //directory to save image
        $series = Model_Series::find($series_id);
        $string = str_replace(' ', '', $series->title);
        $series_folder = strtolower($string);
        $series_dir = 'assets'.DIRECTORY_SEPARATOR.'uploads'.DIRECTORY_SEPARATOR.'comic'.DIRECTORY_SEPARATOR.$series_folder.DIRECTORY_SEPARATOR;
        $bookcover_dir = $series_dir.'cover';
        //check if folder exists, if not create one
        if (!is_dir($bookcover_dir)) 
        {
            mkdir($bookcover_dir, 0777, true);         
        }    

        $config = [
            'path' => $bookcover_dir.DIRECTORY_SEPARATOR.'img',
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
        if(empty(Input::post('series_title')) or Input::post('series_title') == NULL)
        {
            $errors++;
        }
        if(empty(Input::post('author')) or Input::post('author') == NULL)
        {
            $errors++;
        }
        if(empty(Input::post('illustrator')) or Input::post('illustrator') == NULL)
        {
            $errors++;
        }
        if(empty(Input::post('genre')) or Input::post('genre') == NULL)
        {
            $errors++;
        }
        // if a valid file is passed than the function will save, or if it's not empty
        if (Upload::is_valid())
        {
            //delete old cover image
            $bookcover_exists = file_exists(DOCROOT.$bookcover_dir.DIRECTORY_SEPARATOR.'img'.DIRECTORY_SEPARATOR.$series->imagename);
            $bookcover_thumb_exists = file_exists(DOCROOT.$bookcover_dir.DIRECTORY_SEPARATOR.'thumb'.DIRECTORY_SEPARATOR.$series->thumbname);
            //check if old file exists from folder directory 
            if($bookcover_exists == true && !empty($series->imagename) && $series->imagename !== NULL)
            {
                //delete old file
                $delete_image = unlink(DOCROOT.$bookcover_dir.DIRECTORY_SEPARATOR.'img'.DIRECTORY_SEPARATOR.$series->imagename);
                if($delete_image == false)
                {
                    echo "An error occurred deleting the image file from directory : ".$series->imagename;
                    die();
                }
            }
            if($bookcover_thumb_exists == true && !empty($series->thumbname) && $series->thumbname !== NULL)
            {
                //delete old file
                $delete_image = unlink(DOCROOT.$bookcover_dir.DIRECTORY_SEPARATOR.'thumb'.DIRECTORY_SEPARATOR.$series->thumbname);
                if($delete_image == false)
                {
                    echo "An error occurred deleting the image file from directory : ".$series->thumbname;
                    die();
                }
            }
            //upload the new image file into bookcover_dir
            Upload::save();
            //get all the image files that were uploaded
            $value = Upload::get_files();
            foreach ($value as $page)
            {
                //foreach image create a thumbnail and save to db               
                $file_name = $page['saved_as']; 
                $thumb_name = str_replace('image_', 'thumb_', $file_name);
                $thumb_file  = $bookcover_dir.DIRECTORY_SEPARATOR.'thumb'.DIRECTORY_SEPARATOR.$thumb_name;
                //save new image file to the database
                $series->title = Input::post('series_title');
                $series->imagename = $file_name;   
                $series->thumbname = $thumb_name;    
                $series->author = Input::post('author');  
                $series->genre =   Input::post('genre');  
                $series->illustrator = Input::post('illustrator');           
                $series->save();
                //copy the uploaded file to create a thumbnail
                $copied = copy($bookcover_dir.DIRECTORY_SEPARATOR.'img'.DIRECTORY_SEPARATOR.$file_name , $thumb_file);
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

}