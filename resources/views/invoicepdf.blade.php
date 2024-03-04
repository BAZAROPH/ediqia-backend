<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<title>Facture</title>

		<style>
          
@font-face {
    font-family: 'montserratblack';
    src: url('fonts/montserrat-black-webfont.woff') format('woff');
    font-weight: normal;
    font-style: normal;

}
            body{
                font-family: 'montserratblack';
				color: #555;
            }
			.invoice-box {
				/* max-width: 800px; */
				margin: auto;
				padding: 30px;
				border: 1px solid #eee;
				box-shadow: 0 0 10px rgba(0, 0, 0, 0.15);
				font-size: 16px;
				line-height: 24px;
				/* font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; */
				color: #555;
			}

			.invoice-box table {
				width: 100%;
				line-height: inherit;
				text-align: center;
			}

			.invoice-box table td {
				padding: 5px;
				vertical-align: top;
			}

			/*.invoice-box table tr td:nth-child(2) {
				text-align: center;
			}
*/
			.invoice-box table tr.top table td {
				padding-bottom: 20px;
			}

			.invoice-box table tr.top table td.title {
				font-size: 25px;
				line-height: 45px;
				color: #333;
				float: left;
			}
            

			.invoice-box table tr.top table td.invoice-info {
				
/*				line-height: 45px;
*/				float: right;
			}

			.invoice-box table tr table td.info-client {
				
/*				line-height: 45px;
*/				float: right;
			}

				.invoice-box table tr table td.info-entreprise {
				
/*				line-height: 45px;
*/				float: left;
			}

			.invoice-box table tr.information table td {
				padding-bottom: 40px;
			}

			.invoice-box table tr.heading td {
				background: #eee;
				border-bottom: 1px solid #ddd;
				font-weight: bold;
			}

			.invoice-box table tr.details td {
				padding-bottom: 20px;
			}

			.invoice-box table tr.item td {
				border-bottom: 1px solid #eee;
			}

			.invoice-box table tr.item.last td {
				border-bottom: none;
			}

			.invoice-box table tr.total td:nth-child(4) {
				border-top: 2px solid #eee;
				font-weight: bold;
				text-align: center;
			}

			@media only screen and (max-width: 600px) {
				.invoice-box table tr.top table td {
					width: 100%;
					display: block;
					text-align: center;
				}

				.invoice-box table tr.information table td {
					width: 100%;
					display: block;
					text-align: center;
				}
			}

			/** RTL **/
			.invoice-box.rtl {
				direction: rtl;
				font-family: Tahoma, 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
			}

			.invoice-box.rtl table {
				text-align: right;
			}

			.invoice-box.rtl table tr td:nth-child(2) {
/*				text-align: left;
*/			}
		</style>
	</head>

	<body>
        <div> <img src="{{$entreprise->getFirstMediaUrl('image')}}"style="width: 70%; max-width: 100px"></div>

        <!-- info entreprise -->   
            <div style="float:right;  padding-left: 5px;padding-right: 5px;">
                <p><b>{{ $entreprise->libelle }}</b> <br>
                Tel:{{ $entreprise->contact }} <br>
                Email:{{ $entreprise->email }}</p>
            </div><br><br><br><br><br>
    
        <!-- info facture -->  
            @foreach ($detail_facture as $item)
				<h1 style="margin-left:2%"> {{ $item->libelle }} </h1>
			@if ($item->status=='devis')
			<div style="background-color: #eceff1; float: left; width: 100%; margin-bottom:15px" >
				<p style="padding-right:5px; padding-left:5px;"><span><b>DEVIS</b> #{{ $item->code}}</span><br>
				  Date d'émission {{ $item->date_emission}}<br>
				  {{-- Date d'écheance: {{ $item->date_echeance}} --}}
				</p>
			</div>
			@else
			<div style="background-color: #eceff1; float: left; width: 100%; margin-bottom:15px" >
				<p style="padding-right:5px; padding-left:5px;"><span><b>FACTURE</b> #{{ $item->code}}</span><br>
				  Date de facturation: {{ $item->date_emission}}<br>
				  Date d'écheance: {{ $item->date_echeance}}
				</p>
			</div>
			@endif
         
        @endforeach
    
        <!--  info du client -->
        <div style="">
            <p><b>
				@if ($item->status=='devis')
				Devis à
			@else
			Facturé à
			@endif
				</b><br>
                 {{ $client->nom }} <br>
                 {{ $client->contact }} <br>
                 {{ $client->email }}
            </p>
        </div>
		<div class="invoice-box">
             <!-- logo -->
			<table cellpadding="0" cellspacing="0">
				{{-- <tr class="top">
					<td colspan="4">
						<table>
							<tr>
								<td class="title">
									<img src="LW.png" />
								</td>
                                @foreach ($detail_facture as $item)
								<td class="invoice-info">
									<b>Facture: #{{ $item->code}}</b><br />
									Date de creation: {{ $item->date_emission}}<br />
									Date d'écheance: {{ $item->date_echeance}}
								</td>
                                @endforeach
							</tr>
						</table>
					</td>
				</tr>

				<tr class="information">
					<td colspan="4">
						<table>
							<tr>
								<td class="info-entreprise">
									<b>{{ $entreprise->libelle }}</b> <br>
                                     Tel:{{ $entreprise->contact }} <br>
                                     Email:{{ $entreprise->email }}</p>
								</td>

								<td class="info-client">
									 <b>Facture à</b><br>
                                     {{ $client->nom }} <br>
                                     {{ $client->contact }} <br>
                                     {{ $client->email }}
								</td>
							</tr>
						</table>
					</td>
				</tr> --}}

			<!-- 	<tr class="heading">
					
					<td colspan="4" >
							Invoice #: 123<br />
									Created: January 1, 2015<br />
									Due: February 1, 2015
					</td>
				</tr> -->

				<!-- <tr class="details">
					<td>Check</td>

					<td>1000</td>
				</tr> -->

				<tr class="heading">
					<td>#</td>
					<td>Libelle</td>
					<td>Qté</td>
					<td>Prix</td>
				</tr>
                @foreach ($detail_art as $key=>$item)
				<tr class="item">
                    <td>{{ ++$key }}</td>
                    <td>{{$item->libelle}}</td>
                    <td>{{$item->quantite}}</td>
                    <td>{{number_format($item->prix,2,',', '.')}}</td>
				</tr>
                @endforeach

                @foreach ($detail_facture as $item)
				
				<tr class="total">
					<td></td>
					<td></td>
					<td></td>
                    <td>Montant HT: {{ number_format($item->total_ht,2,',', '.')}} FCFA</td>
				</tr>
				<tr class="total">
					<td></td>
					<td></td>
					<td></td>
                    @if ($item->total_taxe)
                      <td>{{ $item->total_taxe}}% Taxe: {{number_format($taxe = ($item->total_taxe/100)*$item->total_ht,2,',', '.') }} FCFA</td>
                    @endif
				</tr>
				<tr class="total">
					<td></td>
					<td></td>
					<td></td>
                    @if ($item->remise)
                       <td>{{ $item->remise}}% Remise: {{number_format($remise= ($item->remise/100)*$item->total_ht,2,',', '.') }} FCFA</td>
                    @endif
				</tr>
                <tr class="total">
					<td></td>
					<td></td>
					<td></td>
                    <td>Montant TTC: {{ number_format($item->total_ttc,2,',', '.')}} FCFA</td>
				</tr>
                @endforeach
			</table>
             <!--  Note -->
           @foreach ($detail_facture as $item)
           <div style="width: 100%; margin-top: 10%; text-align:center;">
               <p><b>Note:</b><span>{{ $item->description}}.</span></p>
           </div>
           @endforeach
		</div>
	</body>
</html>