<?php

namespace App\Http\Controllers\Admin;

use App\Models\Auth\Role\Role;
use App\Models\Auth\User\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;
use Maatwebsite\Excel\Facades\Excel;
use App\Quotes;
Use \DB;
use Illuminate\Support\Facades\Input;
use Auth;
use Carbon\Carbon;
use PDF;
use Illuminate\Support\Facades\Mail;

class QuotesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
      if (!Auth::user()->hasRole('administrator'))
        return redirect()->intended(route('admin.dashboard'));

        return view('admin.quotes.index');
    }

    public function charts(){
     
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param User $user
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(User $user)
    {
        return view('admin.users.show', ['user' => $user]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param User $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        return view('admin.users.edit', ['user' => $user, 'roles' => Role::get()]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param User $user
     * @return mixed
     */
    public function update(Request $request, User $user)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255',
            'active' => 'sometimes|boolean',
            'confirmed' => 'sometimes|boolean',
        ]);

        $validator->sometimes('email', 'unique:users', function ($input) use ($user) {
            return strtolower($input->email) != strtolower($user->email);
        });

        $validator->sometimes('password', 'min:6|confirmed', function ($input) {
            return $input->password;
        });

        if ($validator->fails()) return redirect()->back()->withErrors($validator->errors());

        $user->name = $request->get('name');
        $user->email = $request->get('email');

        if ($request->has('password')) {
            $user->password = bcrypt($request->get('password'));
        }

        $user->active = $request->get('active', 0);
        $user->confirmed = $request->get('confirmed', 0);

        $user->save();

        //roles
        if ($request->has('roles')) {
            $user->roles()->detach();

            if ($request->get('roles')) {
                $user->roles()->attach($request->get('roles'));
            }
        }

        return redirect()->intended(route('admin.users'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

       /**

 * Import file into database Code

 *

 * @var array

 */

public function importExcelForUpload(Request $request){


  
  $validator = Validator::make($request->all(), [
        'quotes'      => 'required|mimes:csv,txt',
  ]);


    if ($validator->fails()) return redirect()->back()->withErrors($validator->errors());


    if($request->hasFile('quotes')){

        $path = $request->file('quotes')->getRealPath();
        $data = Excel::load($path, function($reader) {})->get();

        if(!empty($data) && $data->count()){
          //$i=0;
            foreach ($data->toArray() as $key => $value) {
                if(!empty($value)){
                    if($value['job_card_number'] != null){
                        $insert[] = [
                          'job_card_number' => $value['job_card_number'], 
                          'problem_type' => $value['problem_type'],
                          'sub_district' => $value['sub_district'],
                          'facility_name' => $value['facility_name'],
                          'description' => $value['work_description']
                        ];
                      }
                }
            }


            //$quotes = Quotes::all();

            // if(count($quotes) > 0){
            //   foreach($insert as $key => $arr_pop){
            //     foreach($quotes as $quote){
            //       if($quote->job_card_number == $arr_pop['job_card_number']){
            //         unset($insert[$key]);
                    
            //       }
            //     }
            //   }
            // }


            if(!empty($insert)){
              $i=0;
              foreach($insert as $t ){

                $matchThese = array('job_card_number'=>$t['job_card_number']);

                $quotes = Quotes::firstOrCreate($matchThese,$t);
               
                //DB::table('quotes')->insert($t);
              if($quotes->wasRecentlyCreated){
                 $i++;
               }
              }
             if($i > 0){
                return back()->with('success','Insert Record successfully.');
             }else{
               return back()->with('success','No Job Card Number Remain to UPLOAD');
             }
            }else{
              return back()->with('success','No Job Card Number Remain to UPLOAD');
            }
        }
    }
    return back()->with('error','Please Check your file, Something is wrong there.');
  }



  public function getQuotes(Request $request){
      $datas = array();
      return view('admin.quotes.getQuotes', compact('datas'));
  }

  public function deleteUploads($id){

    $deleteQuote = Quotes::find($id);
    if($deleteQuote->delete($id)){
      return redirect()->intended(route('admin.getQuotes'));
    }else{
      return redirect()->intended(route('admin.getQuotes'));
    } 
  }

  public function searchquotes(Request $request){
    
      $q = $request->searchs;
      if($q){
        $datas = Quotes::where('job_card_number','LIKE','%'.$q.'%')->paginate(30);
      }else{
        $datas = Quotes::paginate(30);
      }
      
      if(count($datas) > 0){
        return view('admin.quotes.getQuotes', compact('datas'))->withQuery($q);     
      }else {
        return view ('admin.quotes.getQuotes',compact('datas'))->withMessage('No Details found. Try to search again !');
      }
  }

  public function editQuote($id){



    $getForm = Quotes::where('quotes.id', $id)
                ->leftJoin('sub_district', 'sub_district.name', '=', 'quotes.sub_district')
                ->leftJoin('district', 'district.id', '=', 'sub_district.district_id')
                ->leftJoin('inspectors_management', 'inspectors_management.sub_district_id', '=', 'sub_district.id')
                ->leftJoin('facilities', 'facilities.name', '=', 'quotes.facility_name')
                ->select('quotes.*', 'district.name as DistrictName', 'district.id as dist_id', 'sub_district.id as sub_dist_id', 'inspectors_management.inspector_id' , 'facilities.id as facility_id')
                ->get();
               
    $disctrict_id = $getForm[0]->dist_id;
    $sub_disctrict_id = $getForm[0]->sub_dist_id;
    $getInspector = DB::table('inspectors_management')->where('district_id', $disctrict_id)
                    ->where('sub_district_id', $sub_disctrict_id)->get() ;
    $getFacilities = DB::table('facilities')->get();

    $inspector = array();
    $facility = array();
    $contractors = array();

    foreach($getFacilities as $facilities){
      $facility[$facilities->id] = $facilities->name; 
    }


    
    foreach($getInspector as $inspectors){
      
      $inspector['id'] = $inspectors->inspector_id ;
      $inspector['name'] =  $inspectors->inspector_name;
    }




    $contractor = DB::table('contractors')->get();
    foreach($contractor as $getcontractor){

      $contractors[$getcontractor->id] = $getcontractor->name; 
    }

    return view('admin.quotes.quotes',compact('getForm', 'inspector', 'facility', 'contractors'));
    
  }

  public function newCapturing(){

    $getInspector = DB::table('inspectors_management')->get() ;
    $getFacilities = DB::table('facilities')->get();

    $inspector = array();
    $facility = array();
    $contractors = array();

    foreach($getFacilities as $facilities){
      
      $facility[$facilities->id] = $facilities->name; 
    }
    
    foreach($getInspector as $inspectors){
      
      $inspector['id'] = $inspectors->inspector_id ;
      $inspector['name'] =  $inspectors->inspector_name;
    }

    $contractor = DB::table('contractors')->get();
    foreach($contractor as $getcontractor){

      $contractors[$getcontractor->id] = $getcontractor->name; 
    }

    $problem_types = DB::table('problem_type')->pluck('name')->toArray();
    $problem_type = array();
    foreach($problem_types as $prob){
      $problem_type[$prob] = $prob;
    }

    return view('admin.quotes.newCapture',compact( 'inspector', 'facility', 'contractors', 'problem_type'));
    
  }

  public function addQuote($id){
    // $getForm = Quotes::where('quotes.id', $id)
    //             ->leftJoin('sub_district', 'sub_district.name', '=', 'quotes.sub_district')
    //             ->leftJoin('district', 'district.id', '=', 'sub_district.district_id')
    //             ->leftJoin('inspectors_management', 'inspectors_management.sub_district_id', '=', 'sub_district.id')
    //             ->select('quotes.*', 'district.name as DistrictName', 'district.id as dist_id', 'sub_district.id as sub_dist_id', 'inspectors_management.inspector_id', 'inspectors_management.inspector_name')
    //             ->get();
    // $disctrict_id = $getForm[0]->dist_id;
    // $sub_disctrict_id = $getForm[0]->sub_dist_id;
    $getInspector = DB::table('inspectors_management')->get() ;
    $inspector = array();

    
    foreach($getInspector as $inspectors){
      
      $inspector['id'] = $inspectors->inspector_id ;
      $inspector['name'] =  $inspectors->inspector_name;
    }

    return view('admin.quotes.addquotes',compact('inspector'));
    
  }

  public function capturing(Request $request){



    $validator = Validator::make($request->all(), [
      'job_card_no' => 'required|max:255',
      'sub_district' => 'required|max:255',
      'district' => 'required|max:255',
      'problem_type' => 'required|max:255',
      'facility_id' => 'required|max:255',
      'inspector' => 'required|max:255',
      'quotation_no' => 'required|max:255',
      'status' => 'required|integer',
      'price' => 'required|max:255',
      'quote_date' => 'required|max:255',
      'description' => 'required|max:255',
      'contractor_id' => 'required',
      'facility_no' => 'required'
      
  ]);

  if ($validator->fails()) return redirect()->back()->withErrors($validator->errors())->withInput($request->all());
  $employee = Auth::user()->id;

  

  $facility_name = DB::table('facilities')->where('id', $request->facility_id)->get();
  $facility_name = $facility_name[0]->name;

 $contractor = DB::table('contractors')->where('id', $request->contractor_id)->get();
  
  $contractor_name = $contractor[0]->name;

  if($request->id){
    $quoteUpdate = Quotes::find($request->id);
    $completed_status = $quoteUpdate->completed_status;
  }else{

    $quoteUpdate = new Quotes();
    
    if(Quotes::where('job_card_number', $request->job_card_no)->get()->toArray()){
      return redirect()->back()->withErrors(array('message' => 'Job Card Already Exists.'))->withInput($request->all());
    }
  }


      $quoteUpdate->job_card_number = $request->job_card_no;
      $quoteUpdate->sub_district = $request->sub_district;
      $quoteUpdate->district = $request->district;
      $quoteUpdate->problem_type = $request->problem_type;
      $quoteUpdate->facility_name = $facility_name;
      $quoteUpdate->facility_id = $request->facility_id;
      $quoteUpdate->contractor_id = $request->contractor_id;
      $quoteUpdate->contractor_name = $contractor_name;
      $quoteUpdate->contractor_email =  $contractor[0]->email;
      $quoteUpdate->inspector_name = $request->inspector;
      $quoteUpdate->quotation_no = $request->quotation_no;
      $quoteUpdate->material_vat_exempt = $request->material_vat_exempt;
      $quoteUpdate->invoice_no = $request->invoice_no;
      $quoteUpdate->facility_no = $request->facility_no;
      $quoteUpdate->status = $request->status;
      $quoteUpdate->price = $request->price;
      $quoteUpdate->quotation_date = $request->quote_date;
      $quoteUpdate->description = $request->description;
      $quoteUpdate->district_id = $request->dist_id;
      $quoteUpdate->sub_district_id = $request->sub_dist_id;
      $quoteUpdate->inspector_id = $request->inspector_id;
      $quoteUpdate->labour_amount = $request->labour_amount;
      $quoteUpdate->travelling_time_amount = $request->travelling_time;
      $quoteUpdate->travelling_cost = $request->travelling_cost;
      $quoteUpdate->desludging_water_delive = $request->desludge_delive;
      $quoteUpdate->accomodation = $request->accomodation;
      $quoteUpdate->material_used_amount = $request->material_used_amount;
      $quoteUpdate->amount_excluding_vat = $request->amount_exc_vat;
      $quoteUpdate->reg_unregistered = $request->vat_check;
      $quoteUpdate->reason = $request->reason;
      if($request->status == 1){
        $quoteUpdate->capturing_date = Carbon::now()->toDateTimeString();
      }elseif($request->status == 2){
        $quoteUpdate->approved_date = Carbon::now()->toDateTimeString();
      }elseif($request->status == 3){
        $quoteUpdate->reject_internal_date = Carbon::now()->toDateTimeString();
      }elseif($request->status == 4){
        $quoteUpdate->reject_vetting_date = Carbon::now()->toDateTimeString();
      }elseif($request->status == 5){
        $quoteUpdate->corrected_date = Carbon::now()->toDateTimeString();
      }elseif($request->status == 6){
        $quoteUpdate->vetting_date = Carbon::now()->toDateTimeString();
      }elseif($request->status == 7){
        $quoteUpdate->invoiced_date = Carbon::now()->toDateTimeString();
      }
      /***************** COMPLETE STATUS ARRAY *****************/
      // if ($request->id == '32705') {
        $employee_name = Auth::user()->name;
        $completed_status = $quoteUpdate->completed_status;
        if ($completed_status) {
          $decoded_completed = json_decode($completed_status, true);
        } else {
          $decoded_completed = array();
        }
        if($request->status == 1){
          $push_arr = [
            'name' => $employee_name,
            'date' => Carbon::now()->toDateTimeString()
          ];
          if(isset($decoded_completed['capturing'])) {
            array_push($decoded_completed['capturing'], $push_arr);
          } else {
            $decoded_completed['capturing'] = [$push_arr];
          }
        }elseif($request->status == 2){
          $push_arr = [
            'name' => $employee_name,
            'date' => Carbon::now()->toDateTimeString()
          ];
          if(isset($decoded_completed['approved'])) {
            array_push($decoded_completed['approved'], $push_arr);
          } else {
            $decoded_completed['approved'] = [$push_arr];
          }
        }elseif($request->status == 3){
          $push_arr = [
            'name' => $employee_name,
            'date' => Carbon::now()->toDateTimeString()
          ];
          if(isset($decoded_completed['rejected_internally'])) {
            array_push($decoded_completed['rejected_internally'], $push_arr);
          } else {
            $decoded_completed['rejected_internally'] = [$push_arr];
          }
        }elseif($request->status == 4){
          $push_arr = [
            'name' => $employee_name,
            'date' => Carbon::now()->toDateTimeString()
          ];
          if(isset($decoded_completed['rejected_after_vetted_by_client'])) {
            array_push($decoded_completed['rejected_after_vetted_by_client'], $push_arr);
          } else {
            $decoded_completed['rejected_after_vetted_by_client'] = [$push_arr];
          }
        }elseif($request->status == 5){
          $push_arr = [
            'name' => $employee_name,
            'date' => Carbon::now()->toDateTimeString()
          ];
          if(isset($decoded_completed['corrected'])) {
            array_push($decoded_completed['corrected'], $push_arr);
          } else {
            $decoded_completed['corrected'] = [$push_arr];
          }
        }elseif($request->status == 6){
          $push_arr = [
            'name' => $employee_name,
            'date' => Carbon::now()->toDateTimeString()
          ];
          if(isset($decoded_completed['vetted'])) {
            array_push($decoded_completed['vetted'], $push_arr);
          } else {
            $decoded_completed['vetted'] = [$push_arr];
          }
        }elseif($request->status == 7){
          $push_arr = [
            'name' => $employee_name,
            'date' => Carbon::now()->toDateTimeString()
          ];
          if(isset($decoded_completed['invoiced'])) {
            array_push($decoded_completed['invoiced'], $push_arr);
          } else {
            $decoded_completed['invoiced'] = [$push_arr];
          }
        }
        $encode_completed = json_encode($decoded_completed);
        $quoteUpdate->completed_status = $encode_completed;
      // }
      /***************** COMPLETE STATUS ARRAY *****************/

      if(!is_null(Quotes::find($request->id))){
        $quoteUpdate->updated_by = Auth::user()->name;
        $quoteUpdate->update();
      }else{
        
        $quoteUpdate->save();
      }
      //$quoteUpdate->update();

    $getStatus = DB::table('status')->where('id', $request->status)->get();

    $dataemail = array(
        'name' => $contractor_name,
        'status' => $request->status,
        'reason' => $request->reason,
        'job_card_number' => $request->job_card_no,
        'type' => $getStatus[0]->type,
    );

    $stats = array(3,4,5);
    $rejected_stats = array(3,4);
    /************** SENDING EMAIL TO CONTRACTOR **************/
    if (in_array($request->status, $stats))
    {
       if($request->status == '3'){
         $heading = 'Internally Rejected Claims';
      }elseif($request->status == '4'){
         $heading = 'Claims Rejected at vetting ';
      }elseif($request->status == '5'){
         $heading = 'Corrected ';
      }

      Mail::send('admin.emails.statusEmail', $dataemail, function ($message)  use ($heading, $contractor) {
        $message->from('kena@sakhiwo.com', 'Quotes Status');
        //$message->to($contractor[0]->email;)->subject('Quotes Status');
        $message->to($contractor[0]->email)->subject($heading)->replyTo('kena@sakhiwo.com')->cc('finance.sakhiwo@gmail.com');
      });
    }
    /************* SENDING EMAIL TO INSPECTOR ON REJECTION **************/
    if (in_array($request->status, $rejected_stats)) {
      if($request->status == '3'){
        $heading = 'Internally Rejected Claims';
      } elseif($request->status == '4'){
        $heading = 'Claims Rejected at vetting ';
      }
      $getInspectorData = DB::table('inspectors')->where('id', $request->inspector_id)->get();
      
      if ($getInspectorData[0]->email) {
        $inspector_email = $getInspectorData[0]->email;
        $dataemail1 = array(
          'name' => $getInspectorData[0]->name,
          'status' => $request->status,
          'reason' => $request->reason,
          'job_card_number' => $request->job_card_no,
          'type' => $getStatus[0]->type,
        );
        
        Mail::send('admin.emails.statusEmail', $dataemail1, function ($message)  use ($heading, $inspector_email) {
          $message->from('kena@sakhiwo.com', 'Quotes Status');
          //$message->to($contractor[0]->email;)->subject('Quotes Status');
          $message->to($inspector_email)->subject($heading)->replyTo('kena@sakhiwo.com')->cc('finance.sakhiwo@gmail.com');
        });
      }    
    }
     
    $datas = Quotes::paginate(30);
    // return view('admin.quotes.getQuotes', compact('datas'));
    return redirect()->route('admin.search');
  }

  public function getfacility(Request $request){

    $facility = DB::table('facilities')->where('id', $request->id)->get();
    
    $subdistrict = DB::table('sub_district')->where('name', $facility[0]->subdistrict)
                    ->leftJoin('inspectors_management', 'inspectors_management.sub_district_id' , '=', 'sub_district.id')
                    ->select('inspectors_management.*')
                    ->get();
    $facility['district_id'] = $subdistrict[0]->district_id;
    $facility['sub_district_id'] = $subdistrict[0]->sub_district_id;
    $facility['inspector_id'] = $subdistrict[0]->inspector_id;

    echo json_encode($facility);
  }

public function vetting_reports(){

  $contractors = DB::table('contractors')->pluck( 'name', 'id')->toArray();

  $district = DB::table('district')->pluck('name', 'id')->toArray();

  $status = DB::table('status')->pluck('type', 'id')->toArray();

  $search = array();
  $paginating = 0;

  return view('admin.reports.vetting_report', compact('contractors', 'district', 'status', 'search', 'paginating'));
}

public function search_vetting(Request $request){

  $paginating = 0;
  $contractors = DB::table('contractors')->pluck( 'name', 'id')->toArray();
  $district = DB::table('district')->pluck('name', 'id')->toArray();
  $status = DB::table('status')->pluck('type', 'id')->toArray();
  $search = new Quotes();
  if($request->status){
    $search = $search->where('status', $request->status);
  }
  if($request->contractor_id){
    $search = $search->where('contractor_id', $request->contractor_id);
  }
  if($request->district){
    $search = $search->where('district_id', $request->district);
  }
  if($request->vetting_dates){
    if($request->status){
      $vettings = ['1' => 'capturing_date',
                    '2' => 'approved_date',
                    '3' => 'reject_internal_date',
                    '4'=> 'reject_vetting_date',
                    '5' => 'corrected_date',
                    '6' => 'vetting_date',
                    '7' => 'invoiced_date'
                  ];

      $getStatus_selected = $vettings[$request->status];
      $search = $search->whereDate($getStatus_selected, date('Y-m-d', strtotime($request->vetting_dates)));
    }
    
  }

  if($request->status || $request->contractor_id || $request->district){
     $search = $search->paginate('25');
     $paginating = 1;
  }else{
    $search = $search->paginate('25');
    $paginating = 1;
  }

  
  return view('admin.reports.vetting_report', compact('contractors', 'district', 'status', 'search', 'paginating'))->withInput($request->all());
}
  
public function downloadxlsx(Request $request){

  $status = $request->status;
  $contractor_id = $request->contractor_id;
  $district = $request->district_id;
  if($request->status){
    $search = Quotes::where('status', $request->status);
  }else{
    $search = Quotes::where('status', '>', 0);
  }
  
  if($request->contractor_id){
    $search = $search->where('contractor_id', $request->contractor_id);
  }
  if($request->district){
    $search = $search->where('district_id', $request->district);
  }
  $search = $search->get();
ob_start();

    $search_array[] = array('Date',
                  'Invoice No',
                  'Supplier',
                'Facility',
                'District',
                'Sub District',
                'Facility Nr',
                'Inspector',
                'Job card No',
                'Service Desc',
                'Quotation Nr',
                'Amount Exc VAT',
                'Amount Inc VAT');


     foreach($search as $res)
     {
      $search_array[] = array(
                'Date' => date('Y-m-d', strtotime($res->quotation_date)),
                'Invoice No' => $res->invoice_no,
                'Supplier' => $res->contractor_name,
                'Facility' => $res->facility_name,
                'District' => $res->district,
                'Sub District' => $res->sub_district,
                'Facility Nr' => $res->facility_no,
                'Inspector' => $res->inspector_name,
                'Job card No' => $res->job_card_number,
                'Service Desc' => $res->description,
                'Quotation Nr' => $res->quotation_no,
                'Amount Exc VAT' => $res->amount_excluding_vat,
                'Amount Inc VAT' => $res->amount_including_vat,
      );
     }
ob_clean();
    Excel::create('Vetting', function($excel) use ($search_array){
      $excel->setTitle('Vetting Report');
      $excel->sheet('Vetting Report', function($sheet) use ($search_array){
       $sheet->fromArray($search_array, null, 'A1', false, false);
      });
     })->download('xlsx');

    return redirect()->back();
}

public function downloadpdf(Request $request){
ob_start();
  $status = $request->status;
  $contractor_id = $request->contractor_id;
  $district = $request->district_id;

  $search = new Quotes();
  if($request->status){
      $search = $search->where('status', $request->status);
  }

  if($request->contractor_id){
    $search = $search->where('contractor_id', $request->contractor_id);
  }
  if($request->district){
    $search = $search->where('district_id', $request->district);
  }
  
  if($request->vetting_dates){
    if($request->status){
      $vettings = ['1' => 'capturing_date',
                    '2' => 'approved_date',
                    '3' => 'reject_internal_date',
                    '4'=> 'reject_vetting_date',
                    '5' => 'corrected_date',
                    '6' => 'vetting_date',
                    '7' => 'invoiced_date'
                  ];

      $getStatus_selected = $vettings[$request->status];
      $search = $search->whereDate($getStatus_selected, date('Y-m-d', strtotime($request->vetting_dates)));
    }
    
  }

  if($request->status || $request->contractor_id || $request->district){
     $search = $search->get();
     
  }else{
    $search = $search->where('status', '>', 0)->get();
  }

ob_clean();
  $pdf = PDF::loadView('admin.reports.pdf_report', compact('search'))->setPaper('a4', 'landscape');

   return $pdf->download('Vetting.pdf');
}

public function search_dfmiy(Request $request){
$contractors = DB::table('contractors')->pluck( 'name', 'id')->toArray();

  $district = DB::table('district')->pluck('name', 'id')->toArray();

  $problem_type = DB::table('problem_type')->pluck('name', 'id')->toArray();

  $search = array();

  $paginating = 0;

  return view('admin.reports.dfm_report', compact('contractors', 'district',  'problem_type', 'search', 'paginating'));
}

public function search_filter_dfm(Request $request){

  $contractors = DB::table('contractors')->pluck( 'name', 'id')->toArray();
  $district = DB::table('district')->pluck('name', 'id')->toArray();
  $problem_type = DB::table('problem_type')->pluck('name', 'name')->toArray();

  $paginating = 0;
  $search  = new Quotes();
  if($request->problem_type){
    $search = $search->where('problem_type', $request->problem_type );
  }
  if($request->contractor_id){
    $search = $search->where('contractor_id', $request->contractor_id);
  }
  if($request->district){
    $search = $search->where('district_id', $request->district );
  }


  if($request->status || $request->contractor_id || $request->district){
     $search = $search->orderBy('quotation_date','DESC')->get();
  }else{
    $search = $search->orderBy('quotation_date','DESC')->paginate('50');
    $paginating = 1;
  }



  
  return view('admin.reports.dfm_report', compact('contractors', 'district', 'problem_type', 'search', 'paginating'))->withInput($request->all());
}

public function downloadDFMxlsx(Request $request){

  // $validator = Validator::make($request->all(), [
  //       'problem_type'      => 'required',
  // ]);


  // if ($validator->fails()) return redirect()->back()->withErrors($validator->errors());

  $problem_type = $request->problem_type;
  $contractor_id = $request->contractor_id;
  $district = $request->district_id;

  // if ($problem_type || $contractor_id || $district){
   
  

      $search = new Quotes();
  
      if($request->problem_type){
        $search = $search->where('problem_type', $request->problem_type);
      }
      if($request->contractor_id){
        $search = $search->where('contractor_id', $request->contractor_id);
      }
      if($request->district){
        $search = $search->where('district_id', $request->district);
      }
  
      ob_start();

      $capturing = $request->capturing;
      $approved = $request->approved;
      $reject_internal = $request->reject_internal;
      $reject_vetting = $request->reject_vetting;
      $corrected = $request->corrected;
      $vetted = $request->vetted;
      $invoiced = $request->invoiced;

      $statuses = array();

      $search_array[] = array('Contractor',
                'Job Card Number',
                'Facility Name',
                'Problem Type'
                );

        if($capturing){
          array_push($search_array[0], 'Capturing' );
          $statuses[] = 1;

        }
        if($approved){
          array_push($search_array[0], 'Approved');
          $statuses[] = 2;
        }
        if($reject_internal){
          array_push($search_array[0], 'Reject Internally');
          $statuses[] = 3;
        }
        if($reject_vetting){
          array_push($search_array[0], 'Reject After Vetting');
          $statuses[] = 4;
        }
        if($corrected){
          array_push($search_array[0], 'Corrected');
          $statuses[] = 5;
        }
        if($vetted){
          array_push($search_array[0], 'Vetted');
          $statuses[] = 6;
        }
        if($invoiced){
          array_push($search_array[0], 'Invoiced');
          $statuses[] = 7;
        }

$search = $search->where(function ($search) use ($statuses) {
      $search->whereIn('status', $statuses);
  })->get();
        


        $i=1;
      foreach($search as $res){
          $search_array[] = array(
                    'Contractor' => $res->contractor_name,
                    'Job Card Number' => $res->job_card_number,
                    'Facility Name' => $res->facility_name,
                    'Problem Type' => $res->problem_type,
          );
        

          if($capturing){
            if($res->status == 1)
              $search_array[$i]['Capturing'] = $res->price;
            else
              $search_array[$i]['Capturing'] = '0';
          }
          if($approved){
            if($res->status == 2)
              $search_array[$i]['Approved'] = $res->price;
            else
              $search_array[$i]['Approved'] = '0';
          }
          if($reject_internal){
            if($res->status == 3)
              $search_array[$i]['Reject Internally'] = $res->price;
            else
              $search_array[$i]['Reject Internally'] = '0';
          }
          if($reject_vetting){
            if($res->status == 4)
              $search_array[$i]['Reject After Vetting'] = $res->price;
            else
              $search_array[$i]['Reject After Vetting'] = '0';
          }
          if($corrected){
            if($res->status == 5)
              $search_array[$i]['Corrected'] = $res->price;
            else
              $search_array[$i]['Corrected'] = '0';
          }
          if($vetted){
            if($res->status == 6)
              $search_array[$i]['Vetted'] = $res->price;
            else
              $search_array[$i]['Vetted'] = '0';
          }
          if($invoiced){
            if($res->status == 7)
              $search_array[$i]['Invoiced'] = $res->price;
            else
              $search_array[$i]['Invoiced'] = '0';
          }
          $i++;
        }

            ob_clean();
            Excel::create('DFM', function($excel) use ($search_array){
              $excel->setTitle('DFM Report');
              $excel->sheet('DFM Report', function($sheet) use ($search_array){
               $sheet->fromArray($search_array, null, 'A1', false, false);
              });
             })->download('xlsx');

            return redirect()->back();
    
    // }else{
    //   return redirect('admin/search_dfmiy')->withErrors(['Please select an option']);
    // }

  }


  public function search_total(){

   $contractors = DB::table('contractors')->pluck( 'name', 'id')->toArray();

    $search = Quotes::selectRaw('contractor_id,contractor_name, problem_type, sum(ROUND(price, 2)) as price')
            ->where('contractor_id', '!=', 0)
            ->groupBy('contractor_id', 'problem_type')
            ->get();

    $mid_array = array();
    $a = $search->toArray();
    $b = array_unique(array_column($a, 'contractor_name'));
    //var_dump($b);
    $b = array_values($b);


// $problemType = array('WATER TREATMENT',
// 'WATER PUMPS',
// 'WATER CARTING',
// 'UPS',
// 'ST LUCY WATER CARTING',
// 'SOLAR SYSTEM',
// 'SEWER DESLUDGING',
// 'REFURBISHMENT AND UPGRADES - GB',
// 'REFURBISHMENT AND UPGRADES - EM',
// 'REFRIGERATION',
// 'PREVENTIVE MAINT',
// 'POWER GENERATORS',
// 'PLUMBING',
// 'MORTUARY EQUIPMENT',
// 'MEDICAL GAS INSTALLATION',
// 'MADWALENI HOSPITAL SEWER DESLUDG',
// 'LT ELECTRICAL',
// 'LAUNDRY EQUIPMENT',
// 'KITCHEN EQUIPMENT',
// 'INDUSTRIAL AIR-CONDITIONING',
// 'HV - ELECTRICAL',
// 'GENERAL BUILDING',
// 'GARDEN SERVICES',
// 'FRERE GEN BUILDI',
// 'FIRE PREVENTION AND PROTECTION S',
// 'ELECTRONIC SYSTEMS',
// 'DOMESTIC AIR CONDITIONING',
// 'COMPRESSORS AND VACUUM PUMPS',
// 'CLINIC WATER PUMPS',
// 'CLEANING & PEST CONTROL',
// 'BOILERS, STEAM LINES AND CALORIF',
// 'AUTOCLAVES, STERILIZATION EQUIPM',
// );
    $i=0;
    $j=0;

$count = count($b);
 foreach($b as $arr){
        
        foreach($a as $res){
     

          if($res['contractor_name'] == $b[$i]){
            $mid_array[$i]['contractor_name'] = $res['contractor_name'];
            $mid_array[$i][$res['problem_type']]   = $res['problem_type'];
            $mid_array[$i][$res['problem_type'].'-price']   = $res['price'];

          }

      }
       $i++;
      
     
    }

    $problem_type  = DB::table('problem_type')->get()->toArray();
  
    return view('admin.reports.total_report', compact('contractors'))->with('mid_array', $mid_array)->with('problem_type', $problem_type);
  }

   public function excel_total(){

   $contractors = DB::table('contractors')->pluck( 'name', 'id')->toArray();

    $search = Quotes::selectRaw('contractor_id,contractor_name, problem_type, sum(ROUND(price, 2)) as price')
            ->where('contractor_id', '!=', 0)
            ->groupBy('contractor_id', 'problem_type')
            ->get();

    $mid_array = array();
    $a = $search->toArray();
    $b = array_unique(array_column($a, 'contractor_name'));
    //var_dump($b);
    $b = array_values($b);


    $i=0;
    $j=0;

$count = count($b);
 foreach($b as $arr){
        
        foreach($a as $res){
     

          if($res['contractor_name'] == $b[$i]){
            $mid_array[$i]['contractor_name'] = $res['contractor_name'];
            $mid_array[$i][$res['problem_type']]   = $res['problem_type'];
            $mid_array[$i][$res['problem_type'].'-price']   = $res['price'];

          }

      }
       $i++;
      
     
    }

    $problem_type  = DB::table('problem_type')->get()->toArray();


    Excel::create('New file', function($excel) use ($mid_array, $contractors, $problem_type){

        $excel->sheet('New sheet', function($sheet) use ($mid_array, $contractors, $problem_type){

            $sheet->loadView('admin.reports.excel_report', compact('contractors'))->with('mid_array', $mid_array)->with('problem_type', $problem_type);


            $sheet->cells('B1:AG1', function($cells) {

              $cells->setTextRotation(90);

            });



            $sheet->setSize(array(
                    'A1:AH1' => array(
                    'width'     => 30,
                    'height'    => 400
                )
            ));

        });



    })->download('xlsx');

    return redirect()->back();

  
   // return view('admin.reports.excel_report', compact('contractors'))->with('mid_array', $mid_array)->with('problem_type', $problem_type);
  }

  public function status_change(){

    $statusChange = Quotes::where('contractor_id', '!=', 0)->paginate(25);
   
     return view('admin.reports.status_report', compact('statusChange'));
  }

  public function downloadStatusxlsx(Request $request){

    // $status = $request->status;
    // $contractor_id = $request->contractor_id;
    // $district = $request->district_id;
    // if($request->status){
    //   $search = Quotes::where('status', $request->status);
    // }else{
    //   $search = Quotes::where('status', '>', 0);
    // }
    
    // if($request->contractor_id){
    //   $search = $search->where('contractor_id', $request->contractor_id);
    // }
    // if($request->district){
    //   $search = $search->where('district_id', $request->district);
    // }
    $search = Quotes::where('contractor_id', '!=', 0)->get();
  ob_start();


  
      $search_array[] = array('Job Card',
                            'Contractor',
                            'Quote Amount',
                            'Captured',
                            'Approved',
                            'Interanl Reject',
                            'Corrected',
                            'Vetting',
                            'Rejected by Client',
                            'Duration In days',
                            'Invoiced date'
                        );
                        
  
       foreach($search as $res)
       {
        $search_array[] = array(
          'Job Card' => $res->job_card_number,
          'Contractor' => $res->contractor_name,
          'Quote Amount' => $res->price,
          'Captured' => $res->capturing_date,
          'Approved' => $res->approved_date,
          'Interanl Reject' => $res->reject_internal_date,
          'Corrected' => $res->corrected_date,
          'Vetting' => $res->vetting_date,
          'Rejected by Client' => $res->rejected_vetting_date,
          'Duration In days' => $res->quotation_no,
          'Invoiced date' => $res->invoiced_date,
        );
       }
  ob_clean();
      Excel::create('Status', function($excel) use ($search_array){
        $excel->setTitle('Status Change Report');
        $excel->sheet('Status Change Report', function($sheet) use ($search_array){
         $sheet->fromArray($search_array, null, 'A1', false, false);
        });
       })->download('xlsx');
  
      return redirect()->back();
  }


}