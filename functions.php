<?php
#GLOBAL VARIABLES
$PartnersNumber=0;
$PrizesNumber=0;
$PresentersNumber=0;
$Presenters = array();
$Partners = array();
$about = 1;
$Prizes = array();


date_default_timezone_set('EUROPE/WARSAW');

function getPartnersNumber()
{
	global $PartnersNumber;
	return $PartnersNumber;
}
function getPresentersNumber()
{
	global $PresentersNumber;
	return $PresentersNumber;
}
function getPrizesNumber()
{
	global $PrizesNumber;
	return $PrizesNumber;
}
function main()
{

	setPartnersNumber();
	setPrizesNumber();
	setPresentersNumber();
	setPresenters();
	setPartners();
	setPrizes();
}
function setPartnersNumber()
{
	global $PartnersNumber;
	$conn=ConnectToSQLDB();
	$query="SELECT * FROM Itad.Partners";
	$params = array();
	$options =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET );
	$table=sqlsrv_query($conn,$query, $params, $options); 
	if($table == false)
	{
		die(print_r(sqlsrv_errors(),true));
		
	}
	$row_count = sqlsrv_num_rows( $table );
   
if ($row_count === false)
	{
		echo "Error in retrieveing row count.";
		$PartnersNumber=0;
	}
else
   $PartnersNumber = $row_count;
}

function setPresentersNumber()
{
	global $PresentersNumber;
	$conn=ConnectToSQLDB();
	$query="SELECT * FROM Itad.Presenters";
	$params = array();
	$options =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET );
	$table=sqlsrv_query($conn,$query, $params, $options); 
	if($table == false)
	{
		die(print_r(sqlsrv_errors(),true));
		
	}
	$row_count = sqlsrv_num_rows( $table );
   
if ($row_count === false)
	{
		echo "Error in retrieveing row count.";
		$PresentersNumber=0;
	}
else
   $PresentersNumber = $row_count;
}

function setPrizesNumber()
{
	global $PrizesNumber;
	$conn=ConnectToSQLDB();
	$query="SELECT * FROM Itad.Prizes";
	$params = array();
	$options =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET );
	$table=sqlsrv_query($conn,$query, $params, $options); 
	if($table == false)
	{
		die(print_r(sqlsrv_errors(),true));
		
	}
	$row_count = sqlsrv_num_rows( $table );
   
if ($row_count === false)
	{
		echo "Error in retrieveing row count.";
		$PrizesNumber=0;
	}
else
   $PrizesNumber = $row_count;
}
function getTableContent($name)
{
	$conn=ConnectToSQLDB();
	$query="SELECT * FROM Itad.".$name."";
	$params = array();
	$options =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET );
	$table=sqlsrv_query($conn,$query, $params, $options); 
	
	if($table == false)
	{
		die(print_r(sqlsrv_errors(),true));
		
	}
	
	$array = array();
	while($table1 = sqlsrv_fetch_array($table, SQLSRV_FETCH_ASSOC))
	{
		array_push($array, $table1);
	}
	
	return $array;
	
}
function getContentFromTable($what, $from, $Id)
{
	$conn=ConnectToSQLDB();
	
	$query ="SELECT ".$what." FROM Itad.".$from." WHERE Id = '".$Id."'";
	
	$params = array();
	$options =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET );
	$content=sqlsrv_query($conn,$query, $params, $options); 
	if($content == false)
	{
		die(print_r(sqlsrv_errors(),true));
		
	}
	while($row = sqlsrv_fetch_array($content, SQLSRV_FETCH_ASSOC))
	{
	return $row[$what];
	}
	
}

function getPartnersInfo()
{
	$table = getTableContent('Partners');
	$array = array();
	foreach($table as $row)
	{
	
		array_push($array, getPartnerInfo($row["Id"]));
	}
	
	
	return $array;
}
function getPresentersInfo()
{
	$table = getTableContent('Presenters');
	$array = array();
	foreach($table as $row)
	{
	
		array_push($array, getPresenterInfo($row["Id"]));
	}
	
	
	return $array;
}
function getPresenterImage($Id)
{
	return getContentFromTable('imageUri', 'Presenters', $Id);
	
}
function getPresenterName($Id)
{
	return getContentFromTable('FirstName', 'Presenters', $Id)." ".getContentFromTable('LastName', 'Presenters', $Id);
}
function getPresenterCompany($Id)
{
	return getContentFromTable('Company', 'Presenters', $Id);
}
function getPresneterDescritpion($Id)
{
	return getContentFromTable('Description', 'Presenters', $Id);
}
function getPartnerLogo($Id)
{
	return getContentFromTable('Logo', 'Partners', $Id);
}
function getPartnerName($Id)
{
	return getContentFromTable('Name', 'Partners', $Id);
}
function getAboutNumber()
{
	global $about;
	if($about==1)
		$about = 2;
	else
		$about = 1;
	return $about;
}
function getHorL()
{
	global $about;
	if($about==2)
		return'<div class="horL"></div>';
}

function getPartnerInfo($Id)
{



	$return='<div class="col-md-6">
						<div class="about'.getAboutNumber().'">
						<img class="pic1Ab" src="'.getPartnerLogo($Id).'">
							<h3>'.getPartnerName($Id).'</h3>
							<p>Nulla consectetur ornare nibh, a auctor mauris scelerisque eu proin nec urna quis justo adipiscing auctor ut auctor feugiat fermentum quisque eget pharetra, felis et venenatis. aliquam, nulla nisi lobortis elit ac.</p>
						</div>
					</div>'.getHorL();
	return $return;
}
function getPrizeName($Id)
{
	return getContentFromTable('Name', 'Prizes', $Id);
}
function getPrizes()
{
global $Prizes;
	$return="";
	$i=0;
	foreach($Prizes as $value)
		{

			$i++;	
			$return = $return." ".$value;
		}


	return $return;
}
function getPrizeInfo($Id)
{
	$return='<div class="col-md-4">
						<img src=""></img>
						<h4>'.getPrizeName($Id).'</h4>
						<!---<p>Nulla consectetur ornare nibh, a auctor mauris scelerisque eu proin nec urna quis justo adipiscing auctor ut auctor. feugiat </p>--->
					</div>';
	return $return;
}
function getPrizesInfo()
{
	$table = getTableContent('Prizes');
	$array = array();
	foreach($table as $row)
	{
	
		array_push($array, getPrizeInfo($row["Id"]));
	}
	
	
	return $array;
}

function setPrizes()
{
	global $Prizes;
	$Prizes = getPrizesInfo();
}

function  getPresenterInfo($Id)
{



	$return='<div class="col-md-4">
				
						<img class="img-responsive" src="'.getPresenterImage($Id).'">
						<h4>'.getPresenterName($Id).'</h4>
						<h5>'.getPresenterCompany($Id).'</h5>
						<p>'.getPresneterDescritpion($Id).'</p>
						<!---<ul>
							<li><a href="#"><i class="fa fa-facebook-square"></i></a></li>
							<li><a href="#"><i class="fa fa-pinterest"></i></a></li>
							<li><a href="#"><i class="fa fa-twitter" ></i></a></li>
							<li><a href="#"><i class="fa fa-google-plus-square"></i></a></li>
						</ul>--->
				</div>';
	return $return;
}

function setPresenters()
{
	global $Presenters;
	$Presenters = getPresentersInfo();
}
function setPartners()
{
	global $Partners;
	$Partners = getPartnersInfo();
}
function getPartners()
{
	global $Partners;
	$return="";
	$i=0;
	foreach($Partners as $value)
		{

			$i++;	
			$return = $return." ".$value;
		}


	return $return;
}
function getPresenters()
{
	global $Presenters;
	$return="";
	$i=0;
	foreach($Presenters as $value)
		{

			$i++;	
			$return = $return." ".$value;
		}


	return $return;
}
function ConnectToSQLDB()
{
 

$connectionInfo = array("UID" => "itad@cy6qzlygzd", "pwd" => "Haslo123", "Database" => "Itad_db", "LoginTimeout" => 30, "Encrypt" => 1);

$serverName = "tcp:cy6qzlygzd.database.windows.net,1433";

$conn = sqlsrv_connect($serverName, $connectionInfo);
if( $conn ) {
}else{
     echo "Connection could not be established.<br />";
     die( print_r( sqlsrv_errors(), true));
}
return $conn;
}
function getHeaderContent()
{
	$HeaderContent = '<title>Timber</title>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link rel="stylesheet" type="text/css" href="css/bootstrap.css">
		<link rel="stylesheet" type="text/css" href="css/font-awesome.css">
		<link rel="stylesheet" id="camera-css"  href="css/camera.css" type="text/css" media="all">

		<link rel="stylesheet" type="text/css" href="css/slicknav.css">
		<link rel="stylesheet" href="css/prettyPhoto.css" type="text/css" media="screen" title="prettyPhoto main stylesheet" charset="utf-8" />
		<link rel="stylesheet" type="text/css" href="css/style.css">
		
		
		<script type="text/javascript" src="js/jquery-1.8.3.min.js"></script>

		<link href=\'http://fonts.googleapis.com/css?family=Roboto:400,300,700|Open+Sans:700\' rel=\'stylesheet\' type=\'text/css\'>
		<script type="text/javascript" src="js/jquery.mobile.customized.min.js"></script>
		<script type="text/javascript" src="js/jquery.easing.1.3.js"></script> 
		<script type="text/javascript" src="js/camera.min.js"></script>
		<script type="text/javascript" src="js/myscript.js"></script>
		<script src="js/sorting.js" type="text/javascript"></script>
		<script src="js/jquery.isotope.js" type="text/javascript"></script>
		<!--script type="text/javascript" src="js/jquery.nav.js"></script-->
		

		<script>
			jQuery(function(){
					jQuery(\'#camera_wrap_1\').camera({
					transPeriod: 500,
					time: 3000,
					height: \'490px\',
					thumbnails: false,
					pagination: true,
					playPause: false,
					loader: false,
					navigation: false,
					hover: false
				});
			});
		</script>
		
		
		';
	return $HeaderContent;
}

function getBodyContent()
{
	$BodyContent = '<!--home start-->
    
    <div id="home">
    	<div class="headerLine">
	<div id="menuF" class="default">
		<div class="container">
			<div class="row">
				<div class="logo col-md-4">
					<div>
						<a href="#">
							<img src="images/logo.png">
						</a>
					</div>
				</div>
				<div class="col-md-8">
					<div class="navmenu"style="text-align: center;">
						<ul id="menu">
							<li class="active" ><a href="#home">Home</a></li>
							<li><a href="#about">About</a></li>
							<li><a href="#project">Projects</a></li>
							<li><a href="http://codeguru.geekclub.pl/kalendarium/podglad-wydarzenia/it-academic-day-2014---politechnika-wroclawska,10507" >Rejestruj</a></li>
							<li class="last"><a href="#contact">Contact</a></li>
							<!--li><a href="#features">Features</a></li-->
						</ul>
					</div>
				</div>
			</div>
		</div>
	</div>
		<div class="container">
			<div class="row wrap">
				<div class="col-md-12 gallery"> 
						<div class="camera_wrap camera_white_skin" id="camera_wrap_1">
							<div data-thumb="" data-src="images/slides/blank.gif">
								<div class="img-responsive camera_caption fadeFromBottom">
									<h2>We listen.</h2>
								</div>
							</div>
							<div data-thumb="" data-src="images/slides/blank.gif">
								<div class="img-responsive camera_caption fadeFromBottom">
									<h2>We discuss.</h2>
								</div>
							</div>
							<div data-thumb="" data-src="images/slides/blank.gif">
								<div class="img-responsive camera_caption fadeFromBottom">
									<h2>We develop.</h2>
								</div>
							</div>
						</div><!-- #camera_wrap_1 -->
				</div>
			</div>
		</div>
	</div>
		<div class="container">
			<div class="row">
				<div class="col-md-4 project">
					<h3 id="counter">0</h3>
					<h4>Nasze projekty</h4>
					<p>Dolor sit amet, consectetur adipiscing elit quisque tempus eget diam et lorem a laoreet phasellus ut nisi id leo molestie. </p>
				</div>
				<div class="col-md-4 project">
					<h3 id="counter1">0</h3>
					<h4>Nasi Partnerzy</h4>
					<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit quisque tempus eget diam et. laoreet phasellus ut nisi id leo.  </p>
				</div>
				<div class="col-md-4 project">
					<h3 id="counter2" style="margin-left: 20px;">0</h3>
					<h4 style="margin-left: 20px;">Nagrody</h4>
					<p>Consectetur adipiscing elit quisque tempus eget diam et laoreet phasellus ut nisi id leo molestie adipiscing vitae a vel. </p>
				</div>
			</div>
		</div>
		   
    </div>
    
    <!--about start-->    
    
    <div id="about">
    	<div class="line2">
			<div class="container">
				<div class="row Fresh">'
					.getPrizes().'		
				</div>
			</div>
		</div>
		<div class="container">
			<div class="row">
				<div class="col-md-12 wwa">
					<span name="about" ></span>
					<h3>Nasi prezenterzy!</h3>
					<h4>We listen, we discuss, we advise and develop. We love to learn and use the latest technologies.</h4>
				</div>
			</div>
		</div>
		<div class="container">
			<div class="row team">
							
			'.getPresenters().'
				
			</div>
		</div>
		<div class="container">
			<div class="row">
				<div class="col-md-12 hr1">
					<hr/>
				</div>
			</div>
		</div>		
			
		
		
		<div class="container">
			<div class="row aboutUs">
				<div class="col-md-12 ">
					<h3>Nasi partnerzy</h3>
				</div>
			</div>
		</div>
		
		<div style="position: relative;">
		
			<div class="container">
				<div class="row about">
				'.getPartners().'
				</div>
			</div>
		
			
		
					
		</div>
    </div>
    <!--project start    
    <div id="project">    	
		<div class="line3">
			<div class="container">
				<div id="project1" ></div>
				<div class="row Ama">
					<div class="col-md-12">
					<span name="projects" id="projectss"></span>
					<h3>Our Amazing Works</h3>
					<p>Right here we\'ve got something you gonna love</p>
					</div>
				</div>
			</div>
		</div>          
    
    
       <div class="container">
		
		<div class="row"> -->
		
			<!-- filter_block 
				<div id="options" class="col-md-12" style="text-align: center;">	
					<ul id="filter" class="option-set" data-option-key="filter">
						<li><a class="selected" href="#filter" data-option-value="*" class="current">All Works</a></li>
						<li><a href="#filter" data-option-value=".polygraphy">Polygraphy</a></li>
						<li><a href="#filter" data-option-value=".branding">Branding</a></li>
						<li><a href="#filter" data-option-value=".web">Web UI</a></li>
						<li><a href="#filter" data-option-value=".text_styles">Text Styles</a></li>
					</ul>
				</div>--><!-- //filter_block 
		
		
		
			<div class="portfolio_block columns3   pretty" data-animated="fadeIn">	
					<div class="element col-sm-4   gall branding">
						<a class="plS" href="images/prettyPhotoImages/pic1.jpg" rel="prettyPhoto[gallery2]">
							<img class="img-responsive picsGall" src="images/prettyPhotoImages/thumb_pic1.jpg" alt="pic1 Gallery"/>
						</a>
						<div class="view project_descr ">
							<h3><a href="#">Recycled Paper - Business Card Mock Up</a></h3>
							<ul>
								<li><i class="fa fa-eye"></i>215</li>
								<li><a class="heart" href="#"><i class="fa-heart-o"></i>14</a></li>
							</ul>
						</div>
					</div>
					<div class="element col-sm-4  gall branding">
						<a class="plS" href="images/prettyPhotoImages/pic2.jpg" rel="prettyPhoto[gallery2]">
							<img class="img-responsive picsGall" src="images/prettyPhotoImages/thumb_pic2.jpg" alt="pic2 Gallery"/>
						</a>
						<div class="view project_descr center">
							<h3><a href="#">Environment Logos Set</a></h3>
							<ul>
								<li><i class="fa fa-eye"></i>369</li>
								<li><a  class="heart" href="#"><i class="fa-heart-o"></i>86</a></li>
							</ul>
						</div>
					</div>
					<div class="element col-sm-4  gall web">
						<a class="plS" href="images/prettyPhotoImages/pic3.jpg" rel="prettyPhoto[gallery2]">
							<img class="img-responsive picsGall" src="images/prettyPhotoImages/thumb_pic3.jpg" alt="pic3 Gallery"/>
						</a>
						<div class="view project_descr ">
							<h3><a href="#">Beag Simple WEB UI</a></h3>
							<ul>
								<li><i class="fa fa-eye"></i>400</li>
								<li><a  class="heart" href="#"><i class="fa-heart-o"></i>124</a></li>
							</ul>
						</div>
					</div>
		
		
					
					<div class="element col-sm-4  gall  text_styles">
						<a class="plS" href="images/prettyPhotoImages/pic4.jpg" rel="prettyPhoto[gallery2]">
							<img class="img-responsive picsGall" src="images/prettyPhotoImages/thumb_pic4.jpg" alt="pic1 Gallery"/>
						</a>
						<div class="view project_descr ">
							<h3><a href="#">Pop Candy Text Effect</a></h3>
							<ul>
								<li><i class="fa fa-eye"></i>480</li>
								<li><a  class="heart" href="#"><i class="fa-heart-o"></i>95</a></li>
							</ul>
						</div>
					</div>
					<div class="element col-sm-4  gall  web">
						<a class="plS" href="images/prettyPhotoImages/pic5.jpg" rel="prettyPhoto[gallery2]">
							<img class="img-responsive picsGall" src="images/prettyPhotoImages/thumb_pic5.jpg" alt="pic1 Gallery"/>
						</a>
						<div class="view project_descr center">
							<h3><a href="#">User Interface Elements</a></h3>
							<ul>
								<li><i class="fa fa-eye"></i>215</li>
								<li><a  class="heart" href="#"><i class="fa-heart-o"></i>14</a></li>
							</ul>
						</div>
					</div>
					<div class="element col-sm-4  gall  polygraphy">
						<a class="plS" href="images/prettyPhotoImages/pic6.jpg" rel="prettyPhoto[gallery2]">
							<img class="img-responsive picsGall" src="images/prettyPhotoImages/thumb_pic6.jpg" alt="pic1 Gallery"/>
						</a>
						<div class="view project_descr ">
							<h3><a href="#">Stationery Branding Mock Up</a></h3>
							<ul>
								<li><i class="fa fa-eye"></i>375</li>
								<li><a  class="heart" href="#"><i class="fa-heart-o"></i>102</a></li>
							</ul>
						</div>
					</div>		
					<div class="element col-sm-4   gall branding">
						<a class="plS" href="images/prettyPhotoImages/pic7.jpg" rel="prettyPhoto[gallery2]">
							<img class="img-responsive picsGall" src="images/prettyPhotoImages/thumb_pic7.jpg" alt="pic1 Gallery"/>
						</a>
						<div class="view project_descr ">
							<h3><a href="#">Darko - Business Card Mock Up</a></h3>
							<ul>
								<li><i class="fa fa-eye"></i>440</li>
								<li><a  class="heart" href="#"><i class="fa-heart-o"></i>35</a></li>
							</ul>
						</div>
					</div>
					
					<div class="element col-sm-4  gall text_styles">
						<a class="plS" href="images/prettyPhotoImages/pic8.jpg" rel="prettyPhoto[gallery2]">
							<img class="img-responsive picsGall" src="images/prettyPhotoImages/thumb_pic8.jpg" alt="pic1 Gallery"/>
						</a>
						<div class="view project_descr ">
							<h3><a href="#">Foil Mini Badges</a></h3>
							<ul>
								<li><i class="fa fa-eye"></i>512</li>
								<li><a  class="heart" href="#"><i class="fa-heart-o"></i>36</a></li>
							</ul>
						</div>
					</div>
					
					<div class="element col-sm-4  gall polygraphy">
						<a class="plS" href="images/prettyPhotoImages/pic9.jpg" rel="prettyPhoto[gallery2]">
							<img class="img-responsive picsGall" src="images/prettyPhotoImages/thumb_pic9.jpg" alt="pic1 Gallery"/>
						</a>
						<div class="view project_descr ">
							<h3><a href="#">Woody Poster Text Effect</a></h3>
							<ul>
								<li><i class="fa fa-eye"></i>693</li>
								<li><a  class="heart" href="#"><i class="fa-heart-o"></i>204</a></li>
							</ul>
						</div>
					</div>			
			</div>
			
			
				
					<div class="col-md-12 cBtn  lb" style="text-align: center;">
						<ul class="load_more_cont ">
							<li class="dowbload btn_load_more">
								<a href="javascript:void(0);" >
									<i class="fa fa-arrow-down"></i>Load More Projects
								</a>
							</li>
							<li class="buy">
								<a href="#">
									<i class="fa fa-shopping-cart"></i>Buy on Themeforest
								</a>
							</li>
						</ul>
					</div>
			
		</div>
			
			<script type="text/javascript">
				jQuery(window).load(function(){
					items_set = [
					
						{category : \'branding\', lika_count : \'77\', view_count : \'234\', src : \'images/prettyPhotoImages/pic9.jpg\', title : \'Foil Mini Badges\', content : \'\' },
						
						{category : \'polygraphy\', lika_count : \'45\', view_count : \'100\', src : \'images/prettyPhotoImages/pic7.jpg\', title : \'Darko – Business Card Mock Up\', content : \'\' },
						
						{category : \'text_styles\', lika_count : \'22\', view_count : \'140\', src : \'images/prettyPhotoImages/pic8.jpg\', title : \'Woody Poster Text Effect\', content : \'\' }
						

					];
					jQuery(\'.portfolio_block\').portfolio_addon({
						type : 1, // 2-4 columns simple portfolio
						load_count : 3,
						
						items : items_set
					});
					$(\'#container\').isotope({
					  animationOptions: {
						 duration: 900,
						 queue: false
					   }
					});
				});
			</script>
		</div>
    </div>    
    -->
    <!--news start-->
    
    <div id="news">
    	<div class="line4">		
			
		</div>
		<div class="container">
		
		
		asasasa
		
				
			</div>
			
			
			
			
			
			<div class="container">
			
		</div>
    </div>
    
    
    <!--contact start-->
    
    <div id="contact">
    	<div class="line5">					
			<div class="container">
				<div class="row Ama">
					<div class="col-md-12">
					<h3>Got a Question? We&rsquo;re Here to Help!</h3>
					<p>Get in touch with us</p>
					</div>
				</div>
			</div>
		</div>
		<div class="container">
			<div class="row">
				<div class="col-md-9 col-xs-12 forma">
					<form>
						<input type="text" class="col-md-6 col-xs-12 name" name=\'name\' placeholder=\'Name *\'/>
						<input type="text" class="col-md-6 col-xs-12 Email" name=\'Email\' placeholder=\'Email *\'/>
						<input type="text" class="col-md-12 col-xs-12 Subject" name=\'Subject\' placeholder=\'Subject\'/>
						<textarea type="text" class="col-md-12 col-xs-12 Message" name=\'Message\' placeholder=\'Message *\'></textarea>
						<div class="cBtn col-xs-12">
							<ul>
								<li class="clear"><a href="#"><i class="fa fa-times"></i>clear form</a></li>
								<li class="send"><a href="#"><i class="fa fa-share"></i>Send Message</a></li>
							</ul>
						</div>
					</form>
				</div>
				<div class="col-md-3 col-xs-12 cont">
					<!--- <ul>
						<li><i class="fa fa-home"></i>5512 Lorem Ipsum Vestibulum 666/13</li>
						<li><i class="fa fa-phone"></i>+1 800 789 50 12, +1 800 450 6935</li>
						<li><a href="#"><i class="fa fa-envelope"></i>mail@compname.com</li></a>
						<li><i class="fa fa-skype"></i>compname</li>
						<li><a href="#"><i class="fa fa-twitter"></i>Twitter</li></a>
						<li><a href="#"><i class="fa fa-facebook-square"></i>Facebook</li></a>
						<li><a href="#"><i class="fa fa-dribbble"></i>Dribbble</li></a>
						<li><a href="#"><i class="fa fa-flickr"></i>Flickr</li></a>
						<li><a href="#"><i class="fa fa-youtube-play"></i>YouTube</li></a>
					</ul>--->
				</div>
			</div>
		</div>
		<div class="line6">
					
					<iframe src="https://www.google.com/maps/embed?pb=!1m14!1m12!1m3!1d2504.985212503921!2d17.059121999999995!3d51.10873300000003!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!5e0!3m2!1spl!2spl!4v1416258910705" width="100%" height="750" frameborder="0" style="border:0"></iframe>
		
		</div>																									
		
		<div class="line7">
			<div class="container">
				<div class="row footer">
					<br><br>
					<h3> Find us on social </h3>
					<div class="soc col-md-12">
						<ul>
							<li class="soc1"><a href="#"></a></li>
							<li class="soc2"><a href="#"></a></li>
							<li class="soc3"><a href="#"></a></li>
							<li class="soc4"><a href="#"></a></li>
							<li class="soc5"><a href="#"></a></li>
							<li class="soc6"><a href="#"></a></li>
							<li class="soc7"><a href="#"></a></li>
							<li class="soc8"><a href="#"></a></li>
							
						</ul>
					</div>
				</div>
			</div>
		</div>
		<div class="lineBlack">
			<div class="container">
				<div class="row downLine">
					<div class="col-md-12 text-right">
						<!--input  id="searchPattern" type="search" name="pattern" value="Search the Site" onblur="if(this.value==\'\') {this.value=\'Search the Site\'; }" onfocus="if(this.value ==\'Search the Site\' ) this.value=\'\';this.style.fontStyle=\'normal\';" style="font-style: normal;"/-->
						<input  id="searchPattern" type="search" placeholder="Search the Site"/><i class="glyphicon glyphicon-search" style="font-size: 13px; color:#a5a5a5;" id="iS"></i>
					</div>
					<div class="col-md-6 text-left copy">
						<p>Copyright &copy; 2014 Timber HTML Template. All Rights Reserved.</p>
					</div>
					
				</div>
			</div>
		</div>
    </div>		
		
		
	<script src="js/jquery.prettyPhoto.js" type="text/javascript" charset="utf-8"></script>
	<script src="js/bootstrap.min.js"></script>
	<script src="js/jquery.slicknav.js"></script>
	<script>
			$(document).ready(function(){
			$(".bhide").click(function(){
				$(".hideObj").slideDown();
				$(this).hide(); //.attr()
				return false;
			});
			$(".bhide2").click(function(){
				$(".container.hideObj2").slideDown();
				$(this).hide(); // .attr()
				return false;
			});
				
			$(\'.heart\').mouseover(function(){
					$(this).find(\'i\').removeClass(\'fa-heart-o\').addClass(\'fa-heart\');
				}).mouseout(function(){
					$(this).find(\'i\').removeClass(\'fa-heart\').addClass(\'fa-heart-o\');
				});
				
				function sdf_FTS(_number,_decimal,_separator)
				{
				var decimal=(typeof(_decimal)!=\'undefined\')?_decimal:2;
				var separator=(typeof(_separator)!=\'undefined\')?_separator:\'\';
				var r=parseFloat(_number)
				var exp10=Math.pow(10,decimal);
				r=Math.round(r*exp10)/exp10;
				rr=Number(r).toFixed(decimal).toString().split(\'.\');
				b=rr[0].replace(/(\d{1,3}(?=(\d{3})+(?:\.\d|\b)))/g,"\$1"+separator);
				r=(rr[1]?b+\'.\'+rr[1]:b);

				return r;
}
				
			setTimeout(function(){
					$(\'#counter\').text(\'0\');
					$(\'#counter1\').text(\'0\');
					$(\'#counter2\').text(\'0\');
					setInterval(function(){
						
						var curval=parseInt($(\'#counter\').text());
						var curval1=parseInt($(\'#counter1\').text().replace(\' \',\'\'));
						var curval2=parseInt($(\'#counter2\').text());
						if(curval<='.getPresentersNumber().'-1){
							$(\'#counter\').text(sdf_FTS((curval+1),0,\' \'));
						}
						if(curval1<='.getPartnersNumber().'-1){
							$(\'#counter1\').text(sdf_FTS((curval1+1),0,\' \'));
						}
						if(curval2<='.getPrizesNumber().'-1){
							$(\'#counter2\').text(sdf_FTS((curval2+1),0,\' \'));
						}
					}, 2);
					
				}, 500);
			});
	</script>
	<script type="text/javascript">
	jQuery(document).ready(function(){
		jQuery(\'#menu\').slicknav();
		
	});
	</script>
	
	<script type="text/javascript">
    $(document).ready(function(){
       
        var $menu = $("#menuF");
            
        $(window).scroll(function(){
            if ( $(this).scrollTop() > 100 && $menu.hasClass("default") ){
                $menu.fadeOut(\'fast\',function(){
                    $(this).removeClass("default")
                           .addClass("fixed transbg")
                           .fadeIn(\'fast\');
                });
            } else if($(this).scrollTop() <= 100 && $menu.hasClass("fixed")) {
                $menu.fadeOut(\'fast\',function(){
                    $(this).removeClass("fixed transbg")
                           .addClass("default")
                           .fadeIn(\'fast\');
                });
            }
        });
	});
    //jQuery
	</script>
	<script>
		/*menu*/
		function calculateScroll() {
			var contentTop      =   [];
			var contentBottom   =   [];
			var winTop      =   $(window).scrollTop();
			var rangeTop    =   200;
			var rangeBottom =   500;
			$(\'.navmenu\').find(\'a\').each(function(){
				contentTop.push( $( $(this).attr(\'href\') ).offset().top );
				contentBottom.push( $( $(this).attr(\'href\') ).offset().top + $( $(this).attr(\'href\') ).height() );
			})
			$.each( contentTop, function(i){
				if ( winTop > contentTop[i] - rangeTop && winTop < contentBottom[i] - rangeBottom ){
					$(\'.navmenu li\')
					.removeClass(\'active\')
					.eq(i).addClass(\'active\');				
				}
			})
		};
		
		$(document).ready(function(){
			calculateScroll();
			$(window).scroll(function(event) {
				calculateScroll();
			});
			$(\'.navmenu ul li a\').click(function() {  
				$(\'html, body\').animate({scrollTop: $(this.hash).offset().top - 80}, 800);
				return false;
			});
		});		
	</script>	
	<script type="text/javascript" charset="utf-8">

		jQuery(document).ready(function(){
			jQuery(".pretty a[rel^=\'prettyPhoto\']").prettyPhoto({animation_speed:\'normal\',theme:\'light_square\',slideshow:3000, autoplay_slideshow: true, social_tools: \'\'});
			
		});
	</script>
	
	
	
	';

	return $BodyContent;
}

?>