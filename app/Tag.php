<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    
	public $table = "tags";

	public $primaryKey = "id";
    
	public $timestamps = true;

	public $fillable = [
	    "name"
	];

	public static $rules = [
	    "name" => "required"
	];

}
