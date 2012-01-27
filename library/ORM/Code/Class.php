<?php
/**
 * @TODO DOCUMENT
 */ 
class Code_Class{
	private $name;
	private $attributes;
	private $constants;
	private $methods;
	private $author;
	private $package;
	private $subpackage;
	private $version;
	private $date;
	private $superclass;
	private $comments;
	private $template;
	private $relations;
	
	public function __construct($name = null, $superclass = null){
		if (is_null($name)) throw new Exception("INVALID CLASS NEM PROVIDED IN CONTRUCTOR");
		
		$this->name = $name;
		$this->superclass = null;
		$this->methods = array();
		$this->attributes = array();
		$this->author = "IDS ORM <orm@ids-team.com>";
		$this->package = "models";
		$this->subpackage = null;
		$this->version = "1";
		$this->date = date("Y-m-d");
		
		$this->template = "model.php.tpl";
	}
	/**
	 * @return the $name
	 */
	public function getName() {
		return $this->name;
	}

	/**
	 * @return the $attributes
	 */
	public function getAttributes() {
		return $this->attributes;
	}

	/**
	 * @return the $methods
	 */
	public function getMethods() {
		return $this->methods;
	}

	/**
	 * @return the $author
	 */
	public function getAuthor() {
		return $this->author;
	}

	/**
	 * @return the $package
	 */
	public function getPackage() {
		return $this->package;
	}

	/**
	 * @return the $subpackage
	 */
	public function getSubpackage() {
		return $this->subpackage;
	}

	/**
	 * @return the $version
	 */
	public function getVersion() {
		return $this->version;
	}

	/**
	 * @return the $date
	 */
	public function getDate() {
		return $this->date;
	}

	/**
	 * @return the $superclass
	 */
	public function getSuperclass() {
		return $this->superclass;
	}

	/**
	 * @param $name the $name to set
	 */
	public function setName($name) {
		$this->name = $name;
	}

	/**
	 * @param $author the $author to set
	 */
	public function setAuthor($author) {
		$this->author = $author;
	}

	/**
	 * @param $package the $package to set
	 */
	public function setPackage($package) {
		$this->package = $package;
	}

	/**
	 * @param $subpackage the $subpackage to set
	 */
	public function setSubpackage($subpackage) {
		$this->subpackage = $subpackage;
	}

	/**
	 * @param $version the $version to set
	 */
	public function setVersion($version) {
		$this->version = $version;
	}

	/**
	 * @param $date the $date to set
	 */
	public function setDate($date) {
		$this->date = $date;
	}

	/**
	 * @param $superclass the $superclass to set
	 */
	public function setSuperclass($superclass) {
		$this->superclass = $superclass;
	}

	
	/**
	 * @return the $comments
	 */
	public function getComments() {
		return $this->comments;
	}

	/**
	 * @param $comments the $comments to set
	 */
	public function setComments($comments) {
		$this->comments = $comments;
	}

	public function removeAllAttributes(){
		$this->attributes = array();
	}
	
	public function removeAllMethods(){
		$this->methods = array();
	}
	
	public function addMethod(Code_Class_Method $method){
		$this->methods[] = $method;
	}
	
	public function addAttribute(Code_Class_Attribute $attribute){
		$this->attributes[$attribute->getName()] = $attribute;
	}
	/**
	 * @return the $constants
	 */
	public function getConstants() {
		return $this->constants;
	}
	
	public function AddConstatnt(Code_Class_Constant $constant){
		$this->constants[$constant->getName()] = $constant;
	}
	/**
	 * @return the $template
	 */
	public function getTemplate() {
		return $this->template;
	}

	/**
	 * @param $template the $template to set
	 */
	public function setTemplate($template) {
		$this->template = $template;
	}
	
	
	public function hasRelations(){
		return (count($this->relations)>0);
	}
	public function addRelation($relation){
		$this->relations[] = $relation;
	}

	/**
	 * @return the $relations
	 */
	public function getRelations() {
		return $this->relations;
	}

	/**
	 * @param field_type $relations
	 */
	public function setRelations($relations) {
		$this->relations = $relations;
	}

	public function toXML(){
		
		return $this->getExporter()->toXML();
	}
	
	public function toJSON(){
		return $this->getExporter()->toJson();
	}
	
	public function toArray($exclude = true){
		$result = array();
		foreach($this as $key => $value){
			if($exclude){
				if ($key!="id"){
					$result[$key] = $value;
				}
			}else{
				$result[$key] = $value;
			}
		}
			
		return $result;
	}
	
	
	/**
	 * 
	 * Gets Class Exporter
	 * @return Code_Class_Exporter
	 */
	public function getExporter(){
		return Code_Class_Exporter::getInstance($this);
	}
	
	

}