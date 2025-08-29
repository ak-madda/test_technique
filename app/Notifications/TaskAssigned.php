<?php

namespace App\Notifications;

use App\Models\Task;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class TaskAssigned extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(public Task $task) {}

    public function via($notifiable): array
    {
        return ['mail'];
    }

    public function toMail($notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Nouvelle tâche assignée')
            ->line('Une nouvelle tâche vous a été assignée.')
            ->line('Tâche: ' . $this->task->title)
            ->line('Projet: ' . $this->task->project->name)
            ->action('Voir la tâche', url('/tasks/' . $this->task->id))
            ->line('Merci d\'utiliser notre application!');
    }

    public function toArray($notifiable): array
    {
        return [
            'task_id' => $this->task->id,
            'task_title' => $this->task->title,
            'project_name' => $this->task->project->name,
        ];
    }
}