<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ShortUrlController extends Controller
{
    public function redirect($code)
    {
        $searchUrl = "https://po3.in/s/" . $code;
    
        $image = DB::connection('images')
            ->table('upload_image')
            ->where('bit_url', 'LIKE', $searchUrl . '%')
            ->first();
    
        if (!$image) {
            abort(404);
        }
    
        return redirect("https://pothysadv.in/imgupload/images/".$image->image_name);
        
        
        /*$key = $code.'.'.$ext;

        $urls = json_decode(
            file_get_contents('https://pothysadv.in/imgupload/urls.json'),
            true
        );
    
        if (!isset($urls[$key])) {
            abort(404);
        }
    
        return redirect($urls[$key]);*/
    }
}