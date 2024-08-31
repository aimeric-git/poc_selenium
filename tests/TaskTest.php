<?php 

namespace App\Tests;

use App\Entity\Task;
use PHPUnit\Framework\TestCase;

class TaskTest extends TestCase
{
    public function testTitle()
    {
        $task = new Task();
        $task->setTitle('test task 1');
        $this->assertEquals('test task 1', $task->getTitle());
    }

    public function testDescription()
    {
        $task = new Task();
        $task->setDescription('test Description 1');
        $this->assertEquals('test Description 1', $task->getDescription());
    }

    public function testCreatedAt()
    {
        $task = new Task();
        $currentDateTime = new \DateTime();
        $task->setCreatedAt($currentDateTime);
        $this->assertInstanceOf(\DateTime::class, $task->getCreatedAt());
        $this->assertEquals($currentDateTime, $task->getCreatedAt());
    }
}