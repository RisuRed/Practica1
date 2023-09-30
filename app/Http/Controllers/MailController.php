<?php

namespace App\Http\Controllers;

use App\Helpers\PdfHelper;
use App\Mail\MyTestMail;
use App\Models\Evento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class MailController extends Controller
{

    public function pruebaEmail(){   
        Log::channel('mail')->info("Entro a pruebaEmail");
        $mailInfo = [
            'title' => 'Mail de prueba',
            'body' => 'Este es un mail de prueba'
        ];
        Log::channel('mail')->notice("Se agrego la info del correo");

        try {
            //Mail::to('yoezer@gmail.com')->send(new MyTestMail($mailInfo));
        } catch (\Exception $e) {
            //throw $th;
            Log::channel('mail')->error("Error: ". $e);
        }
        
        Log::channel('mail')->info("Se envio el correo");

    }
    public function eventMail($id){
        $event = Evento::find($id);
        if(is_null($event)){
            return response()->json(['message:'=>'Evento no encontrado'],404);
        }
        $mailInfo = [
            'email' => 'wits@correo.com',
            'title' => 'Evento que no te puedes perder',
            'body' => 'Este es un mail de prueba',
            'subject' => 'Envio del evento'
        ];
        //$pdf = PdfHelper::generate($event);
        //$pdf = Pdf::loadView('pdfs.pdf', compact('event'));
        $pdf = Pdf::loadView('pdfs.pdf', ['event' => $event]);
        $mailInfo['pdf'] = $pdf;
         $enviar = Mail::to($mailInfo["email"])->send(new MyTestMail($mailInfo));
         //Log::channel('mail')->info("Se envio el correo: " . $enviar);
         return response()->json(['Message' => 'Todo bien'],200);
    }
}
