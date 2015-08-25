<?php
/**
 * 第二方定制用户信息,主要是为了让投票系统和客户的用户系统能够接驳
 * @author weihello
 */
interface UserInfo{
	/**
	 * 获得当前用户信息
	 * @param $args array 用户自定义参数，任意定制
	 * @return array
	 * 	 格式 {
	 * 			'uid' -> '123435',
	 * 			'username' -> 'weihello',
	 * 			'isLogin' -> true
	 * 		 }
	 *   用户可以定制继续添加
	 */
	function getUserInfo($args);
	/**
	 * 用户合法验证(包括其他验证)
	 * @param $args array 用户自定义参数，任意定制
	 * @return 
	 *    {
	 *       0 -> 'validation error 1',
	 * 		 1 -> 'validation error 2',
	 *       2 -> 'validation error 3',
	 * 		 3 -> 'validation error 4',
	 *    }
	 * 无错误则返回{}	 
	 *
	 */
	function validateUserInfo($args);
}