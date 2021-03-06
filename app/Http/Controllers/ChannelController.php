<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use DB;
use Session;
use View;
use App\Models\Category;
use App\Models\Channel;
use Illuminate\Http\Request;
use Validator;
use Input;

class ChannelController extends Controller {

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

        $channel_lists = Channel::from('channel_mst as ch')
                        ->join('category_mst as c', 'ch.fk_cat_id', '=', 'c.pk_cat_id')
                        ->select(DB::raw('ch.*,c.cate_name'))
                        ->get()->toArray();
        $data = array(
            'channel_lists' => $channel_lists
        );
        return View::make('admin.channel.list')->with($data);
    }

    public function add() {
        $category_lists = Category::get()->toArray();
        $data = array(
            'category_lists' => $category_lists
        );

        return View::make('admin.channel.add')->with($data);
    }

    public function ajax_add(Request $request) {

        $messsages = array(
            'pk_cat_id.required' => 'Please choose Category Name',
            'channel_name.required' => 'Please enter channel name',
            'channel_no.required' => 'Please enter Channel Number',
            'channel_url.required' => 'Please enter Channel URL',
        );

        $rules = array(
            'pk_cat_id' => 'required',
            'channel_name' => 'required',
            'channel_no' => 'required',
            'channel_url' => 'required',
            'channel_logo' => 'required'
        );

        $validator = Validator::make($request->all(), $rules, $messsages);

        if ($validator->fails()) {
            return response()->json([
                        'status' => 0,
                        'msg' => $validator->getMessageBag()->toArray()
                            ], 200);
        } else {
            if ($request->channel_logo->isValid()) {
                $file = $request->channel_logo;
                $input = array('image' => $file);

                $destinationPath = 'upload/channel/';
                $filename = md5(microtime() . $file->getClientOriginalName()) . "." . $file->getClientOriginalExtension();
                $request->channel_logo->move($destinationPath, $filename);
            } else {
                echo json_encode(array('status' => 0, 'msg' => "<p>Please upload only image</p>"));
                return false;
            }

            $add_channel = DB::table('channel_mst')->insert(
                    ['fk_cat_id' => $request->input('pk_cat_id'), 'channel_name' => $request->input('channel_name'), 'channel_no' => $request->input('channel_no'), 'channel_url' => $request->input('channel_url'), 'channel_logo' => $filename, 'updated_on' => date('Y-m-d H:i:s')]
            );
            if ($add_channel == 1) {
                Session::flash('SucMessage', ucfirst($request->input('channel_name')) . ' Channel Added Successfully');
                echo json_encode(array('status' => 1));
            } else {
                echo json_encode(array('status' => 0, 'msg' => 'Channel Added Not Successfully'));
            }
        }
    }

    public function exist_channel_check(Request $request) {
        if ($request->method() == "POST") {
            $query = Channel::select('channel_name')->where('channel_name', $request->input('channel_name'))->where('fk_cat_id', $request->input('fk_cat_id'));
            if ($request->input('pk_ch_id') != "") {
                $query->where(DB::raw('md5(pk_ch_id)'), '!=', $request->input('pk_ch_id'));
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
        $category_lists = Category::get()->toArray();
        $get_channel_list = Channel::from('channel_mst as ch')->where(DB::raw('md5(pk_ch_id)'), $id)
                        ->join('category_mst as c', 'ch.fk_cat_id', '=', 'c.pk_cat_id')
                        ->select(DB::raw('ch.*,c.cate_name'))
                        ->get()->toArray();
        if (count($get_channel_list) > 0) {
            $data = array(
                'get_channel_list' => $get_channel_list, 'pk_ch_id' => $id, 'category_lists' => $category_lists
            );
            return View::make('admin.channel.edit')->with($data);
        }
        else
        {
            return redirect('admin/channel');
        }
    }

    public function ajax_edit(Request $request) {
        $messsages = array(
            'pk_cat_id.required' => 'Please choose Category Name',
            'channel_name.required' => 'Please enter channel name',
            'channel_no.required' => 'Please enter Channel Number',
            'channel_url.required' => 'Please enter Channel URL',
        );

        $rules = array(
            'pk_cat_id' => 'required',
            'channel_name' => 'required',
            'channel_no' => 'required',
            'channel_url' => 'required'
        );

        $validator = Validator::make($request->all(), $rules, $messsages);

        if ($validator->fails()) {
            return response()->json([
                        'status' => 0,
                        'msg' => $validator->getMessageBag()->toArray()
                            ], 200);
        } else {



            $id = $request->input('pk_ch_id');
            $get_channel_list = Channel::from('channel_mst as ch')->where(DB::raw('md5(pk_ch_id)'), $id)
                            ->join('category_mst as c', 'ch.fk_cat_id', '=', 'c.pk_cat_id')
                            ->select(DB::raw('ch.*,c.cate_name'))
                            ->get()->toArray();
            $filename = $get_channel_list[0]['channel_logo'];
            If (Input::hasFile('channel_logo')) {
                if ($get_channel_list[0]["channel_logo"] != "") {
                    $image_file = './upload/channel/' . $get_channel_list[0]["channel_logo"];
                    if (file_exists($image_file)) {
                        unlink($image_file);
                    }
                }
                $file = $request->channel_logo;
                $input = array('image' => $file);

                $destinationPath = 'upload/channel/';
                $filename = md5(microtime() . $file->getClientOriginalName()) . "." . $file->getClientOriginalExtension();
                $request->channel_logo->move($destinationPath, $filename);
            }
            $update_user = DB::table('channel_mst')->where(DB::raw('md5(pk_ch_id)'), $id)->update(
                    ['fk_cat_id' => $request->input('pk_cat_id'), 'channel_name' => $request->input('channel_name'), 'channel_no' => $request->input('channel_no'), 'channel_url' => $request->input('channel_url'), 'channel_logo' => $filename, 'updated_on' => date('Y-m-d H:i:s')]
            );
            if ($update_user == 1) {
                Session::flash('SucMessage', ucfirst($request->input('fname')) . ' Channel Updated Successfully');
                echo json_encode(array('status' => 1));
            } else {
                echo json_encode(array('status' => 0, 'msg' => 'Channel Updated Not Successfully'));
            }
        }
    }

    public function change_channel_active(Request $request) {
        if ($request->method() == "POST") {
            $id = trim($request->input('pk_ch_id'));
            $update_user = DB::table('channel_mst')->where(DB::raw('md5(pk_ch_id)'), $id)->update(['standing' => $request->input('standing')]);
            $standing = ($request->input('standing') == 1 ? 'Active' : 'Inactive');
            if ($update_user == 1) {
                echo json_encode(array('status' => 1, 'msg' => "Channel $standing Successfully"));
            } else {
                echo json_encode(array('status' => 0, 'msg' => "Channel $standing Not Successfully"));
            }
        }
    }

    public function delete($id) {
        $get_channel_list = Channel::from('channel_mst as ch')->where(DB::raw('md5(pk_ch_id)'), $id)
                        ->join('category_mst as c', 'ch.fk_cat_id', '=', 'c.pk_cat_id')
                        ->select(DB::raw('ch.*,c.cate_name'))
                        ->get()->toArray();
        if (count($get_channel_list) > 0) {
            $image_file = './upload/channel/' . $get_channel_list[0]["channel_logo"];
            if (file_exists($image_file)) {
                unlink($image_file);
            }            
            $delete_record = Channel::from('channel_mst')->where(DB::raw('md5(pk_ch_id)'), $id)->delete();
            if ($delete_record == 1) {
                Session::flash('SucMessage', 'Channel has been deleted successfully!');
            } else {
                Session::flash('ErrorMessages', 'Channel has not been deleted successfully!');
            }
        }
        return redirect('admin/channel');
    }

}
