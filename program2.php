<!DOCTYPE html>
<html lang="en">
<!-- 
    Di dalam database matakuliah ada dua tabel yaitu tabel dalam_prodi dan tabel luar_prodi
 -->
<?php 
    #Bagian ini untuk memanggil tabel dalam_prodi
    $conn = new mysqli("localhost","root","","mata_kuliah");
    if(!$conn){
        die("Connection dailed: ".mysqli_connect_error());
    }
    $queryDp = "SELECT * FROM dalam_prodi";
    $resultDalam = mysqli_query($conn, $queryDp);
    $dataJsonDalam = array();
    // isi setiap data pada tabel dalam_prodi akan dimasukan ke variabel $dataJsonDalam untuk dijadikan sebagai file json
    while($dataDalam = mysqli_fetch_assoc($resultDalam)){
        $dataJsonDalam[] = $dataDalam;
    }
    // variabel $dataJsonDalam dimasukkan/di write ke dalam file json yaitu datajsondalamp
    $fileOpenDalam = fopen('datajsondalamp.json','w');
    fwrite($fileOpenDalam, json_encode($dataJsonDalam));
    fclose($fileOpenDalam);

    // Bagian ini untuk memanggil tabel luar_prodi
    $conn2 = new mysqli("localhost","root","","mata_kuliah");
    if(!$conn2){
        die("Connection dailed: ".mysqli_connect_error());
    }
    $queryLp = "SELECT * FROM luar_prodi";
    $resultLuar = mysqli_query($conn2, $queryLp);
    $dataJsonLuar = array();
    // isi setiap data pada tabel luar_prodi akan dimasukan ke variabel $dataJsonLuar untuk dijadikan sebagai file json
    while($dataLuar = mysqli_fetch_assoc($resultLuar)){
        $dataJsonLuar[] = $dataLuar;
    }
    // variabel $dataJsonLuar dimasukkan/di write ke dalam file json yaitu datajsonluarp
    $fileOpenLuar = fopen('datajsonluarp.json','w');
    fwrite($fileOpenLuar, json_encode($dataJsonLuar));
    fclose($fileOpenLuar);
?>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jquery</title>
    <style>
        /* Styling untuk elemen html nya */
        table, td, th {  
          border: 1px solid #ddd;
          text-align: left;
        }

        table {
          border-collapse: collapse;
        }

        tr:nth-child(even){
            background-color: seashell;
        }
        th{
            background-color: salmon;
        }

        th, td {
          padding: 15px;
        }
        .prodi{
            height: 100%;
            cursor: pointer;
            padding: 20px;
            font-family: sans-serif;
            font-size: 18px;
            background-color: rgb(255, 255, 255);
	        color: #1baedb;
        }

        .prodi:hover{
            background-color: #1baedb;
            color: #ddd;
        }

        #body{
            margin: auto;
            border: 3px solid #73AD21;
            width: 60%;
        }
        #tabelData{
            margin: auto;
            width: 80%;
        }
        #inisiasi{
            margin: auto;
            width: 30%;
        }
        #tampilkan{
            color: white;
            background-color: red;
            border: none;
            padding: 8px;
        }
        .pagination{
            margin: auto;
            width: 15%;
        }
        .pagination button{
            width: 50px;
            background-color: sandybrown;
        }
    </style>
</head>
<body>
<div id="body">
        <div id="inisiasi">
            <select name="tahun" id="tahun">
                <option value=0>Pilih Tahun Ajaran</option>
                <option value="ganjil">2022/2023 Ganjil</option>
                <option value="genap">2022/2023 Genap</option>
            </select>
            <button type="submit" id="tampilkan">Tampilkan</button>
        </div>
        
        <div id="tabelData">
            <input type="text" id="search" value="Cari Data">
            <button class="prodi" id="dalamProdi">Dalam Prodi</button>
            <button class="prodi" id="luarProdi">Luar Prodi</button>
            <select name="jmlData" id="jmlData">
                <option value=10>10</option>
                <option value=20>20</option>
                <option value=30>30</option>
            </select>
            <table>
                <thead>
                    <th>Kode Kelas</th>
                    <th>Nama Kelas</th>
                    <th>Kode Matakuliah</th>
                    <th>Nama Mata kuliah</th>
                    <th>SKS</th>
                </thead>
                <tbody id="dataTabel">
                </tbody>
            </table>
        </div>
        
        <div class="pagination" id="pagination"></div>
    </div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script>
    var arrayJsonDalam =[];
    var arrayJsonLuar =[];
    let currentPage = 1;
    let perHalaman = 10;
    var dataTabel = $("#dataTabel");
    var paginationsItem = $('#pagination');
    var tessa = $("#tahun");
    var cekPosisi = []
  
    // Pemanggilan ajax untuk pemrosesan json
    $.getJSON("datajsondalamp.json", function(result){
       arrayJsonDalam = result; 
    })

    $.getJSON("datajsonluarp.json", function(result){
        arrayJsonLuar = result;
    })

    // Pemrosesan query saat terjadi perubahan pada search (sedang terjadi search)
    $('#search').on('change',(event)=>{
        var hasilSearchDalam = [];
        var hasilSearchLuar = [];
        console.log(event.target.value)
        for(var i=0; i<arrayJsonDalam.length; i++){
            if(arrayJsonDalam[i].kode_kelas == event.target.value || arrayJsonDalam[i].kelas == event.target.value || arrayJsonDalam[i].kode == event.target.value || arrayJsonDalam[i].nama_mata_kuliah == event.target.value || arrayJsonDalam[i].sks == event.target.value){
                hasilSearchDalam.push(arrayJsonDalam[i])
            }
        }

        for(var i=0; i<arrayJsonLuar.length; i++){
            if(arrayJsonLuar[i].kode_kelas == event.target.value || arrayJsonLuar[i].kelas == event.target.value || arrayJsonLuar[i].kode == event.target.value || arrayJsonLuar[i].nama_mata_kuliah == event.target.value || arrayJsonLuar[i].sks == event.target.value){
                hasilSearchLuar.push(arrayJsonLuar[i])
            }
        }

        if(hasilSearchDalam.length > 0 && cekPosisi[cekPosisi.length-1]==0){
            currentPage = 1 //saat function ini dijalankan, halaman dikembalikan lagi ke awal untuk menampilkan hasil pencarian
            dalamProdi(hasilSearchDalam, dataTabel[0], perHalaman, currentPage);
        }

        if(hasilSearchLuar.length >0 && cekPosisi[cekPosisi.length-1]==1){
            currentPage = 1 //saat function ini dijalankan, halaman dikembalikan lagi ke awal untuk menampilkan hasil pencarian
            luarProdi(hasilSearchLuar, dataTabel[0], perHalaman, currentPage);
        }

        if(hasilSearchLuar == 0 && hasilSearchDalam == 0){
            dataTabel[0].innerHTML = "";
            alert("data tidak ada");
        }
    })

    // Tabel data disembunyikan dulu
    $("#tabelData").hide()

    $('#tahun').change(function(){
        var tes = "";
        tes = $("#tahun");
    })

    $("#tampilkan").click(function(){
        // Saat tombol dipencet tabel data dapat ditampilkan
        $("#tabelData").show()
        var cond = 1;
        currentPage = 1; //saat function ini dijalankan, halaman dikembalikan lagi ke awal
        dalamProdi(arrayJsonDalam, dataTabel[0], perHalaman, currentPage);
        setUpPagination(arrayJsonDalam, paginationsItem[0], perHalaman, cond)
    })


    $("#dalamProdi").click(function(){
        // Saat tombol dalam prodi dipencet makan data akan ditampilkan 
        var cond = 1;
        currentPage = 1 //saat function ini dijalankan, halaman dikembalikan lagi ke awal
        dalamProdi(arrayJsonDalam, dataTabel[0], perHalaman, currentPage);
        setUpPagination(arrayJsonDalam, paginationsItem[0], perHalaman, cond)
    })


    $("#luarProdi").click(function(){
        // Saat tombol dalam prodi dipencet makan data akan ditampilkan 
        var cond = 0;
        currentPage = 1 //saat function ini dijalankan, halaman dikembalikan lagi ke awal
        luarProdi(arrayJsonLuar, dataTabel[0], perHalaman, currentPage);
        setUpPagination(arrayJsonLuar, paginationsItem[0], perHalaman, cond)
    })

    $("#jmlData").on('change',(event)=>{
        // Penampilan baris data sesaui dari jumlah yang diinginan 
        var tahunCek = $("#tahun")
        var jmlData = document.getElementById("jmlData").value
        console.log(jmlData)
        if(tahunCek[0].value == "ganjil"){
            if(jmlData == 10){
                dalamProdi(arrayJsonDalam, dataTabel[0], jmlData, currentPage);
            }else if(jmlData == 20){
                dalamProdi(arrayJsonDalam, dataTabel[0], jmlData, currentPage);
            }else if(jmlData == 30){
                dalamProdi(arrayJsonDalam, dataTabel[0], jmlData, currentPage);
            }
        }else if(tahunCek[0].value == "genap"){
            if(jmlData == 10){
                luarProdi(arrayJsonLuar, dataTabel[0], jmlData, currentPage)
            }else if(jmlData == 20){
                luarProdi(arrayJsonLuar, dataTabel[0], jmlData, currentPage)
            }else if(jmlData == 30){
                luarProdi(arrayJsonLuar, dataTabel[0], jmlData, currentPage)
            }
        }
    })


    function dalamProdi(dataMatkul, templateData, perHalaman, hal){
        cekPosisi.push(0)
        templateData.innerHTML="" //tBody html dikoosngkan terlebih dahulu supaya setiap function di akses tidak ada terjadi penumpukan data. 
        hal--;

        // Pemfilteran data dimana data akan dimasukkan ke variabel arrayFixedTahunDalam sesuai dari tahun yang dipilih
        var arrayFixedTahunDalam = [];
        for(var i=0; i<dataMatkul.length; i++){
            if(dataMatkul[i].semester ===tahun.value){
                arrayFixedTahunDalam.push(dataMatkul[i]);
            }
        }

        // Pentuan akses index untuk pagination, dimana jumlah data yang default adalah 10 dan sisanya kelipatan 10 sampai 30. 
        let awal = perHalaman*hal;
        let akhir = awal + perHalaman;
        let paginatedItems = arrayFixedTahunDalam.slice(awal,akhir)

        for(var i=0; i<paginatedItems.length; i++){

            var barisData = document.createElement("tr"); //Pembuatan baris data

            //Pembuatan kolom
            var kodeKelas = document.createElement("td"); 
            var namaKelas = document.createElement("td");
            var kodeMatkul = document.createElement("td");
            var namaMatkul = document.createElement("td");
            var sks = document.createElement("td");

            // Data dari objek dimasukkan ke setaip kolom yang sudah dibuat
            kodeKelas.appendChild(document.createTextNode(paginatedItems[i].kode_kelas));
            namaKelas.appendChild(document.createTextNode(paginatedItems[i].kelas));
            kodeMatkul.appendChild(document.createTextNode(paginatedItems[i].kode));
            namaMatkul.appendChild(document.createTextNode(paginatedItems[i].nama_mata_kuliah));
            sks.appendChild(document.createTextNode(paginatedItems[i].sks));

            // Kolom yang sudah terisi oleh data dimasukkan ke dalam baris data
            barisData.appendChild(kodeKelas);
            barisData.appendChild(namaKelas);
            barisData.appendChild(kodeMatkul);
            barisData.appendChild(namaMatkul);
            barisData.appendChild(sks);

            // baris data dimasukkan ke dalam tbody dari tabel html. 
            templateData.appendChild(barisData);
        }
    }

    function luarProdi(dataMatkul, templateData, perHalaman, hal){
        cekPosisi.push(1)
        templateData.innerHTML="" //tBody html dikoosngkan terlebih dahulu supaya setiap function di akses tidak ada terjadi penumpukan data.
        hal--;

        // Pemfilteran data dimana data akan dimasukkan ke variabel arrayFixedTahunDalam sesuai dari tahun yang dipilih
        var arrayFixedTahunLuar = [];
        var tahun = document.getElementById("tahun");
        for(var i=0; i<dataMatkul.length; i++){
            if(dataMatkul[i].semester ===tahun.value){
                arrayFixedTahunLuar.push(dataMatkul[i]);
            }
        }
        console.log(arrayFixedTahunLuar)

        // Pentuan akses index untuk pagination, dimana jumlah data yang default adalah 10 dan sisanya kelipatan 10 sampai 30. 
        let awal = perHalaman*hal;
        let akhir = awal + perHalaman;
        let paginatedItems = arrayFixedTahunLuar.slice(awal,akhir)

        for(var i=0; i<paginatedItems.length; i++){
                var barisData = document.createElement("tr"); //Pembuatan baris data

                //Pembuatan kolom
                var kodeKelas = document.createElement("td");
                var namaKelas = document.createElement("td");
                var kodeMatkul = document.createElement("td");
                var namaMatkul = document.createElement("td");
                var sks = document.createElement("td");

                // Data dari objek dimasukkan ke setaip kolom yang sudah dibuat
                kodeKelas.appendChild(document.createTextNode(paginatedItems[i].kode_kelas));
                namaKelas.appendChild(document.createTextNode(paginatedItems[i].kelas));
                kodeMatkul.appendChild(document.createTextNode(paginatedItems[i].kode));
                namaMatkul.appendChild(document.createTextNode(paginatedItems[i].nama_mata_kuliah));
                sks.appendChild(document.createTextNode(paginatedItems[i].sks));

                // Kolom yang sudah terisi oleh data dimasukkan ke dalam baris data
                barisData.appendChild(kodeKelas);
                barisData.appendChild(namaKelas);
                barisData.appendChild(kodeMatkul);
                barisData.appendChild(namaMatkul);
                barisData.appendChild(sks);

                // baris data dimasukkan ke dalam tbody dari tabel html.
                templateData.appendChild(barisData);
        }
    }

    function setUpPagination(dataMatkul, dataTabel, rowPerPage,cond){
        dataTabel.innerHTML=""; //tBody html dikoosngkan terlebih dahulu supaya setiap function di akses tidak ada terjadi penumpukan data

        // Menghitung halaman dari jumlah data yang ada
        let hitungHalaman = Math.ceil(dataMatkul.length / rowPerPage);
        for(var i=1; i<hitungHalaman+1; i++){
            let btn = paginationButton(i, dataMatkul,cond);
            dataTabel.appendChild(btn);
        }
    }

    function paginationButton(halaman, dataMatkul, cond){
        // Pembuatan tombol untuk pagination nya
        let button = document.createElement('button');
        button.innerText = halaman;

        if(currentPage == halaman){
            button.classList.add('active')
        }

        button.addEventListener('click', function(){
            currentPage = halaman;
            if(cond == 1){
                dalamProdi(dataMatkul, dataTabel[0], perHalaman, currentPage);
            }else{
                luarProdi(dataMatkul, dataTabel[0], perHalaman, currentPage)
            }
            let currentBtn = document.querySelector('.pageNumbers button.active');
            currentBtn.classList.remove('active');
            button.classList.add('active');
        })
        return button;
    }
</script>
</body>
</html>


