<?php

namespace App\Console\Commands;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Console\Command;

class NotifyDeadlineTaskOfUsers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'notify-deadline';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Notificar usuário que o prazo de sua tarefa está chegando ao fim.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // $users = User::whereHas('tasks')->get();
        // foreach ($users as $user) {
        //     foreach($user->tasks as $task) {
        //         $deadline = $task->due_at->diff(Carbon::now())->days;
        //         ds($deadline);
        //         $user->notify("Faltam" . $deadline . "dias para o prazo da sua tarefa!");
        //     }
        // }
        ds('kauan bonitinho');
    }
}
