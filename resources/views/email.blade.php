<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Facture</title>

    <style>
        
@import url(https://fonts.googleapis.com/css?family=Roboto:100,300,400,900,700,500,300,100);
*{
  margin: 0;
  box-sizing: border-box;

}
body{
  background: #E0E0E0;
  font-family: 'Roboto', sans-serif;
  background-image: url('');
  background-color: rgb(221, 215, 215);
  background-repeat: repeat-y;
  background-size: 100%;
  border: 1px solid indigo
}
::selection {background: #f31544; color: #FFF;}
::moz-selection {background: #f31544; color: #FFF;}
h1{
  font-size: 1.5em;
  color: #222;
}
h2{font-size: .9em;}
h3{
  font-size: 1.2em;
  font-weight: 300;
  line-height: 2em;
}
p{
  font-size: .7em;
  color: #666;
  line-height: 1.2em;
}

#invoiceholder{
  width:100%;
  height: 100%;
  padding-top: 50px;
 /* background-color: rgb(205, 152, 243); */
}
/* #headerimage{
  z-index:-1;
  position:relative;
  top: -50px;
  height: 350px;
  background-image: url('http://michaeltruong.ca/images/invoicebg.jpg');

  -webkit-box-shadow:inset 0 2px 4px rgba(0,0,0,.15), inset 0 -2px 4px rgba(0,0,0,.15);
	-moz-box-shadow:inset 0 2px 4px rgba(0,0,0,.15), inset 0 -2px 4px rgba(0,0,0,.15);
	box-shadow:inset 0 2px 4px rgba(0,0,0,.15), inset 0 -2px 4px rgba(0,0,0,.15);
  overflow:hidden;
  background-attachment: fixed;
  background-size: 1920px 80%;
  background-position: 50% -90%;
} */


@media (max-width: 600px) {
  #invoiceholder {
    width: 100% !important;
  }}
#invoice{
  position: relative;
  top: -290px;
  margin: 0 auto;
  width: 700px;
  background: #FFF;
}

[id*='invoice-']{ /* Targets all id with 'col-' */
  border-bottom: 1px solid #EEE;
  padding: 30px;
}

#invoice-top{min-height: 120px;}
#invoice-mid{min-height: 120px;}
#invoice-bot{ min-height: 250px;}

.logo{
  float: left;
	height: 60px;
	width: 60px;
	background: url(http://michaeltruong.ca/images/logo1.png) no-repeat;
	background-size: 60px 60px;
}
.clientlogo{
  float: left;
	height: 60px;
	width: 60px;
	background: url(http://michaeltruong.ca/images/client.jpg) no-repeat;
	background-size: 60px 60px;
  border-radius: 50px;
}
.info{
  display: block;
  float:left;
  margin-left: 20px;
}
.title{
  float: right;
}
.title p{text-align: right;}
#project{margin-left: 52%;}
table{
  width: 100%;
  border-collapse: collapse;
}
td{
  padding: 5px 0 5px 15px;
  border: 1px solid #EEE
}
.tabletitle{
  padding: 5px;
  background: #EEE;
}
.service{border: 1px solid #EEE;}
.item{width: 50%;}
.itemtext{font-size: .9em;}

#legalcopy{
  margin-top: 30px;
}
form{
  float:right;
  margin-top: 30px;
  text-align: right;
}


.effect2
{
  position: relative;
}
.effect2:before, .effect2:after
{
  z-index: -1;
  position: absolute;
  content: "";
  bottom: 15px;
  left: 10px;
  width: 50%;
  top: 80%;
  max-width:300px;
  background: #777;
  -webkit-box-shadow: 0 15px 10px #777;
  -moz-box-shadow: 0 15px 10px #777;
  box-shadow: 0 15px 10px #777;
  -webkit-transform: rotate(-3deg);
  -moz-transform: rotate(-3deg);
  -o-transform: rotate(-3deg);
  -ms-transform: rotate(-3deg);
  transform: rotate(-3deg);
}
.effect2:after
{
  -webkit-transform: rotate(3deg);
  -moz-transform: rotate(3deg);
  -o-transform: rotate(3deg);
  -ms-transform: rotate(3deg);
  transform: rotate(3deg);
  right: 10px;
  left: auto;
}



.legal{
  width:70%;
}


    </style>
</head>
<body>
    <div id="invoiceholder">

        <div id="headerimage"></div>
        <div id="invoice" class="effect2">
          
          <div id="invoice-top">
            <div class="logo"></div>
            <div class="info">
               


              <h2> {{ $entreprise->libelle }}</h2><br>
              <p> {{ $entreprise->email }} <br><br>
                {{ $entreprise->contact }}
              </p>
            </div><!--End Info-->
            <div class="title">
              <h1>
                @if ($type_facture[0]->type_facture_id==0)
                Devis
                @elseif($type_facture[0]->type_facture_id==1)
                    Facture
            @endif
                  
                {{ $details_facture->code}}
            </h1>
              <p>
                  Date emision: {{ $details_facture->date_emission}}<br><br>
                 Date echeance: {{ $details_facture->date_echeance}}<br>
              </p>
            </div><!--End Title-->
          </div><!--End InvoiceTop-->
      
      
          
          <div id="invoice-mid">
            
            <div class="clientlogo"></div>
            <div class="info">
              <h2>{{ $client->nom }}</h2><br>
              <p>{{ $client->email }}<br><br>
                {{ $client->contact }}
              </p>
            </div>
      
            {{-- <div id="project">
              <h2>Project Description</h2>
              <p>Proin cursus, dui non tincidunt elementum, tortor ex feugiat enim, at elementum enim quam vel purus. Curabitur semper malesuada urna ut suscipit.</p>
            </div>   
       --}}
          </div><!--End Invoice Mid-->
          
          <div id="invoice-bot">
            
            <div id="table">
              <table>
                <tr class="tabletitle">
                    <td class="Hours"><h2>N°</h2></td>
                  <td class="item"><h2>Libelle</h2></td>
                  <td class="Hours"><h2>Qte</h2></td>
                  <td class="item"><h2>Prix</h2></td>
                  {{-- <td class="subtotal"><h2>Sub-total</h2></td> --}}
                </tr>
                @foreach ($detail_art as $key=>$item)   
                <tr class="service">
                  <td class="tableitem"><p class="itemtext">{{ ++$key }}</td>
                  <td class="tableitem"><p class="itemtext">{{$item->libelle}}</td>
                  <td class="tableitem"><p class="itemtext">{{$item->quantite}}</p></td>
                  <td class="tableitem"><p class="itemtext">{{$item->prix}} FCFA</td>
                  {{-- <td class="tableitem"><p class="itemtext">$419.25</p></td> --}}
                </tr>
                @endforeach 
                
                  
                <tr class="tabletitle">
                    <td></td>
                    <td></td>
                    <td class="Rate"><h2>Total HT</h2></td>
                    @foreach ($total_ht as $item)
                    <td class="payment"><h2>{{ $item->total_ht}} FCFA</h2></td>
                    @endforeach
                    </tr>
                <tr class="tabletitle">
                    <td></td>
                    <td></td>
                    <td class="Rate"><h2>Total TTC</h2></td>
                     @foreach ($total_ttc as $item)
                     <td class="payment"><h2>{{ $item->total_ttc}} FCFA</h2></td>
                     @endforeach
                  </tr>
                
              </table>
            </div><!--End Table-->
            
          {{-- <form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_top">
            <input type="hidden" name="cmd" value="_s-xclick">
            <input type="hidden" name="hosted_button_id" value="QRZ7QTM9XRPJ6">
            <input type="image" src="http://michaeltruong.ca/images/paypal.png" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
          </form> --}}
      
            
            <div id="legalcopy">
              <p class="legal">
                  <strong>{{ $details_facture->description}}</strong>
              </p>
            </div>
            
          </div><!--End InvoiceBot-->
        </div><!--End Invoice-->
      </div><!-- End Invoice Holder-->
</body>
</html>