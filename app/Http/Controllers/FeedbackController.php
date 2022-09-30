<?php

namespace App\Http\Controllers;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller; 
use App\Models\Feedback;  
use App\Models\User;
use Auth;
use DB;
use Request;
use Route;
use View;


class FeedbackController extends Controller
{
    private function getPostData()
	{
		 return Request::post();
	} 
	
	/**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    { 
 
	    $usergroups = User::select_single(Auth::id()); 
					
		$usergroup_id = $usergroups[0]['group_id']; 
		$usergroupname = $usergroups[0]['group_name'];
		
	    if($usergroupname =='Administrator')
		{
			$feedback = Feedback::select_all(); 
		}
		elseif($usergroupname =='Standard')
		{
			$feedback = Feedback::select_my_feedback(Auth::id());
		}		
		
		 
		for($i = 0;$i <= sizeof($feedback)-1; $i ++)
		{
			$feedback[$i]['created_on'] = date('d M Y', strtotime($feedback[$i]['created_on']));
			
			if($usergroupname =='Administrator')
			{
				$feedback[$i]['created_by'] = 'By '.$feedback[$i]['full_name'];
			} 
			elseif($usergroupname =='Standard')
			{
				$feedback[$i]['created_by'] = '';
			}	
		}  
		 
		  
		if(Request::ajax()) 
		{ 
			$json = json_encode($feedback);  
			
			return response($json, 200)->header('Content-Type', 'application/json;'); 
		}
		else
		{ 
			 // load the view and pass the variables
			return View::make('feedback.index')
            ->with('feedback', $feedback);
		} 
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function add($id)
    { 
		$feedback = Feedback::select_single($id);  //dd(DB::getQueryLog());	 
		$msg = array(); 
		
		
		if (Request::isMethod('post'))
		{
			$form_data=  $this->getPostData(); 
			$form_data['created_by'] = Auth::id();
			$form_data['created_on'] = date('Y-m-d H:i:s');
			$form_data['delete_flag'] = 0;
			unset($form_data['_token']);
			
			try 
			{
				  
				DB::table('feedback')->insert($form_data); 

				$msg=array(
					'type'=>'Success',
					'code'=>1,
					'text'=>'Comments added sucessfully');
			} 
			catch (\Exception  $e)
			{
				DB::rollback();

				$msg=array(
					'type'=>'error',
					'code'=>0,
					'text'=>$e->getMessage());
			}
		}
 
		
		
		
		if((Request::ajax()) && (Request::isMethod('post')))
		{ 
			$json = json_encode($msg);  
			
			return response($json, 200)->header('Content-Type', 'application/json;'); 
		} 
		if(Request::ajax())
		{ 
			 // load the view and pass the variables
			return View::make('feedback.form' )
			->with('action','add')
			->with('sbt_button','Save')
			->with('id',$id)
			->with('form',$feedback)  
			->with('msg',$msg) ; 
		} 
		else 
		{
		 
			 // load the view and pass the variables
			return View::make('feedback.form')
			->with('action','add')
			->with('sbt_button','Save')
			->with('id',$id) 
			->with('form',$feedback)  
			->with('msg',$msg) ; 
		}
    }
 

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    { 
	  
		$feedback = Feedback::select_single($id)->toArray();  
		$feedback = $feedback[0];  
	  
		$msg = array(); 
		
		
		if (Request::isMethod('post'))
		{
			$form_data=  $this->getPostData(); 
			$form_data['modified_by'] = Auth::id();
			$form_data['modified_on'] = date('Y-m-d H:i:s');
			unset($form_data['_token']);
			
			try 
			{
				Feedback::whereId($id)->update($form_data);
				

				$msg=array(
					'type'=>'Success',
					'code'=>1,
					'text'=>'Comments updated sucessfully');
			} 
			catch (\Exception  $e)
			{
				DB::rollback();

				$msg=array(
					'type'=>'error',
					'code'=>0,
					'text'=>$e->getMessage());
			}
		}
 
		
		
		
		if((Request::ajax()) && (Request::isMethod('post')))
		{ 
			$json = json_encode($msg);  
			
			return response($json, 200)->header('Content-Type', 'application/json;'); 
		} 
		if(Request::ajax())
		{ 
			 // load the view and pass the variables
			 return View::make('feedback.form')
			->with('action','edit')
			->with('sbt_button','Save')
			->with('id',$id)
			->with('form',$feedback)  
			->with('msg',$msg) ; 
		} 
		else 
		{
		 
			 // load the view and pass the variables
			return View::make('feedback.form')
			->with('action','edit')
			->with('sbt_button','Save')
			->with('id',$id) 
			->with('form',$feedback)  
			->with('msg',$msg) ; 
		}
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function delete($id)
    {
        $feedback = Feedback::select_single($id); 
		 
		$feedback = $feedback[0]; 
		
		$msg = array(); 
		
		
		if (Request::isMethod('post'))
		{
			$form_data=  $this->getPostData(); 
			$form_data['modified_by'] = Auth::id();
			$form_data['modified_on'] = date('Y-m-d H:i:s');
			$form_data['delete_flag'] = 1;
			$form_data['id'] = $id;
			unset($form_data['_token']);
			
			try 
			{
				$deleteid = explode("_", $id);
				Feedback::soft_delete($deleteid, $form_data['modified_by'], $form_data['modified_on']);
				

				$msg=array(
					'type'=>'Success',
					'code'=>1,
					'text'=>'Comments(ies) deleted sucessfully');
			} 
			catch (\Exception  $e)
			{
				DB::rollback();

				$msg=array(
					'type'=>'error',
					'code'=>0,
					'text'=>$e->getMessage());
			}
		} 
		
		
		if((Request::ajax()) && (Request::isMethod('post')))
		{ 
			$json = json_encode($msg);  
			
			return response($json, 200)->header('Content-Type', 'application/json;'); 
		} 
		if(Request::ajax())
		{ 
			 // load the view and pass the variables
			return View::make('feedback.form_delete')
			->with('action','delete')
			->with('sbt_button','Delete')
			->with('id',$id)
			->with('form',$feedback) 
			->with('msg',$msg) ;  
		} 
		else 
		{
		 
			 // load the view and pass the variables
			return View::make('feedback.form_delete')
			->with('action','delete')
			->with('sbt_button','Delete')
			->with('id',$id)
			->with('form',$feedback) 
			->with('msg',$msg) ; 
		} 
    }
	
	public function show()
    {
	}
	

}