<!DOCTYPE html>
<html>
<head>
    <title>Absence Notification</title>
</head>
<body>
    <h2>Absence Notification</h2>
    <p>Dear {{ $absence->user->name }},</p>
    
    <p>An absence has been recorded for you:</p>
    
    <ul>
        <li><strong>Date:</strong> {{ $absence->date }}</li>
        <li><strong>Session:</strong> {{ $absence->session }}</li>
        <li><strong>Teacher:</strong> {{ $absence->teacher->name }}</li>
        @if($absence->penalty)
        <li><strong>Penalty:</strong> {{ $absence->penalty }}</li>
        @endif
    </ul>

    <p>Please submit your justification through the system if needed.</p>
    
    <p>Best regards,<br>
    {{ config('app.name') }}</p>
</body>
</html>