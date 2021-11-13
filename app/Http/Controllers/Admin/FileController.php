<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\CustomerFileMail;
use App\Mail\CustomerMultiFileMail;
use App\Models\Customer;
use App\Models\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class FileController extends Controller
{
    public function index($id)
    {
        $file = File::findOrFail($id);
        return response()->file($file->name);
    }

    public function send($id, $customer)
    {
        $file = File::findOrFail($id);
        $user = Customer::findOrFail($customer);

        Mail::to($user)->send(new CustomerFileMail($user, $file));

        return back()->with('success', 'Mail successfully sent!');
    }

    public function multiple(Request $request, $customer)
    {
        $user = Customer::findOrFail($customer);
        $files = File::whereIn('id', $request->ids)->get();

        Mail::to($user)->send(new CustomerMultiFileMail($user, $files));

        return back()->with('success', 'Mail successfully sent!');
    }
}
