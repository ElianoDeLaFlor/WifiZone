$(document).ready(function() { 

    $('#payement_ticket, #connexion_client')[0].reset(); 
    $('select').niceSelect('update');

    $('#type_forfait').on('change', function (e) {
        var optionSelected = $("option:selected", this);
        var valueSelected = this.value;
        if(valueSelected == "STANDARD"){
            $('#title_forfait').html('<a href="#" class="btn btn-dark btn-sm rounded-0 font-weight-bold wow fadeInRight">STANDARD</a><a href="#" class="btn btn-secondary btn-sm rounded-0 font-weight-bold wow fadeInRight">300 F CFA</a>');
            $('#detail_forfait').html('<div class="d-inline-block wow fadeInRight">Bande passante : <b>0.5Mbs</b><br>Temps : 24h<br>Validité : 1 jour</div>');
        }
        if(valueSelected == "START"){
            $('#title_forfait').html('<a href="#" class="btn btn-dark btn-sm rounded-0 font-weight-bold wow fadeInRight">START</a><a href="#" class="btn btn-secondary btn-sm rounded-0 font-weight-bold wow fadeInRight">500 F CFA</a>');
            $('#detail_forfait').html('<div class="d-inline-block wow fadeInRight">Bande passante : <b>1Mbs</b><br>Temps : 24h<br>Validité : 1 jour</div>');
        }
        if(valueSelected == "PREMIUM"){
            $('#title_forfait').html('<a href="#" class="btn btn-dark btn-sm rounded-0 font-weight-bold wow fadeInRight">PREMIUM</a><a href="#" class="btn btn-secondary btn-sm rounded-0 font-weight-bold wow fadeInRight">1000 F CFA</a>');
            $('#detail_forfait').html('<div class="d-inline-block wow fadeInRight">Bande passante : <b>3.5Mbs</b><br>Temps : 24h<br>Validité : 1 jour</div>');
        }
    });

});