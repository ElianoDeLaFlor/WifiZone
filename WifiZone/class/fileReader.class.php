<?php

    include 'ticket.class.php';

    class FileReader
    {
        private $Path;
        private $codeListe;

        public function GetPath()//return le chemin vers le fichier
        {
            return $this->Path;
        }




        public function SetPath($p)// Permet de speficier le chemin vers le fichier
        {
            $this->Path=$p;
        }




        public function Read()//lis le contenu du fichier
        {
            $this->codeListe=array();
            $tk;
            $GetType;
            $IdTypeTicket;
            $cnt=0;
            if ($fh = fopen($this->Path, 'r')) {
                while (!feof($fh)) {
                                
                    if($cnt==0){
                        //skip the file header
                        $line=fgets($fh);
                        $line=null;
                    }
                    else{
                    $line = fgets($fh);
                    
                        if($cnt==1){
                        $GetType=$arr=explode(';',$line);
                        $type=$GetType[1];
                        $IdTypeTicket=$this->SetTypeTicketId($type);
                        }
                    $tk=$this->GetTicket($line,$IdTypeTicket);
                    $tk->InsertTicket();
                    }
                    $cnt++;
                }
                fclose($fh);
                return true;
            }
            return false;
        }

    public function tt(){
        echo('form fr');
    }

        private function SetTypeTicketId($str)//Detecte le ID type du code;
        {
            $conn=Connection::getInstance();
                //------------------------
                try{
                    $conn=Connection::getInstance();
                    //-----------------
                    $con= $conn->prepare("SELECT IdTypeTicket from typeticket WHERE ReferenceTypeTicket=:ReferenceTypeTicket");
                    $con->execute(array(
                        "ReferenceTypeTicket" => $str,
                    ));
                    //--------------
                    $row = $con->fetch();
                    return $row['IdTypeTicket'];

                }catch(PDOException $e){
                    return false;
                }
        }


        private function GetTicket($str,$id):Ticket
        {
            $tk=new Ticket();
            $arr=explode(';',$str);
            $tk->FK_IdTypeTicket=$id;//typeticket
            $tk->CodeTicket=$arr[3];// code du ticket
            $tk->DateCreationTicket=(date ("Y-m-d H:i:s"));//date d'enregistrement
            return $tk;
        }




        public function test(){
            //$t2 = "7336a180-c266-46a6-8b7b-ac7c1016d916";
            try{
                header("Location: https://paygateglobal.com/v1/page?token=7336a180-c266-46a6-8b7b-ac7c1016d916&amount=132014&description=payment%20joa&identifier=0012&url=eliano-pc:8081");
            }catch(Exception $e){
                echo $e;
            }
        }




        private function RemoveQuotes($str){
            return trim($str , '"');
        }
        
    }