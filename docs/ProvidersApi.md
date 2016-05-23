# Vericred\Client\ProvidersApi

All URIs are relative to *https://api.vericred.com/*

Method | HTTP request | Description
------------- | ------------- | -------------
[**getProvider**](ProvidersApi.md#getProvider) | **GET** /providers/{npi} | Find a Provider
[**getProviders**](ProvidersApi.md#getProviders) | **POST** /providers/search | Find Providers


# **getProvider**
> \Swagger\Client\Model\ProviderResponse getProvider($npi, $vericred_api_key)

Find a Provider

To retrieve a specific provider, just perform a GET using his NPI number

### Example 
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

$api_instance = new Vericred\Client\Api\ProvidersApi();
$npi = "1234567890"; // string | NPI number
$vericred_api_key = "api-doc-key"; // string | API Key

try { 
    $result = $api_instance->getProvider($npi, $vericred_api_key);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling ProvidersApi->getProvider: ', $e->getMessage(), "\n";
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **npi** | **string**| NPI number | 
 **vericred_api_key** | **string**| API Key | [optional] 

### Return type

[**\Swagger\Client\Model\ProviderResponse**](ProviderResponse.md)

### Authorization

No authorization required

### HTTP request headers

 - **Content-Type**: Not defined
 - **Accept**: Not defined

[[Back to top]](#) [[Back to API list]](../README.md#documentation-for-api-endpoints) [[Back to Model list]](../README.md#documentation-for-models) [[Back to README]](../README.md)

# **getProviders**
> \Swagger\Client\Model\ProvidersSearchResponse getProviders($body)

Find Providers

All `Provider` searches require a `zip_code`, which we use for weighting
the search results to favor `Provider`s that are near the user.  For example,
we would want "Dr. John Smith" who is 5 miles away to appear before
"Dr. John Smith" who is 100 miles away.

The weighting also allows for non-exact matches.  In our prior example, we
would want "Dr. Jon Smith" who is 2 miles away to appear before the exact
match "Dr. John Smith" who is 100 miles away because it is more likely that
the user just entered an incorrect name.

The free text search also supports Specialty name search and "body part"
Specialty name search.  So, searching "John Smith nose" would return
"Dr. John Smith", the ENT Specialist before "Dr. John Smith" the Internist.


### Example 
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

$api_instance = new Vericred\Client\Api\ProvidersApi();
$body = new \Swagger\Client\Model\RequestProvidersSearch(); // \Swagger\Client\Model\RequestProvidersSearch | 

try { 
    $result = $api_instance->getProviders($body);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling ProvidersApi->getProviders: ', $e->getMessage(), "\n";
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **body** | [**\Swagger\Client\Model\RequestProvidersSearch**](\Swagger\Client\Model\RequestProvidersSearch.md)|  | [optional] 

### Return type

[**\Swagger\Client\Model\ProvidersSearchResponse**](ProvidersSearchResponse.md)

### Authorization

No authorization required

### HTTP request headers

 - **Content-Type**: Not defined
 - **Accept**: Not defined

[[Back to top]](#) [[Back to API list]](../README.md#documentation-for-api-endpoints) [[Back to Model list]](../README.md#documentation-for-models) [[Back to README]](../README.md)

