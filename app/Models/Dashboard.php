<?php
namespace App\models;

use Illuminate\Database\Eloquent\Model;
use DB;
 
class Dashboard extends Model
{
 
	 
	public static function select_vendor_bikes()
	{
		$sql = Bikes::select(DB::raw('COUNT(bikes.id) AS total'), DB::raw('vendors.vendor_name AS Vendor'))
		->join('vendors', 'vendors.id', '=', 'bikes.vendor_id')  
		->where([ 'vendors.delete_flag'=>0, 'bikes.delete_flag'=>0 ]) 
		->groupby('vendors.vendor_name') 
		->get();     
		return	$sql;   
	}
	
	 
	public static function select_customer_bookings()
	{
		$sql = Bikes::select(DB::raw('COUNT(bikes.id) AS total'),  DB::raw('CONCAT(users.first_name, " ", users.last_name) AS full_name'))
		->join('users', 'users.id', '=', 'bikes.vendor_id')  
		->where([ 'users.delete_flag'=>0, 'bikes.delete_flag'=>0 ]) 
		->groupby('users.first_name', 'users.last_name') 
		->get();     
		return	$sql;   
	}
	
	public static function select_bookings_by_date()
	{
		$sql = Bikes::select(DB::raw('COUNT(bike_bookings.id) AS total'),  DB::raw('Date(bike_bookings.booked_on)  AS booked_on'))
		->join('bike_bookings', 'bikes.id', '=', 'bike_bookings.bike_id')  
		->where([ 'bike_bookings.delete_flag'=>0 ])  
		->groupBy(DB::raw('Date(bike_bookings.booked_on)')) 
		->get();     
		return	$sql;   
	}
	   
	
	public static function select_single($id)
	{
		$sql = Cities::select('cities.id',   'cities.city',  'cities.created_by', 'cities.created_on', 'cities.modified_by', 'cities.modified_on', 'cities.delete_flag') 
		->where(['cities.delete_flag'=>0, 'cities.id'=>$id])
		->groupby()
		->orderby('cities.city', 'desc') 
		->get();   
		return	$sql;  
	}
	  
	
	public static function soft_delete($deleteid, $modified_by, $modified_on)
	{			 
		
		if( is_array($deleteid) )
		{ 
			DB::table('cities')
			->whereIn('id', $deleteid)
			->update(['delete_flag' => '1', 'modified_by' => $modified_by, 'modified_on' => $modified_on]); 
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
 
    protected $table = 'cities';
}
 