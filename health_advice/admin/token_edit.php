<?php
define('PAGENAME', 'tokeneditpage', true);
include('config.php');  // require or include, config.php from include folder
include('header.php');   // require or include, header.php from include folder
$tokenid  =   $_REQUEST['token_id'];   

 $selectquery = mysql_query("select token_rate_id,normal_token_one,normal_token_one_price,normal_token_two,normal_token_two_price,normal_token_three,normal_token_three_price,monthly_token_one,monthly_token_one_price,monthly_token_two,monthly_token_two_price,monthly_token_three,monthly_token_three_price,message,free_token_value FROM token_rate_by_admin where token_rate_id=$tokenid");
$tokenrate=mysql_fetch_array($selectquery);  //carry on looping through while there are records
       
		$tokenrateid=$tokenrate['token_rate_id'];
		$normaltokenone=$tokenrate['normal_token_one'];
		$normaltokenoneprice=$tokenrate['normal_token_one_price'];
		$normaltokentwo=$tokenrate['normal_token_two'];
		$normaltokentwoprice=$tokenrate['normal_token_two_price'];
		$normaltokenthree=$tokenrate['normal_token_three'];
		$normaltokenthreeprice=$tokenrate['normal_token_three_price'];
		$monthlytokenone=$tokenrate['monthly_token_one'];
		$monthlytokenoneprice=$tokenrate['monthly_token_one_price'];
		$monthlytokentwo=$tokenrate['monthly_token_two'];
		$monthlytokentwoprice=$tokenrate['monthly_token_two_price'];
		$monthlytokenthree=$tokenrate['monthly_token_three'];
		$monthlytokenthreeprice=$tokenrate['monthly_token_three_price'];
		$message=$tokenrate['message'];
		$freetokenvalue=$tokenrate['free_token_value'];
		
	
		
if(isset($_POST['save'])){    
    //print_r($_POST);
        
		$nortokenone=$_POST['normal_token_one'];
		$nortokenoneprice=$_POST['normal_token_one_price'];
		$nortokentwo=$_POST['normal_token_two'];
		$nortokentwoprice=$_POST['normal_token_two_price'];
		$nortokenthree=$_POST['normal_token_three'];
		$nortokenthreeprice=$_POST['normal_token_three_price'];
		$monthtokenone=$_POST['monthly_token_one'];
		$monthtokenoneprice=$_POST['monthly_token_one_price'];
		$monthtokentwo=$_POST['monthly_token_two'];
		$monthtokentwoprice=$_POST['monthly_token_two_price'];
		$monthtokenthree=$_POST['monthly_token_three'];
		$monthtokenthreeprice=$_POST['monthly_token_three_price'];
		$msg=$_POST['message'];
		$freetoken=$_POST['free_token_value'];
      $updatequery  =   "update token_rate_by_admin set normal_token_one='".$nortokenone."',normal_token_one_price='".$nortokenoneprice."',normal_token_two='".$nortokentwo."',normal_token_two_price='".$nortokentwoprice."',normal_token_three='".$nortokenthree."',normal_token_three_price='".$nortokenthreeprice."',monthly_token_one='".$monthtokenone."',monthly_token_one_price='".$monthtokenoneprice."',monthly_token_two='".$monthtokentwo."',monthly_token_two_price='".$monthtokentwoprice."',monthly_token_three='".$monthtokenthree."',monthly_token_three_price='".$monthtokenthreeprice."',message='".$msg."',free_token_value='".$freetoken."' where token_rate_id=$tokenrateid";
    if (mysql_query($updatequery)){
		//echo "$updatequery";
		header('location:token_create.php');
		exit();
	}else
		{
    $errormsg   =   "Updation error! Please try again!";    
    
    }
}
if(isset($_POST['cancel'])){
        header('location:token_create.php');
		 exit();
}
?>
<script type="text/javascript" src="js/jquery-form.validate.js"></script>

<section id="main" class="column" style="width:100%">
		
		<h4 class="alert_info">Welcome to the Family Health Panel </h4>
		
		<article class="module width_3_quarter">
		<header><h3 class="tabs_involved">TOKEN UPDATE</h3>
		
		</header>

		<div class="tab_container">
			<div id="tab1" class="tab_content">
                            <form method="POST" name="token_edit.php" action="<?php $_SERVER['PHP_SELF']; ?>" >
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
   				<td><label for="Normal token one">NORMAL TOKEN ONE</label></td> 
    				<td><input type="text" name="normal_token_one" value="<?php echo $normaltokenone ;?>"></td>     				
				</tr>
			</tbody> 
			<tbody> 
				<tr> 
                                <td><label for="Normal token one price">NORMAL TOKEN ONE PRICE</label></td> 
    				<td><input type="text" name="normal_token_one_price" value="<?php echo $normaltokenoneprice;?>"></td>     				
				</tr>
			</tbody> 
			<tbody> 
				<tr> 
   					<td><label for="Normal token two">NORMAL TOKEN TWO</label></td> 
    				<td><input type="text" name="normal_token_two" value="<?php echo $normaltokentwo;?>"></td>     				
				</tr>
			</tbody> 
			<tbody> 
				<tr> 
   				<td><label for="Normal token two price">NORMAL TOKEN TWO PRICE</label></td> 
    				<td><input type="text" name="normal_token_two_price" value="<?php echo $normaltokentwoprice;?>"></td>     				
				</tr>
			</tbody> 
			<tbody> 
                        <tr> 
                        <td><label for="Normal token three">NORMAL TOKEN THREE</label></td> 
                        <td><input type="text" name="normal_token_three"  value="<?php echo $normaltokenthree;?>"></td>
                        </tr>
			</tbody>
			<tbody> 
                        <tr> 
                        <td><label for="Normal token three price">NORMAL TOKEN THREE PRICE</label></td> 
                        <td><input type="text" name="normal_token_three_price"  value="<?php echo $normaltokenthreeprice;?>"></td>
                        </tr>
			</tbody>
			<tbody> 
                        <tr> 
                        <td><label for="Monthly token one">MONTHLY TOKEN ONE</label></td> 
                        <td><input type="text" name="monthly_token_one"  value="<?php echo $monthlytokenone;?>"></td>
                        </tr>
			</tbody>
			<tbody> 
                        <tr> 
                        <td><label for="Monthly token one price">MONTHLY TOKEN ONE PRICE</label></td> 
                        <td><input type="text" name="monthly_token_one_price"  value="<?php echo $monthlytokenoneprice;?>"></td>
                        </tr>
			</tbody>
			<tbody> 
                        <tr> 
                        <td><label for="Monthly token two">MONTHLY TOKEN TWO</label></td> 
                        <td><input type="text" name="monthly_token_two"  value="<?php echo $monthlytokentwo;?>"></td>
                        </tr>
			</tbody>
			<tbody> 
                        <tr> 
                        <td><label for="Monthly token two price">MONTHLY TOKEN TWO PRICE</label></td> 
                        <td><input type="text" name="monthly_token_two_price"  value="<?php echo $monthlytokentwoprice;?>"></td>
                        </tr>
			</tbody>
			<tbody> 
                        <tr> 
                        <td><label for="Monthly token three">MONTHLY TOKEN THREE</label></td> 
                        <td><input type="text" name="monthly_token_three"  value="<?php echo $monthlytokenthree;?>"></td>
                        </tr>
			</tbody>
			<tbody> 
                        <tr> 
                        <td><label for="Monthly token three price">MONTHLY TOKEN THREE PRICE</label></td> 
                        <td><input type="text" name="monthly_token_three_price"  value="<?php echo $monthlytokenthreeprice;?>"></td>
                        </tr>
			</tbody>
			<tbody> 
                        <tr> 
                        <td><label for="message">MESSAGE</label></td> 
                        <td><textarea style="width: 500px; height: 150px;" name="message"><?php echo $message;?></textarea></td>
                        </tr>
			</tbody>
			<tbody> 
                        <tr> 
                        <td><label for="free token value">FREE TOKEN VALUE</label></td> 
                        <td><input type="text" name="free_token_value"  value="<?php echo $freetokenvalue;?>"></td>
                        </tr>
			</tbody>
			<tbody> 
                        
			</tbody>
			
			
			<tbody> 
			<tr>
				<td align="center" colspan="2"><input type="submit" name="save" value="Update"> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
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


</body>

</html>
