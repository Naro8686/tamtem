<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class MetaTag extends Model
{
    protected $table = 'meta_tags';
    protected $fillable
        = [
            'title', 'page_slug', 'description', 'keywords', 'updated_at'
        ];

    public static function allWithCategories(): \Illuminate\Support\Collection
    {
        $all = collect([]);

        $metaTags = self::all();
        foreach ($metaTags as $metaTag) {
            $all[] = new self([
                'page_slug'   => $metaTag->page_slug,
                'title'       => $metaTag->title,
                'description' => $metaTag->description,
                'keywords'    => $metaTag->keywords,
                'updated_at'  => $metaTag->updated_at
            ]);
        }

        $categories = Category::all();
        foreach ($categories as $category) {
            foreach (['sales', 'bids'] as $firstSlug) {
                $slug = $category->parent_slug
                    ? "$firstSlug/{$category->parent_slug}/{$category->slug}"
                    : "$firstSlug/{$category->slug}";
                $all[] = new self([
                    'page_slug'   => $slug,
                    'title'       => $category->title,
                    'description' => $category->description,
                    'keywords'    => null,
                    'updated_at'  => new Carbon(today()->subMonth()
                        ->toDateTimeString())
                ]);
            }
        }
        return $all;
    }
}
