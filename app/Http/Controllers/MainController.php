<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Samples;

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

   		return view('view', ['data'=>$result]);
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
	   		$data['country'] = $request->get('country');
	   		$data['state'] = $request->get('state');
	   		$data['city'] = $request->get('city');
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
		$data = DB::table('samples')->get();
	
		if (empty($data) === false) {
			/*$file = fopen('user-details.csv', 'w');

			fputcsv($file, array('S.No', 'Name', 'Gender', 'Marital Status', 'Mobile', 'State', 'DOB'));

			foreach ($data as $value) {
				fputcsv($file, (array) $value);
			}
			 
			fclose($file);*/

			header('Content-type: text/csv');
			header('Content-Disposition: attachment; filename="user-details.csv"');

			header('Pragma: no-cache');
			header('Expires: 0');

			$file = fopen('php://output', 'w');
 
			fputcsv($file, array('S.No', 'f_name', 'l_name', 'dob', 'address1', 'address2', 'State', 'city', 'Country', 'pincode', 'comments'));

			foreach ($data as $value) {
				fputcsv($file, (array) $value);
			}
			exit();

			return ['success' => true, 'status' => 200,  'message' => 'File Exported !!'];
		}
		else
			return ['success' => false, 'status' => 500,  'message' => 'File Not Exported !!'];

	}

}
