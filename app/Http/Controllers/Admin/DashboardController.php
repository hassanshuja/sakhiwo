<?php

namespace App\Http\Controllers\Admin;

use App\Models\Auth\User\User;
use Arcanedev\LogViewer\Entities\Log;
use Arcanedev\LogViewer\Entities\LogEntry;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Routing\Route;
use App\Charts\dashboardchart;
use App\Quotes;

trait PrintReport {

    function getMonthName($n){
        return date('F', mktime(0, 0, 0, $n, 1));
    }
}

class DashboardController extends Controller
{
    use PrintReport;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $counts = [
            'users' => \DB::table('users')->count(),
            'users_unconfirmed' => \DB::table('users')->where('confirmed', false)->count(),
            'users_inactive' => \DB::table('users')->where('active', false)->count(),
            'protected_pages' => 0,
        ];

         $getTotals = \DB::table('quotes')->selectRaw('SUM(Round(price,2)) as price, status, count(id) as quotesCount')
                            ->where('status', '>', 0)->groupBy('status')->orderBy('status','ASC')->get();

        $getStatus = \DB::table('status')->get();

        foreach (\Route::getRoutes() as $route) {
            foreach ($route->middleware() as $middleware) {
                if (preg_match("/protection/", $middleware, $matches)) $counts['protected_pages']++;
            }
        }

       // $quotesData= Quotes::where('status', 6)->selectRaw('SUM(price) as price, MONTHNAME(vetting_date) as monthname')->groupBy(\DB::raw('MONTH(DATE(vetting_date))'))->get();

         $quotesData= Quotes::whereRaw('YEAR(vetting_date) = YEAR(CURDATE()) AND status = 6')->selectRaw('SUM(price) as price, MONTHNAME(vetting_date) as monthname')->groupBy(\DB::raw('MONTH(DATE(vetting_date))'))->get();

         $quotesData_previous = Quotes::whereRaw('YEAR(vetting_date) = YEAR(DATE_SUB(CURDATE(), INTERVAL 1 YEAR)) AND status = 6')->selectRaw('SUM(price) as price, MONTHNAME(vetting_date) as monthname')->groupBy(\DB::raw('MONTH(DATE(vetting_date))'))->get();


     $start = 1; //use Input::get()
    $end = 12; //use Input::get()
   // $instance = new Quotes();

    $categoryArray = array_map(array($this, 'getMonthName'), range($start,$end));
    $series = array();
    $pre_series = array();
    $i = 0;        

  
    foreach($categoryArray as $months){
        foreach($quotesData as $datas){

                if($months == $datas->monthname){

                    $series[$i] = $datas->price; 

                    break;
                }else{
                    $series[$i] = 0;  
                    
                }
            }
        $i++;       
    }
$i =0;
     foreach($categoryArray as $months){
        foreach($quotesData_previous as $datas){

                if($months == $datas->monthname){

                    $pre_series[$i] = $datas->price; 

                    break;
                }else{
                    $pre_series[$i] = 0;  
                    
                }
            }
        $i++;       
    }
  

    $chartArray["chart"] = array("type" => "column" , "renderTo" => 'container');
    $chartArray["title"] = array("text" => "Vetted Reports");
    $chartArray["yAxis"] = array("title" => array("text" => "Amounts"));
    $chartArray["xAxis"] = array("categories" => $categoryArray);


    $chartArray["series"] = [
        array("name" => date("Y"), "data" => $series),
        array("name" => date("Y") - 1 , "data" => $pre_series)
    ];



    //$chartArray["series"] = [$series];


// $monthData = array();
//     foreach($quotesData as $datas){
        
//         $obj = new \stdClass();
//        $obj->name =  $datas->monthname;
//        $obj->data = $datas->price;

//        $monthData[] = $obj;
//     }

// $chartArray ["series"] = array ($monthData);
    
      

        return view('admin.dashboard', ['counts' => $counts, 'prices' => $getTotals, 'status' => $getStatus, 'chartArray' => $chartArray]);
    }

    

    


    public function getLogChartData(Request $request)
    {
        \Validator::make($request->all(), [
            'start' => 'required|date|before_or_equal:now',
            'end' => 'required|date|after_or_equal:start',
        ])->validate();

        $start = new Carbon($request->get('start'));
        $end = new Carbon($request->get('end'));

        $dates = collect(\LogViewer::dates())->filter(function ($value, $key) use ($start, $end) {
            $value = new Carbon($value);
            return $value->timestamp >= $start->timestamp && $value->timestamp <= $end->timestamp;
        });


        $levels = \LogViewer::levels();

        $data = [];

        while ($start->diffInDays($end, false) >= 0) {

            foreach ($levels as $level) {
                $data[$level][$start->format('Y-m-d')] = 0;
            }

            if ($dates->contains($start->format('Y-m-d'))) {
                /** @var  $log Log */
                $logs = \LogViewer::get($start->format('Y-m-d'));

                /** @var  $log LogEntry */
                foreach ($logs->entries() as $log) {
                    $data[$log->level][$log->datetime->format($start->format('Y-m-d'))] += 1;
                }
            }

            $start->addDay();
        }

        return response($data);
    }

    public function getRegistrationChartData()
    {

        $data = [
            'registration_form' => User::whereDoesntHave('providers')->count(),
            'google' => User::whereHas('providers', function ($query) {
                $query->where('provider', 'google');
            })->count(),
            'facebook' => User::whereHas('providers', function ($query) {
                $query->where('provider', 'facebook');
            })->count(),
            'twitter' => User::whereHas('providers', function ($query) {
                $query->where('provider', 'twitter');
            })->count(),
        ];

        return response($data);
    }
}
