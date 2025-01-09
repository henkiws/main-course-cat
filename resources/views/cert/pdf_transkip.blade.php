<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	</head>
	<style>
        @font-face {
            font-family: 'CenturyGothic';
            src: url('{{ base_path("public/fonts/CenturyGothic.ttf") }}') format("truetype");
            font-weight: 400;
            font-style: normal;
        }
        @font-face {
            font-family: 'CenturyGothicBold';
            src: url('{{ base_path("public/fonts/CenturyGothic-Bold.ttf") }}') format("truetype");
            font-weight: 400;
            font-style: normal;
        }
		body {
            font-family: "CenturyGothic" !important;
		}
        body, span, div, table, tr, td {
			font-size: 14px;
		}

		th, b, h1, .text-bold {
			font-weight: bold;
            font-family: "CenturyGothicBold" !important;
		}

		.table-inv tbody tr td{
            font-family: "CenturyGothic" !important;
			border-spacing: 0px;
			border-collapse: separate;
		}
		td, th {
			vertical-align: top;
			padding: 5px;
		}

		.table-inv td,
		.table-inv th {
			border-bottom: 0px solid #e0e0e0;
            padding: 5px;
		}

		td .no-padding {
			padding: 0px !important;
		}

		.table-inv td,
		.table-inv th {
			border-bottom: 1px solid #e0e0e0;
		}

		p {
			margin: 0;
		}

		.text-center {
			text-align:center!important;
		}

		.text-left {
			text-align:left!important;
		}

		.text-right {
			text-align:right!important;
		}

		main {
			top: 75px;
			position: relative;
		}

		#header,
		#footer {
		    position: fixed;
		    left: 0;
			right: 0;
			font-size: 0.9em;
		}
		#header {
		    top: 40px;
            border-bottom: 0.1pt solid #e0e0e0;
		}
        header{
            position: fixed;
            top: 20px;
            left: 0;
			right: 0;
            margin-top: -100px;
        }
		#footer {
		    bottom: 0px;
		}
		.page-number:before {
            content: "Page " counter(page);
		}

        #footer div{
            font-size: 10px !important;
        }
        #footer img{
            width: 80px !important;
        }
        #footer table td{
            padding: 0;
        }
        @page {
            margin-top: 100px;
            margin-bottom: 230px;
        }
        .header-text {
            position: relative;
            left: 60px;
            font-size: 30px;
            font-weight: 400;
            top: 10px;
        }
        .subheader-text {
            position: relative;
            left: 140px;
            font-size: 20px;
            font-weight: 400;
            top: 10px;
        }
        #watermark {
            position: fixed;
            top: 40%;
            width: 100%;
            text-align: center;
            opacity: .1;
            transform: rotate(30deg);
            transform-origin: 50% 50%;
            z-index: -1000;
            font-size: 130px;
        }
	</style>
	<body>
        <div id="watermark">KSN AKADEMI</div>
        <div id="header">
            <header>
                <table style="width:100%;border-collapse: collapse;border-spacing: 0px!important;" cellpadding="0" >
                        <tr style="margin-bottom: 0px">
                            <td style="vertical-align: top; width: 30%">
                                <img style="width: 200px;" src="https://exam.ksn-konsultan.com/public/images/logo_dark.png" />
                            </td>
                            <td class="text-left" style="width: 70%;">
                                <span class="header-text text-bold">{{ strtoupper($data->data_certificate->title) }}</span><br>
                                <span class="subheader-text text-bold">TRANSKIP AKADEMIK</span>
                            </td>
                        </tr>
                </table>
            </header>
		</div>
		<main>
            <table style="width:100%;float:left;border-collapse: collapse;border-spacing: 0px!important;" cellpadding="0" class="">
				<tr>
					<td width="20%" class="text-left" style="padding:0px;">
						Nomor Sertifikat
					</td>
					<td width="5%" class="text-left" style="padding:0px;">:</td>
					<td width="75%" class="text-left" style="padding:0px;">{{ $data->ref }}</td>
				</tr>
                <tr>
					<td width="20%" class="text-left" style="padding:0px;">
						Nama Pelatihan
					</td>
					<td width="5%" class="text-left" style="padding:0px;">:</td>
					<td width="75%" class="text-left" style="padding:0px;">{{ ucwords($data->data_certificate->name) }}</td>
				</tr>
                <tr>
					<td width="20%" class="text-left" style="padding:0px;">
						Batch Pelatihan
					</td>
					<td width="5%" class="text-left" style="padding:0px;">:</td>
					<td width="75%" class="text-left" style="padding:0px;">{{ ucwords($data->data_certificate->batch) }}</td>
				</tr>
                <tr>
					<td width="20%" class="text-left" style="padding:0px;">
						Nama Peserta
					</td>
					<td width="5%" class="text-left" style="padding:0px;">:</td>
					<td width="75%" class="text-left" style="padding:0px;">{{ ucwords($data->data_user->name) }}</td>
				</tr>
			</table>

			<br style="clear:both; height:1px" />
			
            <div style="min-height: 1px; height:auto; width: 100%; float: left;">
				<table style="width:100%;" class="table-inv">
					<thead>
						<tr style="background-color:#e0e0e0;">
							<td class="text-center">No</td>
							<td class="text-left">Kompetensi</td>
							<td class="text-center">Predikat</td>
						</tr>
					</thead>
					<tbody>
                        @foreach( $data->data_details as $key => $val )
						<tr>
                            <td class="text-center">
                                {{ ($key+1) }}
                            </td>
                            <td class="text-left">
                                {{ getCBTName($val->fk_cbt_test) }}
                            </td>
                            <td class="text-center">
                                {{ $val->score_text }}
                            </td>
                        </tr>
                        @endforeach
					</tbody>
				</table>
			</div>

            <br style="clear:both; height:1px" />
            <span class="text-bold">Keterangan</span><br>
            A = Sangat Baik<br>
            B = Baik<br>
            C = Cukup<br>
            D = Kurang<br>
            E = Tidak Berpartisipasi<br>
		</main>

	</body>

</html>
