<?php
/**
 * 投票验证策略
 * 可能的验证策略(IP限制、用户限制、不限制、ip & 用户限制、用户时间限制、ip时间限制、用户等级限制,用户登陆限制,用户注册时间限制)
 * 
 */
interface ValidationStrategy {
	/**
	 * 验证策略，参数是投票结果
	 * 返回值则是一个Array
	 * 如果是非法投票，直接抛出ValidationException
	 * @param array $polls 投票限制
	 * @return array
	 *    {
	 *       0 -> 'validation error 1',
	 * 		 1 -> 'validation error 2',
	 *       2 -> 'validation error 3',
	 * 		 3 -> 'validation error 4',
	 *    }
	 */
	public function validate($polls);
}
