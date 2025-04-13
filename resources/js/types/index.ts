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
}

export interface Corretora {
    uid: string;
    nome: string;
}

export interface TipoOperacao {
    uid: string;
    nome: string;
    nome_interno: string;
}

export interface Operacao {
    uid: string;
    user_id?: number;
    ativo_uid: string;
    corretora_uid: string;
    tipo_operacao_uid: string;
    data_operacao: string;
    quantidade: number;
    cotacao_preco: number;
    valor_total: number;

    // Additional fields from relationships
    ativo_codigo: string;
    classe_nome: string;
    corretora_nome: string;
    tipo_operacao_nome: string;

    // Optional fields that might be present
    created_at?: string;
    updated_at?: string;
}

export interface Provento {
    uid: string;
    user_id: number;
    ativo_uid: string;
    tipo_provento_uid: string;
    corretora_uid: string;
    data_com: string;
    data_pagamento: string;
    quantidade_ativo: number;
    valor: number;
    yield_on_cost: number;
    ativo_codigo: string;
    tipo_provento_nome: string;
    corretora_nome: string;
    valor_total: number;
}

export interface TipoProvento {
    uid: string;
    nome: string;
    nome_interno: string;
}
