<?php

namespace App\Actions\Operacao;

use App\Imports\OperacoesImport;
use App\Events\ConsolidaCarteiraEvent;
use Illuminate\Http\UploadedFile;
use Maatwebsite\Excel\Facades\Excel;

class ImportarOperacoesAction
{
    /**
     * Importa operações a partir de um arquivo Excel.
     *
     * @param UploadedFile $file O arquivo Excel (.xlsx ou .xls)
     * @param int $userId O ID do usuário
     * @return void
     */
    public function execute(UploadedFile $file, int $userId): void
    {
        Excel::import(new OperacoesImport($userId), $file);

        // Dispara o evento para atualizar a carteira
        event(new ConsolidaCarteiraEvent($userId));
    }
}
