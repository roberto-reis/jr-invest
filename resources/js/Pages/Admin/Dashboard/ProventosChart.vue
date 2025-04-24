<script setup lang="ts">
import { ref, onMounted } from 'vue';
import VueApexCharts from 'vue3-apexcharts';

// Dados de exemplo para o gráfico de proventos
const proventosOptions = ref({
    chart: {
        height: 350,
        type: 'bar',
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
    plotOptions: {
        bar: {
            horizontal: false,
            columnWidth: '55%',
            borderRadius: 4,
            dataLabels: {
                position: 'top',
            },
        },
    },
    dataLabels: {
        enabled: true,
        formatter: function (val) {
            return 'R$ ' + new Intl.NumberFormat('pt-BR', { minimumFractionDigits: 2 }).format(val);
        },
        offsetY: -20,
        style: {
            fontSize: '12px',
            colors: ['#304758']
        }
    },
    stroke: {
        show: true,
        width: 2,
        colors: ['transparent']
    },
    colors: ['#10b981'], // Cor verde para o gráfico
    grid: {
        borderColor: '#e7e7e7',
        row: {
            colors: ['transparent', 'transparent'],
            opacity: 0.2
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
            formatter: function (value: any) {
                return 'R$ ' + new Intl.NumberFormat('pt-BR').format(value);
            },
            style: {
                colors: [],
                fontSize: '12px',
                fontFamily: 'inherit',
            },
        },
    }
});

// Dados de exemplo para o gráfico (valores mensais de proventos)
const proventosSeries = ref([
    {
        name: 'Proventos',
        data: [2500, 3200, 2800, 3500, 4000, 3800, 4200, 4500, 4300, 5000, 5200, 5500]
    }
]);

// Função para alternar entre modo claro e escuro no gráfico
const updateChartTheme = (isDark) => {
    proventosOptions.value = {
        ...proventosOptions.value,
        theme: {
            mode: isDark ? 'dark' : 'light'
        },
        tooltip: {
            ...proventosOptions.value.tooltip,
            theme: isDark ? 'dark' : 'light'
        },
        grid: {
            ...proventosOptions.value.grid,
            borderColor: isDark ? '#374151' : '#e7e7e7',
        },
        colors: isDark ? ['#34d399'] : ['#10b981'],
        dataLabels: {
            ...proventosOptions.value.dataLabels,
            style: {
                ...proventosOptions.value.dataLabels.style,
                colors: isDark ? ['#d1d5db'] : ['#304758']
            }
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
    <div class="px-4 pt-4 bg-white rounded-lg shadow dark:bg-gray-800 border border-gray-200 dark:border-gray-700">
        <h2 class="text-xl font-semibold mb-4 text-gray-800 dark:text-gray-200">Proventos</h2>
        <VueApexCharts
            height="350"
            :options="proventosOptions"
            :series="proventosSeries"
        />
    </div>
</template>