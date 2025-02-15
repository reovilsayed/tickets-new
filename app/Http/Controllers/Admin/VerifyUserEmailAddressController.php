<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Http\Controllers\Controller;

class VerifyUserEmailAddressController extends Controller
{
    public function __invoke(User $user)
    {
        if ($user->hasVerifiedEmail()) {
            return redirect()->back();
        }

        $user->markEmailAsVerified();

        return redirect()->back()->with([
            'message'    => 'User email successfully verified',
            'alert-type' => 'success',
        ]);
    }
}
