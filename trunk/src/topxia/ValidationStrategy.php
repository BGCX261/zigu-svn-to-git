<?php
/**
 * ͶƱ��֤����
 * ���ܵ���֤����(IP���ơ��û����ơ������ơ�ip & �û����ơ��û�ʱ�����ơ�ipʱ�����ơ��û��ȼ�����,�û���½����,�û�ע��ʱ������)
 * 
 */
interface ValidationStrategy {
	/**
	 * ��֤���ԣ�������ͶƱ���
	 * ����ֵ����һ��Array
	 * ����ǷǷ�ͶƱ��ֱ���׳�ValidationException
	 * @param array $polls ͶƱ����
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
