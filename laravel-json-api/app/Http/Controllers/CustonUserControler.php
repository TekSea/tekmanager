<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class CustonUserControler extends Controller
{
    
    public function show($id)
    {
        $user = User::where('id', $id)->firstOrFail();
        $user->makeHidden(['password', 'token']);
        return response()->json($user);
    }
}