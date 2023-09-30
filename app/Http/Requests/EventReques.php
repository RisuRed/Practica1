<?php

namespace App\Http\Requests;

use App\Rules\EmailValidation;
use Illuminate\Foundation\Http\FormRequest;
use App\Enums\Type_event;
use App\Enums\Yes_No;
use Illuminate\Validation\Rules\Enum;

class EventReques extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        $eventoId = $this->route("id");
        $rutes = [];
        if (!isset($eventoId)) {
            $rutes = [
                'name_event' => 'required|string',
                'type_event' => ['required', new Enum(Type_event::class)],
                'group_event' => ['required', new Enum(Yes_No::class)],
                'date_register' => 'required|date',
                'date_start' => 'required|date',
                'date_end' => 'required|date',
                'hour_start' => 'required', 'date_format:H:i',
                'hour_end' => 'required', 'date_format:H:i',
                'register_start_date' => 'required|date',
                'register_end_date' => 'required|date',
                'description_event' => 'required|string|max:140',
                'sede_id' => 'required|integer',
                'aquien_va_dirigido' => 'required|json',
                'director_CT_only' => ['required', new Enum(Yes_No::class)],
                'administrative_area_only' => ['required', new Enum(Yes_No::class)],
                'administrative_area_participants_id' => 'required|integer',
                'workplace_center_participants_id' => 'required|integer',
                'event_host' => 'required|string',
                'email' => 'required', new EmailValidation(),
                'phone_number' => 'required|string',
                'visible_data_host' => ['required', new Enum(Yes_No::class)],
                'asigned_host' => 'required|string',
                'have_event_activity' => ['required', new Enum(Yes_No::class)],
                'notification_enabled' => ['required', new Enum(Yes_No::class)],
                'thumbnail.*' => 'required|image|mimes:png,jpg,jpeg|max:2048',
                'files.*' => 'required|mimes:pdf,docx,xlsx,pptx,txt|max:2048',
            ];
        } else {
            $rutes = [
                'name_event' => 'sometimes|string',
                'type_event' => ['sometimes', new Enum(Type_event::class)],
                'group_event' => ['sometimes', new Enum(Yes_No::class)],
                'date_register' => 'sometimes|date',
                'date_start' => 'sometimes|date',
                'date_end' => 'sometimes|date',
                'hour_start' => 'sometimes', 'date_format:H:i',
                'hour_end' => 'sometimes', 'date_format:H:i',
                'register_start_date' => 'sometimes|date',
                'register_end_date' => 'sometimes|date',
                'description_event' => 'sometimes|string|max:140',
                'sede_id' => 'sometimes|integer',
                'aquien_va_dirigido' => 'sometimes|json',
                'director_CT_only' => ['sometimes', new Enum(Yes_No::class)],
                'administrative_area_only' => ['sometimes', new Enum(Yes_No::class)],
                'administrative_area_participants_id' => 'sometimes|integer',
                'workplace_center_participants_id' => 'sometimes|integer',
                'event_host' => 'sometimes|string',
                'email' => 'sometimes', new EmailValidation(),
                'phone_number' => 'sometimes|string',
                'visible_data_host' => ['sometimes', new Enum(Yes_No::class)],
                'asigned_host' => 'sometimes|string',
                'have_event_activity' => ['sometimes', new Enum(Yes_No::class)],
                'notification_enabled' => ['sometimes', new Enum(Yes_No::class)],
                'thumbnail.*' => 'sometimes|image|mimes:png,jpg,jpeg|max:2048',
                'files.*' => 'sometimes|mimes:pdf,docx,xlsx,pptx,txt|max:2048',
            ];
        }
        return $rutes;
    }
    public function messages()
    {
        return [
            'name_event.required' => 'El campo nombre del evento es obligatorio.',
            'name_event.string' => 'El campo nombre del evento debe ser una cadena de texto.',
            'type_event.required' => 'El campo tipo de evento es obligatorio.',
            'type_event.*' => 'El campo tipo de evento no es válido.',
            'group_event.required' => 'El campo grupo de evento es obligatorio.',
            'group_event.*' => 'El campo grupo de evento no es válido.',
            'date_register.required' => 'El campo fecha de registro es obligatorio.',
            'date_register.date' => 'El campo fecha de registro debe ser una fecha válida.',
            'date_start.required' => 'El campo fecha de inicio es obligatorio.',
            'date_start.date' => 'El campo fecha de inicio debe ser una fecha válida.',
            'date_end.required' => 'El campo fecha de fin es obligatorio.',
            'date_end.date' => 'El campo fecha de fin debe ser una fecha válida.',
            'hour_start.required' => 'El campo hora de inicio es obligatorio.',
            'hour_start.date_format' => 'El campo hora de inicio debe tener el formato HH:mm.',
            'hour_end.required' => 'El campo hora de fin es obligatorio.',
            'hour_end.date_format' => 'El campo hora de fin debe tener el formato HH:mm.',
            'register_start_date.required' => 'El campo fecha de inicio de registro es obligatorio.',
            'register_start_date.date' => 'El campo fecha de inicio de registro debe ser una fecha válida.',
            'register_end_date.required' => 'El campo fecha de fin de registro es obligatorio.',
            'register_end_date.date' => 'El campo fecha de fin de registro debe ser una fecha válida.',
            'description_event.required' => 'El campo descripción del evento es obligatorio.',
            'description_event.string' => 'El campo descripción del evento debe ser una cadena de texto.',
            'description_event.max' => 'El campo descripción del evento no debe exceder los 140 caracteres.',
            'sede_id.required' => 'El campo sede es obligatorio.',
            'sede_id.integer' => 'El campo sede debe ser un número entero.',
            'aquien_va_dirigido.required' => 'El campo a quién va dirigido es obligatorio.',
            'aquien_va_dirigido.json' => 'El campo a quién va dirigido debe ser un JSON válido.',
            'director_CT_only.required' => 'El campo director CT solo es obligatorio.',
            'director_CT_only.*' => 'El campo director CT solo no es válido.',
            'administrative_area_only.required' => 'El campo área administrativa solo es obligatorio.',
            'administrative_area_only.*' => 'El campo área administrativa solo no es válido.',
            'administrative_area_participants_id.required' => 'El campo ID del área administrativa de los participantes es obligatorio.',
            'administrative_area_participants_id.integer' => 'El campo ID del área administrativa de los participantes debe ser un número entero.',
            'workplace_center_participants_id.required' => 'El campo ID del centro de trabajo de los participantes es obligatorio.',
            'workplace_center_participants_id.integer' => 'El campo ID del centro de trabajo de los participantes debe ser un número entero.',
            'event_host.required' => 'El campo anfitrión del evento es obligatorio.',
            'event_host.string' => 'El campo anfitrión del evento debe ser una cadena de texto.',
            'email.required' => 'El campo correo electrónico es obligatorio.',
            'email.*' => 'El campo correo electrónico no es válido.',
            'phone_number.required' => 'El campo número de teléfono es obligatorio.',
            'phone_number.string' => 'El campo número de teléfono debe ser una cadena de texto.',
            'visible_data_host.required' => 'El campo visibilidad de datos del anfitrión es obligatorio.',
            'visible_data_host.*' => 'El campo visibilidad de datos del anfitrión no es válido.',
            'asigned_host.required' => 'El campo anfitrión asignado es obligatorio.',
            'asigned_host.string' => 'El campo anfitrión asignado debe ser una cadena de texto.',
            'have_event_activity.required' => 'El campo actividad del evento es obligatorio.',
            'have_event_activity.*' => 'El campo actividad del evento no es válido.',
            'notification_enabled.required' => 'El campo notificación habilitada es obligatorio.',
            'notification_enabled.*' => 'El campo notificación habilitada no es válido.',
            'thumbnail.required' => 'El campo imagen en miniatura es obligatorio.',
            'thumbnail.image' => 'El campo imagen en miniatura debe ser una imagen.',
            'thumbnail.mimes' => 'El campo imagen en miniatura debe ser una imagen en formato PNG, JPG o JPEG.',
            'thumbnail.max' => 'El campo imagen en miniatura no debe exceder los 2 MB de tamaño.',
            'files.required' => 'El campo archivos es obligatorio.',
            'files.mimes' => 'El campo archivos debe ser un archivo en formato PDF, DOCX, XLSX, PPTX o TXT.',
            'files.max' => 'El campo archivos no debe exceder los 2 MB de tamaño.',
        ];
    }
}
