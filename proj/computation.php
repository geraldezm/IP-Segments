    <html>
       <body>

          <?php
          
          function ipRange($ip){
            $ipArray = [];

            $ipadd = explode(".", $ip);

            for ($i = 0; $i < sizeof($ipadd); $i++){
                if(strpos(($ipadd[$i]), "-") == true) {
                    $octet = $i;
                    $iprange = explode("-",$ipadd[$i]);
                    $min = $iprange[0];
                    $max = $iprange[1];    
                }

            }


            for($i = $min; $i <= $max; $i++){
                $ipadd[$octet] = $i;
               
                for ($j = 0; $j < sizeof($ipadd); $j++){

                    $address = implode(".", $ipadd);
                }
                
                $ipArray[] = $address;
               
            }
              
            return $ipArray;
           
            /*foreach ($ipArray as $oneIP){
                #echo "$oneIP</br>";
            }*/

        } 
            

          ?>

       </body>
    </html>