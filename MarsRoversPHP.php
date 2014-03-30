<html>
	<head>
		<title>MarsRoversPHP!</title>
	</head>
	<body>
	<?php
	/* Kervon Gibson
   	Computer and Information Science (B.S)
   	kervongibson@gmail.com
   
   	PROBLEM:
   	MARS ROVERS
   	A squad of robotic rovers are to be landed by NASA on a plateau on Mars. This plateau, which is
   	curiously rectangular, must be navigated by the rovers so that their on-board cameras can get a
   	complete view of the surrounding terrain to send back to Earth. A rover's position and location
   	is represented by a combination of x and y co-ordinates and a letter representing one of the four
   	cardinal compass points. The plateau is divided up into a grid to simplify navigation. An example
   	position might be 0, 0, N, which means the rover is in the bottom left corner and facing North.
   	In order to control a rover, NASA sends a simple string of letters. The possible letters are 'L',
   	'R' and 'M'. 'L' and 'R' makes the rover spin 90 degrees left or right respectively, without moving
   	from its current spot. 'M' means move forward one grid point, and maintain the same heading. Assume
   	that the square directly North from (x, y) is (x, y+1).

   	INPUT:
   	The first line of input is the upper-right coordinates of the plateau, the lower-left coordinates
   	are assumed to be 0,0. The rest of the input is information pertaining to the rovers that have been
   	deployed. Each rover has two lines of input. The first line gives the rover's position, and the second
   	line is a series of instructions telling the rover how to explore the plateau. The position is made up
   	of two integers and a letter separated by spaces, corresponding to the x and y co-ordinates and the
   	rover's orientation. Each rover will be finished sequentially, which means that the second rover won't
   	start to move until the first one has finished moving.

   	OUTPUT:
   	The output for each rover should be its final co-ordinates and heading.
   
   	INPUT AND OUTPUT
   	Test Input:
   	5 5
   	1 2 N
   	LMLMLMLMM
   	3 3 E
   	MMRMMRMRRM
   
   	Expected Output:
   	1 3 N
   	5 1 E
   	==========

   	SOLUTION
   	MarsRoverPHP.php

   	This program was orinally written in java and was modified for PHP. This program implements Jump 
   	Tables to reduce the number of comparisons made, this is very useful
   	when you have a lot of input data to process. The input is read in from a file.
   	To run this program place "MarsRoversPHP.php" and "Input.txt" in the same location on your site, 
   	where "Input.txt" is the name of your input file. The first line of the input file 
   	is assumed to be two integers separated by a white space. Every two lines following, we will assume
   	the first line of input contains two integers and a character (a direction either a N for North, S 
   	for South, W for West, E for East) and the second line contains a string of instructions (either a M
   	for move forward one, L for turning in place to the Left, R for turning in place to the Right). This
   	program is not case sensitive it accepts 'm', 'l', 'r', 'n', 's', 'w', 'e'.
	*/

	//Plateau class used to create planets
	class Plateau{
		private $xcoordinate;
		private $ycoordinate;

		//Method to set plateau max X co-ordinate
		public function setXCoordinate($coord){
			$this->xcoordinate = $coord;
			return;
		}

		//Method to set plateau max Y co-ordinate
		public function setYCoordinate($coord){
			$this->ycoordinate = $coord;
			return;
		}

		//Method to get plateau  X co-ordinate
		public function getXCoordinate(){
			return $this->xcoordinate;
		}

		//Method to get plateau Y co-ordinate
		public function getYCoordinate(){
			return $this->ycoordinate;
		}
	}

	//Rover class used to create curiosity rovers
	class Rover{
		private $xcoordinate;
		private $ycoordinate;
		private $heading;

		//Method to set rover X co-ordinate
		public function setXCoordinate($coord){
			$this->xcoordinate = $coord;
			return;
		}

		//Method to set rover Y co-ordinate
		public function setYCoordinate($coord){
			$this->ycoordinate = $coord;
			return;
		}

		//Method to set rover heading
		public function setHeading($h){
			$this->heading = $h;
			return;
		}

		//Method to get rover X co-ordinates
		public function getXCoordinate(){
		return $this->xcoordinate;
		}

		//Method to get rover Y co-ordinates
		public function getYCoordinate(){
			return $this->ycoordinate;
		}

		//Method to get rover heading
		public function getHeading(){
			return $this->heading;
		}

		//Print formatted output
		public function printOutput(){
			echo "$this->xcoordinate $this->ycoordinate $this->heading <br>";
			return;
		}
	}

	//Table for instructions the rover can execute
	class InstructionTable{
		const  NORTH = "N";
		const  SOUTH = "S";
		const  WEST = "W";
		const  EAST = "E";
		const  MOVE = "M";
		const  LEFT = "L";
		const  RIGHT = "R";
		private $jumpInstruction = array();
		private $jumpMoveForward = array();
		private $jumpLeftTurn = array();
		private $jumpRightTurn = array();

		public function InstructionTable(){
			$this->initializeTables();
			return;
		}

		//Initialize all Jump Tables 
		public function initializeTables(){
			//set default values of Jump Tables
			//cast int type to get ASCII value of character (0-255). Store appropriate method at
			//that index in the appropriate array
			$this->jumpInstruction[self::MOVE] = "moveFoward";
			$this->jumpInstruction[self::LEFT] = "turnLeft";
			$this->jumpInstruction[self::RIGHT] = "turnRight";
			$this->jumpInstruction[strtolower(self::MOVE)] = "moveFoward";
			$this->jumpInstruction[strtolower(self::LEFT)] = "turnLeft";
			$this->jumpInstruction[strtolower(self::RIGHT)] = "turnRight";
			$this->jumpMoveForward[self::NORTH] = "forwardNorth";
			$this->jumpMoveForward[self::SOUTH] = "forwardSouthth";
			$this->jumpMoveForward[self::WEST] = "forwardWest";
			$this->jumpMoveForward[self::EAST] = "forwardEast";
			$this->jumpMoveForward[strtolower(self::NORTH)] = "forwardNorth";
			$this->jumpMoveForward[strtolower(self::SOUTH)] = "forwardSouthth";
			$this->jumpMoveForward[strtolower(self::WEST)] = "forwardWest";
			$this->jumpMoveForward[strtolower(self::EAST)] = "forwardEast";
			$this->jumpLeftTurn[self::NORTH] = "leftNorth";
			$this->jumpLeftTurn[self::SOUTH] = "leftSouth";
			$this->jumpLeftTurn[self::WEST] = "leftWest";
			$this->jumpLeftTurn[self::EAST] = "leftEast";
			$this->jumpLeftTurn[strtolower(self::NORTH)] = "leftNorth";
			$this->jumpLeftTurn[strtolower(self::SOUTH)] = "leftSouth";
			$this->jumpLeftTurn[strtolower(self::WEST)] = "leftWest";
			$this->jumpLeftTurn[strtolower(self::EAST)] = "leftEast";
			$this->jumpRightTurn[self::NORTH] = "rightNorth";
			$this->jumpRightTurn[self::SOUTH] = "rightSouth";
			$this->jumpRightTurn[self::WEST] = "rightWest";
			$this->jumpRightTurn[self::EAST] = "rightEast";
			$this->jumpRightTurn[strtolower(self::NORTH)] = "rightNorth";
			$this->jumpRightTurn[strtolower(self::SOUTH)] = "rightSouth";
			$this->jumpRightTurn[strtolower(self::WEST)] = "rightWest";
			$this->jumpRightTurn[strtolower(self::EAST)] = "rightEast";
			return;
		}

		//Return the appropriate instruction
		public function doInstruction($instruction, $curiosity, $mars){
			call_user_func('self::' . $this->jumpInstruction[$instruction], $curiosity, $mars);
			return;
		}

		//If input is a 'M' or 'm' call appropriate move instruction method
		public function moveFoward($curiosity, $mars){
			call_user_func('self::' . $this->jumpMoveForward[$curiosity->getHeading()], $curiosity, $mars);
			return;
		}

		//If input is a 'L' or 'l' call appropriate instruction method
		public function turnLeft($curiosity, $mars){
			call_user_func('self::' . $this->jumpLeftTurn[$curiosity->getHeading()], $curiosity);
			return;
		}

		//If input is a 'R' or 'r' call appropriate instruction method
		public function turnRight($curiosity, $mars){
			call_user_func('self::' . $this->jumpRightTurn[$curiosity->getHeading()], $curiosity);
			return;
		}

		//If heading is 'N' or 'n' and the rover is not at top edge, move forward one
		public function forwardNorth($curiosity, $mars){
			if($curiosity->getYCoordinate() < $mars->getYCoordinate())
				$curiosity->setYCoordinate($curiosity->getYCoordinate()+1);
			return;
		}

		//If heading is 'S' or 's' and the rover is not at bottom edge, move forward one
		public function forwardSouthth($curiosity, $mars){
			if($curiosity->getYCoordinate() > 0)
				$curiosity->setYCoordinate($curiosity->getYCoordinate()-1);
			return;
		}

		//If heading is 'W' or 'w' and the rover is not at left edge, move forward one
		public function forwardWest($curiosity, $mars){
			if($curiosity->getXCoordinate() > 0)
				$curiosity->setXCoordinate($curiosity->getXCoordinate()-1);
			return;
		}

		//If heading is 'E' or 'e' and the rover is not at right edge, move forward one
		public function forwardEast($curiosity, $mars){
			if($curiosity->getXCoordinate() < $mars->getXCoordinate())
				$curiosity->setXCoordinate($curiosity->getXCoordinate()+1);
			return;
		}

		//If heading is 'N' or 'n', turn West(W)
		public function leftNorth($curiosity){
			$curiosity->setHeading(self::WEST);
			return;
		}

		//If heading is 'S' or 's', turn East(E)
		public function leftSouth($curiosity){
			$curiosity->setHeading(self::EAST);
			return;
		}

		//If heading is 'W' or 'w', turn South(S)
		public function leftWest($curiosity){
			$curiosity->setHeading(self::SOUTH);
			return;
		}

		//If heading is 'E' or 'e', turn North(N)
		public function leftEast($curiosity){
			$curiosity->setHeading(self::NORTH);
			return;
		}

		//If heading is 'N' or 'n', turn East(E)
		public function rightNorth($curiosity){
			$curiosity->setHeading(self::EAST);
			return;
		}

		//If heading is 'S' or 's', turn West(W)
		public function rightSouth($curiosity){
			$curiosity->setHeading(self::WEST);
			return;
		}

		//If heading is 'W' or 'w', turn North(N)
		public function rightWest($curiosity){
			$curiosity->setHeading(self::NORTH);
			return;
		}

		//If heading is 'E' or 'e', turn South(S)
		public function rightEast($curiosity){
			$curiosity->setHeading(self::SOUTH);
			return;
		}

	} 

	class Mission{
		//A Plateau
		private $mars;
		//A Rover
		private $curiosity;
		//Intreuctions Jump Table
		private $orders;

		//Recursively executes Instructions
		protected function executeInstructions($instructions, $count){
			if($count >= strlen($instructions))
				return;
			//Translate instruction usng the Jump Table and execute it
			//cast int type to get ASCII value of character (0-255) in string instructions
			//$this->orders->getInstruction($instructions[$count])->doInsrtuction($this->curiosity, $this->mars);
			$this->orders->doInstruction($instructions[$count], $this->curiosity, $this->mars);
			$this->executeInstructions($instructions, $count + 1);
		}

		//Read in Plateau Co-ordinates from a file
		protected function readPlateau($handle){
			//Read Plateau X and Y Co-ordinates
			if($input = fscanf($handle, "%s\t%s\n")) {
    			list ($marsx, $marsy) = $input;
    			//Set Plateau X Co-ordinates
        		$this->mars->setXCoordinate($marsx);
				//Set Plateau Y Co-ordinates
        		$this->mars->setYCoordinate($marsy);
        	}
        	return; 
		}
	
		//Read in Rover Co-ordinates, heading and instructions from a file
		protected function readRovers($handle){
			//Read Rover X and Y Co-ordinates and Heading
			if($input = fscanf($handle, "%s\t%s\t%s\n")) {
    			list ($roverx, $rovery, $roverh) = $input;
    			//Set Rover X Co-ordinates
				$this->curiosity->setXCoordinate($roverx);
    			//Set Rover Y Co-ordinates				
				$this->curiosity->setYCoordinate($rovery);
    			//Set Rover Heading				
				$this->curiosity->setHeading($roverh);
			}
			//Read Rover Instructions
			if($input = fscanf($handle, "%s\n")) {
    			list ($instructions) = $input;
    			//Execute Instructions
				$this->executeInstructions($instructions, 0);
				//Print Rover X and Y Co-ordinates and Heading
				$this->curiosity->printOutput();
				//Read next Rover
				$this->readRovers($handle);
			}
			return;
		}

		//Main Mission
		public function Mission(){
			$handle = fopen("Input.txt", "r");
			if($handle){
				//create Plateau
				$this->mars = new Plateau;
				//Create a Rover
				$this->curiosity = new Rover;
				//Create Intreuctions Jump Table
				$this->orders = new InstructionTable();
				//Read Plateau 
				$this->readPlateau($handle);
				//Read Rover
				$this->readRovers($handle);
				//Mission Over
				echo "========== <br>";
        	}
        	fclose($handle);
			return;
		}
	}
	?><br>
	<?php $marsMission = new Mission(); ?><br>
	</body>
</html>