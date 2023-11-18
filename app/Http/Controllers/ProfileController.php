<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileForm;
use App\Models\Profile;
use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Facades\Image;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProfileForm $request): \Illuminate\Http\RedirectResponse
    {
        $dataValidated = $request->validated();

        if($dataValidated){
            $requestImage = $request->file('imageUpload');
            $img = Image::make($requestImage);

            $img->resize(null, 400, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            });

            $name = $requestImage->hashName();
            $path = 'storage/images/'.$name;

            $img->save($path); // Store the image

            // We register the image:
            Profile::updateOrCreate(
                ['user_id' => Auth::id()],
                ['imageUpload' => $path]
            );

            return back()->with('success', "Your image has been uploaded.");
        }
        else {
            return back()->with('error', "Your image couldn't be uploaded. Check for any errors");
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Profile $profile)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Profile $profile): \Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|
    \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\Foundation\Application
    {
        $user = User::find(Auth::id());
        return view('profile/edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Profile $profile)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Profile $profile)
    {
        //
    }
}
