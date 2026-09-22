<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Image;
// use App\Models\ImageClick;
use App\Models\ImageClick;
use App\Models\District;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Jenssegers\Agent\Agent;
use Illuminate\Support\Facades\Log;
use Stevebauman\Location\Facades\Location;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
class ImageController extends Controller
{
    public function index()
    {
        // $images = Image::where('user_id', Auth::id())
        //     ->latest()
        //     ->get();

        $images = Image::withCount([
            'clicks',
            'clicks as today_clicks' => function ($query) {
                $query->whereDate('created_at', Carbon::today());
            }
        ])->latest()->get();

        // for district dropdown
        $districts = District::where('status', 1)

            ->orderBy('district_name')
            ->get();
        //   dd($districts);
        return view('dashboard', compact('images', 'districts'));
    }



    public function getImages(Request $request)
    {
        $query = Image::where('user_id', Auth::id());

        // Search
        if ($request->search['value']) {
            $search = $request->search['value'];
            $query->where('image_name', 'like', "%{$search}%");
        }

        $total = $query->count();

        // Pagination
        $images = $query->latest()
            ->skip($request->start)
            ->take($request->length)
            ->get();

        $data = [];

        foreach ($images as $index => $img) {
            $fullUrl = url('/' . $img->short_code);

            $imageUrl = asset('storage/' . $img->file_path);

            $data[] = [
                $request->start + $index + 1,

                "<a href='{$imageUrl}' target='_blank'>
                {$img->image_name}.jpeg
            </a>",

                "<div class='d-flex gap-2'>
                <a href='{$fullUrl}' target='_blank'>{$fullUrl}</a>
                <button onclick=\"copyLink('{$fullUrl}')\" class='btn btn-sm btn-light'> 
                    
                </button>
            </div>",

                $img->click_count,

                $img->created_at->format('d M Y h:i A')
            ];
        }

        return response()->json([
            "draw" => intval($request->draw),
            "recordsTotal" => $total,
            "recordsFiltered" => $total,
            "data" => $data
        ]);
    }
    public function mobile()
    {
        $imageClicks = ImageClick::join('images', 'image_clicks.image_id', '=', 'images.id')
            ->where('images.user_id', Auth::id())
            ->select(
                'image_clicks.*',
                'images.image_name',
                'images.file_path'
            )
            ->latest()
            ->get();

        return view('mobile', compact('imageClicks'));
    }

    public function store(Request $request)
    {
        // dd("hi");
        $request->validate([
            'image_name' => 'required|max:255',
            'image' => 'required|image|mimes:jpeg,jpg|max:2048'
        ]);

        $cleanName = preg_replace('/[^A-Za-z0-9_\-]/', '_', $request->image_name);
        $fileName = $cleanName . '.jpeg';

        if (Storage::disk('public')->exists('images/' . $fileName)) {
            return back()->with('error', 'File name already exists!');
        }

        $path = $request->file('image')
            ->storeAs('images', $fileName, 'public');

        do {
            $shortCode = Str::random(6);
        } while (Image::where('short_code', $shortCode)->exists());

        Image::create([
            'user_id' => Auth::id(),
            'image_name' => $cleanName,
            'file_path' => $path,
            'short_code' => $shortCode
        ]);

        return back()->with('success', 'Image uploaded successfully!');
    }

//     public function edit($id)
// {
//     dd($id);
//     $image = Image::findOrFail($id);

//     return view('image.edit', compact('image'));
// }
public function edit(Image $image)
{
    return view('image.edit', compact('image'));
}

public function update(Request $request, $id)
{
    dd($request);
    $request->validate([
        'image' => 'required|image|mimes:jpeg,jpg|max:2048',
    ]);

    $image = Image::findOrFail($id);

    // Delete old image
    if (Storage::disk('public')->exists($image->file_path)) {
        Storage::disk('public')->delete($image->file_path);
    }

    // Keep same file name
    $fileName = $image->image_name . '.jpeg';

    $path = $request->file('image')
        ->storeAs('images', $fileName, 'public');

    $image->update([
        'file_path' => $path,
    ]);

    return redirect()->back()->with('success', 'Image updated successfully.');
}
public function destroy($id)
{
    $image = Image::findOrFail($id);

    if (Storage::disk('public')->exists($image->file_path)) {
        Storage::disk('public')->delete($image->file_path);
    }

    $image->delete();

    return redirect()->back()->with('success', 'Image deleted successfully.');
}
    // merge and create short url
    public function redirect_old($code)
{
    /*
    |--------------------------------------------------------------------------
    | 1. Check Image Shortener
    |--------------------------------------------------------------------------
    */
    $image = Image::where('short_code', $code)->first();

    if ($image) {

        $image->increment('click_count');

        $agent = new Agent();

        $device = $agent->isMobile()
            ? 'Mobile'
            : ($agent->isTablet() ? 'Tablet' : 'Desktop');

        $browser = $agent->browser();
        $ip = request()->ip();

        $location = Location::get($ip);
        $country = $location ? $location->countryName : 'Unknown';

        ImageClick::create([
            'image_id'    => $image->id,
            'ip_address'  => $ip,
            'browser'     => $browser,
            'device_type' => $device,
            'country'     => $country,
        ]);

        return redirect(asset('storage/' . $image->file_path));
    }

    /*
    |--------------------------------------------------------------------------
    | 2. Check PDF Shortener
    |--------------------------------------------------------------------------
    */
    $pdf = \App\Models\Pdf::where('short_code', $code)->first();

    if ($pdf) {

        $pdf->increment('click_count');

        return redirect(asset('storage/' . $pdf->file_path));
    }

    /*
    |--------------------------------------------------------------------------
    | 3. Check External upload_image Database
    |--------------------------------------------------------------------------
    */
    $searchUrl = "https://po3.in/" . $code;

    $uploadImage = DB::connection('images')
        ->table('upload_image')
        ->where('bit_url', $searchUrl)
        ->first();

    if ($uploadImage) {

        return redirect("https://pothysadv.in/pothys-imgupload-api/images/" . $uploadImage->image_name);
    }

    abort(404);
}

    public function redirect($code)
    {
        /*
        |--------------------------------------------------------------------------
        | Check Image table first
        |--------------------------------------------------------------------------
        */
        $image = Image::where('short_code', $code)->first();
    
        if ($image) {
    
            // Increase total clicks
            $image->increment('click_count');
    
            $agent = new Agent();
    
            $device = $agent->isMobile()
                ? 'Mobile'
                : ($agent->isTablet() ? 'Tablet' : 'Desktop');
    
            $browser = $agent->browser();
            $ip = request()->ip();
    
            $location = Location::get($ip);
            $country = $location ? $location->countryName : 'Unknown';
    
            ImageClick::create([
                'image_id'    => $image->id,
                'ip_address'  => $ip,
                'browser'     => $browser,
                'device_type' => $device,
                'country'     => $country,
            ]);
    
            return redirect(asset('storage/' . $image->file_path));
        }
    
        /*
        |--------------------------------------------------------------------------
        | Check upload_image table
        |--------------------------------------------------------------------------
        */
    
        $searchUrl = "https://po3.in/" . $code;
    
        $uploadImage = DB::connection('images')
            ->table('upload_image')
            ->where('bit_url', $searchUrl)
            ->first();
    
        if ($uploadImage) {
            return redirect("https://pothysadv.in/pothys-imgupload-api/images/" . $uploadImage->image_name);
        }
    
        abort(404);
    }

    // public function process(Request $request)
    // {
    //     $request->validate([
    //         'images.*' => 'required|image',
    //         'mode' => 'required|in:vertical,horizontal',
    //     ]);

    //     $manager = new ImageManager(new Driver());

    //     $images = [];

    //     foreach ($request->file('images') as $file) {
    //         $images[] = $manager->read($file)->orient();
    //     }

    //     $width = 1080;

    //     foreach ($images as $img) {
    //         $img->scale(width: $width);
    //     }

    //     $totalHeight = array_sum(array_map(fn($img) => $img->height(), $images));

    //     $canvas = $manager->create($width, $totalHeight);

    //     $y = 0;
    //     foreach ($images as $img) {
    //         $canvas->place($img, 'top-left', 0, $y);
    //         $y += $img->height();
    //     }

    //     // SAVE PATH
    //     $path = public_path('storage/images');

    //     if (!file_exists($path)) {
    //         mkdir($path, 0777, true);
    //     }

    //     // TEMP NAME (ONLY TEMP, NOT FINAL NAME)
    //     $fileName = 'temp_' . time() . '.jpg';

    //     $canvas->toJpeg(95)->save($path . '/' . $fileName);

    //     return response()->json([
    //         'image' => asset('storage/images/' . $fileName),
    //         'file_path' => 'images/' . $fileName
    //     ]);
    // }
    //merge and shorl url create and save to db 
// public function saveImage(Request $request)
// {
//     dd($request);
//     $request->validate([
//         'image_name' => 'required',
//         'file_path' => 'required'
//     ]);

    //     $cleanName = preg_replace('/[^A-Za-z0-9_\-]/', '_', $request->image_name);

    //     $path = public_path('storage/');

    //     $oldPath = $path . $request->file_path;
//     $newFileName = $cleanName . '.jpg';
//     $newPath = $path . 'images/' . $newFileName;

    //     //  duplicate check
//     if (file_exists($newPath)) {
//         return response()->json([
//             'status' => 'error',
//             'message' => 'Image name already exists!'
//         ], 422);
//     }

    //     //  rename file
//     rename($oldPath, $newPath);

    //     // generate shortcode
//     do {
//         $shortCode = Str::random(6);
//     } while (Image::where('short_code', $shortCode)->exists());

    //     // save DB
//     Image::create([
//         'user_id' => Auth::id(),
//         'image_name' => $cleanName,
//         'file_path' => 'images/' . $newFileName,
//         'short_code' => $shortCode
//     ]);

    //     return response()->json([
//         'status' => 'success',
//         'message' => 'Image saved successfully!',
//         'short_url' => url('/s/' . $shortCode)
//     ]);
// }

    public function process(Request $request)
{
    ini_set('memory_limit', '512M');
	$request->validate([
        'images.*' => 'required|image',
        'mode'     => 'required|in:vertical,horizontal',
        
    ]);

    $manager = new ImageManager(new Driver());

    $images = [];

    foreach ($request->file('images') as $file) {
        $images[] = $manager->read($file)->orient();
    }

    $mode = $request->mode;
    $spacing = (int) ($request->spacing ?? 0);
    $bgColor = $request->bgcolor ?? '#ffffff';

    if ($mode === 'vertical') {

        $width = (int) ($request->width ?? 1080);

        foreach ($images as $img) {
            $img->scale(width: $width);
        }

        $totalHeight = array_sum(
            array_map(fn($img) => $img->height(), $images)
        ) + ($spacing * (count($images) - 1));

        $canvas = $manager->create($width, $totalHeight);

        $y = 0;

        foreach ($images as $img) {
            $canvas->place($img, 'top-left', 0, $y);
            $y += $img->height() + $spacing;
        }

    } else {

        $height = (int) ($request->height ?? 1080);

        foreach ($images as $img) {
            $img->scale(height: $height);
        }

        $totalWidth = array_sum(
            array_map(fn($img) => $img->width(), $images)
        ) + ($spacing * (count($images) - 1));

        $canvas = $manager->create($totalWidth, $height);

        $x = 0;

        foreach ($images as $img) {
            $canvas->place($img, 'top-left', $x, 0);
            $x += $img->width() + $spacing;
        }
    }

    $savePath = public_path('storage/images');

    if (!file_exists($savePath)) {
        mkdir($savePath, 0777, true);
    }

    $fileName = 'temp_' . time() . '.jpg';

    $canvas->toJpeg(95)->save(
        $savePath . '/' . $fileName
    );

    return response()->json([
        'image' => asset('storage/images/' . $fileName),
        'file_path' => 'images/' . $fileName
    ]);
}

    public function saveImage(Request $request)
{
    $request->validate([
        'image_name'  => 'required|string|max:255',
        'file_path'   => 'required|string',
        'district_id' => 'required|exists:districts,id',
    ]);

    /*
    |--------------------------------------------------------------------------
    | User
    |--------------------------------------------------------------------------
    */

    $userId = Auth::id();


    /*
    |--------------------------------------------------------------------------
    | Clean Image Name
    |--------------------------------------------------------------------------
    */

    $cleanName = preg_replace(
        '/[^A-Za-z0-9_\-]/',
        '_',
        trim($request->image_name)
    );


    /*
    |--------------------------------------------------------------------------
    | District
    |--------------------------------------------------------------------------
    */

    $district = District::findOrFail(
        $request->district_id
    );


    /*
    |--------------------------------------------------------------------------
    | Check Duplicate
    |--------------------------------------------------------------------------
    */

    $query = Image::where(
        'image_name',
        $cleanName
    );

    // Only check user's images when logged in
    if ($userId) {

        $query->where(
            'user_id',
            $userId
        );

    }


    if ($query->exists()) {

        return response()->json([
            'status' => 'error',
            'message' => 'Image name already exists.'
        ], 422);

    }


    /*
    |--------------------------------------------------------------------------
    | Old File
    |--------------------------------------------------------------------------
    */

    $storagePath = public_path('storage');

    $oldPath = $storagePath . '/' .
        ltrim($request->file_path, '/');


    if (!file_exists($oldPath)) {

        return response()->json([
            'status' => 'error',
            'message' => 'Generated image file not found.'
        ], 404);

    }


    /*
    |--------------------------------------------------------------------------
    | Images Folder
    |--------------------------------------------------------------------------
    */

    $imageFolder = $storagePath . '/images';

    if (!file_exists($imageFolder)) {

        mkdir(
            $imageFolder,
            0777,
            true
        );

    }


    /*
    |--------------------------------------------------------------------------
    | Generate Short Code
    |--------------------------------------------------------------------------
    */

    do {

        $letters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';

        $shortCode =
            $letters[random_int(0, 25)] .
            $letters[random_int(0, 25)] .
            random_int(0, 9) .
            strtoupper(
                $district->district_shortcode
            );

    } while (
        Image::where(
            'short_code',
            $shortCode
        )->exists()
    );


    /*
    |--------------------------------------------------------------------------
    | File Name
    |--------------------------------------------------------------------------
    */

    $newFileName =
        $cleanName .
        '_' .
        $shortCode .
        '.jpg';


    $newPath =
        $imageFolder .
        '/' .
        $newFileName;


    /*
    |--------------------------------------------------------------------------
    | Move File
    |--------------------------------------------------------------------------
    */

    if (!rename($oldPath, $newPath)) {

        return response()->json([
            'status' => 'error',
            'message' => 'Unable to save image.'
        ], 500);

    }


    /*
    |--------------------------------------------------------------------------
    | Save Database
    |--------------------------------------------------------------------------
    */

    $image = Image::create([

        // NULL for guest
        'user_id' => $userId,

        'district_id' => $district->id,

        'image_name' => $cleanName,

        'file_path' => 'images/' . $newFileName,

        'short_code' => $shortCode,

        'click_count' => 0,

    ]);


    /*
    |--------------------------------------------------------------------------
    | Response 
    |--------------------------------------------------------------------------
    */

    return response()->json([

        'status' => 'success',

        'message' => $userId
            ? 'Image saved successfully.'
            : 'Image uploaded and short URL created successfully.',

        'image_id' => $image->id,

        'short_code' => $shortCode,

        'short_url' => url($shortCode),

        'image_url' => asset(
            'storage/images/' . $newFileName
        ),

        'guest' => !$userId,

    ]);
}
}
