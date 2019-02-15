<?
require_once('global.inc');

define('SQUARES_PER_ACRE', 1);


class Layout_CellClass
{
	// id of the ward that is claiming this space or false for an unclaimedcell
	public $ward_id = false;
	// tells which sides of the cell have walls
	public $walls = array('left' => false, 'right' => false, 'top' => false, 'bottom' => false,);
	// tells if this cell is inside walls (wards know this already, unclaimeds don't) true, false, null means don't know yet
	public $inside_walls = null;
}

class Layout_CityMapClass
{
	// when bloat changes, make sure to test against "$ratio > .55 || $ratio < .45"
	const WARD_BLOAT_FACTOR = 8.0; // this determines how much larger wards are than just 1:1; don't ever have this less than 1
	public $array_size = 0; // how many cells so that you don't have to do count($this->cells) all the time
	public $width = false; // how many map cells in width
	public $height = false; // how many map cells in height
	public $average_density = false; // the average density of the citytype; could be a table value since it's static
	private $city = false; // the city used for generation // keep private so that json doesn't get an infinite loop
	private $starting_locations = array(); // 2D array of possible starting positions
	private $start_locations_corners = array(); // array of corner starting positions (duplicate data of $start_locations)
	public $unused_squares = array(); // the position of all the unused squares that can be filled
	public $cells = false; // array of cell class describing a cell of the map
	private $wards_by_id = array(); // array of id => ward for easy lookup

	public function generate($city)
	{
		// save the city for all to cherish
		$this->city = $city;

		// create the cells array of the right size and determine height/width of layout
		$this->create_cell_layout();

		// setup starting locations in layers
		$this->setup_layers();

		// pick a starting position for each ward
		$this->set_starting_positions();

//TODO: place rivers/roads after starting places so that raods rivers can flow around the zones, fi there is a river zone, make sur ethe river goes by it
//TODO: rivers/roads have a variable thickness?
//TODO:			place rivers
//TODO:			place roads
//TODO:			some wards stop at roads
//TODO:			some wards stop at rivers

		// once all wards have a start position, loop through them all and place a square
		$this->allocate_wards();

//			fill empty space with cool stuff

		// set up cells array with wards and empty spaces information in preparation for walls
		$this->load_cells();

		// determine which cells have walls on which sides
		$this->add_walls();


	}

	/**
	 * load cells array with all the wards positions and empty positions as Layout_CellClass
	 * also create ward lookup by id array
	 */
	private function load_cells()
	{
		$this->cells = array();
		// it's all pointers so it's ok!
		// easy lookup of ward by id for wall detection
		foreach ($this->city->wards as $ward) {
			$this->wards_by_id[$ward->id] = $ward;

			// load cell positions
			foreach ($ward->map_positions() as $position) {
				$cell = new Layout_CellClass();
				$cell->ward_id = $ward->id;
				$cell->inside_walls = $ward->inside_walls;
				$this->cells[$position] = $cell;
			}
		}

		foreach ($this->unused_squares as $position) {
			// 0 index position was being set to blank?
			$this->cells[$position] = new Layout_CellClass();
		}
		//ksort($this->cells);
		//pprint_r(array($this->cells, $this->wards_by_id), 'grid layout', true);
	}

	/**
	 * get a point from layered started points
	 *
	 * @param $inside_walls true if the ward should be inside walls (placed in inner layers)
	 * @param $corner true if the ward should be in a corner (outter layer corner); this trumps inside_walls
	 * @return integer point of the starting position
	 */
	private function get_starting_point($inside_walls, $corner)
	{
		if ($corner) {
			// randomize corners just for kicks
			shuffle($this->start_locations_corners);
			// get a random corner
			$point = array_shift($this->start_locations_corners);
			// remove corner from layers
			$layer = &$this->starting_locations[count($this->starting_locations) - 1];
			$idx = array_search($point, $layer);
			unset($layer[$idx]);
			// if layer is exhausted (tiny all ocean city?) remove layer
			if (count($layer) == 0) {
				array_pop($this->starting_locations);
			}
		} else {
			// outside walls start on edges
			if ($inside_walls) {
				$layer_idx = 0;
			} else {
				// inside walls start in center
				$layer_idx = count($this->starting_locations) - 1;
			}
			// get layer
			$layer = &$this->starting_locations[$layer_idx];
			shuffle($layer);
			// get point
			$point = array_shift($layer);
			// remove layer if it's empty
			if (count($layer) == 0) {
				if ($inside_walls) {
					array_shift($this->starting_locations);
				} else {
					array_pop($this->starting_locations);
				}
			}
		}

		// remove from unused squares
		$idx = array_search($point, $this->unused_squares);
		unset($this->unused_squares[$idx]);

		return $point;
	}

	/**
	 * setup the layers of starting points for wards
	 */
	private function setup_layers()
	{
		$this->starting_locations = array();
		// 4 corners on outside layer
		$this->start_locations_corners = array();
		$wards_count = count($this->city->wards);
		$layers_count = 0;
		$layer_size = 4;
		while ($wards_count > 0) {
			$layers_count++;
			$wards_count -= $layer_size;
			$layer_size += 8;
		}
		// dots across = layers * 2; add two for margin with outside
		$square_step_x = $this->width / ($layers_count * 2 + 1);
		$square_step_y = $this->height / ($layers_count * 2 + 1);
		for ($level_number = 0; $level_number < $layers_count; $level_number++) {
			// move to level_number
			$cell_start_x = floor($square_step_x * ($layers_count - $level_number));
			$cell_start_y = floor($square_step_y * ($layers_count - $level_number));
			$layer = array();
			for ($x_pos = 0; $x_pos < ($level_number + 1) * 2; $x_pos++) {
				// fill whole row for first and last rows
				if ($x_pos == 0 || $x_pos == ($level_number + 1) * 2 - 1) {
					for ($y_pos = 0; $y_pos < ($level_number + 1) * 2; $y_pos++) {
						$layer[] = $this->position_to_point($cell_start_x + floor($square_step_x * $x_pos), floor($cell_start_y + $square_step_y * $y_pos));
					}
					// remember corners of outside layer
					if ($level_number == $layers_count - 1) {
						$this->start_locations_corners[] = $this->position_to_point($cell_start_x + floor($square_step_x * $x_pos), $cell_start_y);
						$this->start_locations_corners[] = $this->position_to_point($cell_start_x + floor($square_step_x * $x_pos), floor($cell_start_y + $square_step_y * (($level_number) * 2 + 1)));
					}
				} else {
					// only border cells for middle rows
					$layer[] = $this->position_to_point($cell_start_x + floor($square_step_x * $x_pos), $cell_start_y);
					$layer[] = $this->position_to_point($cell_start_x + floor($square_step_x * $x_pos), floor($cell_start_y + $square_step_y * (($level_number) * 2 + 1)));
				}
			}
			$this->starting_locations[] = $layer;
		}
		//$this->dev_show_layers_graph();
	}

	/**
	 * set starting positions for every ward
	 */
	private function set_starting_positions()
	{

		// place ward starting points in the city
		// - seas & outskirts (go in the corners)
		foreach ($this->city->wards as $ward) {
			if ($ward->type() == Layout_Enum_Wards::kWard_Sea || $ward->type() == Layout_Enum_Wards::kWard_Outskirt) {
				$point = $this->get_starting_point(false, true);
				// add starting position to the ward
				$ward->add_map_position($point, $this);
			}
		}

		// - non-sea, non-outskirt, non-gate (gates go in the middle layers)
		foreach ($this->city->wards as $ward) {
			if ($ward->type() != Layout_Enum_Wards::kWard_Sea && $ward->type() != Layout_Enum_Wards::kWard_Outskirt && $ward->type() != Layout_Enum_Wards::kWard_Gate) {
				$point = $this->get_starting_point($ward->inside_walls, false);
				$ward->add_map_position($point, $this);
			}
		}

		// - gates
		foreach ($this->city->wards as $ward) {
			if ($ward->type() == Layout_Enum_Wards::kWard_Gate) {
				// should this be false or true for inside walls? does it matter? should it go for middle layers?
				$point = $this->get_starting_point(false, false);
				$ward->add_map_position($point, $this);
			}
		}
		//$this->dev_show_wards_start_graph();
	}

	/**
	 * find all adjacent cells that are unclaimed; if an adjacent cell is claimed and outside walls, all the cells are outside walls
	 * @param $idx int starting point of an unclaimed cell
	 */
	private function add_walls_to_unclaimed_clump($idx)
	{
		$neighbors = array($idx);
		$inside_walls = true;
		for ($i = 0; $i < count($neighbors); $i++) {
			$new_neighbors = $this->neighbor_squares($neighbors[$i]);
			// put clumps touching the border always outside walls
			if (count($new_neighbors) != 4) {
				$inside_walls = false;
			}
			// loop through neighbors looking for unclaimeds and outsiders
			foreach ($new_neighbors as $new_neighbor) {
				$neighbor_cell = $this->cells[$new_neighbor];
				// only add new neighbor if it is unclaimed
				if (array_search($new_neighbor, $neighbors) === false) {
					// if neighbor is unwalled, the whole thing is unwalled
					if ($neighbor_cell->inside_walls === false) {
						$inside_walls = false;
					} else if ($neighbor_cell->inside_walls === null) {
						// neighbor is unclaimed so add to neighbors to lookup
						$neighbors[] = $new_neighbor;
					}
					// else if neighbor_cell->inside_walls === true then inside_walls remains default true
				}
			}
		}
		// set the whole group's walled status
		foreach ($neighbors as $neighbor) {
			$this->cells[$neighbor]->inside_walls = $inside_walls;
		}
	}


	/**
	 * set walled status on all unclaimed cells and set wall sides on all walled cells bordering unwalled
	 */
	private function add_walls()
	{
		// phase 1 : determine inside/outside
		// loop through and find any positions that aren't resolved
		foreach ($this->cells as $idx => $cell) {
			// find unclaimed cells and set their walled status
			if ($cell->inside_walls === null) {
				$this->add_walls_to_unclaimed_clump($idx);
			}
		}
//		$this->dev_show_wards_squares_graph();
//		$this->dev_show_walled();

		// phase 2 : find wall sides
		// loop through each position
		for ($i = 0; $i < $this->array_size; $i++) {
			$cell = $this->cells[$i];
			// only add walls to cells that are inside walls
			if ($cell->inside_walls) {
				// get neighbors to this cell
				$neighbors = $this->neighbor_squares($i);
				// loop over possible sides so that cells on edge of layout still get walls
				foreach (array('left', 'top', 'right', 'bottom') as $side) {
					// if on border OR if adjacent cell is outside walls, add a wall for that side
					if (!isset($neighbors[$side]) || !$this->cells[$neighbors[$side]]->inside_walls) {
						$cell->walls[$side] = true;
					}
				}
			}
		}
//		$this->dev_show_wards_squares_graph();
//		$this->dev_show_walled();
	}

	/**
	 * determine height/width of the city and create unused_squares array of point indexes
	 */
	private function create_cell_layout()
	{
		global $table_population_ward_density;

		$this->average_density = 0;

		// get the average density of building types for the city's population type
		$densities = $table_population_ward_density[$this->city->population_type];
		foreach ($densities as $density) {
			$this->average_density += $density;
		}
		$this->average_density /= count($densities);

		// get the total cells for all the wards
		$num_cells = 0;
		foreach ($this->city->wards as $ward) {
			$ward->number_cells = intval(max(1, intval($ward->building_total / $this->average_density)) * Layout_CityMapClass::WARD_BLOAT_FACTOR);
			$num_cells += $ward->number_cells;
		}

		$num_cells *= 1.05; // add some bloat for the edges and inconsistencies and ward holes

		// get random ratio (weighted towards .5) for determining height vs width
		// this determines the root to use when dividing cells
		// for a square city, # of cells in height or width = sqroot of total cells, doing different roots gives different shapes
		do {
			// loop until the ratio isn't impossibly bad
			$ratio = rand_ratio();
		} while ($ratio > .55 || $ratio < .45); // if this changes, make sure to test against Layout_CityMapClass::WARD_BLOAT_FACTOR

		// get height/width to be a rectangle
		$this->height = max(1, intval(pow($num_cells, $ratio)));
		$this->width = max(1, intval($num_cells / $this->height));

		while ($this->width * $this->height < $num_cells) {
			// alternate
			if (($this->width + $this->height) % 2) {
				$this->width++;
			} else {
				$this->height++;
			}
		}
		// num_cells will most likely be a bit bigger now than originally intended which is ok, allows more filler
		$num_cells = $this->width * $this->height;

		// for quick looping not requiring count() every time
		$this->array_size = $num_cells;

		// setup unused squares array
		$this->unused_squares = array();
		for ($i = 0; $i < $num_cells; $i++) {
			$this->unused_squares[] = $i;
		}
	}

	/**
	 * find neighbor cells to the given point
	 *
	 * @param $point int number index in to city layout
	 * @return array of integers indexes in to city layout that are adjacent to this point
	 */
	public function neighbor_squares($point)
	{
		// check adjacent squares to point to see if they should be added to possible positions
		$possible_points = array();
		// up = $point - width; ok to be negative, it will be disallowed later
		$temp = $point - $this->width;
		if ($temp >= 0) {
			$possible_points['top'] = $temp;
		}
		// down = $point + width; ok to be off edge of map, it will be disallowed later
		$temp = $point + $this->width;
		if ($temp < $this->array_size) {
			$possible_points['bottom'] = $temp;
		}
		// left = $point - 1; watch for edges
		if ($point % $this->width != 0) {
			$possible_points['left'] = $point - 1;
		}
		// right = $point +1; watch for edges
		if (($point + 1) % $this->width != 0) {
			$possible_points['right'] = $point + 1;
		}
		return $possible_points;
	}

	/**
	 * convert x/y point to a index position in the city grid
	 * @param $x
	 * @param $y
	 * @return integer square index
	 */
	public function position_to_point($x, $y)
	{
		return $y * $this->width + $x;
	}

	private function allocate_wards()
	{
		// once all wards have a start position, loop through them all and place a square
		do {
			$continue = false;
			foreach ($this->city->wards as $ward) {
				$continue = $ward->add_layout_square($this) || $continue;
//TODO: rivers/roads should not place squares here
			}
		} while ($continue);
		//$this->dev_show_wards_squares_graph();
	}

	/**
	 * Dev use only; show the wards spaces graph
	 */
	private function dev_show_wards_squares_graph()
	{
		$positions = array();
		foreach ($this->city->wards as $ward) {
			foreach ($ward->map_positions() as $position) {
				$positions[$position] = $ward->id_letter;
			}
		}
		$this->dev_show_layout_graph($positions);
	}

	private function dev_show_wards_start_graph()
	{
		$positions = array();
		foreach ($this->city->wards as $ward) {
			$positions[$ward->map_positions()[0]] = $ward->type()[0];
		}
		$this->dev_show_layout_graph($positions);
	}

	private function dev_show_layout_graph($positions_taken, $die = true)
	{
		// show layers graph
		echo '<pre>';
		for ($i = 0; $i < $this->array_size; $i++) {
			if ($i % $this->width == 0) {
				echo '<br />';
			}
			if (isset($positions_taken[$i])) {
				echo $positions_taken[$i];
			} else {
//pprint_r(array($i, $positions_taken), 'position not set?', true);
				echo '*';
			}
		}
		echo '</pre>';
		if ($die) {
			exit('<br /><br />there you have it');
		}
	}

	private function dev_show_layers_graph()
	{
		$positions = array();
		$layer_num = 0;
		foreach ($this->starting_locations as $layer) {
			$layer_num++;
			foreach ($layer as $position) {
				$positions[$position] = $layer_num;
			}
		}

		foreach ($this->start_locations_corners as $position) {
			$positions[$position] = 'c';
		}
		$this->dev_show_layout_graph($positions);
	}

	private function dev_show_walled()
	{
		$positions = array();
		foreach ($this->cells as $idx => $cell) {
			if ($cell->inside_walls !== null) {
				if ($cell->inside_walls) {
					$positions[$idx] = ($cell->ward_id || $cell->ward_id === 0) ? $this->wards_by_id[$cell->ward_id]->id_letter : '?';
//					$positions[$idx] = 'H';
				} else {
					$positions[$idx] = '*';
				}
			} else {
				$positions[$idx] = 'X';
			}
		}
		$this->dev_show_layout_graph($positions);
	}

	private function dev_show_neighbors($idx, $neighbors)
	{
		$positions = array($idx => 'X');
		foreach ($neighbors as $neighbor) {
			$positions[$neighbor] = 'N';
		}
		$this->dev_show_layout_graph($positions);
	}
}
