<?php    

    class HostpostAPI
    {
        public $baseuri; 
        public $apikey; 
        public $secret;

    
        public function __construct(){
            
            $this->baseuri = "http://technology.afstrel.com/api/v1/";
            $this->apikey = "N4TN9PD9D6W2RV95X2YNR8R8XW1VBGRN"; 
            $this->secret = "65X6HY5LVR76661TYN39LH841YP1219Y";  
        }
        
        //   Encryption for sparams    
        function Encrypt($string) {    
            //   Encryption vector initialization    
            $secretiv = hash("SHA256", $apikey, true);   
            global $secret, $secretiv; 
    
            $output = false;    
            $output = mcrypt_encrypt(MCRYPT_RIJNDAEL_256, md5($secret), "encchk=1/" .$string, MCRYPT_MODE_CBC, $secretiv);       
            return rtrim(strtr(base64_encode($output), '+/', '-_'), '=');
        }
    
        // crées l'utilisateur
        public function CreateUser($username,$password){
            $url = $baseuri ."setuserdata" ."/apikey=" .$apikey ."/" ."sparam=" . $this->Encrypt("domainid=568/username=$username/password=$password/productid=958/acceptmkt=1/terms=1/setlanguage=fr"); 
            //   Exec the GET call
            return json_decode(file_get_contents($url));
        }
    
    }
