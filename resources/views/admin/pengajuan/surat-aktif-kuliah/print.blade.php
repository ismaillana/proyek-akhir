<html>
<head>
    <title>Surat Keterangan Aktif Kuliah </title>
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
                       <h2 style="line-height:25px;font-weight:50">RISET DAN TEKNOLOGI</h2>
                       <h2 style="margin-top:0.2em;margin-bottom:1em">POLITEKNIK NEGERI SUBANG</h2>
                       <h4 style="font-weight:1;line-height:1px;">Jl. Brigjen Katamso No.37(Belakang RSUD), Dangdeur, Subang, Jawa Barat 41211</h4>
                       <h4 style="font-weight:1;line-height:20px;">Telp. (0260) 417658 Laman: <span style="color:blue">https://www.polsub.ac.id</span></h4>
                 </td>
            </tr>
      </table>
     <div class="judul mb">
      <h4 style="text-decoration: underline; font-size:14px;" >SURAT KETERANGAN MASIH KULIAH</h4>
      <h4 style="line-height:20px; font-size:14px;">Nomor: {{@$aktifKuliah->no_surat}}</h4>
      </div>

      <div class="isi" style="font-size:14px">
      <table width="100%" class="kegiatan">
            <tr align="justify">
                  <td><p>Yang bertanda tangan dibawah ini:</p></td>
            </tr>
      </table>

      <table width="100%" class="kegiatan">
            <tr>
                  <td style="width:20%"><p>Nama</p></td>
                  <td style="width:2%"><p>:</p></td>
                  <td style="width:78%"><p>Wiwik Endah Rahayu, S.TP.,M.Si.</p></td>
            </tr>
            <tr>
                  <td style="width:20%"><p>NIP</p></td>
                  <td style="width:2%"><p>:</p></td>
                  <td style="width:78%"><p>198311282015042001</p></td>
            </tr>
            <tr>
                  <td style="width:20%"><p>Pangkat</p></td>
                  <td style="width:2%"><p>:</p></td>
                  <td style="width:78%"><p>Penata Muda Tk. I/III.b</p></td>
            </tr>
            <tr>
                  <td style="width:20%"><p>Jabatan</p></td>
                  <td style="width:2%"><p>:</p></td>
                  <td style="width:78%"><p>Wakil Direktur I</p></td>
            </tr>
      </table>

      <table width="100%" class="kegiatan">
            <tr align="justify">
                  <td><p>Menyatakan dengan sesungguhnya, bahwa:</p></td>
            </tr>
      </table>

      <table width="100%" class="kegiatan">
            <tr>
                  <td style="width:25%"><p>Nama</p></td>
                  <td style="width:2%"><p>:</p></td>
                  <td style="width:73%"><p>{{@$aktifKuliah->mahasiswa->user->name}}</p></td>
            </tr>
            <tr>
                  <td style="width:25%"><p>NIM</p></td>
                  <td style="width:2%"><p>:</p></td>
                  <td style="width:73%"><p>{{@$aktifKuliah->mahasiswa->user->nomor_induk}}</p></td>
            </tr>
            <tr>
                  <td style="width:25%"><p>Tempat/Tanggal Lahir</p></td>
                  <td style="width:2%"><p>:</p></td>
                  <td style="width:73%"><p>{{@$aktifKuliah->mahasiswa->tempat_lahir}}, {{ Carbon\Carbon::parse(@$aktifKuliah->tanggal_lahir)->translatedFormat('d F Y') }}</p></td>
            </tr>
            <tr>
                  <td style="width:25%"><p>Jurusan/Prodi</p></td>
                  <td style="width:2%"><p>:</p></td>
                  <td style="width:73%"><p>{{@$aktifKuliah->mahasiswa->programStudi->jurusan->name}}/{{@$aktifKuliah->mahasiswa->programStudi->name}}</p></td>
            </tr>
            <tr>
                  <td style="width:25%"><p>Semester/TA</p></td>
                  <td style="width:2%"><p>:</p></td>
                  <td style="width:73%"><p>{{@$aktifKuliah->mahasiswa->semester}}/{{@$aktifKuliah->mahasiswa->tahun_ajaran}}</p></td>
            </tr>
      </table>

      <table width="100%" class="kegiatan">
            <tr align="justify">
                  <td><p>Adalah benar mahasiswa pada Perguruan Tinggi Politeknik Negeri Subang dan orang tua/wali dari mahasiswa tersebut adalah:</p></td>
            </tr>
      </table>

      <table width="100%" class="kegiatan">
            <tr>
                  <td style="width:20%"><p>Nama</p></td>
                  <td style="width:2%"><p>:</p></td>
                  <td style="width:78%"><p>{{@$aktifKuliah->mahasiswa->orang_tua}}</p></td>
            </tr>
            <tr>
                  <td style="width:20%"><p>NIP/NRP</p></td>
                  <td style="width:2%"><p>:</p></td>
                  <td style="width:78%"><p>{{@$aktifKuliah->mahasiswa->nip_nrp}}</p></td>
            </tr>
            <tr>
                  <td style="width:20%"><p>Pangkat/Golongan</p></td>
                  <td style="width:2%"><p>:</p></td>
                  <td style="width:78%"><p>{{@$aktifKuliah->mahasiswa->pangkat}}</p></td>
            </tr>
            <tr>
                  <td style="width:20%"><p>Jabatan</p></td>
                  <td style="width:2%"><p>:</p></td>
                  <td style="width:78%"><p>{{@$aktifKuliah->mahasiswa->jabatan}}</p></td>
            </tr>
            <tr>
                  <td style="width:20%"><p>Pada Instansi</p></td>
                  <td style="width:2%"><p>:</p></td>
                  <td style="width:78%"><p>{{@$aktifKuliah->mahasiswa->instansi}}</p></td>
            </tr>
      </table>

      <table width="100%" class="kegiatan">
            <tr align="justify">
                  <td><p>Demikian surat keterangan ini diberikan dengan sebenar-benarnya kepada yang bersangkutan untuk dipergunakan sebagaimana mestinya.</p></td>
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