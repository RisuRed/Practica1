<?php
namespace App\Helpers;

use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;
class PdfHelper {
    public static function generate($event)
    {
        $pdf = Pdf::loadView('pdfs.pdf', compact('event'));
        Storage::put('public/tmp/evento.pdf', $pdf->output());
        $path = Storage::url('public/tmp/evento.pdf');
        return $path;
    }
}