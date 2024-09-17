<div class="row">
    <div class="col-xl-5">
		@include('user::form')
	</div>

    <div class="col-xl-7">
		<div class="card card-bordered">
			<div class="card-body">
				@include('user::table')
			</div>
		</div>
	</div>
</div>
@include('user::javascript')
