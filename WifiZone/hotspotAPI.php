<?php    

    $BaseUri = "http://technology.afstrel.com/api/v1/"; 
    $apikey = "N4TN9PD9D6W2RV95X2YNR8R8XW1VBGRN"; 
    $secret = "65X6HY5LVR76661TYN39LH841YP1219Y";   

    //   Encryption vector initialization    
    $secretiv = hash("SHA256", $apikey, true); 

    //   Encryption for sparams    
     function Encrypt($string) {      
        global $secret, $secretiv; 

        $output = false;    
        $output = mcrypt_encrypt(MCRYPT_RIJNDAEL_256, md5($secret), "encchk=1/" .$string, MCRYPT_MODE_CBC, $secretiv);       
        return rtrim(strtr(base64_encode($output), '+/', '-_'), '=');
    } 

    //   **********************************************************************************************************    
    //   Samples    
    //   Warning! In order to read or write data (retailers, managers, hotspot, domains, users, etc.) the AppID    
    //   must be a member forming part of the requested information. Example: User xxx can read the information of     
    //   the managers if the AppID is defined in the retailer or in the manager    
    //   **********************************************************************************************************    

    //   Call a test API    
    // $url = $BaseUri ."testapi" ."/apikey=" .$apikey ."/" ."sparam=" .Encrypt("Param1=Abcd/ParamN=1234"); 

    //   Get user data by ID    
    // $url = $BaseUri ."getuserdata" ."/apikey=" .$apikey ."/" ."sparam=" .Encrypt("id=1"); 

    //   Get user data by user name    
    // $url = $BaseUri ."getuserdatabyusername" ."/apikey=" .$apikey ."/" ."sparam=" .Encrypt("username=123456@domainname"); 

    //   Get users data    
    // $url = $BaseUri ."exportusers" ."/apikey=" .$apikey ."/" ."sparam=" .Encrypt("domainid=1/userid=0/cardsgeneration=/fromdate=2017-07-11 00:00:00/todate=2017-07-11 23:59:59"); 

    //   Get user product    
    // $url = $BaseUri ."getuserproduct" ."/apikey=" .$apikey ."/" ."sparam=" .Encrypt("id=1"); 

    //   Get domain data    
    // $url = $BaseUri ."getdomaindata" ."/apikey=" .$apikey ."/" ."sparam=" .Encrypt("id=1"); 
    //   Get manager data    
    // $url = $BaseUri ."getmanagerdata" ."/apikey=" .$apikey ."/" ."sparam=" .Encrypt("id=1"); 

    //   Get retailer data    
    // $url = $BaseUri ."getretailerdata" ."/apikey=" .$apikey ."/" ."sparam=" .Encrypt("id=1"); 

    //   User connection status    
    // $url = $BaseUri ."getuserconnectionstatus" ."/apikey=" .$apikey ."/" ."sparam=" .Encrypt("username=123456@domainname"); 

    //   Add or modify a user    
    $url = $BaseUri ."setuserdata" ."/apikey=" .$apikey ."/" ."sparam=" .Encrypt("domainid=568/username=333333@Groupe33/password=1234/productid=958/acceptmkt=1/terms=1/setlanguage=fr"); 

    //   get user data by username    
    // $url = $BaseUri ."getuserdatabyusername" ."/apikey=" .$apikey ."/" ."sparam=" .Encrypt("username=iii@Groupe33"); 

    //   Create cards    
    // $url = $BaseUri ."createcards" ."/apikey=" .$apikey ."/" ."sparam=" .Encrypt("domainid=1/productid=64/sellprice=5/language=en/quantity=3"); 

    //   Create vouchers    
    // $url = $BaseUri ."createvouchers" ."/apikey=" .$apikey ."/" ."sparam=" .Encrypt("domainid=1/productid=64/sellprice=5/language=en/quantity=3"); 

    //   Export users sales    
    // $url = $BaseUri ."exportuserssales" ."/apikey=" .$apikey ."/" ."sparam=" .Encrypt("domainid=1/gatewayid-113/userid/fromdate-2017-03-01/todate-2017-03-31"); 

    //   *********************************************************************************************************

    //   Exec the GET call    
    $oStdClass = json_decode(file_get_contents($url), true); 

    echo $oStdClass['id']; 

?>