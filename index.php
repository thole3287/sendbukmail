<?php
ob_start();
session_start();

require_once("classes/db.php");

$db = new DataBase();
$db->Connect();

$query = $db->Query("SELECT * FROM `customer` ORDER BY `customer_id` ASC");

//$user = $db->Fetch_Array("SELECT * FROM `customer` WHERE `customer_id` = '6'");

// while ($row = mysqli_fetch_array($query))
// {

// }
?>
<!DOCTYPE html>
<html>
<head>
	<title>Send Mail</title>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.2.2/css/bootstrap.min.css" />
	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" />
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastify-js/1.12.0/toastify.min.css" />
	<link rel="icon" href="https://www.kindpng.com/picc/m/258-2584223_send-sent-vector-png-transparent-png.png">
</head>
<body>
	<div class="container h-100">
		<div class="d-flex justify-content-center align-items-center h-100">
			<div class="col-md-10 my-auto">
				<form action="#" method="POST" enctype="multipart/form-data" id="fm-sendmail">
					<div class="card">
						<div class="card-header">
							<i class="far fa-paper-plane me-2"></i>
							<span>Send Mail By Nhóm 1</span>
						</div>
						<div class="row card-body">
							<div class="col-md-6  ">
								<table id="table_id">
									<thead>
										<tr>
											<th>Name</th>
											<th>Email</th>
											<th>Select</th>
										</tr>
									</thead>
									<tbody>
								        <!-- <tr>
								            <td>data-1a</td>
								            <td>data-1b</td>
								            <td>data-1c</td>
								        </tr> -->
								        <?php
								        while ($row = mysqli_fetch_array($query))
								        {
								        	echo '<tr>';
								        	echo '<td scope="row">'.$row['customer_name'].'</td>';
								        	echo '<td>'.$row['customer_email'].'</td>';
								        	echo '<td><input type="checkbox" data-id="'.$row['customer_id'].'" name="select" value=""></td>';
								        	echo ' </tr>';
								        }
								        ?>
								    	<!-- <tr>
								    		<td colspan="3" align="right"><input type="checkbox" id="checkAll"> Check all</td>
								    	</tr> --> 

								    </tbody>
								</table>
							<div align="right"><input type="checkbox" id="checkAll"> Check all</div>
							</div>
							<!-- <table class="table table-striped">
							  <thead>
							    <tr>
							      <th scope="col">Name</th>
							      <th scope="col">Email</th>
							    </tr>
							  </thead>
							  <tbody>
							   
							    <?php
							    	// while ($row = mysqli_fetch_array($query))
							    	// {
							    	// 	echo '<tr>';
							    	// 	echo '<th scope="row">'.$row['customer_name'].'</th>';
								    //   	echo '<td>'.$row['customer_email'].'</td>';
								    //   	echo ' </tr>';
								    // }
							    ?>
							   
							  </tbody>
							</table> -->

							<div class="col-md-6">
								<div class="form-group mb-2">
									<label class="form-label">Subject:</label>
									<input type="text" name="cc" id="cc" value="" class="form-control" placeholder="Subject" required="required">
								</div>
								<div class="form-group mb-2">
									<label class="form-label">Mail Content:</label>
									<textarea class="form-control" name="content" id="content" rows="10" placeholder="Messages" required="required"></textarea>
								</div>
								<div class="form-group">
									<label class="form-label">File Attachment:</label>
									<input type="file" name="att" id="att" class="form-control">
								</div>
							</div>
						</div>
						<div class="card-footer">
							<button type="submit" class="btn btn-primary w-100" id="send-event">Send</button>
							<!-- <?php echo date('H:i:s d/m/Y', (1666259545866/1000)); ?> -->
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>

	<style type="text/css">
		@import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');
		html {
			height: 100%;
		}
		body {
			font-family: 'Poppins', sans-serif;
			font-size: 16px;
			background-color: #EFEFEF;
			height: 100%;
		}
		.card {
			border-radius: unset!important;
			box-shadow: rgba(0, 0, 0, 0.1) 0px 4px 6px -1px, rgba(0, 0, 0, 0.06) 0px 2px 4px -1px;
		}
		.card-header, .card-footer {
			background-color: #fff!important;
			padding: 20px!important;
		}
	</style>

	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.2/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/js/all.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.2.2/js/bootstrap.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/toastify-js/1.12.0/toastify.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
	<script type="text/javascript" src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>

	<script type="text/javascript">
		$(document).ready(function(){
			console.log(Date.now());
			$("#checkAll").change(function(){
				$("input:checkbox").prop('checked', $(this).prop("checked"));
			});

			$('#table_id').DataTable({
				pageLength: 4,
				order: [[0, 'desc']],
				lengthMenu: [4, 5, 10, 20, 50, 100, 200, 500],
			});

			$("#fm-sendmail").on("submit", function(e) {
				e.preventDefault();


				
			    //attr
			    if ($('#checkAll').is(':checked'))
			    {
			    	$.each($("input:checkbox[name='select']:checked"), function () {



			     	// $(this).data("id");

			 		//console.log($(this).data("id")); // $(this).data("id")

				    var fd = new FormData();
				    var time = Date.now();
				    fd.append('subject', $("#cc").val());
				    fd.append('content', $("#content").val());
				    fd.append('image', $('#att')[0].files[0]);
				    fd.append('id', $(this).data("id"));
				    fd.append('time', time);

				    $.ajax({
					 	url: "ajax/call.php?act=all", // all
					 	type: "POST",
					 	dataType: "JSON",
					 	data: fd,
					 	cache: false,
					 	processData: false,
	                    contentType: false,
					 	beforeSend: function()
					 	{
					 		$("#send-event").html("Sending...");
					 	},
					 	success: function(response)
					 	{
					 	   for (var i = 0; i < response.length; i++)
					 	   {
	     					    if (response[i].status == true)
					 	        {
	         					    Toastify({
	         							text: response[i].messenge,
	         							duration: 3000,
	         							style: {
	                                         background: "linear-gradient(to right, #00b09b, #96c93d)",
	                                     }
	         						}).showToast();
					 	        }
					 	        else
					 	        {
					 	        	Toastify({
	         							text: response[i].messenge,
	         							duration: 3000,
	         							style: {
	                                         background: "linear-gradient(to right, #ff5f6d, #ffc371)",
	                                     }
	         						}).showToast();
					 	        }

					         }
					        
					 		$("#send-event").html("Send");
					 	}
					 });

			     });

			    }
			    else
			    {
			    	$.each($("input:checkbox[name='select']:checked"), function () {


			    		//$(this).data("id");

			 		//console.log($(this).data("id")); // $(this).data("id")

			 		var fd = new FormData();
				    var time = Date.now();
			 		fd.append('subject', $("#cc").val());
			 		fd.append('content', $("#content").val());
			 		fd.append('image', $('#att')[0].files[0]);
			 		fd.append('id', $(this).data("id"));
				    fd.append('time', time);

			 		 $.ajax({
					 	url: "ajax/call.php?act=select", // all
					 	type: "POST",
					 	dataType: "JSON",
					 	data: fd,
					 	cache: false,
					 	processData: false,
					 	contentType: false,
					 	beforeSend: function()
					 	{
					 		$("#send-event").html("Sending...");
					 	},
					 	success: function(response)
					 	{
					 		for (var i = 0; i < response.length; i++)
					 		{
					 			if (response[i].status == true)
					 			{
					 				Toastify({
					 					text: response[i].messenge,
					 					duration: 3000,
					 					style: {
					 						background: "linear-gradient(to right, #00b09b, #96c93d)",
					 					}
					 				}).showToast();
					 			}
					 			else
					 			{
					 				Toastify({
					 					text: response[i].messenge,
					 					duration: 3000,
					 					style: {
					 						background: "linear-gradient(to right, #ff5f6d, #ffc371)",
					 					}
					 				}).showToast();
					 			}

					 		}

					 		$("#send-event").html("Send");
					 	}
					 });

			 		});

			    }


			    

			});
		});
	</script>
</body>
</html>
<?php
ob_flush();
?>