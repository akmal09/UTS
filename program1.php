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
    <title>Javascript DOM</title>
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
            <button type="submit" id="tampilkan" onclick="tampilDalamProdi()">Tampilkan</button> <!-- Untuk menjalankan function tampilDalamProdi yaitu funtion yang menampilan list mata kuliah yang ada di tabel dalam_prodi, jadi secara default program akan menampilkan list mata kuliah yang ada di dalam rodi terlebih dahulu -->
        </div>
        
        <div id="tabelData">
            <input type="text" id="search" value="Cari Data">
            <button class="prodi" onclick="tampilDalamProdi()">Dalam Prodi</button> <!-- Untuk menjalankan function tampilDalamProdi yaitu funtion yang menampilan list mata kuliah yang ada di tabel dalam_prodi -->
            <button class="prodi" onclick="tampilLuarProdi()">Luar Prodi</button> <!-- Untuk menjalankan function tampilLuarProdi yaitu funtion yang menampilan list mata kuliah yang ada di tabel luar_prodi -->
            <select name="jmlData" id="jmlData" onchange="rowData(value)">
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
    
<script>
    var arrayJsonDalam; //Sebagai variabel untuk memindahankan data json yang isinya array dari tabel dalam_prodi
    var arrayJsonLuar; //Sebagai variabel untuk memindahankan data json yang isinya array dari tabel luar_prodi
    var paginationsItem = document.getElementById('pagination');
    var tabelData = document.getElementById("tabelData");
    let currentPage = 1;
    let perHalaman = 10;
    var dataTabel = document.getElementById("dataTabel");
    var searchForm = document.getElementById("search");
    var cekPosisi = []; //Untuk mengecek saat melakukan searching query search nya ini dibuat untuk tabel dalam_prodi atau tabel luar_prodi
    // Penjelasan variabel cekPosisi :
    // Jadi saat user mengakses tabel luar_prodi maka cekPosisi akan menambah variabel 1 ke dalam arraynya sedangkan variabel 0 ditambahkan kalau user mengakses tabel dalam_prodi. Penjelasan selanjutnya ada function queryProcess
    var tahun = document.getElementById("tahun");
    tabelData.style.visibility = "hidden"
    fetch("datajsondalamp.json")
        .then(response => response.json())
        .then(dataJsonDalam => {
            arrayJsonDalam = dataJsonDalam //data yang ada dari file datajsondalamp.json di inisiasi ke variabel arrayJsonDalam
        })

    fetch("datajsonluarp.json")
        .then(response => response.json())
        .then(dataJsonLuar => {
            arrayJsonLuar = dataJsonLuar //data yang ada dari file datajsonluarp.json di inisiasi ke variabel arrayJsonLuar
        })

    searchForm.addEventListener('change',queryProcess);
    function queryProcess(query){
        // Jadi disini query dari search akan diproses dengan menggunakan percabangan yaitu apakah value dari setiap key pada arrayJsonDalam atau arrayJsonLuar ada yang sama.
        var hasilSearchDalam = [];
        var hasilSearchLuar = [];

        for(var i=0; i<arrayJsonDalam.length; i++){
            // Jika ada yang sama, maka nilai key dan value dari file arrayJsonDalam akan dimasukkan ke dalam file array hasilSearchDalam
            if(arrayJsonDalam[i].kode_kelas == query.target.value || arrayJsonDalam[i].kelas == query.target.value || arrayJsonDalam[i].kode == query.target.value || arrayJsonDalam[i].nama_mata_kuliah == query.target.value || arrayJsonDalam[i].sks == query.target.value){
                hasilSearchDalam.push(arrayJsonDalam[i])
            }
        }

        for(var i=0; i<arrayJsonLuar.length; i++){
            // Jika ada yang sama, maka nilai key dan value dari file arrayJsonLuar akan dimasukkan ke dalam file array hasilSearchLuar
            if(arrayJsonLuar[i].kode_kelas == query.target.value || arrayJsonLuar[i].kelas == query.target.value || arrayJsonLuar[i].kode == query.target.value || arrayJsonLuar[i].nama_mata_kuliah == query.target.value || arrayJsonLuar[i].sks == query.target.value){
                hasilSearchLuar.push(arrayJsonLuar[i])
            }
        }

        // Disinilah di cek variabel array cekPosisi, mungkin bisa dilihat dulu maksud dari variabel cekPosisi ini apa saat pendeklarasian di awal pada line ---
        // Jadi percabangan akan mencek apa nilai dari cekPosisi pada indeks terakhir. 
        // Jika nilai pada indeks terakhir nya adalah 0, maka user sedang mengakses tabel dalam_prodi dan function dalamProdi lah yang akan dieksekusi hasilnya dan jika isi array hasilSearchDalam pun juga harus > 0 (tandanya ada data yang sesuai dari inputan search query).
        if(hasilSearchDalam.length > 0 && cekPosisi[cekPosisi.length-1]==0){
            currentPage = 1 //saat function ini dijalankan, kembali lagi ke halaman awal untuk menampilkan hasil pencarian
            dalamProdi(hasilSearchDalam, dataTabel, perHalaman, currentPage);
        }

        // Sedangkan jika indeks terakhir nya adalah 0, maka user sedang mengakses tabel luar_prodi dan function luarProdi lah yang akan dieksekusi hasilnya dan jika isi array hasilSearchDalam pun juga harus > 0 (tandanya ada data yang sesuai dari inputan search query).
        if(hasilSearchLuar.length >0 && cekPosisi[cekPosisi.length-1]==1){
            currentPage = 1 //saat function ini dijalankan, kembali lagi ke halaman awal untuk menampilkan hasil pencarian
            luarProdi(hasilSearchLuar, dataTabel, perHalaman, currentPage);
        }

        // Sedankan kalau isi dari hasilSearchLuar dan hasilSearchDalam nya itu 0 (tidak ada isinya), maka akan ditampilkan pesan alert keada user bahwa data yang dicari tidak ada. 
        if(hasilSearchLuar == 0 && hasilSearchDalam == 0){
            dataTabel.innerHTML = "";
            alert("data tidak ada");
        }

    }

    function tampilDalamProdi(){
        tabelData.style.visibility = "visible";
        var cond = 1;
        currentPage = 1; //saat function ini dijalankan, halaman dikembalikan lagi ke awal 
        dalamProdi(arrayJsonDalam, dataTabel, perHalaman, currentPage)
        setUpPagination(arrayJsonDalam, paginationsItem, perHalaman,cond);
    }

    function tampilLuarProdi(){
        var cond = 0;
        currentPage = 1 //saat function ini dijalankan, halaman dikembalikan lagi ke awal
        luarProdi(arrayJsonLuar, dataTabel, perHalaman, currentPage);
        setUpPagination(arrayJsonLuar, paginationsItem, perHalaman, cond)
    }

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
                dalamProdi(dataMatkul, dataTabel, perHalaman, currentPage);
            }else{
                luarProdi(dataMatkul, dataTabel, perHalaman, currentPage)
            }
            let currentBtn = document.querySelector('.pageNumbers button.active');
            currentBtn.classList.remove('active');
            button.classList.add('active');
        })
        return button;
    }

    function rowData(jmlData){
        // function untuk mengakses data berdasarkan banyak data yang diinginkan. 
        var tahunCek = document.getElementById("tahun");
        console.log(jmlData," ",tahunCek.value)
        if(tahunCek.value == "ganjil"){
            if(jmlData == 10){
                dalamProdi(arrayJsonDalam, dataTabel, jmlData, currentPage);
            }else if(jmlData == 20){
                dalamProdi(arrayJsonDalam, dataTabel, jmlData, currentPage);
            }else if(jmlData == 30){
                dalamProdi(arrayJsonDalam, dataTabel, jmlData, currentPage);
            }
        }else if(tahunCek.value == "genap"){
            if(jmlData == 10){
                luarProdi(arrayJsonLuar, dataTabel, jmlData, currentPage)
            }else if(jmlData == 20){
                luarProdi(arrayJsonLuar, dataTabel, jmlData, currentPage)
            }else if(jmlData == 30){
                luarProdi(arrayJsonLuar, dataTabel, jmlData, currentPage)
            }
        }
    }

</script>
</body>
</html>