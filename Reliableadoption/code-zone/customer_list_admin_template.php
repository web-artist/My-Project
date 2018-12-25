<?php
/*
Template Name: Customer List admin Template
*/
?>


<?php

include "header-admin.php";

global $user_ID;
//get_currentuserinfo();
?>	
<link rel="stylesheet" href="/wp-content/themes/doug/css/redmond/jquery-ui-1.8.23.custom.css" />	
<script type="text/javascript" src="/wp-content/themes/doug/jquery.dataTables.min.js"></script>	
<script type="text/javascript">		
    jQuery(function() {			
        jQuery('#tblCustomers').dataTable({				
            bJQueryUI: true,				
            "sPaginationType" : "full_numbers",				
            "aaSorting" : [[3, "desc"]],				
            "aoColumns" : [null,{ "bSortable" : false },null,null,{ "bSortable" : false }]
        });
    });	
</script>	
<div class="homepage"><?php the_title(); ?><a href="<?php bloginfo('url'); ?>/home-page" class="main_link">Home</a></div>
<div class="scrool">				
<div class="order_in">
<?php //echo do_shortcode('[userlist]'); ?>

<h1><?php //the_title(); ?></h1>
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="xTab1" id="tblCustomers">

<thead>

<tr>

<th>Customer</th>

<th class="sortless">Phone Number</th>

<th>Email</th>

<th class="dateFormat-ddmmyyyy">Date/Time Registered</th>

<th class="sortless">Customer Report</th>

</tr>

</thead>

<tbody>
<?php $query    = get_users();
	
		foreach($query as $user_list) {
	?>
<tr>

<td><?php echo $user_list->user_nicename; ?></td>

<td><?php echo get_user_meta($user_list->ID, "phone", true); ?></td>

<td><?php echo $user_list->user_email; ?></td>

<td><?php echo $user_list->user_registered; ?></td>

<td><a href="/customer-report/?usrid=<?php echo $user_list->ID; ?>">Customer Report</a></td>


</tr>


<?php }?>
</tbody>

</table> 										
	 
	 <div class="bspacing"></div>

	 
	 </div>	</div>	


    
</div> </div> </div></div>	

<style type="text/css">	
    .page-numbers {
    list-style-type: none;
}
.page-numbers li {
    display: inline-block;
	margin: 15px 11px 0 0px;
}
.page-numbers li .current {
   background: #00aae8;
   padding: 3px 8px;
   zcolor: white;
}
	
    .dataTable .even td {			
        background-color:#eaf4fd;		
    }		
    .DataTables_sort_icon {			
        float:left;		
    }		
    .dataTables_filter {			
        float:right;		
    }		
    .dataTables_length {			
        float:left;		
    }		
    .paging_full_numbers {			
        text-align:center;		
    }		
    .paging_full_numbers a {			
        padding:0px 2px 0px 2px;			
        margin:0px 2px 0px 2px !important;		
    }	
</style>

</body></html>