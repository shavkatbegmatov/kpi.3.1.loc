<div class="card">
    <form class="row g-0" method="POST" action="/employee/add" enctype="multipart/form-data">
        <div class="card-body">
            <h2 class="mb-4">Добавить сотрудника</h2>

            <?php if (isset($_SESSION['message'])): ?>
                <div class="alert alert-<?php echo htmlspecialchars($_SESSION['message']['type'], ENT_QUOTES, 'UTF-8'); ?>" role="alert">
                    <?php echo htmlspecialchars($_SESSION['message']['text'], ENT_QUOTES, 'UTF-8'); unset($_SESSION['message']); ?>
                </div>
            <?php endif; ?>

            <div id="error-message" class="alert alert-danger d-none" role="alert"></div>

            <div>
                <label for="photo" class="form-label required">Картинка</label>
                <input type="file" class="form-control" id="photo" name="photo">
            </div>
            <div class="mt-3">
                <label for="name" class="form-label required">Название</label>
                <input type="text" class="form-control" id="name" name="name" placeholder="Введите название">
            </div>
            <div class="mt-3">
                <label for="position" class="form-label required">Должность</label>
                <input type="text" class="form-control" id="position" name="position" placeholder="Введите должность">
            </div>
            <div class="mt-3">
                <label for="branch" class="form-label required">Филиал</label>
                <select class="form-select" id="branch" name="branch">
                    <option value="">Выберите филиал</option>
                    <?php foreach ($branches as $branch): ?>
                        <option value="<?php echo $branch['code']; ?>">[<?php echo $branch['code']; ?>] <?php echo $branch['name']; ?> — <?php echo $branch['address']; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="mt-3">
                <label for="phone" class="form-label required">Номер телефона</label>
                <input type="text" class="form-control" id="phone" name="phone_mask" data-mask="+998 (00) 000-00-00" data-mask-visible="true" placeholder="+998 (00) 000-00-00" autocomplete="off" style="font-family: monospace;">
                <input type="hidden" id="phone_hidden" name="phone">
            </div>

            <button type="submit" class="btn btn-primary mt-3">
                Добавить сотрудника
            </button>
        </div>
    </form>
</div>

<script>
    document.querySelector('form').addEventListener('submit', function (event) {
        const photo = document.getElementById('photo');
        const code = document.getElementById('code');
        const name = document.getElementById('name');
        const position = document.getElementById('position');
        const branch = document.getElementById('branch');
        const phone = document.getElementById('phone');
        const phoneHidden = document.getElementById('phone_hidden');
        const errorMessage = document.getElementById('error-message');
        let errorMessages = [];

        if (!photo.value.trim()) {
            errorMessages.push('Пожалуйста, загрузите картинку.');
            photo.classList.add('is-invalid');
            photo.classList.add('is-invalid-lite');
        } else {
            photo.classList.remove('is-invalid');
            photo.classList.remove('is-invalid-lite');
        }

        if (!name.value.trim()) {
            errorMessages.push('Пожалуйста, введите название.');
            name.classList.add('is-invalid');
            name.classList.add('is-invalid-lite');
        } else {
            name.classList.remove('is-invalid');
            name.classList.remove('is-invalid-lite');
        }

        if (!position.value.trim()) {
            errorMessages.push('Пожалуйста, введите адрес.');
            position.classList.add('is-invalid');
            position.classList.add('is-invalid-lite');
        } else {
            position.classList.remove('is-invalid');
            position.classList.remove('is-invalid-lite');
        }

        if (!branch.value.trim()) {
            errorMessages.push('Пожалуйста, выберите филиал.');
            branch.classList.add('is-invalid');
            branch.classList.add('is-invalid-lite');
        } else {
            branch.classList.remove('is-invalid');
            branch.classList.remove('is-invalid-lite');
        }

        if (!phone.value.trim()) {
            errorMessages.push('Пожалуйста, введите номер телефона.');
            phone.classList.add('is-invalid');
            phone.classList.add('is-invalid-lite');
        } else if (!/^\+998 \(\d{2}\) \d{3}-\d{2}-\d{2}$/.test(phone.value.trim())) {
            errorMessages.push('Пожалуйста, полностью заполните маску номера телефона.');
            phone.classList.add('is-invalid');
            phone.classList.add('is-invalid-lite');
        } else {
            phone.classList.remove('is-invalid');
            phone.classList.remove('is-invalid-lite');
            phoneHidden.value = phone.value.replace(/\+998|\s|\(|\)|-/g, '');
        }

        if (errorMessages.length > 0) {
            event.preventDefault();
            errorMessage.classList.remove('d-none');
            
            let errorList = '<ul>';
            errorMessages.forEach(function(message) {
                errorList += '<li>' + message + '</li>';
            });
            errorList += '</ul>';

            errorMessage.innerHTML = errorList;
        } else {
            errorMessage.classList.add('d-none');
        }
    });
</script>
