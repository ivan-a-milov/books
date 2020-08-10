<?php

namespace App\Services\Application;


use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Query\ResultSetMapping;

class SQLSummary implements Summary
{
    /** @var EntityManagerInterface  */
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function count(): array
    {
        $booksByAuthor = $this->booksByAuthor();
        return [
            'booksByAuthor' => $booksByAuthor,
            'booklessAuthors' => $this->booklessAuthors($booksByAuthor),
            'booksByDay' => $this->booksByDay(),
        ];
    }

    private function booksByAuthor(): array
    {
        $sql = <<<SQL
select a.name, count(b.id) as books_count
from author a 
left join book b on b.author_id = a.id 
group by a.id;
SQL;
        $rsm = new ResultSetMapping();
        $rsm->addScalarResult('name', 'name');
        $rsm->addScalarResult('books_count', 'books_count');
        $query = $this->entityManager->createNativeQuery($sql, $rsm);
        $result = $query->getResult();
        return $result;
    }

    private function booklessAuthors(array $booksByAuthor): array
    {
        // SQL для этого нужен вот такой:
        //
        //    select a.name
        //    from author a
        //    left join book b on b.author_id = a.id
        //    group by a.id having count(b.id)=0;
        //
        // Но зачем делать два запроса, когда можно обойтись одним?
        // Так что поступим вот так:

        $result = array_filter($booksByAuthor, function ($r) { return $r['books_count'] == 0; });
        $result = array_map(function ($r) { return $r['name']; }, $result);
        $result = array_values($result);
        return $result;
    }

    private function booksByDay(): array
    {
        $sql = <<<SQL
select b.upload_date, count(b.id) as books_count 
from book b 
group by upload_date;
SQL;
        $rsm = new ResultSetMapping();
        $rsm->addScalarResult('upload_date', 'date');
        $rsm->addScalarResult('books_count', 'books_count');
        $query = $this->entityManager->createNativeQuery($sql, $rsm);
        $result = $query->getResult();
        return $result;
    }
}
