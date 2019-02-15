<?
	require_once '../generate_layout.inc';

	class Layout_CityMapClass_Test extends Layout_CityMapClass {
		public function test() {
			$this->test_coord_to_array_pos();
			$this->test_position_to_idx();
			$this->test_idx_string_to_position();
			$this->test_idx_to_position_string();
			$this->test_idx_to_position();

			exit('test complete');
		}

		private function test_idx_to_position() {
			$this->width = 7;
			$this->height = 9;

			for ($y = 0; $y < $this->height; $y++) {
				for ($x = 0; $x < $this->width; $x++) {
					assert(array('x' => $x, 'y' => $y) == $this->idx_to_position($y * $this->width + $x), "$x:$y failed");
				}
			}
		}

		private function test_idx_to_position_string() {
			$this->width = 9;
			$this->height = 7;

			for ($y = 0; $y < $this->height; $y++) {
				for ($x = 0; $x < $this->width; $x++) {
					assert("$x:$y" == $this->idx_to_position_string($y * $this->width + $x), "$x:$y failed with : " . $this->idx_to_position_string($y * $this->width + $x));
				}
			}
		}

		private function test_position_to_idx() {
			assert('1:3' == $this->position_to_idx(array('x' => 1, 'y' => 3)));
		}
		private function test_idx_string_to_position() {
			assert(array('x' => 1, 'y' => 3) == $this->idx_string_to_position('1:3'));
		}


		private function test_coord_to_array_pos() {
			$this->width = 9;
			$this->height = 7;

			for ($y = 0; $y < $this->height; $y++) {
				for ($x = 0; $x < $this->width; $x++) {
					$position = array('x' => $x, 'y' => $y);
					assert($y * $this->width + $x == $this->coord_to_array_pos($position), $position['x'] . ':' . $position['y'] . ' failed with : ' . $this->coord_to_array_pos($position));
				}
			}

			$position = array('x' => -1, 'y' => 0);
			assert(-1 == $this->coord_to_array_pos($position), $position['x'] . ':' . $position['y'] . ' failed with : ' . $this->coord_to_array_pos($position));

			$position = array('x' => 0, 'y' => -1);
			assert(-1 == $this->coord_to_array_pos($position), $position['x'] . ':' . $position['y'] . ' failed with : ' . $this->coord_to_array_pos($position));

			$position = array('x' => 0, 'y' => 0);
			assert(0 == $this->coord_to_array_pos($position), $position['x'] . ':' . $position['y'] . ' failed with : ' . $this->coord_to_array_pos($position));

			for ($i = 1; $i < 9; $i++) {
				$position = array('x' => $i, 'y' => 0);
				assert($i == $this->coord_to_array_pos($position), $position['x'] . ':' . $position['y'] . ' failed with : ' . $this->coord_to_array_pos($position));
			}
			for ($i = 1; $i < 9; $i++) {
				$position = array('x' => $i, 'y' => 1);
				assert($i + $this->width == $this->coord_to_array_pos($position), $position['x'] . ':' . $position['y'] . ' failed with : ' . $this->coord_to_array_pos($position));
			}

			$position = array('x' => 0, 'y' => 1);
			assert(9 == $this->coord_to_array_pos($position), $position['x'] . ':' . $position['y'] . ' failed with ' . $this->coord_to_array_pos($position));

			$position = array('x' => 0, 'y' => 2);
			assert(18 == $this->coord_to_array_pos($position), $position['x'] . ':' . $position['y'] . ' failed with ' . $this->coord_to_array_pos($position));

			$position = array('x' => 0, 'y' => 3);
			assert(27 == $this->coord_to_array_pos($position), $position['x'] . ':' . $position['y'] . ' failed with ' . $this->coord_to_array_pos($position));

			$position = array('x' => 0, 'y' => 4);
			assert(36 == $this->coord_to_array_pos($position), $position['x'] . ':' . $position['y'] . ' failed with ' . $this->coord_to_array_pos($position));

			$position = array('x' => 0, 'y' => 5);
			assert(45 == $this->coord_to_array_pos($position), $position['x'] . ':' . $position['y'] . ' failed with ' . $this->coord_to_array_pos($position));

			$position = array('x' => 0, 'y' => 6);
			assert(54 == $this->coord_to_array_pos($position), $position['x'] . ':' . $position['y'] . ' failed with ' . $this->coord_to_array_pos($position));

			$position = array('x' => 8, 'y' => 6);
			assert(62 == $this->coord_to_array_pos($position), $position['x'] . ':' . $position['y'] . ' failed with ' . $this->coord_to_array_pos($position));
		}
	}

//	(new Layout_CityMapClass_Test())->test(); // run the tests
