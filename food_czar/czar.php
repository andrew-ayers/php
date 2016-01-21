<?php

class czar
{
	private $all_food_places;
	private $food_places;

	public function get_places($all = false)
	{
		if (empty($this->all_food_places))
		{
			foreach (glob(__DIR__ . "/food_places/*.ini") as $file)
			{
				$fp = parse_ini_file($file);

				if (empty($fp['name']))
					continue;

				$this->all_food_places[] = $fp + array(
						'address' => '??'
					);
			}

			$this->food_places = $this->all_food_places;
		}

		if ($all === true)
			$this->food_places = $this->all_food_places;

		return $this->food_places;
	}

	public function get_random()
	{
		$this->get_places(true);

		while (count($this->food_places) > 1)
		{
			// shuffle the array around
			$tmp = array();
			while (!empty($this->food_places))
			{
				$random = mt_rand(0, (count($this->food_places) - 1));
				$tmp[]  = $this->food_places[$random];
				unset($this->food_places[$random]);
				$this->food_places = array_values($this->food_places);
			}
			$this->food_places = $tmp;

			// remove a random one from our list
			unset($this->food_places[mt_rand(0, (count($this->food_places) - 1))]);

			// reset all of the keys
			$this->food_places = array_values($this->food_places);
		}

		return $this->get_distance(reset($this->food_places));
	}

	private function get_distance($lucky_one)
	{
		if ($lucky_one['address'] != '??')
		{
			$resp = file_get_contents('https://maps.googleapis.com/maps/api/distancematrix/json?origins=' . urlencode('East High Street, Phoenix, AZ') . '&destinations=' . urlencode($lucky_one['address']) . '&units=imperial');
			try
			{

				if ($resp === false)
					throw new Exception("There was an error retrieving the response from the url");

				$datas = json_decode($resp);

				if ($datas === false)
					throw new Exception("There was an error parsing the response from the url");

				if ($datas->status != "OK")
					throw new Exception("The status response was not 'OK' " . print_r($datas, true));

				$elements = reset($datas->rows);
				$element  = reset($elements);
				$entry    = reset($element);

				$lucky_one += array(
					'distance_from_offce' => $entry->distance->text,
					'time_from_office'    => $entry->duration->text
				);
			}
			catch (Exception $e)
			{
				trigger_error("There was an error retrieving distance information: " . $e->getMessage());
			}
		}

		return $lucky_one;
	}
}