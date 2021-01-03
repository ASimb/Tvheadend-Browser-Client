<HTML>

<?php
  echo "<link rel='icon' ";
  if (isset($_GET["logo"]))
    {
    echo "type='image/png' href='".$_GET["logo"]."'>\r\n";
    }
  else
    {
    echo "href='icon/tv-icon.ico'>\r\n";
    }

  echo "<HEAD>\r\n";
  echo "<title>".$_GET["chnam"]."</title>\r\n";
  echo "</HEAD>\r\n";
  echo "<BODY bgcolor='#606060' text='#E0E0E0' style='font-family:Calibri'>\r\n";

  if (isset($_GET["channel"]))
    {
    echo "<video controls autoplay height=\"100%\" width=\"100%\">\r\n";
    echo "<source src=\"".base64_decode($_GET["channel"])."\">\r\n";
    echo "<center>\r\n";
    echo "<i>Sorry, der Browser unterst&uuml;tzt kein MP4</i>\r\n"; 
    echo "</center>\r\n";
    echo "</video>\r\n"; 
    }
?>

</BODY>

</HTML>