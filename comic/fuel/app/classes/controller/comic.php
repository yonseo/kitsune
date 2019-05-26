<?php


class Controller_Comic extends Controller_Template
{

    public function __construct()
    {
        // Check if the current user is an administrator
        if (\Auth::check() && Auth::member(100))
        {
            //administrator access!
        }
        else
        {
            //DENIED ACCESS. Kick Out
            Session::set_flash('error', 'Access Denied!');
            Response::redirect('/');
        }
    }

	public function action_index()
	{
		$posts = Model_Series::getAllSeries();
		if($posts && $posts !==NULL)
		{
			$imgurl = DIRECTORY_SEPARATOR.'assets'.DIRECTORY_SEPARATOR.'uploads'.DIRECTORY_SEPARATOR.'comic'.DIRECTORY_SEPARATOR;
			$data = ['posts' => $posts, 'imgurl' => $imgurl];
	        $this->template->title = 'Series';
	        $this->template->content = View::forge('comic/index', $data);
		}
		else
		{
			//redirect to dahsboard
			Response::redirect('/');
		}
	}

	public function action_create($type=NULL,$id=NULL)
	{
		//create a new series
        if($type=='series' && $type !== NULL && $id == 'new' && $id !== NULL)
        {
            if(Input::post('SUBMIT'))
            {
            	$errors = 0;
            	$error_message = '';
            	if(!Input::post('series_title') or empty(Input::post('series_title')))
            	{
            		$errors++;
            		$error_message = $error_message.'<error>series title</error>  ';
            	}
            	if(!Input::post('author') or empty(Input::post('author')))
            	{
            		$errors++;
            		$error_message = $error_message.'<error>author</error>  ';
            	}
            	if(!Input::post('illustrator') or empty(Input::post('illustrator')))
            	{
            		$errors++;
            		$error_message = $error_message.'<error>illustrator</error>  ';
            	}
            	if(!Input::post('genre') or empty(Input::post('genre')))
            	{
            		$errors++;
            		$error_message = $error_message.'<error>genre</error> ';
            	}
            	if($errors == 0)
            	{
            		$dir = Model_Comics::fetchDir([NULL, NULL]);
		            //organize dir
		            $comic_dir = $dir[0];
		            //list all directories to be created
		            $string = str_replace(' ', '', Input::post('series_title'));
	            	$series_folder = strtolower($string);
		            $dir = $comic_dir.DIRECTORY_SEPARATOR.$series_folder.DIRECTORY_SEPARATOR.'cover';  
		            //upload images 
	            	$result = Model_Comics::uploadImages([0, $dir]);
	            	if($result !== false && $result !== NULL && !empty($result))
	            	{
	            		//save files to db
	            		$series = new Model_Series();
	            		foreach($result as $file)
	            		{
	            			$series->imagename = $file['saved_as'];
	            			$thumb_name = str_replace('image_', 'thumb_', $file['saved_as']);
	            			$series->thumbname = $thumb_name;
	            		}
	            		$series->title = Input::post('series_title');
	            		$series->author = Input::post('author');
	            		$series->illustrator = Input::post('illustrator');
	            		$series->genre = Input::post('genre');
	            		$series->save();

		                Session::set_flash('success', 'New Series Created.');
		                Response::redirect('/comic');
		            }
		            else
		            {
		            	Session::set_flash('error', 'ERROR: creating a series.');
		                Response::redirect('/comic/create/series/new');
		            }
		        }
		        else
	            {
	            	Session::set_flash('error', 'ERROR: missing inputs : '.$error_message);
	                Response::redirect('/comic/create/series/new');
	            }
            }
            //render form
            $data = [''];
            $this->template->title = 'New Tankōbon';
            $this->template->content = View::forge('comic/create/series', $data);
        }
        if($type=='chapter' && $type !== NULL && is_numeric($id) && $id !== NULL)
        {
        	$series = Model_Series::find($id);
            $total_chapters = Model_Comics::getAllChaptersFromSeriesID($series->id);
    		if($total_chapters !== NULL){ $new_chapter = count($total_chapters) + 1; }else { $new_chapter = 1; }
            if(Input::post('SUBMIT'))
            {            
            	//check for errors
            	$errors = 0;
            	$error_message = '';
            	$count_chapters = count($total_chapters);
            	if($count_chapters == Input::post('chapter_number'))
            	{
					//if chapter already exists then redirect		
					$errors ++;
					Session::set_flash('error', 'ERROR: chapter '.Input::post('chapter_number').' already exists.');
                	Response::redirect('/comic/create/chapter/'.$id);
            	}
            	if(empty(Input::post('chapter_title')) or !Input::post('chapter_title'))
            	{
            		$errors ++;
            		$error_message = $error_message.' <error>chapter title</error>';
            	}
            	if(empty(Input::post('chapter_number')) or !Input::post('chapter_number'))
            	{
            		$errors ++;
            		$error_message = $error_message.' <error>chapter number</error>';
            	}
                if($series && $series !== NULL && $errors == 0)
                {
                	//prepare DIR
					$dir = Model_Comics::fetchDIR([$series->id, NULL]);
					$comic_dir = $dir[0];
					$series_dir = $dir[1];
					$dir = $series_dir.DIRECTORY_SEPARATOR.'chapter_'.$new_chapter.DIRECTORY_SEPARATOR.'cover';
	            	$result = Model_Comics::uploadImages($dir);
                	if($result !== false && !empty($result))
                	{
                		foreach($result as $file)
	            		{
	            			$image_name = $file['saved_as'];
	            			$thumb_name = str_replace('image_', 'thumb_', $file['saved_as']);
	            		
		            		$new_chapter = new Model_Chapters();
		            		$new_chapter->title = Input::post('chapter_title');
		            		$new_chapter->chapter = Input::post('chapter_number');
		            		$new_chapter->group = $series->id;
		            		$new_chapter->pages = 1;
		            		$new_chapter->imagename = $image_name;
		            		$new_chapter->thumbname = $thumb_name;
		            		$new_chapter->save();
		            	}
	            		//redirect
                		Session::set_flash('success', 'New Chapter Created.');
                		Response::redirect('/comic/view/'.$series->id);
                	}
                	else
                	{
                		Session::set_flash('error', 'ERROR: creating a new chapter. Empty upload.');
                		Response::redirect('/comic/create/chapter/'.$id);
                	}
                }
                else
				{
					//errors found
	                Session::set_flash('error', 'ERROR: missing input : '.$error_message);
	                Response::redirect('/comic/create/chapter/'.$id);
	            }
            }
            $series_data = Model_Series::find($id);
            $series = $series_data->title;
            $chapters = Model_Comics::getAllChaptersFromSeriesID($series_data->id);
            $data = ['series' => $series, 'new_chapter' => $new_chapter];
            $this->template->title = 'New Chapter';
            $this->template->content = View::forge('comic/create/chapter', $data);
        }

        if($type=='pages' && $type !== NULL && is_numeric($id) && $id !== NULL)
        {
        	//upload new image pages
        	$chapter = Model_Chapters::find($id);
        	$series = Model_Series::find($chapter->group);
        	if($series !== NULL && $chapter !== NULL && $chapter->group == $series->id)
            {
	            if(Input::post('SUBMIT'))
	            {
	            	//prepare DIR
					$dir = Model_Comics::fetchDIR([$series->id, $chapter->id]);
					$comic_dir = $dir[0];
					$series_dir = $dir[1];
					$comic_cover_dir = $dir[2];
					$chapter_cover_dir = $dir[3];
					$page_dir = $dir[4];
	            	$result = Model_Comics::uploadImages($page_dir);
	            	if($result !== false && !empty($result) && $result !== NULL or $result == true)
	            	{
	            		//update db
						foreach ($result as $page)
            			{
        					$img_name = $page['saved_as'];
							$thumb_name = str_replace('image_', 'thumb_', $img_name);

	                    	//old files deleted from folder
		                    //update new filenames to db
		                    $new_page = new Model_Pages();
		                    //get number of pages in chapter
			            	$pages_data = Model_Comics::getAllPagesFromChapterID($chapter->id);
			            	if($pages_data !== NULL or !empty($pages_data))
			            	{
			            		$total_pages = count($pages_data) + 1;
			            	}
			            	else
			            	{
			            		$total_pages = 1;
			            	}
		                    $new_page->page = $total_pages;
		                    $new_page->imagename = $img_name;
							$new_page->thumbname = $thumb_name;
							$new_page->group = $chapter->id;
							$new_page->save();
							
						}
	            		Session::set_flash('success', 'All new pages uploaded.');
	            		Response::redirect('/comic/edit/'.$series->id.'/'.$chapter->id);
	            	}
	            	else
	            	{
	            		Session::set_flash('error', 'Upload failed.');
	            	}
	            	//redirect back to chapter page
                	Response::redirect('/comic/create/pages/'.$chapter->id);
	            }
	            //render pages form
	            $data = ['series' => $series, 'chapter' => $chapter];
	            $this->template->title = 'Upload Pages';
	            $this->template->content = View::forge('comic/create/pages', $data);
	        }
	        else
	        {
	        	//ERROR
	        	Session::set_flash('error', 'Chapter not found.');
                Response::redirect('/comic');
	        }
        }

        if($type == NULL && $id == NULL or $type == NULL or $id == NULL)
        {
            //no type selected
            Response::redirect('/comic');
        }
	}

	public function action_read($series_id=NULL, $chapter_id=NULL, $page_num=NULL)
	{
		//##============================== read comic pages
		//get all pages for this chapter
		//$posts = Model_Comics::getAllPagesFromChapterID($chapter_id);
		//get series data
		$series_data = Model_Series::find($series_id);
		//get chapter data
		$chapter_data = Model_Chapters::find($chapter_id);
		//get single page from chapter id
		$posts = Model_Comics::getPageFromChapterID($chapter_id, $page_num);
		//check if chapter group matches series id
		if($posts !== NULL && $series_data !== NULL && $chapter_data !== NULL && $series_data->id == $chapter_data->group)
		{	
			if($posts && $posts !==NULL)
			{
				$dir = Model_Comics::fetchURL([$series_data->id, $chapter_data->id]);
				$comic_dir = $dir[0];
				$series_dir = $dir[1];
				$comic_cover_dir = $dir[2];
				$chapter_cover_dir = $dir[3];
				$pages = $dir[4];

				$string = str_replace(' ', '', $series_data->title);
				$series_folder = strtolower($string);
				$series = $series_data->title;
				$page_url = 'comic/read/'.$series_data->id.'/'.$chapter_data->id.'/';
				$total_pages = count(Model_Comics::getAllPagesFromChapterID($chapter_data->id));
				$data = [
					'posts' => $posts, 
					'pages' => $pages, 
					'series' => $series, 
					'page_url' => $page_url,
					'total_pages' => $total_pages
				];
		        $this->template->title = $series.'/Chapter '.$chapter_data->chapter.'/'.$chapter_data->title;
		        $this->template->content = View::forge('comic/read', $data);
			}
		}
		else
		{
			//redirect to dahsboard
			Response::redirect('/comic/view/'.$series_data->id);
		}
	}

	public function action_view($id=NULL)
	{
		//view all chapters from a single series id
		$series = Model_Comics::getSeries($id);
		if($series && $series !==NULL)
		{
			//prepare dir
			$dir = Model_Comics::fetchURL([$id, NULL]);
			$comic_dir = $dir[0];
			$series_dir = $dir[1];
			$comic_cover = $dir[2];
			$chapter_cover = $dir[3];
			$pages = $dir[4];

			$posts = Model_Comics::getAllChaptersFromSeriesID($series->id);
			$total_chapters = count($posts);
			//render view
			$data = [
				'posts' => $posts,
				'total_chapters' => $total_chapters,
				'series' => $series,
				'comic_cover' => $comic_cover,
				'comic_dir' => $comic_dir
			];
	        $this->template->title = 'Tankōbon';
	        $this->template->content = View::forge('comic/view', $data);
		}
		else
		{
			//redirect to dahsboard
			Response::redirect('/');
		}
	}

	public function action_edit($page=NULL, $id=NULL)
	{
		//##=============== EDIT 'cover'/series id
		if($page == 'bookcover' && !empty($id) && $id !== NULL && is_numeric($id))
		{
			$series = Model_Series::find($id);
			if($series !== NULL)
			{
				$chapters = Model_Comics::getAllChaptersFromSeriesID($series->id);
				if( Input::post('SUBMIT') && $series !== NULL && $chapters !== NULL)
				{
					$errors = 0;
	            	$error_message = '';
	            	if(!Input::post('series_title') or empty(Input::post('series_title')))
	            	{
	            		$errors++;
	            		$error_message = $error_message.'<error>series title</error>  ';
	            	}
	            	if(!Input::post('author') or empty(Input::post('author')))
	            	{
	            		$errors++;
	            		$error_message = $error_message.'<error>author</error>  ';
	            	}
	            	if(!Input::post('illustrator') or empty(Input::post('illustrator')))
	            	{
	            		$errors++;
	            		$error_message = $error_message.'<error>illustrator</error>  ';
	            	}
	            	if(!Input::post('genre') or empty(Input::post('genre')))
	            	{
	            		$errors++;
	            		$error_message = $error_message.'<error>genre</error> ';
	            	}

	            	if($errors == 0)
	            	{
	            		//upload the book cover image
	            		$dir = Model_Comics::fetchDIR([$series->id, NULL]);
						$comic_cover = $dir[2];
						$result = Model_Comics::uploadImages($comic_cover);
						if($result == true or $result !== false)
						{
							//update db
							foreach ($result as $page)
                			{
                				//fetch old image files from db to delete from directory
                				$img = $comic_cover.DIRECTORY_SEPARATOR.'img';
            					$thumb = $comic_cover.DIRECTORY_SEPARATOR.'thumb'; 
            					$img_name = $page['saved_as'];
								$thumb_name = str_replace('image_', 'thumb_', $img_name);

			                    $delete_img = Model_Comics::deleteImageFromDir($series->imagename, $img);
			                    $delete_thumb = Model_Comics::deleteImageFromDir($series->thumbname, $thumb);
			                    if($delete_img == true && $delete_thumb == true)
			                    {
			                    	//old files deleted from folder
				                    //update new filenames to db
				                    $series->imagename = $img_name;
									$series->thumbname = $thumb_name;
									$series->title = Input::post('series_title');
									$series->genre = Input::post('genre');
									$series->author = Input::post('author');
									$series->illustrator = Input::post('illustrator');
									$series->save();
									$series->save();
									Session::set_flash('success', 'Book cover image replaced.');
									Response::redirect('/comic/view/'.$series->id);
								}
								else
								{
									//delete new files from folder
									Model_Comics::deleteImageFromDir($img_name, $img);
									Model_Comics::deleteImageFromDir($thumb_name, $thumb);
								}
							}
							Session::set_flash('error', 'ERROR: failed to delete old image files. <error>Upload denied</error>');
							Response::redirect('/comic/edit/bookcover/'.$series->id);
						}
						else
						{
							//No image uploaded. Update data
							$series->title = Input::post('series_title');
							$series->genre = Input::post('genre');
							$series->author = Input::post('author');
							$series->illustrator = Input::post('illustrator');
							$series->save();
							Session::set_flash('success', 'Updated series details.');
							Response::redirect('/comic/view/'.$series->id);
						}
					}
					else
					{
						Session::set_flash('error', 'ERROR: missing input : '.$error_message);
						Response::redirect('/comic/edit/bookcover/'.$series->id);
					}
				}
				//prepare dir
				$dir = Model_Comics::fetchURL([$series->id, NULL]);
				$comic_dir = $dir[0];
				$series_dir = $dir[1];
				$comic_cover = $dir[2];
				$chapter_cover = $dir[3];
				$pages = $dir[4];
				//render form
				$total_chapters = count($chapters);
				$string = str_replace(' ', '', $series->thumbname);
				$thumb_name = strtolower($string);
				$imgurl = $comic_cover.DIRECTORY_SEPARATOR.'thumb'.DIRECTORY_SEPARATOR.$thumb_name;
				$data = [
					'series' => $series,
					'imgurl' => $imgurl,
					'total_chapters' => $total_chapters
				];
				$this->template->title = 'Edit Series Details';
	        	$this->template->content = View::forge('comic/edit/series_details', $data);
	        }
	        else
	        {
	        	Session::set_flash('error', 'ERROR: no series found.');
				Response::redirect('/comic');
	        }
		}
		//##=============== EDIT 'cover'/chapter id
		if($page == 'cover' && !empty($id) && $id !== NULL && is_numeric($id))
		{
			//##=================== edit a chapters details
			$chapter = Model_Chapters::find($id);
			$series = Model_Series::find($chapter->group);
			if( Input::post('SUBMIT') && $chapter !== NULL)
			{
				$dir = Model_Comics::fetchDIR([NULL, $chapter->id]);
				$chapter_cover = $dir[3];
				$result = Model_Comics::uploadImages($chapter_cover);
				if($result !== false && !empty($result) && $result !== NULL)
				{
					foreach ($result as $page) 
					{
						$img = $chapter_cover.DIRECTORY_SEPARATOR.'img';
						$thumb = $chapter_cover.DIRECTORY_SEPARATOR.'thumb';
						$img_name = $page['saved_as'];
						$thumb_name = str_replace('image_', 'thumb_', $img_name);
						//delete old image files
						$delete_img = Model_Comics::deleteImageFromDir($chapter->imagename, $img);
	                    $delete_thumb = Model_Comics::deleteImageFromDir($chapter->thumbname, $thumb);

	                    if($delete_img == true && $delete_thumb == true)
	                    {
	                    	//save new image files to db
							$chapter->imagename = $img_name;
							$chapter->thumbname = $thumb_name;
							$chapter->save();
							Session::set_flash('success', 'Chapter cover image replaced.');
							Response::redirect('/comic/edit/'.$chapter->group.'/'.$chapter->id);
						}
						else
						{
							//delete new image files
							Model_Comics::deleteImageFromDir($img_name, $img);
	                    	Model_Comics::deleteImageFromDir($thumb_name, $thumb);
						}
					}
					Session::set_flash('error', 'ERROR: failed to delete old image files. <error>Upload denied</error>');
					Response::redirect('/comic/edit/cover/'.$chapter->id);
				}
				else
				{
					Session::set_flash('error', 'ERROR: failed uploading chapter cover image.');
					Response::redirect('/comic/edit/cover/'.$chapter->id);
				}
			}

			//render form
			$all_pages = Model_Comics::getAllPagesFromChapterID($chapter->id);
			if($all_pages != NULL){ $page_count = count($all_pages); } else { $page_count = 0; }
			$total_pages = $page_count;
			$string = str_replace(' ', '', $series->title);
			$series_folder = strtolower($string);
			$imgurl = DIRECTORY_SEPARATOR.'assets'.DIRECTORY_SEPARATOR.'uploads'.DIRECTORY_SEPARATOR.'comic'
			.DIRECTORY_SEPARATOR.$series_folder.DIRECTORY_SEPARATOR.'chapter_'.$chapter->chapter.DIRECTORY_SEPARATOR.'cover'.DIRECTORY_SEPARATOR.'img'.DIRECTORY_SEPARATOR;
			$data = [
				'series' => $series,
				'chapter' => $chapter,
				'imgurl' => $imgurl,
				'total_pages' => $total_pages
			];
			$this->template->title = 'Edit Chapter Details';
        	$this->template->content = View::forge('comic/edit/chapter_details', $data);
		}

		//##=============== EDIT 'PAGE'/page id
		if($page == 'page' && !empty($id) && $id !== NULL && is_numeric($id))
		{
			//edit a single page image
			$page = Model_Pages::find($id);
			$chapter = Model_Comics::getChapterFromPageID($page->id);
			$series = Model_Comics::getSeries($chapter->group);
			if($page && $page !== NULL&& $chapter !== NULL && $series !== NULL && $page->group == $chapter->id)
			{
				//prepare URL
				$dir = Model_Comics::fetchURL([$series->id, $chapter->id]);
				$comic_dir = $dir[0];
				$series_dir = $dir[1];
				$comic_cover = $dir[2];
				$chapter_cover = $dir[3];
				$pages = $dir[4];
				if(Input::post('UPLOAD') && $page->group == $chapter->id)
				{
					//prepare DIR
					$dir = Model_Comics::fetchDIR([$series->id, $chapter->id]);
					$comic_dir = $dir[0];
					$series_dir = $dir[1];
					$comic_cover = $dir[2];
					$chapter_cover = $dir[3];
					$pages = $dir[4];
					$result = Model_Comics::uploadImages($pages);
					if($result !== false && !empty($result))
					{
						foreach($result as $file)
						{
							//delete old image files
							$img = $pages.DIRECTORY_SEPARATOR.'img';
							$thumb = $pages.DIRECTORY_SEPARATOR.'thumb';
							
							//delete old image files
							$delete_img = Model_Comics::deleteImageFromDir($page->imagename, $img);
		                    $delete_thumb = Model_Comics::deleteImageFromDir($page->thumbname, $thumb);

		                    if($delete_img == true && $delete_thumb == true)
		                    {
								//update db
								$image_name = $file['saved_as'];
								$thumb_name = str_replace('image_', 'thumb_', $image_name);
								$page->imagename = $image_name;
								$page->thumbname = $thumb_name;
								$page->save();
								Session::set_flash('success', 'Page Uploaded.');
								Response::redirect('comic/edit/'.$series->id.'/'.$chapter->id);
							}
							else
							{
								//failed to delete old image files
								Session::set_flash('error', 'ERROR: failed to delete old image files.');
								Response::redirect('comic/edit/page/'.$page->id);
							}
						}
					}
					else
					{
						Session::set_flash('error', 'ERROR: uploading image.');
						Response::redirect('/comic/edit/page/'.$page->id);
					}
				}
				//render form
				$page_url = $pages;
				$data = [
					'page' => $page,
					'series' => $series,
					'chapter' => $chapter,
					'page_url' => $page_url
				];
			    $this->template->title = 'Edit a Page';
			    $this->template->content = View::forge('comic/edit/page', $data);
			}
			
		}
		//##=============== EDIT SERIES id/CHAPTER id
		if($page !== NULL && is_numeric($page) && !empty($id) && $id !== NULL && is_numeric($id))
		{
			//##================= view and edit a single chapter
			//get all pages for this chapter
			$posts = Model_Comics::getAllPagesFromChapterID($id);
			//get series data
			$series_data = Model_Series::find($page);
			//get chapter data
			$chapter_data = Model_Chapters::find($id);
			//check if chapter group matches series id
			if(!$posts or $posts == NULL)
			{
				//no pages found
				$posts = [];
			}
			if($series_data !== NULL && $chapter_data !== NULL && $series_data->id == $chapter_data->group)
			{				
				//prepare URL
				$dir = Model_Comics::fetchURL([$series_data->id, $chapter_data->id]);
				$comic_dir = $dir[0];
				$series_dir = $dir[1];
				$comic_cover_dir = $dir[2];
				$chapter_cover_dir = $dir[3];
				$page_dir = $dir[4];
				//prepare the data
				$series = $series_data->title;
				$author = $series_data->author;
				$chapter_id = $chapter_data->id;
				$chapter = $chapter_data->chapter;
				$chapter_name = $chapter_data->title;
				$total_chapters = count(Model_Comics::getAllChaptersFromSeriesID($page));
				if($posts == NULL){ $total_pages = 0; }else { $total_pages = count($posts); }			
				$string = str_replace(' ', '', $series);
				$series_folder = strtolower($string);
				$imgurl = DIRECTORY_SEPARATOR.'assets'.DIRECTORY_SEPARATOR.'uploads'.DIRECTORY_SEPARATOR.'comic'
				.DIRECTORY_SEPARATOR.$series_folder.DIRECTORY_SEPARATOR.'chapter_'.$chapter.DIRECTORY_SEPARATOR.'thumb'.DIRECTORY_SEPARATOR;
				//display in view
				$chapter_dir = 'comic'.DIRECTORY_SEPARATOR.$series_folder.DIRECTORY_SEPARATOR.'chapter_'.$chapter.DIRECTORY_SEPARATOR;
				$series_dir = 'comic'.DIRECTORY_SEPARATOR.$series_folder.DIRECTORY_SEPARATOR;
				$chaptercover = DIRECTORY_SEPARATOR.'assets'.DIRECTORY_SEPARATOR.'uploads'.DIRECTORY_SEPARATOR.$chapter_dir.'cover'
				.DIRECTORY_SEPARATOR.'img'.DIRECTORY_SEPARATOR.$chapter_data->imagename;
				//render view
				$data = [
					'posts' => $posts, 
					'series' => $series, 
					'author' => $author, 
					'chapter' => $chapter, 
					'chapter_name' => $chapter_name,
					'chapter_id' => $chapter_id,
					'total_pages' => $total_pages,
					'imgurl' => $imgurl,
					'chapter_dir' => $chapter_dir,
					'series_dir' => $series_dir,
					'chaptercover' => $chaptercover,
					'total_chapters' => $total_chapters,
					'page_dir' => $page_dir
				];
			    $this->template->title = 'Edit a Chapter';
			    $this->template->content = View::forge('comic/edit/chapter', $data);
			}
			else
			{
				if($series_data->id !== $chapter_data->group)
				{
					//chapter was not found
					Session::set_flash('error', 'Chapter was not found.');
					Response::redirect('/comic');
				}
				if($series_data == NULL or !$series_data)
				{
					//series was not found
					Session::set_flash('error', 'Series was not found.');
					Response::redirect('/comic');
				}
				//ERROR
				Session::set_flash('error', 'ERROR: fetching comic chapter.');
				Response::redirect('/comic');
			}
		}
	}

}
