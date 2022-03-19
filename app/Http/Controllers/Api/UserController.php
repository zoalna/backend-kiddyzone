<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\UserResource;
use App\Traits\ImageUploadTrait;
use App\Models\User;
use Auth;
use Validator;

class UserController extends Controller
{
    use ImageUploadTrait;


    public $successStatus = 200;
    public $unAuthorizedStatus = 401;
}
