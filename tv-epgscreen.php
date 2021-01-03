<HTML>
<link rel="icon" type="image/png" href="icon/mediacentericon.png">
<link rel="stylesheet" type="text/css" href="style/generalstyles.css">

<HEAD>

<title>Mediacenter - EPG-Ansicht</title>

</HEAD>

<script>

  var eventid;

  window.onload=initelements;

  function initelements()
    {
<?php
  if (isset($_GET["eventid"]))
    {
    echo "    window.eventid='".$_GET["eventid"]."';\r\n";
    }
?>
    }

  function registerelement(elementobj, refobj, windowobj)
    {
    window.elementobj=elementobj;
    window.windowobj=windowobj;
    window.refobj=refobj;
    document.getElementById('recbut').disabled=false;
    }

  function setstatus(stat)
    {
    if (stat==1)
      {
      window.elementobj.style.background="#FF0000";
      window.refobj.href="tv-epgscreen.php?eventid="+window.eventid+"&record=set";
      }
    else
      {
      window.elementobj.style.background="transparent";
      window.refobj.href="tv-epgscreen.php?eventid="+window.eventid;
      }
    window.windowobj.transmitdata(window.eventid);
    }

</script>

<BODY bgcolor="#606060" text="#E0E0E0" style="font-family:Calibri">

<?php
  require_once 'tv-params.php';

  if (isset($_GET["eventid"]))
    {
    $status="none";
    $epg=getepgeventdata(TVHEADENDIP, $_GET["eventid"],TVHEADENDUSER,TVHEADENDPWD);
    if (isset($_GET["record"]) && ($_GET["record"]=="set"))
      {
      $status="set";
      }
    if (isset($_GET["record"]) && ($_GET["record"]=="true"))
      {
      dvrcreateevent(TVHEADENDIP, $_GET["eventid"],TVHEADENDUSER,TVHEADENDPWD);
      $status="set";
      }
    if (isset($_GET["record"]) && ($_GET["record"]=="false"))
      {
      dvrcancelevent(TVHEADENDIP, $epg["dvrUuid"],TVHEADENDUSER,TVHEADENDPWD);
      $status="none";
      }
    echo "<table width='100%'>\r\n";
    echo "<tr>\r\n";
    echo "<td width='70px'>\r\n";
    if (isset($epg["channelIcon"])) echo "<img src='http://".TVHEADENDIP.":9981/".$epg["channelIcon"]."' width='100%'>\r\n";
    echo "</td>\r\n";
    echo "<td width='200px'>\r\n";
    echo "<b>".$epg["channelName"]."</b>\r\n";
    echo "</td>\r\n";
    echo "<td width='150' rowspan=2>\r\n";
    if ($status=="set")
      {
      echo "<center>\r\n";
      echo "  <div class='one-fifth-item'>\r\n";
      echo "    <form method='GET' style='margin-bottom: 0px' onsubmit=\"setstatus(0);\">\r\n";
      echo "      <button id='recbut' type='submit' class='tv-command' name='record' value='false' disabled><i class='material-icons' style='color: white'>stop</i></button>\r\n";
      echo "      <input type='hidden' name='eventid' value='".$_GET["eventid"]."'>\r\n";
      echo "    </form>\r\n";
      echo "  </div>\r\n";
      echo "</center>\r\n";
      }
    else
      {
      echo "<center>\r\n";
      echo "  <div class='one-fifth-item'>\r\n";
      echo "    <form method='GET' style='margin-bottom: 0px' onsubmit=\"setstatus(1);\">\r\n";
      echo "      <button id='recbut' type='submit' class='tv-command' name='record' value='true' disabled><i class='material-icons' style='color: red'>fiber_manual_record</i></button>\r\n";
      echo "      <input type='hidden' name='eventid' value='".$_GET["eventid"]."'>\r\n";
      echo "    </form>\r\n";
      echo "  </div>\r\n";
      echo "</center>\r\n";
      }
    echo "</td>\r\n";
    echo "<td>\r\n";
    echo "</td>\r\n";
    echo "</tr>\r\n";
    echo "<tr>\r\n";
    echo "<td colspan=2><b><br>\r\n";
    echo date("d.m.Y", $epg["start"])."<br>";
    echo date("H:i", $epg["start"])." - ".date("H:i", $epg["stop"])."<br><br>";
    echo "</b></td>\r\n";
    echo "</tr>\r\n";
    echo "<tr>\r\n";
    echo "<td colspan=4 style='font-size:2em'><b>\r\n";
    echo $epg["title"]."\r\n";
    echo "</b></td>\r\n";
    echo "</tr>\r\n";
    if ($status=="set")
      {
      echo "<tr>\r\n";
      echo "<td colspan=4 style='color:red'>\r\n";
      echo "<b>Aufnahme ist vorgemerkt</b>\r\n";
      echo "</td>\r\n";
      echo "</tr>\r\n";
      }
    echo "<tr>\r\n";
    echo "<td colspan=4><br>\r\n";
    $cont=$epg["description"];
    file_put_contents("/var/www/html/Mediacenter/test.txt", $cont);
    $cont=preg_replace("/\r\n/", "<br>", $cont);
    $cont=preg_replace("/\r/", "<br>", $cont);
    $cont=preg_replace("/\n/", "<br>", $cont);
    $cont=preg_replace("/\\\\n/", "<br>", $cont);
    echo $cont."\r\n";
    echo "</td>\r\n";
    echo "</tr>\r\n";
    echo "</table>\r\n";
    }
?>

</BODY>

</HTML>