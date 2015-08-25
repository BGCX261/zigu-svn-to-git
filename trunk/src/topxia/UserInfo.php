<?php
/**
 * �ڶ��������û���Ϣ,��Ҫ��Ϊ����ͶƱϵͳ�Ϳͻ����û�ϵͳ�ܹ��Ӳ�
 * @author weihello
 */
interface UserInfo{
	/**
	 * ��õ�ǰ�û���Ϣ
	 * @param $args array �û��Զ�����������ⶨ��
	 * @return array
	 * 	 ��ʽ {
	 * 			'uid' -> '123435',
	 * 			'username' -> 'weihello',
	 * 			'isLogin' -> true
	 * 		 }
	 *   �û����Զ��Ƽ������
	 */
	function getUserInfo($args);
	/**
	 * �û��Ϸ���֤(����������֤)
	 * @param $args array �û��Զ�����������ⶨ��
	 * @return 
	 *    {
	 *       0 -> 'validation error 1',
	 * 		 1 -> 'validation error 2',
	 *       2 -> 'validation error 3',
	 * 		 3 -> 'validation error 4',
	 *    }
	 * �޴����򷵻�{}	 
	 *
	 */
	function validateUserInfo($args);
}