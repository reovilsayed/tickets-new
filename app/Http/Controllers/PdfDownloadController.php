<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class PdfDownloadController extends Controller
{
    public function download(Request $request, Order $order)
    {
        
        $tickets = $order->tickets;

        if ($request->filled('p')) {
            $tickets = $order->tickets()->where('product_id', $request->p)->get();
        }
        if ($request->filled('t')) {
            $tickets = $order->tickets()->where('ticket', $request->t)->get();
        }
        foreach ($tickets as $ticket) {
            $ticket->qr_code = $this->getQRCodeBase64($ticket->ticket);
        }
        $pdf = Pdf::loadView('ticket_download', compact('tickets'));
        $pdf->setOption('defaultFont','montserrat');
        $pdf->setOption('isHtml5ParserEnabled',true);
        // return $pdf->download();
        return $pdf->stream();
    }

    private function getQRCodeBase64($data)
    {
        $url = "https://api.qrserver.com/v1/create-qr-code/?size=120x120&data=" . urlencode($data) . "&color=ef5927";
        $imageData = file_get_contents($url);
        return 'data:image/png;base64,' . base64_encode($imageData);
    }
}
