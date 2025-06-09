<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use App\Mail\ContactFormMail;
use App\Mail\ContactAutoReplyMail;

class ContactController extends Controller
{
    public function index()
    {
        return view('cust.contact');
    }

    public function send(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'subject' => 'required|string|max:255',
            'message' => 'required|string|max:5000',
        ], [
            'name.required' => 'Nama wajib diisi',
            'email.required' => 'Email wajib diisi',
            'email.email' => 'Format email tidak valid',
            'subject.required' => 'Subjek wajib diisi',
            'message.required' => 'Pesan wajib diisi',
            'message.max' => 'Pesan maksimal 5000 karakter',
        ]);

        try {
            // Simpan ke database
            $contact = Contact::create($validated);

            // Kirim email ke admin
            Mail::to(config('mail.admin_email', env('MAIL_ADMIN_EMAIL')))
                ->send(new ContactFormMail($contact));

            // Kirim auto-reply ke pengirim
            Mail::to($contact->email)
                ->send(new ContactAutoReplyMail($contact));

            return redirect()->back()->with('success', 'Pesan Anda berhasil terkirim! Kami akan segera menghubungi Anda.');

        } catch (\Exception $e) {
            Log::error('Contact form error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Terjadi kesalahan dalam pengiriman pesan. Silakan coba lagi.');
        }
    }

    // Admin methods
    public function adminIndex()
    {
        $contacts = Contact::latest()->paginate(10);
        return view('admin.contacts.index', compact('contacts'));
    }

    public function show(Contact $contact)
    {
        $contact->markAsRead();
        return view('admin.contacts.show', compact('contact'));
    }

    public function markAsRead(Contact $contact)
    {
        $contact->markAsRead();
        return redirect()->back()->with('success', 'Pesan ditandai sebagai sudah dibaca');
    }

    public function destroy(Contact $contact)
    {
        $contact->delete();
        return redirect()->back()->with('success', 'Pesan berhasil dihapus');
    }
}