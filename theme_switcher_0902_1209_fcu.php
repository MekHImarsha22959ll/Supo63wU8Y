<?php
// 代码生成时间: 2025-09-02 12:09:03
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use App\Http\Controllers\Controller;

/**
 * ThemeSwitcherController is responsible for handling theme switching functionality.
 * It allows users to switch between different themes.
 */
class ThemeSwitcherController extends Controller
{
    /**
     * Switch the theme for the current session.
     *
     * @param string $theme
     * @return \Illuminate\Http\RedirectResponse
     */
    public function switchTheme($theme)
    {
        // Check if theme is allowed
        $allowedThemes = ['light', 'dark', 'colorful'];
        if (!in_array($theme, $allowedThemes)) {
            // Return error if theme is not allowed
            return Redirect::back()->withErrors(['error' => 'Theme not allowed.']);
        }

        // Store the theme in session
        Session::put('theme', $theme);

        // Redirect back with success message
        return Redirect::back()->with('success', 'Theme switched successfully.');    }
}
