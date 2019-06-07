<?php    

    class HostpostAPI
    {
        public $baseuri; 
        public $apikey; 
        public $secret;
        public $secretiv;
        public $domainId;
        public $domainName;

    
        public function __construct(){
            
            $this->baseuri = "http://technology.afstrel.com/api/v1/";
            $this->apikey = "N4TN9PD9D6W2RV95X2YNR8R8XW1VBGRN"; 
            $this->secret = "65X6HY5LVR76661TYN39LH841YP1219Y";  
            $this->secretiv = hash("SHA256", $this->apikey, true);
            $this->domainId = "568";
            $this->domainName = "Groupe33";
        }
        
        //   Encryption for sparams    
        public function Encrypt($string) {    
              
            $secret = $this->secret;
            $secretiv = $this->secretiv; 
    
            $output = false;    
            $output = mcrypt_encrypt(MCRYPT_RIJNDAEL_256, md5($secret), "encchk=1/" .$string, MCRYPT_MODE_CBC, $secretiv);       
            return rtrim(strtr(base64_encode($output), '+/', '-_'), '=');
        
        }
    
        // crées l'utilisateur
        public function CreateUser($username, $password, $idTypeTicketInHotspotSoftware){
            $domainId = $this->domainId;
            $encryptString = $this->Encrypt("domainid=$domainId/username=$username/password=$password/productid=$idTypeTicketInHotspotSoftware/acceptmkt=1/terms=1/setlanguage=fr");
            $url = $this->baseuri ."setuserdata" ."/apikey=" . $this->apikey ."/" ."sparam=" . $encryptString; 
            //   Exec the GET call
            return json_decode(file_get_contents($url), true);
        }

        // get user data
        public function GetUserData($username){
            $domainName = $this->domainName;
            $encryptString = $this->Encrypt("username=$username@$domainName");
            $url = $BaseUri ."getuserdatabyusername" ."/apikey=" .$apikey ."/" ."sparam=" . $encryptString;
            //   Exec the GET call
            return json_decode(file_get_contents($url));
        }

        // // Crediter le compte de l'utilisateur
        // public function CreditUserAccount($username, $password, $idTypeTicketInHotspotSoftware){
        //     $encryptString = $this->Encrypt("id=677/productid=$idTypeTicketInHotspotSoftware/sellprice=500/updatecredit=true");
        //     $url = $this->baseuri ."adduserproduct" ."/apikey=" . $this->apikey ."/" ."sparam=" . $encryptString; 
        //     //   Exec the GET call
        //     return json_decode(file_get_contents($url));
        // }
    
    }
