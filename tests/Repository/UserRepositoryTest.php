<?php

namespace ProgrammerZamanNow\MVC\Repository;

use PHPUnit\Framework\TestCase;
use ProgrammerZamanNow\MVC\Config\Database;
use ProgrammerZamanNow\MVC\Repository\UserRepository;
use ProgrammerZamanNow\MVC\Domain\User;

class UserRepositoryTest extends TestCase
{
    private UserRepository $userRepository;
    private SessionRepository $sessionRepository;

    public function setUp(): void
    {
        $this->sessionRepository = new SessionRepository(Database::getConnection());
        $this->sessionRepository->deleteAll();

        $this->userRepository = new UserRepository(Database::getConnection());
        $this->userRepository->deleteAll();
    }

    public function testSaveSuccess()
    {
        $user = new User();
        $user->id = "imam";
        $user->name = "Imam";
        $user->password = password_hash("12345", PASSWORD_BCRYPT);

        $this->userRepository->save($user);

        $result = $this->userRepository->findById($user->id);

        $this->assertEquals($user->id, $result->id);
        $this->assertEquals($user->name, $result->name);
        $this->assertEquals($user->password, $result->password);
    }

    public function testFindByIdNotFound()
    {
        $user = $this->userRepository->findById(100);
        $this->assertNull($user);
    }

    public function testUpdate()
    {
        $user = new User();
        $user->id = "imam";
        $user->name = "Imam";
        $user->password = password_hash("12345", PASSWORD_BCRYPT);
        $this->userRepository->save($user);

        $user->name = "Imam Setiawan";
        $this->userRepository->update($user);

        $result = $this->userRepository->findById($user->id);

        $this->assertEquals($user->id, $result->id);
        $this->assertEquals($user->name, $result->name);
        $this->assertEquals($user->password, $result->password);
    }
}