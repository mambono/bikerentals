<?php
namespace App\Http\Controllers;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller; 
use App\models\Bikes;  
use App\models\Cities; 
use App\Http\Models\Modules;
use App\models\User;
use App\models\Dashboard;
use Auth;
use DB;
use Request;
use Route;  
use View;

class HomeController extends Controller
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
		  
		$json = json_encode($vendor_bikes);  
			
		return response($json, 200)->header('Content-Type', 'application/json;'); 
		
    }
	
	
	public function show()
    {
	}
	
}
