<HTML>
<link rel="icon" href="icon/tv-icon.ico">

<HEAD>
<style>
  body 
    { 
    font-size: 100%; 
    min-width: 350;
    }

  @media screen and (max-width: 800px)
    {
    body{ font-size: 70%; }
    }

  .topnav 
    {
    overflow: hidden;
    background-color: #5dd39e;  
    }

  .topnav a 
    {
    float: left;
    text-align: center;
    padding: 5px 10px;
    text-decoration: none;
    font-size: 1.2em; 
    }

  .topnav a:hover 
    {
    background-color: #7df3be;
    }

  .topnav a.active 
    {
    background-color: #3db37e;
    }

  a:link 
    {
    color: #E0E0E0;
    background-color: transparent;
    text-decoration: none;
    }

  a:visited 
    {
    color: #E0E0E0;
    background-color: transparent;
    text-decoration: none;
    }

  a:hover 
    {
    color: white;
    background-color: transparent;
    text-decoration: underline; 
    }

  a:active 
    {
    color: white;
    background-color: transparent;
    text-decoration: underline;
    }

</style>

<?php

  require_once 'tv-params.php';

  header("Cache-Control: no-cache");

  $options=array(TXTEPG,TXTPVR);
  $action=$options[0];

  if (isset($_GET["ACTION"]))
    {
    $action=$_GET["ACTION"];
    }

  echo"<title>".BROWSERTITLE." ".VERSION."</title>\r\n";
?>

<script>
  var orgrh;
  var orglw;
  var epgwin;
  var orgtcw=[];
  var orgrcw=[];

<?php
  if ($action==$options[0])
    {
    echo "  window.onload=initelements0;\r\n";
    echo "  window.onresize=modify0;\r\n";
    }
  if ($action==$options[1])
    {
    echo "  window.onload=initelements1;\r\n";
    echo "  window.onresize=modify1;\r\n";
    }
?>

  function modify0()
    {
    let rh=orgrh;
    let lw=orglw;
    if (window.innerWidth<800)
      {
      rh=0.7*orgrh;
      lw=0.7*orglw;
      }
    var table = document.getElementById("channeltable");
    let rowsnum=table.rows.length;
    for (i=0;(i<(rowsnum-1));i++)
      {
      table.rows[i].style.height=rh;
      document.getElementById("epgtable"+i).rows[0].style.height=rh;
      if (document.getElementById("logo"+i)!=null)
        {
        document.getElementById("logo"+i).width=lw;
        }
      }
    var w=window.innerWidth-175;
    var h=window.innerHeight-115;
    if (w<300) w=300;
    if (h<200) h=200;
    document.getElementById("divHeader").style.width=w-20;
    document.getElementById("table_div").style.width=w;
    document.getElementById("firstcol").style.height=h;
    document.getElementById("table_div").style.height=h;
    }

  function modify1()
    {
    let rh=orgrh;
    let lw=orglw;
    let f=1;
    if (window.innerWidth<800)
      {
      rh=0.7*orgrh;
      lw=0.7*orglw;
      f=0.7;
      }
    var table = document.getElementById("rectable");
    let rowsnum=table.rows.length;
    for (i=0;(i<rowsnum);i++)
      {
      table.rows[i].style.height=rh;
      if (document.getElementById("logo"+i)!=null)
        {
        document.getElementById("logo"+i).width=lw;
        }
      if (document.getElementById("remove"+i)!=null)
        {
        document.getElementById("remove"+i).width=lw;
        }
      for (j=0;(j<(document.getElementById("rectable").rows[i].cells.length-1));j++)
        {
        document.getElementById("rectable").rows[i].cells[j].style.width=f*orgrcw[j];
        }
      }
    let totalw=0;
    for (i=0;(i<(document.getElementById("titletable").rows[0].cells.length-1));i++)
      {
      document.getElementById("titletable").rows[0].cells[i].style.width=f*orgtcw[i];
      totalw=totalw+document.getElementById("titletable").rows[0].cells[i].offsetWidth;
      }
    var w=window.innerWidth-17;
    var h=window.innerHeight-100;
    if (w<300) w=300;
    if (h<200) h=200;
    document.getElementById("divHeader").style.width=w-20;
    document.getElementById("table_div").style.width=w;
    document.getElementById("table_div").style.height=h;
    if (totalw<w) totalw=w-15;
    document.getElementById("titletable").style.width=totalw;
    document.getElementById("rectable").style.width=totalw;
    }

  function initelements0()
    {
    orgrh=document.getElementById("channeltable").rows[0].offsetHeight;
    orglw=document.getElementById("logo0").width;
    modify0();
    }

  function initelements1()
    {
    orgrh=document.getElementById("rectable").rows[0].offsetHeight;
    orglw=document.getElementById("logo0").width;
    for (i=0;(i<(document.getElementById("titletable").rows[0].cells.length-1));i++)
      {
      orgtcw[i]=document.getElementById("titletable").rows[0].cells[i].offsetWidth;
      }
    for (i=0;(i<(document.getElementById("rectable").rows[0].cells.length-1));i++)
      {
      orgrcw[i]=document.getElementById("rectable").rows[0].cells[i].offsetWidth;
      }
    modify1();
    }

  function fnScroll0()
    {
    var x=document.getElementById("table_div").scrollLeft;
    var y=document.getElementById("table_div").scrollTop;
    document.getElementById("firstcol").scrollTop=y;
    document.getElementById("divHeader").scrollLeft=x;
    }
  
  function fnScroll1()
    {
    var x=document.getElementById("table_div").scrollLeft;
    document.getElementById("divHeader").scrollLeft=x;
    }

  function transmitdata(eventid)
    {
    setTimeout(function(){epgwin.registerelement(document.getElementById(eventid), document.getElementById('ref'+eventid), window);}, 2000);
    }

  function openepg(eventid)
    {
    epgwin=window.open("tv-epgscreen.php?eventid="+eventid, "epgwindow", "width=900,height=500,toolbar=no,status=no");
    transmitdata(eventid);
    return false;
    }

</script>

</HEAD>

<BODY bgcolor="#606060" text="#E0E0E0" style="font-family:Calibri">

<?php

  $session="";
  if (isset($_GET["SESSION"])) 
    {
    $session=$_GET["SESSION"];
    }  
  
  if ((isset($_GET["ACTION"])) && ($action==$options[1]) && (isset($_GET["DELETEID"])))
    {
    dvrremoveevent(TVHEADENDIP,$_GET["DELETEID"],TVHEADENDUSER,TVHEADENDPWD);
    }

  echo "<div class='topnav' width='100%'>\r\n";
  foreach ($options as $option)
    {
    echo "<a ";
    if ($action==$option) echo "class='active' "; 
    echo "href='tv.php?SESSION=".$session."&ACTION=".$option."'>".$option."</a>\r\n";
    }
  echo "</div>\r\n<br>\r\n";

  $channellist=getchanneldata(TVHEADENDIP,TVHEADENDUSER,TVHEADENDPWD);

  if ($action==$options[0])
    {
    $rec=getupcomingrec(TVHEADENDIP,TVHEADENDUSER,TVHEADENDPWD);

    $rowheight=70;                           //Zeilenhoehe
    $rownum=10;                              //Anzahl Zeilen
    $pixmin=2;                               //2 Pixel pro Minuten
    $acttime=intdiv(time(),60)*60;           //auf ganze Minuten bringen
    //die folgenden Zeilen berechnen die Zeitdifferenz zu UTC
    $offset=(date("H",$acttime)*3600+date("i",$acttime)*60)-($acttime%86400);
    if (offset<0) $offset=$offset+86400;
    $passedday=($acttime+$offset)%86400;     //wieviele Sekunden hat der Tag noch?
    $passedwidth=$passedday/60*$pixmin;   

    echo "<table style='font-size:1em; text-align: left;' cellspacing='0' cellpadding='0' border='0'>\r\n";
    echo "<tr style='background: #5dd39e;'>\r\n";
    echo "<td style='border: 1px solid #eee;'><b>".TXTCHANNEL."</b></td>\r\n";
    echo "<td style='border: 1px solid #eee;'>\r\n";
    echo "<div id='divHeader' style='overflow:hidden;width:2000px'>\r\n";
    echo "<table width='".(1440*number_of_days()*$pixmin)."px' style='font-size:1em; text-align: left;' cellspacing='0' cellpadding='0' border='0'>\r\n";  // 3 Tage = 4320 Minuten
    echo "<tr style='background: #5dd39e;'>\r\n";
    echo "<td style='width:".(1440*$pixmin-$passedwidth-1)."px; border-right: 1px solid #eee;'><div class='tableHeader 'style='width:".(1440*$pixmin-$passedwidth-2)."px; overflow: hidden;'>".date("d.m",$acttime)."</div></td>\r\n";
    $i=1;
    for (;($i<number_of_days());$i++)
      {
      echo "<td style='width:".(1440*$pixmin-1)."px; border-right: 1px solid #eee;'>".date("d.m",($acttime+$i*86400))."<div class='tableHeader'></div></td>\r\n";
      }
    echo "<td style='width:".($passedwidth-1)."px;border-right: 1px solid #eee;'><div class='tableHeader'>".date("d.m",($acttime+$i*86400))."</div></td>\r\n";
    echo "</tr>\r\n";
    echo "</table>\r\n";
    echo "<table width='".(1440*number_of_days()*$pixmin)."px' style='font-size:1em; text-align: left;' cellspacing='0' cellpadding='0' border='0'>\r\n";
    echo "<tr style='background: #5dd39e;'>\r\n";
    $x=0;
    $starttime=intdiv(($acttime),3600)*3600;
    $end=intdiv((3600-$acttime%3600),60);
    for($i=0; ($i<=(24*number_of_days())); $i++)
      {
      if ($end>(1440*number_of_days())) $end=(1440*number_of_days());
      echo "<td style='width:".(($end-$x)*$pixmin-1)."px; border-right: 1px solid #eee;'><div class='tableHeader' style='width:".(($end-$x)*$pixmin-3)."px; overflow: hidden;'>";
      if ($end>=59) echo date("H:i",($starttime+$i*3600));
      echo "</div></td>\r\n";
      $x=$end;
      $end=$end+60;
      }
    echo "</tr>\r\n";
    echo "</table>\r\n";
    echo "</div>\r\n";
    echo "</td>\r\n";
    echo "</tr>\r\n";

    echo "<tr>\r\n";
    echo "<td valign='top'>\r\n";
    echo "<div id='firstcol' style='overflow: hidden; height:".($rowheight*$rownum)."px'>\r\n";
    echo "<table id='channeltable' style='font-size:1em; text-align: left;' cellspacing='0' cellpadding='0' border='0'>\r\n";
    $cnt=0;
    foreach ($channellist as $channel)
      {
      echo "<tr style='background: #5dd39e; height: ".$rowheight."px'>\r\n";
      echo "<td style='width:55px; border-bottom: 1px solid #eee; border-left: 1px solid #eee;' class='Col1'>\r\n";
      $chlogo="";
      if (isset($channel["icon_public_url"])) 
        {
        $chlogo="&logo=".$channel["icon_public_url"];
        echo "<a href='tv-screen.php?channel=".base64_encode($channel["uri"]).$chlogo."&chnam=".$channel["name"]."' target='tvwindow' ";
        echo "onclick=\"window.open('tv-screen.php?channel=".base64_encode($channel["uri"]).$chlogo."&chnam=".$channel["name"]."', 'tvwindow', 'width=900,height=500,toolbar=no,status=no'); return false;\">";
        echo "<img id='logo".$cnt."' src='".$channel["icon_public_url"]."' width='50'>\r\n";
        echo "</a>\r\n";
        }
      echo "</td>\r\n";
      echo "<td class='Col2' style='width:100px; border-bottom: 1px solid #eee; border-right: 1px solid #eee;'>\r\n";
      $cnt++;
      if (isset($channel["name"])) 
        {
        echo "<a href='tv-screen.php?channel=".base64_encode($channel["uri"]).$chlogo."&chnam=".$channel["name"]."' target='tvwindow' ";
        echo "onclick=\"window.open('tv-screen.php?channel=".base64_encode($channel["uri"]).$chlogo."&chnam=".$channel["name"]."', 'tvwindow', 'width=900,height=500,toolbar=no,status=no'); return false;\">";
        echo $channel["name"]."\r\n";
        echo "</a>\r\n";
        }
      echo "</td>\r\n";
      echo "</tr>\r\n";
      }
    echo "<tr style='background: #5dd39e; height: ".$rowheight."px'>\r\n";
    echo "<td style='border-bottom: 1px solid #eee; border-left: 1px solid #eee; border-right: 1px solid #eee;' class='Col1' colspan=2>\r\n";
    echo "</td>\r\n";
    echo "</tr>\r\n";
    echo "</table>\r\n";
    echo "</div>\r\n";
    echo "</td>\r\n";

    echo "<td valign='top'>\r\n";
    echo "<div id='table_div' style='overflow: scroll;width:2020px;height:".($rowheight*$rownum+16)."px;position:relative' onscroll='fnScroll0()'>\r\n";
    $cnt=0;
    foreach ($channellist as $channel)
      {
      echo "<table id='epgtable".$cnt."' width='".(1440*number_of_days()*$pixmin)."px' style='font-size:1em; text-align: left;' cellspacing='0' cellpadding='0' border='0'>\r\n";
      $cnt++;
      echo "<tr style='height:".$rowheight."px;'>\r\n";
      $epg=getepgdata(TVHEADENDIP, $channel["uuid"],TVHEADENDUSER,TVHEADENDPWD);
      $last=$acttime;
      $x=0;
      foreach($epg as $entry)
        {
        $start=$entry["start"];
        $stop=$entry["stop"];
        if (($stop>$start) && ($stop>$acttime) && ($start<($acttime+86400*number_of_days())))
          {
          if ($start<$acttime)
            {
            $start=$acttime;
            }
          if ($stop>($acttime+86400*number_of_days()))
            {
            $stop=($acttime+86400*number_of_days());
            }
          if ($last!=$start)
            {
            $start=$last;
            }
          $last=$stop;
          $w=intdiv(($stop-$acttime),60)-$x;
          if ($w>0)
            {
            $x=$x+$w;
            $col="";
            $recpar="";
            if (isset($rec[$entry["channelUuid"]][$entry["eventId"]])) 
              {
              $col="background: #FF0000;";
              $recpar="&record=set";
              }
            echo "<td id=".$entry["eventId"]." style='width:".($w*$pixmin)."px; border-right: 1px solid #eee;border-bottom: 1px solid #eee;".$col."'>\r\n";
            echo "<div style='overflow: hidden; width:".($w*$pixmin-2)."px; height:100%; white-space:nowrap'>\r\n";
            echo "<a id=ref".$entry["eventId"]." href='tv-epgscreen.php?eventid=".$entry["eventId"].$recpar."' target='epgwindow' ";
            echo "onclick=\"openepg(".$entry["eventId"].");\">";
            echo date("H:i",$entry["start"])."-".date("H:i",$entry["stop"])."<br>";
            echo $entry["title"];
            echo "</a>\r\n";
            echo "</div>\r\n";
            echo "</td>\r\n";
            }
          }
        }
      echo "<td style='overflow: hidden; width:".((1440*number_of_days()-$x)*$pixmin)."px; border-bottom: 1px solid #eee;'></td>\r\n";
      echo "</tr>\r\n";
      echo "</table>\r\n";
      }
    echo "</div>\r\n";
    echo "</td>\r\n";

    echo "</tr>\r\n";
    echo "</table>\r\n";
    }

  if ($action==$options[1])
    {
    $newchannellist=array();
    foreach($channellist as $key=>$entry)
      {
      $newchannellist[$entry["uuid"]]=$entry;
      }

    $rectemp=array();
    $rec=array();
    
    $rectemp=getallrec(TVHEADENDIP,TVHEADENDUSER,TVHEADENDPWD);
    foreach($rectemp as $key=>$entry)
      {
      $rec[$entry["start"]."-".$key]=$entry;
      if (isset($newchannellist[$rec[$entry["start"]."-".$key]["channel"]]["icon_public_url"]))
        {
        $rec[$entry["start"]."-".$key]["icon_public_url"]=$newchannellist[$rec[$entry["start"]."-".$key]["channel"]]["icon_public_url"];
        }
      $rec[$entry["start"]."-".$key]["channel"]=$newchannellist[$rec[$entry["start"]."-".$key]["channel"]]["name"];
      }
    ksort($rec);

    $rowheight=70;                           //Zeilenhoehe
    echo "<table style='font-size:1em; text-align: left;' cellspacing='0' cellpadding='0' border='0'>\r\n";
    echo "<tr style='background: #5dd39e;'>\r\n";
    echo "<td style='border: 1px solid #eee;'>\r\n";

    echo "<div id='divHeader' style='overflow:hidden;width:2000px'>\r\n";
    echo "<table id='titletable' width='2000px' style='font-size:1em; text-align: left;' cellspacing='0' cellpadding='0' border='0'>\r\n";
    echo "<tr style='background: #5dd39e;'>\r\n";
    echo "<td style='width:400px; border-right: 1px solid #eee;'><b>".TXTTITLE."</b></td>\r\n";
    echo "<td style='width:170px; border-right: 1px solid #eee;'><b>".TXTCHANNEL."</b></td>\r\n";
    echo "<td style='width:150px; border-right: 1px solid #eee;'><b>".TXTSTATUS."</b></td>\r\n";
    echo "<td style='width:150px; border-right: 1px solid #eee;'><b>".TXTDATETIME."</b></td>\r\n";
    echo "<td style='text-align: center; width:100px; border-right: 1px solid #eee;'><b>".TXTREMOVE."</b></td>\r\n";
    echo "<td style='border-right: 1px solid #eee;'></td>\r\n";
    echo "</tr>\r\n";
    echo "</table>\r\n";
    echo "</div>\r\n";

    echo "</td>\r\n";
    echo "</tr>\r\n";
    echo "<tr>\r\n";
    echo "<td valign='top'>\r\n";

    echo "<div id='table_div' style='overflow: scroll;width:2020px;height:1000px;position:relative' onscroll='fnScroll1()'>\r\n";
    echo "<table id='rectable' width='2000px' style='font-size:1em; text-align: left;' cellspacing='0' cellpadding='0' border='0'>\r\n";
    $cnt=0;
    foreach($rec as $entry)
      {
      echo "<tr style='height:".$rowheight."px;'>\r\n";
      echo "<td style='width:400px; border-right: 1px solid #eee;border-bottom: 1px solid #eee;border-left: 1px solid #eee;'>\r\n";
      echo $entry["disp_title"]."<br>".$entry["disp_subtitle"]."\r\n";
      echo "</td>\r\n";
      echo "<td style='width:55px; border-bottom: 1px solid #eee;'>\r\n";
      if (isset($entry["icon_public_url"])) 
        {
        echo "<img id='logo".$cnt."' src='".$entry["icon_public_url"]."' width='50'>\r\n";
        }
      echo "</td>\r\n";
      echo "<td style='width:115px; border-right: 1px solid #eee;border-bottom: 1px solid #eee;'>\r\n";
      echo $entry["channel"]."\r\n";
      echo "</td>\r\n";
      $status=$entry["status"];
      $statstyle="";
      if ($status=="Scheduled for recording")
        {
        $statstyle="color: orange;";
        $status=TXTSCHEDULED;
        }
      if ($status=="Aborted by user")
        {
        $statstyle="color: lightgreen;";
        $status=TXTUSERABORT;
        }
      if ($status=="Completed OK")
        {
        $statstyle="color: lightgreen;";
        $status=TXTSUCCESS;
        }
      if ($status=="Running")
        {
        $statstyle="color: blue;";
        $status=TXTRUNNING;
        }
      if ($status=="File missing")
        {
        $statstyle="color: red;";
        $status=TXTFILEMISSING;
        }
      if ($status=="Time missed")
        {
        $statstyle="color: red;";
        $status=TXTTIMEMISSED;
        }
      echo "<td style='width:150px; border-right: 1px solid #eee;border-bottom: 1px solid #eee;".$statstyle."'>\r\n";
      echo $status."\r\n";
      echo "</td>\r\n";
      echo "<td style='width:150px; border-right: 1px solid #eee;border-bottom: 1px solid #eee;'>\r\n";
      echo date("d.m.Y",$entry["start"])."<br>".date("H:i",$entry["start"])."-".date("H:i",$entry["stop"])."\r\n";
      echo "</td>\r\n";
      echo "<td style='text-align: center; width:100px; border-right: 1px solid #eee;border-bottom: 1px solid #eee;'>\r\n";
      echo "<a href='tv.php?DELETEID=".$entry["uuid"]."&SESSION=".$session."&ACTION=".$option."'>\r\n";
      echo "<img id='remove".$cnt."' src='icon/remove.png' width='50'>\r\n";
      echo "</a>\r\n";
      echo "</td>\r\n";
      echo "<td style='border-right: 1px solid #eee;border-bottom: 1px solid #eee;'></td>\r\n";
      echo "</tr>\r\n";
      $cnt++;
      }
    echo "</table>\r\n";
    echo "</div>\r\n";

    echo "</td>\r\n";
    echo "</tr>\r\n";
    echo "</table>\r\n";
    }

?>

</BODY>

</HTML>