<?php

namespace App\Http\Controllers\Api\User;

use App\Models\User;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    use ApiResponser;

    public function getUsersRegistered()
    {
        $users = User::with('profile')
            ->whereNot('id', '=', Auth::user()->id)
            ->get();

        return $this->successResponse($users, 'Users registered retrieved successfully', 200);
    }
}
