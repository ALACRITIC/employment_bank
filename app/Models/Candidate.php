<?php

namespace employment_bank\Models;

use Illuminate\Database\Eloquent\Model;

class Candidate extends Model{

    protected $table = 'students';
    protected $guarded = ['_token'];
    protected $hidden = ['password'];

    public static $rules = [
        'fullname' => 'required|between:3,55',
        'username'=> 'required|min:3|regex:/^[\pL\s]+$/u|unique:candidates,username',
        'mobile_no'=> 'required|digits:10|numeric|unique:candidates,mobile_no',
        'email'=> 'email|required|max:100|unique:candidates,email',
        'password'=> 'confirmed|required',
    ];

    public static $messages = [
        'username.min' => 'Username must be atleast minimum 3 characters',
        'mobile_no.numeric' => 'Mobile No can only contain numbers',
        'password.confirmed' => 'Password and Confirm Password does not match',
    ];

    protected $fillable = ['username', 'fname', 'mname', 'lname', 'mobile_no', 'email', 'password', 'reset_key', 'active', 'remember_token'];
    //
}
