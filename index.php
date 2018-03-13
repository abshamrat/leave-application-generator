<!DOCTYPE html>
<html>
	<?php
		require_once __DIR__ . '/vendor/autoload.php';

		$sent = false;
		$name = isset($_POST['name'])?$_POST['name']:"";
		$phone = isset($_POST['phone'])?$_POST['phone']:"";
		$email = isset($_POST['email'])?$_POST['email']:"";
		$date = isset($_POST['date'])?$_POST['date']:"";
		$designation = isset($_POST['designation'])?$_POST['designation']:"";
		$message = isset($_POST['message'])?$_POST['message']:"";

		if(isset($_POST['name']) && isset($_POST['phone']) && isset($_POST['email']) && isset($_POST['date']) && isset($_POST['designation']) && isset($_POST['message']))
		{
			
			$mpdf = new \Mpdf\Mpdf([ 'debug' => true,
    								'allow_output_buffering' => true]);

			$html='
				<html>
					<head>
						<style type="text/css">
							html,body{
  								font-family: "Open Sans", sans-serif;
  								width: 595px;
  								height: 842px; 
  								margin-top: 30px;
  								padding-left: 100px;
  								padding-right: 100px;
							}
						</style>
					</head>
					<body >
						<div style="padding: 30px;">
							<h1 style="text-align: center; margin-top: 30px">Leave Application Letter</h1>
							<div style="margin-top: 60px">
								<p style="line-height: -2px;">'.$name.'</p>
								<p style="line-height: -2px;">'.$phone.'</p>
								<p style="line-height: -2px;">'.$email.'</p>
							</div>
							<div style="margin-top: 10px">
								<p>'.$date.'</p>
							</div>
							<div style="margin-top: 10px">
								<p style="line-height: -2px;">Sarwar Jahan Morshed</p>
								<p style="line-height: -2px;">CEO</p>
								<p style="line-height: -2px;">S11 IT Limited</p>
								<p style="line-height: -2px;">Mirpur, DOHS</p>
							</div>
							<div style="margin-top: 40px;text-align: justify;">
								<p>Sir,</p>
								<p>'.$message.'</p>
							</div>
							<div style="margin-top: 30px">
								<p>Sincerely,</p>
							</div>
							<div style="margin-top: 50px">
								<p style="line-height: -2px;">'.$name.'</p>
								<p style="line-height: -2px;">'.$designation.'</p>
								<p style="line-height: -2px;">S11 IT Limited</p>
							</div>
						</div>
					</body>
				</html>
			';
			$subject = "Leave Application";
			$to = "sarwar.morshed@selevenit.com";

			$headers = 'From: '.$email. "\r\n".
			    'X-Mailer: PHP/'. phpversion();

			mail($to,$subject,$html,$headers);

			$mpdf->WriteHTML($html);

			$mpdf->Output("Leave-Application.pdf",\Mpdf\Output\Destination::FILE);

			$sent = true;

		}
	 ?>	
	<head>
		<title>Leave Application</title>
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
		<link rel="stylesheet" type="text/css" href="assets/css/style.css">
		</head>
		<body>
			<h1>SElevenIT Limited</h1>
			<div class="info">
				<a href="#">
					<p> Leave Application</p>
				</a>
			</div>
			<?php if($sent != true){ ?>

			<form action="<?php echo 'http://'.$_SERVER['HTTP_HOST'].''.$_SERVER['REQUEST_URI']; ?>" method="POST">
				<h1 style="text-align: center;">Fill the form and download your leave application.</h1>
				<div class="contentform">
					<div id="sendmessage"> Please fill up all fields. </div>
					<div class="leftcontact">
						<div class="form-group">
							<p>Name
								<span>*</span>
							</p>
							<span class="icon-case">
								<i class="fa fa-user"></i>
							</span>
							<input required="Please enter name" value="<?php echo $name; ?>" type="text" name="name" id="nom" data-rule="required" placeholder="Name" data-msg="Add valid name"/>
							<div class="validation"></div>
						</div>
						<div class="form-group">
							<p>E-mail 
								<span>*</span>
							</p>
							<span class="icon-case">
								<i class="fa fa-envelope-o"></i>
							</span>
							<input  required="Please enter email" type="email" name="email" value="<?php echo $email; ?>" id="email" placeholder="your_email@selevenit.com" data-rule="email" data-msg="email is not valid"/>
							<div class="validation"></div>
						</div>
					</div>
					<div class="rightcontact">
						<div class="form-group">
							<p>Phone number 
								<span>*</span>
							</p>
							<span class="icon-case">
								<i class="fa fa-phone"></i>
							</span>
							<input type="text" name="phone" value="<?php echo $phone; ?>"  required="Please enter phone number" placeholder="01XXXXXXXXX" id="phone" data-rule="maxlen:11" data-msg="can not add phone number more than 11 digits"/>
							<div class="validation"></div>
						</div>
						<div class="form-group">
							<p>Date 
								<span>*</span>
							</p>
							<span class="icon-case">
								<i class="fa fa-calendar"></i>
							</span>
							<input type="text" name="date"  required="Please enter date" value="<?php echo $date; ?>" placeholder="dd/mm/YYY" id="date" data-rule="maxlen:10" data-msg="date formate dd/mm/YYY"/>
							<div class="validation"></div>
						</div>
					</div>
					<div class="full-width-div">
						<div class="form-group">
							<p>Designation 
								<span>*</span>
							</p>
							<span class="icon-case">
								<i class="fa fa-id-badge"></i>
							</span>
							<select name="designation">
								<option value="Software Engineer">Software Engineer</option>
								<option value="Sr. Software Engineer">Sr. Software Engineer</option>
							</select>
							<div class="validation"></div>
						</div>
						<div class="form-group">
							<p>Message 
								<span>*</span>
							</p>
							<textarea name="message" id="message" placeholder="Your leave reason" rows="14" data-rule="required" data-msg=""><?php echo $message; ?></textarea>
							<div class="validation"></div>
						</div>
					</div>
				</div>
				<button type="submit" class="bouton-contact">Send</button>
			</form>
			<?php }else if($sent){ ?>
			<div id="sendmessage" style="display: block;"> Download link is available: <a target="_blank" href="<?php echo 'http://'.$_SERVER['HTTP_HOST'].''.$_SERVER['REQUEST_URI'].'/Leave-Application.pdf'; ?>"><?php echo 'http://'.$_SERVER['HTTP_HOST'].''.$_SERVER['REQUEST_URI'].'/Leave-Application.pdf'; ?></a> </div>
			<?php } ?>
			<footer >
				<small id="developedby">Developed by Shamrat</small>
			</footer>
		</body>
	</html>
</html>