<?php

  //refer also: https://github.com/dave-p/TVH-API-docs/wiki/Dvr
  //            https://oberguru.net/tvheadend/api.html  

  function getchanneluris($ip, $format="matroska", $user="", $password="")
    {
    $rv=array();
    if (($user!="") || ($password!=""))
      {
      $sfh=fopen("http://".$user.":".$password."@".$ip.":9981/playlist?profile=".$format,"r");
      }
    else
      {
      $sfh=fopen("http://".$ip.":9981/playlist?profile=".$format,"r");
      }
    while (!feof($sfh)) 
      {
      $line=fgets($sfh);
      $line=preg_replace("#[\r\n]#", '', $line);
      if (substr($line,0,8)=="#EXTINF:")
        {
        $channelname=substr($line,strpos($line,"\",")+2);
        $line=fgets($sfh);
        $line=preg_replace("#[\r\n]#", '', $line);
        $rv[]=array('NAME' => $channelname, 'URI' => $line);
        }
      }    
    fclose($sfh);
    return $rv;
    }

  function getchanneldata($ip, $user="", $password="")
    {
    $rv=array();
    $tags=array();
    $userpwd="";
    if (($user!="") || ($password!=""))
      {
      $userpwd=$user.":".$password."@";
      $data=file_get_contents("http://".$user.":".$password."@".$ip.":9981/api/channel/grid","r");
      $channeltags=json_decode(file_get_contents("http://".$user.":".$password."@".$ip.":9981/api/channeltag/list?limit=0","r"), true);
      }
    else
      {
      $data=file_get_contents("http://".$ip.":9981/api/channel/grid","r");
      $channeltags=json_decode(file_get_contents("http://".$ip.":9981/api/channeltag/list?limit=0","r"), true);
      }
    foreach ($channeltags["entries"] as $tag)
      {
      $tags[$tag["key"]]=$tag["val"];
      }
    foreach (json_decode($data, true)["entries"] as $entry)
      {
      if ($entry["enabled"]==1)
        {
        $rv[$entry[number]]=$entry;
        $rv[$entry[number]]["uri"]="http://".$userpwd.$ip.":9981/stream/channel/".$entry[uuid]."?profile=webtv-sd";
        if (isset($entry["icon_public_url"]))
          {
          $rv[$entry[number]]["icon_public_url"]="http://".$ip.":9981/".$entry["icon_public_url"];
          }
        $i=0;
        foreach($rv[$entry[number]]["tags"] as $tag)
          {
          $rv[$entry[number]]["tags"][$i]=$tags[$rv[$entry[number]]["tags"][$i]];
          if ($rv[$entry[number]]["tags"][$i]=="HDTV")
            {
            $rv[$entry[number]]["uri"]="http://".$userpwd.$ip.":9981/stream/channel/".$entry[uuid]."?profile=webtv-hd";
            }
          $i++;
          }
        }
      }
    ksort($rv);
    return $rv;
    }

  function getepgdata($ip, $channel, $user="", $password="")
    {
    $data=array();
    if (($user!="") || ($password!=""))
      {
      $data=file_get_contents("http://".$user.":".$password."@".$ip.":9981/api/epg/events/grid?channel=".$channel."&limit=1000","r");
      }
    else
      {
      $data=file_get_contents("http://".$ip.":9981/api/epg/events/grid?channel=".$channel."&limit=1000","r");
      }
    //$data = preg_replace('/[\x00-\x1F\x80-\xFF]/', '', $data); //entfernt alle nicht druckbaren Zeichen
    $data = preg_replace('/[\x00-\x1F]/', '', $data); //entfernt alle nicht druckbaren Zeichen
    $data=json_decode($data,true)["entries"];
    return $data;
    }

  function getallrec($ip, $user="", $password="")
    {
    $data=array();
    if (($user!="") || ($password!=""))
      {
      $data=file_get_contents("http://".$user.":".$password."@".$ip.":9981/api/dvr/entry/grid","r");
      }
    else
      {
      $data=file_get_contents("http://".$ip.":9981/api/dvr/entry/grid","r");
      }
    //$data = preg_replace('/[\x00-\x1F\x80-\xFF]/', '', $data); //entfernt alle nicht druckbaren Zeichen
    $data = preg_replace('/[\x00-\x1F]/', '', $data); //entfernt alle nicht druckbaren Zeichen
    $data=json_decode($data,true)["entries"];
    return $data;
    }

  function getupcomingrec($ip, $user="", $password="")
    {
    $data=array();
    if (($user!="") || ($password!=""))
      {
      $data=file_get_contents("http://".$user.":".$password."@".$ip.":9981/api/dvr/entry/grid_upcoming","r");
      }
    else
      {
      $data=file_get_contents("http://".$ip.":9981/api/dvr/entry/grid_upcoming","r");
      }
    //$data = preg_replace('/[\x00-\x1F\x80-\xFF]/', '', $data); //entfernt alle nicht druckbaren Zeichen
    $data = preg_replace('/[\x00-\x1F]/', '', $data); //entfernt alle nicht druckbaren Zeichen
    $data=json_decode($data,true)["entries"];
    $rv=array();
    foreach($data as $entry)
      {
      $rv[$entry["channel"]][$entry["broadcast"]]=$entry;
      }
    return $rv;
    }

  function getepgeventdata($ip, $eventid, $user="", $password="")
    {
    $data=array();
    if (($user!="") || ($password!=""))
      {
      $data=file_get_contents("http://".$user.":".$password."@".$ip.":9981/api/epg/events/load?eventId=".$eventid,"r");
      }
    else
      {
      $data=file_get_contents("http://".$ip.":9981/api/epg/events/load?eventId=".$eventid,"r");
      }
    $data = preg_replace('/[\x00-\x1F]/', '', $data); //entfernt alle nicht druckbaren Zeichen
    $data=json_decode($data,true)["entries"][0];
    return $data;
    }

  function getdvrconfig($ip, $user="", $password="")
    {
    $data=array();
    if (($user!="") || ($password!=""))
      {
      $data=file_get_contents("http://".$user.":".$password."@".$ip.":9981/api/dvr/config/grid","r");
      }
    else
      {
      $data=file_get_contents("http://".$ip.":9981/api/dvr/config/grid","r");
      }
    $data = preg_replace('/[\x00-\x1F]/', '', $data); //entfernt alle nicht druckbaren Zeichen
    $data=json_decode($data,true)["entries"][0];
    return $data;
    }

  function dvrcreateevent($ip, $eventid, $user="", $password="")
    {
    $data=array();
    $dvrcfg=getdvrconfig($ip, $user, $password);
    if (($user!="") || ($password!=""))
      {
      $data=file_get_contents("http://".$user.":".$password."@".$ip.":9981/api/dvr/entry/create_by_event?config_uuid=".$dvrcfg["uuid"]."&event_id=".$eventid,"r");
      }
    else
      {
      $data=file_get_contents("http://".$ip.":9981/api/dvr/entry/create_by_event?config_uuid=".$dvrcfg["uuid"]."&event_id=".$eventid,"r");
      }
    $data = preg_replace('/[\x00-\x1F]/', '', $data); //entfernt alle nicht druckbaren Zeichen
    $data=json_decode($data,true)["entries"][0];
    return $data;
    }

  function dvrcancelevent($ip, $uuid, $user="", $password="")
    {
    $data=array();
    if (($user!="") || ($password!=""))
      {
      $data=file_get_contents("http://".$user.":".$password."@".$ip.":9981/api/dvr/entry/cancel?uuid=".$uuid,"r");
      }
    else
      {
      $data=file_get_contents("http://".$ip.":9981/api/dvr/entry/cancel?uuid=".$uuid,"r");
      }
    }

  function dvrremoveevent($ip, $uuid, $user="", $password="")
    {
    $data=array();
    if (($user!="") || ($password!=""))
      {
      $data=file_get_contents("http://".$user.":".$password."@".$ip.":9981/api/dvr/entry/remove?uuid=".$uuid,"r");
      }
    else
      {
      $data=file_get_contents("http://".$ip.":9981/api/dvr/entry/remove?uuid=".$uuid,"r");
      }
    }

?>