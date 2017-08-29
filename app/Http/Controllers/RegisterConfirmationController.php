<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class RegisterConfirmationController extends Controller
{
    public function index()
    {
        User::where('confirmation_token', request('token'))
            ->firstOrFail()
            ->confirm();

        return redirect('thread')->with('flash.message', 'Your account is now confirmed! You may post to forum.');
    }
}
