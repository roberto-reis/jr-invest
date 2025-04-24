<script setup lang="ts">
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import { ref, onMounted } from 'vue';
import VueApexCharts from 'vue3-apexcharts';

// Dados de exemplo para o gráfico de evolução patrimonial
const patrimonioOptions = ref({
    chart: {
        height: 350,
        type: 'area',
        toolbar: {
            show: true,
            tools: {
                download: true,
                selection: true,
                zoom: true,
                zoomin: true,
                zoomout: true,
                pan: true,
                reset: true,
            },
            autoSelected: 'zoom'
        },
        zoom: {
            enabled: true
        },
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
        }
    },
    dataLabels: {
        enabled: false
    },
    stroke: {
        curve: 'smooth',
        width: 2,
    },
    colors: ['#4f46e5'], // Cor indigo para o gráfico
    fill: {
        type: 'gradient',
        gradient: {
            shadeIntensity: 1,
            opacityFrom: 0.7,
            opacityTo: 0.2,
            stops: [0, 90, 100],
            colorStops: [
                {
                    offset: 0,
                    color: '#4f46e5',
                    opacity: 0.8
                },
                {
                    offset: 100,
                    color: '#818cf8',
                    opacity: 0.2
                }
            ]
        }
    },
    grid: {
        borderColor: '#e7e7e7',
        row: {
            colors: ['transparent', 'transparent'],
            opacity: 0.2
        },
    },
    xaxis: {
        categories: ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul', 'Ago', 'Set', 'Out', 'Nov', 'Dez'],
        labels: {
            style: {
                colors: [],
                fontSize: '12px',
                fontFamily: 'inherit',
            },
        },
        axisBorder: {
            show: false,
        },
        axisTicks: {
            show: false,
        },
    },
    yaxis: {
        labels: {
            formatter: function (value) {
                return 'R$ ' + new Intl.NumberFormat('pt-BR').format(value);
            },
            style: {
                colors: [],
                fontSize: '12px',
                fontFamily: 'inherit',
            },
        },
    },
    tooltip: {
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
    markers: {
        size: 5,
        colors: ['#4f46e5'],
        strokeColors: '#fff',
        strokeWidth: 2,
        hover: {
            size: 7,
            sizeOffset: 3
        }
    },
});

// Dados de exemplo para o gráfico (valores mensais do patrimônio)
const patrimonioSeries = ref([
    {
        name: 'Patrimônio',
        data: [150000, 175000, 200000, 225000, 240000, 260000, 280000, 300000, 320000, 350000, 380000, 420000, 450000]
    }
]);

// Função para alternar entre modo claro e escuro no gráfico
const updateChartTheme = (isDark) => {
    patrimonioOptions.value = {
        ...patrimonioOptions.value,
        theme: {
            mode: isDark ? 'dark' : 'light'
        },
        tooltip: {
            ...patrimonioOptions.value.tooltip,
            theme: isDark ? 'dark' : 'light'
        },
        grid: {
            ...patrimonioOptions.value.grid,
            borderColor: isDark ? '#374151' : '#e7e7e7',
        },
        colors: isDark ? ['#818cf8'] : ['#4f46e5'],
        fill: {
            ...patrimonioOptions.value.fill,
            gradient: {
                ...patrimonioOptions.value.fill.gradient,
                colorStops: isDark ? [
                    {
                        offset: 0,
                        color: '#818cf8',
                        opacity: 0.8
                    },
                    {
                        offset: 100,
                        color: '#4f46e5',
                        opacity: 0.2
                    }
                ] : [
                    {
                        offset: 0,
                        color: '#4f46e5',
                        opacity: 0.8
                    },
                    {
                        offset: 100,
                        color: '#818cf8',
                        opacity: 0.2
                    }
                ]
            }
        },
        markers: {
            ...patrimonioOptions.value.markers,
            colors: isDark ? ['#818cf8'] : ['#4f46e5'],
        }
    };
};

// Detectar o tema atual e atualizar o gráfico
onMounted(() => {
    const isDarkMode = document.documentElement.classList.contains('dark');
    updateChartTheme(isDarkMode);

    // Observar mudanças no tema
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
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <div>
            <!-- Cards de Rentabilidade -->
            <div class="grid grid-cols-1 gap-4 mb-6 md:grid-cols-3">
                <!-- Card Rentabilidade (Dia) -->
                <div class="p-4 bg-white rounded-lg shadow dark:bg-gray-800 border border-gray-200 dark:border-gray-700">
                    <div class="text-center">
                        <p class="text-lg font-medium text-red-600 dark:text-red-400">-R$ 100.500,00 (-15%)</p>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Rentabilidade (Dia)</p>
                        <div class="text-red-500 mt-1">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 inline-block" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M16.707 10.293a1 1 0 010 1.414l-6 6a1 1 0 01-1.414 0l-6-6a1 1 0 111.414-1.414L9 14.586V3a1 1 0 012 0v11.586l4.293-4.293a1 1 0 011.414 0z" clip-rule="evenodd" transform="rotate(180, 10, 10)" />
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Card Rentabilidade (últimos 30 dias) -->
                <div class="p-4 bg-white rounded-lg shadow dark:bg-gray-800 border border-gray-200 dark:border-gray-700">
                    <div class="text-center">
                        <p class="text-lg font-medium text-green-600 dark:text-green-400">R$ 100.500,00 (15%)</p>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Rentabilidade (últimos 30 dias)</p>
                        <div class="text-green-500 mt-1">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 inline-block" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M16.707 10.293a1 1 0 010 1.414l-6 6a1 1 0 01-1.414 0l-6-6a1 1 0 111.414-1.414L9 14.586V3a1 1 0 012 0v11.586l4.293-4.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Card Rentabilidade (Ano) -->
                <div class="p-4 bg-white rounded-lg shadow dark:bg-gray-800 border border-gray-200 dark:border-gray-700">
                    <div class="text-center">
                        <p class="text-lg font-medium text-green-600 dark:text-green-400">R$ 100.500,00 (15%)</p>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Rentabilidade (Ano)</p>
                        <div class="text-green-500 mt-1">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 inline-block" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M16.707 10.293a1 1 0 010 1.414l-6 6a1 1 0 01-1.414 0l-6-6a1 1 0 111.414-1.414L9 14.586V3a1 1 0 012 0v11.586l4.293-4.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Gráfico de Evolução Patrimonial -->
            <div class="p-6 bg-white rounded-lg shadow dark:bg-gray-800 border border-gray-200 dark:border-gray-700">
                <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-200 mb-4">Evolução Patrimonial</h2>
                <VueApexCharts
                    type="area"
                    height="350"
                    :options="patrimonioOptions"
                    :series="patrimonioSeries"
                />
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<style>
/* Estilos para o componente de patrimônio */
.apexcharts-tooltip {
    box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05) !important;
    border: none !important;
    border-radius: 0.5rem !important;
    padding: 0.5rem !important;
}

.apexcharts-tooltip-title {
    font-weight: 600 !important;
    margin-bottom: 0.5rem !important;
    padding: 0.5rem !important;
}

.dark .apexcharts-tooltip {
    background: rgba(30, 41, 59, 0.95) !important;
    border: 1px solid rgba(55, 65, 81, 0.5) !important;
    color: #e2e8f0 !important;
}

.dark .apexcharts-tooltip-title {
    background: rgba(15, 23, 42, 0.8) !important;
    border-bottom: 1px solid rgba(55, 65, 81, 0.5) !important;
    color: #e2e8f0 !important;
}

/* Melhorias visuais para o gráfico */
.apexcharts-xaxis-label, .apexcharts-yaxis-label {
    fill: #4b5563 !important;
}

.dark .apexcharts-xaxis-label, .dark .apexcharts-yaxis-label {
    fill: #9ca3af !important;
}

.apexcharts-grid-borders line {
    stroke-dasharray: 3;
    stroke-width: 1;
}

/* Animação para o gráfico */
.apexcharts-area {
    transition: all 0.3s ease;
}

/* Ajuste para responsividade */
@media (max-width: 640px) {
    .apexcharts-toolbar {
        scale: 0.8;
        transform-origin: right top;
    }

    .apexcharts-menu {
        min-width: 120px !important;
    }
}
</style>