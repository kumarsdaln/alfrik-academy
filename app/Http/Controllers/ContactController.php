<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ContactController extends Controller
{
    public function store(Request $request): RedirectResponse
    {
        $inquiry = $request->validate([
            'name' => ['required', 'string', 'max:120'],
            'email' => ['required', 'email', 'max:255'],
            'topic' => ['required', 'string', 'in:course,team,other'],
            'message' => ['required', 'string', 'min:20', 'max:5000'],
        ]);

        DB::table('contact_inquiries')->insert([
            ...$inquiry,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return back()->with('success', 'Thanks for reaching out. Our team will be in touch soon.');
    }
}
