<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Lead;
use App\Models\Task;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RelatorioController extends Controller
{
    public function quantidadeLeadPorStatus()
    {
        $leadsPorStatus = Lead::select('status', DB::raw('count(*) as total'))
            ->groupBy('status')
            ->pluck('total', 'status');
        
        return response()->json([
            'Leads novos' => $leadsPorStatus->get('novo', 0),
            'Leads em negociação' => $leadsPorStatus->get('em negociação', 0),
            'Leads fechados' => $leadsPorStatus->get('fechado', 0),
            'Leads perdidos' => $leadsPorStatus->get('perdido', 0),
        ]);
    }

    public function tarefasPendentes()
    {
        $pendingTasks = Task::where('done', false)->get();
        return $pendingTasks;
    }

    public function tarefasConcluidas()
    {
        $doneTasks = Task::where('done', true)->get();
        return $doneTasks;
    }

    public function contatosLeadsMaisAtivos()
    {
        $leadsMaisAtivos = [];
        $leads = Lead::with('tasks')->get();
        foreach($leads as $lead) {
            if(count($lead->tasks) >= 3) {
                array_push($leadsMaisAtivos, $lead);
            }
        } 
        
        return $leadsMaisAtivos;
    }
}
