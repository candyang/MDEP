<?
include("opendata.php"); 
?>
<html>

<head>
<style type="text/css">
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
</head>

<body background="./image/backcolor.jpg">
<?
   require("class.tree/class.tree.php3");


   $tree=new Tree("class.tree");

   $tree->set_frame("mainFrame");

   $root=$tree->open_tree("第三社區營造中心","");

   $folder1=$tree->add_folder($root,"活動看板","calend.php");

   $folder2=$tree->add_folder($root,"認識中心","");

   //$folder3=$tree->add_folder($root,"社區營造點資訊","communityframe.html");

   $folder4=$tree->add_folder($root,"社區營造資源","");
   
   $tree->add_document($root,"社區營造點資訊","communityframe.html","mainFrame");


   //$folder5=$tree->add_folder($root,"社區培力計劃","/course/all.htm");

   $tree->add_document($root,"社區培力計劃","/course/all.htm","_blank");


   //$folder6=$tree->add_folder($root,"社造計劃公告","client/proposalbrowse.php");

   //$folder7=$tree->add_folder($root,"交流討論區","client/discuss/discuss.php");
   $tree->add_document($root,"交流討論區","client/discuss/discuss.php","mainFrame");

   //$folder8=$tree->add_folder($root,"相關連結","client/linkbrowse.php");

   $tree->add_document($root,"相關連結","client/linkbrowse.php","mainFrame");


   $tree->add_document($folder1,"最新消息","client/newsbrowse.php?btype=0","mainFrame");

   $tree->add_document($folder1,"中心活動消息","client/newsbrowse.php?btype=1","mainFrame");

   $tree->add_document($folder1,"社區活動消息","client/newsbrowse.php?btype=2","mainFrame");

   $tree->add_document($folder1,"活動花絮","client/activebrowse.php?btype=titbits","mainFrame");


   $tree->add_document($folder2,"中心簡介","introduct.htm","mainFrame");

   $tree->add_document($folder2,"中心工作伙伴","client/center_teambrowse.php?btype=1","mainFrame");

   $tree->add_document($folder2,"授課/輔導老師","client/center_teambrowse.php?btype=2","mainFrame");


   //$sql=Mysql_query("select * from family_class");
   //$i=1;

   //while($family=Mysql_fetch_array($sql,MYSQL_BOTH)){
   //   $tree->add_document($folder3,$family[1],"client/communitybrowse.php?btype=$family[0]");
   //   if($i==5) break;
   //   $i++;
   // }


   //$tree->add_document($folder4,"中心社造活動","client/activebrowse.php?btype=1");

   //$tree->add_document($folder4,"陪伴計劃活動","client/activebrowse.php?btype=3");

   $tree->add_document($folder4,"社區營造個案","client/activebrowse.php?btype=case","mainFrame");

   $tree->add_document($folder4,"社造補助資訊","client/proposalbrowse.php","mainFrame");

   $tree->add_document($folder4,"知識分享區","client/knowledge/knowledge.php","mainFrame");


   //$tree->add_document($folder5,"課程公告","browse.php?btype=5");

   //$tree->add_document($folder5,"知識分享區","browse.php?btype=5");



   //$tree->add_document($folder7,"家族交流","browse.php?btype=7&discusstype=1");

   //$tree->add_document($folder7,"社區營造員交流","browse.php?btype=7&discusstype=2");

   //$tree->add_document($folder7,"社區居民交流","browse.php?btype=7&discusstype=3");

   //$tree->add_document($folder7,"社造問題法令諮詢","browse.php?btype=7&discusstype=4");


   //$tree->add_document($folder8,"分區社造中心網頁","client/linkbrowse.php?btype=1");

   //$tree->add_document($folder8,"陪伴社區網頁","client/linkbrowse.php?btype=3");

   //$tree->add_document($folder8,"相關社造網頁","client/linkbrowse.php?btype=5");


   $tree->close_tree();


?>

<a href="../index.html" target="_top"><img src="./image/back.gif" border=0 align="center"></a>

</body>

</html>

