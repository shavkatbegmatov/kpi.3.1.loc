<div class="card mb-4">
    <div class="card-header">
        <h3 class="card-title">Средняя оценка по месяцам</h3>
    </div>
    <div class="card-body border-bottom py-3">
        <div class="form-group">
            <label class="form-label" for="year">Выберите год:</label>
            <select name="year" class="form-select mb-2" id="year">
                <?php for ($yearOption = date('Y'); $yearOption >= 2000; $yearOption--): ?>
                    <option value="<?php echo $yearOption; ?>" <?php echo ($yearOption == $year) ? 'selected' : ''; ?>><?php echo $yearOption; ?></option>
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
                    <a href="/report/annual/export/<?php echo $year; ?>" class="btn btn-green">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-download">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                            <path d="M4 17v2a2 2 0 0 0 2 2h12a2 2 0 0 0 2 -2v-2" />
                            <path d="M7 11l5 5l5 -5" />
                            <path d="M12 4l0 12" />
                        </svg>
                        Экспортировать в Excel
                    </a>
                </div>
            </div>
        </div>
        <div class="table-responsive">
            <table class="table card-table table-vcenter text-nowrap datatable">
                <thead>
                    <tr>
                        <th>Месяц</th>
                        <th>Средняя оценка по всем филиалам</th>
                        <th>Количество оценок</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Январь <?php echo $year; ?></td>
                        <td><?php echo $averageRate['january']; ?></td>
                        <td><?php echo $ratingsCount['january_count']; ?></td>
                    </tr>
                    <tr>
                        <td>Февраль <?php echo $year; ?></td>
                        <td><?php echo $averageRate['february']; ?></td>
                        <td><?php echo $ratingsCount['february_count']; ?></td>
                    </tr>
                    <tr>
                        <td>Март <?php echo $year; ?></td>
                        <td><?php echo $averageRate['march']; ?></td>
                        <td><?php echo $ratingsCount['march_count']; ?></td>
                    </tr>
                    <tr>
                        <td>Апрель <?php echo $year; ?></td>
                        <td><?php echo $averageRate['april']; ?></td>
                        <td><?php echo $ratingsCount['april_count']; ?></td>
                    </tr>
                    <tr>
                        <td>Май <?php echo $year; ?></td>
                        <td><?php echo $averageRate['may']; ?></td>
                        <td><?php echo $ratingsCount['may_count']; ?></td>
                    </tr>
                    <tr>
                        <td>Июнь <?php echo $year; ?></td>
                        <td><?php echo $averageRate['june']; ?></td>
                        <td><?php echo $ratingsCount['june_count']; ?></td>
                    </tr>
                    <tr>
                        <td>Июль <?php echo $year; ?></td>
                        <td><?php echo $averageRate['july']; ?></td>
                        <td><?php echo $ratingsCount['july_count']; ?></td>
                    </tr>
                    <tr>
                        <td>Август <?php echo $year; ?></td>
                        <td><?php echo $averageRate['august']; ?></td>
                        <td><?php echo $ratingsCount['august_count']; ?></td>
                    </tr>
                    <tr>
                        <td>Сентябрь <?php echo $year; ?></td>
                        <td><?php echo $averageRate['september']; ?></td>
                        <td><?php echo $ratingsCount['september_count']; ?></td>
                    </tr>
                    <tr>
                        <td>Октябрь <?php echo $year; ?></td>
                        <td><?php echo $averageRate['october']; ?></td>
                        <td><?php echo $ratingsCount['october_count']; ?></td>
                    </tr>
                    <tr>
                        <td>Ноябрь <?php echo $year; ?></td>
                        <td><?php echo $averageRate['november']; ?></td>
                        <td><?php echo $ratingsCount['november_count']; ?></td>
                    </tr>
                    <tr>
                        <td>Декабрь <?php echo $year; ?></td>
                        <td><?php echo $averageRate['december']; ?></td>
                        <td><?php echo $ratingsCount['december_count']; ?></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>


    <script>
        document.addEventListener("DOMContentLoaded", function() {
            window.ApexCharts && (new ApexCharts(document.getElementById('chart'), {
                chart: {
                    type: "area",
                    fontFamily: 'Segoe UI',
                    height: 500,
                    parentHeightOffset: 0,
                    toolbar: {
                        show: false,
                    },
                    animations: {
                        enabled: true
                    },
                },
                fill: {
                    opacity: 1,
                },
                stroke: {
                    width: 3,
                    lineCap: "round",
                    curve: "smooth",
                },
                series: [{
                    name: "Средняя оценка по всем филиалам",
                    data: [<?php echo $averageRate['january']; ?>, <?php echo $averageRate['february']; ?>, <?php echo $averageRate['march']; ?>, <?php echo $averageRate['april']; ?>,<?php echo $averageRate['may']; ?>, <?php echo $averageRate['june']; ?>,<?php echo $averageRate['july']; ?>, <?php echo $averageRate['august']; ?>,<?php echo $averageRate['september']; ?>, <?php echo $averageRate['october']; ?>,<?php echo $averageRate['november']; ?>,<?php echo $averageRate['december']; ?>]
                }],
                tooltip: {
                    theme: 'dark'
                },
                grid: {
                    padding: {
                    top: -20,
                    right: 0,
                    left: -4,
                    bottom: -4
                    },
                    strokeDashArray: 4,
                },
                xaxis: {
                    labels: {
                        padding: 0,
                    },
                    tooltip: {
                        enabled: false
                    }
                },
                yaxis: {
                    labels: {
                        padding: 4
                    },
                },
                labels: [
                    "Январь", "Февраль", "Март", "Апрель", "Май", "Июнь", "Июль", "Август", "Сентябрь", "Октябрь", "Ноябрь", "Декабрь"
                ],
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
        window.location.href = '/report/annual/' + this.value;
    });
</script>