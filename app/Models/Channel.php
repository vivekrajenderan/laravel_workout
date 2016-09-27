<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Channel extends Model
{
   /**
    * The database table used by the model.
    *
    * @var string
    */
   protected $table = 'channel_mst';

   /*
    * The attributes that are mass assignable.
    *
    * @var array
    */
   protected $fillable = ['pk_ch_id', 'fk_cat_id', 'channel_name','channel_logo','channel_no','channel_url','standing','updated_on'];

   /*
    * The attributes excluded from the model's JSON form.
    *
    * @var array
    */
   //protected $hidden = ['password', 'remember_token'];
}