<?php
header("Content-Type:text/html; charset=utf-8");
$FileArray=array();
$DiffArray=array();
$dir_path = 'C:\wamp\www\dir\tmp1';
list_all_file(0,$dir_path);
$dir_path = 'C:\wamp\www\dir\tmp2';
list_all_file(2,$dir_path);
FileMD5(0);
FileMD5(2);
function list_all_file($flag,$dir_path)
{

	if(is_dir($dir_path))
	{
		foreach(scandir($dir_path) as $file)
		{
			if($file != '.' && $file != '..')
			{
				list_all_file($flag,$dir_path . '\\' . $file);
			}
		}
	}
	
	if(is_file($dir_path))
	{
		global $FileArray;
		$FileArray[$flag][]=$dir_path;
	}
}
function FileMD5($flag){
global $FileArray;
	foreach($FileArray[$flag] as $FileName)
	{
		$md5file = md5_file($FileName);
		$FileArray[$flag+1][]=$md5file;
	}
}

echo "<br>";
$cnt=0;
$DiffArray1=array_diff($FileArray[1],$FileArray[3]);
$DiffArray2=array_diff($FileArray[3],$FileArray[1]);
foreach($DiffArray1 as $string)
{
	$key=array_search($string, $FileArray[1]);
	$DiffArray[$cnt][0]=$FileArray[0][$key];
	$DiffArray[$cnt][1]=$FileArray[1][$key];
	$cnt++;
	
}
foreach($DiffArray2 as $string)
{
	$key=array_search($string, $FileArray[3]);
	$DiffArray[$cnt][0]=$FileArray[2][$key];
	$DiffArray[$cnt][1]=$FileArray[3][$key];
	$cnt++;
	
}
?>
來源
<table border="1">
<tr>
<?php 
for($i=0;$i<count($FileArray[0]);$i++)
{
	echo "</tr><tr>";
	echo "<td>".$FileArray[0][$i]."</td><td>".$FileArray[1][$i]."</td>";
}
	
?>
</tr>
</table>
目標
<table border="1">
<tr>
<?php 
for($i=0;$i<count($FileArray[2]);$i++)
{
	echo "</tr><tr>";
	echo "<td>".$FileArray[2][$i]."</td><td>".$FileArray[3][$i]."</td>";
}
	
?>
</tr>
</table>
比對後
<table border="1">
<tr>
<?php 
for($i=0;$i<count($DiffArray);$i++)
{
	echo "</tr><tr>";
	echo "<td>".$DiffArray[$i][0]."</td><td>".$DiffArray[$i][1]."</td>";
}
	
?>
</tr>
</table>