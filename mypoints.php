<?php

class MyPoints
{
	private $IsAllowPoint = true;
	private $ProfitDiscount = 50; // The benefit of points
	private $totalPoint = 100;    // Maximum points to get the benefit
	private $Bonuspoint = 10;     // Bonus point
	private $ValueOrder = 20; // value check total order to performed Point
	
    public function getTotalPoints($db, $usrId)
    {
		$query = "SELECT SUM(countpoints) as totalPoints FROM mypoints WHERE userid = $usrId AND state = 0";
		$row = $db->SelectQuery($query);
        $currentPoints = $row ? (float) $row['totalPoints'] : 0;
		return $currentPoints;
    }

	// Method to check if points are allowed
	public function isAllowPoint()
    {
		return $this->IsAllowPoint;
	}
   // Method to get Bonus point
	public function getBonuspoint()
    {
		return $this->Bonuspoint;
	}
	// Method to get Value Order
	public function getValueOrder()
    {
		return $this->ValueOrder;
	}
	// Method to check the user's points and return a discount if Qualified
	public function chckPoints($db, $usrId)
    {
		$Profit = (float)0;
		$currentPoints = $this->getTotalPoints($db, $usrId);
		if ($currentPoints >= $this->totalPoint)
		{
			$Profit = $this->ProfitDiscount;
		}
	    return $Profit;
	}
}
