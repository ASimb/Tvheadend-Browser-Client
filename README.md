# Tvheadend-Browser-Client
This is a browser client for Tvheadend. It allows to watch TV, list the EPG-information and display the PVR-data, all inside of your internet browser.

System requirements: 
The client is tested on a raspberry pi 4+ with PHP 7.3.19 and Apache 2.4.38. The browser I use is Google Chrome version 87.

Installation:
Just copy all the files in the apache-directory of your server. Open the file "tv-params.php" and change the entries for the IP-adress and the username and password of your tvheadend-installation. You can also change the language-based parameters within this file.
Important: to watch TV within the browser you have to define 2 stream-profiles in tvheadend. Open tvheadend with admin-rights, go to Configuration=>Streams=>Stream profiles and add two profiles called "webtv-sd" and "webtv-hd". The exact configuration of theses profiles can be found in this repository at "instructions" "webtv-sd.jpg" and "webtv-hd.jpg". The webtv-hd profile is used for HD-channels, the webtv-sd for SD channels. Therefore it is important, that in the tags of your channels the keywords "HDTV" and "SDTV" are set properly.
