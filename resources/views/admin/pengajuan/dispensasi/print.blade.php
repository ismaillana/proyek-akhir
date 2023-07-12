<html>
<head>
    <title>Surat Pengajuan Izin Penelitian </title>
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

    <link rel="shortcut icon" href="{{ asset('template/assets/img/logoPOLSUB.png')}}">
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

      <div class="isi" style="font-size:14px">
            <table width="100%" class="mt-2">
                  <tr>
                        <td style="width:20%"><p>Nomor</p></td>
                        <td style="width:2%"><p>:</p></td>
                        <td style="width:48%"><p>{{@$dispensasi->no_surat}}</p></td>
                        <td style="width:30%" class="right"><p>{{ @$dispensasi->tanggal_surat }}</p></td>
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
                        <td style="width:30%">Permohonan Izin Dispensasi Kuliah</td>
                  </tr>
                  <br>
                  <tr>
                        <td style="width:20%"><p>Yang Terhormat,</p></td>
                  </tr>
                  <tr>
                        <td style="width:20%" colspan="4"><p>Bapak/Ibu Dosen Pengampu Mata Kuliah</p></td>
                  </tr>
                  <tr>
                        <td style="width:20%"><p>Ditempat</p></td>
                  </tr>
            </table>

            <table width="100%" class="kegiatan">
                  <tr align="justify">
                        <td>
                              <p>Dengan Hormat,</p>
                        </td>
                  </tr>
            </table>

            <table width="100%">
                  <tr align="justify">
                        <td>
                              <p>Sehubungan dengan adanya kegiatan {{@$dispensasi->kegiatan}} yang akan dilaksanakan di {{@$dispensasi->nama_tempat}}, 
                              kami mohon kepada Bapak/Ibu agar memberika izin kepada mahasiswatersebut dibawah untuk tidak mengikuti kegiatan perkuliahan sebagaimana mestinya:</p>
                        </td>
                  </tr>
            </table>

            <table width="100%" class="list">
                  <tr>
                        <th class="th">No</th>
                        <th class="th">Nama</th>
                        <th class="th"><p>NIM</p></th>
                  </tr>
                  @foreach($mahasiswa as $item)
                  
                  <tr>
                        <td style="text-align:center;width:10%" class="td"><p>{{$loop->iteration}}</p></td>
                        <td class="td" style="width:50%"><p>{{$item->user->name}}</p></td>
                        <td class="td" style="text-align:center;width:40%"><p>{{$item->nim}}</p></td>
                  </tr>
                  @endforeach
                  </table>

            <table width="100%" class="kegiatan">
                  <tr align="justify">
                        <td colspan="3"><p>Demikian surat permohonan ini kami sampaikan, atas perhatiannya kami ucapkan terima kasih.</p></td>
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
                              <td><p>Wiwik Endah Rahayu, S.TP.,M.Si.</p></td>
                        </tr>
                        <tr>
                              <td><p></p></td>
                              <td style="width:50%"></td>
                              <td><p>NIP. 198311282015042001</p></td>
                        </tr>
                  </table>
            </div>
      </div>
</div>



</body>
</html>