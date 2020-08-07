<?php

namespace App\Command;

use App\DTO\Request\AddBookRequest;
use App\Exception\BaseException;
use App\Services\Application\AddBook;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class BooksAddCommand extends Command
{
    /** @var string  */
    protected static $defaultName = 'books:add';

    /** @var AddBook  */
    private $addBookService;

    public function __construct(AddBook $addBookService)
    {
        parent::__construct(self::$defaultName);
        $this->addBookService = $addBookService;

    }

    protected function configure()
    {
        $this
            ->setDescription('Add book to database')
            ->addArgument('path', InputArgument::REQUIRED, 'Path to file')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $path = $input->getArgument('path');

        $exitCode = 0;
        try {
            if (!is_file($path)) {
                throw new BaseException(sprintf("no such file %s", $path));
            }
            $addBookRequest = new AddBookRequest(file_get_contents($path));
            $this->addBookService->execute($addBookRequest);
            $io->success(sprintf('File %s is added to database', $path));
        } catch (BaseException $e) {
            $io->error($e->getMessage());
            $exitCode = 1;
        }
        return $exitCode;
    }
}
