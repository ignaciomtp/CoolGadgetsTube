<?php echo '<?xml version="1.0" encoding="UTF-8"?>'; ?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    <url>
        <loc>{{ url('/') }}</loc>
        <changefreq>weekly</changefreq>
        <priority>1.0</priority>
    </url>

    <url>
        <loc>{{ url('/random') }}</loc>
        <changefreq>weekly</changefreq>
        <priority>0.7</priority>
    </url>

    <url>
        <loc>{{ url('/most-popular') }}</loc>
        <changefreq>weekly</changefreq>
        <priority>0.7</priority>
    </url>

    @foreach($categories as $cat)
        <url>
            <loc>{{ url($cat->slug) }}</loc>
            <lastmod>{{ gmdate('Y-m-d\TH:i:s\Z',strtotime($cat->updated_at)) }}</lastmod>
            <changefreq>weekly</changefreq>
            <priority>0.9</priority>
        </url>
    @endforeach


    @foreach ($posts as $post)
        <url>
            <loc>{{ url('/blog/'.$post->slug) }}</loc>
            <lastmod>{{ gmdate('Y-m-d\TH:i:s\Z',strtotime($post->updated_at)) }}</lastmod>
            <changefreq>weekly</changefreq>
            <priority>0.9</priority>
        </url>
    @endforeach

    @foreach($products as $prod)
        <url>
            <loc>{{ url('/p/'.$prod->slug) }}</loc>
            <lastmod>{{ gmdate('Y-m-d\TH:i:s\Z',strtotime($prod->updated_at)) }}</lastmod>
            <changefreq>weekly</changefreq>
            <priority>0.8</priority>
        </url>
    @endforeach

</urlset>