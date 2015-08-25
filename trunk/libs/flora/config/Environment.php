<?php
final class Environment {
	const DEVLOPMENT = 'development';
	const PRODUCTION = 'production';
	const TEST = 'test';
	public static  $runLevel = self::PRODUCTION;
	
	public static function setRunLevel($level) {
		if (!in_array($level, array(self::DEVLOPMENT, self::PRODUCTION, self::TEST))) {
			throw new Exception('Environment Type error!');
		}
		self::$runLevel = $level;
	}
}
