<?php

namespace App\Http\Controllers;

use App\User;
use Validator;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;
use View;
use Input;
use Auth;
use App\Http\Requests;

class LoginController extends Controller {
    
    /**
     * Store a new blog post.
     *
     * @param  Request  $request
     * @return Response
     */
    public function index() {
        if (Auth::check()) {
           return Redirect::to('/admin/dashboard');
        } else {
           return View::make('login.login');  
        }
    }

    public function ajax_check(Request $request) {
        $validator = Validator::make($request->all(), [
                    'email' => 'required|email',
                    'password' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                        'status' => 0,
                        'msg' => $validator->getMessageBag()->toArray()
                            ], 200);
        } else {
            $userdata = array(
                'email' => Input::get('email'),
                'password' => Input::get('password')
            );
            if (Auth::attempt($userdata)) {
                return response()->json([
                            'status' => 1
                                ], 200);
            } else {
                return response()->json([
                            'status' => 0,
                            'msg' => array("Invalid Credential")
                                ], 200);
            }
        }
    }

}
