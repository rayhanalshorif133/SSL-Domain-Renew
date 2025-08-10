<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Domain;
use App\Mail\DomainRenewMail;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;




class SendDomainRenewReminder extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:send-domain-renew-reminder';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Get domains that need renewal tomorrow
        // ✅ আজ থেকে ৩ দিন পর যেসব ডোমেইন এক্সপায়ার হচ্ছে
        // $targetDate = \Carbon\Carbon::now()->addDays(5)->toDateString();
        $today =  \Carbon\Carbon::today();

        $domains = \App\Models\Domain::whereDate('expiry_date', $today)
                         ->whereNotNull('client_email')
                         ->where('status', 'active') // ✅ শুধুমাত্র অ্যাক্টিভ ডোমেইনগুলো
                         ->where('email_status', 'false') // ✅ যাদের ইমেইল স্ট্যাটাস 'false'
                         ->select('id', 'name', 'client_email', 'expiry_date','email_status', 'status') //
                         ->get();

        dd($domains);

      if ($domains->isNotEmpty()) {
            $expiry = Carbon::parse($domain->expiry_date);
            $diffDays = $today->diffInDays($expiry, false);

            foreach ($domains as $domain) {
                // ইমেইল পাঠানো (আপনি চাইলে চালু করবেন)
                // Mail::to($domain->client_email)->send(new DomainRenewMail($domain));
                $domain->email_status = 'true';
                // $domain->save();

                $this->info("✅ Email sent and status updated for domain: {$domain->name}");
            }
        } else {
            $this->info("No domains need renewal.");
        }
    }

}
