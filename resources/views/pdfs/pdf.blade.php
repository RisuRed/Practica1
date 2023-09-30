<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Evento: {{ $event['name_event'] }}</title>
</head>

<body>
    <h1>{{ $event['name_event'] }}</h1>
    <p><strong>Descripción:</strong> {{ $event['description_event'] }}</p>
    <p><strong>Fecha de inicio:</strong> {{ $event['date_start'] }}</p>
    <p><strong>Fecha de fin:</strong> {{ $event['date_end'] }}</p>
    <p><strong>Hora de inicio:</strong> {{ $event['hour_start'] }}</p>
    <p><strong>Hora de fin:</strong> {{ $event['hour_end'] }}</p>
    <p><strong>Tipo de evento:</strong> {{ $event['type_event'] }}</p>
    <p><strong>Host:</strong> {{ $event['event_host'] }}</p>
    <p><strong>Correo electrónico:</strong> {{ $event['email'] }}</p>
    <p><strong>Teléfono:</strong> {{ $event['phone_number'] }}</p>
</body>

</html>