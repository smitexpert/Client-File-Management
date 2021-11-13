<?php

namespace App\Mail;

use App\Models\Customer;
use App\Models\File;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CustomerFileMail extends Mailable
{
    use Queueable, SerializesModels;
    public $customer, $file;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Customer $customer, File $file)
    {
        $this->customer = $customer;
        $this->file = $file;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.customer.files.send_pdf')
            ->subject('You get all of your files.')
            ->attach(public_path($this->file->name));
    }


}
