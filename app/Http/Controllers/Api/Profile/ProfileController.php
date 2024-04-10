<?php

namespace App\Http\Controllers\Api\Profile;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProfileRequest;
use App\Http\Resources\ProfileResource;
use App\Models\Profile;
use App\Models\User;
use App\Traits\ApiResponser;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    use ApiResponser;

    public function index()
    {
        $profiles = Profile::all();

        return $this->successResponse(ProfileResource::collection($profiles), 'Profiles retrieved successfully', 200);
    }

    public function store(ProfileRequest $request)
    {
        $user = Auth::user();
        $payload = $request->validated();
        $payload['user_id'] = $user->id;

        if($user->profile) {
            $user->profile->update($payload);
            return $this->successResponse(
                ProfileResource::make($user->profile),
                'Profile updated successfully',
                201
            );
        }

        $profile = Profile::create($payload);

        return $this->successResponse(
            ProfileResource::make($profile),
            'Profile created successfully',
            201
        );
    }

    public function show($slug)
    {
        $user = User::with('profile')->where('slug', $slug)->first();

        if (!$user) {
            return $this->errorResponse('User not found', 404);
        }

        if ($user->profile) {
            return $this->successResponse(new ProfileResource($user->profile), 'Profile retrieved successfully', 200);
        }

        return $this->errorResponse('Profile not found', 404);
    }

    public function update(ProfileRequest $request, $slug)
    {
        $user = User::with('profile')->where('slug', $slug)->first();

        if (!$user) {
            return $this->errorResponse('User not found', 404);
        }

        if ($user->profile) {
            $payload = $request->validated();
            $user->profile->update($payload);
            return $this->successResponse(new ProfileResource($user->profile), 'Profile updated successfully', 200);
        }

        return $this->errorResponse('Profile not found', 404);
    }


    public function destroy($slug)
    {
        $user = User::where('slug', $slug)->first();

        if (!$user) {
            return $this->errorResponse('User not found', 404);
        }

        if ($user->profile) {
            $user->profile->delete();
            return $this->successResponse([], 'Profile deleted successfully', 200);
        }

        return $this->errorResponse('Profile not found', 404);
    }
}
