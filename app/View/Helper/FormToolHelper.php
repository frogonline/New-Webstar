<?php
class FormToolHelper extends AppHelper {
	var $helpers = array('Cache','Html','Session','Form','Paginator');
	
	public function buildTool($toolArr){
		$str = '';
		if(!empty($toolArr)){
			switch($toolArr['FormTool']['tool_type']){
				case 'TB':
					$str .= $this->textbox($toolArr);
					break;
				case 'TA':
					$str .= $this->textarea($toolArr);
					break;
				case 'PW':
					$str .= $this->password($toolArr);
					break;
				case 'EI':
					$str .= $this->emailid($toolArr);
					break;
				case 'CB':
					$str .= $this->checkbox($toolArr);
					break;
				case 'RB':
					$str .= $this->radiobutton($toolArr);
					break;
				case 'SB':
					$str .= $this->selectbox($toolArr);
					break;
				case 'IMG':
					$str .= $this->imgbox($toolArr);
					break;
				default:
					$str .= '';
					break;
			}
		}
		return $str;
	}
	
	private function textbox($fldArr){
		$str = '<div class="col-sm-6">';
		//$str .= '<div class="form-group">';
		$str .= ($fldArr['FormTool']['is_required']=='Y')?'<p class="" for="tool-'.$fldArr['FormTool']['id'].'">'.$fldArr['FormTool']['label'].'*</p>':'<p class="" for="tool-'.$fldArr['FormTool']['id'].'">'.$fldArr['FormTool']['label'].'</p>';
		
		//$str .= '<div class="col-lg-12">';
		$str .= $this->Form->input('tool-'.$fldArr['FormTool']['id'], array('type'=>'text', 'required'=>($fldArr['FormTool']['is_required']=='Y')?true:false, 'placeholder'=>$fldArr['FormTool']['placeholder'].' *', 'class'=>'form-control', 'id'=>'tool-'.$fldArr['FormTool']['id']));
		$str .= '</div>';
		
		//$str .= '</div>';
		return $str;
	}
	
	private function textarea($fldArr){
		$str = '<div class="col-sm-6">';
		//$str .= '<div class="form-group">';
		$str .= ($fldArr['FormTool']['is_required']=='Y')?'<p class="" for="tool-'.$fldArr['FormTool']['id'].'">'.$fldArr['FormTool']['label'].'*</p>':'<p class="" for="tool-'.$fldArr['FormTool']['id'].'">'.$fldArr['FormTool']['label'].'</p>';
		  
		//$str .= '<div class="col-lg-12">';
		$str .= $this->Form->textarea('tool-'.$fldArr['FormTool']['id'], array('placeholder'=>$fldArr['FormTool']['placeholder'].' *', 'class'=>'form-control', 'required'=>($fldArr['FormTool']['is_required']=='Y')?true:false, 'id'=>'tool-'.$fldArr['FormTool']['id'], 'rows'=>$fldArr['FormTool']['rows'], 'cols'=>$fldArr['FormTool']['cols']));
		$str .= '</div>';
		
		//$str .= '</div>';
		return $str;
	}
	
	private function emailid($fldArr){
		$str = '<div class="col-sm-6">';
		//$str .= '<div class="form-group">';
		$str .= ($fldArr['FormTool']['is_required']=='Y')?'<p class="" for="tool-'.$fldArr['FormTool']['id'].'">'.$fldArr['FormTool']['label'].'*</p>':'<p class="" for="tool-'.$fldArr['FormTool']['id'].'">'.$fldArr['FormTool']['label'].'</p>';
		
		//$str .= '<div class="col-lg-12">';
		$str .= $this->Form->input('tool-'.$fldArr['FormTool']['id'], array('type'=>'email', 'required'=>($fldArr['FormTool']['is_required']=='Y')?true:false, 'placeholder'=>$fldArr['FormTool']['placeholder'].' *', 'class'=>'form-control', 'id'=>'tool-'.$fldArr['FormTool']['id']));
		$str .= '</div>';
		
		//$str .= '</div>';
		return $str;
	}
	
	private function password($fldArr){
		$str = '<div class="col-sm-6">';
		//$str .= '<div class="form-group">';
		$str .= ($fldArr['FormTool']['is_required']=='Y')?'<p class="" for="tool-'.$fldArr['FormTool']['id'].'">'.$fldArr['FormTool']['label'].'*</p>':'<p class="" for="tool-'.$fldArr['FormTool']['id'].'">'.$fldArr['FormTool']['label'].'</p>';
		
		//$str .= '<div class="col-lg-12">';
		$str .= $this->Form->input('tool-'.$fldArr['FormTool']['id'], array('type'=>'password', 'required'=>($fldArr['FormTool']['is_required']=='Y')?true:false, 'placeholder'=>$fldArr['FormTool']['placeholder'].' *', 'class'=>'form-control', 'id'=>'tool-'.$fldArr['FormTool']['id']));
		$str .= '</div>';
		
		//$str .= '</div>';
		return $str;
	}
	
	private function checkbox($fldArr){
		$str = '<div class="col-sm-6">';
		$str .= '<div class="form-group">';
		$str .= ($fldArr['FormTool']['is_required']=='Y')?'<p class="" for="tool-'.$fldArr['FormTool']['id'].'">'.$fldArr['FormTool']['label'].'*</p>':'<p class="" for="tool-'.$fldArr['FormTool']['id'].'">'.$fldArr['FormTool']['label'].'</p>';
		
		$str .= '<div class="col-lg-12">';
		if(!empty($fldArr['FormToolOption'])){
			foreach($fldArr['FormToolOption'] as $opt){
				$str .= '<div class="col-md-3" style="padding:5px 0 0 0;">';
				if($fldArr['FormTool']['is_required']=='Y'){
					$str .= '<input type="checkbox" required="required" name="data[FormTable][tool-'.$fldArr['FormTool']['id'].']['.$opt['id'].']" value="'.$opt['option_value'].'" /> '.$opt['option_value'];
				} else {
					$str .= '<input type="checkbox" name="data[FormTable][tool-'.$fldArr['FormTool']['id'].']['.$opt['id'].']" value="'.$opt['option_value'].'" /> '.$opt['option_value'];
				}
				$str .= '</div>';
			}
		}
		$str .= '</div>';
		
		$str .= '</div>';
		$str .= '</div>';
		return $str;
	}
	
	private function radiobutton($fldArr){
		$str = '<div class="col-sm-6">';
		$str .= '<div class="form-group">';
		
		
		$str .= '<div class="col-lg-12">';
		$str .= ($fldArr['FormTool']['is_required']=='Y')?'<p class="" for="tool-'.$fldArr['FormTool']['id'].'">'.$fldArr['FormTool']['label'].'*</p>':'<p class="" for="tool-'.$fldArr['FormTool']['id'].'">'.$fldArr['FormTool']['label'].'</p>';
		
		if(!empty($fldArr['FormToolOption'])){
			foreach($fldArr['FormToolOption'] as $opt){
				$str .= '<div class="col-md-3" style="padding:5px 0 0 0;">';
				if($fldArr['FormTool']['is_required']=='Y'){
					$str .= '<input type="radio" required="required" name="data[FormTable][tool-'.$fldArr['FormTool']['id'].']" value="'.$opt['option_value'].'" id="tool-'.$fldArr['FormTool']['id'].'-'.$opt['id'].'" /> '.$opt['option_value'];
				} else {
					$str .= '<input type="radio" name="data[FormTable][tool-'.$fldArr['FormTool']['id'].']" value="'.$opt['option_value'].'" id="tool-'.$fldArr['FormTool']['id'].'-'.$opt['id'].'" /> '.$opt['option_value'];
				}
				$str .= '</div>';
			}
		}
		$str .= '</div>';
		$str .= '</div>';
		$str .= '</div>';
		return $str;
	}
	
	private function selectbox($fldArr){
		$str = '<div class="col-sm-6">';
		$str .= '<div class="form-group">';
	
		
		$str .= '<div class="col-lg-12">';
			$str .= ($fldArr['FormTool']['is_required']=='Y')?'<p class="" for="tool-'.$fldArr['FormTool']['id'].'">'.$fldArr['FormTool']['label'].'*</p>':'<p class="" for="tool-'.$fldArr['FormTool']['id'].'">'.$fldArr['FormTool']['label'].'</p>';
			
		if(!empty($fldArr['FormToolOption'])){
			if($fldArr['FormTool']['is_required']=='Y'){
				$str .= '<select name="data[FormTable][tool-'.$fldArr['FormTool']['id'].']" required="required" class="form-control">';
			} else {
				$str .= '<select name="data[FormTable][tool-'.$fldArr['FormTool']['id'].']" class="form-control">';
			}
			$str .= '<option value="">Please Select</option>';
			foreach($fldArr['FormToolOption'] as $opt){
				$str .= '<option value="'.$opt['option_value'].'">'.$opt['option_value'].'</option>';
			}
			$str .= '</select>';
		}
		$str .= '</div>';
		$str .= '</div>';
		$str .= '</div>';
		return $str;
	}
	
	private function imgbox($fldArr){
		$str = '<div class="col-sm-6">';
		//pr($fldArr);
		$str .= ($fldArr['FormTool']['is_required']=='Y')?'<p class="" for="tool-'.$fldArr['FormTool']['id'].'">'.$fldArr['FormTool']['label'].'*</p>':'<p class="" for="tool-'.$fldArr['FormTool']['id'].'">'.$fldArr['FormTool']['label'].'</p>';
		
	
		$id=$fldArr["FormTool"]["id"];
		if($fldArr['FormTool']['multiple_flag']=='Y'){
		$name='data[FormTable][tool-'.$id.'][]';
		}else{
		$name='data[FormTable][tool-'.$id.']';
		}
		$str .= $this->Form->input('tool-'.$fldArr['FormTool']['id'], array('type'=>'file', 'required'=>($fldArr['FormTool']['is_required']=='Y')?true:false, 'multiple'=>($fldArr['FormTool']['multiple_flag']=='Y')?true:false, 'class'=>'form-control formfileclass','name'=>$name, 'id'=>'tool-'.$fldArr['FormTool']['id']));
		$str .= '</div>';
		return $str;
	}
}
?>