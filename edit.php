<?
include(".././opendata.php");
Switch($id)
{
  case 1: //團隊
     if(count($phone)<>0)
       $phonea=$phone[1].",".$phone[2].",".$phone[3];
     if(count($fax)<>0)
       $faxa=$fax[1].",".$fax[2];
     if(count($mobile)<>0)
       $mobilea=$mobile[1].",".$mobile[2];
     if(count($birth)<>0)
       $birtha=$birth[1]."/".$birth[2]."/".$birth[3];
     if(count($family)<>0)
       $familya=Implode(",",$family);
     if(count($title)<>0)
       $titlea=Implode(",",$title);
     $idno=Strtoupper($idno);

     if(Ereg("[1-2]",$titlea) and Ereg("[3-9]",$titlea)){
       $groupid="伙伴兼老師";
     }else{
       $groupid=($btype==1)? "中心工作伙伴":"授課/輔導老師";
     }

   if($dba=="add"){
     $sql = "insert into center_team (group_id,id,name,sex,login_name,password,birth,title_id,work,phone,mobile,fax,email,edu,job,background,family_id";
     if($photo_size!=0){
       $photo_file = fread(fopen($photo,"r"),filesize($photo));
       $photo_file = addslashes($photo_file);
       $photo_types=$photo_type;
       $sql = $sql.",photo,file_type";
     }
     $sql=$sql.") values ('$groupid','$idno','$name','$sex','$loginname','$password','$birtha','$titlea','$work','$phonea','$mobilea','$faxa','$email','$edu','$job','$background','$familya'";
     if($photo_size!=0)
       $sql = $sql.",'$photo_file','$photo_types'";
     $sql=$sql.")";
     Mysql_query($sql);
     Header("Location:center_team.php?btype=$btype&dba=add");
    }elseif($dba="edit"){
       $sql = "update center_team set group_id='$groupid',id='$idno',name='$name',sex='$sex',login_name='$loginname',password='$password',birth='$birtha',title_id='$titlea',work='$work',phone='$phonea',mobile='$mobilea',fax='$faxa',email='$email',edu='$edu',job='$job',background='$background',family_id='$familya'";
       if($photo_size!=0 and $sourcef!="yes"){
         $photo_file = fread(fopen($photo,"r"),filesize($photo));
         $photo_file = addslashes($photo_file);
         $photo_types=$photo_type;
         $sql = $sql.",photo='$photo_file',file_type='$photo_types'";
       }elseif($sourcef!="yes" and $photo_size==0){
         $sql = $sql.",photo=NULL,file_type=''";
       }
       $sql=$sql." where id='$editno'";
       Mysql_query($sql);
       Header("Location:../client/center_teambrowse.php?btype=$btype");
    }
     break;
  case 2: //營造員
     $familysql=Mysql_query("select family_id from community where community_no=$community");
     List($familyid)=Mysql_fetch_row($familysql);
     if(count($phone)<>0)
       $phonea=$phone[1].",".$phone[2].",".$phone[3];
     if(count($fax)<>0)
       $faxa=$fax[1].",".$fax[2];
     if(count($mobile)<>0)
       $mobilea=$mobile[1].",".$mobile[2];
     if(count($birth)<>0)
       $birtha=$birth[1]."/".$birth[2]."/".$birth[3];
     $idno=Strtoupper($idno);
     if($dba=="add"){
     $sql = "insert into employee (id,name,sex,birth,password,phone,mobile,fax,address,email,edu,background,expect,community_no,family_id";
     if($photo_size<>0){
       $photo_file = fread(fopen($photo,"r"),filesize($photo));
       $photo_file = addslashes($photo_file);
       $photo_types=$photo_type;
       $sql = $sql.",photo,file_type";
     }
     $sql=$sql.") values ('$idno','$name','$sex','$birtha','$password','$phonea','$mobilea','$faxa','$address','$email','$edu','$background','$expect','$community','$familyid'";
     if($photo_size<>0)
       $sql = $sql.",'$photo_file','$photo_types'";
     $sql=$sql.")";
     }elseif($dba=="edit"){
       $sql = "update employee set id='$idno',name='$name',sex='$sex',birth='$birtha',password='$password',phone='$phonea',mobile='$mobilea',fax='$faxa',address='$address',email='$email',edu='$edu',background='$background',expect='$expect',community_no='$community',family_id='$familyid'";
       if($photo_size!=0 and $sourcef!="yes"){
         $photo_file = fread(fopen($photo,"r"),filesize($photo));
         $photo_file = addslashes($photo_file);
         $photo_types=$photo_type;
         $sql = $sql.",photo='$photo_file',file_type='$photo_types'";
       }elseif($sourcef!="yes" and $photo_size==0){
         $sql = $sql.",photo=NULL,file_type=''";
       }
       $sql=$sql." where id='$editno'";
     }
     Mysql_query($sql);
     Mysql_query("update community set employee_id='' where employee_id='$idno'");
     Mysql_query("update community set employee_id='$idno' where community_no='$community'");
     Header("Location:../communityframe.html");
     break;
  case 3: //營造點
     $copyf=CheckUploadDir("buildproposal","");
     if(count($phone)<>0)
       $phonea=$phone[1].",".$phone[2].",".$phone[3];
     if(count($fax)<>0)
       $faxa=$fax[1].",".$fax[2];
     //if(count($evaluate)<>0)
     //  $evaluatea=Implode(",",$evaluate);
     if($dba=="add"){
     $sql = "insert into community (name,local_id,rang,build_id,subvention,proposal,employee_id,address,executive_section,section_addr,liaisoner,phone,fax,email,introduct,family_id,link_address";

     if($proposalpath_size!=0){
       $sql = $sql.",proposal_path";
       $f=$copyf."/".$proposalpath_name;
     }

     for($i=1;$i<=8;$i++){
       if($photo_size[$i]<>0){
          $photo_file[$i] = fread(fopen($photo[$i],"r"),filesize($photo[$i]));
          $photo_file[$i] = addslashes($photo_file[$i]);
          $photo_types[$i]=$photo_type[$i];
	  $sqltmp=",photo".$i.",file".$i."_type";
          $sql = $sql.$sqltmp;
       }
     }


     //if($photo1_size<>0){
     //  $photo1_file = fread(fopen($photo1,"r"),filesize($photo1));
     //  $photo1_file = addslashes($photo1_file);
     //  $photo1_types=$photo1_type;
     //  $sql = $sql.",photo1,file1_type";
     //}

     $sql=$sql.") values ('$name','$local','$rang','$build','$subvention','$proposal','$employee','$address','$executive_section','$section_addr','$liaisoner','$phonea','$faxa','$email','$introduct','$family','$link_address'";

     if($proposalpath_size!=0){
       $sql = $sql.",'$f'";
       copy($proposalpath,$f);
     }

     for($i=1;$i<=8;$i++){
       if($photo_size[$i]<>0)
         $sql = $sql.",'$photo_file[$i]','$photo_types[$i]'";
     }

     //if($photo1_size<>0)
     //  $sql = $sql.",'$photo1_file','$photo1_types'";

     $sql=$sql.")";
     Mysql_query($sql);
     $upemployee="update employee set family_id='".$family."' where id='".$employee."'";
     Mysql_query($upemployee);
     Header("Location:community.php?dba=add");
     }elseif($dba=="edit"){
     $sql = "update community set name='$name',local_id='$local',rang='$rang',build_id='$build',subvention='$subvention',proposal='$proposal',employee_id='$employee',address='$address',executive_section='$executive_section',section_addr='$section_addr',liaisoner='$liaisoner',phone='$phonea',fax='$faxa',email='$email',introduct='$introduct',family_id='$family',link_address='$link_address'";

     if($proposalpath_size!=0 or ($sourcep!="yes" and $proposalpath_size==0)){
       $pathsql=Mysql_query("select proposal_path from community where community_no=$editno");
       $pathrow=Mysql_fetch_row($pathsql);
       if($pathrow[0]!="") unlink($pathrow[0]);
       if($proposalpath_size!=0){
         $f=$copyf."/".$proposalpath_name;
         $sql = $sql.",proposal_path='$f'";
         copy($proposalpath,$f);
       }else{
         $sql = $sql.",proposal_path=''";
       }
     }

     for($i=1;$i<=8;$i++){
       if($photo_size[$i]!=0 and $sourcef[$i]!="yes"){
         $photo_file[$i] = fread(fopen($photo[$i],"r"),filesize($photo[$i]));
         $photo_file[$i] = addslashes($photo_file[$i]);
         $photo_types[$i]=$photo_type[$i];
	 $sqltmp=",photo".$i."='$photo_file[$i]',file".$i."_type='$photo_types[$i]'";
         $sql = $sql.$sqltmp;
       }elseif($sourcef[$i]!="yes" and $photo_size[$i]==0){
         $sqltmp=",photo".$i."=NULL,file".$i."_type=NULL";
         $sql = $sql.$sqltmp;
       }
     }
     //if($photo1_size!=0 and $sourcef1!="yes"){
     //  $photo1_file = fread(fopen($photo1,"r"),filesize($photo1));
     //  $photo1_file = addslashes($photo1_file);
     //  $photo1_types=$photo1_type;
     //  $sql = $sql.",photo1='$photo1_file',file1_type='$photo1_types'";
     //}elseif($sourcef1!="yes" and $photo1_size==0){
     //  $sql = $sql.",photo1=NULL,file1_type=''";
     //}

     $sql=$sql." where community_no='$editno'";
     Mysql_query($sql);
     $upemployee="update employee set family_id='".$family."' where id='".$employee."'";
     Mysql_query($upemployee);
     Header("Location:../communityframe.html");
     }
     break;
  case 4: //好站相連
     //if(count($phone)<>0)
     //  $phonea=$phone[1].",".$phone[2].",".$phone[3];
     if($dba=="add"){
     $sql = "insert into link (link_id,name,link_address";
     //if($photo_size<>0){
     //  $photo_file = fread(fopen($photo,"r"),filesize($photo));
     //  $photo_file = addslashes($photo_file);
     //  $photo_types=$photo_type;
     //  $sql = $sql.",photo,file_type";
     //}
     $sql=$sql.") values ('$linkid','$name','$link_address'";
     //if($photo_size<>0)
     //  $sql = $sql.",'$photo_file','$photo_types'";
     $sql=$sql.")";
     Mysql_query($sql);
     Header("Location:link.php?dba=add");
     }elseif($dba=="edit"){
       $sql = "update link set link_id='$linkid',name='$name',link_address='$link_address'";
       //if($photo_size!=0 and $sourcef!="yes"){
       //  $photo_file = fread(fopen($photo,"r"),filesize($photo));
       //  $photo_file = addslashes($photo_file);
       //  $photo_types=$photo_type;
       //  $sql = $sql.",photo='$photo_file',file_type='$photo_types'";
       //}elseif($sourcef!="yes" and $photo_size==0){
       //  $sql = $sql.",photo=NULL,file_type=''";
       //}
       $sql=$sql." where link_no='$editno'";
       Mysql_query($sql);
       Header("Location:../client/linkbrowse.php");
     }
     break;
  case 5: //計劃公告
     $copyf=CheckUploadDir("proposal","");
     //if(count($phone)<>0)
     //  $phonea=$phone[1].",".$phone[2].",".$phone[3];
     if($dba=="add"){
       $sql = "insert into link (link_id,name,executive_section,note";
     if($linkaddress!="")
       $sql = $sql.",link_address";
     if($linkpath_size!=0){
       $sql = $sql.",link_path";
       $f=$copyf."/".$linkpath_name;
     }
     $sql=$sql.") values ('4','$name','$executive_section','$note'";
     if($linkaddress!="")
       $sql = $sql.",'$linkaddress'";
     if($linkpath_size!=0){
       $sql = $sql.",'$f'";
       copy($linkpath,$f);
     }
     $sql=$sql.")";
     Mysql_query($sql);
     Header("Location:proposal.php?dba=add");
    }elseif($dba="edit"){
       $sql = "update link set name='$name',executive_section='$executive_section',note='$note'";
       if($linkpath_size!=0 or ($sourcef!="yes" and $linkpath_size==0)){
         $pathsql=Mysql_query("select link_path from link where link_no=$editno");
         $pathrow=Mysql_fetch_row($pathsql);
         if($pathrow[0]!="") unlink($pathrow[0]);
         if($linkpath_size!=0){
           $f=$copyf."/".$linkpath_name;
           $sql = $sql.",link_path='$f'";
           copy($linkpath,$f);
         }else{
           $sql = $sql.",link_path=''";
         }
       }
     $sql=$sql." where link_no='$editno'";
     Mysql_query($sql);
     Header("Location:../client/proposalbrowse.php");
    }
     break;
  case 6: //最新消息
     if(count($datetime)!=0)
       $datetimea=$datetime[1]."/".$datetime[2]."/".$datetime[3];
     $copyf=($linkid!="titbits")? CheckUploadDir("news","") : $copyf=CheckUploadDir("titbits","");
     if($dba=="add"){
       $sql = "insert into news (classid,link_id,datetime,contents";
       if($linkaddress!="")
         $sql = $sql.",link_address";
       if($linkpath_size!=0){
         $sql = $sql.",link_path";
         $f=$copyf."/".$linkpath_name;
       }
       if($linkid!="titbits")
		$sql=$sql.") values ('news','$btype','$datetimea','$contents'";
       else
		$sql=$sql.") values ('$linkid','','$datetimea','$contents'";
       if($linkaddress!="")
         $sql = $sql.",'$linkaddress'";
       if($linkpath_size!=0){
         $sql = $sql.",'$f'";
         echo copy($linkpath,$f);
       }
       $sql=$sql.")";
       Mysql_query($sql);
       Header("Location:news.php?btype=$btype&dba=add");
     }elseif($dba=="edit"){
      $pathsql=Mysql_query("select link_path from news where new_no=$editno");
      $pathrow=Mysql_fetch_row($pathsql);
      if($linkid!="titbits"){
       $sql = "update news set link_id='$linkid',datetime='$datetimea',contents='$contents',link_address='$linkaddress'";
       if($linkpath_size!=0 or ($sourcef!="yes" and $linkpath_size==0)){
         if($pathrow[0]!="") unlink($pathrow[0]);
         if($linkpath_size!=0){
           $f=$copyf."/".$linkpath_name;
           $sql = $sql.",link_path='$f'";
           copy($linkpath,$f);
         }else{
           $sql = $sql.",link_path=''";
         }
       } //$linkpath_size!=0 or ($sourcef!="yes" and $linkpath_size==0)
      }else{ //活動報導程式開始
       $sql = "update news set classid='$linkid',link_id='',datetime='$datetimea',contents='$contents',link_address='$linkaddress'";
       if($linkpath_size!=0 or ($sourcef!="yes" and $linkpath_size==0)){
         if($pathrow[0]!="") unlink($pathrow[0]);
         if($linkpath_size!=0){
           $f=$copyf."/".$linkpath_name;
           $sql = $sql.",link_path='$f'";
           copy($linkpath,$f);
         }else{
           $sql = $sql.",link_path=''";
         }
       }elseif($sourcef=="yes" and $linkpath_size==0){ //move file
         if($pathrow[0]!=""){ //start move file
	   $filename_s=basename($pathrow[0]);
	   $f=$copyf."/".$filename_s;
           $sql = $sql.",link_path='$f'";
	   copy($pathrow[0],$f);
 	   unlink($pathrow[0]);
	   $mkfiledir=explode(".",$pathrow[0]);
	   $checkv=$mkfiledir[0];
	   if(is_dir($checkv) and !is_file($checkv)){ //有圖片檔資料夾
	    $mkfiledir=explode(".",$filename_s);
 	    $copyf=CheckUploadDir("titbits",$mkfiledir[0]);
	    Chdir($checkv);
	    $dir=Opendir(".");
	    Rewinddir($dir);
	    While($file=Readdir($dir)){
	      $subcopyf=$copyf."/".$mkfiledir[0]."/".$file;
	      copy($file,$subcopyf);
              unlink($file);
 	    } //while
	    rmdir($checkv);
	   } //if 有圖片檔資料夾
         } //start move file
       } //$sourcef=="yes" and $linkpath_size==0

      }//活動報導程式結束
     $sql=$sql." where new_no=$editno";
     Mysql_query($sql);
     Header("Location:../client/newsbrowse.php?btype=$btype");
   } //case 6 over
   break;
 case 10: //活動報導
     if(count($datetime)!=0)
       $datetimea=$datetime[1]."/".$datetime[2]."/".$datetime[3];
     if($dba=="add"){
       $copyf=CheckUploadDir($btype,"");
       $sql = "insert into news (classid,datetime,contents";
       if($linkaddress!="")
         $sql = $sql.",link_address";
       if($linkpath_size!=0){
         $sql = $sql.",link_path";
         $f=$copyf."/".$linkpath_name;
       }
       $sql=$sql.") values ('$btype','$datetimea','$contents'";
       if($linkaddress!="")
         $sql = $sql.",'$linkaddress'";
       if($linkpath_size!=0){
         $sql = $sql.",'$f'";
         copy($linkpath,$f);
       }
       $sql=$sql.")";
       Mysql_query($sql);
       Header("Location:active.php?btype=$btype&dba=add");
     }elseif($dba=="edit"){
       $copyf=($btype=="case" or $linkid=="titbits") ? CheckUploadDir($btype,"") : CheckUploadDir("news","");
       $pathsql=Mysql_query("select link_path from news where new_no=$editno");
       $pathrow=Mysql_fetch_row($pathsql);
       if($btype=="case" or $linkid=="titbits"){
         $sql = "update news set datetime='$datetimea',contents='$contents',link_address='$linkaddress'";
         if($linkpath_size!=0 or ($sourcef!="yes" and $linkpath_size==0)){
           if($pathrow[0]!="") unlink($pathrow[0]);
           if($linkpath_size!=0){
             $f=$copyf."/".$linkpath_name;
             $sql = $sql.",link_path='$f'";
             copy($linkpath,$f);
           }elseif($linkid){
             $sql = $sql.",link_path=''";
           }
         } //$linkpath_size!=0 or ($sourcef!="yes" and $linkpath_size==0)
	}else{ //最新消息程式開始
	 $sql = "update news set classid='news',link_id='$linkid',datetime='$datetimea',contents='$contents',link_address='$linkaddress'";
         if($linkpath_size!=0 or ($sourcef!="yes" and $linkpath_size==0)){
           if($pathrow[0]!="") unlink($pathrow[0]);
           if($linkpath_size!=0){
             $f=$copyf."/".$linkpath_name;
             $sql = $sql.",link_path='$f'";
             copy($linkpath,$f);
           }else{
             $sql = $sql.",link_path=''";
           }
         }elseif($sourcef=="yes" and $linkpath_size==0){ //move file
           if($pathrow[0]!=""){ //start move file
	     $filename_s=basename($pathrow[0]);
	     $f=$copyf."/".$filename_s;
             $sql = $sql.",link_path='$f'";
	     copy($pathrow[0],$f);
 	     unlink($pathrow[0]);
	     $mkfiledir=explode(".",$pathrow[0]);
	     $checkv=$mkfiledir[0];
	     if(is_dir($checkv) and !is_file($checkv)){ //有圖片檔資料夾
	       $mkfiledir=explode(".",$filename_s);
 	       $copyf=CheckUploadDir("news",$mkfiledir[0]);
	       Chdir($checkv);
	       $dir=Opendir(".");
	       Rewinddir($dir);
	       While($file=Readdir($dir)){
	         $subcopyf=$copyf."/".$mkfiledir[0]."/".$file;
	         copy($file,$subcopyf);
		 unlink($file);
 	       } //while
	       rmdir($checkv);
	     } //if 有圖片檔資料夾
           } //start move file
         } //$sourcef=="yes" and $linkpath_size==0

      }//最新消息程式結束
       $sql=$sql." where new_no=$editno";
     Mysql_query($sql);
     Header("Location:../client/activebrowse.php?btype=$btype");
     } //case 10 over
   break;
 case 11: //家族
     if($dba=="add"){
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
       }
       $sql = "insert into family_class (family_id,family_name,link_address,family_desc";
       $sql=$sql.") values ('$i','$family_name','$link_address','$family_desc')";
       Mysql_query($sql);
       Header("Location:family.php?dba=add");
     }elseif($dba=="edit"){
       $sql = "update family_class set family_name='$family_name',link_address='$link_address',family_desc='$family_desc' where family_id='".$editno."'";
       Mysql_query($sql);
       Header("Location:../communityframe.html");
     }
     break;
 case 12: //上傳地圖
     $f="../image/3rdmap2.jpg";
     copy($mappath,$f);
     if($keepposition=="yes")
       Mysql_query("update community set map_position=''");
?>
     <script>
       window.parent.location.replace("../communityframe.html")
     </script>
<?
     break;
}
?>
