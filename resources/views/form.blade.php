<!DOCTYPE html>
<html>
<head>
	<title>User Form</title>
	<meta charset="utf-8">
  	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
  	<style type="text/css">
  		.body-container {
  			border: 1px solid #ccc;
  			width: 65%;
  			margin: 0px auto;
  			padding: 15px;
  		}
  	</style>
</head>
<body>
	<div class="container">
		<form method="post" action="/saveDetails">
			{{ csrf_field() }}
			<div class="form-group">
				<label for="f_name">First Name</label>
				<input type="text" name="f_name" id="fname" class="form-control" placeholder="First Name" required>
			</div>
			<div class="form-group">
				<label for="l_name">Last Name</label>
				<input type="text" name="l_name" class="form-control" placeholder="Last Name" required>
			</div>
			<div class="form-group">
				<label for="dob">DOB</label>
				<input type="date" name="dob" class="form-control" required>
			</div>
			<div class="form-group">
				<label for="address1">Address 1</label>
				<input type="text" name="address1" id="fname" class="form-control" placeholder="Address" required>
			</div>
			<div class="form-group">
				<label for="address2">Address 2</label>
				<input type="text" name="address2" id="fname" class="form-control" placeholder="Address" required>
			</div>
			<div class="form-group">
				<label for="country">Country</label>
				<select id="country" name="country" class="form-control">
					<option value="" selected disabled>--Select--</option>
					@foreach($countries as $key => $value)
						<option value="{{$key}}">{{$value}}</option>
					@endforeach
				</select>
			</div>
			<div class="form-group">
				<label for="state">State</label>
				<select id="state" name="state" class="form-control">
				</select>
			</div>
			<div class="form-group">
				<label for="city">City</label>
				<select id="city" name="city" class="form-control">
				</select>
			</div>
			<div class="form-group">
				<label for="pincode">Pincode</label>
				<input type="text" name="pincode" class="form-control" pattern="[0-9]{6}" placeholder="Pincode" required>
			</div>
			<div class="form-group">
				<label for="address2">Comments</label>
				<input type="text" name="comments" id="comments" class="form-control" placeholder="Comments" required>
			</div>
			<div class="form-group">
				<button class="btn btn-success text-right" name=suibmit>submit</button>
			</div>
		</form>
	</div>
	<script type="text/javascript">
		$(document).ready(function() {
			$('#country').on('change', function() {
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
			$('#state').on('change', function() {
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
		}); 
	</script>
</body>
</html>