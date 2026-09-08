<?php

namespace App\Console\Commands;

use App\Models\BlogPost;
use App\Models\Course;
use App\Models\Lesson;
use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Url;

#[Signature('sitemap:generate')]
#[Description('Generate the sitemap')]
class GenerateSitemap extends Command
{
    public function handle(): void
    {
        $siteUrl = rtrim((string) config('seo.url'), '/');

        $sitemap = Sitemap::create();

        $sitemap->add(Url::create($siteUrl.'/')->setPriority(1.0)->setChangeFrequency('weekly'));
        $sitemap->add(Url::create($siteUrl.'/enfants')->setPriority(0.9)->setChangeFrequency('weekly'));
        $sitemap->add(Url::create($siteUrl.'/adultes')->setPriority(0.9)->setChangeFrequency('weekly'));
        $sitemap->add(Url::create($siteUrl.'/price')->setPriority(0.8)->setChangeFrequency('monthly'));
        $sitemap->add(Url::create($siteUrl.'/blog')->setPriority(0.7)->setChangeFrequency('daily'));

        Course::where('is_active', true)->get()->each(function (Course $course) use ($sitemap, $siteUrl): void {
            $sitemap->add(
                Url::create($siteUrl."/cours/{$course->slug}")
                    ->setPriority(0.8)
                    ->setChangeFrequency('monthly')
                    ->setLastModificationDate($course->updated_at)
            );
        });

        BlogPost::published()->latest('published_at')->get()->each(function (BlogPost $post) use ($sitemap, $siteUrl): void {
            $sitemap->add(
                Url::create($siteUrl."/blog/{$post->slug}")
                    ->setPriority(0.6)
                    ->setChangeFrequency('monthly')
                    ->setLastModificationDate($post->updated_at)
            );
        });

        Lesson::where('is_active', true)->latest()->get()->each(function (Lesson $lesson) use ($sitemap, $siteUrl): void {
            $sitemap->add(
                Url::create($siteUrl."/lecons-gratuites/{$lesson->slug}")
                    ->setPriority(0.5)
                    ->setChangeFrequency('monthly')
                    ->setLastModificationDate($lesson->updated_at)
            );
        });

        $sitemap->writeToFile(public_path('sitemap.xml'));
        $this->info('Sitemap generated successfully!');
    }
}
