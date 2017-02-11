<?php
define('PAGENAME', 'homepage', true);
//error_reporting(1);
require_once 'include/header.php';
require_once 'FYMasterScript.php';
if(isset($_POST['add_customer'])){
    
    //print_r($_POST);
    $companyname = $_POST['companyname'];
    $address   =   $_POST['address'];
    $email     =   $_POST['email'];
    $password  =   $_POST['password'];
    $username  =   $_POST['username'];
    $phoneno   =   $_POST['phoneno'];
    $country   =   $_POST['country'];
    $state     =   $_POST['state'];
    $city      =   $_POST['city'];
    $currency   =   $_POST['currency'];
    $spread     =   $_POST['Spread Format'];
    $carton     =   $_POST['Carton'];
    $book       =   $_POST['Book Format'];  
    $ncr        =   $_POST['NCR'];
    $calendar   =   $_POST['Calendar']; 
    $other       =   $_POST['Other'];   
    $stationary =   $_POST['Stationary'];
    
    $TypeOfApplication =   'Android';
    $ForInternetApp    =   'Android';
    $IMEINO      =  $_POST['IMEINO'];
    // store product name in array
    $productnamearray   =   array();
    if($spread == 1){
        
       $productnamearray[] =  'Spread Format';
    }
     if($carton == 1){
        
       $productnamearray[] =  'Carton';
    }
     if($book == 1){
        
       $productnamearray[] =  'Book Format';
    }
     if($ncr == 1){
        
       $productnamearray[] =  'NCR';
    }
     if($calendar == 1){
        
       $productnamearray[] =  'Calendar';
    }
     if($other == 1){
        
       $productnamearray[] =  'Other';
    }
     if($stationary == 1){
        
       $productnamearray[]=  'Stationary';
    }
     //print_r($productstring);
    //$productstring = implode(',',$productnamearray);
    
    // end product name 
    if($companyname == "" || $email == ""){
        $errormsg   =   "All field are require";
    
    }
   else{
        
       $checkusername       =   "select UserId from EasePrintMaster.dbo.UserMaster where UserName= '$username'";
       $executecheckquery   =   mssql_query($checkusername);   
       $CountUserId         =   mssql_num_rows($executecheckquery);
       if( $CountUserId > 0){
         echo '<script type="text/javascript">alert("Username already exits.");</script>'; // $errormsg    =   "Username already exits.";
       }
       else{
       $lala    =   'USP_Admin_Generator';
       
       $loadproc    = mssql_init($lala);
    
                    mssql_bind($loadproc, '@pCompanyName',$companyname,SQLVARCHAR,false,false,50);
                    mssql_bind($loadproc, '@pAddress',$address,SQLVARCHAR,false,false,50);
                    mssql_bind($loadproc, '@pCity',$city,SQLVARCHAR,false,false,50);
                    mssql_bind($loadproc, '@pState',$state,SQLVARCHAR,false,false,50);
                    mssql_bind($loadproc, '@pCountry',$country,SQLVARCHAR,  false,false,  50);
                    mssql_bind($loadproc, '@pCurrencyName',$currency,SQLVARCHAR,false,  false,  50);
                    mssql_bind($loadproc, '@pPhoneNo',$phoneno,SQLVARCHAR,false,false,  50);
                    mssql_bind($loadproc, '@pEmailId',$email,SQLVARCHAR,false,false,50);
                    mssql_bind($loadproc, '@pTypeOfApplication',$TypeOfApplication,SQLVARCHAR,false,false,50);
                    mssql_bind($loadproc, '@pForInternetApp',$ForInternetApp,SQLVARCHAR,false,false,50);
                    mssql_bind($loadproc, '@pUserName',$username,SQLVARCHAR,false,false,50);
                    mssql_bind($loadproc, '@pUPassword',$password,SQLVARCHAR,false,false,50);
                    
                   $executeproc   = mssql_execute($loadproc);
			 if($executeproc == 1){
				 
				 $sucessmsg	=   "Registration has been successfully";
                               
                               $orignalname = $companyname;
                               $companyname = str_replace(' ','',$companyname);
                               $tenstring = substr($companyname, 0, 10);
                               $CompanyDbName =  $tenstring.'_'.date("Y").'_'.date('Y', strtotime('+1 year'));;
                                  
                                  
                                 $CompanyDb =   "CREATE DATABASE $CompanyDbName";
                                $executecompanydb    =    mssql_query($CompanyDb);
                                if($executecompanydb == true){
                                    $companyconnect    = mssql_connect($myServer,$myUser,$myPass);
                                    if($companyconnect){

                                   $selectdb= mssql_select_db($CompanyDbName,$companyconnect);
                                     ESTIMATION_TAB($companyconnect);
                                     FYScriptSQL($companyconnect);
                                     FYProcScript($companyconnect);
                                     FYScriptViewStatment($companyconnect);
                                     FYFunction($companyconnect);
                                     
                                    $GetLastCompanyId  =   "select CompanyID from EasePrintMaster.dbo.EaseDatabaseOwner where CompanyName ='$orignalname'";
                                    $GetLastCompanyIdexe    = mssql_query($GetLastCompanyId);
                                    $fetchCompanyId    = mssql_fetch_array($GetLastCompanyIdexe);
                                    $FetchId   =    $fetchCompanyId['CompanyID'];
                                    mssql_query("update EasePrintMaster.dbo.LicenseForSoftware set LicenseRefNo='$IMEINO' where CompanyDetailedID = $FetchId");
                                    $databasename   =   $CompanyDbName.'.dbo.ProductMaster';
                                 for($countarray = 0 ;$countarray < count($productnamearray);$countarray++){
                                    $updateproduct   =   "update $databasename set IsDel=1 
                                        where ProductName = '$productnamearray[$countarray]'";
                                
                                    $updateproducte  = mssql_query($updateproduct);
                                  }
                                    
                                  
$bindinginsert  =  "INSERT INTO Book_Binding_Type (BBindingType) VALUES('Book Folding')
                    INSERT INTO Book_Binding_Type (BBindingType) VALUES('Book Gathering')
                    INSERT INTO Book_Binding_Type (BBindingType) VALUES('Book Tipping')
                    INSERT INTO Book_Binding_Type (BBindingType) VALUES('Book Sewing')
                    INSERT INTO Book_Binding_Type (BBindingType) VALUES('End Paper Pasting')
                    INSERT INTO Book_Binding_Type (BBindingType) VALUES('Galley Fitting')
                    INSERT INTO BindingMaster (BindingType,UOMID) VALUES('Center Stitch','4')
                    INSERT INTO BindingMaster (BindingType,UOMID) VALUES('Perfect Binding','4')
                    INSERT INTO BindingMaster (BindingType,UOMID) VALUES('Spiral','5')
                    INSERT INTO BindingMaster (BindingType,UOMID) VALUES('Wiro','4')
                    INSERT INTO BindingMaster (BindingType,UOMID) VALUES('Gluing','4')
                    INSERT INTO BindingMaster (BindingType,UOMID) VALUES('Tim Rimming','4')
                    INSERT INTO BindingMaster (BindingType,UOMID) VALUES('Sewing & Perfect Binding','4')
                    INSERT INTO BindingMaster (BindingType,UOMID) VALUES('Sewing & Case Binding','4')
                    INSERT INTO Book_Binding_Unit (BBindingUnitName,BUnitValue) VALUES('per fold per thousand','1000')
                    INSERT INTO Book_Binding_Unit (BBindingUnitName,BUnitValue) VALUES('per form per thousand','1000')
                    INSERT INTO Book_Binding_Unit (BBindingUnitName,BUnitValue) VALUES('per unit qty','1')
                    INSERT INTO Book_Binding_Unit (BBindingUnitName,BUnitValue) VALUES('per thoushand','1000')
                    INSERT INTO Book_Binding_Unit (BBindingUnitName,BUnitValue) VALUES('per size per book','1')
                    INSERT INTO Book_Binding_Unit (BBindingUnitName,BUnitValue) VALUES('Per Page','1')
                    INSERT INTO PlateTypeMaster VALUES ('Wipe On',0)
                    INSERT INTO PlateTypeMaster VALUES ('D.E',0)
                    INSERT INTO PlateTypeMaster VALUES ('P.S',0)
                    INSERT INTO PlateTypeMaster VALUES ('Polyester',0)
                    INSERT INTO PlateTypeMaster VALUES ('CTP',0)
                    INSERT INTO PlateTypeMaster VALUES ('CTCP',0)
                    INSERT INTO FilmTypeMaster VALUES ('Camera', 0,1,1)
                    INSERT INTO FilmTypeMaster VALUES ('Image Setter',0,2,0)";

                    $executeinsert = mssql_query($bindinginsert); 
                                  
                                    }
                                     else {
                                      echo $CompanyDbName.' database not connect';    
                                    }
                                
                                    
                                }
			 }
			 else{
			 $errormsg	=	"Registration not successfully";
			 
                        }
    }
    }
}
if(isset($_POST['cancel'])){
    

}
?>
<script type="text/javascript" src="js/jquery-form.validate.js"></script>
<script type="text/javascript">
$(document).ready(function(){
$('#createuser').validate(
 {
  rules: {
    companyname: {
      minlength: 2,
      required: true
    },
    address: {
        minlength: 2,
      required: true
	  
    },
     email: {
      required: true,
      email: true
    },
    password: {
      minlength: 2,
      required: true
	  
    },
    cpassword: {
      minlength: 2,
      required: true
	  
    },
    username: {
        minlength: 2,
      required: true
	  
    },
    phoneno: {
      digits: true,
	  maxlength:14,
	  minlength: 10,
      required: true
    },
   country: {
        minlength:2,
      required: true
    },
    state: {
        minlength:2,
      required: true
    },
    city: {
        minlength:2,
      required: true
    },
    IMEINO: {
        minlength:2,
      required: true
    },
  },
  highlight: function(element) {
    $(element).closest('.control-group').removeClass('success').addClass('error');
  },
  success: function(element) {
    element
    .text('OK!').addClass('valid')
    .closest('.control-group').removeClass('error').addClass('success');
  }
 });
}); // end document.ready

</script>
	<section id="main" class="column" style="width:100%">
		
		<h4 class="alert_info">Accordion Panel </h4>
		
		<article class="module width_3_quarter" style="margin: 0px 395px;float:left;width: 49%;">
		<header><h3 class="tabs_involved">CUSTOMERS Registration</h3>
		
		</header>
                   <form method="POST" name="createuser" action="<?php $_SERVER['PHP_SELF']; ?>" id="createuser"> 
		<div class="tab_container">
			<div id="tab1" class="tab_content">
			<table class="tablesorter" cellspacing="0"> 
			<tbody> 
                            <?php
                            
			if($errormsg != ""){
			echo '<tr>
				<td style="color:red;">'.$errormsg.'</td>
				</tr>';
                            }
			if($sucessmsg != ""){
			echo '<tr>
				<td style="color:green;">'.$sucessmsg.'</td>
				</tr>';
                            }
                            
                                
                           ?>
                            <tr> 
   				<td><label for="companyname">Company:</label></td> 
    				<td><input type="text" name="companyname" id="companyname" value=""></td>     				
				</tr>
			 </tbody>
                            <tbody>
                            <tr> 
   				<td><label for="username">Username:</label></td> 
    				<td><input type="text" name="username" id="username" value=""></td>     				
				</tr>
                            </tbody> 
                            <tbody>
                            <tr> 
   				<td><label for="password">Password:</label></td> 
    				<td><input type="password" name="password" id="password" value=""></td>     				
				</tr>
                            </tbody> 
                            <tbody> 
				<tr> 
                                <td><label for="cpassword">Confirm Password :</label></td> 
    				<td><input type="password" name="cpassword" id="cpassword" value=""></td>     				
				</tr>
			</tbody>
			<tbody> 
                            
				<tr> 
                                <td><label for="email">E-mail Id:</label></td> 
    				<td><input type="text" name="email" id="email" value=""></td>     				
				</tr>
			</tbody>
                        <tbody> 
				<tr> 
                                <td><label for="country">Country:</label></td> 
    				<td><input type="text" name="country" id="country" value=""></td>     				
				</tr>
			</tbody>
                        
			<tbody> 
				<tr> 
                                <td><label for="state">State:</label></td> 
    				<td><input type="text" name="state" id="state" value=""></td>     				
				</tr>
			</tbody> 
			<tbody> 
				<tr> 
   					<td style="border-bottom:none"><label for="city">City:</label></td> 
    				<td style="border-bottom:none"><input type="text" name="city" id="city" value=""></td>
					 
					   				
				</tr>
			</tbody> 
                        <tbody> 
				<tr> 
                                <td style="border-bottom:none"><label for="currency">Currency:</label></td> 
    				<td style="border-bottom:none">
                                    <select  name="currency" id="currency">
                                         <option value="Indian Rupee-(Rs.)">Indian Rupee-(Rs.)</option>
                                        <option value="Bangladeshi Taka-(BDT)">Bangladeshi Taka-(BDT)</option>
                                           <option value="Euro-(€)">Euro-(€)</option>
                                              <option value="Ghana Cedi-(¢)">Ghana Cedi-(¢)</option>
                                                <option value="Kenyan Shilling-(KSh)">Kenyan Shilling-(KSh)</option>
                                                       <option value="Malaysian Ringgit-(RM)">Malaysian Ringgit-(RM)</option>
                                                         <option value="Nepal Rupee-(Rs.)"> Nepal Rupee-(Rs.)</option>
                                                          <option value="Sri Lanka Rupee-(Rs.)">Sri Lanka Rupee-(Rs.)</option>
                                                           <option value="Tanzanian Shilling-(TZS)">Tanzanian Shilling-(TZS)</option>
                                                           <option value="UAE Dirham-(AED)"> UAE Dirham-(AED)</option>
                                                           <option value="Uganda Shilling-(UGX)">Uganda Shilling-(UGX)</option>
                                                           <option value="US Doller-($)">US Doller-($)</option>
                                    </select>
                                    
                                </td>
					 
					   				
				</tr>
			</tbody> 
                        <tbody> 
				<tr> 
   				<td style="border-bottom:none"><label for="phoneno">Phone No:</label></td> 
    				<td style="border-bottom:none"><input type="text" name="phoneno" id="phoneno" value=""></td>
					 
					   				
				</tr>
			</tbody> 
                         <tbody> 
				<tr> 
   				<td><label for="address">Address:</label></td> 
    				<td><input type="text" name="address" id="address" value=""></td>     				
				</tr>
			</tbody> 
                        
                             <tbody> 
				<tr> 
   				<td><label for="address">IMEI No:</label></td> 
    				<td><input type="text" name="IMEINO" id="IMEINO" value=""></td>     				
				</tr>
			</tbody> 
			<tbody> 
				<tr> 
                                        <td><input type="checkbox" value="1" name='NCR'<?php if($_POST['ncr']== 1){echo 'checked="checked"';}?>>
                                            <label for="name">NCR</label></td> 
    				<td><input type="checkbox" value="1" name="Other"<?php if($_POST['other']== 1){echo 'checked="checked"';}?>>
                                    <label for="name">OTHER</label></td> 				
				</tr>
				<tr> 
   					<td><input type="checkbox" value="1" name="Calendar"<?php if($_POST['calander']== 1){echo 'checked="checked"';}?>>
                                            <label for="name">CALENDER</label></td> 
    				<td><input type="checkbox" value="1" name="Spread Format"<?php if($_POST['spread']== 1){echo 'checked="checked"';}?>>
                                    <label for="name">SPREAD</label></td> 				
				</tr>
				<tr> 
   				<td><input type="checkbox" value="1" name="Carton"<?php if($_POST['carton']== 1){echo 'checked="checked"';}?> >
                                    <label for="name">CARTON</label></td> 
    				<td>
                                    <input type="checkbox" value="1" name="Book Format"<?php if($_POST['book']== 1){echo 'checked="checked"';}?>>
                                    <label for="name">BOOK</label></td> 				
				</tr>
				<tr> 
   					<td><input type="checkbox" value="1" name="Stationary"<?php if($_POST['stationary']== 1){echo 'checked="checked"';}?>>
                                           <label for="name">STATIONARY</label></td> 
    					<td></td> 
				</tr>
				</tbody> 
				<tbody> 
				<tr> 
   			<td colspan="2" align="center"><input type="submit" value="Create" name="add_customer" id="add_customer">
                            <input type="submit" value="Cancel" name="cancel" id="cancel"></td> 
					   		
					   				
				</tr>
			</tbody> 
			
			</table>
			</div><!-- end of #tab1 -->
			
		</div><!-- end of .tab_container -->
                   </form> <!--  end form -->
		
		</article><!-- end of content manager article -->
		
		<div class="clear"></div>
		
		<div class="spacer"></div>
	</section>



</body>

</html>
