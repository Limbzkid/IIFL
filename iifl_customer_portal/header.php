<?php //echo $_SERVER['REQUEST_URI'];

	$lastSegment = basename(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));
	$lastSegment = str_replace('-', '_', $lastSegment);
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <title>IIFL</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1,  user-scalable = no"/>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link href="http://10.132.150.2:9001/iifl_customer_portal/images/favicon.ico" rel="shortcut icon" type="image/x-icon"/>
		<link rel="stylesheet" href="http://10.132.150.2:9001/iifl_customer_portal/styles/jquery-ui.css">
    <link rel="stylesheet" href="http://10.132.150.2:9001/iifl_customer_portal/styles/style.css" type="text/css" />
		<script type="text/javascript" src="http://10.132.150.2:9001/iifl_customer_portal/scripts/jquery-1.11.3.min.js"></script>
		<script type="text/javascript" src="http://10.132.150.2:9001/iifl_customer_portal/scripts/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="http://10.132.150.2:9001/iifl_customer_portal/scripts/jquery-accordion-menu.js"></script>
    <script type="text/javascript" src="http://10.132.150.2:9001/iifl_customer_portal/scripts/highcharts.js"></script>
		<script type="text/javascript" src="http://10.132.150.2:9001/iifl_customer_portal/scripts/jquery-ui.min.js"></script>
		<script type="text/javascript" src="http://10.132.150.2:9001/iifl_customer_portal/scripts/modernizr.js"></script>
		<script type="text/javascript" src="http://10.132.150.2:9001/iifl_customer_portal/scripts/common.js"></script>
    <script type="text/javascript" src="http://10.132.150.2:9001/iifl_customer_portal/scripts/custom.js"></script>	
    <!--[if IE]><!-->
    <!--<![endif]-->
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body class="<?php echo $lastSegment; ?>">
    <!--wrapper start-->
    <div id="wrapper">
      <!--outer wrapper start-->
      <div class="outer-wrapper">
        <!--inner wrapper start-->
        <div class="inner-wrapper">
           <!--left section start-->
           <div class="left_section">
              <div class="iifl_logo"><a href="javascript:;"><img src="http://10.132.150.2:9001/iifl_customer_portal/images/iifl_logo.jpg" alt="IIFL"/></a></div>
              <div class="search"><input type="text" name="search" value="search" onBlur="clearText(this)" onFocus="clearText(this)"/></div>
           </div>
           <!--left section end-->

           <!--right section start-->
           <div class="right_section">
              <div class="contact_us"><a href="javascript:;"><span class="contact_icon"></span>Contact Us</a></div>
              <div class="faq"><a href="javascript:;"><span class="faq_icon"></span>FAQ</a></div>
              <div class="user_welname">
                <div class="user_img"><img src="http://10.132.150.2:9001/iifl_customer_portal/images/user_icon.png" alt="IIFL"/></div>
                <div class="user_name">Welcome Harish
                  <div id="account_info">
                    <a href="profile">Profile</a>
                    <a href="change-password">Change Password</a>
                    <a href="javascript:;">Info three</a>
                  </div>
                </div>
              </div>
              <div class="setting"><a class="setting_icon" href="javascript:;"></a></div>
           </div>
            <!--right section end-->
        </div>
        <!--inner wrapper end-->
    </div>
    <!--outer wrapper end-->

    <!--outer wrapper start-->
    <div class="outer-wrapper menubg">
    <!--inner wrapper start-->
        <div class="inner-wrapper">
        <!--menu new start-->
        <a class="mobile" href="javascript:;">&#9776;</a>
        <?php include("main_menu.php"); ?>
        </div>
        <!--inner wrapper end-->
    </div>
    <!--outer wrapper end-->