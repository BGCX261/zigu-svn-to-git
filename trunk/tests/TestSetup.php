<?php

class TestSetup {
	public static function reCreateTables() {
		foreach (new DirectoryIterator('../database') as $item) {
			echo $item . "\n\n";
		}
	}
}