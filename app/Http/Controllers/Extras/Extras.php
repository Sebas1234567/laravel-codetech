<?php

namespace Code\Http\Controllers\Extras;

use Illuminate\Http\Request;
use Code\Http\Controllers\Controller;

class Extras extends Controller
{
    public function saveFilesTiny(Request $request)
    {
        $accepted_origins = ["http://localhost", "http://192.168.1.1", "http://127.0.0.1:8000"];
        $imageFolder = "tiny-files/";

        if ($request->server('HTTP_ORIGIN')) {
            // same-origin requests won't set an origin. If the origin is set, it must be valid.
            if (in_array($request->server('HTTP_ORIGIN'), $accepted_origins)) {
                header('Access-Control-Allow-Origin: ' . $request->server('HTTP_ORIGIN'));
            } else {
                return response()->json(['error' => 'Origin '.$request->server('HTTP_ORIGIN').' Denied'], 403);
            }
        }

        // Don't attempt to process the upload on an OPTIONS request
        if ($request->isMethod('OPTIONS')) {
            return response()->json(['message' => 'Method not allowed'], 405);
        }

        $file = $request->file('file');

        if ($file->isValid()) {
            // Sanitize input
            if (preg_match("/([^\w\s\d\-_~,;:\[\]\(\).])|([\.]{2,})/", $file->getClientOriginalName())) {
                return response()->json(['error' => 'Invalid file name.'], 400);
            }

            // Verify extension
            $allowedExtensions = ["gif", "jpg", "png", "jpeg"];
            $extension = strtolower($file->getClientOriginalExtension());
            if (!in_array($extension, $allowedExtensions)) {
                return response()->json(['error' => 'Invalid extension.'], 400);
            }

            // Accept upload
            $fileName = $file->getClientOriginalName();
            $file->storeAs($imageFolder, $fileName, 'public');

            // Determine the base URL
            $protocol = $request->secure() ? "https://" : "http://";
            $baseurl = $protocol . $request->server('HTTP_HOST') . rtrim(dirname($request->getRequestUri()), "/") . "/storage/";

            // Respond to the successful upload with JSON.
            // Use a location key to specify the path to the saved image resource.
            // { location : '/your/uploaded/image/file'}
            return response()->json(['location' => $baseurl . $imageFolder . $fileName]);
        } else {
            // Notify that the upload failed
            return response()->json(['error' => 'Server Error'], 500);
        }
    }

    public function saveFiles(Request $request)
    {
        $archivo = $request->file('archivo');
        $carpeta = 'files/'.$archivo->getClientOriginalExtension().'/';
        $archivo->storeAs($carpeta, $archivo->getClientOriginalName(), 'public');
        $nombre = $archivo->getClientOriginalExtension().'/'.$archivo->getClientOriginalName();
        return response()->json(['success' => true,'archivo'=>$nombre])
            ->header('Cache-Control', 'no-store, no-cache, must-revalidate, max-age=0')
            ->header('Expires', 'Mon, 1 Jan 1990 00:00:00 GMT');;
    }
}
