<?php
include '../class/fileReader.class.php';
$f=new fileReader();
$f->setPath('externalFile/createTicket.csv');
if($f->Read())
    echo('<span style="color: green;">Ticket bien inserré</span>');
else
    echo('<span style="color: red;">Erreur lors de l\'insertion du ticket</span>');