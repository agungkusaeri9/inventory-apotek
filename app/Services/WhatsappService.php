<?php

namespace App\Services;

use App\Models\Barang;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

class WhatsappService
{
    protected $client;
    protected $token;
    protected $wa_admin;

    public function __construct()
    {
        $this->client = new Client();
        $this->wa_admin = env('WA_ADMIN');
        $this->token = env('FONNTE_TOKEN');
    }

    public function send($target = NULL, $message)
    {
        try {
            $response = $this->client->post('https://api.fonnte.com/send', [
                'headers' => [
                    'Authorization' => $this->token,
                ],
                'multipart' => [
                    [
                        'name' => 'target',
                        'contents' => $target,
                    ],
                    [
                        'name' => 'message',
                        'contents' => $message,
                    ]
                ],
            ]);

            // dd($response->getBody()->getContents());
        } catch (RequestException $e) {
            // dd($e->getMessage());
        }
    }

    public function stokMenipis($barang_id)
    {
        $barang = Barang::find($barang_id);
        $message = "Halo, Admin.\n\n";
        $message .= "Kami ingin memberitahukan bahwa stok barang berikut sedang menipis:\n\n";
        $message .= "Nama Barang: " . $barang->nama . "\n";
        $message .= "Jumlah Tersisa: " . $barang->stok . "\n\n";
        $message .= "Mohon segera lakukan pengisian ulang stok agar tidak kehabisan. Terima kasih atas perhatian Anda.\n\nSalam,\nApotek";
        $this->send($this->wa_admin, $message);
    }
}
