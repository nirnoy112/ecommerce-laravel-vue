<?php echo '<?xml version="1.0" encoding="UTF-8"?>'; ?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    <url>
        <loc>{{ route('about_us') }}</loc>
        <changefreq>weekly</changefreq>
        <priority>1</priority>
    </url>

    <url>
        <loc>{{ route('contact_us') }}</loc>
        <changefreq>weekly</changefreq>
        <priority>1</priority>
    </url>

    <url>
        <loc>{{ route('size_guide') }}</loc>
        <changefreq>weekly</changefreq>
        <priority>1</priority>
    </url>

    <url>
        <loc>{{ route('privacy_policy') }}</loc>
        <changefreq>weekly</changefreq>
        <priority>1</priority>
    </url>

    <url>
        <loc>{{ route('terms_conditions') }}</loc>
        <changefreq>weekly</changefreq>
        <priority>1</priority>
    </url>
</urlset>