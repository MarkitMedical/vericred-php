<?php
/**
 * Applicant
 *
 * PHP version 5
 *
 * @category Class
 * @package  Vericred\Client
 * @author   http://github.com/swagger-api/swagger-codegen
 * @license  http://www.apache.org/licenses/LICENSE-2.0 Apache Licene v2
 * @link     https://github.com/swagger-api/swagger-codegen
 */
/**
 *  Copyright 2016 SmartBear Software
 *
 *  Licensed under the Apache License, Version 2.0 (the "License");
 *  you may not use this file except in compliance with the License.
 *  You may obtain a copy of the License at
 *
 *      http://www.apache.org/licenses/LICENSE-2.0
 *
 *  Unless required by applicable law or agreed to in writing, software
 *  distributed under the License is distributed on an "AS IS" BASIS,
 *  WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 *  See the License for the specific language governing permissions and
 *  limitations under the License.
 */
/**
 * NOTE: This class is auto generated by the swagger code generator program.
 * https://github.com/swagger-api/swagger-codegen
 * Do not edit the class manually.
 */

namespace Swagger\Client\Model;

use \ArrayAccess;
/**
 * Applicant Class Doc Comment
 *
 * @category    Class
 * @description 
 * @package     Vericred\Client
 * @author      http://github.com/swagger-api/swagger-codegen
 * @license     http://www.apache.org/licenses/LICENSE-2.0 Apache Licene v2
 * @link        https://github.com/swagger-api/swagger-codegen
 */
class Applicant implements ArrayAccess
{
    /**
      * The original name of the model.
      * @var string
      */
    static $swaggerModelName = 'Applicant';

    /**
      * Array of property to type mappings. Used for (de)serialization 
      * @var string[]
      */
    static $swaggerTypes = array(
        'id' => 'int',
        'dob' => '\DateTime',
        'member_id' => 'string',
        'name' => 'string',
        'relationship' => 'string',
        'smoker' => 'bool',
        'ssn' => 'string'
    );
  
    static function swaggerTypes() {
        return self::$swaggerTypes;
    }

    /** 
      * Array of attributes where the key is the local name, and the value is the original name
      * @var string[] 
      */
    static $attributeMap = array(
        'id' => 'id',
        'dob' => 'dob',
        'member_id' => 'member_id',
        'name' => 'name',
        'relationship' => 'relationship',
        'smoker' => 'smoker',
        'ssn' => 'ssn'
    );
  
    static function attributeMap() {
        return self::$attributeMap;
    }

    /**
      * Array of attributes to setter functions (for deserialization of responses)
      * @var string[]
      */
    static $setters = array(
        'id' => 'setId',
        'dob' => 'setDob',
        'member_id' => 'setMemberId',
        'name' => 'setName',
        'relationship' => 'setRelationship',
        'smoker' => 'setSmoker',
        'ssn' => 'setSsn'
    );
  
    static function setters() {
        return self::$setters;
    }

    /**
      * Array of attributes to getter functions (for serialization of requests)
      * @var string[]
      */
    static $getters = array(
        'id' => 'getId',
        'dob' => 'getDob',
        'member_id' => 'getMemberId',
        'name' => 'getName',
        'relationship' => 'getRelationship',
        'smoker' => 'getSmoker',
        'ssn' => 'getSsn'
    );
  
    static function getters() {
        return self::$getters;
    }

    /**
      * $id Primary key
      * @var int
      */
    protected $id;
    /**
      * $dob Date of Birth
      * @var \DateTime
      */
    protected $dob;
    /**
      * $member_id Foreign key to members
      * @var string
      */
    protected $member_id;
    /**
      * $name Full name of the Applicant
      * @var string
      */
    protected $name;
    /**
      * $relationship Relationship of the Applicant to the Member
      * @var string
      */
    protected $relationship;
    /**
      * $smoker Does the Applicant smoke?
      * @var bool
      */
    protected $smoker;
    /**
      * $ssn Applicant's Social Security Number
      * @var string
      */
    protected $ssn;

    /**
     * Constructor
     * @param mixed[] $data Associated array of property value initalizing the model
     */
    public function __construct(array $data = null)
    {
        
        
        if ($data != null) {
            $this->id = $data["id"];
            $this->dob = $data["dob"];
            $this->member_id = $data["member_id"];
            $this->name = $data["name"];
            $this->relationship = $data["relationship"];
            $this->smoker = $data["smoker"];
            $this->ssn = $data["ssn"];
        }
    }
    /**
     * Gets id
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }
  
    /**
     * Sets id
     * @param int $id Primary key
     * @return $this
     */
    public function setId($id)
    {
        
        $this->id = $id;
        return $this;
    }
    /**
     * Gets dob
     * @return \DateTime
     */
    public function getDob()
    {
        return $this->dob;
    }
  
    /**
     * Sets dob
     * @param \DateTime $dob Date of Birth
     * @return $this
     */
    public function setDob($dob)
    {
        
        $this->dob = $dob;
        return $this;
    }
    /**
     * Gets member_id
     * @return string
     */
    public function getMemberId()
    {
        return $this->member_id;
    }
  
    /**
     * Sets member_id
     * @param string $member_id Foreign key to members
     * @return $this
     */
    public function setMemberId($member_id)
    {
        
        $this->member_id = $member_id;
        return $this;
    }
    /**
     * Gets name
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }
  
    /**
     * Sets name
     * @param string $name Full name of the Applicant
     * @return $this
     */
    public function setName($name)
    {
        
        $this->name = $name;
        return $this;
    }
    /**
     * Gets relationship
     * @return string
     */
    public function getRelationship()
    {
        return $this->relationship;
    }
  
    /**
     * Sets relationship
     * @param string $relationship Relationship of the Applicant to the Member
     * @return $this
     */
    public function setRelationship($relationship)
    {
        
        $this->relationship = $relationship;
        return $this;
    }
    /**
     * Gets smoker
     * @return bool
     */
    public function getSmoker()
    {
        return $this->smoker;
    }
  
    /**
     * Sets smoker
     * @param bool $smoker Does the Applicant smoke?
     * @return $this
     */
    public function setSmoker($smoker)
    {
        
        $this->smoker = $smoker;
        return $this;
    }
    /**
     * Gets ssn
     * @return string
     */
    public function getSsn()
    {
        return $this->ssn;
    }
  
    /**
     * Sets ssn
     * @param string $ssn Applicant's Social Security Number
     * @return $this
     */
    public function setSsn($ssn)
    {
        
        $this->ssn = $ssn;
        return $this;
    }
    /**
     * Returns true if offset exists. False otherwise.
     * @param  integer $offset Offset 
     * @return boolean
     */
    public function offsetExists($offset)
    {
        return isset($this->$offset);
    }
  
    /**
     * Gets offset.
     * @param  integer $offset Offset 
     * @return mixed 
     */
    public function offsetGet($offset)
    {
        return $this->$offset;
    }
  
    /**
     * Sets value based on offset.
     * @param  integer $offset Offset 
     * @param  mixed   $value  Value to be set
     * @return void
     */
    public function offsetSet($offset, $value)
    {
        $this->$offset = $value;
    }
  
    /**
     * Unsets offset.
     * @param  integer $offset Offset 
     * @return void
     */
    public function offsetUnset($offset)
    {
        unset($this->$offset);
    }
  
    /**
     * Gets the string presentation of the object
     * @return string
     */
    public function __toString()
    {
        if (defined('JSON_PRETTY_PRINT')) { // use JSON pretty print
            return json_encode(\Vericred\Client\ObjectSerializer::sanitizeForSerialization($this), JSON_PRETTY_PRINT);
        }

        return json_encode(\Vericred\Client\ObjectSerializer::sanitizeForSerialization($this));
    }
}
