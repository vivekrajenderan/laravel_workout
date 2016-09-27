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

class HomeController extends Controller {

    public function doLogout() {           
        Auth::logout(); // log the user out of our application
        return Redirect::to(''); // redirect the user to the login screen
    }

    public function showProduct() {
        // show the form
        return View::make('test');
    }
    

public function ajaxshow(Request $request)
{
            $validator = Validator::make($request->all(), [
                    'product.*' => 'required'
        ]);

        if ($validator->fails()) {
             return redirect('product')->withErrors($validator)->withInput();
            //echo "<pre>";print_r($validator->getMessageBag()->toArray());die;
        } else {
           
        }
}

//
//    public function doLogin() {
//// validate the info, create rules for the inputs
//        $rules = array(
//            'email' => 'required|email', // make sure the email is an actual email
//            'password' => 'required|alphaNum|min:3' // password can only be alphanumeric and has to be greater than 3 characters
//        );
//
//// run the validation rules on the inputs from the form
//        $validator = Validator::make(Input::all(), $rules);
//
//// if the validator fails, redirect back to the form
//        if ($validator->fails()) {
//            return Redirect::to('login')
//                            ->withErrors($validator) // send back all errors to the login form
//                            ->withInput(Input::except('password')); // send back the input (not the password) so that we can repopulate the form
//        } else {
//
//            // create our user data for the authentication
//            $userdata = array(
//                'email' => Input::get('email'),
//                'password' => Input::get('password')
//            );
//
//            // attempt to do the login
//            if (Auth::attempt($userdata)) {
//
//                // validation successful!
//                // redirect them to the secure section or whatever
//                // return Redirect::to('secure');
//                // for now we'll just echo success (even though echoing in a controller is bad)
//                echo 'SUCCESS!';
//               
//                
//            } else {
//
//                // validation not successful, send back to form 
//                return Redirect::to('login');
//            }
//        }
//    }
}
