<?php echo '<?xml version="1.0" encoding="UTF-8"?>'; ?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    <url>
        <loc>https://commandpost.dev/</loc>
        <lastmod>2022-03-01T06:05:08Z</lastmod>
        <changefreq>daily</changefreq>
        <priority>0.6</priority>
    </url>
    <url>
        <loc>https://commandpost.dev/login</loc>
        <lastmod>2022-03-01T06:05:08Z</lastmod>
        <changefreq>daily</changefreq>
        <priority>0.6</priority>
    </url>
    <url>
        <loc>https://commandpost.dev/register</loc>
        <lastmod>2022-03-01T06:05:08Z</lastmod>
        <changefreq>daily</changefreq>
        <priority>0.6</priority>
    </url>
    <url>
        <loc>https://commandpost.dev/contact</loc>
        <lastmod>2022-03-01T06:05:08Z</lastmod>
        <changefreq>daily</changefreq>
        <priority>0.6</priority>
    </url>
    @foreach ($collections as $collection)
    <url>
        <loc>https://commandpost.dev/view/{{$collection->encrypted_id}}</loc>
        <lastmod>{{ gmdate('Y-m-d\TH:i:s\Z',strtotime($collection->created_at)) }}</lastmod>
        <changefreq>daily</changefreq>
        <priority>0.6</priority>
    </url>
    @endforeach
</urlset>
