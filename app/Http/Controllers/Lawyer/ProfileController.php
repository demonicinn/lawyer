<?php

namespace App\Http\Controllers\Lawyer;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Lawyer_info;
use Illuminate\Http\Request;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use App\Models\UserDetails;
use App\Models\State;
use App\Models\LawyerHours;
use App\Notifications\MailToAdminForLawyerStatus;
use Illuminate\Support\Facades\Notification;

class ProfileController extends Controller
{
    use LivewireAlert;

    //
    public function index()
    {

        $title = array(
            'title' => 'Profile',
            'active' => 'profile',
        );

        $user = auth()->user();
        $states = State::whereStatus('1')->pluck('name', 'id');
        // dd($user);

        $categories = Category::whereStatus('1')->where('is_multiselect', '0')->get();
        $categoriesMulti = Category::whereStatus('1')->where('is_multiselect', '1')->get();
        


        //    dd($categories);
        return view('lawyer.profile.index', compact('user', 'title', 'states', 'categories', 'categoriesMulti'));
    }

    //
    public function update(Request $request)
    {
        //dd($request->all());
        $request->validate([
            'bio' => 'required',
            'contingency_cases' => 'required',
            'is_consultation_fee' => 'required',
            'hourly_fee' => 'required',
            'website_url' => 'nullable|url',
            'first_name' => 'required|max:50',
            'last_name' => 'required|max:50',
            'contact_number' => 'required|numeric|digits_between:10,12',
            'address' => 'required',
            'city' => 'required|max:100',
            'state' => 'required',
            'zip_code' => 'required|max:20',
            //'bar_number' => 'required|numeric',
            //'year_admitted' => 'required|numeric',
            'year_experience' => 'required|numeric',
            // 'lawyer_info.*'=>'required|array',
        ]);


        $user = auth()->user();

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
        $user->save();


        //...
        $details = new UserDetails;
        if (@$user->details) {
            $details->id = $user->details->id;
            $details->exists = true;
        } else {
            $details->users_id = $user->id;
        }
        $details->bio = $request->bio;
        $details->contingency_cases = $request->contingency_cases;
        $details->is_consultation_fee = $request->is_consultation_fee;
        $details->hourly_fee = $request->hourly_fee;
        $details->consultation_fee = $request->consultation_fee;
        $details->website_url = $request->website_url;
        $details->address = $request->address;
        $details->city = $request->city;
        $details->states_id = $request->state;
        $details->zip_code = $request->zip_code;
        $details->bar_number = $request->bar_number;
        $details->year_admitted = $request->year_admitted;
        $details->year_experience = $request->year_experience;
        $details->save();


        //...Working Hours
        if ($request->day) {
            foreach ($request->day as $day => $data) {
                if (@$data['from_time'] && $data['to_time']) {

                    $checkHour = LawyerHours::where(['users_id' => $user->id, 'day' => $day])->first();

                    $hour = new LawyerHours;
                    if (@$checkHour) {
                        $hour->id = $checkHour->id;
                        $hour->exists = true;
                    }
                    $hour->users_id = $user->id;
                    $hour->day = $day;
                    $hour->from_time = $data['from_time'];
                    $hour->to_time = $data['to_time'];
                    $hour->save();
                }
            }
        }

        //...save category and items id's
        if ($request->lawyer_info) {
            // on update
            Lawyer_info::where('user_id', auth()->user()->id)->delete();

            foreach ($request->lawyer_info as $cat_id => $item_id) {
                $storeInfo = new Lawyer_info();
                $storeInfo->user_id = auth()->user()->id;
                $storeInfo->category_id = $cat_id;
                $storeInfo->item_id = $item_id;
                $storeInfo->save();
            }
        }

        //.........
        if ($request->lawyer_address) {
            // on update
            Lawyer_info::where('user_id', auth()->user()->id)->delete();

            foreach ($request->lawyer_address as $cat_id => $items) {
                
                foreach ($items['data'] as $itemId => $item) {

                    $storeInfo = new Lawyer_info();
                    $storeInfo->user_id = auth()->user()->id;
                    $storeInfo->category_id = $cat_id;
                    $storeInfo->item_id = $itemId;
                    $storeInfo->year_admitted = @$item['year_admitted'];
                    $storeInfo->bar_number = @$item['bar_number'];
                    $storeInfo->save();
                }
            }
        }


        //...
        $this->flash('success', 'Profile updated successfully');
        return redirect()->back();
    }

    public function submit(Request $request)
    {

        $user = auth()->user();
        $details = $user->details;

        $hoursCount = $user->lawyerHours->count();

        if ($details->is_verified == 'no' && $details->address && $details->review_request == '0' && $hoursCount > 0) {

            $details->review_request = '1';
            $details->save();

            //...send mail

            Notification::route('mail', env('MAIL_FROM_ADDRESS'))->notify(new MailToAdminForLawyerStatus($user));

            $this->flash('success', 'Request Send');
            return redirect()->back();
        }

        //...
        $this->flash('error', 'Invalid Request');
        return redirect()->back();
    }
}
