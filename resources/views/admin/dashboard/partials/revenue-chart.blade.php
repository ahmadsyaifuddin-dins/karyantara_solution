<div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 gap-4">
        <div>
            <h3 class="font-extrabold text-[#1E293B] text-lg flex items-center">
                <i class="fa-solid fa-chart-line text-amber-500 mr-2"></i>
                Tren Omzet Global <span id="chartTitleYear" class="ml-1">({{ $chartYear }})</span>
            </h3>
            <p class="text-xs text-gray-500 mt-1">Metrik fluktuasi pendapatan perusahaan layaknya saham.</p>
        </div>

        <div class="inline-flex bg-gray-100 rounded-lg p-1">
            <button id="btnTabBulanan"
                class="px-4 py-1.5 text-xs font-bold rounded-md transition-all duration-200 bg-white shadow-sm text-[#1E293B]">
                Bulanan
            </button>
            <button id="btnTabTahunan"
                class="px-4 py-1.5 text-xs font-bold rounded-md transition-all duration-200 text-gray-500 hover:text-[#1E293B]">
                Tahunan
            </button>
        </div>
    </div>

    <div class="relative w-full h-[300px]">
        <canvas id="revenueCanvas"></canvas>
    </div>
</div>

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // 1. Ambil Data dari Laravel Controller (Aman dari Proxy)
            const currentChartYear = "{{ $chartYear }}";

            const monthlyData = {!! json_encode($chartData ?? [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0]) !!};
            const monthlyLabels = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov',
                'Des'
            ];

            const yearlyData = {!! json_encode($yearlyData['values'] ?? [0, 0, 0, 0, 0]) !!};
            const yearlyLabels = {!! json_encode($yearlyData['labels'] ?? ['', '', '', '', '']) !!};

            // 2. Ambil Elemen DOM
            const ctx = document.getElementById('revenueCanvas').getContext('2d');
            const btnBulanan = document.getElementById('btnTabBulanan');
            const btnTahunan = document.getElementById('btnTabTahunan');
            const chartTitleYear = document.getElementById('chartTitleYear');

            // 3. Efek Gradien Emas
            let gradientFill = ctx.createLinearGradient(0, 0, 0, 300);
            gradientFill.addColorStop(0, 'rgba(245, 158, 11, 0.4)');
            gradientFill.addColorStop(1, 'rgba(245, 158, 11, 0.0)');

            // 4. Inisialisasi Chart (Vanilla, Murni)
            let revenueChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: monthlyLabels,
                    datasets: [{
                        label: 'Omzet Global (Rp)',
                        data: monthlyData,
                        borderColor: '#1E293B',
                        borderWidth: 3,
                        backgroundColor: gradientFill,
                        fill: true,
                        pointBackgroundColor: '#f59e0b',
                        pointBorderColor: '#ffffff',
                        pointBorderWidth: 2,
                        pointRadius: 4,
                        pointHoverRadius: 7,
                        tension: 0.4
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    interaction: {
                        intersect: false,
                        mode: 'index'
                    },
                    plugins: {
                        legend: {
                            display: false
                        },
                        tooltip: {
                            backgroundColor: '#1E293B',
                            titleFont: {
                                size: 13,
                                family: 'Figtree'
                            },
                            bodyFont: {
                                size: 14,
                                weight: 'bold',
                                family: 'Figtree'
                            },
                            padding: 12,
                            displayColors: false,
                            callbacks: {
                                label: function(context) {
                                    return 'Rp ' + new Intl.NumberFormat('id-ID').format(context.parsed
                                        .y);
                                }
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            border: {
                                display: false
                            },
                            grid: {
                                color: '#f1f5f9',
                                drawTicks: false
                            },
                            ticks: {
                                color: '#94a3b8',
                                font: {
                                    family: 'Figtree',
                                    size: 11
                                },
                                callback: function(value) {
                                    if (value >= 1000000) return (value / 1000000) + ' Jt';
                                    if (value >= 1000) return (value / 1000) + ' Rb';
                                    return value;
                                }
                            }
                        },
                        x: {
                            border: {
                                display: false
                            },
                            grid: {
                                display: false
                            },
                            ticks: {
                                color: '#94a3b8',
                                font: {
                                    family: 'Figtree',
                                    size: 12
                                }
                            }
                        }
                    }
                }
            });

            // 5. Logic Tab Switcher (DOM Manipulation)
            function toggleActiveStyles(activeBtn, inactiveBtn, titleText) {
                // Aktifkan style tombol yang di-klik
                activeBtn.classList.add('bg-white', 'shadow-sm', 'text-[#1E293B]');
                activeBtn.classList.remove('text-gray-500', 'hover:text-[#1E293B]');

                // Matikan style tombol lainnya
                inactiveBtn.classList.remove('bg-white', 'shadow-sm', 'text-[#1E293B]');
                inactiveBtn.classList.add('text-gray-500', 'hover:text-[#1E293B]');

                // Ubah teks judul
                chartTitleYear.innerText = titleText;
            }

            // Event Listener Tombol Bulanan
            btnBulanan.addEventListener('click', function() {
                toggleActiveStyles(btnBulanan, btnTahunan, `(${currentChartYear})`);

                revenueChart.data.labels = monthlyLabels;
                revenueChart.data.datasets[0].data = monthlyData;
                revenueChart.update();
            });

            // Event Listener Tombol Tahunan
            btnTahunan.addEventListener('click', function() {
                toggleActiveStyles(btnTahunan, btnBulanan, '(5 Tahun Terakhir)');

                revenueChart.data.labels = yearlyLabels;
                revenueChart.data.datasets[0].data = yearlyData;
                revenueChart.update();
            });
        });
    </script>
@endpush
