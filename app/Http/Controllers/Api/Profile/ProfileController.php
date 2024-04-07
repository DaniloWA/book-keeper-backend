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
        $profiles->load('user');

        return $this->successResponse(ProfileResource::collection($profiles), 'Profiles retrieved successfully', 200);
    }

    public function store(ProfileRequest $request)
    {
        $user = Auth::user();
        $payload = $request->validated();
        $payload['user_id'] = $user->id;

        $profile = Profile::create($payload);
        $profile->load('user');

        return $this->successResponse(new ProfileResource($profile), 'Profile created successfully', 201);
    }

    public function show($slug)
    {
        $user = User::where('slug', $slug)->firstOrFail();
        $profile = $user->profile;

        if ($profile) {
            $profile->load('user');
            return $this->successResponse(new ProfileResource($profile), 'Profile retrieved successfully', 200);
        }

        return $this->errorResponse('Profile not found', 404);
    }

    public function update(ProfileRequest $request, $slug)
    {
        $user = User::where('slug', $slug)->firstOrFail();
        $profile = $user->profile;

        if ($profile) {
            $payload = $request->validated();
            $profile->update($payload);
            $profile->load('user');
            return $this->successResponse(new ProfileResource($profile), 'Profile updated successfully', 200);
        }

        return $this->errorResponse('Profile not found', 404);
    }


    public function destroy($slug)
    {
        $user = User::where('slug', $slug)->firstOrFail();
        $profile = $user->profile;

        if ($profile) {
            $profile->delete();
            return $this->successResponse(null, 'Profile deleted successfully', 204);
        }

        return $this->errorResponse('Profile not found', 404);
    }
}
