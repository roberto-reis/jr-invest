<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use App\Events\ConsolidaCarteiraEvent;

class ConsolidaCarteiraCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'carteira:consolidar {--user_id= : ID do usuário para consolidar a carteira}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Consolida a carteira de um ou vários usuários';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $userId = $this->option('user_id');

        if (!empty($userId)) {
            $this->consolidarUsuariosEspecificos((int)$userId);
            return;
        }

        if (!$this->confirm('Nenhum ID de usuário fornecido. Deseja consolidar a carteira de todos os usuários?')) {
            $this->error('Operação cancelada.');
            return;
        }

        $this->consolidarTodosUsuarios();

        $this->info('Processamento das carteiras iniciado com sucesso!');
    }

    /**
     * Consolida a carteira de usuários específicos.
     *
     * @param array $userIds
     * @return void
     */
    private function consolidarUsuariosEspecificos(int $userId)
    {
        // Busca usuário possui operações com o ID fornecido
        $user = User::whereHas('operacoes', function ($query) use ($userId) {
            $query->where('user_id', $userId);
        })->find($userId);

        if (!$user) {
            $this->warn("Usuário com ID {$userId} não encontrado ou não possui operações.");
            return;
        }

        $this->newLine();
        $this->info('Eventos de consolidação disparados para os usuário especificado.');
    }

    /**
     * Consolida a carteira de todos os usuários.
     *
     * @return void
     */
    private function consolidarTodosUsuarios()
    {
        $users = User::whereHas('operacoes')->get();

        if ($users->isEmpty()) {
            $this->warn('Nenhum usuário com operações encontrado.');
            return;
        }

        $this->info("Consolidando carteira para {$users->count()} usuários...");

        $this->withProgressBar($users, function ($user) {
            $this->dispararEvento($user->id);
        });

        $this->newLine();
        $this->info('Eventos de consolidação disparados para todos os usuários.');
    }

    /**
     * Dispara o evento de consolidação de carteira.
     *
     * @param int $userId
     * @return void
     */
    private function dispararEvento(int $userId)
    {
        event(new ConsolidaCarteiraEvent($userId));
    }
}
