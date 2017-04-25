<?php
$contentVar = $_POST['contentVar'];
if($contentVar=="con1") {
	echo "My default content";
}
else if ($contentVar=="con2") {
	echo "This is content that loads for the second";
}
else if ($contentVar=="con3") {
	echo "This is content that loads for the third";
}
?>
