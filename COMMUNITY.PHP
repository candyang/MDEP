<?
include(".././opendata.php");   
if($dba=="edit"){
  $communitysql=Mysql_query("select * from community where community_no=$editno");   
  $communityinfo=Mysql_fetch_array($communitysql,MYSQL_BOTH);   
  $phonecut=explode(",",$communityinfo["phone"]);
  $faxcut=explode(",",$communityinfo["fax"]);
}
?>

<html>

<head>
<title>社造點基本資料</title>
</head>

<body background="../image/底圖32.gif">

<form method="post" action="edit.php?id=3&dba=<?=$dba?>&editno=<?=$editno?>" enctype="multipart/form-data">
<?
$localsql=Mysql_query("select * from local_class");
$buildsql=Mysql_query("select * from build_class");
$familysql=Mysql_query("select * from family_class");
$employeesql=Mysql_query("select id,name from employee");
$community_evaluatesql=Mysql_query("select * from community_evaluate");
?>
<div align="center">
  <center>
  <table border="1" width="720">
  <tr>
      <td width="90">社區名稱</td>
      <td><input type="text" name="name" size="25" tabindex="1" value="<?=$communityinfo["name"]?>"></td>
      <td width="120">所屬區域</td>
      <td><select size="1" name="local">
 <?
while($localinfo=Mysql_fetch_array($localsql,MYSQL_BOTH)){
  $checkv="";
  $checkv=($communityinfo["local_id"]==$localinfo["local_id"]) ? 'selected':'';
?>
<option value="<?=$localinfo["local_id"]?>" <?=$checkv?>><?=$localinfo["local_name"]?></option>
<?}?>
        </select></td>
    </tr>
    <tr>
      <td width="90">營造點類型</td>
      <td><select size="1" name="build">
 <?
while($buildinfo=Mysql_fetch_array($buildsql,MYSQL_BOTH)){
  $checkv="";
  $checkv=($communityinfo["build_id"]==$buildinfo["build_id"]) ? 'selected':'';
?>
<option value="<?=$buildinfo["build_id"]?>" <?=$checkv?>><?=$buildinfo["build_name"]?></option>
<?}?>
        </select></td>
      <td width="120">提案單位</td>
      <td><input type="text" name="executive_section" size="25" tabindex="7" value="<?=$communityinfo["executive_section"]?>"></td>
    </tr>
    <tr>
     <td width="90">社區網址</td>
      <td>http://<input type="text" name="link_address" size="30" tabindex="3" value="<?=$communityinfo["link_address"]?>"></td>
      <td width="120">提案單位聯絡人</td>
      <td><input type="text" name="liaisoner" size="25" tabindex="8" value="<?=$communityinfo["liaisoner"]?>"></td>
    </tr>
    <tr>
      <td width="90">社區地址</td>
      <td><input type="text" name="address" size="26" tabindex="3" value="<?=$communityinfo["address"]?>"></td>
      <td width="120" >聯絡電話</td>
      <td><input type="text" name="phone[1]" size="3" tabindex="4" value="<?=$phonecut[0]?>">-<input type="text" name="phone[2]" size="7" tabindex="5" value="<?=$phonecut[1]?>">轉<input type="text" name="phone[3]" size="5" tabindex="6" value="<?=$phonecut[2]?>"></td>
    </tr>
    <tr>
      <td width="90">社造員</td>
      <td><select size="1" name="employee">
<option value=""></option>
 <?
while($employeeinfo=Mysql_fetch_array($employeesql,MYSQL_BOTH)){
  $checkv="";
  $checkv=($communityinfo["employee_id"]==$employeeinfo["id"]) ? 'selected':'';
?>
<option value="<?=$employeeinfo["id"]?>" <?=$checkv?>><?=$employeeinfo["name"]?></option>
<?}?>
      </select></td>
      <td width="120">傳真電話</td>
      <td><input type="text" name="fax[1]" size="3" tabindex="4" value="<?=$faxcut[0]?>">-<input type="text" name="fax[2]" size="7" tabindex="5" value="<?=$faxcut[1]?>"></td>
    </tr>
    <tr>
      <td width="90" height="8">所屬家族</td>
      <td height="8"><select size="1" name="family">
 <?
$checkv="";
if($communityinfo["family_id"]=="") $checkv="selected";
  echo "<option value=\"\"".$checkv.">無</option>";

while($familyinfo=Mysql_fetch_array($familysql,MYSQL_BOTH)){
  $checkv="";
  $checkv=($communityinfo["family_id"]==$familyinfo["family_id"]) ? 'selected':'';
?>
<option value="<?=$familyinfo["family_id"]?>" <?=$checkv?>><?=$familyinfo["family_name"]?></option>
<?}?>
        </select></td>
      <td width="120">E-Mail</td>
      <td><input type="text" name="email" size="27" tabindex="8" value="<?=$communityinfo["email"]?>"></td>
    </tr>
    <tr>
      <td rowspan=2 width="90">營造範圍</td>
      <td rowspan=2>
        <textarea rows="6" name="rang" cols="30" tabindex="2"><?=$communityinfo["rang"]?></textarea>
      </td>
      <td width="120">提案單位地址</td>
      <td><input type="text" name="section_addr" size="27" tabindex="9" value="<?=$communityinfo["section_addr"]?>"></td>
    </tr>
    <tr>
      <td width="120">計劃上傳</td>
      <td><input type="file" name="proposalpath">
      <?
      if($dba=="edit" and $communityinfo["proposal_path"]!=""){
        $cproposalvcut=explode("/",$communityinfo["proposal_path"]);
        echo "<br><input type=\"checkbox\" name=\"sourcep\" checked value=\"yes\">"."原始檔案:".$cproposalvcut[count($cproposalvcut)-1];
      }
      ?>
      </td>
      </tr>
    <tr>
      <td width="90" rowspan="4">
        <p style="margin-top: 0; margin-bottom: 0">上傳社區</p>
        <p style="margin-top: 0; margin-bottom: 0">照片/影片</p>
      </td>
      <td>計劃名稱:<input type="file" name="photo[1]">
        <?
        if($dba=="edit" and $communityinfo["file1_type"]!="")
        echo "<br><input type=\"checkbox\" name=\"sourcef[1]\" checked value=\"yes\"><a href=\"viewphoto.php?photono=1&id=3&idno=".$communityinfo["community_no"]."\" target=\"_blank\">觀看原始照片</a>";
        ?>
      </td>
      <td colspan="2">社區名稱:<input type="file" name="photo[2]">
        <?if($dba=="edit" and $communityinfo["file2_type"]!="")
        echo "<br><input type=\"checkbox\" name=\"sourcef[2]\" checked value=\"yes\"><a href=\"viewphoto.php?photono=2&id=3&idno=".$communityinfo["community_no"]."\" target=\"_blank\">觀看原始照片</a>";
      ?></td>
    </tr>
    <tr>
      <td>大圖片:<input type="file" name="photo[3]">
        <?if($dba=="edit" and $communityinfo["file3_type"]!="")
        echo "<br><input type=\"checkbox\" name=\"sourcef[3]\" checked value=\"yes\"><a href=\"viewphoto.php?photono=3&id=3&idno=".$communityinfo["community_no"]."\" target=\"_blank\">觀看原始照片</a>";
        ?></td>
      <td colspan="2">中圖片:<input type="file" name="photo[4]">
        <?if($dba=="edit" and $communityinfo["file4_type"]!="")
        echo "<br><input type=\"checkbox\" name=\"sourcef[4]\" checked value=\"yes\"><a href=\"viewphoto.php?photono=4&id=3&idno=".$communityinfo["community_no"]."\" target=\"_blank\">觀看原始照片</a>";
        ?></td>
    </tr>
    <tr>
      <td>小圖片1:<input type="file" name="photo[5]">
        <?if($dba=="edit" and $communityinfo["file5_type"]!="")
        echo "<br><input type=\"checkbox\" name=\"sourcef[5]\" checked value=\"yes\"><a href=\"viewphoto.php?photono=5&id=3&idno=".$communityinfo["community_no"]."\" target=\"_blank\">觀看原始照片</a>";
        ?></td>
      <td colspan="2">小圖片2:<input type="file" name="photo[6]">
        <?if($dba=="edit" and $communityinfo["file6_type"]!="")
        echo "<br><input type=\"checkbox\" name=\"sourcef[6]\" checked value=\"yes\"><a href=\"viewphoto.php?photono=6&id=3&idno=".$communityinfo["community_no"]."\" target=\"_blank\">觀看原始照片</a>";
        ?></td>
    </tr>
      <tr>
      <td>小圖片3:<input type="file" name="photo[7]">
        <?if($dba=="edit" and $communityinfo["file7_type"]!="")
        echo "<br><input type=\"checkbox\" name=\"sourcef[7]\" checked value=\"yes\"><a href=\"viewphoto.php?photono=7&id=3&idno=".$communityinfo["community_no"]."\" target=\"_blank\">觀看原始照片</a>";
        ?></td>
      <td colspan="2">小圖片4:<input type="file" name="photo[8]">
        <?if($dba=="edit" and $communityinfo["file8_type"]!="")
        echo "<br><input type=\"checkbox\" name=\"sourcef[8]\" checked value=\"yes\"><a href=\"viewphoto.php?photono=8&id=3&idno=".$communityinfo["community_no"]."\" target=\"_blank\">觀看原始照片</a>";
        ?></td>
    </tr>
  </table>
  </center>
</div>
  <table border="1" width="720">
    <tr>
      <td width="360">
        <p align="center">社區簡介</td>
      <td width="360">
  <p align="center">未來發展方向</td>
<!--
       <td width="370" height="12">
  <p align="center">評估
  </td>
-->
    </tr>
      <tr>
      <td width="360">

        <textarea rows="15" name="introduct" cols="46" tabindex="10"><?=$communityinfo["introduct"]?></textarea>

        </td>
      <td width="360">

  <textarea rows="15" name="proposal" cols="46" tabindex="11"><?=$communityinfo["proposal"]?></textarea>

  </td>
<!--
      <td width="370" height="195">
<font size="2">
-->
<?
//if($dba=="add"){
//$i=19;
//while($community_evaluateinfo=Mysql_fetch_array($community_evaluatesql,MYSQL_BOTH)){
?>
<!--
<input type="checkbox" name=evaluate[<?=$i?>] value="<?=$community_evaluateinfo["evaluate_id"]?>"><?=$community_evaluateinfo["evaluate_name"]?><p>
<?
//$i++;
//}
//}elseif($dba="edit"){
//$evaluate_list=split(",",$communityinfo["evaluate"]);
//$j=1;
//while($community_evaluateinfo=Mysql_fetch_array($community_evaluatesql,MYSQL_BOTH)){
//  $checkval="";
//  for($i=0;$i<(count($evaluate_list)+1);$i++){
//    if($evaluate_list[$i]==$j){   
//     $checkval="checked";   
//      break;   
//    }   
//  }   
//  $j++;          
//?>   
<!--          
<input type="checkbox" name=evaluate[<?=$i?>] value="<?=$community_evaluateinfo["evaluate_id"]?>" <?=$checkval?>><?=$community_evaluateinfo["evaluate_name"]?><p>      
-->            
<?   
//}}     
?>              
      </tr>              
    <tr>              
      <td width="720" height="12" colspan="3">
        <p align="center"><input type="submit" value="儲存" name="saving"><input type="reset" value="重新填寫" name="reset"></td>
    </tr>
  </table>
</form>
</body>
</html>
