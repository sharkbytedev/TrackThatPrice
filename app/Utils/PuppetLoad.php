<?php

namespace App\Utils;

use Illuminate\Support\Facades\Log;

class PuppetLoad
{
    public static function load(array $urls)
    {
        $u = $urls[0];
        for ($i = 1; $i < count($urls); $i += 1) {
            $u = $u.'[]'.escapeshellarg($urls[$i]);
        }
        $output = [];
        $code = null;
        $base = base_path();
        exec("node {$base}/puppet.js -h {$u}", $output, $code);
        if ($code == 0) {
            return json_decode(implode('', $output));
        } else {
            Log::error($output);
            throw new \Error("Puppeteer gave non-zero exit code {$code}");
        }
    }
}
