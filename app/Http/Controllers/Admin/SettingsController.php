<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;

class SettingsController extends Controller
{
    public function facility_view(Request $request){

    	$facility = DB::table('facilities')->paginate('30');

    	return view('admin.settings.facility_view')->with('datas', $facility);
    }

    public function facility_edit($id){

    	$getForm = DB::table('facilities')->where('facilities.id', $id)
                ->leftJoin('sub_district', 'sub_district.name', '=', 'facilities.subdistrict')
                ->leftJoin('district', 'district.id', '=', 'sub_district.district_id')
                ->leftJoin('inspectors_management', 'inspectors_management.sub_district_id', '=', 'sub_district.id')
                ->select('facilities.*',   'facilities.facility_manager as inspector_name', 'district.name as DistrictName', 'district.id as dist_id', 'sub_district.id as sub_dist_id', 'inspectors_management.inspector_id' , 'facilities.id as facility_id')
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


    return view('admin.settings.facility_edit', compact('getForm', 'inspector', 'facility', 'contractors'));
    
    }

    public function new_facility(){

         $getdistrict = DB::table('district')->get();
         $getsub_district = DB::table('sub_district')->get();

         $getInspector = DB::table('inspectors')->get();
    
    $district = array();
    $sub_district = array();
    $inspector = array();

    foreach($getdistrict as $districts){
      $district[$districts->name] = $districts->name; 
    }


    
    foreach($getsub_district as $sub_districts){
      
      $sub_district[$sub_districts->name] = $sub_districts->name ;

    }

    
    foreach($getInspector as $inspectors){
      
      $inspector[$inspectors->name] = $inspectors->name ;

    }


    return view('admin.settings.new_facility', compact('district', 'sub_district', 'inspector'));
    
    }

    public function add_facility(Request $request){

        $district = $request->district;
        $sub_district = $request->sub_district;
        $facility_name = $request->facility_name;
        $facility_no = $request->facility_no;
        $inspector = $request->inspector;

        $data = array('district' => $district,
                      'subdistrict' => $sub_district,
                      'name' => $facility_name,
                      'facility_no' => $facility_no,
                      'facility_manager' => $inspector
                        );

        $insert_facility = DB::table('facilities')
                            ->insert($data);
         return redirect('admin/viewfacilities');
    }

    public function facility_update(Request $request){

        $id = $request->id;
        $district = $request->district;
        $sub_district = $request->sub_district;
        $facility_name = $request->facility_name;
        $facility_no = $request->facility_no;
        $inspector = $request->inspector;

        $data = array('district' => $district,
                      'subdistrict' => $sub_district,
                      'name' => $facility_name,
                      'facility_no' => $facility_no,
                      'facility_manager' => $inspector
                        );

        $update_facility = DB::table('facilities')->where('id', $id)
                            ->update($data);

        return redirect('admin/viewfacilities');
    }


    public function deleteFacility($id){
      $inspector = DB::table('facilities')->where('id', $id)->delete();
      return redirect('admin/viewfacilities');
    }


    //For DFM SETTINGS






    public function DFM_view(Request $request){

        $dfm = DB::table('inspectors_management')->paginate('30');

        return view('admin.settings.dfm.view_dfm')->with('datas', $dfm);
    }

    public function DFM_edit($id){

        $getsub_district = DB::table('sub_district')->get();
        $getForm = DB::table('inspectors_management')->where('id', $id)->get();
        $getInspector = DB::table('inspectors')->get();

        $sub_district = array();
        $inspector = array();
    
    foreach($getInspector as $inspectors){
      
      $inspector[$inspectors->id] = $inspectors->name ;

    }

    
    foreach($getsub_district as $sub_districts){
      
      $sub_district[$sub_districts->id] = $sub_districts->name ;

    }


    return view('admin.settings.dfm.edit_dfm', compact('getForm', 'sub_district', 'inspector'));
    
    }
      public function new_DFM(){

         $getdistrict = DB::table('district')->get();
         $getsub_district = DB::table('sub_district')->get();

         $getInspector = DB::table('inspectors')->get();
    
        $district = array();
        $sub_district = array();
        $inspector = array();

        foreach($getdistrict as $districts){
          $district[$districts->id] = $districts->name; 
        }

        foreach($getsub_district as $sub_districts){
          $sub_district[$sub_districts->id] = $sub_districts->name ;
        }


    return view('admin.settings.dfm.new_dfm', compact('district', 'sub_district'));
    
    }

    public function add_DFM(Request $request){
//this addition adds in two tables
      //inspector and inspctors_management
        $district_id = $request->district;
        $sub_district_id = $request->sub_district;
        $inspector_name = $request->inspector;
        $inspector_email = $request->inspector_email;

        $inspector_id = DB::table('inspectors')->insertGetId(['name' => $inspector_name, 'email' => $inspector_email]);
        $district_name = DB::table('district')->where('id', $district_id)->get();
        $sub_district_name = DB::table('sub_district')->where('id', $sub_district_id)->get();


        $data = array('district_id' => $district_id,
                      'sub_district_id' => $sub_district_id,
                      'inspector_id' => $inspector_id,
                      'district_name' => $district_name[0]->name,
                      'sub_district_name' => $sub_district_name[0]->name,
                      'inspector_name'  => $inspector_name,
                      'inspector_email'  => $inspector_email,
                        );
        
        $insert_dfm = DB::table('inspectors_management')
                            ->insert($data);
         return redirect('admin/viewdfm');
    }

    public function DFM_update(Request $request){

        $id = $request->id;
        $sub_district = $request->sub_district;
        $inspector = $request->inspector;
        $inspector_id = $request->inspector_id;


        $getsub_district_name = DB::table('sub_district')->where('id', $sub_district)->get();
       
        $getsub_inspector = DB::table('inspectors')->where('id', $inspector_id)->update(['name' => $inspector]);



        $data = array('sub_district_name' => $getsub_district_name[0]->name,
                        'sub_district_id' => $sub_district,
                        'inspector_name' => $inspector
                        );

        $update_facility = DB::table('inspectors_management')->where('id', $id)
                            ->update($data);

        return redirect('admin/viewdfm');
    }

    public function deleteDFM($id){
      $inspector = DB::table('inspectors_management')->where('id', $id)->get();

      DB::table('inspectors')->where('id', $inspector[0]->inspector_id)->delete();

      DB::table('inspectors_management')->where('id', $id)->delete();

      return redirect('admin/viewdfm');
    }


    public function viewDistricts(Request $request){

        $districts = DB::table('district')->paginate('30');

        return view('admin.settings.districts.view_districts')->with('datas', $districts);
    }

    public function editDistrict(Request $request){

      $id = $request->id;
      $name = $request->name;

      if(DB::table('district')->where('id', $id)->update(['name' => $name ])){
        echo json_encode(['success' => true]);
      }else{
        echo json_encode(['success' => false]);
      }
    }

     public function deleteDistrict($id){

      $inspector = DB::table('district')->where('id', $id)->delete();
      return redirect('admin/viewdistricts');
    }

    public function add_district(Request $request){

      $name = $request->district;

      if(DB::table('district')->insert(['name' => $name ])){
        echo json_encode(['success_add' => true]);
      }else{
        echo json_encode(['success_add' => false]);
      }
    }


    ///Setting for Sub disctrict

    public function viewsubDistricts(Request $request){

        $sub_district = DB::table('sub_district')->paginate('30');
        $getdistrict = DB::table('district')->get();

        $district = array();
        foreach($getdistrict as $districts){
          $district[$districts->id] = $districts->name; 
        }

        return view('admin.settings.sub_districts.view_subdistrict')->with('datas', $sub_district)->with('district', $district);
    }

    public function editsubDistrict(Request $request){

      $id = $request->id;
      $name = $request->name;

      if(DB::table('sub_district')->where('id', $id)->update(['name' => $name ])){
        echo json_encode(['success' => true]);
      }else{
        echo json_encode(['success' => false]);
      }
    }

     public function deletesubDistrict($id){

      $inspector = DB::table('sub_district')->where('id', $id)->delete();
      return redirect('admin/viewsubdistricts');
    }

    public function add_subdistrict(Request $request){

      $name = $request->subdistrict;
      $dist_id = $request->district;

      if(DB::table('sub_district')->insert(['name' => $name , 'district_id' => $dist_id])){
        echo json_encode(['success_add' => true]);
      }else{
        echo json_encode(['success_add' => false]);
      }
    }


  //Settings for Contractors

  public function viewContractor(Request $request){

    $contractor = DB::table('contractors');
    // if($request->search) {
    //   $contractor->where("name", "like", "$request->name");
    // }

    $contractor  = $contractor->orderBy('name')->paginate('30');

    return view('admin.settings.contractor.view_contractor')->with('datas', $contractor);
}

public function editContractor(Request $request){

  $id = $request->id;
  $name = $request->name;
  $email = $request->email;

  if(DB::table('contractors')->where('id', $id)->update(['name' => $name , 'email' => $email ])){
    echo json_encode(['success' => true]);
  }else{
    echo json_encode(['success' => false]);
  }
}

 public function deleteContractor($id){

  $contractor = DB::table('contractors')->where('id', $id)->delete();
  return redirect('admin/viewContractor');
}

public function addContractor(Request $request){

  $name = $request->name;
  $email = $request->email;

  if(DB::table('contractors')->insert(['name' => $name , 'email' => $email])){
    echo json_encode(['success_add' => true]);
  }else{
    echo json_encode(['success_add' => false]);
  }
}


}
