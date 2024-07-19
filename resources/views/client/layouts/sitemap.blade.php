{!! '<?xml version="1.0" encoding="UTF-8"?>' !!}

<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
        xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd">
    @foreach ($pages as $page)
        <url>
            <loc>{{url($page->page_slug)}}</loc>
            <lastmod>{{$page->updated_at->tz('UTC')->toAtomString()}}</lastmod>
            <changefreq>weekly</changefreq>
            <priority>1.0</priority>
        </url>
    @endforeach
</urlset>