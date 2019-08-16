<?
include("../opendata.php");
?>
<html>

<head>
<title>社區資訊</title>
</head>

<body>


<?             
$communitysql=Mysql_query("select * from community where community_no='$communityno'");             
              
$communityinfo=Mysql_fetch_array($communitysql,MYSQL_BOTH);         

$familysql="select family_name from family_class where family_id='".$communityinfo["family_id"]."'";          
$familyinfo=Mysql_query($familysql);           
List($family)=Mysql_fetch_row($familyinfo);         
            
$localsql="select local_name from local_class where local_id='".$communityinfo["local_id"]."'";          
$localinfo=Mysql_query($localsql);             
List($local)=Mysql_fetch_row($localinfo);

$buildsql="select build_name from build_class where build_id='".$communityinfo["build_id"]."'";
$buildinfo=Mysql_query($buildsql);
List($build)=Mysql_fetch_row($buildinfo);

$employeesql="select id,name from employee where id='".$communityinfo["employee_id"]."'";
$employeeinfo=Mysql_query($employeesql);
$employee=Mysql_fetch_array($employeeinfo,MYSQL_BOTH);

$community_evaluatesql=Mysql_query("select * from community_evaluate");
?>
<div align="center">
  <center>
  <table border="0" width="610">
    <tr>
      <td width="218" rowspan="7">
	  <img border="0" src="showImg.php?photono=3&id=3&idno=<?=$communityinfo["community_no"]?>" style="width:230; height:200">
      </td>
      <td width="100">社造員</td>
      <td width="300"><a href="employee.php?employeeno=<?=base64_encode($employee["id"])?>" target=_top><?=$employee["name"]?></a></td>
    </tr>
    <tr>
      <td width="100">所屬家族</td>
      <td width="300"><?=$family?></td>
    </tr>
    <tr>
      <td width="100">營造點類型</td>
      <td width="300"><?=$build?></td>
    </tr>
    <tr>
      <td width="100">聯絡電話</td>
      <td width="300">
      <? $phonev=Ereg_replace(",","-",$communityinfo["phone"]);
      if(!Ereg("[0-9]$",$phonev)) $phonev=substr($phonev,0,strlen($phonev)-1);
        else{ $phonevcut=explode("-",$phonev); $phonev=$phonevcut[0]."-".$phonevcut[1]."轉".$phonevcut[2];
        }
        echo $phonev;
      ?>
      </td>
    </tr>
    <tr>
      <td width="100">聯絡傳真</td>
      <td width="300"><?=Ereg_replace(",","-",$communityinfo["fax"])?></td>
    </tr>
    <?if($communityinfo["link_address"]!=""){?>
    <tr>
      <td width="100">社區網址</td>
      <td width="300"><a href="http://<?=$communityinfo["link_address"]?>" target="_top">http://<?=$communityinfo["link_address"]?></a></td>
    </tr>
    <?}?>
    <tr>
      <td width="100">E-mail</td>
      <td width="300"><a href="mailto:<?=$communityinfo["email"]?>"><?=$communityinfo["email"]?></a></td>
    </tr>
  </table>
  </center>
</div>

<div align="center">
  <center>
  <table border="0" width="610">
    <tr>
      <td width="610" colspan="3"><font size=4><b>營造點範圍</b></font></td>
    </tr>
    <tr>
      <td width="22"></td>
      <td width="428"><?=$communityinfo["rang"]?><br></td>
    </tr>
    <tr height=10></tr>
    <tr>
      <td width="456" colspan="2"><font size=4><b>社區簡介</b></font></td>
     </td>
      <td width="206" rowspan="3">
	  <img border="0" src="showImg.php?photono=4&id=3&idno=<?=$communityinfo["community_no"]?>" style="width:180; height:200">
      </td>
    </tr>
    <tr>
      <td width="22"></td>
      <td width="428">
      <?=$communityinfo["introduct"]?>
     </tr>
    <tr height=10></tr>
    <tr>
      <td width="610" colspan="3">
	  <img border="0" src="showImg.php?photono=5&id=3&idno=<?=$communityinfo["community_no"]?>" style="width:150; height:130">
	  <img border="0" src="showImg.php?photono=6&id=3&idno=<?=$communityinfo["community_no"]?>" style="width:140; height:130">
	  <img border="0" src="showImg.php?photono=7&id=3&idno=<?=$communityinfo["community_no"]?>" style="width:150; height:130">
  	  <img border="0" src="showImg.php?photono=8&id=3&idno=<?=$communityinfo["community_no"]?>" style="width:140; height:130">
      </td>
    </tr>
    <tr height=10></tr>
    <tr>
      <td width="610" colspan="3"><font size=4><b>未來發展方向</b></font></td>
    </tr>
    <tr>
      <td width="22"></td>
      <td width="596"colspan=3><?=$communityinfo["proposal"]?></td>
    </tr>
  </table>
  </center>
</div>

</body>

</html>
