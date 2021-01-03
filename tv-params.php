<?php
  require_once 'lib/tvheadend.php';

  //IP and access-data for tvheadend:
  define("TVHEADENDIP", "10.0.0.10");
  define("TVHEADENDUSER", "");
  define("TVHEADENDPWD", "");

  //varios text-constants
  //feel free to change it to your own language :-)
  //German version:
  define("TXTEPG","Programmvorschau");
  define("TXTPVR","Aufnahmen");
  define("TXTCHANNEL","Sender");
  define("TXTTITLE","Titel");
  define("TXTSTATUS","Status");
  define("TXTDATETIME","Datum/Uhrzeit");
  define("TXTREMOVE","l&ouml;schen");
  define("TXTSCHEDULED","geplant");
  define("TXTUSERABORT","manuell abgebrochen");
  define("TXTSUCCESS","erfolgreich");
  define("TXTRUNNING","l&auml;uft");
  define("TXTFILEMISSING","Datei fehlt");
  define("TXTTIMEMISSED","fehlgeschlagen");
  //English version:
  //define("TXTEPG","program guide");
  //define("TXTPVR","recordings");
  //define("TXTCHANNEL","channels");
  //define("TXTTITLE","title");
  //define("TXTSTATUS","status");
  //define("TXTDATETIME","date/time");
  //define("TXTREMOVE","remove");
  //define("TXTSCHEDULED","scheduled");
  //define("TXTUSERABORT","aborted by user");
  //define("TXTSUCCESS","successful");
  //define("TXTRUNNING","running");
  //define("TXTFILEMISSING","file missing");
  //define("TXTTIMEMISSED","time missed");

  //various constants
  define("BROWSERTITLE", "Tvheadend Browser Client");
  define("VERSION","1.0 Beta");

  //number of days displayed in the forecast
  //this function can be modified to make this parameter flexible
  function number_of_days()
    {
    return 5;
    }

?>