<!DOCTYPE html>
<html>
<head>
    <title>Absence Notification</title>
    <meta charset="utf-8">
</head>
<body>
    <h2>Absence Notification</h2>
    <p>Dear {{ $absence->user->name }},</p>
    
    <p>An absence has been recorded for you:</p>
    
    <ul>
        <li><strong>Date:</strong> {{ $absence->date }}</li>
        <!-- <li><strong>Session:</strong> {{ $absence->session }}</li>
        <li><strong>Teacher:</strong> {{ $absence->teacher->name }}</li> -->
        @if($absence->penalty)
        <li><strong>Penalty:</strong> {{ $absence->penalty }}</li>
        @endif
    </ul>

    <p><strong>Total absences this year: {{ $totalAbsences }}</strong></p>

    @if($totalAbsences === 15)
        <div style="background-color: #ff0000; color: white; padding: 15px; margin: 15px 0;">
            <strong>SEVERE WARNING:</strong><br>
            You have reached 15 absences. A reprimand with temporary exclusion of 5 days has been issued.
            You must bring your parent to the administration.
        </div>
    @elseif($totalAbsences === 10)
        <div style="background-color: #ff8800; color: white; padding: 15px; margin: 15px 0;">
            <strong>SERIOUS WARNING:</strong><br>
            You have reached 10 absences. A reprimand with temporary exclusion of 2 days has been issued.
        </div>
    @elseif($totalAbsences === 5)
        <div style="background-color: #ffcc00; color: black; padding: 15px; margin: 15px 0;">
            <strong>WARNING:</strong><br>
            You have received an oral warning due to reaching 5 absences.
        </div>
    @endif

    <p>Please submit your justification through the system if needed.</p>
    
    <p>Best regards,<br>
    School Administration</p>
</body>
</html>