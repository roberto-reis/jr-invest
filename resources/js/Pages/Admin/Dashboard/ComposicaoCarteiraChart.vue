<script setup lang="ts">
import { ref, onMounted } from 'vue';
import VueApexCharts from 'vue3-apexcharts';

// Dados de exemplo para o gru00e1fico de composiu00e7u00e3o da carteira
const composicaoOptions = ref({
    chart: {
        type: 'donut',
        height: 350,
        fontFamily: 'inherit',
        animations: {
            enabled: true,
            easing: 'easeinout',
            speed: 800,
            animateGradually: {
                enabled: true,
                delay: 150
            },
            dynamicAnimation: {
                enabled: true,
                speed: 350
            }
        },
        toolbar: {
            show: true,
            tools: {
                download: true,
            }
        },
    },
    plotOptions: {
        pie: {
            donut: {
                size: '65%',
                background: 'transparent',
                
                labels: {
                    show: false, // Mostar label total
                    name: {
                        show: true,
                        fontSize: '22px',
                        fontFamily: 'inherit',
                        fontWeight: 600,
                        color: undefined,
                        offsetY: -10,
                    },
                    value: {
                        show: true,
                        fontSize: '16px',
                        fontFamily: 'inherit',
                        fontWeight: 400,
                        color: undefined,
                        offsetY: 16,
                        formatter: function (val) {
                            return 'R$ ' + new Intl.NumberFormat('pt-BR', { minimumFractionDigits: 2 }).format(val);
                        }
                    },
                    total: {
                        show: true,
                        showAlways: true,
                        label: 'TOTAL',
                        fontSize: '14px',
                        fontFamily: 'inherit',
                        fontWeight: 600,
                        color: '#373d3f',
                        formatter: function (w) {
                            const total = w.globals.seriesTotals.reduce((a, b) => a + b, 0);
                            return 'R$ ' + new Intl.NumberFormat('pt-BR', { minimumFractionDigits: 2 }).format(total);
                        }
                    }
                }
            },
        },
    },
    dataLabels: {
        enabled: true,
        formatter: function (val: any) {
            return val.toFixed(2) + '%';
        },
    },
    colors: ['#0ea5e9', '#10b981', '#6366f1', '#8b5cf6', '#f59e0b'],
    labels: ['FIIs', 'AÇÕES', 'FIAGRO', 'FI-INFRA', 'OUTROS'],
    legend: {
        show: true,
        position: 'bottom',
        horizontalAlign: 'center',
        fontSize: '14px',
        fontFamily: 'inherit',
        fontWeight: 400,
        markers: {
            width: 12,
            height: 12,
            strokeWidth: 0,
            radius: 12,
            offsetX: -3,
        },
        itemMargin: {
            horizontal: 10,
            vertical: 5
        },
    },
    tooltip: {
        enabled: true,
        y: {
            formatter: function (value) {
                return 'R$ ' + new Intl.NumberFormat('pt-BR', { minimumFractionDigits: 2 }).format(value);
            }
        },
        theme: 'light',
    },
    theme: {
        mode: 'light'
    },
    responsive: [{
        breakpoint: 480,
        options: {
            chart: {
                height: 300
            },
            legend: {
                position: 'bottom'
            }
        }
    }]
});

// Dados de exemplo para o gru00e1fico (valores por tipo de ativo)
const composicaoSeries = ref([125000, 75000, 30000, 15000, 5250.66]);

// Funu00e7u00e3o para alternar entre modo claro e escuro no gru00e1fico
const updateChartTheme = (isDark) => {
    composicaoOptions.value = {
        ...composicaoOptions.value,
        theme: {
            mode: isDark ? 'dark' : 'light'
        },
        tooltip: {
            ...composicaoOptions.value.tooltip,
            theme: isDark ? 'dark' : 'light'
        },
        plotOptions: {
            ...composicaoOptions.value.plotOptions,
            pie: {
                ...composicaoOptions.value.plotOptions.pie,
                donut: {
                    ...composicaoOptions.value.plotOptions.pie.donut,
                    labels: {
                        ...composicaoOptions.value.plotOptions.pie.donut.labels,
                        total: {
                            ...composicaoOptions.value.plotOptions.pie.donut.labels.total,
                            color: isDark ? '#e5e7eb' : '#373d3f'
                        }
                    }
                }
            }
        },
        legend: {
            ...composicaoOptions.value.legend,
            labels: {
                colors: isDark ? '#e5e7eb' : '#374151'
            }
        }
    };
};

// Detectar o tema atual e atualizar o gru00e1fico
onMounted(() => {
    const isDarkMode = document.documentElement.classList.contains('dark');
    updateChartTheme(isDarkMode);

    // Observar mudanu00e7as no tema
    const observer = new MutationObserver((mutations) => {
        mutations.forEach((mutation) => {
            if (mutation.attributeName === 'class') {
                const isDark = document.documentElement.classList.contains('dark');
                updateChartTheme(isDark);
            }
        });
    });

    observer.observe(document.documentElement, { attributes: true });
});
</script>

<template>
    <div class="p-4 bg-white rounded-lg shadow dark:bg-gray-800 border border-gray-200 dark:border-gray-700">
        <h2 class="text-xl font-semibold mb-4 text-gray-800 dark:text-gray-200">Composição</h2>
        <div class="chart-container">
            <VueApexCharts
                height="350"
                :options="composicaoOptions"
                :series="composicaoSeries"
            />
        </div>
    </div>
</template>