<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
   /**
    * The database table used by the model.
    *
    * @var string
    */
   protected $table = 'category_mst';

   /*
    * The attributes that are mass assignable.
    *
    * @var array
    */
   //protected $fillable = ['name', 'email', 'password'];

   /*
    * The attributes excluded from the model's JSON form.
    *
    * @var array
    */
   //protected $hidden = ['password', 'remember_token'];
}