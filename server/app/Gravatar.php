<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Gravatar extends Model
{

    /**
     * Get either a Gravatar URL or complete image tag for a specified email address.
     *
     * @param string $email The email address
     * @param string $s Size in pixels, defaults to 80px [ 1 - 2048 ]
     * @param string $d Default imageset to use [ 404 | mp | identicon | monsterid | wavatar ]
     * @param string $r Maximum rating (inclusive) [ g | pg | r | x ]
     * @param boole $img True to return a complete IMG tag False for just the URL
     * @param array $atts Optional, additional key/value attributes to include in the IMG tag
     * @return String containing either just a URL or a complete image tag
     * @source https://gravatar.com/site/implement/images/php/
     * 
     * adapted from: https://en.gravatar.com/site/implement/images/php/
     * should return a string
     * example: https://www.gravatar.com/avatar/8782feacb73d12f97b5507b0fead8fb8?s=400&d=identicon&r=g
     */
    public static function getGravatar(string $email): string {
        $email = (string) $email;
        $sizePixels = (int) 400; // [ 1 - 2048 ]
        $defaultImageset = (string) 'identicon'; // [ 404 | mp | identicon | monsterid | wavatar ]
        $rating = (string) 'g'; // [ g | pg | r | x ]

        $url = 'https://www.gravatar.com/avatar/';
        $url .= md5( strtolower( trim( $email ) ) );
        $url .= "?s=$sizePixels&d=$defaultImageset&r=$rating";
        
        return $url;
    }

}