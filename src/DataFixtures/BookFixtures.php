<?php
/** @noinspection PhpParamsInspection */

namespace App\DataFixtures;

use App\Entity\Book;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class BookFixtures extends Fixture implements DependentFixtureInterface
{
    /** @var ObjectManager */
    private $objectManager;

    /**
     * @param ObjectManager $manager
     * @throws \Exception
     */
    public function load(ObjectManager $manager)
    {
        $this->objectManager = $manager;
        $this->addBook(
            'Domain Driven Design',
            '2020-09-01',
            AuthorFixtures::EVANS
        );
        $this->addBook(
            'The Art of Computer Programming',
            '2020-09-01',
            AuthorFixtures::KNUTH
        );
        $this->addBook(
            'The TeXbook',
            '2020-08-22',
            AuthorFixtures::KNUTH
        );

        $manager->flush();
    }

    /**
     * @param string $title
     * @param string $language
     * @param string $uploadDate
     * @param string $authorReference
     * @return Book
     * @throws \Exception
     */
    private function addBook(string $title, string $uploadDate, string $authorReference, string $language = 'en'): Book
    {
        $book = new Book();
        $book->setTitle($title)
            ->setLanguage($language)
            ->setAuthor($this->getReference($authorReference));
        $this->objectManager->persist($book);
        $book->setUploadDate(new \DateTime($uploadDate));
        $this->objectManager->persist($book);
        return $book;
    }

    /**
     * This method must return an array of fixtures classes
     * on which the implementing class depends on
     *
     * @return class-string[]
     */
    public function getDependencies()
    {
        return [AuthorFixtures::class];
    }
}
