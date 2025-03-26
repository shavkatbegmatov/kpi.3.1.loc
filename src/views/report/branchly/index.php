<div class="card mb-4">
    <div class="card-header">
        <h3 class="card-title">Средняя оценка по филиалам</h3>
    </div>
    <div class="card-body border-bottom py-3">
        <div class="form-group">
            <label class="form-label" for="year">Выберите год:</label>
            <select name="year" class="form-select mb-4" id="year">
                <?php for ($yearOption = date('Y'); $yearOption >= 2000; $yearOption--): ?>
                    <option value="<?php echo $yearOption; ?>" <?php echo ($yearOption == $year) ? 'selected' : ''; ?>><?php echo $yearOption; ?></option>
                <?php endfor; ?>
            </select>
            <label class="form-label" for="month">Выберите месяц:</label>
            <select name="month" class="form-select mb-2" id="month">
                <?php for ($monthOption = 1; $monthOption <= 12; $monthOption++): ?>
                    <option value="<?php echo $monthOption; ?>" <?php echo ($monthOption == $month) ? 'selected' : ''; ?>>
                        <?php echo date('F', mktime(0, 0, 0, $monthOption, 1)); ?>
                    </option>
                <?php endfor; ?>
            </select>
        </div>
    </div>
</div>

<?php if (!$no_data): ?>
    <div class="card mb-4">
        <div class="card-body">
            <div id="chart" class="chart-lg"></div>
        </div>
    </div>

    <div class="card">
        <div class="card-body border-bottom py-3">
            <div class="d-flex">
                <div class="btn-list ms-auto">
                    <a href="/report/branchly/export/<?php echo $month; ?>/<?php echo $year; ?>" class="btn btn-green">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-download"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M4 17v2a2 2 0 0 0 2 2h12a2 2 0 0 0 2 -2v-2" /><path d="M7 11l5 5l5 -5" /><path d="M12 4l0 12" /></svg>
                        Экспортировать в Excel
                    </a>
                </div>
            </div>
        </div>
        <div class="table-responsive">
            <table class="table card-table table-vcenter text-nowrap datatable">
                <thead>
                    <tr>
                        <th>Название филиала</th>
                        <th>Средняя оценка за месяц</th>
                        <th>Количество оценок</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($branchNames as $index => $branchName): ?>
                        <tr>
                            <td><?php echo $branchName; ?></td>
                            <td><?php echo number_format($averageRates[$index], 2); ?></td>
                            <td><?php echo number_format($ratingsCounts[$index]); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            window.ApexCharts && (new ApexCharts(document.getElementById('chart'), {
                chart: {
                    type: "bar",
                    fontFamily: 'Segoe UI',
                    height: 500,
                    parentHeightOffset: 0,
                    toolbar: {
                        show: false,
                    },
                    animations: {
                        enabled: true
                    },
                    distributed: true
                },
                fill: {
                    opacity: 1,
                },
                plotOptions: {
                    bar: {
                        horizontal: false,
                        endingShape: 'rounded',
                        columnWidth: '50%',
                    }
                },
                dataLabels: {
                    enabled: false,
                },
                stroke: {
                    show: true,
                    width: 2,
                    colors: ['transparent'],
                },
                series: [{
                    name: "Средняя оценка",
                    data: <?php echo json_encode($averageRates); ?>
                }],
                xaxis: {
                    categories: <?php echo json_encode($branchNames); ?>,
                    labels: {
                        padding: 0,
                    },
                    tooltip: {
                        enabled: false
                    }
                },
                yaxis: {
                    min: 3,
                    max: 5,
                    tickAmount: 4,
                    forceNiceScale: true,
                    labels: {
                        padding: 8,
                    },
                },
                tooltip: {
                    theme: 'dark',
                    y: {
                        formatter: function(val) {
                            return val.toFixed(2);
                        }
                    }
                },
                grid: {
                    padding: {
                        top: -20,
                        right: 0,
                        left: -4,
                        bottom: -4,
                    },
                    strokeDashArray: 4,
                },
                fill: {
                    opacity: 1,
                },
            })).render();
        });
    </script>
<?php else: ?>
    <div class="card">
        <div class="card-body">
            <p class="text-center">Нет данных</p>
        </div>
    </div>
<?php endif; ?>

<script>
    document.getElementById('year').addEventListener('change', function() {
        window.location.href = '/report/branchly/' + document.getElementById('month').value + '/' + this.value;
    });

    document.getElementById('month').addEventListener('change', function() {
        window.location.href = '/report/branchly/' + this.value + '/' + document.getElementById('year').value;
    });
</script>