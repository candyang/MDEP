<?
  include("../opendata.php");

?>


<script Language="JavaScript">

function buildmap(buildno){
  window.parent.mapbuild.location.replace("buildmap.php?buildno="+buildno);
}

function uploadmap(){
  window.parent.mapbuild.location.replace("../manager/uploadmap.php")

}

function delrecord(delval,recordno) { //�R��
 if (delval=="delete"){
   var return_value=confirm("�T�w�R����y�I?")
   if (return_value)
     window.location.replace("communitybrowse.php?send="+delval+"&delno="+recordno);
 }
 if(delval=="deleteemployee"){
   var return_value=confirm("�T�w�R����y��?")
   if (return_value)
     window.location.replace("communitybrowse.php?send="+delval+"&delno="+recordno);
 }
 if(delval=="deletefamily"){
   var return_value=confirm("�T�w�R���a��?")
   if (return_value)
     window.location.replace("communitybrowse.php?send="+delval+"&delno="+recordno);
 }
 if(delval=="clearp"){
   var return_value=confirm("�T�w�M���y��?")
   if (return_value)
     window.location.replace("communitybrowse.php?send="+delval+"&delno="+recordno);
 }

}

function editrecord(editno){ //�ק�ը����e
window.parent.location.replace("../manager/community.php?editno="+editno+"&dba=edit")
}

function editemployee(editno,communityno){ //�ק���y�����e
window.parent.location.replace("../manager/employee.php?editno="+editno+"&dba=edit"+"&communityno="+communityno)
}

function editfamily(editno){ //�ק�a�ڤ��e
window.parent.location.replace("../manager/family.php?editno="+editno+"&dba=edit")
}


function winop(communityno){ //����y�I�ԲӸ��
self.win_child=window.open("cbframe.php?communityno="+communityno)
self.win_child.win_parent=self
}

function winopemployee(eid){ //����y���ԲӸ��
self.win_child=window.open("employee.php?employeeno="+eid)
self.win_child.win_parent=self
}
</script>

<?
 If($send=="delete") //�P�_�O�_���n�D����
 {
    $svsql="delete from community where community_no=".$delno;
    $rows=Mysql_query($svsql);
 }elseif($send=="deleteemployee"){
    $svsql="delete from employee where id='".$delno."'";
    $rows=Mysql_query($svsql);
    Mysql_query("update community set employee_id='' where employee_id='$delno'");
 }elseif($send=="deletefamily"){
   Mysql_query("delete from family_class where family_id=$delno");
   Mysql_query("update community set family_id='' where family_id=$delno");
   Mysql_query("update employee set family_id='' where family_id=$delno");

   Mysql_query("update family_class set family_id=family_id+100");
   Mysql_query("update community set family_id=family_id+100 where family_id<>''");
   Mysql_query("update employee set family_id=family_id+100 where family_id<>''");
   $familycount=Mysql_query("select family_id from family_class order by family_id");
   $i=1;
   while($row = mysql_fetch_array ($familycount,MYSQL_BOTH)){
      $sqlv="update community set family_id=".$i." where family_id=".$row["family_id"];
      Mysql_query($sqlv);
      $sqlv="update employee set family_id=".$i." where family_id=".$row["family_id"];
      Mysql_query($sqlv);
      $sqlv="update family_class set family_id=".$i." where family_id=".$row["family_id"];
      Mysql_query($sqlv);
      $i++;
  }}elseif($send=="clearp"){
    Mysql_query("update community set map_position='' where community_no='$delno'");
?>
<script>
    window.parent.mapbuild.location.replace("buildmap.php");
</script>
<?
 }

$addrecordpath="../manager/community.php";

$sqlfamily=Mysql_query("select family_name,link_address from family_class order by family_id");

$sql="select * from community order by family_id"; //�q���
$rows=mysql_query($sql);

?>
<HTML>
<HEAD>
<style>
body {  scrollbar-3d-light-color: #b4b46c;
	scrollbar-arrow-color: #6c0000;
	scrollbar-base-color: #FFFFFF;
	scrollbar-dark-shadow-color: #FFFFFF;
	scrollbar-face-color: #b4b46c;
	scrollbar-highlight-color: #FFFFFF;
	scrollbar-shadow-color: #6c0000;
     }
a {text-decoration:none}
a:hover{position:relative;top:1px;left:1px;}
</style>
</HEAD>
<BODY background="../image/14.jpg" bgproperties="fixed">
  <table border="0" width="100%">
    <tr>
      <?if($session_usrstatus=="���߹ζ�"){?>
      <td align="center"><font size=2><a href="javascript:uploadmap()">��s�a��</a></font></td>
      <td align="center"><font size=2><a href="../manager/community.php?dba=add" target="_parent">�s�W��y�I</a></font></td>
      <td align="center"><font size=2><a href="../manager/family.php?dba=add" target="_parent">�s�W�a��</a></font></td>
      <?}?>
    </tr>
  </table>
<TABLE  border="0" width="100%" bordercolor="#800000" cellpadding="1" cellspacing="1" >
<form action="community.php" method=post name="community">
<?
   $familytmp=0;
   while($row = mysql_fetch_array ($rows,MYSQL_BOTH) ){
     $localsql="select local_name from local_class where local_id='".$row["local_id"]."'";
     $localinfo=Mysql_query($localsql);
     List($localname)=Mysql_fetch_row($localinfo);
     $employeesql="select id,name from employee where id='".$row["employee_id"]."'";
     $employeeinfo=Mysql_query($employeesql);
     $employee=Mysql_fetch_array($employeeinfo,MYSQL_BOTH);
     if($row["family_id"]!=$familytmp){
        $familytmp=$row["family_id"];
	$familyname=mysql_result($sqlfamily,$familytmp-1,"family_name");
	$familylinkaddress=mysql_result($sqlfamily,$familytmp-1,"link_address");
	echo "<tr><td colspan=3><hr></td><tr><tr><td colspan=3><font size=3>";
	if($familylinkaddress!="")
	  echo "<a href=\"http://".$familylinkaddress."\" target=\"_blank\">".$familyname."</a>";
	else
	  echo $familyname;
        if($session_usrstatus=="���߹ζ�"){
	  echo "&nbsp;&nbsp;<a href=\"javascript:editfamily('".$row["family_id"]."')\"><font color=\"#FF0000\" size=2>[�ק�]</font></a>&nbsp;&nbsp;";
          echo "<a href=\"javascript:delrecord('deletefamily','".$row["family_id"]."')\"><font color=\"#FF0000\" size=2>[�R��]</font></a></td>";
        }
	echo "</font></td></tr>";
     }
?>
<tr>
<td rowspan=2><img border="0" src="../image/logo.gif" width="15"></td>
<td><font size=2>
<a href="javascript:winop('<?=$row["community_no"]?>')"><?=$localname?><?=$row["name"]?></a></font>
</td>
<?if($row["employee_id"]!=""){?>
<td align="center"><font size=2><a href="javascript:winopemployee('<?=base64_encode($employee["id"])?>')"><?=$employee["name"]?></font></td>
<?}elseif($row["employee_id"]==""){
  if($session_usrstatus=="���߹ζ�"){?>
<td align="center">
<font size=2><a href="../manager/employee.php?dba=add&communityno=<?=$row["community_no"]?>" target="_parent">�s�W��y��</a></font>
</td>
<?}}?>
</tr>
<tr>
<?if($session_usrstatus=="���߹ζ�"){?>
<td><font size=2 color="#FF0000"><a href="javascript:editrecord('<?=$row["community_no"]?>')"><font color="#FF0000">[�ק�]</font></a>
<a href="javascript:delrecord('delete','<?=$row["community_no"]?>')"><font color="#FF0000">[�R��]</font></a>
<a href="javascript:buildmap('<?=$row["community_no"]?>')"><font color="#FF0000" size=2>[�w�y��]</font></a>
<?if($row["map_position"]!=""){?>
<a href="javascript:delrecord('clearp','<?=$row["community_no"]?>')"><font color="#FF0000" size=2>[�M�y��]</font></a></font></td>
<?}}?>
<?if($session_usrstatus=="���߹ζ�"){?>
<td align="center"><font size=2><a href="javascript:editemployee('<?=$employee["id"]?>','<?=$row["community_no"]?>')"><font color="#FF0000">[�ק�]</font></a>&nbsp;
<a href="javascript:delrecord('deleteemployee','<?=$employee["id"]?>')"><font color="#FF0000">[�R��]</font></a></font></td>
<?}}?>
</tr>
</table>
</form>
</body>
</html>
