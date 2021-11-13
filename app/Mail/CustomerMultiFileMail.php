<?php

namespace App\Mail;

use App\Models\Customer;
use App\Models\File;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CustomerMultiFileMail extends Mailable
{
    use Queueable, SerializesModels;

    protected $files, $customer;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Customer $customer, $files)
    {
        $this->files = $files;
        $this->customer = $customer;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $email = $this->markdown('emails.files.multiplefile')
        ->subject('Your PDF file is ready!');
        foreach($this->files as $file)
        {
            $email->attach(public_path($file->name));
        }

        return $email;
    }
}
