<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Facture</title>
    <!-- <link rel="stylesheet" href="style.css" media="all" /> -->
    <style>
        @font-face {
  font-family: SourceSansPro;
  src: url(SourceSansPro-Regular.ttf);
}

.clearfix:after {
  content: "";
  display: table;
  clear: both;
}

a {
  color: #0087C3;
  text-decoration: none;
}

body {
  position: relative;
  width: 21cm;  
  height: 29.7cm; 
  margin: 0 auto; 
  color: #555555;
  background: #FFFFFF; 
  font-family: Arial, sans-serif; 
  font-size: 14px; 
  font-family: SourceSansPro;
}

header {
  padding: 10px 0;
  margin-bottom: 20px;
  border-bottom: 1px solid #AAAAAA;
}

#logo {
  float: left;
  margin-top: 8px;
}

#logo img {
  height: 70px;
}

#company {
  float: right;
  text-align: right;
}


#details {
  margin-bottom: 50px;
}

#client {
  padding-left: 6px;
  border-left: 6px solid #0087C3;
  float: left;
}

#client .to {
  color: #777777;
}

h2.name {
  font-size: 1.4em;
  font-weight: normal;
  margin: 0;
}

#invoice {
  float: right;
  text-align: right;
}

#invoice h1 {
  color: #0087C3;
  font-size: 2.4em;
  line-height: 1em;
  font-weight: normal;
  margin: 0  0 10px 0;
}

#invoice .date {
  font-size: 1.1em;
  color: #777777;
}

table {
  width: 100%;
  border-collapse: collapse;
  border-spacing: 0;
  margin-bottom: 20px;
  text-align: center;
}

table th,
table td {
  padding: 20px;
  background: #EEEEEE;
  text-align: center;
  border-bottom: 1px solid #FFFFFF;
}

table th {
  white-space: nowrap;        
  font-weight: normal;
}

table td {
  text-align: right;
}

table td h3{
  color: indigo;
  font-size: 1.2em;
  font-weight: normal;
  margin: 0 0 0.2em 0;
}

table .no {
  color: #FFFFFF;
  font-size: 1.6em;
  background: indigo;
}

table .desc {
  text-align: left;
}

table .unit {
  background: #DDDDDD;
}

/* table .qty {
} */

table .total {
  background: indigo;
  color: #FFFFFF;
}

table td.unit,
table td.qty,
table td.total {
  font-size: 1.2em;
}

table tbody tr:last-child td {
  border: none;
}

table tfoot td {
  padding: 10px 20px;
  background: #FFFFFF;
  border-bottom: none;
  font-size: 1.2em;
  white-space: nowrap; 
  border-top: 1px solid #AAAAAA; 
}

table tfoot tr:first-child td {
  border-top: none; 
}

table tfoot tr:last-child td {
  color: indigo;
  font-size: 1.4em;
  border-top: 1px solid indigo; 

}

table tfoot tr td:first-child {
  border: none;
}

#thanks{
  font-size: 2em;
  margin-bottom: 50px;
}

#notices{
  padding-left: 6px;
  border-left: 6px solid indigo;  
}

#notices .notice {
  font-size: 1.2em;
}

footer {
  color: #777777;
  width: 100%;
  height: 30px;
  position: absolute;
  bottom: 0;
  border-top: 1px solid #AAAAAA;
  padding: 8px 0;
  text-align: center;
}


        </style>
</head>
  
  <body>
    <header class="clearfix">
      <div id="logo">
        <img src="{{$entreprise->getFirstMediaUrl('logo')}}">
      </div>
      <div id="company">
        <h2 class="name">{{ $entreprise->libelle }}</h2>
        <div></div>
        <div>{{ $entreprise->contact }}</div>
        <div><a href="mailto:{{ $entreprise->email }}">  {{ $entreprise->email }}</a></div>
      </div>
      </div>
    </header>
    <main>
      <div id="details" class="clearfix">
        <div id="client">
          <div class="to">FACTURE A:</div>
          <h2 class="name">  {{ $client->nom }}</h2>
          <div class="address"> {{ $client->contact }}</div>
          <div class="email"><a href="mailto:john@example.com">{{ $client->email }}</a></div>
        </div>
        <div id="invoice">
          <h1>{{ $details_facture->code}}</h1>
          <div class="date">Date emission: {{ $details_facture->date_emission}}</div>
          <div class="date"> Date echeance: {{ $details_facture->date_echeance}}</div>
        </div>
      </div>
      <table border="0" cellspacing="0" cellpadding="0">
        <thead>
          <tr>
            <th class="no">#</th>
            <th class="desc">LIBELLE</th>
            {{-- <th class="unit">UNIT PRICE</th> --}}
            <th class="qty">QUANTITE</th>
            <th class="total">PRIX</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($detail_art as $key=>$item)  
          <tr>
            <td class="no">{{ ++$key }}</td>
            <td class="desc"><h3>{{$item->libelle}}</h3></td>
            <td class="qty">{{$item->quantite}}</td>
            {{-- <td class="unit">{{$item->prix}}</td> --}}
            <td class="total">{{$item->prix}}</td>
          </tr>
          @endforeach 
        </tbody>
        <tfoot>
          <tr>
            @foreach ($total_ht as $item)
            <td colspan="2"></td>
            <td colspan="2">TOTAL</td>
            <td>{{ $item->total_ht}} FCFA</td>
            @endforeach
          </tr>
          <tr>
            @foreach ($total_taxe as $item)
            <td colspan="2"></td>
            <td colspan="2">TAXE (%)</td>
            <td>{{ $item->total_taxe}} %</td>
            @endforeach
          </tr>
          <tr>
            @foreach ($remise as $item)
            <td colspan="2"></td>
            <td colspan="2">REMISE (%)</td>
            <td>{{ $item->remise}} %</td>
            @endforeach
          </tr>
          <tr>
            @foreach ($total_ttc as $item)
            <td colspan="2"></td>
            <td colspan="2">MONTANT TOTAL</td>
            <td>{{ $item->total_ttc}} FCFA</td>
            @endforeach
          </tr>
        </tfoot>
      </table>
      {{-- <div id="thanks">Thank you!</div> --}}
      <div id="notices">
        <div>NOTE:</div>
        <div class="notice">{{ $details_facture->description}}</div>
      </div>
    </main>
    <footer>
      {{-- Invoice was created on a computer and is valid without the signature and seal. --}}
    </footer>
  </body>
</html>