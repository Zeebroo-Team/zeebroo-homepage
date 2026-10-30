<?php

namespace App\Services;

/**
 * Safety net for docs HTML written in the admin: removes scripts, embedded frames,
 * inline event handlers (onclick=…) and javascript: links, and leaves every other tag,
 * class and attribute exactly as written so the docs components keep their markup.
 * Docs editing is limited to trusted roles; this is not a general-purpose HTML purifier.
 */
class DocHtmlSanitizer
{
    public function clean(?string $html): ?string
    {
        if ($html === null || trim($html) === '') {
            return null;
        }

        $html = preg_replace('#<(script|iframe|object|embed|style)\b[^>]*>.*?</\1\s*>#is', '', $html);
        $html = preg_replace('#<(script|iframe|object|embed|style|base|meta|link)\b[^>]*/?>#i', '', $html);
        $html = preg_replace('#\s+on[a-z]+\s*=\s*("[^"]*"|\'[^\']*\'|[^\s>]+)#i', '', $html);
        $html = preg_replace('#\b(href|src|action|formaction|xlink:href)\s*=\s*(["\']?)\s*(javascript|vbscript|data:text/html):[^"\'>\s]*\2#i', '$1="#"', $html);

        return trim((string) $html);
    }
}
