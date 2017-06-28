<?php

namespace App\Http\Controllers;

use App\User;

class ProfileController extends Controller
{
    public function show(User $user)
    {
        $activitiesGroupByDay = $user->activities()->latest()->get()->groupBy(function ($record) {
            return $record->created_at->format('Y-m-d');
        });

        return view('profile.show', [
            'profileUser' => $user,
            'activitiesGroupByDay' => $activitiesGroupByDay,
        ]);
    }
}
