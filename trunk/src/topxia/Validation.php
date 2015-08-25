<?php

interface Validation{
	public function getName();
	public function process($poll);
	public function validate($poll);
}

class AbstractValidation {
	private $validation=null;
	
	/**
	 * @return unknown
	 */
	public function getValidation() {
		return $this->validation;
	}
	
	/**
	 * @param unknown_type $validation
	 */
	public function setValidation($validation) {
		if(!$this->validation){
		  $this->validation = $validation;
		}else{
			$this->validation->setValidation($validation);
		}
	}
	
	public function process($poll){
		if($this->validation!=null) {
		  $result = $this->validation->process($poll);
		}
		if($result && !$result->isLegal())
		   return $result;
		return $this->validate();
	}

}

class XXValidation extends AbstractValidation{
	public function getName(){
		return 'XX';
	}
	public function validate($poll){
		return new ValidationResult();
	}
}




class ValidationResult{
	public function setLegal($legal){
		
	}
	public function isLegal(){
		
	}
	public function getIllegalInfo(){
		
	}
	public function setIllegalInfo($illegalInfo){
		
	}
	
}
?>