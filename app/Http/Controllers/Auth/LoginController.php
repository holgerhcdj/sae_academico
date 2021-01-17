<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\DB;
use App\Models\AnioLectivo;
use App\Models\Usuarios;
use Session;
class LoginController extends Controller {
use AuthenticatesUsers;
     protected $redirectTo = '/home';

     public function __construct() {
        $this->middleware('guest')->except('logout');
    }




    
    
    
}
