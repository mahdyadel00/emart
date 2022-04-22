 
<div class="tab-pane"  id="metaTags">
	<form method="POST" id="form-meta-tags" action="{{route('meta.store')}}">
		@csrf
		<input type="hidden"  name="id" id="metId"   >
		<div class="row">
			<div class="col-md-12 form-group">
 				<label for="title" >{{_i('Meta Title')}}</label>
				<input type="text" class="form-control" name="value[title]" id="title">
			</div>
			<div class="col-md-12 form-group">
 				<label for="description" >{{_i('Meta Description')}}</label>
				<input type="text" class="form-control" name="value[description]" id="des">
			</div>
			<div class="col-md-12 form-group">
 				<label for="keyword" >{{_i('Meta Keywords')}}</label>
				<input type="text" class="form-control" name="value[keyword]" id="keyword">
			</div>
			<div class="col-md-12 form-group">
				<button type="submit" form="form-meta-tags" class="form-control btn btn-primary">{{_i('save')}}</button>
			</div>
		</div>
	</form>

</div>
 


