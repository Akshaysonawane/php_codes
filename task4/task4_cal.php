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
		
		// Code to check if delimeter exists as \\[delimeter]\\
		if(substr($this->operands,0,2) == '\\\\' && substr($this->operands,3,2) == '\\\\')
		{
			if($this->operands[2] == '\\')
			{
			    echo "Delemeter can not be '\'";exit;
			}
			else
			{
			    $this->operands = str_replace("\\", "", $this->operands);
				
				// Statement to accept \n as operand separator
				$this->operands = str_replace("\\n", ",", $this->operands);
				
				if($this->operation == 'multiply')
				{
			        $this->getoperandsArray($this->operands[2], 1);
				}
				else
				{
					$this->getoperandsArray($this->operands[2]);
				}
			}
		}
		else
		{
			$this->operands = str_replace("\\n", ",", $this->operands);
			$this->getoperandsArray();
		}
	}
	
	//function to conver argumets(operands) to array 
	public function getoperandsArray($delimeter = ',', $flag=0)
	{
		$this->operands_array = array_map('intval', explode($delimeter, $this->operands));
		if($flag==1)
		{
			$this->operands_array[0] = 1;
		}			
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
$value = $calculate1->calculateValue();
echo $value;


?>