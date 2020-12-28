<!DOCTYPE html>
<html>
<head>
	<title>Details</title>
	<meta charset="utf-8">
  	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  	<script src="https://cdn.datatables.net/1.10.22/css/jquery.dataTables.min.css"></script>
  	<script src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>
  	<script srcsrc="https://markcell.github.io/jquery-tabledit/assets/js/tabledit.min.js"></script>
  	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>            
    <script src="https://markcell.github.io/jquery-tabledit/assets/js/tabledit.min.js"></script>
  
  	<script src="public/js/script.js"></script>
</head>
<body>
	<div class="container">
		<div class="text-right" style="margin-top: 20px">
			<a href="{{ url('/exportData') }}"> <span class="btn btn-info btn-lg glyphicon glyphicon-export" style="padding: 8px 8px;"> Export</span></a>
			<a href="{{ url('/')}}" class="btn btn-lg btn-danger">Back<<</a>
		</div>
		<div class="table-responsive">
			@csrf
			<table class="table table-striped" id="editable">
				<thead>
					<tr>
					<th>Id</th>
					<th>First Name</th>
					<th>Last Name</th>
					<th>DOB</th>
					<th>Address1</th>
					<th>Address2</th>
					<th>State</th>
					<th>City</th>
					<th>Country</th>
					<th>Pincode</th>
					<th>Comments</th>
					<th>Add</th>
				</tr>
				</thead>
				<tbody>
					@foreach($data as $key => $val)
						<tr id="{{$val->id}}">
							<td>{{$val->id}}</td>
							<td contenteditable="false">{{$val->f_name}}</td>
							<td contenteditable="false">{{$val->l_name}}</td>
							<td contenteditable="false">{{$val->dob}}</td>
							<td contenteditable="false">{{$val->address1}}</td>
							<td contenteditable="false">{{$val->address2}}</td>
							<td contenteditable="false">{{ App\State::where('id','=',$val->state)->select('name')->first()->name}}</td>
							<td contenteditable="false">{{ App\City::where('id','=',$val->city)->select('name')->first()->name}}</td>
							<td contenteditable="false">{{ App\Country::where('id','=',$val->country)->select('name')->first()->name}}</td>
							<td contenteditable="false">{{$val->pincode}}</td>
							<td contenteditable="false">{{$val->comments}}</td>
							<td><form><input type="button" name="add" class="addNew btn btn-success" value="Add"></form></td>
						</tr>
					@endforeach
				</tbody>
			</table>
		</div>
	</div>
	<script type="text/javascript">
		$(document).ready(function() {
			$(document).ready(function(){
   
			  $.ajaxSetup({
			    headers:{
			      'X-CSRF-Token' : $("input[name=_token]").val()
			    }
			  });

			  $('#editable').Tabledit({
			    url:'/action',
			    dataType:"json",
			    columns:{
			      identifier:[0, 'id'],
			      editable:[[1, 'f_name'], [2, 'l_name'], [3, 'dob'], [4, 'address1'], [5, 'address2'], [6, 'state'], [7, 'city'], [8, 'country'], [9, 'pincode'], [10, 'comments']]
			    },
			    restoreButton:false,
			    onSuccess:function(data, textStatus, jqXHR)
			    {
			      if(data.action == 'delete')
			      {
			        $('#'+data.id).remove();
			      }
			    }
			  });

			});  
			
			$('.addNew').on('click', function(){
				$('#editable').append('<tr id="newRow"><td></td><td><input type="text" name="f_name" id="f_name" class="form-control" placeholder="First Name" required></td><td><input type="text" name="l_name" id="l_name" class="form-control" placeholder="Last Name" required></td><td><input type="date" name="dob" id="dob" class="form-control" required></td><td><input type="text" name="address1" class="form-control" placeholder="Address1" id="address1" required></td><td><input type="text" name="address" class="form-control" id="address2" placeholder="Address2" required></td><td><select id="country" name="country" class="form-control"><option value="" selected disabled>--Select--</option>@foreach($countries as $key => $value)<option value="{{$key}}">{{$value}}</option>@endforeach	</select></td><td><select id="state" name="state" class="form-control"></select></td><td><select id="city" name="city" class="form-control"></select></td><td><input type="text" id="pincode" name="pincode" class="form-control" pattern="[0-9]{6}" placeholder="Pincode" required></td><td><input type="text" name="comments" id="comments" class="form-control" placeholder="Comments" required></td><td><input type="submit" class="btn btn-success text-right" name="submit" id="save"></td></tr>');
			});
			$('#editable').on('change', '#country', function(){
				var country_id = this.value;
				$("#state").html('');
				$.ajax({
					url:"{{url('states-by-country')}}",
					type: "GET",
					data: {
						country_id: country_id,
						_token: '{{csrf_token()}}' 
					},
					dataType : 'json',
					success: function(result){
						$('#state').empty();
						$('#state').html('<option value="">Select State</option>'); 
						$.each(result,function(key,value){
							$("#state").append('<option value="'+key+'">'+value+'</option>');
						});
						$('#city').html('<option value="">Select State First</option>'); 
					}
				});
			});
			$('#editable').on('change','#state', function() {
				var state_id = this.value;
				$("#city").html('');
				$.ajax({
					url:"{{url('cities-by-state')}}",
					type: "POST",
					data: {
						state_id: state_id,
						_token: '{{csrf_token()}}' 
					},
					dataType : 'json',
					success: function(result){
						$('#city').html('<option value="">Select City</option>'); 
						$.each(result,function(key,value){
							$("#city").append('<option value="'+key+'">'+value+'</option>');
						});
					}
				});
		 	});
			$('#editable').on('click', '#save', function(){
				$.ajax({
					url:"{{url('/saveDetails')}}",
					type: "POST",
					data: {
						f_name: $("#f_name").val(),
						l_name: $("#l_name").val(),
						dob: $("#dob").val(),
						address1: $("#address1").val(),
						address2: $("#address2").val(),
						country: $("#country").val(),
						state: $("#state").val(),
						city: $("#city").val(),
						pincode: $("#pincode").val(),
						comments: $("#comments").val(),
						_token: '{{csrf_token()}}' 
					},
					dataType : 'json',
					success: function(result){
						//$('#editable.#newRow').hide();
						return true;
					}
				});
			});
		});
	</script>
</body>
</html
