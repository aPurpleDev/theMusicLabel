<?php

namespace App\DataFixtures;

use App\Entity\Album;
use App\Entity\Artist;
use App\Entity\Event;
use App\Entity\News;
use App\Entity\User;
use App\Entity\Track;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker;

class DataFixtures extends Fixture //use Faker to populate our database with 100 Artists, 1000 Albums, 10 000 Tracks, 500 Events and 250 News
{

    /**
     * DataFixtures constructor.
     */
    public function __construct()
    {
    }

    public function load(ObjectManager $manager)
    {
        $faker = Faker\Factory::create();

        $artistArray = [];
        $albumArray = [];

        for ($i = 0; $i < 100; $i++) {

            $user = new User();
            $user->setEmail($faker->email());
            $user->setPassword($faker->realText(10));
            $user->setRoles(['ROLE_USER']);
            $user->setFirstName($faker->firstName($gender = null));
            $user->setLastName($faker->lastName());

            $manager->persist($user);
            $manager->flush();
        }

        for ($i = 0; $i < 100; $i++) {
            $artist = new Artist();
            $artist->setName($faker->firstName($gender = null));

            $style = ['POP', 'HIP-HOP', 'COUNTRY', 'HOUSE', 'RNB', 'KPOP', 'CLASSICAL', 'ROCK', 'METAL', 'ALTERNATIVE'];
            $artist->setStyle($faker->randomElement($style));
            $artist->setCountry($faker->country());
            $artist->setBio($faker->realText($maxNbChars = 200, $indexSize = 2));

            $manager->persist($artist);
            $artistArray[] = $artist;

            $manager->flush();
        }

        for ($i = 0; $i < 1000; $i++) {
            $album = new Album();
            $randomer = rand(1, 99);

            $album->setPrice(rand(1, 100));
            $album->setReleaseDate($faker->dateTimeBetween('-80 years', ',now'));
            $album->setTitle($faker->name('null'));
            $album->setArtist($artistArray[$randomer]);

            $manager->persist($album);
            $albumArray[] = $album;

            $manager->flush();
        }

        for ($i = 0; $i < 10000; $i++) {
            $track = new Track();
            $randomer = rand(1, 999);

            $track->setTitle($faker->word());
            $track->setAlbum($albumArray[$randomer]);

            $manager->persist($track);
            $albumArray = null;
        }

        for ($i = 0; $i < 500; $i++) {
            $event = new Event();
            $randomer = rand(1, 99);

            $event->setArtist($artistArray[$randomer]);
            $event->setPrice(rand(10, 999));
            $event->setName($faker->realText('50'));
            $event->setStartDate($faker->dateTimeBetween('now', '+2 years'));
            $event->setEndDate($faker->dateTime($event->getStartDate()->add(date_interval_create_from_date_string('5 days'))));
            $event->setCity($faker->city());

            $manager->persist($event);

            $manager->flush();
        }

        for ($i = 0; $i < 250; $i++) {
            $news = new News();
            $randomer = rand(1, 99);

            $news->setTitle($faker->name('null'));
            $news->setContent($faker->realText(200));
            $news->setPublishDate($faker->dateTimeBetween('-2 years', 'now'));
            $news->setArtist($artistArray[$randomer]);

            $manager->persist($news);
            $manager->flush();
        }

        $artistArray = null;
        $albumArray = null;
    }

}