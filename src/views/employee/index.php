<?php

if (OLD_QR_CODE_URL === true) {
    $url = 'http://kpi.loc/rate/rate.php?code=';
} else {
    $url = 'http://kpi.loc/rate/';
}

?>

<div class="card">
    <div class="card-header">
        <h3 class="card-title">Таблица сотрудников</h3>
    </div>
    <div class="card-body border-bottom py-3">
        <div class="d-flex">
            <div class="text-secondary">
                Поиск:
                <div class="ms-2 d-inline-block">
                    <input type="text" id="search-input" class="form-control form-control" aria-label="Search branches" placeholder="Введите для поиска...">
                </div>
            </div>
            <div class="btn-list ms-auto">
                <a href="/employee/add" class="btn btn-primary">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-plus"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 5l0 14" /><path d="M5 12l14 0" /></svg>
                    Добавить сотрудника
                </a>
                <a href="/employee/export" class="btn btn-green">
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
                    <th>Код</th>
                    <th>Ф.И.О</th>
                    <th>Должность</th>
                    <th>Номер телефона</th>
                    <th>Филиал</th>
                    <th></th>
                </tr>
            </thead>
            <tbody id="employee-table">
                <?php foreach ($employees as $employee): ?>
                    <tr>
                        <td class="text-muted filterable""><?php echo $employee['id']; ?></td>
                        <td class="filterable"><?php echo $employee['code']; ?></td>
                        <td style="max-width: 300px; text-wrap: wrap;">
                            <div class="d-flex py-1 align-items-center">
                                <?php if (file_exists(BASE_URL . '/uploads/employees/' . $employee['photo'])): ?>
                                    <span class="avatar avatar-sm me-3" style="background-image: url('<?php echo '/uploads/employees/' . $employee['photo']; ?>')"></span>
                                <?php else: ?>
                                    <span class="avatar avatar-sm me-3"><?php echo mb_substr($employee['name'], 0, 1); ?></span>
                                <?php endif; ?>
                                <div class="flex-fill">
                                    <div class="font-weight-medium"><?php echo $employee['name']; ?></div>
                                </div>
                            </div>
                        </td>
                        <td class="filterable" style="max-width: 300px; text-wrap: wrap;"><?php echo $employee['position']; ?></td>
                        <td class="filterable">
                            <?php
                                if (!empty($employee['phone'])) {
                                    $phone = preg_replace("/[^0-9]/", "", $employee['phone']);
                                    echo "+998 (" . substr($phone, 0, 2) . ") " . substr($phone, 2, 3) . "-" . substr($phone, 5, 2) . "-" . substr($phone, 7, 2);
                                } else {
                                    echo "—";
                                }
                            ?>
                        </td>
                        <td class="filterable">
                            <?php
                                $branch = R::findOne('branches', 'code = ?', [$employee['branch_code']]);
                            ?>
                            [<?php echo $employee['branch_code']; ?>] <?php echo $branch['name']; ?>
                        </td>
                        <td class="text-end">
                            <div class="btn-list d-flex flex-nowrap">
                                <a class="btn btn-icon btn-outline-yellow" href="/employee/rates/<?php echo $employee['id']; ?>">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                        <path d="M12 17.75l-6.172 3.245l1.179 -6.873l-5 -4.867l6.9 -1l3.086 -6.253l3.086 6.253l6.9 1l-5 4.867l1.179 6.873z" />
                                    </svg>
                                </a>
                                <button class="btn btn-icon" data-bs-toggle="modal" data-bs-target="#qr_code_modal" onclick="showQr('<?php echo $employee['code']; ?>')">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                        <path d="M4 4m0 1a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v4a1 1 0 0 1 -1 1h-4a1 1 0 0 1 -1 -1z" />
                                        <path d="M7 17l0 .01" />
                                        <path d="M14 4m0 1a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v4a1 1 0 0 1 -1 1h-4a1 1 0 0 1 -1 -1z" />
                                        <path d="M7 7l0 .01" />
                                        <path d="M4 14m0 1a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v4a1 1 0 0 1 -1 1h-4a1 1 0 0 1 -1 -1z" />
                                        <path d="M17 7l0 .01" />
                                        <path d="M14 14l3 0" />
                                        <path d="M20 14l0 .01" />
                                        <path d="M14 14l0 3" />
                                        <path d="M14 20l3 0" />
                                        <path d="M17 17l3 0" />
                                        <path d="M20 17l0 3" />
                                    </svg>
                                </button>
                                <a class="btn btn-icon btn-outline-warning" href="/employee/change/<?php echo $employee['id']; ?>">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                        <path d="M4 20h4l10.5 -10.5a2.828 2.828 0 1 0 -4 -4l-10.5 10.5v4" />
                                        <path d="M13.5 6.5l4 4" />
                                    </svg>
                                </a>
                                <a class="btn btn-icon btn-outline-danger" href="/employee/delete/<?php echo $employee['id']; ?>" onclick="return confirm('Вы точно хотите удалить сотрудника <?php echo $employee['name']; ?>?');">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                        <path d="M4 7l16 0" />
                                        <path d="M10 11l0 6" />
                                        <path d="M14 11l0 6" />
                                        <path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12" />
                                        <path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3" />
                                    </svg>
                                </a>
                            </div>
                        </td>
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
    function showQr(code) {
        let img = document.querySelector('#qr_code_img');
        let link = document.querySelector('#qr_code_link');
        let download = document.querySelector('#qr_code_download');
        
        img.src = "https://api.qrserver.com/v1/create-qr-code/?size=400x400&data=<?php echo $url; ?>" + code;

        link.href = "<?php echo $url; ?>" + code;

        download.href = "https://api.qrserver.com/v1/create-qr-code/?size=400x400&data=<?php echo $url; ?>" + code;
    }

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
