# RequestPlanFind

## Properties
Name | Type | Description | Notes
------------ | ------------- | ------------- | -------------
**applicants** | [**\Swagger\Client\Model\RequestPlanFindApplicant[]**](RequestPlanFindApplicant.md) | Applicants for desired plans. | [optional] 
**enrollment_date** | **string** | Date of enrollment | [optional] 
**drug_packages** | [**\Swagger\Client\Model\DrugPackage[]**](DrugPackage.md) | National Drug Code Package Id | [optional] 
**fips_code** | **string** | County code to determine eligibility | [optional] 
**household_income** | **int** | Total household income. | [optional] 
**household_size** | **int** | Number of people living in household. | [optional] 
**market** | **string** | Type of plan to search for. | [optional] 
**providers** | [**\Swagger\Client\Model\RequestPlanFindProvider[]**](RequestPlanFindProvider.md) | List of providers to search for. | [optional] 
**zip_code** | **string** | 5-digit zip code - this helps determine pricing. | [optional] 

[[Back to Model list]](../README.md#documentation-for-models) [[Back to API list]](../README.md#documentation-for-api-endpoints) [[Back to README]](../README.md)


