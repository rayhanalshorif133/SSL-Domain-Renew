<?php

namespace App\Http\Controllers;

use App\Models\Domain;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\DomainRenewMail;

class DomainController extends Controller
{


    public function sendMails()
    {

        //    $domain = Domain::find(1); // ধরুন ID 1 এর ডোমেইনের ডেটা নিচ্ছেন
        //     Mail::to('user@example.com')->send(new DomainRenewMail($domain));
        //     return "Email sent!";

        $domains = Domain::whereDate('expiry_date', now()->addDays(3))->get(); // যাদের রিনিউ ৩ দিন পর

        foreach ($domains as $domain) {
            Mail::to($domain->client_email)->send(new DomainRenewMail($domain));
        }

        return "মেইল পাঠানো সম্পন্ন হয়েছে!";
    }
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

    public function store(Request $request)
    {
        //
    }



    public function update(Request $request, Domain $domain)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Domain $domain)
    {

    }
}
