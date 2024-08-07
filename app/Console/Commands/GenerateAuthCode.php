<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class GenerateAuthCode extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:generate-auth-code';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $response = Http::get('https://app15.toconline.pt/oauth/auth', [
            'response_type' => 'code',
            'client_id' => 'pt506844374_c341575-18049488f6d1021a',
            'scope' => 'commercial',
            'redirect_uri' => url('toconline/callback')
        ]);
    }
}
