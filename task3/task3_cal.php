<?php

abstract class BaseCalculator
{
	protected $cmd;
	protected $operation;
	protected $operands;
	protected $operands_array;
	
	public function __construct($argv, $argc)
	{
		$this->cmd = $argv;
	}
	
	//function to separate operation and operands
	public function getOperationandoperands()
	{
		if(isset($this->cmd[1]))
		{
		    $this->operation = $this->cmd[1];
		}
		else
		{
			echo "No operation mentioned";exit;
		}
		$this->operands = $this->cmd[2] ?? 0;
		
		// Statement to accept \n as operand separator
		$this->operands = str_replace("\\n", ",", $this->operands);
	}
	
	//function to conver argumets(operands) to array 
	public function getoperandsArray()
	{
		$this->operands_array = array_map('intval', explode(',', $this->operands));
	}
}

class Calculate extends BaseCalculator
{
	public function __construct($argv, $argc)
	{
		parent::__construct($argv, $argc);
	}
	
	//function to perform operation on any number of operands using predefined array functions
	public function calculateValue()
	{
	    if($this->operation == 'sum' || $this->operation == 'add')
		{
			return(array_sum($this->operands_array));
		}
		else
		{
			if($this->operation == 'multiply')
			{
				return(array_product($this->operands_array));
			}
			else
			{
				echo "operation not supported";
				exit;
			}
		}				
	}
}

$calculate1 = new Calculate($argv, $argc);
$calculate1->getOperationandoperands();
$calculate1->getoperandsArray();
$value = $calculate1->calculateValue();
echo $value;


?>