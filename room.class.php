<?php
	class Room
	{
		public $id = "";
		public $name = "";
		public $num_students = "";
		public $has_pc = "";
		public $has_projector = "";

		public function __construct($id="", $name = "", $num_students = "", $has_pc = "N", $has_projector = "N") {

			$this->id = $id;
			$this->name = $name;
			$this->num_students = $num_students;
			$this->has_pc = $has_pc;
			$this->has_projector = $has_projector;
		}
	}
?>