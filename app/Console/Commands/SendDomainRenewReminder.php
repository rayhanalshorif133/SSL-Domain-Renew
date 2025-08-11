<?php
namespace App\Console\Commands;

use App\Mail\DomainRenewMail;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

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
        $targetDate = \Carbon\Carbon::now()->addDays(15)->toDateString();
        $domains = \App\Models\Domain::whereDate('expiration_date', '<=', $targetDate)
            ->whereNotNull('client_email')
            ->where('status', 'active')                                                                                  // ✅ শুধুমাত্র অ্যাক্টিভ ডোমেইনগুলো
            ->select('id', 'domain_name', 'client_email', 'domain_content', 'expiration_date', 'domain_buyer', 'status') //
            ->orderBy('expiration_date', 'DESC')                                                                         // ✅ এক্সপায়ার হওয়ার তারিখ অনুযায়ী সাজানো
            ->limit(20)                                                                                                  // ✅ সর্বোচ্চ 20টি ডোমেইন
            ->get();

        // dd($domains);

        if ($domains->isNotEmpty()) {

            foreach ($domains as $domain) {
                $emails = is_string($domain->client_email) ? json_decode($domain->client_email, true) : $domain->client_email; // যদি আগেই array হয়

                if (! is_array($emails)) {
                    $this->error("⚠️ Invalid client_email format for domain: {$domain->domain_name}");
                    continue;
                }

                foreach ($emails as $emailData) {
                    $recipient = $emailData['value'] ?? null;

                    if ($recipient && filter_var($recipient, FILTER_VALIDATE_EMAIL)) {
                        try {
                            Mail::to($recipient)->send(new DomainRenewMail($domain));
                            $this->info("📧 Email sent to: {$recipient}");
                        } catch (\Exception $e) {
                            $this->error("❌ Failed to send email to {$recipient}: " . $e->getMessage());
                        }
                    } else {
                        $this->error("⚠️ Invalid email skipped: " . json_encode($emailData));
                    }
                }

                try {
                    $domain->update(['email_status' => 'true']);
                    $this->info("✅ Email status updated for domain: {$domain->domain_name}");
                } catch (\Exception $e) {
                    $this->error("❌ Failed to update email_status for domain {$domain->domain_name}: " . $e->getMessage());
                }
            }

        } else {
            $this->info("No domains need renewal.");
        }
    }

}
