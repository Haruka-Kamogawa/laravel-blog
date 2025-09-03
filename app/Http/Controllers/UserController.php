<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    private $user;
    const LOCAL_STORAGE_FOLDER = 'avatar/'; // folder path where the avatar will be stored

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    // Opens the profile page
    public function show(){
        return view('users.show')->with('user', Auth::user());
    }

    // Opens edit page
    public function edit(){
        return view('users.edit')->with('user', Auth::user());
    }

    // Update the user
    public function update(Request $request){
        // Validate the request
        $request->validate([
            'avatar' => 'mimes:jpeg,jpg,png,gif|max:1048',
            'name' => 'required|max:50',
            'email' => 'required|email|max:50|unique:users,email,' . Auth::user()->id,
            'password' => 'required|min:8'
                                            // check all emails inside users table except/skip this ID
        ]);

        // Insert new date: unique:table,column / unique:table
        // Update new date: unique:table,column,exceptID

        $user = $this->user->findOrFail(Auth::user()->id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = $request->password;


        // If there is a new image
        if($request->avatar){
            // 1. If the user currently has an avatar, delete it first from local storage
            $this->deleteAvatar($user->avatar);

            // 2. Save the new image
            $user->avatar = $this->saveAvatar($request->avatar);
        }

        $user->save();

        return redirect()->route('profile.show');
    }

    private function saveAvatar($avatar){
        // 1. Change the name of the image to CURRENT TIME to avoid overwriting
        $avatar_name = time() . "." . $avatar->extension();

        // 2. Save the avatar to storage/app/public/avatars
        $avatar->storeAs(self::LOCAL_STORAGE_FOLDER, $avatar_name);

        return $avatar_name;
    }

    // Delete the previous/old avatar from the local storage
    private function deleteAvatar($avatar){
        $avatar_path = self::LOCAL_STORAGE_FOLDER . $avatar; // location of the old avatar

        if(Storage::disk('public')->exists($avatar_path)){ // storage/app/public/avatar/17123456789.jpg
            Storage::disk('public')->delete($avatar_path);
        }
    }




    public function specificShow($id){
        $user = $this->user->findOrFail($id);

        if($user == Auth::user()){
            return view('users.show')->with('user', $user);
        }

        return view('users.specificshow')->with('user', $user);
    }
}
