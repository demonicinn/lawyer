<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Session;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class ProfileControlller extends Controller
{
    use LivewireAlert;
    public function index()
    {

        $title = array(
            'title' => 'Update Account Information',
            'active' => 'profile',
        );

        $user = auth()->user();
        return view('admin.profile.index', compact('user', 'title'));
    }
    
    public function update(Request $request)
    {
        $user = auth()->user();
        
        $request->validate([

            'first_name' => 'required|max:50',
            'last_name' => 'required|max:50',
            'contact_number' => 'required',
            'email' => 'required|email|unique:users,email,'.$user->id,

        ]);

        

        if ($request->image && strpos($request->image, "data:") !== false) {
            $image = $request->image;

            $folderPath = ('storage/images/');
            if (!is_dir($folderPath)) {
                mkdir($folderPath, 0775, true);
                chown($folderPath, exec('whoami'));
            }

            $image_parts = explode(";base64,", $image);
            $image_type_aux = explode("image/", $image_parts[0]);
            $image_base64 = base64_decode($image_parts[1] ?? null) ?? null;
            $file_name = $user->id . '-' . md5(uniqid() . time()) . '.png';
            $imageFullPath = $folderPath . $file_name;
            file_put_contents($imageFullPath, $image_base64);

            //...
            $user->image = $file_name;
        }
        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->contact_number = $request->contact_number;
        $user->email = $request->email;
        $user->save();

      
        $this->flash('success', 'Profile updated successfully');
        return redirect()->back();
    }
}
