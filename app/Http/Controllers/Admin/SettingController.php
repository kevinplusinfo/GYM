<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SettingController extends Controller
{

    public function index(){
        $setting = Setting::first();
        return view('Admin.Setting.Index', compact('setting'));
    }

    public function weblogo(){
        $setting = Setting::first();
        return view('Admin.Setting.WebsiteLogo', compact('setting'));
    }

    public function contact(){
        $setting = Setting::first();
        return view('Admin.Setting.contact', compact('setting'));
    }

    public function favicon(){
        $setting = Setting::first();
        return view('Admin.Setting.Favicon', compact('setting'));
    }

    public function sociallink(){
        $setting = Setting::first();
        return view('Admin.Setting.Sociallink', compact('setting'));
    }

    public function aboutas(){
        $setting = Setting::first();
        return view('Admin.Setting.AboutAs', compact('setting'));
    }

    public function storeaboutas(Request $request){
        $request->validate([
            'about_title' => 'nullable|string',
            'about_description' => 'nullable|string',
            'video_link' => 'nullable|url',
        ]); 
        $setting = Setting::firstOrNew(['id' => 1]);

        $setting->about_title = $request->input('about_title');
        $setting->about_desciption = $request->input('about_description');
        $setting->video_link = $request->input('video_link');
        $setting->save();

        return redirect()->back()->with('success', 'Settings updated successfully!');
        
    }

    public function storecontact(Request $request){
        $request->validate([
            'addresh' => 'nullable|string',
            'mno1' => 'nullable|string',
            'mno2' => 'nullable|string',
            'email' => 'nullable|email',
        ]);
        $setting = Setting::firstOrNew(['id' => 1]);

        $setting->addresh = $request->input('addresh');
        $setting->mno1 = $request->input('mno1');
        $setting->mno2 = $request->input('mno2');
        $setting->email = $request->input('email');
        $setting->save();

        return redirect()->back()->with('success', 'Settings updated successfully!');

    }

    public function storesocial(Request $request)
    {
        $setting = Setting::firstOrNew(['id' => 1]);

        $setting->facebook_link = $request->input('facebook_link');
        $setting->twitter_link = $request->input('twitter_link');
        $setting->youtube_link = $request->input('youtube_link');
        $setting->instagram_link = $request->input('instagram_link');
        $setting->gmail_link = $request->input('gmail_link');
        $setting->footerdescription = $request->input('footerdescription');

        $setting->save();

        return redirect()->back()->with('success', 'Settings updated successfully!');
    }

    public function storeOrUpdate(Request $request){
        $request->validate([
            'img1' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'img2' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'favicon' => 'nullable|image|mimes:jpeg,png,jpg,gif,ico|max:1024',
            'wlogo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
    
        $setting = Setting::firstOrNew(['id' => 1]);
        if ($request->hasFile('img1')) {
            if ($setting->img1) {
                Storage::delete($setting->img1); 
            }
            $setting->img1 = $request->file('img1')->store('indexbanner', 'public');
        }
        if ($request->hasFile('img2')) {
            if ($setting->img2) {
                Storage::delete($setting->img2);
            }
            $setting->img2 = $request->file('img2')->store('indexbanner', 'public');
        }
        if ($request->hasFile('favicon')) {
            if ($setting->favicon) {
                Storage::delete($setting->favicon);
            }
            $setting->favicon = $request->file('favicon')->store('favicons', 'public');
        }
        if ($request->hasFile('wlogo')) {
            if ($setting->wlogo) {
                Storage::delete($setting->wlogo);
            }
            $setting->wlogo = $request->file('wlogo')->store('wlogo', 'public');
        }
        $setting->save();
        return redirect()->back()->with('success', 'Settings updated successfully!');
    }
    
}
