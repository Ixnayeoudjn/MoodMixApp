<?php

/*---------------------------------------------------------------------------------------------------------
Program Title: Playlist Management Module

Programmers:    Marzan, Kristina Amor A.
                Millano, Ryan Kris F.
                Narisma, Anaise Nicole M.
                Seño, Lei Hant L.

Where the program fits in the general system designs:
This controller manages user profile actions within the MoodMix application. It provides
endpoints for viewing and updating profile information and deleting the user account.
It bridges form requests and model persistence while ensuring security checks.

Date Written: July 2025
Date Revised: November 2025

Purpose: 
- Display the profile edit form to authenticated users.
- Validate and persist profile updates using a dedicated Form Request.
- Handle account deletion with password confirmation and session invalidation.

Data structures, algorithms, and control:
- User model: primary entity for profile data and authentication fields.
- FormRequest (ProfileUpdateRequest): encapsulates validation rules and authorization.
- Use of typed responses (View, RedirectResponse) for clarity.
- Guard clauses and validation ensure only authorized modifications.
- On email change, reset email verification timestamp to force re-verification.
- Proper session invalidation and CSRF token regeneration after account deletion.

----------------------------------------------------------------------------------------------------------*/

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        // Return a view populated with the current authenticated user's data.
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        // Fill the user model with validated attributes from the ProfileUpdateRequest.
        $request->user()->fill($request->validated());

        // If email changed, clear verification timestamp so user must re-verify.
        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        // Persist changes to the database.
        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        // Validate the user's current password before deletion for safety.
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        // Log the user out and delete the Eloquent model.
        Auth::logout();

        $user->delete();

        // Invalidate the session and regenerate token to prevent session fixation.
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
