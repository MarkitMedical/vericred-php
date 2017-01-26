<?php
/**
 * Pricing
 *
 * PHP version 5
 *
 * @category Class
 * @package  Vericred\Client
 * @author   http://github.com/swagger-api/swagger-codegen
 * @license  http://www.apache.org/licenses/LICENSE-2.0 Apache Licene v2
 * @link     https://github.com/swagger-api/swagger-codegen
 */

/*
 * Vericred API
 *
 */

/*
 Vericred's API allows you to search for Health Plans that a specific doctor
accepts.

## Getting Started

Visit our [Developer Portal](https://developers.vericred.com) to
create an account.

Once you have created an account, you can create one Application for
Production and another for our Sandbox (select the appropriate Plan when
you create the Application).

## SDKs

Our API follows standard REST conventions, so you can use any HTTP client
to integrate with us. You will likely find it easier to use one of our
[autogenerated SDKs](https://github.com/vericred/?query=vericred-),
which we make available for several common programming languages.

## Authentication

To authenticate, pass the API Key you created in the Developer Portal as
a `Vericred-Api-Key` header.

`curl -H 'Vericred-Api-Key: YOUR_KEY' "https://api.vericred.com/providers?search_term=Foo&zip_code=11215"`

## Versioning

Vericred's API default to the latest version.  However, if you need a specific
version, you can request it with an `Accept-Version` header.

The current version is `v3`.  Previous versions are `v1` and `v2`.

`curl -H 'Vericred-Api-Key: YOUR_KEY' -H 'Accept-Version: v2' "https://api.vericred.com/providers?search_term=Foo&zip_code=11215"`

## Pagination

Endpoints that accept `page` and `per_page` parameters are paginated. They expose
four additional fields that contain data about your position in the response,
namely `Total`, `Per-Page`, `Link`, and `Page` as described in [RFC-5988](https://tools.ietf.org/html/rfc5988).

For example, to display 5 results per page and view the second page of a
`GET` to `/networks`, your final request would be `GET /networks?....page=2&per_page=5`.

## Sideloading

When we return multiple levels of an object graph (e.g. `Provider`s and their `State`s
we sideload the associated data.  In this example, we would provide an Array of
`State`s and a `state_id` for each provider.  This is done primarily to reduce the
payload size since many of the `Provider`s will share a `State`

```
{
  providers: [{ id: 1, state_id: 1}, { id: 2, state_id: 1 }],
  states: [{ id: 1, code: 'NY' }]
}
```

If you need the second level of the object graph, you can just match the
corresponding id.

## Selecting specific data

All endpoints allow you to specify which fields you would like to return.
This allows you to limit the response to contain only the data you need.

For example, let's take a request that returns the following JSON by default

```
{
  provider: {
    id: 1,
    name: 'John',
    phone: '1234567890',
    field_we_dont_care_about: 'value_we_dont_care_about'
  },
  states: [{
    id: 1,
    name: 'New York',
    code: 'NY',
    field_we_dont_care_about: 'value_we_dont_care_about'
  }]
}
```

To limit our results to only return the fields we care about, we specify the
`select` query string parameter for the corresponding fields in the JSON
document.

In this case, we want to select `name` and `phone` from the `provider` key,
so we would add the parameters `select=provider.name,provider.phone`.
We also want the `name` and `code` from the `states` key, so we would
add the parameters `select=states.name,staes.code`.  The id field of
each document is always returned whether or not it is requested.

Our final request would be `GET /providers/12345?select=provider.name,provider.phone,states.name,states.code`

The response would be

```
{
  provider: {
    id: 1,
    name: 'John',
    phone: '1234567890'
  },
  states: [{
    id: 1,
    name: 'New York',
    code: 'NY'
  }]
}
```

## Benefits summary format
Benefit cost-share strings are formatted to capture:
 * Network tiers
 * Compound or conditional cost-share
 * Limits on the cost-share
 * Benefit-specific maximum out-of-pocket costs

**Example #1**
As an example, we would represent [this Summary of Benefits &amp; Coverage](https://s3.amazonaws.com/vericred-data/SBC/2017/33602TX0780032.pdf) as:

* **Hospital stay facility fees**:
  - Network Provider: `$400 copay/admit plus 20% coinsurance`
  - Out-of-Network Provider: `$1,500 copay/admit plus 50% coinsurance`
  - Vericred's format for this benefit: `In-Network: $400 before deductible then 20% after deductible / Out-of-Network: $1,500 before deductible then 50% after deductible`

* **Rehabilitation services:**
  - Network Provider: `20% coinsurance`
  - Out-of-Network Provider: `50% coinsurance`
  - Limitations & Exceptions: `35 visit maximum per benefit period combined with Chiropractic care.`
  - Vericred's format for this benefit: `In-Network: 20% after deductible / Out-of-Network: 50% after deductible | limit: 35 visit(s) per Benefit Period`

**Example #2**
In [this other Summary of Benefits &amp; Coverage](https://s3.amazonaws.com/vericred-data/SBC/2017/40733CA0110568.pdf), the **specialty_drugs** cost-share has a maximum out-of-pocket for in-network pharmacies.
* **Specialty drugs:**
  - Network Provider: `40% coinsurance up to a $500 maximum for up to a 30 day supply`
  - Out-of-Network Provider `Not covered`
  - Vericred's format for this benefit: `In-Network: 40% after deductible, up to $500 per script / Out-of-Network: 100%`

**BNF**

Here's a description of the benefits summary string, represented as a context-free grammar:

```
<cost-share>     ::= <tier> <opt-num-prefix> <value> <opt-per-unit> <deductible> <tier-limit> "/" <tier> <opt-num-prefix> <value> <opt-per-unit> <deductible> "|" <benefit-limit>
<tier>           ::= "In-Network:" | "In-Network-Tier-2:" | "Out-of-Network:"
<opt-num-prefix> ::= "first" <num> <unit> | ""
<unit>           ::= "day(s)" | "visit(s)" | "exam(s)" | "item(s)"
<value>          ::= <ddct_moop> | <copay> | <coinsurance> | <compound> | "unknown" | "Not Applicable"
<compound>       ::= <copay> <deductible> "then" <coinsurance> <deductible> | <copay> <deductible> "then" <copay> <deductible> | <coinsurance> <deductible> "then" <coinsurance> <deductible>
<copay>          ::= "$" <num>
<coinsurace>     ::= <num> "%"
<ddct_moop>      ::= <copay> | "Included in Medical" | "Unlimited"
<opt-per-unit>   ::= "per day" | "per visit" | "per stay" | ""
<deductible>     ::= "before deductible" | "after deductible" | ""
<tier-limit>     ::= ", " <limit> | ""
<benefit-limit>  ::= <limit> | ""
```


*/


/* OpenAPI spec version: 1.0.0
 * 
 * Generated by: https://github.com/swagger-api/swagger-codegen.git
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *      http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

/**
 * NOTE: This class is auto generated by the swagger code generator program.
 * https://github.com/swagger-api/swagger-codegen
 * Do not edit the class manually.
 */

namespace Swagger\Client\Model;

use \ArrayAccess;

/**
 * Pricing Class Doc Comment
 *
 * @category    Class */
/** 
 * @package     Vericred\Client
 * @author      http://github.com/swagger-api/swagger-codegen
 * @license     http://www.apache.org/licenses/LICENSE-2.0 Apache Licene v2
 * @link        https://github.com/swagger-api/swagger-codegen
 */
class Pricing implements ArrayAccess
{
    /**
      * The original name of the model.
      * @var string
      */
    protected static $swaggerModelName = 'Pricing';

    /**
      * Array of property to type mappings. Used for (de)serialization
      * @var string[]
      */
    protected static $swaggerTypes = array(
        'age' => 'int',
        'effective_date' => '\DateTime',
        'expiration_date' => '\DateTime',
        'plan_id' => 'int',
        'premium_child_only' => 'float',
        'premium_family' => 'float',
        'premium_single' => 'float',
        'premium_single_and_children' => 'float',
        'premium_single_and_spouse' => 'float',
        'premium_single_smoker' => 'float',
        'rating_area_id' => 'string',
        'premium_source' => 'string',
        'updated_at' => 'string'
    );

    public static function swaggerTypes()
    {
        return self::$swaggerTypes;
    }

    /**
     * Array of attributes where the key is the local name, and the value is the original name
     * @var string[]
     */
    protected static $attributeMap = array(
        'age' => 'age',
        'effective_date' => 'effective_date',
        'expiration_date' => 'expiration_date',
        'plan_id' => 'plan_id',
        'premium_child_only' => 'premium_child_only',
        'premium_family' => 'premium_family',
        'premium_single' => 'premium_single',
        'premium_single_and_children' => 'premium_single_and_children',
        'premium_single_and_spouse' => 'premium_single_and_spouse',
        'premium_single_smoker' => 'premium_single_smoker',
        'rating_area_id' => 'rating_area_id',
        'premium_source' => 'premium_source',
        'updated_at' => 'updated_at'
    );

    public static function attributeMap()
    {
        return self::$attributeMap;
    }

    /**
     * Array of attributes to setter functions (for deserialization of responses)
     * @var string[]
     */
    protected static $setters = array(
        'age' => 'setAge',
        'effective_date' => 'setEffectiveDate',
        'expiration_date' => 'setExpirationDate',
        'plan_id' => 'setPlanId',
        'premium_child_only' => 'setPremiumChildOnly',
        'premium_family' => 'setPremiumFamily',
        'premium_single' => 'setPremiumSingle',
        'premium_single_and_children' => 'setPremiumSingleAndChildren',
        'premium_single_and_spouse' => 'setPremiumSingleAndSpouse',
        'premium_single_smoker' => 'setPremiumSingleSmoker',
        'rating_area_id' => 'setRatingAreaId',
        'premium_source' => 'setPremiumSource',
        'updated_at' => 'setUpdatedAt'
    );

    public static function setters()
    {
        return self::$setters;
    }

    /**
     * Array of attributes to getter functions (for serialization of requests)
     * @var string[]
     */
    protected static $getters = array(
        'age' => 'getAge',
        'effective_date' => 'getEffectiveDate',
        'expiration_date' => 'getExpirationDate',
        'plan_id' => 'getPlanId',
        'premium_child_only' => 'getPremiumChildOnly',
        'premium_family' => 'getPremiumFamily',
        'premium_single' => 'getPremiumSingle',
        'premium_single_and_children' => 'getPremiumSingleAndChildren',
        'premium_single_and_spouse' => 'getPremiumSingleAndSpouse',
        'premium_single_smoker' => 'getPremiumSingleSmoker',
        'rating_area_id' => 'getRatingAreaId',
        'premium_source' => 'getPremiumSource',
        'updated_at' => 'getUpdatedAt'
    );

    public static function getters()
    {
        return self::$getters;
    }

    

    

    /**
     * Associative array for storing property values
     * @var mixed[]
     */
    protected $container = array();

    /**
     * Constructor
     * @param mixed[] $data Associated array of property values initializing the model
     */
    public function __construct(array $data = null)
    {
        $this->container['age'] = isset($data['age']) ? $data['age'] : null;
        $this->container['effective_date'] = isset($data['effective_date']) ? $data['effective_date'] : null;
        $this->container['expiration_date'] = isset($data['expiration_date']) ? $data['expiration_date'] : null;
        $this->container['plan_id'] = isset($data['plan_id']) ? $data['plan_id'] : null;
        $this->container['premium_child_only'] = isset($data['premium_child_only']) ? $data['premium_child_only'] : null;
        $this->container['premium_family'] = isset($data['premium_family']) ? $data['premium_family'] : null;
        $this->container['premium_single'] = isset($data['premium_single']) ? $data['premium_single'] : null;
        $this->container['premium_single_and_children'] = isset($data['premium_single_and_children']) ? $data['premium_single_and_children'] : null;
        $this->container['premium_single_and_spouse'] = isset($data['premium_single_and_spouse']) ? $data['premium_single_and_spouse'] : null;
        $this->container['premium_single_smoker'] = isset($data['premium_single_smoker']) ? $data['premium_single_smoker'] : null;
        $this->container['rating_area_id'] = isset($data['rating_area_id']) ? $data['rating_area_id'] : null;
        $this->container['premium_source'] = isset($data['premium_source']) ? $data['premium_source'] : null;
        $this->container['updated_at'] = isset($data['updated_at']) ? $data['updated_at'] : null;
    }

    /**
     * show all the invalid properties with reasons.
     *
     * @return array invalid properties with reasons
     */
    public function listInvalidProperties()
    {
        $invalid_properties = array();
        return $invalid_properties;
    }

    /**
     * validate all the properties in the model
     * return true if all passed
     *
     * @return bool True if all properteis are valid
     */
    public function valid()
    {
        return true;
    }


    /**
     * Gets age
     * @return int
     */
    public function getAge()
    {
        return $this->container['age'];
    }

    /**
     * Sets age
     * @param int $age Age of applicant
     * @return $this
     */
    public function setAge($age)
    {
        $this->container['age'] = $age;

        return $this;
    }

    /**
     * Gets effective_date
     * @return \DateTime
     */
    public function getEffectiveDate()
    {
        return $this->container['effective_date'];
    }

    /**
     * Sets effective_date
     * @param \DateTime $effective_date Effective date of plan
     * @return $this
     */
    public function setEffectiveDate($effective_date)
    {
        $this->container['effective_date'] = $effective_date;

        return $this;
    }

    /**
     * Gets expiration_date
     * @return \DateTime
     */
    public function getExpirationDate()
    {
        return $this->container['expiration_date'];
    }

    /**
     * Sets expiration_date
     * @param \DateTime $expiration_date Plan expiration date
     * @return $this
     */
    public function setExpirationDate($expiration_date)
    {
        $this->container['expiration_date'] = $expiration_date;

        return $this;
    }

    /**
     * Gets plan_id
     * @return int
     */
    public function getPlanId()
    {
        return $this->container['plan_id'];
    }

    /**
     * Sets plan_id
     * @param int $plan_id Foreign key to plans
     * @return $this
     */
    public function setPlanId($plan_id)
    {
        $this->container['plan_id'] = $plan_id;

        return $this;
    }

    /**
     * Gets premium_child_only
     * @return float
     */
    public function getPremiumChildOnly()
    {
        return $this->container['premium_child_only'];
    }

    /**
     * Sets premium_child_only
     * @param float $premium_child_only Child-only premium
     * @return $this
     */
    public function setPremiumChildOnly($premium_child_only)
    {
        $this->container['premium_child_only'] = $premium_child_only;

        return $this;
    }

    /**
     * Gets premium_family
     * @return float
     */
    public function getPremiumFamily()
    {
        return $this->container['premium_family'];
    }

    /**
     * Sets premium_family
     * @param float $premium_family Family premium
     * @return $this
     */
    public function setPremiumFamily($premium_family)
    {
        $this->container['premium_family'] = $premium_family;

        return $this;
    }

    /**
     * Gets premium_single
     * @return float
     */
    public function getPremiumSingle()
    {
        return $this->container['premium_single'];
    }

    /**
     * Sets premium_single
     * @param float $premium_single Single-person premium
     * @return $this
     */
    public function setPremiumSingle($premium_single)
    {
        $this->container['premium_single'] = $premium_single;

        return $this;
    }

    /**
     * Gets premium_single_and_children
     * @return float
     */
    public function getPremiumSingleAndChildren()
    {
        return $this->container['premium_single_and_children'];
    }

    /**
     * Sets premium_single_and_children
     * @param float $premium_single_and_children Single person including children premium
     * @return $this
     */
    public function setPremiumSingleAndChildren($premium_single_and_children)
    {
        $this->container['premium_single_and_children'] = $premium_single_and_children;

        return $this;
    }

    /**
     * Gets premium_single_and_spouse
     * @return float
     */
    public function getPremiumSingleAndSpouse()
    {
        return $this->container['premium_single_and_spouse'];
    }

    /**
     * Sets premium_single_and_spouse
     * @param float $premium_single_and_spouse Person with spouse premium
     * @return $this
     */
    public function setPremiumSingleAndSpouse($premium_single_and_spouse)
    {
        $this->container['premium_single_and_spouse'] = $premium_single_and_spouse;

        return $this;
    }

    /**
     * Gets premium_single_smoker
     * @return float
     */
    public function getPremiumSingleSmoker()
    {
        return $this->container['premium_single_smoker'];
    }

    /**
     * Sets premium_single_smoker
     * @param float $premium_single_smoker Premium for single smoker
     * @return $this
     */
    public function setPremiumSingleSmoker($premium_single_smoker)
    {
        $this->container['premium_single_smoker'] = $premium_single_smoker;

        return $this;
    }

    /**
     * Gets rating_area_id
     * @return string
     */
    public function getRatingAreaId()
    {
        return $this->container['rating_area_id'];
    }

    /**
     * Sets rating_area_id
     * @param string $rating_area_id Foreign key to rating areas
     * @return $this
     */
    public function setRatingAreaId($rating_area_id)
    {
        $this->container['rating_area_id'] = $rating_area_id;

        return $this;
    }

    /**
     * Gets premium_source
     * @return string
     */
    public function getPremiumSource()
    {
        return $this->container['premium_source'];
    }

    /**
     * Sets premium_source
     * @param string $premium_source Where was this pricing data extracted from?
     * @return $this
     */
    public function setPremiumSource($premium_source)
    {
        $this->container['premium_source'] = $premium_source;

        return $this;
    }

    /**
     * Gets updated_at
     * @return string
     */
    public function getUpdatedAt()
    {
        return $this->container['updated_at'];
    }

    /**
     * Sets updated_at
     * @param string $updated_at Time when pricing was last updated
     * @return $this
     */
    public function setUpdatedAt($updated_at)
    {
        $this->container['updated_at'] = $updated_at;

        return $this;
    }
    /**
     * Returns true if offset exists. False otherwise.
     * @param  integer $offset Offset
     * @return boolean
     */
    public function offsetExists($offset)
    {
        return isset($this->container[$offset]);
    }

    /**
     * Gets offset.
     * @param  integer $offset Offset
     * @return mixed
     */
    public function offsetGet($offset)
    {
        return isset($this->container[$offset]) ? $this->container[$offset] : null;
    }

    /**
     * Sets value based on offset.
     * @param  integer $offset Offset
     * @param  mixed   $value  Value to be set
     * @return void
     */
    public function offsetSet($offset, $value)
    {
        if (is_null($offset)) {
            $this->container[] = $value;
        } else {
            $this->container[$offset] = $value;
        }
    }

    /**
     * Unsets offset.
     * @param  integer $offset Offset
     * @return void
     */
    public function offsetUnset($offset)
    {
        unset($this->container[$offset]);
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


