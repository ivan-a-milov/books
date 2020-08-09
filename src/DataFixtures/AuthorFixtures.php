<?php

namespace App\DataFixtures;

use App\Entity\Author;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AuthorFixtures extends Fixture
{
    public const EVANS = 'author-evans';
    public const KNUTH = 'author-knuth';

    public function load(ObjectManager $manager)
    {
        $ericEvans = new Author();
        $ericEvans->setName('Eric Evans');
        $manager->persist($ericEvans);
        $this->addReference(self::EVANS, $ericEvans);

        $pupkin = new Author();
        $pupkin->setName('Василий Пупкин');
        $manager->persist($pupkin);

        $knuth = new Author();
        $knuth->setName('Donald Knuth');
        $manager->persist($knuth);
        $this->addReference(self::KNUTH, $knuth);

        $manager->flush();
    }
}
