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
		$this->operation = $this->cmd[1];
		$this->operands = $this->cmd[2] ?? 0;
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
	
	//function just to perform operation for 0-2 operands
	public function calculateValue()
	{
		if(sizeof($this->operands_array) == 1)
		{
			if(is_numeric($this->operands_array[0]))
			{
				return $this->operands_array[0];
			}
			else
			{
				echo "Enter numric value for calculation";
				exit;
			}
		}
		else
		{
			if(is_numeric($this->operands_array[0]) && is_numeric($this->operands_array[1]))
			{
				if($this->operation == 'sum' || $this->operation == 'add')
				{
					return($this->operands_array[0] + $this->operands_array[1]);
				}
				else{
				   if($this->operation == 'multiply')
				   {
				      return($this->operands_array[0] * $this->operands_array[1]);
				   }
				   else
				   {
					   echo "operation not supported";
					   exit;
				   }
				}				
			}
			else
			{
				echo "Enter numric value for calculation";
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