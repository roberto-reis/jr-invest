/**
 * Formata um valor numérico para o formato monetário brasileiro (R$ X.XXX,XX)
 * @param value Valor numérico ou string representando um número
 * @param currency Símbolo da moeda (padrão: R$)
 * @param decimalPlaces Número de casas decimais (padrão: 2)
 * @returns String formatada no padrão monetário
 */
export function formatCurrency(value: number | string, currency: string = 'R$', decimalPlaces: number = 2): string {
    if (value === null || value === undefined) return '';

    // Converte para número se for string
    const numValue = typeof value === 'string' ? parseFloat(value) : value;

    // Verifica se é um número válido
    if (isNaN(numValue)) return '';

    // Formata o número usando o Intl.NumberFormat
    return `${currency} ${numValue.toLocaleString('pt-BR', {
        minimumFractionDigits: decimalPlaces,
        maximumFractionDigits: decimalPlaces,
    })}`;
}

/**
 * Formata um número para exibir com separador de milhares e decimais no formato brasileiro
 * @param value Valor numérico ou string representando um número
 * @param decimalPlaces Número de casas decimais (padrão: 2)
 * @returns String formatada com separadores
 */
export function formatNumber(value: number | string, decimalPlaces: number = 2): string {
    if (value === null || value === undefined) return '';

    // Converte para número se for string
    const numValue = typeof value === 'string' ? parseFloat(value) : value;

    // Verifica se é um número válido
    if (isNaN(numValue)) return '';

    // Formata o número usando o Intl.NumberFormat
    return numValue.toLocaleString('pt-BR', {
        minimumFractionDigits: decimalPlaces,
        maximumFractionDigits: decimalPlaces,
    });
}

/**
 * Converte uma string formatada em moeda para um número
 * @param value String formatada em moeda (ex: "R$ 1.234,56")
 * @returns Número (ex: 1234.56)
 */
export function parseCurrency(value: string): number {
    if (!value) return 0;

    // Remove o símbolo da moeda e espaços
    const sanitized = value.replace(/[^\d,.-]/g, '')
        // Substitui vírgula por ponto para decimais
        .replace(',', '.');

    return parseFloat(sanitized);
}

/**
 * Formata uma data para o formato brasileiro (DD/MM/YYYY)
 * @param dateStr Data em formato string (pode ser ISO ou outro formato reconhecido pelo Date)
 * @param includeTime Se deve incluir o horário na formatação
 * @returns String formatada no padrão brasileiro
 */
export function formatDate(dateStr: string, includeTime: boolean = false): string {
    if (!dateStr) return '';

    try {
        // Se a data já está no formato DD/MM/YYYY, apenas retorna
        if (dateStr.match(/^\d{2}\/\d{2}\/\d{4}/)) {
            return dateStr;
        }

        // Para datas em formato ISO, vamos tratar com cuidado o problema de timezone
        let date: Date;

        // Verifica se a data já tem 'T' (formato ISO)
        if (dateStr.includes('T')) {
            // Data ISO completa com tempo - usar diretamente
            date = new Date(dateStr);
        } else if (dateStr.includes('-')) {
            // Data em formato YYYY-MM-DD sem tempo
            // Adiciona T00:00:00 para evitar que o JS interprete como UTC e subtrai horas
            const [year, month, day] = dateStr.split('-');
            date = new Date(`${year}-${month}-${day}T00:00:00`);

            // Ajusta a data para o fuso horário local
            date.setMinutes(date.getMinutes() + date.getTimezoneOffset());
        } else {
            // Outro formato, deixa o JS interpretar
            date = new Date(dateStr);
        }

        // Verifica se a data é válida
        if (isNaN(date.getTime())) {
            return dateStr; // Retorna a string original em caso de data inválida
        }

        // Extrai os componentes da data manualmente para evitar problemas de timezone
        const day = date.getDate().toString().padStart(2, '0');
        const month = (date.getMonth() + 1).toString().padStart(2, '0');
        const year = date.getFullYear();

        // Formata no estilo brasileiro
        if (includeTime) {
            const hours = date.getHours().toString().padStart(2, '0');
            const minutes = date.getMinutes().toString().padStart(2, '0');
            const seconds = date.getSeconds().toString().padStart(2, '0');
            return `${day}/${month}/${year} ${hours}:${minutes}:${seconds}`;
        }

        return `${day}/${month}/${year}`;
    } catch (error) {
        console.error('Error formatting date:', error, dateStr);
        return dateStr; // Retorna a string original em caso de erro
    }
}
