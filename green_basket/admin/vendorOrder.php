<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
define('PAGENAME', 'vendorOrderpage', true);
require_once 'include/config.php'; // require or include, config.php from include folder
require_once 'include/header.php'; // require or include, header.php from include folder
$vendor_id  =   $_REQUEST['v_id']; // get vendor_id from viewvendor.php page
// get vendor shop name from vendor_signup table
$vendor_shop_name_sql = mysql_query("SELECT vendor_shop_name FROM vendor_signup where vendor_id='".$vendor_id."'");
while($result_shop_name=mysql_fetch_array($vendor_shop_name_sql))  //carry on looping through while there are records
 {
	 $vendor_shop_name=$result_shop_name['vendor_shop_name'];
}
// get order date, time and customer email id from payment_details and customer_signup table
   $payment_details_sql =mysql_query("SELECT p.customer_id,  p.total_payments, p.payment_date_time, c.customer_email from payment_details p "
						."inner join customer_signup c on c.customer_id=p.customer_id where p.vendor_id='".$vendor_id."'");
// get vendor every month total order amount from payment_details table
  $amount_sql=mysql_query("SELECT SUM(total_payments) as s, DATE_FORMAT(payment_date_time, '%Y-%M') as m FROM payment_details where vendor_id='".$vendor_id."' GROUP BY DATE_FORMAT(payment_date_time, '%Y-%m')");
?>
<link rel="stylesheet" href="css/flip_switch.css" type="text/css" media="screen" />
<script src="js/jquery.js"></script>
 <section id="main" class="column">		
		<h4 class="alert_info">Welcome to the GreenBasket admin panel </h4>		
		<article class="module width_3_quarter" style="width: 100%;float:left;">
		<header><h3 class="tabs_involved" id="vendor-order-details">Order Details for < <?php echo $vendor_shop_name;  ?> ></h3>		
                </header>    <!-- end of #tabs_involved -->		                                      
                <div id="tab2" class="tab_content">
			<table class="tablesorter" cellspacing="0"> 
			<thead> 
				<tr> 
					<th>Order Date</th> 				
    				<th>Order Time</th> 
    				<th>Customer email</th> 
					<th>Order Value</th> 
				</tr> 
				</thead> 
				<tbody id="txtHint" class="table-body">
                    <?php
                            $countrecord    =   0;
                            $i=1;
                            while($result=mysql_fetch_array($payment_details_sql))  //carry on looping through while there are records
                                {
									
                             $order_date= date('F dS  Y',strtotime($result['payment_date_time']));
                            $order_time= date('h:ia',strtotime($result['payment_date_time']));
                                echo "<tr class='".$countrecord."'> 
                                <td>".$order_date ."</td> 
								<td>".$order_time."</td> 
                                <td>".$result['customer_email']."</td> 
                                <td>Rs. ".$result['total_payments']."/-</td>
                                 
								</tr>"; 
								$i++;
								}
								?>   								        			
			</tbody> 
			</table> <!-- end of table -->		                         
			</div><!-- end of #tab2 -->		
		</article><!-- end of content manager article -->			
					<article class="module width_3_quarter" style="width: 50%;float:left;">		
                <div id="tab2" class="tab_content">
			<table class="tablesorter" cellspacing="0"> 
			<thead> 
				<tr> 
					<th>Month</th> 				
    				<th>Total Order Amount</th> 
				</tr> 
				</thead> 
								<tbody>
                    <?php
                            $countrecord    =   0;
                            $i=1;
                            while($total_amount=mysql_fetch_array($amount_sql))  //carry on looping through while there are records
                                {
                             $order_month= date('F Y',strtotime($total_amount['m']));
                                  echo "<tr class='".$countrecord."'> 
                                  <td>".$order_month."</td> 
                                <td>".$total_amount['s']."/-</td>                                 
								</tr>"; 
								$i++;
								}
								?>							        			
			</tbody> 
			</table> <!-- end of table -->		                         
			</div><!-- end of #tab2 -->		
		</article><!-- end of content manager article -->		
		<div class="clear"></div>		
		<div class="spacer"></div>
	</section> <!-- end of section -->		                         
	</body>
</html>
