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
        const date = new Date(dateStr);

        // Verifica se a data é válida
        if (isNaN(date.getTime())) {
            // Tenta interpretar datas no formato DD/MM/YYYY
            if (dateStr.includes('/')) {
                const parts = dateStr.split('/');
                if (parts.length === 3) {
                    const day = parseInt(parts[0], 10);
                    const month = parseInt(parts[1], 10) - 1; // Mês em JavaScript é base 0
                    const year = parseInt(parts[2], 10);
                    const dateObj = new Date(year, month, day);

                    return includeTime
                        ? dateObj.toLocaleString('pt-BR')
                        : dateObj.toLocaleDateString('pt-BR');
                }
            }
            return dateStr; // Retorna a string original se não conseguir parseá-la
        }

        // Formata a data usando o Intl.DateTimeFormat
        return includeTime
            ? date.toLocaleString('pt-BR')
            : date.toLocaleDateString('pt-BR');
    } catch (error) {
        console.error('Error formatting date:', error);
        return dateStr; // Retorna a string original em caso de erro
    }
}
