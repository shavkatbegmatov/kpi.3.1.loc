

<div class="row mb-4">
    <div class="col-lg-6">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Данные сотрудника</h3>
            </div>
            <div class="card-body">
                <div class="datagrid">
                    <div class="datagrid-item">
                        <div class="datagrid-title">Код</div>
                        <div class="datagrid-content"><?php echo $employee['code']; ?></div>
                    </div>
                    <div class="datagrid-item">
                        <div class="datagrid-title">Имя</div>
                        <div class="datagrid-content"><?php echo $employee['name']; ?></div>
                    </div>
                    <div class="datagrid-item">
                        <div class="datagrid-title">Номер телефона</div>
                        <div class="datagrid-content">
                            <?php 
                                $phone = preg_replace("/[^0-9]/", "", $employee['phone']);
                                echo "+998 (" . substr($phone, 0, 2) . ") " . substr($phone, 2, 3) . "-" . substr($phone, 5, 2) . "-" . substr($phone, 7, 2);
                            ?>
                        </div>
                    </div>
                    <div class="datagrid-item">
                        <div class="datagrid-title">Должность</div>
                        <div class="datagrid-content"><?php echo $employee['position']; ?></div>
                    </div>
                    <div class="datagrid-item">
                        <div class="datagrid-title">Филиал</div>
                        <div class="datagrid-content"><?php echo $branch['name']; ?></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="card">
            <div class="card-body">
                <h3 class="card-title">Фильтр по дате</h3>
                <form id="dateForm" action="" method="GET" onsubmit="submitDateRange(); return false;">
                    <div class="mb-3">
                        <label for="start_date" class="form-label">Дата от:</label>
                        <input type="date" id="start_date" name="start_date" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="end_date" class="form-label">Дата до:</label>
                        <input type="date" id="end_date" name="end_date" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Фильтровать</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
function submitDateRange() {
    const employeeId = <?php echo json_encode($employee['id']); ?>;
    const startDate = document.getElementById('start_date').value;
    const endDate = document.getElementById('end_date').value;

    if (startDate && endDate) {
        const url = `/employee/rates/${employeeId}/${startDate}/${endDate}`;
        window.location.href = url;
    }
}
</script>

<div class="row mb-4">
    <div class="col-lg-6">
        <div class="card">
            <div class="card-body">
                <h3 class="card-title">Статистика критерии пользователей при оценке сотрудника</h3>
                <?php if (!empty($criterias)): ?>
                    <table class="table table-sm table-borderless">
                        <thead>
                            <tr>
                                <th>Критерия</th>
                                <th class="text-end">Кол-во</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($criterias as $criteria): ?>
                                <tr>
                                    <td>
                                        <div class="progressbg">
                                            <div class="progress progressbg-progress">
                                                <div class="progress-bar <?php echo getCriteriaColor($criteria['index']); ?>" style="width: <?php echo $criteria['count'] / $totalCriteriasCount * 100; ?>%" role="progressbar" aria-valuenow="<?php echo $criteria['count'] / $totalCriteriasCount * 100; ?>" aria-valuemin="0" aria-valuemax="100">
                                                    <span class="visually-hidden"></span>
                                                </div>
                                            </div>
                                            <div class="progressbg-text"><?php echo criteria_index_translate($criteria['index']); ?></div>
                                        </div>
                                    </td>
                                    <td class="w-1 fw-bold text-end"><?php echo $criteria['count']; ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php else: ?>
                    <p>Нет данных</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="card">
            <div class="card-body">
                <h3 class="card-title">Статистика оценок сотрудника</h3>
                <table class="table table-sm table-borderless">
                    <thead>
                        <tr>
                            <th>Оценка</th>
                            <th class="text-end">Кол-во</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($allRates as $rateCount): ?>
                            <tr>
                                <td>
                                    <div class="progressbg">
                                        <div class="progress progressbg-progress">
                                            <div class="progress-bar bg-primary-lt" style="width: <?php echo $rateCount['count'] / $totalRatesCount * 100; ?>%" role="progressbar" aria-valuenow="<?php echo $rateCount['count'] / $totalRatesCount * 100; ?>" aria-valuemin="0" aria-valuemax="100">
                                                <span class="visually-hidden"></span>
                                            </div>
                                        </div>
                                        <div class="progressbg-text">
                                            <span class="badge <?php echo getBadgeColor($rateCount['rate']); ?>" style="color: white;">
                                                <?php echo $rateCount['rate']; ?> балла
                                            </span>
                                        </div>
                                    </div>
                                </td>
                                <td class="w-1 fw-bold text-end"><?php echo $rateCount['count']; ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h3 class="card-title">Таблица оценок сотрудника</h3>
    </div>
    <div class="card-body border-bottom py-3">
        <div class="d-flex">
            <div class="btn-list ms-auto">
                <a href="/employee/rates/export/<?php echo $employee['id']; ?>" class="btn btn-green">
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
                    <th class="w-1">ID</th>
                    <th>Оценка</th>
                    <th>Критерии оценки</th>
                    <th>IP адрес</th>
                    <th>Дата/Время</th>
                </tr>
            </thead>
            <tbody id="rates-table">
                <?php foreach ($rates as $rate): ?>
                    <tr>
                        <td class="text-muted filterable""><?php echo $rate['id']; ?></td>
                        <td class="filterable">
                            <span class="badge <?php echo getBadgeColor($rate['rate']); ?>" style="color: white;"><?php echo $rate['rate']; ?> балла</span>
                        </td>
                        <td style="max-width: 300px; text-wrap: wrap;">
                            <?php
                            
                            $criterias = R::findAll('criterias', 'rate_id = ?', [$rate['id']]);

                            foreach ($criterias as $criteria) {
                                echo '<span class="badge m-1">' . criteria_index_translate($criteria['index']) . '</span>';
                            }

                            ?> 
                        </td>
                        <td class="filterable"><?php echo $rate['ip_address']; ?></td>
                        <td class="filterable"><?php echo $rate['created_at']; ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<div class="modal" id="qr_code_modal" tabindex="-1">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Оценка сотрудника</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center">
                <img id="qr_code_img">
            </div>
            <div class="modal-footer">
                <a class="btn" id="qr_code_link" target="_blank">
                    Перейти к оценке
                </a>
                <a class="btn btn-green" id="qr_code_download" target="_blank">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-download"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M4 17v2a2 2 0 0 0 2 2h12a2 2 0 0 0 2 -2v-2" /><path d="M7 11l5 5l5 -5" /><path d="M12 4l0 12" /></svg>
                    Скачать QR
                </a>
            </div>
        </div>
    </div>
</div>

<script>
    document.getElementById('search-input').addEventListener('input', function() {
        let filter = this.value.toLowerCase();
        let rows = document.querySelectorAll('#employee-table tr');
        
        rows.forEach(function(row) {
            let text = row.textContent.toLowerCase();
            if (text.includes(filter)) {
                row.style.display = '';
                let cells = row.querySelectorAll('td.filterable');
                cells.forEach(function(cell) {
                    cell.innerHTML = cell.textContent.replace(new RegExp(filter, "gi"), match => `<b style="font-weight: 700;">${match}</b>`);
                });
            } else {
                row.style.display = 'none';
            }
        });
    });
</script>
