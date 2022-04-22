@extends('admin.layout.index',[
	'title' => _i('Reports'),
	'subtitle' => _i('Reports'),
	'activePageName' => _i('Reports'),
	'activePageUrl' => route('reports.index'),
	'additionalPageUrl' => '' ,
	'additionalPageName' => '',
] )
@section('content')
<section class="content">
	<div class="row">
		<div class="col-md-3">
			<!-- Profile Image -->
			<div class="box box-primary">
				<div class="box-body box-profile">
					<div class='text-center'>
                        <img class="profile-user-img img-responsive img-circle" src="{{ asset('images/user4-128x128.jpg') }}" alt="User profile picture">
                    </div>
					<h3 class="profile-username text-center">{{ $user->name }}</h3>
					<p class="text-muted text-center">{{ $user->email }}</p>
					<ul class="list-group list-group-unbordered">
						<li class="list-group-item">
							<b>{{_i('Phone')}}</b> <a class="pull-right">{{ $user->phone }}</a>
						</li>
						<li class="list-group-item">
							<b>{{ _i('Gender') }}</b> <a class="pull-right">{{ $user->gender }}</a>
						</li>
						<li class="list-group-item">
							<b>{{ _i('Birthday') }}</b> <a class="pull-right">{{ $user->birthdate }}</a>
						</li>
						<li class="list-group-item">
							<b>{{ _i('Points') }}</b> <a class="pull-right">{{ $user->product_points }}</a>
						</li>
						<li class="list-group-item">
							<b>{{ _i('Balance') }}</b> <a class="pull-right">{{ $user->balance }}</a>
						</li>
					</ul>
					<a href="#" class="btn btn-primary btn-block add-balance" data-toggle="modal" data-target="#add-balance-modal"><b>{{ _i('Add Points') }}</b></a>
				</div>
				<!-- /.box-body -->
			</div>
		</div>
		<!-- /.col -->
		<div class="col-md-9">
			<div class="nav-tabs-custom">
				<ul class="nav nav-tabs">
					<li class="active"><a href="#balance" data-toggle="tab" aria-expanded="false">{{ _i('Points') }}</a></li>
                </ul>

				<div class="tab-content">
					<div class="tab-pane active" id="balance">
                        <table class="table table-bordered table-striped">
                            <tr>
                                <td>{{ _i('ID') }}</td>
                                <td>{{ _i('points') }}</td>
                                <td>{{ _i('Created at') }}</td>
                            </tr>
                            @foreach( $points AS $point )
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $point->points }}</td>
                                <td>{{ $point->created_at }}</td>
                            </tr>
                            @endforeach
                        </table>
                    </div>

					<div class="tab-pane" id="settings">
						<form class="form-horizontal">
							<div class="form-group">
								<label for="inputName" class="col-sm-2 control-label">Name</label>
								<div class="col-sm-10">
									<input type="email" class="form-control" id="inputName" placeholder="Name">
								</div>
							</div>
							<div class="form-group">
								<label for="inputEmail" class="col-sm-2 control-label">Email</label>
								<div class="col-sm-10">
									<input type="email" class="form-control" id="inputEmail" placeholder="Email">
								</div>
							</div>
							<div class="form-group">
								<label for="inputName" class="col-sm-2 control-label">Name</label>
								<div class="col-sm-10">
									<input type="text" class="form-control" id="inputName" placeholder="Name">
								</div>
							</div>
							<div class="form-group">
								<label for="inputExperience" class="col-sm-2 control-label">Experience</label>
								<div class="col-sm-10">
									<textarea class="form-control" id="inputExperience" placeholder="Experience"></textarea>
								</div>
							</div>
							<div class="form-group">
								<label for="inputSkills" class="col-sm-2 control-label">Skills</label>
								<div class="col-sm-10">
									<input type="text" class="form-control" id="inputSkills" placeholder="Skills">
								</div>
							</div>
							<div class="form-group">
								<div class="col-sm-offset-2 col-sm-10">
									<div class="checkbox">
										<label>
											@php
											$terms = '#';
											if ($shared_settings->terms_page != null) {
												$terms = url(app()->getLocale()) . '/pages/' . $shared_settings->terms_page;
											}
										@endphp
										<input type="checkbox"> I agree to the <a href="{{$terms}}">terms and conditions</a>
										</label>
									</div>
								</div>
							</div>
							<div class="form-group">
								<div class="col-sm-offset-2 col-sm-10">
									<button type="submit" class="btn btn-danger">Submit</button>
								</div>
							</div>
						</form>
					</div>
					<!-- /.tab-pane -->
				</div>
				<!-- /.tab-content -->
			</div>
			<!-- /.nav-tabs-custom -->
		</div>
		<!-- /.col -->
	</div>
	<!-- /.row -->
</section>

<div class="modal fade" id="add-balance-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">{{ _i('Add Points') }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action='{{ route('reports.rewards.points.add', $user->id) }}' id='add-balance-form' method='post'>
                    @csrf
                    <div class="form-group">
                        <label for="recipient-name" class="col-form-label">{{ _i('Points') }}:</label>
                        <input type="text" name='points' class="form-control">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary" form='add-balance-form'>Save changes</button>
            </div>
        </div>
    </div>
</div>

@endsection
@push('js')
<script>
	$('body').on('submit','#add-balance-form',function (e) {
	    e.preventDefault();
	    let url = $(this).attr('action');
	    $.ajax({
	        url: url,
	        method: "post",
	        data: new FormData(this),
	        dataType: 'json',
	        cache       : false,
	        contentType : false,
	        processData : false,
	        success: function (response) {
	            console.log(response);
	            if (response.errors){
	                $('#masages_model').empty();
	                $.each(response.errors, function( index, value ) {
	                    $('#masages_model').show();
	                    $('#masages_model').append(value + "<br>");
	                });
	            }
	            if (response.status == 'success'){
	                new Noty({
	                    type: 'success',
	                    layout: 'topRight',
	                    text: response.message,
	                    timeout: 2000,
	                    killer: true
	                }).show();
	                $('#add-balance-modal').modal('hide');
	            }
	        },
	    });
	});
</script>
@endpush
