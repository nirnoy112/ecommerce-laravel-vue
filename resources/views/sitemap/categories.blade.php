<?php echo '<?xml version="1.0" encoding="UTF-8"?>'; ?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    @foreach ($categories as $category)
        <url>
            <loc>{{ route('vendor_or_parent_category', ['text' => changeSpecialChar($category->slug)]) }}</loc>
            <lastmod>{{ $category->updated_at->tz('UTC')->toAtomString() }}</lastmod>
            <changefreq>monthly</changefreq>
            <priority>0.6</priority>
        </url>

        @if (sizeof($category->subCategories) > 0)
            @foreach ($category->subCategories as $sub)
                <url>
                    <loc>{{ route('category_page', ['child' => changeSpecialChar($sub->slug), 'parent' => changeSpecialChar($category->slug)]) }}</loc>
                    <lastmod>{{ $sub->updated_at->tz('UTC')->toAtomString() }}</lastmod>
                    <changefreq>monthly</changefreq>
                    <priority>0.6</priority>
                </url>
            @endforeach
        @endif
    @endforeach
</urlset>