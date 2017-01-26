# VericredClient
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



This PHP package is automatically generated by the [Swagger Codegen](https://github.com/swagger-api/swagger-codegen) project:

- API version: 1.0.0
- Package version: 0.0.7
- Build package: class io.swagger.codegen.languages.PhpClientCodegen

## Requirements

PHP 5.4.0 and later

## Installation & Usage
### Composer

To install the bindings via [Composer](http://getcomposer.org/), add the following to `composer.json`:

```
{
  "repositories": [
    {
      "type": "git",
      "url": "https://github.com/Vericred/VericredClient.git"
    }
  ],
  "require": {
    "Vericred/VericredClient": "*@dev"
  }
}
```

Then run `composer install`

### Manual Installation

Download the files and include `autoload.php`:

```php
    require_once('/path/to/VericredClient/autoload.php');
```

## Tests

To run the unit tests:

```
composer install
./vendor/bin/phpunit lib/Tests
```

## Getting Started

Please follow the [installation procedure](#installation--usage) and then run the following:

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure API key authorization: Vericred-Api-Key
Vericred\Client\Configuration::getDefaultConfiguration()->setApiKey('Vericred-Api-Key', 'YOUR_API_KEY');
// Uncomment below to setup prefix (e.g. Bearer) for API key, if needed
// Vericred\Client\Configuration::getDefaultConfiguration()->setApiKeyPrefix('Vericred-Api-Key', 'Bearer');

$api_instance = new Vericred\Client\Api\DrugPackagesApi();
$formulary_id = "123"; // string | ID of the Formulary in question
$ndc_package_code = "07777-3105-01"; // string | ID of the DrugPackage in question

try {
    $result = $api_instance->showFormularyDrugPackageCoverage($formulary_id, $ndc_package_code);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling DrugPackagesApi->showFormularyDrugPackageCoverage: ', $e->getMessage(), PHP_EOL;
}

?>
```

## Documentation for API Endpoints

All URIs are relative to *https://api.vericred.com/*

Class | Method | HTTP request | Description
------------ | ------------- | ------------- | -------------
*DrugPackagesApi* | [**showFormularyDrugPackageCoverage**](docs/Api/DrugPackagesApi.md#showformularydrugpackagecoverage) | **GET** /formularies/{formulary_id}/drug_packages/{ndc_package_code} | Formulary Drug Package Search
*DrugsApi* | [**getDrugCoverages**](docs/Api/DrugsApi.md#getdrugcoverages) | **GET** /drug_packages/{ndc_package_code}/coverages | Search for DrugCoverages
*DrugsApi* | [**listDrugs**](docs/Api/DrugsApi.md#listdrugs) | **GET** /drugs | Drug Search
*NetworkSizesApi* | [**listStateNetworkSizes**](docs/Api/NetworkSizesApi.md#liststatenetworksizes) | **GET** /states/{state_id}/network_sizes | State Network Sizes
*NetworkSizesApi* | [**searchNetworkSizes**](docs/Api/NetworkSizesApi.md#searchnetworksizes) | **POST** /network_sizes/search | Network Sizes
*NetworksApi* | [**listNetworks**](docs/Api/NetworksApi.md#listnetworks) | **GET** /networks | Networks
*NetworksApi* | [**showNetwork**](docs/Api/NetworksApi.md#shownetwork) | **GET** /networks/{id} | Network Details
*PlansApi* | [**findPlans**](docs/Api/PlansApi.md#findplans) | **POST** /plans/search | Find Plans
*PlansApi* | [**showPlan**](docs/Api/PlansApi.md#showplan) | **GET** /plans/{id} | Show Plan
*ProvidersApi* | [**getProvider**](docs/Api/ProvidersApi.md#getprovider) | **GET** /providers/{npi} | Find a Provider
*ProvidersApi* | [**getProviders**](docs/Api/ProvidersApi.md#getproviders) | **POST** /providers/search | Find Providers
*ProvidersApi* | [**getProviders_0**](docs/Api/ProvidersApi.md#getproviders_0) | **POST** /providers/search/geocode | Find Providers
*ZipCountiesApi* | [**getZipCounties**](docs/Api/ZipCountiesApi.md#getzipcounties) | **GET** /zip_counties | Search for Zip Counties


## Documentation For Models

 - [Applicant](docs/Model/Applicant.md)
 - [Base](docs/Model/Base.md)
 - [Carrier](docs/Model/Carrier.md)
 - [CarrierSubsidiary](docs/Model/CarrierSubsidiary.md)
 - [County](docs/Model/County.md)
 - [CountyBulk](docs/Model/CountyBulk.md)
 - [Drug](docs/Model/Drug.md)
 - [DrugCoverage](docs/Model/DrugCoverage.md)
 - [DrugCoverageResponse](docs/Model/DrugCoverageResponse.md)
 - [DrugPackage](docs/Model/DrugPackage.md)
 - [DrugSearchResponse](docs/Model/DrugSearchResponse.md)
 - [Formulary](docs/Model/Formulary.md)
 - [FormularyDrugPackageResponse](docs/Model/FormularyDrugPackageResponse.md)
 - [FormularyResponse](docs/Model/FormularyResponse.md)
 - [Meta](docs/Model/Meta.md)
 - [Network](docs/Model/Network.md)
 - [NetworkDetails](docs/Model/NetworkDetails.md)
 - [NetworkDetailsResponse](docs/Model/NetworkDetailsResponse.md)
 - [NetworkSearchResponse](docs/Model/NetworkSearchResponse.md)
 - [NetworkSize](docs/Model/NetworkSize.md)
 - [Plan](docs/Model/Plan.md)
 - [PlanCounty](docs/Model/PlanCounty.md)
 - [PlanCountyBulk](docs/Model/PlanCountyBulk.md)
 - [PlanSearchResponse](docs/Model/PlanSearchResponse.md)
 - [PlanSearchResponseMeta](docs/Model/PlanSearchResponseMeta.md)
 - [PlanSearchResult](docs/Model/PlanSearchResult.md)
 - [PlanShowResponse](docs/Model/PlanShowResponse.md)
 - [Pricing](docs/Model/Pricing.md)
 - [Provider](docs/Model/Provider.md)
 - [ProviderDetails](docs/Model/ProviderDetails.md)
 - [ProviderGeocode](docs/Model/ProviderGeocode.md)
 - [ProviderShowResponse](docs/Model/ProviderShowResponse.md)
 - [ProvidersGeocodeResponse](docs/Model/ProvidersGeocodeResponse.md)
 - [ProvidersSearchResponse](docs/Model/ProvidersSearchResponse.md)
 - [RatingArea](docs/Model/RatingArea.md)
 - [RequestPlanFind](docs/Model/RequestPlanFind.md)
 - [RequestPlanFindApplicant](docs/Model/RequestPlanFindApplicant.md)
 - [RequestPlanFindDrugPackage](docs/Model/RequestPlanFindDrugPackage.md)
 - [RequestPlanFindProvider](docs/Model/RequestPlanFindProvider.md)
 - [RequestProvidersSearch](docs/Model/RequestProvidersSearch.md)
 - [ServiceArea](docs/Model/ServiceArea.md)
 - [ServiceAreaZipCounty](docs/Model/ServiceAreaZipCounty.md)
 - [State](docs/Model/State.md)
 - [StateNetworkSizeRequest](docs/Model/StateNetworkSizeRequest.md)
 - [StateNetworkSizeResponse](docs/Model/StateNetworkSizeResponse.md)
 - [VendoredPlanBulk](docs/Model/VendoredPlanBulk.md)
 - [ZipCode](docs/Model/ZipCode.md)
 - [ZipCountiesResponse](docs/Model/ZipCountiesResponse.md)
 - [ZipCounty](docs/Model/ZipCounty.md)
 - [ZipCountyBulk](docs/Model/ZipCountyBulk.md)
 - [ZipCountyResponse](docs/Model/ZipCountyResponse.md)


## Documentation For Authorization


## Vericred-Api-Key

- **Type**: API key
- **API key parameter name**: Vericred-Api-Key
- **Location**: HTTP header


## Author




