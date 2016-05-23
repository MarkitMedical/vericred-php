# Vericred\Client\ZipCountiesApi

All URIs are relative to *https://api.vericred.com/*

Method | HTTP request | Description
------------- | ------------- | -------------
[**getZipCounties**](ZipCountiesApi.md#getZipCounties) | **GET** /zip_counties | Search for Zip Counties


# **getZipCounties**
> \Swagger\Client\Model\ZipCountyResponse getZipCounties($zip_prefix, $vericred_api_key)

Search for Zip Counties

Our `Plan` endpoints require a zip code and a fips (county) code.  This is because plan pricing requires both of these elements.  Users are unlikely to know their fips code, so we provide this endpoint to look up a `ZipCounty` by zip code and return both the selected zip and fips codes.

### Example 
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

$api_instance = new Vericred\Client\Api\ZipCountiesApi();
$zip_prefix = "1002"; // string | Partial five-digit Zip
$vericred_api_key = "api-doc-key"; // string | API Key

try { 
    $result = $api_instance->getZipCounties($zip_prefix, $vericred_api_key);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling ZipCountiesApi->getZipCounties: ', $e->getMessage(), "\n";
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **zip_prefix** | **string**| Partial five-digit Zip | 
 **vericred_api_key** | **string**| API Key | [optional] 

### Return type

[**\Swagger\Client\Model\ZipCountyResponse**](ZipCountyResponse.md)

### Authorization

No authorization required

### HTTP request headers

 - **Content-Type**: Not defined
 - **Accept**: Not defined

[[Back to top]](#) [[Back to API list]](../README.md#documentation-for-api-endpoints) [[Back to Model list]](../README.md#documentation-for-models) [[Back to README]](../README.md)

