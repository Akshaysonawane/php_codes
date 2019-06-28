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
				$this->operands = str_replace("\\n", ",", $this->operands);
				if($this->operation == 'multiply')
				{
			        $this->getoperandsArray($this->operands[2], 1);
				}
				else
				{
					$this->getoperandsArray($this->operands[2]);
				}
			   //$this->operands = str_replace("\\", "0", $this->operands);
			}
		}
		else
		{
			$this->operands = str_replace("\\n", ",", $this->operands);
			$this->getoperandsArray();
		}
	}
	
	
	//function to conver argumets(operands) to array based on delimeter
	public function getoperandsArray($delimeter = ',', $flag=0)
	{
		$this->operands_array = array_map('intval', explode($delimeter, $this->operands));
		if($flag==1)
		{
			$this->operands_array[0] = 1;
		}		

		//code to to check if any negative numbers exists and print negative values in message and remove values greater than 1000
		for($i=0; $i < sizeof($this->operands_array); $i++)
		{
			if($this->operands_array[$i] < 0)
			{
				$negativeArr[] = $this->operands_array[$i];
			}
			else
			{				
				if($this->operands_array[$i] > 1000)
				{
					if($this->operation == 'multiply')
					{
						$this->operands_array[$i] = 1;
					}
					else
					{
						if($this->operation == 'sum' || $this->operation == 'add')
						{
							$this->operands_array[$i] = 0;
						}
					}
				}
			}
		}
		
		if(min($this->operands_array) < 0)
		{
			$negativeNumbers = implode(",",$negativeArr); 
			echo "Negative Numbers (".$negativeNumbers.") not allowed.";exit;
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