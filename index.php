<?php
ini_set('display_errors',1);  error_reporting(E_ALL);
require 'functions.php';
?>
<html>
<head>
<?php
//phpinfo();
main();
echo getHeaderContent();
?>
</head>
<body>
<?php
echo getTableContent("Partners");
echo getBodyContent(); 
?> 
</body>
</html>
