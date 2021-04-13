<?php

namespace App\Http\Controllers\Admin;

use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use App\Http\Controllers\BaseController;
use App\Models\ContactUs;

class SettingController extends BaseController
{

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
		$setting = new Setting();
        $this->setPageTitle('Settings', 'Manage Settings');
        return view('admin.settings.index', compact('setting'));
    }

    /**
     * @param Request $request
     */
    public function update(Request $request)
    {
		$keys = $request->except('_token');
		foreach ($keys as $key => $value)
		{
			Setting::set($key, $value);
		}

	    return $this->responseRedirectBack('Settings updated successfully.', 'success');
    }

    public function contact_us(Request $req)
    {
        $contact = ContactUs::where('type',1)->first();
        return view('admin.contact.index',compact('contact'));
    }

    public function saveContactUs(Request $req)
    {
        $req->validate([
            'email' => 'required|email|string|max:200',
            'mobile' => 'required|string|max:20',
            'address' => 'required',
        ]);
        $contact = ContactUs::where('type',1)->first();
        if(!$contact){
            $contact = new ContactUs();
        }
        $contact->email = $req->email;
        $contact->mobile = $req->mobile;
        $contact->address = $req->address;
        $contact->save();
        return $this->responseRedirectBack('Contact Save successfully.', 'success');
    }

    public function contactUsList(Request $req)
    {
        $list = ContactUs::where('type',2)->with('user')->orderBy('id','DESC')->get();
        return view('admin.contact.list',compact('list'));
    }
}
