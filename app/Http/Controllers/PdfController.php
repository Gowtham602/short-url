<?php

namespace App\Http\Controllers;

use App\Models\TempPage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use App\Models\Image;
use Yajra\DataTables\Facades\DataTables;
use App\Models\District;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
class PdfController extends Controller
{
    /**
     * Upload Page
     */
   public function index()
{
    $images = Image::where('user_id', Auth::id())
            ->latest()
            ->get();
	
	$districts = District::where('status',1)->get();
    //    dd($districts);

    return view('pdf.index',compact('images', 'districts'));
}
  


public function list(Request $request)
{
    if ($request->ajax()) {

        $images = Image::with('district')->latest();

        return DataTables::of($images)
            ->addIndexColumn()

            ->addColumn('district', function ($row) {
                return $row->district->district_name ?? '-';
            })

            
            ->addColumn('short_url', function ($row) {

    $url = route('short.url', $row->short_code);

    return '
        <div class="d-flex align-items-center">
            <a href="'.$url.'" target="_blank" class="p-2 text-dark fw-semibold text-decoration-none">'.$url.'</a>

            <button class="btn btn-sm btn-outline-secondary copy-btn"
                    data-url="'.$url.'"
                    title="Copy URL">
                <i class="fas fa-copy"></i>
            </button>
        </div>
    ';
})

->rawColumns(['short_url'])

            ->rawColumns(['short_url'])

            ->make(true);
    }
}
    public function upload(Request $request)
    {
        $request->validate([
            'pdf' => 'required|mimes:pdf|max:51200',
        ]);

        // Remove old temporary pages
        TempPage::where('session_id', session()->getId())->delete();

        // Upload PDF
        $pdf = $request->file('pdf');

        $fileName = time();

        $pdfPath = $pdf->storeAs(
            'pdfs',
            $fileName . '.pdf'
        );

        $input = storage_path('app/' . $pdfPath);

        // Folder for converted pages
        $outputFolder = storage_path(
            'app/public/temp-pages'
        );

        if (!file_exists($outputFolder)) {
            mkdir($outputFolder, 0777, true);
        }

        // Output pattern
        $output = $outputFolder .
            '/' .
            $fileName .
            'page%03d.png';

        // Ghostscript Command
        if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
    $gs = '"C:\\Program Files\\gs\\gs10.07.0\\bin\\gswin64c.exe"';
} else {
    $gs = '/usr/bin/gs';
}

$command = $gs .
    ' -dNOPAUSE' .
    ' -dBATCH' .
    ' -sDEVICE=png16m' .
    ' -r150' .
    ' -o "' . $output . '"' .
    ' "' . $input . '"';

exec($command . ' 2>&1', $result, $status);

if ($status != 0) {
    return response()->json([
        'success' => false,
        'command' => $command,
        'status' => $status,
        'output' => $result
    ], 500);
}
//         dd([
//     'status' => $status,
//     'files' => glob($outputFolder . '/*'),
// ]);

        if ($status != 0) {

            return response()->json([
                'success' => false,
                'message' => 'Ghostscript conversion failed.'
            ], 500);

        }

        // Read Generated Images
        $pages = glob(
            $outputFolder .
            '/' .
            $fileName .
            'page*.png'
        );

        $images = [];

        foreach ($pages as $index => $page) {

            $relativePath =
                'temp-pages/' .
                basename($page);

            // Save into temp_pages table
           

           $temp = TempPage::create([

    'session_id'=>session()->getId(),

    'image_path'=>$relativePath,

    'sort_order'=>$index+1

]);

$images[] = [

    'id'=>$temp->id,

    'image'=>asset('storage/'.$relativePath),

    'sort_order'=>$temp->sort_order

];

        }

        return response()->json([

            'success' => true,

            'images' => $images

        ]);
    }
    public function addImage(Request $request)
{
    $request->validate([
        'image' => 'required|image|max:10240',
        'position' => 'required|integer|min:1'
    ]);

    $file = $request->file('image');

    $name = time().'_'.uniqid().'.'.$file->getClientOriginalExtension();

    $folder = storage_path('app/public/temp-pages');

    if (!File::exists($folder)) {
        File::makeDirectory($folder, 0777, true);
    }

    $file->move($folder, $name);

    $pages = TempPage::where('session_id', session()->getId())
        ->orderBy('sort_order')
        ->get();

    foreach ($pages as $page) {

        if ($page->sort_order >= $request->position) {

            $page->increment('sort_order');

        }
    }

    $temp = TempPage::create([

        'session_id' => session()->getId(),

        'image_path' => 'temp-pages/'.$name,

        'sort_order' => $request->position

    ]);

    return response()->json([

        'success' => true,

        'page' => $temp,

        'image' => asset('storage/'.$temp->image_path)

    ]);
}
public function deletePage(Request $request)
{
    $page = TempPage::findOrFail($request->id);

    $fullPath = storage_path('app/public/'.$page->image_path);

    if (File::exists($fullPath)) {

        File::delete($fullPath);

    }

    $order = $page->sort_order;

    $page->delete();

    TempPage::where('session_id', session()->getId())

        ->where('sort_order','>',$order)

        ->decrement('sort_order');

    return response()->json([

        'success'=>true

    ]);
}
public function reorder(Request $request)
{
    foreach ($request->pages as $index => $id) {

        TempPage::where('id',$id)

            ->update([

                'sort_order'=>$index+1

            ]);

    }

    return response()->json([

        'success'=>true

    ]);
}
public function pages()
{
    $pages = TempPage::where(

        'session_id',

        session()->getId()

    )

    ->orderBy('sort_order')

    ->get();

    $data = [];

    foreach($pages as $page){

        $data[] = [

            'id'=>$page->id,

            'image'=>asset('storage/'.$page->image_path),

            'sort_order'=>$page->sort_order

        ];

    }

    return response()->json($data);
}

public function generate(Request $request)
{
    $request->validate([
        'mode'        => 'required|in:vertical,horizontal',
        'district_id' => 'required|exists:districts,id',
        // 'image_name'  => 'required|string|max:255'
    ]);

    $district = District::findOrFail($request->district_id);

    $date = now()->format('dMy');

    $prefix = 'POTHYS_' . strtoupper($district->district_shortcode) . '_' . $date;

    $last = Image::where('image_name', 'like', $prefix . '_%')
        ->latest('id')
        ->first();

    $next = 1;

if ($last) {
    preg_match('/_(\d+)$/', $last->image_name, $m);
    $next = isset($m[1]) ? ((int)$m[1] + 1) : 1;
}

$imageName = $prefix . '_' . $next;


        // temp file deleteding to db 
    $pages = TempPage::where('session_id', session()->getId())
        ->orderBy('sort_order')
        ->get();

    if ($pages->isEmpty()) {
        return response()->json([
            'success' => false,
            'message' => 'No pages found.'
        ], 422);
    }

    $manager = new ImageManager(new Driver());

    $images = [];

    foreach ($pages as $page) {

        $path = storage_path('app/public/' . $page->image_path);

        if (File::exists($path)) {
            $images[] = $manager->read($path)->orient();
        }
    }

    if (count($images) == 0) {
        return response()->json([
            'success' => false,
            'message' => 'Images not found.'
        ], 422);
    }

    $spacing = 0;
    $background = '#ffffff';

    if ($request->mode == 'vertical') {

        $targetWidth = max(array_map(fn($img) => $img->width(), $images));

        foreach ($images as $img) {
            $img->scale(width: $targetWidth);
        }

        $totalHeight = array_sum(array_map(fn($img) => $img->height(), $images));

        $canvas = $manager->create($targetWidth, $totalHeight)
                          ->fill($background);

        $y = 0;

        foreach ($images as $img) {
            $canvas->place($img, 'top-left', 0, $y);
            $y += $img->height();
        }

    } else {

        $targetHeight = max(array_map(fn($img) => $img->height(), $images));

        foreach ($images as $img) {
            $img->scale(height: $targetHeight);
        }

        $totalWidth = array_sum(array_map(fn($img) => $img->width(), $images));

        $canvas = $manager->create($totalWidth, $targetHeight)
                          ->fill($background);

        $x = 0;

        foreach ($images as $img) {
            $canvas->place($img, 'top-left', $x, 0);
            $x += $img->width();
        }
    }

    /*
    |--------------------------------------------------------------------------
    | Create Temporary Image
    |--------------------------------------------------------------------------
    */

    $mergedFolder = public_path('merged');

    if (!File::exists($mergedFolder)) {
        File::makeDirectory($mergedFolder, 0777, true);
    }

    $tempFile = time() . '.jpg';

    $canvas->toJpeg(95)->save($mergedFolder . '/' . $tempFile);

    /*
    |--------------------------------------------------------------------------
    | District
    |--------------------------------------------------------------------------
    */

    $district = District::findOrFail($request->district_id);

    /*
    |--------------------------------------------------------------------------
    | Clean Image Name
    |--------------------------------------------------------------------------
    */

    

    /*
    |--------------------------------------------------------------------------
    | Final Storage Folder
    |--------------------------------------------------------------------------
    */

    $imageFolder = public_path('storage/images');

    if (!File::exists($imageFolder)) {
        File::makeDirectory($imageFolder, 0777, true);
    }

    /*
    |--------------------------------------------------------------------------
    | Generate Unique Short Code
    |--------------------------------------------------------------------------
    */

    do {

        $letters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';

        $shortCode =
            $letters[random_int(0,25)] .
            $letters[random_int(0,25)] .
            random_int(0,9) .
            strtoupper($district->district_shortcode);

    } while (
        Image::where('short_code', $shortCode)->exists()
    );

    /*
    |--------------------------------------------------------------------------
    | Final File Name
    |--------------------------------------------------------------------------
    */

    $newFileName = $imageName . '_' . $shortCode . '.jpg';

    File::move(
        $mergedFolder . '/' . $tempFile,
        $imageFolder . '/' . $newFileName
    );

    /*
    |--------------------------------------------------------------------------
    | Save Database
    |--------------------------------------------------------------------------
    */

    // $image = Image::create([
    //     'user_id'      => 1,
    //     'district_id'  => $district->id,
    //     'image_name'   => $imageName,
    //     'file_path'    => 'images/' . $newFileName,
    //     'short_code'   => $shortCode,
    //     'click_count'  => 0
    // ]);

    /*
    |--------------------------------------------------------------------------
    | Delete Temporary Images
    |--------------------------------------------------------------------------
    */

    // foreach ($pages as $page) {

    //     $tempPath = storage_path('app/public/' . $page->image_path);

    //     if (File::exists($tempPath)) {
    //         File::delete($tempPath);
    //     }
    // }

    // TempPage::where('session_id', session()->getId())->delete();

    /*
    |--------------------------------------------------------------------------
    | Response
    |--------------------------------------------------------------------------
    */

    return response()->json([
    'success'      => true,
    'message'      => 'Image Generated Successfully',
    'district_id'  => $district->id,
    'image_name'   => $imageName,
    'file_path'    => 'images/' . $newFileName,
    'image_url'    => asset('storage/images/' . $newFileName),
    'short_code'   => $shortCode,
    'redirect_url' => url('/s/' . $shortCode),
]);
}
// public function saveImage(Request $request)
// {
//     $image = Image::create([
//         'user_id'      => 1,
//         'district_id'  => $request->district_id,
//         'image_name'   => $request->image_name,
//         'file_path'    => $request->file_path,
//         'short_code'   => $request->short_code,
//         'click_count'  => 0
//     ]);

//     return response()->json([
//         'success' => true,
//         'message' => 'Image saved successfully.'
//     ]);
// }

// public function saveImage(Request $request)
// {
//     $request->validate([
//         'district_id' => 'required|exists:districts,id',
     
//         'file_path'   => 'required|string',
//         'short_code'  => 'required|string',
//     ]);

//     $district = District::findOrFail($request->district_id);

// $date = now()->format('dMy');

// $prefix = 'POTHYS_' . strtoupper($district->district_shortcode) . '_' . $date;

// // Find last image saved today for this district
// $lastImage = Image::where('district_id', $district->id)
//     ->whereDate('created_at', today())
//     ->orderByDesc('id')
//     ->first();

// $next = 1;

// if ($lastImage) {

//     if (preg_match('/_(\d+)\.jpeg$/i', $lastImage->image_name, $match)) {
//         $next = (int)$match[1] + 1;
//     }

// }

// $imageName = $prefix . '_' . $next ;

//     // Clean image name
//     // $imageName = $request->image_name;
//     // $imageName = $request->image_name . '.jpeg';

//     // Check duplicate image name in same district
    

//     $pages = TempPage::where('session_id', session()->getId())->get();

//     foreach ($pages as $page) {

//         $tempPath = storage_path('app/public/' . $page->image_path);

//         if (File::exists($tempPath)) {
//             File::delete($tempPath);
//         }
//     }

// TempPage::where('session_id', session()->getId())->delete();
//     $image = Image::create([
//         'user_id'      => Auth::id() ?? 1,
//         'district_id'  => $request->district_id,
//         'image_name'   => $imageName,
//         'file_path'    => $request->file_path,
//         'short_code'   => $request->short_code,
//         'click_count'  => 0,
//     ]);

//     return response()->json([
//         'success' => true,
//         'message' => 'Image saved successfully.',
//         'data'    => $image,
//     ]);
// }

public function saveImage(Request $request)
{
    $request->validate([
        'district_id' => 'required|exists:districts,id',
        'file_path'   => 'required|string',
        'short_code'  => 'required|string',
    ]);

    $district = District::findOrFail($request->district_id);

    // // Example: POTHYS_CHN_02Jul26
    // $date = now()->format('dMy');
    // $prefix = 'POTHYS_' . strtoupper($district->district_shortcode) . '_' . $date;

    // Get last image for same district and same day
    // $lastImage = Image::where('district_id', $district->id)
    //     ->where('image_name', 'LIKE', $prefix . '_%.jpeg')
    //     ->latest('id')
    //     ->first();

   
// Base name
//  $date = now()->format('dMy');
$baseName = 'POTHYS_' . strtoupper($district->district_shortcode) . '_' . now()->format('dMy');

// Find next available number
$suffix = 1;

while (
    Image::where('district_id', $district->id)
        ->where('image_name', $baseName . '_' . $suffix . '.jpeg')
        ->exists()
) {
    $suffix++;
}

// Final image name
$imageName = $baseName . '_' . $suffix . '.jpeg';

    // Delete temporary pages
    $pages = TempPage::where('session_id', session()->getId())->get();

    foreach ($pages as $page) {

        $tempPath = storage_path('app/public/' . $page->image_path);

        if (File::exists($tempPath)) {
            File::delete($tempPath);
        }
    }

    TempPage::where('session_id', session()->getId())->delete();

    // Save image
    $image = Image::create([
        'user_id'      => Auth::id() ?? 1,
        'district_id'  => $district->id,
        'image_name'   => $imageName,
        'file_path'    => $request->file_path,
        'short_code'   => $request->short_code,
        'click_count'  => 0,
    ]);

    return response()->json([
        'success' => true,
        'message' => 'Image saved successfully.',
        'data'    => $image,
    ]);
}
public function redirect($code)
{
    // dd($code,'hi');
    $image = Image::where('short_code', $code)->firstOrFail();

    $image->increment('click_count');

    $file = storage_path($image->file_path);
   

    return redirect(asset('storage/' . $image->file_path));
}
}