<?php

namespace App\Imports;

use App\Models\Ativo;
use App\Models\Corretora;
use App\Models\Operacao;
use App\Models\TipoOperacao;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class OperacoesImport implements ToModel, WithHeadingRow, SkipsEmptyRows
{
    private int $userId;
    private array $tiposOperacao = [];
    private array $corretoras = [];
    private array $ativos = [];

    public function __construct(int $userId)
    {
        $this->userId = $userId;
        $this->carregarCaches();
    }

    /**
     * @param array $row
     *
     * @return Operacao|null
     */
    public function model(array $row)
    {
        $tipoOperacaoNome = trim($row['operacao'] ?? $row['tipo_operacao'] ?? $row['tipo'] ?? $row[0] ?? '');
        $codigoAtivo = trim($row['codigo'] ?? $row[1] ?? '');
        $dataOperacao = $this->parseData($row['data'] ?? $row[2] ?? '');
        $quantidade = abs((int) ($row['quantidade'] ?? $row[3] ?? 0));
        $preco = $this->parseNumero($row['preco'] ?? $row[4] ?? 0);
        $corretoraNome = trim($row['corretora'] ?? $row[5] ?? 'Clear'); // TODO: Ajustar para informar a corretora na importação

        $ativo = $this->buscarAtivo($codigoAtivo);
        $tipoOperacao = $this->buscarTipoOperacao($tipoOperacaoNome == 'C' ? 'compra' : 'venda');
        $corretora = $this->buscarCorretora($corretoraNome);

        if (!$ativo || !$tipoOperacao || !$corretora) {
            return null;
        }

        return new Operacao([
            'user_id' => $this->userId,
            'ativo_uid' => $ativo['uid'],
            'tipo_operacao_uid' => $tipoOperacao['uid'],
            'corretora_uid' => $corretora['uid'],
            'cotacao_preco' => $preco,
            'quantidade' => $quantidade,
            'data_operacao' => $dataOperacao,
        ]);
    }

    /**
     * Carrega os caches de tipos de operação, corretoras e ativos.
     */
    private function carregarCaches(): void
    {
        $this->tiposOperacao = TipoOperacao::all()
            ->keyBy(fn($tipo) => mb_strtolower($tipo->nome))
            ->toArray();

        $this->corretoras = Corretora::all()
            ->keyBy(fn($corretora) => mb_strtolower($corretora->nome))
            ->toArray();

        $this->ativos = Ativo::all()
            ->keyBy(fn($ativo) => mb_strtoupper($ativo->codigo))
            ->toArray();
    }

    /**
     * Busca um ativo pelo código.
     */
    private function buscarAtivo(string $codigo): ?array
    {
        $codigo = mb_strtoupper($codigo);

        return $this->ativos[$codigo] ?? null;
    }

    /**
     * Busca um tipo de operação pelo nome.
     */
    private function buscarTipoOperacao(string $nome): ?array
    {
        $nome = mb_strtolower($nome);

        return $this->tiposOperacao[$nome] ?? null;
    }

    /**
     * Busca uma corretora pelo nome.
     */
    private function buscarCorretora(string $nome): ?array
    {
        $nome = mb_strtolower($nome);

        return $this->corretoras[$nome] ?? null;
    }

    /**
     * Converte um valor para número decimal.
     */
    private function parseNumero($valor): float
    {
        if (is_numeric($valor)) {
            return (float) $valor;
        }

        // Remove espaços, menos e substitui vírgula por ponto
        $valor = str_replace([' ', '.', '-'], ['', '', ''], $valor);
        $valor = str_replace(',', '.', $valor);

        return (float) $valor;
    }

    /**
     * Converte uma data do Excel ou string para formato Y-m-d.
     */
    private function parseData($valor): ?string
    {
        if (empty($valor)) {
            return null;
        }

        // Se for um número (data serial do Excel)
        if (is_numeric($valor)) {
            $timestamp = Date::excelToDateTimeObject($valor);
            return $timestamp->format('Y-m-d');
        }

        // Se for string, tenta parsear diferentes formatos
        $formatos = ['d/m/Y', 'Y-m-d', 'd-m-Y', 'd.m.Y'];

        foreach ($formatos as $formato) {
            $data = \DateTime::createFromFormat($formato, $valor);
            if ($data !== false) {
                return $data->format('Y-m-d');
            }
        }

        return null;
    }
}
