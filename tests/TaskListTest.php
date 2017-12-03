<?php 
	if (! class_exists('PHPUnit_Framework_TestCase')) {
	    class_alias('PHPUnit\Framework\TestCase', 'PHPUnit_Framework_TestCase');
	}

	class TaskListTest extends PHPUnit_Framework_TestCase {
		public function testUncompletedTasks() {
			$tasks = new Tasks();
			$this->tasklist = $tasks->all();
			foreach ($this->tasklist as $task)
		    {
		        if ($task->status != 2)
		            $undone[] = $task;
		    }

		    $this->assertGreaterThan(count($this->tasklist), count($undone));
		}
	}