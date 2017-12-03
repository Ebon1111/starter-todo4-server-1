<?php

  if (! class_exists('PHPUnit_Framework_TestCase'))
  {
      class_alias('PHPUnit\Framework\TestCase', 'PHPUnit_Framework_TestCase');
  }
  
  class TaskTest extends PHPUnit_Framework_TestCase
  {
    // private $task;
    public function setUp()
    {
      // Load CI instance normally
      $this->task = new Task();
    }

    // TaskName Tests
    public function testSetTaskValid()
    {
      $taskName = "Valid Task Name 1";
      $this->task->taskName = $taskName;
      $this->assertEquals($taskName, $this->task->taskName);
    }

    public function testSetTaskInvalidChar()
    {
      $taskName = "Invalid Task Name !";
      $this->task->taskName = $taskName;
      $this->assertNotEquals($taskName, $this->task->taskName);
    }

    public function testSetTaskInvalidLen()
    {
      $taskName = "Invalid Task Name !stbhtebhetrghawrtg34wefg24r2gaerg34y34t44t24t134tgfret34rshnyujatj";
      $this->task->taskName = $taskName;
      $this->assertNotEquals($taskName, $this->task->taskName);
    }

    // Priority Tests
    public function testSetPriorityValid()
    {
      $priority = "1";
      $this->task->priority = $priority;
      $this->assertEquals($priority, $this->task->priority);
    }

    public function testSetPriorityInvalidChar()
    {
      $priority = "!";
      $this->task->priority = $priority;
      $this->assertNotEquals($priority, $this->task->priority);
    }

    public function testSetPriorityInvalidLen()
    {
      $priority = "12345";
      $this->task->priority = $priority;
      $this->assertNotEquals($priority, $this->task->priority);
    }

    // Size Tests 
    public function testSetSizeValid()
    {
      $size = "1";
      $this->task->size = $size;
      $this->assertEquals($size, $this->task->size);
    }

    public function testSetSizeInvalidChar()
    {
      $size = "!!!!";
      $this->task->size = $size;
      $this->assertNotEquals($size, $this->task->size);
    }

    public function testSetSizeInvalidLen()
    {
      $size = "4321";
      $this->task->size = $size;
      $this->assertNotEquals($size, $this->task->size);
    }

    // Group Tests
    public function testSetGroupValid()
    {
      $group = "1";
      $this->task->group = $group;
      $this->assertEquals($group, $this->task->group);
    }

    public function testSetGroupInvalidChar()
    {
      $group = "!!!!";
      $this->task->group = $group;
      $this->assertNotEquals($group, $this->task->group);
    }

    public function testSetGroupInvalidLen()
    {
      $group = "2397571";
      $this->task->group = $group;
      $this->assertNotEquals($group, $this->task->group);
    }

  }