<?php

namespace App\Http\Controllers;

use App\Models\ContactInquiry;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ContactController extends Controller
{
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:120',
            ],
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
            ],
            'topic' => [
                'required',
                'string',
                Rule::in(['course', 'team', 'other']),
            ],
            'message' => [
                'required',
                'string',
                'min:20',
                'max:5000',
            ],
        ]);

        $validated['name'] = trim($validated['name']);
        $validated['email'] = mb_strtolower(trim($validated['email']));
        $validated['message'] = trim($validated['message']);

        // Reject values that become empty after trimming.
        if ($validated['name'] === '') {
            return back()
                ->withErrors(['name' => 'Please enter your name.'])
                ->withInput();
        }

        if ($validated['message'] === '') {
            return back()
                ->withErrors(['message' => 'Please enter a message.'])
                ->withInput();
        }

        ContactInquiry::query()->create($validated);

        return back()->with(
            'success',
            'Thanks for reaching out. Our team will be in touch soon.'
        );
    }
}
