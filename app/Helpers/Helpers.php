<?php

function formatRupiah($angka)
{
    $rupiah = $angka > 0 ? number_format($angka, 0, ',', '.') : "0";
    return "Rp $rupiah";
}
function formatTanggal($datetimeString, $outputFormat = 'd F Y')
{
    $timestamp = strtotime($datetimeString);
    if ($timestamp === false) {
        // Gagal mengonversi string datetime
        return 'Format datetime tidak valid';
    }

    return date($outputFormat, $timestamp);
}

function isAdmin()
{
    if (auth()->user()->role === 'admin') {
        return true;
    } else {
        return false;
    }
}
