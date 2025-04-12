export interface PaginatedData<T> {
    data: T[];
    current_page: number;
    last_page: number;
    per_page: number;
    total: number;
    from: number;
    to: number;
    links: {
        url: string | null;
        label: string;
        active: boolean;
    }[];
}

export interface Ativo {
    codigo: string;
    classe_ativo_uid: string;
    nome: string;
    setor: string;
    created_at: string;
    uid: string;
    classe_nome: string;
}

export interface ClasseAtivo {
    uid: string;
    nome: string;
    descricao: string | null;
    created_at: string;
    updated_at: string;
}

export interface Operacao {
    uid: string;
    ativo_uid: string;
    corretora_uid: string;
    tipo_operacao_uid: string;
    data_operacao: string;
    quantidade: number;
    ativo_codigo: string;
    classe_nome: string;
    corretora_nome: string;
    tipo_operacao_nome: string;
    cotacao_preco: number;
    valor_total: number;
}