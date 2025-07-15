<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\Absence;

class AbsenceNotification extends Mailable
{
    use Queueable, SerializesModels;
    private $totalAbsences;

    public function __construct(private Absence $absence)
    {
        $this->totalAbsences = Absence::where('user_id', $absence->user_id)->count();
    }

        public function envelope(): Envelope
    {
        $subject = 'Absence Warning Notification';
        
        if ($this->totalAbsences === 15) {
            $subject = 'SEVERE WARNING: 5-Day Exclusion - Multiple Absences';
        } elseif ($this->totalAbsences === 10) {
            $subject = 'WARNING: 2-Day Exclusion - Multiple Absences';
        } elseif ($this->totalAbsences === 5) {
            $subject = 'NOTICE: Oral Warning - Accumulated Absences';
        }
    
        return new Envelope(subject: $subject);
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.absence-notification',
            with: [
                'absence' => $this->absence,
                'totalAbsences' => $this->totalAbsences,
            ]
        );
    }
}