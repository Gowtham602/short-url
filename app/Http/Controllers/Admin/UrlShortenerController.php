<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\UrlShortener;
use App\Models\District;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class UrlShortenerController extends Controller
{
    /**
     * URL Shortener page
     */
    public function index()
    {
        $districts = District::where('status', 1)
            ->orderBy('district_name')
            ->get();

        $urls = UrlShortener::where('user_id', Auth::id())
            ->with('district')
            ->latest()
            ->get();

        return view('url-shortener.index', compact(
            'districts',
            'urls'
        ));
    }


    /**
     * Create Short URL
     */
    public function store(Request $request)
    {
        $request->validate([
            'original_url' => [
                'required',
                'url',
                'max:2048',
            ],

            'district_id' => [
                'required',
                'exists:districts,id',
            ],
        ]);


        $district = District::findOrFail(
            $request->district_id
        );

        $districtCode = strtoupper(
            $district->district_shortcode
        );


        /*
        |--------------------------------------------------------------------------
        | Generate short code
        |--------------------------------------------------------------------------
        |
        | Example:
        | AB6CHE
        |
        */

        do {

            $shortCode =
                strtoupper(Str::random(2)) .
                random_int(0, 9) .
                $districtCode;

        } while (
            UrlShortener::where(
                'short_code',
                $shortCode
            )->exists()
        );


        UrlShortener::create([
            'user_id'      => Auth::id(),
            'district_id'  => $district->id,
            'original_url' => $request->original_url,
            'short_code'   => $shortCode,
        ]);


        return redirect()
            ->route('url-shortener.index')
            ->with(
                'success',
                'Short URL created successfully!'
            );
    }


    /**
     * Delete Short URL
     */
    public function destroy(UrlShortener $urlShortener)
    {
        abort_unless(
            $urlShortener->user_id === Auth::id(),
            403
        );

        $urlShortener->delete();

        return redirect()
            ->route('url-shortener.index')
            ->with(
                'success',
                'Short URL deleted successfully!'
            );
    }
}