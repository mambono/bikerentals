<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;
 
class Feedback extends Model
{
 
	 
	public static function select_all()
	{
			$sql = Feedback::select('feedback.id',  'feedback.comments', DB::raw('CONCAT(users.first_name, " ", users.last_name) AS full_name'),   'feedback.created_by', 'feedback.created_on', 'feedback.delete_flag') 
			->join('users', 'feedback.created_by', '=', 'users.id')
			->where(['feedback.delete_flag'=>0 ]) 
			->groupby()
			->orderby('feedback.created_on','asc')
			->get();    
			 
				
			
		return	$sql;  
		 
		
	}
	
	
	public static function select_my_feedback($id)
	{
		$sql = Feedback::select('feedback.id',  'feedback.comments',   'feedback.created_by', 'feedback.created_on', 'feedback.delete_flag')
		->where(['feedback.delete_flag'=>0,  'feedback.created_by'=>$id ]) 
		->groupby()
		->orderby('feedback.created_on', 'desc') 
		->get();   
		return	$sql;  
	} 
	  
	
	public static function select_single($id)
	{
		$sql = Feedback::select('feedback.id',   'feedback.comments',  'feedback.created_by', 'feedback.created_on', 'feedback.delete_flag') 
		->where(['feedback.delete_flag'=>0, 'feedback.id'=>$id])
		->groupby()
		->orderby('feedback.comments', 'desc') 
		->get();   
		return	$sql;  
	}
	  
	
	public static function soft_delete($deleteid, $modified_by, $modified_on)
	{			 
		
		if( is_array($deleteid) )
		{ 
			DB::table('feedback')
			->whereIn('id', $deleteid)
			->update(['delete_flag' => '1']); 
		}
	}
	
	
    protected $primaryKey = 'id';
	/**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = true;
	
    public $timestamps = false;
	 const CREATED_AT = 'created_on';
    const UPDATED_AT = 'modified_on';
	/**
     * The table associated with the model.
     *
     * @var string
     */
 
    protected $table = 'feedback';
}
 