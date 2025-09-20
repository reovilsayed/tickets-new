<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class PdfServeController extends Controller
{
    public function serve(Request $request, $path)
    {
        $filePath = storage_path('app/public/' . $path);
        
        if (!file_exists($filePath)) {
            abort(404, 'PDF file not found');
        }
        
        $fileSize = filesize($filePath);
        $range = $request->header('Range');
        
        if ($range) {
            return $this->serveRangeRequest($filePath, $range, $fileSize);
        }
        
        return response()->file($filePath, [
            'Content-Type' => 'application/pdf',
            'Content-Length' => $fileSize,
            'Accept-Ranges' => 'bytes',
            'Cache-Control' => 'public, max-age=31536000',
            'Access-Control-Allow-Origin' => '*',
            'Access-Control-Allow-Methods' => 'GET, HEAD, OPTIONS',
            'Access-Control-Allow-Headers' => 'Range, Content-Type',
            'Access-Control-Expose-Headers' => 'Content-Length, Content-Range',
        ]);
    }
    
    private function serveRangeRequest($filePath, $range, $fileSize)
    {
        // Parse range header
        $ranges = explode('=', $range);
        if (count($ranges) !== 2 || $ranges[0] !== 'bytes') {
            return response('Invalid range header', 416);
        }
        
        $rangeSet = explode(',', $ranges[1]);
        $rangeStart = intval($rangeSet[0]);
        $rangeEnd = isset($rangeSet[1]) && $rangeSet[1] !== '' ? intval($rangeSet[1]) : $fileSize - 1;
        
        // Validate range
        if ($rangeStart < 0 || $rangeEnd >= $fileSize || $rangeStart > $rangeEnd) {
            return response('Range not satisfiable', 416);
        }
        
        $contentLength = $rangeEnd - $rangeStart + 1;
        
        $file = fopen($filePath, 'rb');
        fseek($file, $rangeStart);
        $content = fread($file, $contentLength);
        fclose($file);
        
        return response($content, 206, [
            'Content-Type' => 'application/pdf',
            'Content-Length' => $contentLength,
            'Content-Range' => "bytes {$rangeStart}-{$rangeEnd}/{$fileSize}",
            'Accept-Ranges' => 'bytes',
            'Cache-Control' => 'public, max-age=31536000',
            'Access-Control-Allow-Origin' => '*',
            'Access-Control-Allow-Methods' => 'GET, HEAD, OPTIONS',
            'Access-Control-Allow-Headers' => 'Range, Content-Type',
            'Access-Control-Expose-Headers' => 'Content-Length, Content-Range',
        ]);
    }
}
