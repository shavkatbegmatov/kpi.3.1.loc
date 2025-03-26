<div class="page page-center">
	<div class="container container-tight py-4">
		<form class="card card-md" method="POST" action="/rate/<?php echo $employee['code']; ?>">
			<div class="card-body">
				<?php if (!isset($_SESSION['rated'])): ?>
					<div class="d-flex flex-column align-items-center mb-3">
						<h2 class="card-title h2 text-center">Оцените сотрудника</h2>
						<p class="card-subtitle text-center text-muted"><?php echo $employee['name']; ?></p>
						<?php if (file_exists(BASE_URL . '/uploads/employees/' . $employee['photo'])): ?>
							<span class="avatar avatar-xl" style="background-image: url('<?php echo '/uploads/employees/' . $employee['photo']; ?>')"></span>
						<?php else: ?>
							<span class="avatar avatar-xl"><?php echo mb_substr($employee['name'], 0, 1); ?></span>
						<?php endif; ?>
					</div>
					<div id="rate">
						<label class="form-label">На сколько звезд оцените обслуживание сотрудника?</label>
						<div class="btn-group w-100" role="group">
							<input type="radio" class="btn-check" name="rate" id="rate-1" autocomplete="off" value="1">
							<label for="rate-1" type="button" class="btn btn-outline-red" onclick="rate(1)">1</label>
							<input type="radio" class="btn-check" name="rate" id="rate-2" autocomplete="off" value="2">
							<label for="rate-2" type="button" class="btn btn-outline-orange" onclick="rate(2)">2</label>
							<input type="radio" class="btn-check" name="rate" id="rate-3" autocomplete="off" value="3">
							<label for="rate-3" type="button" class="btn btn-outline-yellow" onclick="rate(3)">3</label>
							<input type="radio" class="btn-check" name="rate" id="rate-4" autocomplete="off" value="4">
							<label for="rate-4" type="button" class="btn btn-outline-lime" onclick="rate(4)">4</label>
							<input type="radio" class="btn-check" name="rate" id="rate-5" autocomplete="off" value="5">
							<label for="rate-5" type="button" class="btn btn-outline-green" onclick="rate(5)">5</label>
						</div>
					</div>
					<div id="advantages">
						<label class="form-label">Что вам понравилось в обслуживании?</label>
						<div class="form-selectgroup form-selectgroup-boxes d-flex flex-column">
							<label class="form-selectgroup-item flex-fill">
								<input type="checkbox" name="advantages[]" value="1" class="form-selectgroup-input">
								<div class="form-selectgroup-label d-flex align-items-center p-3">
									<div class="me-3">
										<span class="form-selectgroup-check"></span>
									</div>
									<div class="form-selectgroup-label-content d-flex align-items-center">
										<div>
											<div style="font-size: 16px; font-weight: 600;"><?php echo criteria_index_translate(1); ?></div>
										</div>
									</div>
								</div>
							</label>
							<label class="form-selectgroup-item flex-fill">
								<input type="checkbox" name="advantages[]" value="2" class="form-selectgroup-input">
								<div class="form-selectgroup-label d-flex align-items-center p-3">
									<div class="me-3">
										<span class="form-selectgroup-check"></span>
									</div>
									<div class="form-selectgroup-label-content d-flex align-items-center">
										<div>
											<div style="font-size: 16px; font-weight: 600;"><?php echo criteria_index_translate(2); ?></div>
										</div>
									</div>
								</div>
							</label>
							<label class="form-selectgroup-item flex-fill">
								<input type="checkbox" name="advantages[]" value="3" class="form-selectgroup-input">
								<div class="form-selectgroup-label d-flex align-items-center p-3">
									<div class="me-3">
										<span class="form-selectgroup-check"></span>
									</div>
									<div class="form-selectgroup-label-content d-flex align-items-center">
										<div>
											<div style="font-size: 16px; font-weight: 600;"><?php echo criteria_index_translate(3); ?></div>
										</div>
									</div>
								</div>
							</label>
							<label class="form-selectgroup-item flex-fill">
								<input type="checkbox" name="advantages[]" value="4" class="form-selectgroup-input">
								<div class="form-selectgroup-label d-flex align-items-center p-3">
									<div class="me-3">
										<span class="form-selectgroup-check"></span>
									</div>
									<div class="form-selectgroup-label-content d-flex align-items-center">
										<div>
											<div style="font-size: 16px; font-weight: 600;"><?php echo criteria_index_translate(4); ?></div>
										</div>
									</div>
								</div>
							</label>
						</div>
					</div>
					<div id="disadvantages">
						<label class="form-label">Что нам стоит улучшить в обслуживании?</label>
						<div class="form-selectgroup form-selectgroup-boxes d-flex flex-column">
							<label class="form-selectgroup-item flex-fill">
								<input type="checkbox" name="disadvantages[]" value="5" class="form-selectgroup-input">
								<div class="form-selectgroup-label d-flex align-items-center p-3">
									<div class="me-3">
										<span class="form-selectgroup-check"></span>
									</div>
									<div class="form-selectgroup-label-content d-flex align-items-center">
										<div>
											<div style="font-size: 16px; font-weight: 600;"><?php echo criteria_index_translate(5); ?></div>
										</div>
									</div>
								</div>
							</label>
							<label class="form-selectgroup-item flex-fill">
								<input type="checkbox" name="disadvantages[]" value="6" class="form-selectgroup-input">
								<div class="form-selectgroup-label d-flex align-items-center p-3">
									<div class="me-3">
										<span class="form-selectgroup-check"></span>
									</div>
									<div class="form-selectgroup-label-content d-flex align-items-center">
										<div>
											<div style="font-size: 16px; font-weight: 600;"><?php echo criteria_index_translate(6); ?></div>
										</div>
									</div>
								</div>
							</label>
							<label class="form-selectgroup-item flex-fill">
								<input type="checkbox" name="disadvantages[]" value="7" class="form-selectgroup-input">
								<div class="form-selectgroup-label d-flex align-items-center p-3">
									<div class="me-3">
										<span class="form-selectgroup-check"></span>
									</div>
									<div class="form-selectgroup-label-content d-flex align-items-center">
										<div>
											<div style="font-size: 16px; font-weight: 600;"><?php echo criteria_index_translate(7); ?></div>
										</div>
									</div>
								</div>
							</label>
							<label class="form-selectgroup-item flex-fill">
								<input type="checkbox" name="disadvantages[]" value="8" class="form-selectgroup-input">
								<div class="form-selectgroup-label d-flex align-items-center p-3">
									<div class="me-3">
										<span class="form-selectgroup-check"></span>
									</div>
									<div class="form-selectgroup-label-content d-flex align-items-center">
										<div>
											<div style="font-size: 16px; font-weight: 600;"><?php echo criteria_index_translate(8); ?></div>
										</div>
									</div>
								</div>
							</label>
							<label class="form-selectgroup-item flex-fill">
								<input type="checkbox" name="disadvantages[]" value="9" class="form-selectgroup-input">
								<div class="form-selectgroup-label d-flex align-items-center p-3">
									<div class="me-3">
										<span class="form-selectgroup-check"></span>
									</div>
									<div class="form-selectgroup-label-content d-flex align-items-center">
										<div>
											<div style="font-size: 16px; font-weight: 600;"><?php echo criteria_index_translate(9); ?></div>
										</div>
									</div>
								</div>
							</label>
							<label class="form-selectgroup-item flex-fill">
								<input type="checkbox" name="disadvantages[]" value="10" class="form-selectgroup-input">
								<div class="form-selectgroup-label d-flex align-items-center p-3">
									<div class="me-3">
										<span class="form-selectgroup-check"></span>
									</div>
									<div class="form-selectgroup-label-content d-flex align-items-center">
										<div>
											<div style="font-size: 16px; font-weight: 600;"><?php echo criteria_index_translate(10); ?></div>
										</div>
									</div>
								</div>
							</label>
							<label class="form-selectgroup-item flex-fill">
								<input type="checkbox" name="disadvantages[]" value="11" class="form-selectgroup-input">
								<div class="form-selectgroup-label d-flex align-items-center p-3">
									<div class="me-3">
										<span class="form-selectgroup-check"></span>
									</div>
									<div class="form-selectgroup-label-content d-flex align-items-center">
										<div>
											<div style="font-size: 16px; font-weight: 600;"><?php echo criteria_index_translate(11); ?></div>
										</div>
									</div>
								</div>
							</label>
							<label class="form-selectgroup-item flex-fill">
								<input type="checkbox" name="disadvantages[]" value="12" class="form-selectgroup-input">
								<div class="form-selectgroup-label d-flex align-items-center p-3">
									<div class="me-3">
										<span class="form-selectgroup-check"></span>
									</div>
									<div class="form-selectgroup-label-content d-flex align-items-center">
										<div>
											<div style="font-size: 16px; font-weight: 600;"><?php echo criteria_index_translate(12); ?></div>
										</div>
									</div>
								</div>
							</label>
						</div>
						<div class="mt-3">
							<label class="form-label">Другое:</label>
							<textarea name="disadvantage-other" class="form-control" data-bs-toggle="autosize" style="overflow: hidden; overflow-wrap: break-word; resize: none; text-align: start; height: 60px;"></textarea>
						</div>
					</div>
					<div class="form-footer" id="submit">
						<button type="submit" class="btn btn-primary w-100">Отправить оценку</button>
					</div>
				<?php else: ?>
					<div class="d-flex flex-column align-items-center">
						<h2 class="card-title h2 text-center">Благодорим Вас за оценку!</h2>
						<p class="card-subtitle text-center text-muted m-0">Ваше мнение очень важно и мы объязательно учтем его в нашей работе!</p>
					</div>
					<?php unset($_SESSION['rated']); ?>
				<?php endif; ?>
			</div>
		</form>
	</div>
</div>