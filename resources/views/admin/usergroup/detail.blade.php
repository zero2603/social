@extends('layouts.admin')

@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-12">
			<h4 class="m-b-20 header-title">Group Detail</h4>
			<form method="post" action="{{url('admin?controller=UserGroup&task=update&id='.$item->id)}}" class="form-horizontal">

				{{ csrf_field() }}

				<div class="form-group">
					<label class="col-md-2 control-label" for="name">Name</label>
					<div class="col-md-10">
						<input class="form-control" name="data[name]" value="{{ isset($item->name)?$item->name:null }}" type="text" id="name" required maxlength="30">
					</div>
				</div>

				<div class="form-group">
					<label class="col-md-2 control-label" for="params">Params</label>
					<div class="col-md-10">
						<input class="form-control" name="data[params]" type="text" id="params" value="{{$item->params}}">
					</div>
				</div>

				<div class="form-group">
					<label class="col-md-2 control-label"></label>
					<div class="col-md-10">
						<button type="submit" class="btn btn-primary">Submit</button>
					</div>
				</div>
			</form>
		</div>

	</div>
</div>
@endsection
