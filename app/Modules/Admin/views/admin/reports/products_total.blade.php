@extends('admin.layout.index',[
	'title' => _i('Reports'),
	'subtitle' => _i('Reports'),
	'activePageName' => _i('Reports'),
	'activePageUrl' => '',
	'additionalPageUrl' => '' ,
	'additionalPageName' => '',
] )

<?php

?>

@section('content')
	<!-- Page body start -->
	<div class="page-body">
		<div class="row">
			<div class="col-sm-12">
				<!-- Nestable card start -->
				<div class="card">
					<div class="card-header">
						<h5>{{_i('Reports')}}</h5>
						<div class="card-header-right">
							<i class="icofont icofont-rounded-down"></i>
							<i class="icofont icofont-refresh"></i>
							<i class="icofont icofont-close-circled"></i>
						</div>
					</div>
					<div class="card-block">

						<div class="row">

							<div class="col-lg-12 col-sm-12">
								<div class="dd" id="">
									<ol class="dd-list">
										{{-- <li class="dd-item" data-id="13">
											<div class="dd-handle nestable-success">Item 1</div>
										</li>
										<li class="dd-item" data-id="14">
											<div class="dd-handle nestable-warning">Item 2</div>
											<ol class="dd-list">
												<li class="dd-item" data-id="14">
													<div class="dd-handle">Item 3</div>
												</li>
												<li class="dd-item" data-id="15">
													<div class="dd-handle">Item 4</div>
												</li>
												<li class="dd-item" data-id="16">
													<div class="dd-handle">Item 5</div>
													<ol class="dd-list">
														<li class="dd-item" data-id="17">
															<div class="dd-handle">Item 6</div>
														</li>
														<li class="dd-item" data-id="18">
															<div class="dd-handle">Item 7</div>
														</li>
														<li class="dd-item" data-id="19">
															<div class="dd-handle">Item 8</div>
														</li>
													</ol>
												</li>
												<li class="dd-item" data-id="20">
													<div class="dd-handle">Item 9</div>
												</li>
												<li class="dd-item" data-id="21">
													<div class="dd-handle">Item 10</div>
												</li>
											</ol>
										</li>
										<li class="dd-item" data-id="22">
											<div class="dd-handle nestable-danger">Item 11</div>
										</li>
										<li class="dd-item" data-id="23">
											<div class="dd-handle nestable-info">Item 12</div>
										</li> --}}
										{!!$html!!}
									</ol>
								</div>
							</div>



						</div>
					</div>
				</div>
				<!-- Nestable card end -->
			</div>
		</div>
	</div>
	<!-- Page body end -->
	@endsection
