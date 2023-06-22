<html>
<head>
    <title>Surat Pengajuan Verifikasi Ijazah </title>
    <style type= "text/css">
    *{
            margin: 1;
        }
    body {font-family: 'Times New Roman', Times, serif; background-color : #fff }
    .rangkasurat {margin:auto ;background-color : #fff;padding: 10px}
   .header {border-bottom : 3px solid black; padding: 0px;margin-top:0em;line-height: 1.5}
    .tengah {text-align : center;font-size:16px;}
    .judul{
      text-align:center;line-height:5px;font-size:12px;margin-top:1em;}
     .isi{
      margin-left:3em;margin-top:1em;margin-right:3em;font-size:12px;
     }

     .list{
      margin-top:1em;
     }

     .checklist {
      font-size: 24px;
      color: rgb(0, 0, 0);
    }

     .list, .th, .td {
      border: 1px solid black;
      border-collapse: collapse;
      font-size:12pt;
      margin-top:1.5em;
      margin-left:0.4em;
      }

      .kegiatan{
            margin-top:1.5em;
      }

      .right{
            text-align: right;
      }
      .persyaratan{
            margin-top:1.5em;
            line-height:1;
      }

      h6{
            font-size:12pt;
            font-weight:400;
            line-height:1.5;
      }
      p{
            font-size:12pt;
      }

      .koordinator{
            margin-left:auto;
            margin-right:auto;
            line-height:1;
      }

      .staff{
            line-height:1;
      }
      


    
     </style >
</head>
<body>




<div class = "rangkasurat">
     <table class="header" width = "100%">
           <tr>
                 <td> <img src="{{asset('/assets/img/logoPOLSUB.png')}}" width="120px"> </td>
                 <td style="width:99%" class = "tengah">
                  <br>
                       <h2 style="line-height:1px;font-weight:50">KEMENTERIAN PENDIDIKAN, KEBUDAYAAN,</h2>
                       <h2 style="line-height:25px;font-weight:50">RISET, DAN TEKNOLOGI</h2>
                       <h2 style="margin-top:0.2em;margin-bottom:1em">POLITEKNIK NEGERI SUBANG</h2>
                       <h4 style="font-weight:1;line-height:1px;">Jl. Brigjen Katamso No.37(Belakang RSUD), Dangdeur, Subang, Jawa Barat 41211</h4>
                       <h4 style="font-weight:1;line-height:20px;">Telp. (0260) 417658 Laman: <span style="color:blue">https://www.polsub.ac.id</span></h4>
                 </td>
            </tr>
      </table>
     {{-- <div class="judul">
      <h4 style="font-weight:bold; font-size:14px;" >BERITA ACARA PEMINJAMAN BARANG INVENTARIS</h4>
      <h4 style="line-height:20px; font-size:14px;">POLITEKNIK NEGERI SUBANG</h4>
      </div> --}}

      <div class="isi" style="font-size:14px">
            <table width="100%" class="mt-2">
                  {{-- <tr align="justify">
                        <td colspan="4"><p>
                              Pada Hari Ini, {{ $currentDate }} Rabu Tanggal 25343 Bulan 234543 Tahun 45325 45325 telah memberikan izin kepada:</p></td>
                  </tr> --}}
                  <tr>
                        <td style="width:20%"><p>Nomor</p></td>
                        <td style="width:2%"><p>:</p></td>
                        <td style="width:48%"><p>{{@$izinPenelitian->no_surat}}</p></td>
                        <td style="width:30%" class="right"><p>{{ $currentDate }}</p></td>
                  </tr>
                  <tr>
                        <td style="width:20%"><p>Lapiran</p></td>
                        <td style="width:2%"><p>:</p></td>
                        <td style="width:48%"><p>-</p></td>
                        <td style="width:30%"></td>
                  </tr>
                  <tr>
                        <td style="width:20%"><p>Perihal</p></td>
                        <td style="width:2%"><p>:</p></td>
                        <td style="width:48%"><p>{{@$izinPenelitian->perihal}}</p></td>
                        <td style="width:30%"></td>
                  </tr>
                  <br>
                  <tr>
                        <td style="width:20%"><p>Kepada Yth</p></td>
                  </tr>
                  <tr>
                        <td style="width:20%" colspan="4"><p>Direktur {{@$izinPenelitian->nama_tempat}}</p></td>
                  </tr>
                  <tr>
                        <td style="width:20%"><p>Ditempat </p></td>
                  </tr>
                  <br>
                  <tr align="justify">
                        <td colspan="4">
                              <p>Berdasarkan surat dari GHHhhhh 
                              pada tanggal {{ Carbon\Carbon::parse($izinPenelitian->created_at)->translatedFormat('d F Y') }} 
                              perihal permohonan verifikasi ijazah untuk mahasiswa yang bekerja di Rumah Sakit
                              tersebut.</p>
                        </td>
                  </tr>
                  <tr align="justify">
                        <td colspan="4">
                              <p>Maka dengan ini kami sampaikan data alumni tersebut adalah benar alumni dari Politeknik
                                    Negeri Subang pada program studi D III Keperawatan atas nama :</p>
                        </td>
                  </tr>
            </table>

            <table width="100%" class="list">
                  <tr>
                        <th class="th" rowspan="2">No</th>
                        <th class="th" rowspan="2">Nama</th>
                        <th class="th" rowspan="2"><p>NIM</p></th>
                        <th class="th" rowspan="2"><p>Tahun Lulus</p></th>
                        <th class="th" colspan="2"><p>Hasil Verifikasi</p></th>
                  </tr>
                  <tr>
                        <th class="th"><p>Ya</p></th>
                        <th class="th"><p>Tidak</p></th>
                  </tr>
                  @php
                  $i = 0;
                  @endphp
                  {{-- -- @foreach($keranjang as $data) -- --}}
                  @php
                  $i = $i+1;
                  @endphp
                  <tr>
                        <td style="text-align:center;width:10%" class="td"><p>1</p></td>
                        <td class="td" style="width:50%"><p>Lana Ismail</p></td>
                        <td class="td" style="text-align:center;width:30%"><p>10107036</p></td>
                        <td class="td" style="text-align:center;width:20%"><p>2023</p></td>
                        <td class="td" style="text-align:center;width:15%">
                              {{-- -- <p>
                                    @if($data->kondisi_item == "Ready")
                                    Baik
                                    @elseif($data->kondisi_item == "Rusak")
                                    Rusak
                                    @endif
                              </p> -- --}}
                              <span class="checklist"><i class="fas fa-check"></i></span>
                        </td>
                        <td class="td" style="text-align:center;width:15%">
                              {{-- -- <p>
                                    @if($data->kondisi_item == "Ready")
                                    Baik
                                    @elseif($data->kondisi_item == "Rusak")
                                    Rusak
                                    @endif
                              </p> -- --}}
                        </td>
                  </tr>
                  {{-- -- @endforeach -- --}}
            </table>

            <table width="100%" class="kegiatan">
                  <tr align="justify">
                        <td colspan="3"><p>Demikian surat ini dibuat untuk dipergunakan sebagaimana mestinya. Atas perhatiannya
                              diucapkan terima kasih.</p></td>
                  </tr>
            </table>
            <br>
            <div class="ttd">
                  <table class="staff" width="100%">
                        <tr>
                              <td><p></p></td>
                              <td style="width:50%"></td>
                              <td><p>Wakil Direktur I,</p></td>
                        </tr>
                        <tr>
                              <td><p></p></td>
                        </tr>
                        <tr>
                              <td style="height:60px" colspan="3"></td>
                        </tr>
                        <tr>
                              <td><p></p></td>
                              <td style="width:50%"></td>
                              <td><p>Lana Ismail</p></td>
                        </tr>
                        <tr>
                              <td><p></p></td>
                              <td style="width:50%"></td>
                              <td><p>NIP. 376723923489234</p></td>
                        </tr>
                  </table>
            </div>
      </div>
</div>



</body>
</html>