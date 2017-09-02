<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class RegisterConfirmationController extends Controller
{
    public function index()
    {
        try {
            User::where('confirmation_token', request('token'))
                ->firstOrFail()
                ->confirm();
        } catch (ModelNotFoundException $e) {
            return redirect('thread')->with([
                'flash.message' => 'Invalid token.',
                'flash.status' => 'danger',
            ]);
        }

        return redirect('thread')->with('flash.message', 'Your account is now confirmed! You may post to forum.');
    }
}
