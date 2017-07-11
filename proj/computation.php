<html>
   <body>
      
      <?php
         $ip = "192.168.10-25";
         echo $ip;
         echo "</br>";

        $ipadd = explode(".", $ip);

        for ($i = 0; $i < sizeof($ipadd); $i++){
            #echo $i;
            #echo strpos($ipadd[$i], "-");
	        if(strpos(($ipadd[$i]), "-") == true) {
		        echo "There is a '-' on the ". ($i + 1) . " octet";
    	    }

        }
      ?>
      
   </body>
</html>