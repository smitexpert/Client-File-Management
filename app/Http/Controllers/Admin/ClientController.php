<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\File;
use App\Notifications\CustomerAccountCreationNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Notification;

class ClientController extends Controller
{
    public function index()
    {
        $users = Customer::orderBy('id')->get();
        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        return view('admin.users.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|min:3',
            'email' => 'required|email|unique:customers,email',
            'password' => 'required|confirmed|min:6'
        ]);

        $customer = Customer::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);


        Notification::send($customer, new CustomerAccountCreationNotification($request->name, $request->email, $request->password));

        return redirect()->route('admin.users')->with('success', 'User account created!');

    }

    public function edit($id)
    {
        $user = Customer::findOrFail($id);
        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, $id)
    {
        $user = Customer::findOrFail($id);

        $request->validate([
            'name' => 'required|min:3',
            'email' => 'required|email|unique:customers,email,'.$id,
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email
        ]);

        if($request->password != null)
        {
            $request->validate([
                'password' => 'required|confirmed|min:6'
            ]);

            $user->update([
                'password' => $request->password
            ]);
        }

        return back()->with('success', 'User Account Updated!');
    }

    public function files($id)
    {
        $user = Customer::findOrFail($id);
        $files = File::where('customer_id', $id)->orderBy('id', 'DESC')->get();

        return view('admin.users.files', compact('user', 'files'));
    }

    public function upload(Request $request, $id)
    {
        $user = Customer::findOrFail($id);

        $request->validate([
            'file' => 'required|mimes:pdf'
        ]);

        $file = $request->file('file');

        if($file->getClientOriginalExtension() != 'pdf')
        {
            return back()->with('error', 'File type should be PDF');
        }

        $real_name = $file->getClientOriginalName();

        $name = time().'_'.$id.'.'.$file->getClientOriginalExtension();

        $path = 'uploads/pdf';

        $file->move(public_path($path), $name);

        File::create([
            'customer_id' => $id,
            'name' => $path.'/'.$name,
            'file_name' => $real_name,
            'path' => url($path.'/'.$name)
        ]);

        return back()->with('success', 'User file upload!');
    }

}
