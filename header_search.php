<? session_start();

$search = strip_tags($_POST['search']);
$search = str_replace(array("'","\"",">","<","_","-","+","/"), " ", $search);
$search = htmlentities($search, ENT_QUOTES);

//$search = preg_replace('![^\w\d\s]*!','',$search);
echo $search;
?>