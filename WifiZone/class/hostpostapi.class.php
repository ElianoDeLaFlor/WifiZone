<?php    

    class HostpostAPI
    {
        public $BaseUri; 
        public $apikey; 
        public $secret;  
    
        public function __construct(){
            $BaseUri = "http://technology.afstrel.com/api/v1/";
            $apikey = "N4TN9PD9D6W2RV95X2YNR8R8XW1VBGRN"; 
        $secret = "65X6HY5LVR76661TYN39LH841YP1219Y";  
        }

        //   Encryption vector initialization    
        $secretiv = hash("SHA256", $apikey, true); 
        //   Encryption for sparams    
        function Encrypt($string) {      
            global $secret, $secretiv; 
    
            $output = false;    
            $output = mcrypt_encrypt(MCRYPT_RIJNDAEL_256, md5($secret), "encchk=1/" .$string, MCRYPT_MODE_CBC, $secretiv);       
            return rtrim(strtr(base64_encode($output), '+/', '-_'), '=');
        }
    
            //   Add or modify a user    
            $url = $BaseUri ."setuserdata" ."/apikey=" .$apikey ."/" ."sparam=" .Encrypt("domainid=568/username=sylain92@Groupe33/password=1234/productid=958/acceptmkt=1/terms=1/setlanguage=fr"); 
    
            //   Exec the GET call    
        $oStdClass = json_decode(file_get_contents($url)); 
    
        print_r($oStdClass);
    
        public function CreateUser($username,$password){
            $url = $BaseUri ."setuserdata" ."/apikey=" .$apikey ."/" ."sparam=" .Encrypt("domainid=568/username=$username/password=$password/productid=958/acceptmkt=1/terms=1/setlanguage=fr"); 
        }
    
    }
?>