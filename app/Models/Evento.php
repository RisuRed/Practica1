<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;

class Evento extends Model
{
    use HasFactory, HasApiTokens, SoftDeletes, Notifiable;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
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
        'thumbnail',
        'sede_id',
        'files',
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

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'created_at',
        'update_at',
        'deleted_at',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'hour_start' => 'datetime',
        'hour_end' => 'datetime',
    ];
}
