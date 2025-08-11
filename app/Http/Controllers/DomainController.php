<?php
namespace App\Http\Controllers;

use App\Models\Domain;
use Illuminate\Http\Request;

class DomainController extends Controller
{
    public function index($id = null)
    {
        $domainContents = \App\Models\Domain::orderBy('id', 'desc')->get(); // সব রেকর্ড আনবে
        $editDomain     = $id ? Domain::findOrFail($id) : null;

        return view('home', compact('domainContents', 'editDomain'));
    }

    /**
     * Show the form for creating a new resource.
     */

    public function store(Request $request)
    {
        try {
            // Only logged-in users can store (extra safety)
            if (! auth()->check()) {
                abort(403, 'Unauthorized action.');
            }

            // 1️⃣ Validation
            $validated = $request->validate([
                'domainName'     => ['required', 'string', 'max:255', 'regex:/^(?!\-)(?:[a-zA-Z0-9\-]{0,62}[a-zA-Z0-9]\.)+[a-zA-Z]{2,6}$/'],
                'expirationDate' => 'required|date',
                'domainBuyer'    => 'required|string|max:255',
                'typeDomain'     => 'required|string|in:Domain,SSL',
                'client_email'   => 'nullable|string', // Tagify থেকে string আসবে
                'email_status'   => 'required|string|in:false,true',
                'status'         => 'required|string|in:active,inactive',
            ]);

            // 2️⃣ Tagify data JSON এ কনভার্ট করা
            $tagsArray = [];
            if (! empty($validated['client_email'])) {
                $tagsArray = json_decode($validated['client_email'], true);
                if (! is_array($tagsArray)) {
                    $tagsArray = [];
                }
            }

            // 3️⃣ ডাটাবেজে সেভ
            $domain                  = new \App\Models\Domain();
            $domain->domain_name     = $validated['domainName'];
            $domain->expiration_date = $validated['expirationDate'];
            $domain->domain_content  = $validated['domainContent'] ?? null; // Nullable, so default to null if not provided
            $domain->domain_buyer    = $validated['domainBuyer'];
            $domain->type_domain     = $validated['typeDomain'];
            $domain->client_email    = $tagsArray; // JSON আকারে সেভ হবে (model cast)
            $domain->email_status    = $validated['email_status'];
            $domain->status          = $validated['status'];
            $domain->save();

            return redirect()->back()->with('success', 'Domain added successfully!');
        } catch (\Exception $e) {
            // Handle the error
            return redirect()->back()->with('error', 'Failed to add domain: ' . $e->getMessage());
        }
    }

    public function update(Request $request, Domain $domain)
    {

        // dd($domain);
        try {

            // নিরাপত্তা: শুধুমাত্র লগ-ইন ইউজাররা আপডেট করতে পারবে
            if (! auth()->check()) {
                abort(403, 'Unauthorized action.');
            }

            // ভ্যালিডেশন
            $validated = $request->validate([
                'domainName'     => ['required', 'string', 'max:255', 'regex:/^(?!\-)(?:[a-zA-Z0-9\-]{0,62}[a-zA-Z0-9]\.)+[a-zA-Z]{2,}$/'],
                'expirationDate' => 'required|date',
                'domainBuyer'    => 'required|string|max:255',
                'typeDomain'     => 'required|string|in:Domain,SSL',
                'client_email'   => 'nullable|string', // Tagify ডাটা string হিসেবে আসবে
                'email_status'   => 'required|string|in:false,true',
                'status'         => 'required|string|in:active,inactive',
            ]);

            // Tagify থেকে আসা JSON ডাটাকে array-এ রূপান্তর
            $tagsArray = [];
            if (! empty($validated['client_email'])) {
                $decoded = json_decode($validated['client_email'], true);
                if (is_array($decoded)) {
                    $tagsArray = $decoded;
                }
            }

            // ডাটাবেজে আপডেট
            $domain->update([
                'domain_name'     => $validated['domainName'],
                'expiration_date' => $validated['expirationDate'],
                'domain_content'  => $validated['domainContent'] ?? null, // Nullable, so default to null if not provided
                'domain_buyer'    => $validated['domainBuyer'],
                'type_domain'     => $validated['typeDomain'],
                'client_email'    => $tagsArray, // casted as JSON in model
                'email_status'    => $validated['email_status'],
                'status'          => $validated['status'],
            ]);

            return redirect()->route('home')->with('success', 'Domain updated successfully!');
        } catch (\Exception $e) {
            // Handle the error
            return redirect()->back()->with('error', 'Failed to update domain: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Domain $domain)
    {
        $domain->delete();
        return redirect()->back()->with('success', 'Domain deleted successfully!');
    }
}
