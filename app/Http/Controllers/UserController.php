<?php

namespace App\Http\Controllers;

use App\User;
use App\Http\Controllers\Controller;
use App\Car;
use DB;
use Session;
use View;
use App\Models\Customers;
use Illuminate\Http\Request;
use Validator;
use Auth;
use Excel;
use Input;

class UserController extends Controller {

    public function __construct() {
        $this->middleware('auth');
    }

    /**
     * Show the profile for the given user.
     *
     * @param  int  $id
     * @return Response
     */
    public function index() {
        //$customers = Customers::where('standing', '1')->get()->toArray(); 
        $user_list = Customers::get()->toArray();
        $data = array(
            'user_list' => $user_list
        );
        return View::make('admin.customers.list')->with($data);
    }

    public function add() {
        return View::make('admin.customers.add');
    }

    public function ajax_add(Request $request) {
        $validator = Validator::make($request->all(), [
                    'emailid' => 'required|email',
                    'fname' => 'required',
                    'lname' => 'required',
                    'mobileno' => 'required',
                    'vc_number' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                        'status' => 0,
                        'msg' => $validator->getMessageBag()->toArray()
                            ], 200);
        } else {
            $add_user = DB::table('cust_mst')->insert(
                    ['emailid' => $request->input('emailid'), 'fname' => $request->input('fname'), 'lname' => $request->input('lname'), 'mobileno' => $request->input('mobileno'), 'vc_number' => $request->input('vc_number')]
            );
            if ($add_user == 1) {
                Session::flash('SucMessage', ucfirst($request->input('fname')) . ' User Added Successfully');
                echo json_encode(array('status' => 1));
            } else {
                echo json_encode(array('status' => 0, 'msg' => 'User Added Not Successfully'));
            }
        }
    }

    public function exist_email_check(Request $request) {
        if ($request->method() == "POST") {
            $query = Customers::select('emailid')->where('emailid', $request->input('email'));
            if ($request->input('pk_cust_id') != "") {
                $query->where(DB::raw('md5(pk_cust_id)'), '!=', $request->input('pk_cust_id'));
            }
            $check_exist = $query->get()->toArray();
            //$customers = Customers::where(DB::raw('md5(pk_cust_id)'), 'c4ca4238a0b923820dcc509a6f75849b')->get()->toArray();
            if (count($check_exist)) {
                echo "1";
            } else {
                echo "0";
            }
        }
    }

    public function exist_vcnumber_check(Request $request) {

        if ($request->method() == "POST") {
            $query = Customers::select('vc_number')->where('vc_number', $request->input('vc_number'));
            if ($request->input('pk_cust_id') != "") {
                $query->where(DB::raw('md5(pk_cust_id)'), '!=', $request->input('pk_cust_id'));
            }
            $check_exist = $query->get()->toArray();
            //$customers = Customers::where(DB::raw('md5(pk_cust_id)'), 'c4ca4238a0b923820dcc509a6f75849b')->get()->toArray();
            if (count($check_exist)) {
                echo "1";
            } else {
                echo "0";
            }
        }
    }

    public function edit($id) {
        $get_user_list = Customers::where(DB::raw('md5(pk_cust_id)'), $id)->get()->toArray();
        if (count($get_user_list) > 0) {
            $data = array(
                'get_user_list' => $get_user_list, 'pk_cust_id' => $id
            );
            return View::make('admin.customers.edit')->with($data);
        }
    }

    public function ajax_edit(Request $request) {
        $validator = Validator::make($request->all(), [
                    'emailid' => 'required|email',
                    'fname' => 'required',
                    'lname' => 'required',
                    'mobileno' => 'required',
                    'vc_number' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                        'status' => 0,
                        'msg' => $validator->getMessageBag()->toArray()
                            ], 200);
        } else {
            $id = $request->input('pk_cust_id');
            $update_user = DB::table('cust_mst')->where(DB::raw('md5(pk_cust_id)'), $id)->update(
                    ['emailid' => $request->input('emailid'), 'fname' => $request->input('fname'), 'lname' => $request->input('lname'), 'mobileno' => $request->input('mobileno'), 'vc_number' => $request->input('vc_number')]
            );
            if ($update_user == 1) {
                Session::flash('SucMessage', ucfirst($request->input('fname')) . ' User Updated Successfully');
                echo json_encode(array('status' => 1));
            } else {
                echo json_encode(array('status' => 0, 'msg' => 'User Updated Not Successfully'));
            }
        }
    }

    public function change_users_active(Request $request) {
        if ($request->method() == "POST") {
            $id = trim($request->input('pk_cust_id'));
            $update_user = DB::table('cust_mst')->where(DB::raw('md5(pk_cust_id)'), $id)->update(['standing' => $request->input('standing')]);
            $standing = ($request->input('standing') == 1 ? 'Active' : 'Inactive');
            if ($update_user == 1) {
                echo json_encode(array('status' => 1, 'msg' => "User $standing Successfully"));
            } else {
                echo json_encode(array('status' => 0, 'msg' => "User $standing Not Successfully"));
            }
        }
    }

    public function excel() {
        $payments = Customers::get()->toArray();
        Excel::create('Users', function($excel) use ($payments) {

            // Set the spreadsheet title, creator, and description
            $excel->setTitle('Users');
            $excel->setCreator('User')->setCompany('AADHAR');
            $excel->setDescription('User Report file');
            $excel->sheet('sheet1', function($sheet) use ($payments) {
                $sheet->cell('A1', 'Sl.No');
                $sheet->cell('B1', 'firstname');
                $sheet->cell('C1', 'lastname');
                $sheet->cell('D1', 'emailid');
                $sheet->cell('E1', 'mobileno');
                $sheet->cell('F1', 'vcnumber');
            
                $x = 2;
                foreach ($payments as $key => $value) {

                    $sheet->cell('A' . $x, $key + 1);
                    $sheet->cell('B' . $x, $value['fname']);
//                    $sheet->cell("B" . $x, function($cell) {
//                        $cell->setBackground('#ccc');
//                    });
                    $sheet->cell('C' . $x, $value['lname']);
                    $sheet->cell('D' . $x, $value['emailid']);
                    $sheet->cell('E' . $x, $value['mobileno']);
                    $sheet->cell('F' . $x, $value['vc_number']);
                    //$sheet->cell('G' . $x, $value['created_on']);

                    $x++;
                }
            });
        })->download('xlsx');
    }

    public function importexcel() {
        if (Input::hasFile('import_file')) {

            //We can use two way
            //First way
            //$path = $request->import_file->getRealPath();
            //Second way
            $path = Input::file('import_file')->getRealPath();

            $data = Excel::load($path, function($reader) {
                        
                    })->get();

            if (!empty($data) && $data->count()) {
                $x = 0;
                foreach ($data as $key => $value) {

                    $check_email = Customers::select('emailid')->where('emailid', $value->emailid)->get()->toArray();

                    $checkvcnumber = Customers::select('vc_number')->where('vc_number', $value->vcnumber)->get()->toArray();


                    if ($value->firstname != "" && $value->lastname != "" && count($check_email) == 0 && $value->mobileno && count($checkvcnumber) == 0) {
                        $add_user = DB::table('cust_mst')->insert(
                                ['emailid' => $value->emailid, 'fname' => $value->firstname, 'lname' => $value->lastname, 'mobileno' => $value->mobileno, 'vc_number' => $value->vcnumber]
                        );
                        $x++;
                    }


                    //$insert[] = ['title' => $value->title, 'description' => $value->description];
                }


                if ($x > 0) {     
                    Session::flash('SucMessage', $x . ' User Added Successfully');
                    echo json_encode(array('status' => 1, 'msg' => $x . ' User Added Successfully'));
                   
                } else {
                    //echo $x;
                    echo json_encode(array('status' => 0, 'msg' => 'Users Added Not Successfully'));
                    
                }
            }
        }

        //return back();
    }

}
