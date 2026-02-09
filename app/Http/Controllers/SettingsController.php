<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class SettingsController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        return view('settings.index', compact('user'));
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'company_name' => 'nullable|string|max:255',
            'company_website' => 'nullable|url|max:255',
            'logo' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('logo')) {
            // Delete old logo if exists
            if ($user->logo) {
                Storage::disk('public')->delete($user->logo);
            }

            $logoPath = $request->file('logo')->store('logos', 'public');
            $validated['logo'] = $logoPath;
        }

        $user->update($validated);

        return back()->with('success', 'Profile updated successfully.');
    }

    public function updatePassword(Request $request)
    {
        $validated = $request->validate([
            'current_password' => 'required',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = Auth::user();

        if (!Hash::check($validated['current_password'], $user->password)) {
            return back()->withErrors(['current_password' => 'Current password is incorrect.']);
        }

        $user->update([
            'password' => Hash::make($validated['password']),
        ]);

        return back()->with('success', 'Password updated successfully.');
    }

    public function updatePreferences(Request $request)
    {
        $validated = $request->validate([
            'currency' => 'required|string|max:10',
            'theme' => 'required|in:light,dark',
            'language' => 'nullable|in:en,fr',
            'app_name' => 'nullable|string|max:50',
        ]);

        Auth::user()->update($validated);

        return back()->with('success', __('app.preferences_updated'));
    }

    public function updateLanguage(Request $request)
    {
        $validated = $request->validate([
            'language' => 'required|in:en,fr',
        ]);

        Auth::user()->update($validated);

        // Set the locale immediately for this request
        app()->setLocale($validated['language']);

        return back()->with('success', __('app.language_updated'));
    }
}

