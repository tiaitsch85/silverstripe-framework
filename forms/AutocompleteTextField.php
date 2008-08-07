<?php
/**
 * Autocompleting text field, using script.aculo.us
 * @package forms
 * @subpackage fields-formattedinput
 */
class AutocompleteTextField extends TextField {
	
	protected $optionsURL;
	
	function __construct($name, $title = null, $optionsURL, $value = "", $maxLength = null){
		$this->optionsURL = $optionsURL;		
	
		parent::__construct($name, $title, $value, $maxLength);
	}
	
	function extraClass() {
		return parent::extraClass() . " autocomplete";
	}
	
	function Field() {
		// Requirements::javascript('sapphire/javascript/AutocompleteTextField.js');
		$attributes = array(
			'class' => "{$this->class} text " . $this->extraClass(),
			'type' => 'text',
			'id' => $this->id(),
			'name' => $this->name,
			'value' => $this->Value(),
			'tabindex' => $this->getTabIndexHTML(),
			'size' => $this->maxLength ? min( $this->maxLength, 30 ) : 30 
		); 	
		if($this->maxLength) $attributes['maxlength'] = $this->maxLength;

		return $this->createTag('input', $attributes) . "<div id=\"" . $this->id() . "_Options\" class=\"autocompleteoptions\"></div>";
	}
	
	function FieldHolder() {
		$holder = parent::FieldHolder();
		
		$id = $this->id();
		
		$holder .= <<<JS
			<script type="text/javascript">
				new Ajax.Autocompleter( '$id', '{$id}_Options', '{$this->optionsURL}', { afterUpdateElement : function(el) { if(el.onajaxupdate) { el.onajaxupdate(); } } } );
			</script>
JS;

		return $holder;
	}
}
?>