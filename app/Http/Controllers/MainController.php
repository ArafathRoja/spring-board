<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Samples;
use App\Country;
use App\State;
use App\City;
use Excel;
use App\Exports\SamplesExport;
//use Maatwebsite\Excel\Facades\Excel;

class MainController extends Controller
{
   	public function index()
   	{
   		$data['countries'] = DB::table("countries")->pluck("name", "id");
   		return view('form', ['countries' => $data['countries']]);
   	}

   	public function postData(Request $request, Samples $sample)
   	{
   		$data['f_name'] = $request->get('f_name');
   		$data['l_name'] = $request->get('l_name');
   		$data['dob'] = $request->get('dob');
   		$data['address1'] = $request->get('address1');
   		$data['address2'] = $request->get('address2');
   		$data['country'] = $request->get('country');
   		$data['state'] = $request->get('state');
   		$data['city'] = $request->get('city');
   		$data['pincode'] = $request->get('pincode');
   		$data['comments'] = $request->get('comments');
   		
   		$sample->insert($data);
		$result = $sample->get();

		$data['countries'] = DB::table("countries")->pluck("name", "id");

   		return view('view', ['data'=>$result, 'countries' => $data['countries']]);
   	}

   	public function doAction(Request $request)
   	{
   		//print_r($request->get('action'));
   		if ($request->action == 'edit') {
   			$data['f_name'] = $request->get('f_name');
	   		$data['l_name'] = $request->get('l_name');
	   		$data['dob'] = $request->get('dob');
	   		$data['address1'] = $request->get('address1');
	   		$data['address2'] = $request->get('address2');
	   		$data['country'] = Country::where('name', $request->get('country'))->select('id')->first()->id;
	   		$data['state'] = State::where('name', $request->get('state'))->select('id')->first()->id;
	   		$data['city'] = City::where('name', $request->get('city'))->select('id')->first()->id;
	   		$data['pincode'] = $request->get('pincode');
	   		$data['comments'] = $request->get('comments');
   			$save = DB::table('samples')->where('id',$request->id)->update($data);
   		}

   		if ($request->action == 'delete') {
   			DB::table('samples')->where('id',$request->id)->delete();
   		}

   		return response()->json($request);	
   	}

   	public function exportData()
   	{
   		return Excel::download(new SamplesExport, 'sample_data.xlsx');
   	}

   	/*public function exportData()
	{
		$data = DB::table('samples')->get()->toArray();
	
		if (empty($data) === false) {
			$cust[] = array('Id', 'First Name', 'Last Name', 'DOB',	'Address1', 'Address2', 'State', 'City', 'Country', 'Pincode','Comments');
			foreach ($data as $value) {
			 	$cust[] = array(
			 		'Id' => $value->id,
			 		'First Name' => $value->f_name, 
			 		'Last Name' =>  $value->l_name,
			 		'DOB' =>  $value->dob,
			 		'Address1' =>  $value->address1,
			 		'Address2' =>  $value->address2, 
			 		'State' => State::where('id','=',$value->state)->select('name')->first()->name,
			 		'City' => City::where('id','=',$value->city)->select('name')->first()->name, 
			 		'Country' => Country::where('id','=',$value->country)->select('name')->first()->name, 
			 		'Pincode' => $value->pincode,
			 		'Comments' => $value->comments
			 	);
			} 
			Excel::download('Customer Data', function($excel) use ($cust){
				$excel->setTitle('Customer Data');
				$excel->sheet('Customer Data', function($sheet) use ($cust){
					$sheet->fromArray($cust, null, 'A1', false, false);
				});
			})->download('xlsx');
			

			return ['success' => true, 'status' => 200,  'message' => 'File Exported !!'];
		}
		else
			return ['success' => false, 'status' => 500,  'message' => 'File Not Exported !!'];

	}*/

}
