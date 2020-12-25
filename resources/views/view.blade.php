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
					<th>Address 2</th>
					<th>State</th>
					<th>City</th>
					<th>Country</th>
					<th>Pincode</th>
					<th>Comments</th>
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
			      editable:[[1, 'first_name'], [2, 'last_name'], [3, 'dob'], [4, 'address1'], [5, 'address2'], [6, 'state'], [7, 'city'], [8, 'country'], [9, 'pincode'], [10, 'comments']]
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
			/*$.ajaxSetup({
				headers:{
					'X-CSRF-Token': $("input[name=_token]").val()
				}
			});*/
			/*var dataTable = $('#my-table').DataTable({
				"processing": true,
				"serverSide": true,
				"order": [],
				"ajax": {
					url:
					type: "POST"
				}
			});*/
			//$('#my-table').on('draw.dt', function(){
				/*$('#my-table').Tabledit({
					url: '/action',
					type: "POST",
					dataType: "json",
					columns: {
						identifier : [0, 'id'],
						editable : [[1, 'f_name'], [2, 'l_name']]
					},
					restoreButton: false,
					onSucccess:function(data, textStatus, jqXHR){
						if (data.action == 'delete') {
							$('#' + data.id).remove();
							//$('#my-table').DataTable().ajax.reload();
						}
					}
				});*/
			//});
		});
	</script>
</body>
</html
