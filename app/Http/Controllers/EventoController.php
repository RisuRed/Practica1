<?php

namespace App\Http\Controllers;

use App\Models\Evento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use App\Enums\Type_event;
use App\Enums\Yes_No;
use App\Http\Requests\EventReques;
use Illuminate\Validation\Rules\Enum;
use App\Helpers\FilesHelper;
use Illuminate\Support\Facades\Log;

class EventoController extends Controller
{
    /*
    *
    *
    */
    public function store(EventReques $request)
    {
        Log::channel('evento')->info("Entro a la creacion de eventos");
        $data = $request->validated();
        $helper = new FilesHelper();
        $thumbnails=$helper->filePath_to_json($data['thumbnail']);
        $files=$helper->filePath_to_json($data['files']);
        $jsonThumbnails = json_encode($thumbnails);
        $jsonFiles= json_encode($files);

        $data['thumbnail']= $jsonThumbnails;
        $data['files']= $jsonFiles;   
        Log::channel('evento')->info("Datos recibidos", $data);
        try {
            //$events->save();
            Log::channel('evento')->info("Creando evento");
            $event = Evento::create($data);
        } catch (\Exception $e) {
            Log::channel('evento')->error("Fallo al crear evento: " . $e->getMessage());
            return response()->json(["Message" => "Error creating event: " . $e->getMessage()], 500);
        }
        Log::channel('evento')->info("Evento creado: ". $event);
        return response()->json(["Message" => "event created successfully"], 200);
    }

    /*
    *
    *
    */
    public function show($id)
    {
        Log::channel('evento')->info("Entro a show");
        $event = Evento::find($id);
        Log::channel('evento')->info("Encontro el evento");
        if (is_null($event)) {
            Log::channel('evento')->error("Error: Evento no se encontro");
            return response()->json(["Message" => "Event Not Found"], 404);
        }
        Log::channel('evento')->notice("Evento encontrado");
        return response()->json($event, 200);
    }
    /*
    *
    *
    */
    public function index()
    {
        Log::channel('evento')->info("Entro al index");
        $pagination = Evento::paginate(5);
        Log::channel('evento')->notice("Se mostraron 5 eventos");
        return response()->json($pagination, 200);
    }

    /*
    *
    *
    */
    public function destroy($id)
    {
        Log::channel('evento')->info("Entro a show");
        $event = Evento::find($id);
        Log::channel('evento')->info("Encontro el evento");
        if (is_null($event)) {
            Log::channel('evento')->error("Error: Evento no se encontro");
            return response()->json(["Message" => "Event Not Found"], 400);
        }
        Log::channel('evento')->notice("Se elimino el evento con el Id: ". $id);
        $event->delete($event);
        return response()->json(["Message" => "Event deleted"], 200);
    }

    /*
    *
    *
    */
    public function update(EventReques $request, $id)
    {
        Log::channel('evento')->info("Entro a update");
        $data = $request->validated();
        Log::channel('evento')->info("Datos recibidos", $data);
        $event = Evento::find($id);
        if (is_null($event)) {
            Log::channel('evento')->error("Error: Evento no se encontro");
            return response()->json(["Message" => "Event Not Found"], 400);
        }
        $event ->fill($data);
        $helper = new FilesHelper();
        if($request->hasFile('thumbnail')){ 
            $thumbnail = $helper->filePath_to_json($event['thumbnail']);
            //$merge = array_merge($event['thumbnail'], $thumbnail);
            $jsonThumbnail= json_encode($thumbnail);
            $event['thumbnail']  = $jsonThumbnail;
            Log::channel('evento')->notice("archivos Thumbnails modificados: ". $jsonThumbnail);
        }

        if($request->hasFile('files')){
            //decodeamos
            $files = $helper->filePath_to_json($event['files']);
            //$merge = array_merge($event['thumbnail'], $thumbnail);
            $jsonFiles= json_encode($files);
            $event['files']  = $jsonFiles;
            Log::channel('evento')->notice("archivos modificados: ". $jsonFiles);
        }
        // Guardamos el evento
        $event->save();
        Log::channel('evento')->notice("evento guardado");
        //verificamos que todo este bien
        if (is_null($event)) {
            Log::channel('evento')->error("Error al modificar el evento");
            return response()->json(["Message" => "Somthing wrong with create new event"], 400);
        }
        Log::channel('evento')->info("evento modificado");
        return response()->json(["Message" => "Event updated successfully"], 200);
    }

}
