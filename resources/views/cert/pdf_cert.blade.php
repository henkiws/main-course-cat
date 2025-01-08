<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
		<style>
            @font-face {
                font-family: 'CenturyGothic';
                src: url('{{ base_path("public/fonts/CenturyGothic.ttf") }}') format("truetype");
                font-weight: 400;
                font-style: normal;
            }
            body {
                font-family: "CenturyGothic" !important;
            }

            .certificate-container {
                padding: 10px;
                width: 1024px;
            }
            .certificate {
                border: 20px solid #0C5280;
                padding: 20px;
                height: 600px;
                position: relative;
            }

            .certificate-header > .logo {
                width: 150px;
                height: auto;
                position: absolute;
                left: 44%;
                top: 20px;
            }

            .certificate-title {
                text-align: center;    
            }

            .certificate-body {
                margin-top:60px;
                text-align: center;
            }

            h1 {
                font-weight: bold;
                font-size: 40px;
                color: black;
                margin-bottom: 0px;
            }

            .student-name {
                font-size: 30px;
                font-weight: bold;
                margin: 0px;
            }

            .certificate-content {
                margin: 0 auto;
                width: 750px;
            }

            .about-certificate {
                width: 380px;
                margin: 0 auto;
            }

            .topic-description {

                text-align: center;
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
	</head>
	<body> 
        <div id="watermark">KSN AKADEMI</div>
        <div class="certificate-container">
            <div class="certificate">
                <div>
                    <span class="text-center">Nomor Sertifikat</span><br>
                    <span class="text-center">{{ $data->ref }}</span>
                </div>
                <div class="certificate-header" style="">
                    <img src="https://exam.ksn-konsultan.com/public/images/logo_dark.png" class="logo" alt="">
                </div>
                <div class="certificate-body">
                    <h1>{{ strtoupper($data->data_certificate->title) }}</h1>
                    <p class="certificate-title">menyatakan bahwa</p>
                    <p class="student-name">{{ ucwords($data->data_user->name) }}</p>
                    <div class="certificate-content">
                        <div class="text-center">
                            <p>telah menyelesaikan program pelatihan <b>{{ ucwords($data->data_certificate->name) }}</b> Batch {{ $data->data_certificate->batch }}</p>
                            <p>pada tanggal <i>{{ \Carbon\Carbon::parse($data->data_certificate->start_date)->format('d M Y') }}</i> s.d. <i>{{ \Carbon\Carbon::parse($data->data_certificate->end_date)->format('d M Y') }}</i> dan dinyatakan telah memiliki keahlian di bidang kepabeanan.</p>
                        </div>
                    </div>
                    <div class="certificate-footer text-muted">
                        <div class="row">
                            <div class="col-md-6">
                                Jakarta, {{ \Carbon\Carbon::parse($data->certificate_date)->format('d M Y') }}
                                <br> Direktur,
                                <img src="https://toppng.com/uploads/preview/fake-stamp-11523434718dcyoannbr0.png" style="width: 100px;height: auto;position: absolute;left: 30%;bottom: 70px;">
                                <img src="https://asset-2.tstatic.net/pontianak/foto/bank/images/tanda-tangan_20160822_190559.jpg" style="width: 100px;height: auto;position: absolute;bottom: 80px;left: 45%;">
                                <br>
                                <br>
                                <br>
                                <br>
                                <br>Hafidan Ghafi Rafaeyza Subakti
                            </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

	</body>
</html>
