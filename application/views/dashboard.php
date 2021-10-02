<div class="jumbotron bg-primary text-white">
    <h4 class="my-0">Selamat datang di</h4>
    <h1 class="display-4 my-0">Aplikasi Absensi Online</h1>
    <hr class="my-4">
    <p class="lead">Aplikasi absensi online berbasis website PT. Citra Jelajah Informatika</p>
    <?php
    $waktu_awal = strtotime('08:40:00');
    $waktu_akhir = strtotime('17:50:00');
    $waktu_is_awal = strtotime('12:00:00');
    $waktu_is_akhir = strtotime('13:00:00');

    $menit = ($waktu_is_awal - $waktu_awal) + ($waktu_akhir-$waktu_is_akhir);
    $menit2 = round($menit/(3600), 2);

    echo $menit2;
    ?>
</div>