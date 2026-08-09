<?php

namespace App\Support;

class FooterCredit
{
    public static function render(): string
    {
        return '
        <span class="developer-credit">
            | Website by
            <a href="https://rajangupta.com/" 
               target="_blank"
               rel="noopener external"
               title="Freelance WordPress Developer Rajan Gupta" style="color:var(--textColor)">
                Rajan Gupta.
            </a>
        </span>';
    }
}