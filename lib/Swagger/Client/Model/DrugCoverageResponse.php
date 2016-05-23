<?php
/**
 * DrugCoverageResponse
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
 * DrugCoverageResponse Class Doc Comment
 *
 * @category    Class
 * @description 
 * @package     Vericred\Client
 * @author      http://github.com/swagger-api/swagger-codegen
 * @license     http://www.apache.org/licenses/LICENSE-2.0 Apache Licene v2
 * @link        https://github.com/swagger-api/swagger-codegen
 */
class DrugCoverageResponse implements ArrayAccess
{
    /**
      * The original name of the model.
      * @var string
      */
    static $swaggerModelName = 'DrugCoverageResponse';

    /**
      * Array of property to type mappings. Used for (de)serialization 
      * @var string[]
      */
    static $swaggerTypes = array(
        'meta' => '\Swagger\Client\Model\Meta',
        'drug_coverages' => '\Swagger\Client\Model\DrugCoverage[]',
        'drugs' => '\Swagger\Client\Model\Drug[]',
        'drug_packages' => '\Swagger\Client\Model\DrugPackage[]'
    );
  
    static function swaggerTypes() {
        return self::$swaggerTypes;
    }

    /** 
      * Array of attributes where the key is the local name, and the value is the original name
      * @var string[] 
      */
    static $attributeMap = array(
        'meta' => 'meta',
        'drug_coverages' => 'drug_coverages',
        'drugs' => 'drugs',
        'drug_packages' => 'drug_packages'
    );
  
    static function attributeMap() {
        return self::$attributeMap;
    }

    /**
      * Array of attributes to setter functions (for deserialization of responses)
      * @var string[]
      */
    static $setters = array(
        'meta' => 'setMeta',
        'drug_coverages' => 'setDrugCoverages',
        'drugs' => 'setDrugs',
        'drug_packages' => 'setDrugPackages'
    );
  
    static function setters() {
        return self::$setters;
    }

    /**
      * Array of attributes to getter functions (for serialization of requests)
      * @var string[]
      */
    static $getters = array(
        'meta' => 'getMeta',
        'drug_coverages' => 'getDrugCoverages',
        'drugs' => 'getDrugs',
        'drug_packages' => 'getDrugPackages'
    );
  
    static function getters() {
        return self::$getters;
    }

    /**
      * $meta Metadata for query
      * @var \Swagger\Client\Model\Meta
      */
    protected $meta;
    /**
      * $drug_coverages DrugCoverage search results
      * @var \Swagger\Client\Model\DrugCoverage[]
      */
    protected $drug_coverages;
    /**
      * $drugs Drug
      * @var \Swagger\Client\Model\Drug[]
      */
    protected $drugs;
    /**
      * $drug_packages Drug Packages
      * @var \Swagger\Client\Model\DrugPackage[]
      */
    protected $drug_packages;

    /**
     * Constructor
     * @param mixed[] $data Associated array of property value initalizing the model
     */
    public function __construct(array $data = null)
    {
        
        
        if ($data != null) {
            $this->meta = $data["meta"];
            $this->drug_coverages = $data["drug_coverages"];
            $this->drugs = $data["drugs"];
            $this->drug_packages = $data["drug_packages"];
        }
    }
    /**
     * Gets meta
     * @return \Swagger\Client\Model\Meta
     */
    public function getMeta()
    {
        return $this->meta;
    }
  
    /**
     * Sets meta
     * @param \Swagger\Client\Model\Meta $meta Metadata for query
     * @return $this
     */
    public function setMeta($meta)
    {
        
        $this->meta = $meta;
        return $this;
    }
    /**
     * Gets drug_coverages
     * @return \Swagger\Client\Model\DrugCoverage[]
     */
    public function getDrugCoverages()
    {
        return $this->drug_coverages;
    }
  
    /**
     * Sets drug_coverages
     * @param \Swagger\Client\Model\DrugCoverage[] $drug_coverages DrugCoverage search results
     * @return $this
     */
    public function setDrugCoverages($drug_coverages)
    {
        
        $this->drug_coverages = $drug_coverages;
        return $this;
    }
    /**
     * Gets drugs
     * @return \Swagger\Client\Model\Drug[]
     */
    public function getDrugs()
    {
        return $this->drugs;
    }
  
    /**
     * Sets drugs
     * @param \Swagger\Client\Model\Drug[] $drugs Drug
     * @return $this
     */
    public function setDrugs($drugs)
    {
        
        $this->drugs = $drugs;
        return $this;
    }
    /**
     * Gets drug_packages
     * @return \Swagger\Client\Model\DrugPackage[]
     */
    public function getDrugPackages()
    {
        return $this->drug_packages;
    }
  
    /**
     * Sets drug_packages
     * @param \Swagger\Client\Model\DrugPackage[] $drug_packages Drug Packages
     * @return $this
     */
    public function setDrugPackages($drug_packages)
    {
        
        $this->drug_packages = $drug_packages;
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