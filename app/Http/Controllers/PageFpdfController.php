<?php

namespace App\Http\Controllers;

use Response;
use Illuminate\Support\Facades\Log;

/**
 * pdf转图片
 * @author jason <numberjason@gmail.com>
 */
class PageFpdfController extends Controller
{
    /**
     * [pdfToImg pdf转图片]
     */
    public function pdfToImg()
    {
        return view('pdf/pdf-index');
    }
}
