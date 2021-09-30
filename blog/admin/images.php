<?php  include('../config.php'); ?>
	<?php include(ROOT_PATH . '/admin/includes/admin_functions.php'); ?>
	<?php include(ROOT_PATH . '/admin/includes/head_section.php'); ?>
	<?php include(ROOT_PATH . '/admin/includes/post_functions.php'); ?>
	<?php if(isset($_SESSION['user'])){ ?>
<?php if ($_SESSION['user']['role'] == 'Admin') { ?>


	<title>Admin | Manage Images</title>
	
	
	   <script type="text/javascript">

        $(document).ready(function(){

            $("#but_upload").click(function(){

                var fd = new FormData();

                var files = $('#file')[0].files[0];

                fd.append('file',files);

                $.ajax({
                    url:'upload.php',
                    type:'post',
                    data:fd,
                    contentType: false,
                    processData: false,
					
                    success:function(response){
                        if(response != 0){
                            $("#img").attr("src",response);
                            $('.preview img').show();
                            window.location.replace("images.php");
                        }else{
                            alert('Error while uploading...');
                        }
                    }
                });
            });
        });


 function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('#img')
                        .attr('src', e.target.result)
                  
                };

                reader.readAsDataURL(input.files[0]);
            }
        }


    </script>
	

	
</head>
<body>
	<!-- admin navbar -->
	<?php include(ROOT_PATH . '/admin/includes/navbar.php') ?>

	</div>
	
	
	<body>
    <div class="container">
		
        <form method="post" action="" enctype="multipart/form-data" id="myform">
            <div class='preview'>
			<h1 class="page-title">Admin Images</h1>
						<!-- Display notification message -->
			<?php include(ROOT_PATH . '/includes/messages.php') ?>
                <img src="../static/images/default.png" id="img" height="200">
            </div>
            <div >
            <input type="file" id="file" name="file" onchange="readURL(this);"/>
			
	
				
            <input type="button" class="btn btn-primary btn-sm"  value='upload image' id="but_upload"/>
		</form>
				


	<BR>
	<div class="grid-container">
			<?php
				


				$sql = "SELECT id, picture_name, picture_path FROM pictures order by id desc";
				$result = $conn->query($sql);

				if ($result->num_rows > 0) {
					// output data of each row
					$img_count=0;  //for counting fetched images
					while($row = $result->fetch_assoc()) {
					//show images in table grid
					?>
					<div class="table-div-images">
					
				
					
					<div class="grid-item" align="center">
					<?php
					$img_count++;  //increment 1 for each image
					//echo "count:". $img_count."id:" . $row["id"]. "   Name:" . $row["picture_name"]. " <br>"; //show image label
					$current_pic = $row["picture_path"]; //get image path
					?>
					<a href=<?php echo $current_pic ?>>
					<?php
					echo "<img src=" .$current_pic. " height="."90". ">";
					?>
					</a>

					<a  class="fa fa-trash btn delete" title="delete image" href="images.php?delete-image=<?php echo $row['id'] ?>"></a>
					<!--<a  class="fa fa-info btn info" title="show image info" href="image.php?info-img=<?php echo $row['id'] ?>"></a>	-->	

					</div>
					
					
					
					
					</div>  
					<?php
				}
				} else 
				{
					echo "0 results";
				}
		$conn->close();

					?>
	</div>


			
            </div>

    </div>
</body>

	
</body>
</html>

<?php }else{ ?>
	Missing permission
<?php } ?>
		<?php }else{ ?>
			Missing permission

		<?php } ?>