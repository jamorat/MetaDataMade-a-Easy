<?php 

class metaTools
{
	function listAllMetaForResource($resourceType,$resourceID){
		global $shops_myshopify_domain, $api_key, $password;
		$shopify = shopify_api_client($shops_myshopify_domain, NULL, $api_key, $password, true);
	
		try
		{ 
			$metaItems = $shopify('GET', '/admin/'.$resourceType.'/'.$resourceID.'/metafields.json');
			echo json_encode($metaItems);
		}
		
		catch (ShopifyApiException $e)
		{	
		}
		catch (ShopifyCurlException $e)
		{
		}
	}
	
	function confirmIfResourceMetaItemExists($resourceType,$resourceID,$resourceMetaItemID){
		global $shops_myshopify_domain, $api_key, $password;
		$shopify = shopify_api_client($shops_myshopify_domain, NULL, $api_key, $password, true);
	
		try
		{ 
			//Get all customer metafields
			$metaItems = $shopify('GET', '/admin/'.$resourceType.'/'.$resourceID.'/metafields/'.$resourceMetaItemID.'.json');
			
			return true;				
		}
		
		catch (ShopifyApiException $e)
		{				
				return false;		
		}
		catch (ShopifyCurlException $e)
		{
		$e->getMessage(); //returns value of curl_errno() and $e->getCode() returns value of curl_ error()
		print $e;
		}		
	}
	
	
	function writeMetatoCustomer($resourceType,$resourceID4write,$namespace4write,$key4write,$value4write,$valueType4write,$postOrPut4write,$resourceMetaItemID)
	{
		global $shops_myshopify_domain, $api_key, $password;
		//THIS CAN PROBABLY BE ABSTRACTED INTO LOGINS FILE
		$cURLString =  "https://$api_key:$password@$shops_myshopify_domain/admin/".$resourceType."/".$resourceID4write;
		//SHOULD IT WRITE OR UPDATE
		if ($postOrPut4write == 'PUT' && $this->confirmIfResourceMetaItemExists($resourceType,$resourceID4write,$resourceMetaItemID) == false) //THEN WRITE
		{
			$postOrPut4write = 'POST';
			$data_string = '{"metafield": {"namespace": "'.$namespace4write.'","key": '.$this->getHighestMetafieldId($resourceID4write).',"value": "'.$value4write.'","value_type": "string"}}';
			$cURLString .= "/metafields.json";
		}
		else //if does exist OR is not new, THEN DO UPDATE
		{
			$data_string = '{"metafield": {"id": '.$resourceMetaItemID.',"value": "'.$value4write.'","value_type": "string"}}';
			$cURLString .= "/metafields/".$resourceMetaItemID.".json";
		} //end if
		$this->executeCURL($cURLString, $postOrPut4write, $data_string);
	
	
	} //end function
	
	
	function getHighestMetafieldId($resourceID4write)
	{
		// For regular apps:
		//$shopify = shopify_api_client($shops_myshopify_domain, $shops_token, $api_key, $shared_secret);
	
		// For private apps:
		global $shops_myshopify_domain, $api_key, $password;
		$shopify = shopify_api_client($shops_myshopify_domain, NULL, $api_key, $password, true);
	
		try
		{ 
			// Get all products
			$products = $shopify('GET', '/admin/customers/'.$resourceID4write.'/metafields.json');
			$theMax = 100;
			for($i = 0; $i < count($products); $i++) 
			{
				if ($products[$i]['id'] > $theMax)
				{
				$theMax = $products[$i]['id'];
				}
			}
		return $theMax;
		}
		
		catch (ShopifyApiException $e)
		{
		}
		
		catch (ShopifyCurlException $e)
		{
		$e->getMessage(); //returns value of curl_errno() and $e->getCode() returns value of curl_ error()
		print $e;
		}
    }

	function deleteThisMetaField($resourceType,$resourceID4write,$resourceMetaItemID){
	
		if ($this->confirmIfResourceMetaItemExists($resourceType,$resourceID4write,$resourceMetaItemID) == true){
			// For regular apps:
			//$shopify = shopify_api_client($shops_myshopify_domain, $shops_token, $api_key, $shared_secret);
		
			// For private apps:
			global $shops_myshopify_domain, $api_key, $password;
			$shopify = shopify_api_client($shops_myshopify_domain, NULL, $api_key, $password, true);
		
			try
			{ 
			$products = $shopify('DELETE', '/admin/'.$resourceType.'/'.$resourceID4write.'/metafields/'. $resourceMetaItemID .'.json');
			
			}
			catch (ShopifyCurlException $e)
			{
				$e->getMessage(); //returns value of curl_errno() and $e->getCode() returns value of curl_ error()
				print $e;
			
			}
		} else
		{
			echo 'There is no item to delete';
		}
	}

	private function executeCURL($cURLString, $postOrPut4write, $data_string)
	{
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $cURLString);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $postOrPut4write);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);                                     
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);                                                                     
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json','Content-Length: ' . strlen($data_string)));
		$result = curl_exec($ch);
		$dataD=json_decode($result);
		return $dataD->metafield->id;
	}
}
?>