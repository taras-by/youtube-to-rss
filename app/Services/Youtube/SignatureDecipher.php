<?php

namespace App\Services\Youtube;

/**
 * @Todo Add Exceptions
 */
class SignatureDecipher
{
    const VIDEO_URL = 'https://www.youtube.com/watch?v=%s';
    const SCRIPT_URL = 'https://www.youtube.com/%s';

    private $videoId;

    public function __construct(string $videoId)
    {
        $this->videoId = $videoId;
    }

    public function getSignature(string $signature): string
    {
        $playerUrl = $this->getPlayerUrl();
        $playerScript = $this->getPlayerScript($playerUrl);

        $instructions = $this->getInstructionsFromCode($playerScript);
        return $this->decipherWithInstructions($signature, $instructions);
    }

    private function getPlayerUrl(): string
    {
        $data = file_get_contents(sprintf(self::VIDEO_URL, $this->videoId));

        preg_match('/yts\/jsbin\/player(.*)js/', $data, $matches);
        return sprintf(self::SCRIPT_URL, $matches[0]);
    }

    private function getPlayerScript(string $url): string
    {
        return file_get_contents($url);
    }

    private function getInstructionsFromCode(string $code): array
    {
        $instructions = [];

        // what javascript function is responsible for signature decryption?
        // var l=f.sig||Xn(f.s)
        // a.set("signature",Xn(c));return a
        if (preg_match('/signature",([a-zA-Z0-9]+)\(/', $code, $matches)) {

            $func_name = $matches[1];

            // extract code block from that function
            // xm=function(a){a=a.split("");wm.zO(a,47);wm.vY(a,1);wm.z9(a,68);wm.zO(a,21);wm.z9(a,34);wm.zO(a,16);wm.z9(a,41);return a.join("")};
            if (preg_match("/{$func_name}=function\([a-z]+\){(.*?)}/", $code, $matches)) {

                $js_code = $matches[1];

                // extract all relevant statements within that block
                // wm.vY(a,1);
                if (preg_match_all('/([a-z0-9]{2})\.([a-z0-9]{2})\([^,]+,(\d+)\)/i', $js_code, $matches) != false) {

                    // must be identical
                    // $obj_list = $matches[1];
                    $func_list = $matches[2];

                    // extract javascript code for each one of those statement functions
                    preg_match_all('/(' . implode('|', $func_list) . '):function(.*?)\}/m', $code, $matches2, PREG_SET_ORDER);
                    $functions = array();

                    // translate each function according to its use
                    foreach ($matches2 as $m) {
                        if (strpos($m[2], 'splice') !== false) {
                            $functions[$m[1]] = 'splice';
                        } else if (strpos($m[2], 'a.length') !== false) {
                            $functions[$m[1]] = 'swap';
                        } else if (strpos($m[2], 'reverse') !== false) {
                            $functions[$m[1]] = 'reverse';
                        }
                    }

                    // FINAL STEP! convert it all to instructions set
                    foreach ($matches[2] as $index => $name) {
                        $instructions[] = array($functions[$name], $matches[3][$index]);
                    }
                }
            }
        }
        return $instructions;
    }

    private function decipherWithInstructions(string $signature, array $instructions): string
    {
        foreach ($instructions as $opt) {

            $command = $opt[0];
            $value = $opt[1];

            if ($command == 'swap') {

                $temp = $signature[0];
                $signature[0] = $signature[$value % strlen($signature)];
                $signature[$value] = $temp;

            } else if ($command == 'splice') {
                $signature = substr($signature, $value);
            } else if ($command == 'reverse') {
                $signature = strrev($signature);
            }
        }
        return trim($signature);
    }
}
