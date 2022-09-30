<?php
namespace App\Http\Controllers;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller; 
use App\Models\Bikes;  
use App\Models\Cities; 
use App\Http\Models\Modules;
use App\Models\User;
use App\Models\Dashboard;
use Auth;
use DB;
use Request;
use Route;  
use View;

class DashboardController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
   /* public function __construct()
    {
       // $this->middleware('auth');
    }*/

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
     
		return View::make('home');
		
    }
	
	public function vendorbikes()
    {
    
		$vendor_bikes = Dashboard::select_vendor_bikes(); 
		$total_count = 0;
		for($i = 0;$i <= sizeof($vendor_bikes)-1; $i ++)
		{
			$total_count += $vendor_bikes[$i]['total']; 
			
		}  
		
		for($i = 0;$i <= sizeof($vendor_bikes)-1; $i ++)
		{
			$vendor_bikes[$i]['percent'] = number_format(($vendor_bikes[$i]['total']/$total_count)*100);  
			$vendor_bikes[$i]['y'] = $vendor_bikes[$i]['total'];
			$vendor_bikes[$i]['name']      	= $vendor_bikes[$i]['Vendor'];
			
		}  
		  
		  
		$json = json_encode($vendor_bikes);  
			
		return response($json, 200)->header('Content-Type', 'application/json;'); 
		
    }
	
	public function customerbookings()
    {
    
		$bookings = Dashboard::select_customer_bookings(); 
		$total_count = 0;
		for($i = 0;$i <= sizeof($bookings)-1; $i ++)
		{
			$total_count += $bookings[$i]['total']; 
			
		}  
		
		for($i = 0;$i <= sizeof($bookings)-1; $i ++)
		{
			$bookings[$i]['percent'] = number_format(($bookings[$i]['total']/$total_count)*100);  
			$bookings[$i]['y'] = $bookings[$i]['total'];
			$bookings[$i]['name']  = $bookings[$i]['full_name'];
			
		}  
		  
		  
		$json = json_encode($bookings);  
			
		return response($json, 200)->header('Content-Type', 'application/json;'); 
		
    }
	
	public function bookingsdate()
    {
    
		$bookings = Dashboard::select_bookings_by_date(); 
		$total_count = 0;
		$graph_data = array();
		
		for($i = 0;$i <= sizeof($bookings)-1; $i ++)
		{
			$bookings[$i]['booked_on'] = date('Y-m-d', strtotime($bookings[$i]['booked_on'])); 
			$bookings[$i]['y'] = $bookings[$i]['total'];
			$bookings[$i]['name']  = $bookings[$i]['booked_on'];	

			array_push($graph_data, array('booked_on' => date('d M Y', strtotime($bookings[$i]['booked_on'])), 'response'=> $bookings[$i]['total']));
			
		}  
		 
		  
		  
		$json = json_encode($graph_data);  
			
		return response($json, 200)->header('Content-Type', 'application/json;'); 
		
    }
	
	
	public function show()
    {
	}
	
}
