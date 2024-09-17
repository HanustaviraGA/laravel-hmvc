<form action="javascript:onSave('formUser')" method="post" id="formUser" name="formUser" autocomplete="off" enctype="multipart/form-data">
	<div class="card card-bordered">
		<div class="card-body">
			<input type="hidden" name="id" id="id">

			<ul class="nav nav-tabs nav-line-tabs mb-5 fs-6">
				{{-- <li class="nav-item">
					<a class="nav-link active" data-bs-toggle="tab" href="#tabGeneral">
						<i class="las la-bars fs-2"></i>
						General
					</a>
				</li> --}}
				{{-- <li class="nav-item">
					<a class="nav-link" data-bs-toggle="tab" href="#tabAccount">
						<i class="las la-user-cog fs-2"></i>
						Account
					</a>
				</li> --}}
			</ul>

			<div class="tab-content" id="myTabContent">
				<div class="tab-pane fade show active" id="tabGeneral" role="tabpanel">
					<div class="fv-row mb-5">
						<label for="" class="required form-label">Nama Lengkap</label>
						<input type="text" id="name" name="name" class="form-control form-control-solid" placeholder="Input Nama Lengkap" />
					</div>

					<div class="fv-row mb-5">
						<label for="" class="form-label">Role</label>
						<select name="role_id" id="role_id" class="form-select form-select-solid" aria-label="Role"></select>
					</div>

                    <div class="fv-row mb-5">
						<label for="" class="form-label">Email</label>
						<input type="email" id="email" name="email" class="form-control form-control-solid" placeholder="Input Email" />
					</div>

					<div class="fv-row mb-5" data-kt-password-meter="true" id="kt_password_meter_control">
						<!-- <label for="" class=" form-label">Password</label>
						<input type="password" name="password" autocomplete="on" class="form-control form-control-solid" placeholder="input password" /> -->
						<div class="mb-1">
							<label class="col-form-label">
								Password
							</label>
							<div class="position-relative mb-3">
								<input id="password" class="form-control form-control-solid" type="password" placeholder="input password" name="password" autocomplete="on" />
								<!-- <div class="invalid-feedback">Password Not Enough Strong!</div> -->
								{{-- <span class="btn btn-sm btn-icon position-absolute translate-middle top-50 end-0 me-n2" data-kt-password-meter-control="visibility">
									<i class="bi bi-eye-slash d-none fs-2"></i>
									<i class="bi bi-eye fs-2"></i>
								</span> --}}
							</div>

							{{-- <div class="d-flex align-items-center mb-3" data-kt-password-meter-control="highlight">
								<div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px me-2"></div>
								<div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px me-2"></div>
								<div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px me-2"></div>
								<div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px"></div>
							</div> --}}
						</div>
						{{-- <div class="text-muted">
							Gunakan 8 karakter atau lebih dengan campuran huruf besar, huruf kecil, angka & simbol.
						</div> --}}
					</div>

					{{-- <div class=" fv-row mb-5">
						<label class="col-form-label">Tulis Ulang Password</label>
						<div class="col-lg-12 position-relative">
							<input id="p2" type="password" name="renewPass" class="form-control form-control-solid" autocomplete="off" placeholder="input ulang password" />
							<!-- <div id="validationServerrenewPassFeedback" class="invalid-feedback">Password tidak cocok.</div> -->
							<span class="btn btn-sm btn-icon position-absolute translate-middle top-50 end-0 me-1" data-kt-password-meter-control="visibility" onclick="togglePw('renewPass', 'renewPassEye', 'renewPassEyeSlash')">
								<i class="bi bi-eye-slash d-none fs-2" id="renewPassEyeSlash"></i>
								<i class="bi bi-eye fs-2" id="renewPassEye"></i>
							</span>
						</div>
					</div>

					<div class="fv-row mb-5">
						<label for="" class="form-label">Phone</label>
						<input type="telp" name="telp" class="form-control form-control-solid" placeholder="input no telp" />
					</div> --}}

					{{-- <div class="fv-row mb-5">
						<label for="" class="form-label">Status</label>
						<div class="form-check form-check-custom form-check-solid">
							<input name="active" class="form-check-input" type="checkbox" value="1" id="flexCheckChecked" checked="checked" />
							<label class="form-check-label" for="flexCheckChecked">
								Aktif
							</label>
						</div>
					</div> --}}

				</div>
				{{-- <div class="tab-pane fade" id="tabAccount" role="tabpanel">
					<div class="fv-row mb-5">
						<label for="" class="form-label">Email</label>
						<input type="email" name="email" class="form-control form-control-solid" placeholder="Input Email" />
					</div>

					<div class="fv-row mb-5" data-kt-password-meter="true" id="kt_password_meter_control">
						<!-- <label for="" class=" form-label">Password</label>
						<input type="password" name="password" autocomplete="on" class="form-control form-control-solid" placeholder="input password" /> -->
						<div class="mb-1">
							<label class="col-form-label">
								Password
							</label>
							<div class="position-relative mb-3">
								<input id="p1" class="form-control form-control-solid" type="password" placeholder="input password" name="password" autocomplete="on" />
								<!-- <div class="invalid-feedback">Password Not Enough Strong!</div> -->
								<span class="btn btn-sm btn-icon position-absolute translate-middle top-50 end-0 me-n2" data-kt-password-meter-control="visibility">
									<i class="bi bi-eye-slash d-none fs-2"></i>
									<i class="bi bi-eye fs-2"></i>
								</span>
							</div>

							<div class="d-flex align-items-center mb-3" data-kt-password-meter-control="highlight">
								<div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px me-2"></div>
								<div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px me-2"></div>
								<div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px me-2"></div>
								<div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px"></div>
							</div>
						</div>
						<div class="text-muted">
							Gunakan 8 karakter atau lebih dengan campuran huruf besar, huruf kecil, angka & simbol.
						</div>
					</div>

					<div class=" fv-row mb-5">
						<label class="col-form-label">Tulis Ulang Password</label>
						<div class="col-lg-12 position-relative">
							<input id="p2" type="password" name="renewPass" class="form-control form-control-solid" autocomplete="off" placeholder="input ulang password" />
							<!-- <div id="validationServerrenewPassFeedback" class="invalid-feedback">Password tidak cocok.</div> -->
							<span class="btn btn-sm btn-icon position-absolute translate-middle top-50 end-0 me-1" data-kt-password-meter-control="visibility" onclick="togglePw('renewPass', 'renewPassEye', 'renewPassEyeSlash')">
								<i class="bi bi-eye-slash d-none fs-2" id="renewPassEyeSlash"></i>
								<i class="bi bi-eye fs-2" id="renewPassEye"></i>
							</span>
						</div>
					</div>

					<div class="fv-row mb-5">
						<label for="" class="form-label">Phone</label>
						<input type="telp" name="telp" class="form-control form-control-solid" placeholder="input no telp" />
					</div>

					<div class="fv-row mb-5">
						<label for="" class="form-label">Status</label>
						<div class="form-check form-check-custom form-check-solid">
							<input name="active" class="form-check-input" type="checkbox" value="1" id="flexCheckChecked" checked="checked" />
							<label class="form-check-label" for="flexCheckChecked">
								Active
							</label>
						</div>
					</div>

				</div> --}}
			</div>

		</div>
		<div class="card-footer d-flex justify-content-end py-6 px-9">
			{{-- <button type="button" onclick="onReset(this)" class="btn btn-sm btn-light btn-active-light-primary me-2 actCreate">
				<i class="las la-redo-alt fs-1"></i> Reset
			</button> --}}
			<button type="submit" class="btn btn-primary btn-sm me-2 actCreate">
				<i class="las la-save fs-1"></i> Save
			</button>
			{{-- <button type="button" onclick="onDisplayEdit(this)" class="btn btn-warning btn-sm me-2 d-none actEdit w-137px">
				<i class="las la-edit fs-1"></i> Edit
			</button>
			<button type="button" onclick="onDelete(this)" class="btn btn-danger btn-sm me-2 d-none actDelete">
				<i class="las la-trash fs-1"></i> Delete
			</button> --}}
		</div>
	</div>
</form>
