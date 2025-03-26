<div class="row mb-4">
    <div class="col-lg-6">
        <div class="card">
            <div class="card-body">
                <h3 class="card-title">Отчет сотрудника</h3>
                <form id="employeeForm" action="" method="GET" onsubmit="submitChange(); return false;">
                    <div class="mb-3">
                        <label class="form-label" for="branch">Выберите филиал:</label>
                        <select name="branch" class="form-select" id="branch">
                            <option value="">Выберите филиал</option>
                            <?php foreach ($branches as $branch): ?>
                                <option value="<?php echo $branch['code']; ?>" <?php echo ($branch['code'] == $selectedBranchCode) ? 'selected' : ''; ?>>
                                    [<?php echo htmlspecialchars($branch['code']); ?>] <?php echo htmlspecialchars($branch['name']); ?> — <?php echo htmlspecialchars($branch['address']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="employee">Выберите сотрудника:</label>
                        <select name="employee" class="form-select" id="employee">
                            <option value="">Выберите сотрудника</option>
                            <?php foreach ($employees as $employee): ?>
                                <option value="<?php echo $employee['id']; ?>" data-branch-code="<?php echo $employee['branch_code']; ?>" <?php echo ($employee['id'] == $selectedEmployeeId) ? 'selected' : ''; ?>>
                                    <?php echo htmlspecialchars($employee['name']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="start_date" class="form-label">Начало:</label>
                        <input type="date" id="start_date" name="start_date" class="form-control" value="<?php echo $start_date; ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="end_date" class="form-label">Конец:</label>
                        <input type="date" id="end_date" name="end_date" class="form-control" value="<?php echo $end_date; ?>" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Увидеть отчет</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
// Функция для фильтрации сотрудников по выбранному филиалу
document.addEventListener('DOMContentLoaded', function() {
    const branchSelect = document.getElementById('branch');
    const employeeSelect = document.getElementById('employee');

    // Сохраняем все опции сотрудников
    const allEmployeeOptions = Array.from(employeeSelect.options).map(function(option) {
        return {
            value: option.value,
            text: option.text,
            branchCode: option.getAttribute('data-branch-code'),
            selected: option.selected
        };
    });

    function filterEmployees() {
        const selectedBranchCode = branchSelect.value;

        // Очищаем список сотрудников
        employeeSelect.innerHTML = '<option value="">Выберите сотрудника</option>';

        if (!selectedBranchCode) {
            // Если филиал не выбран, не показываем сотрудников
            return;
        }

        // Фильтруем сотрудников по выбранному филиалу
        const filteredOptions = allEmployeeOptions.filter(function(option) {
            return option.branchCode === selectedBranchCode;
        });

        // Если нет сотрудников в выбранном филиале
        if (filteredOptions.length === 0) {
            const noEmployeesOption = document.createElement('option');
            noEmployeesOption.textContent = 'Нет сотрудников';
            noEmployeesOption.disabled = true;
            employeeSelect.appendChild(noEmployeesOption);
            return;
        }

        // Добавляем отфильтрованные опции в список сотрудников
        filteredOptions.forEach(function(optionData) {
            const option = document.createElement('option');
            option.value = optionData.value;
            option.text = optionData.text;
            if (optionData.selected) {
                option.selected = true;
            }
            employeeSelect.appendChild(option);
        });
    }

    // Обработчик события изменения филиала
    branchSelect.addEventListener('change', filterEmployees);

    // Фильтруем сотрудников при загрузке страницы
    filterEmployees();
});

function submitChange() {
    const employeeId = document.getElementById('employee').value;
    const startDate = document.getElementById('start_date').value;
    const endDate = document.getElementById('end_date').value;

    if (employeeId && startDate && endDate) {
        // Формируем URL в требуемом формате
        const url = `/report/employee/${employeeId}/${startDate}/${endDate}`;
        window.location.href = url;
    } else {
        alert('Пожалуйста, выберите сотрудника и укажите даты.');
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