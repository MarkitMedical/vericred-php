# Vericred\Client\DrugsApi

All URIs are relative to *https://api.vericred.com/*

Method | HTTP request | Description
------------- | ------------- | -------------
[**getDrugCoverages**](DrugsApi.md#getDrugCoverages) | **GET** /drug_packages/{ndc_package_code}/coverages | Search for DrugCoverages
[**listDrugs**](DrugsApi.md#listDrugs) | **GET** /drugs | Drug Search


# **getDrugCoverages**
> \Swagger\Client\Model\DrugCoverageResponse getDrugCoverages($ndc_package_code, $audience, $state_code, $vericred_api_key)

Search for DrugCoverages

Drug Coverages are the specific tier level, quantity limit, prior authorization and step therapy for a given Drug/Plan combination. This endpoint returns all DrugCoverages for a given Drug

### Example 
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

$api_instance = new Vericred\Client\Api\DrugsApi();
$ndc_package_code = "12345-4321-11"; // string | NDC package code
$audience = "individual"; // string | Two-character state code
$state_code = "NY"; // string | Two-character state code
$vericred_api_key = "api-doc-key"; // string | API Key

try { 
    $result = $api_instance->getDrugCoverages($ndc_package_code, $audience, $state_code, $vericred_api_key);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling DrugsApi->getDrugCoverages: ', $e->getMessage(), "\n";
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **ndc_package_code** | **string**| NDC package code | 
 **audience** | **string**| Two-character state code | 
 **state_code** | **string**| Two-character state code | 
 **vericred_api_key** | **string**| API Key | [optional] 

### Return type

[**\Swagger\Client\Model\DrugCoverageResponse**](DrugCoverageResponse.md)

### Authorization

No authorization required

### HTTP request headers

 - **Content-Type**: Not defined
 - **Accept**: Not defined

[[Back to top]](#) [[Back to API list]](../README.md#documentation-for-api-endpoints) [[Back to Model list]](../README.md#documentation-for-models) [[Back to README]](../README.md)

# **listDrugs**
> \Swagger\Client\Model\DrugSearchResponse listDrugs($search_term, $vericred_api_key)

Drug Search

Search for drugs by proprietary name

### Example 
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

$api_instance = new Vericred\Client\Api\DrugsApi();
$search_term = "Zyrtec"; // string | Full or partial proprietary name of drug
$vericred_api_key = "api-doc-key"; // string | API Key

try { 
    $result = $api_instance->listDrugs($search_term, $vericred_api_key);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling DrugsApi->listDrugs: ', $e->getMessage(), "\n";
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **search_term** | **string**| Full or partial proprietary name of drug | 
 **vericred_api_key** | **string**| API Key | [optional] 

### Return type

[**\Swagger\Client\Model\DrugSearchResponse**](DrugSearchResponse.md)

### Authorization

No authorization required

### HTTP request headers

 - **Content-Type**: application/json
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../README.md#documentation-for-api-endpoints) [[Back to Model list]](../README.md#documentation-for-models) [[Back to README]](../README.md)

