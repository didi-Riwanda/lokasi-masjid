<?php

namespace App\Support;

use Illuminate\Support\Str as BaseStr;

class Str extends BaseStr {
    public static function closetags($html) {
        // preg_match_all('#<([a-z]+)(?: .*)?(?<![/|/ ])>#iU', $html, $result);
        // $openedtags = $result[1];
        // preg_match_all('#</([a-z]+)>#iU', $html, $result);

        // $closedtags = $result[1];
        // $len_opened = count($openedtags);

        // if (count($closedtags) == $len_opened) {
        //     return $html;
        // }
        // $openedtags = array_reverse($openedtags);
        // for ($i=0; $i < $len_opened; $i++) {
        //     if (!in_array($openedtags[$i], $closedtags)) {
        //         $html .= '</'.$openedtags[$i].'>';
        //     } else {
        //         unset($closedtags[array_search($openedtags[$i], $closedtags)]);
        //     }
        // }
        // return $html;
        libxml_use_internal_errors(true);

        $dom = new \DOMDocument;
        $dom->loadHTML($html);

        // Strip wrapping <html> and <body> tags
        $mock = new \DOMDocument;
        $body = $dom->getElementsByTagName('body')->item(0);
        foreach ($body->childNodes as $child) {
            $mock->appendChild($mock->importNode($child, true));
        }

        return trim($mock->saveHTML());
    }
}
