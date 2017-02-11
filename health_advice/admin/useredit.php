<?php
	include('config.php');  
include('header.php');
	$user_id  =   $_REQUEST['instructor_id'];
	$query="select fname,lname,instructor_email,instructor_phone_number,instructor_about from user_instructors where instructor_id='$user_id'";
	$run=mysql_query($query);
	while ($row=mysql_fetch_array($run))
	{
		
		$fname=$row['fname'];
		$lname=$row['lname'];
		$email=$row['instructor_email'];
		$mobile=$row['instructor_phone_number'];
		$about=$row['instructor_about'];
		echo "$fname";
	}
	?>
<script type="text/javascript" src="js/jquery-form.validate.js"></script>

<section id="main" class="column" style="width:100%">
		
		<h4 class="alert_info">Welcome to the Family Health Panel </h4>
		
		<article class="module width_3_quarter">
		<header><h3 class="tabs_involved">EDIT USER INSTRUCTION</h3>
		
		</header>

		<div class="tab_container">
			<div id="tab1" class="tab_content">
                            <form method="POST" name="user_edit.php" action=""useredit.php?edit_id=<?php echo @$user_id;?>"" >
			<table class="tablesorter" cellspacing="0"> 
			<tbody> 
								<?php
			if($errormsg != ""){
			echo '<tr>
				<th colspan="8" align="center" style="color:#ff0000; font-size:20px;">'.$errormsg.'</th>
				</tr>';
			}
			?>
				<tr> 
   				<td><label for="fname">fname:</label></td> 
    				<td><input type="text" name="fname" value="<?php echo @$fname ;?>"></td>     				
				</tr>
			</tbody> 
			<tbody> 
				<tr> 
                                <td><label for="lname">Lname:</label></td> 
    				<td><input type="text" name="lname" value="<?php echo @$lname;?>"></td>     				
				</tr>
			</tbody> 
			<tbody> 
				<tr> 
   					<td><label for="Email Address">Email Address:</label></td> 
    				<td><input type="text" name="Instructor_email" value="<?php echo @$email;?>"></td>     				
				</tr>
			</tbody> 
			<tbody> 
				<tr> 
   				<td><label for="mobile">Mobile:</label></td> 
    				<td><input type="text" name="Instructor_phone_number" value="<?php echo @$mobile;?>"></td>     				
				</tr>
			</tbody> 
			<tbody> 
                        <tr> 
                        <td><label for="City">Description :</label></td> 
                        <td><input type="text" name="Instructor_about"  value="<?php echo @$about;?>"></td>
                        </tr>
			</tbody>
			<tbody> 
                        
			</tbody>
			
			
			<tbody> 
			<tr>
				<td align="center" colspan="2"><input type="submit" name="save" value="Save"> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				<input type="submit" name="cancel" value="Cancel"></td>				
			</tr>
				</tbody> 
				<tbody> 
				
			</tbody> 
			
			</table>
                            </form>
			</div><!-- end of #tab1 -->
			
		
			
		</div><!-- end of .tab_container -->
		
		</article><!-- end of content manager article -->
		
		<div class="clear"></div>
		
		<div class="spacer"></div>
	</section>
