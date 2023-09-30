<?php

namespace App\Exports;

use App\Models\Evento;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class EventExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
        public function headings(): array {
     
         // according to users table
         return [
            'id',
            'name_event',
            'type_event',
            'group_event',
            'date_register',
            'date_start',
            'date_end',
            'hour_start',
            'hour_end',
            'register_start_date',
            'register_end_date',
            'description_event',
            'sede_id',
            'aquien_va_dirigido',
            'director_CT_only',
            'administrative_area_only',
            'administrative_area_participants_id',
            'workplace_center_participants_id',
            'event_host',
            'email',
            'phone_number',
            'visible_data_host',
            'asigned_host',
            'have_event_activity',
            'notification_enabled',
     
            ];
     
         }
    public function collection()
    {
        $eventData = DB::table('eventos')->select(
            'id',
            'name_event',
            'type_event',
            'group_event',
            'date_register',
            'date_start',
            'date_end',
            'hour_start',
            'hour_end',
            'register_start_date',
            'register_end_date',
            'description_event',
            'sede_id',
            'aquien_va_dirigido',
            'director_CT_only',
            'administrative_area_only',
            'administrative_area_participants_id',
            'workplace_center_participants_id',
            'event_host',
            'email',
            'phone_number',
            'visible_data_host',
            'asigned_host',
            'have_event_activity',
            'notification_enabled'
        )->get();
        foreach ($eventData as $key => $value) {
            $json = $value->aquien_va_dirigido;
            $json = json_decode($json);
            $jsonToString = '';
            foreach ($json as $key => $value2) {
                $jsonToString .= $value2 . ', ';
            }
            $jsonToString = substr($jsonToString, 0, -2);
            $value->aquien_va_dirigido = $jsonToString;
        }
        return $eventData;
    }
}
