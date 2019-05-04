//document.getElementById("auth_view-wrapper").style.display = "none";

// disable and hide sub categories
//document.getElementById("category_id_level_one").disabled = true;
//document.getElementById("category_id_level_one").style.display = "none";
//document.getElementById("category_id_level_one-label").style.display = "none";
//document.getElementById("category_id_level_two").disabled = true;
//document.getElementById("category_id_level_two").style.display = "none";
//document.getElementById("category_id_level_two-label").style.display = "none";


// get all sub categories value based on the selected category id
document.id('country_id').addEvent('change',function() {
    document.getElementById("state_id").disabled = true;
    document.getElementById("state_id").style.display = "none";   
	document.getElementById("state_id-label").style.display = "none";
	//document.getElementById("category_id_level_two").disabled = true;
	//document.getElementById("category_id_level_two").style.display = "none";
	//document.getElementById("category_id_level_two-label").style.display = "none";
	
	//document.getElementById("category_id_level_two").innerHTML = '';

	// making a ajax call to get subcategories
	//var url = en4.core.baseUrl+'Groupimporter/index/articlecategorieslevelone';
	var url = en4.core.baseUrl+'company/category/levelonecategories';
    var selection_category_id = this.get("value");
   // console.log(selection_category_id);
	var request= new Request.JSON({
		url: url,
		method: 'GET',
		data: {"category_id":selection_category_id},
		 onSuccess: function( response ) 
		   {
		   		if(response.posts){		   			
			   		document.getElementById("state_id").disabled = false;
	    			document.getElementById("state_id").style.display = "block";   
		            document.getElementById("state_id-label").style.display = "block";
		            $$('#state_id')[0].innerHTML = response.posts;
		   		}
		   		else{
		   			document.getElementById("state_id").innerHTML = '';
		   		}
			    
    	   }, onFailure: function(){
		   	 console.log('failed');
			}
		  });
		request.send();
});


// get all sub categories value based on the selected category id
//if(false){

	document.id('state_id').addEvent('change',function() {
		document.getElementById("city_id").disabled = true;
	    document.getElementById("city_id").style.display = "none";   
		document.getElementById("city_id-label").style.display = "none";

		// making a ajax call to get subcategories
	    //var url = en4.core.baseUrl+'ipimportcsv/index/articlecategoriesleveltwo';
		var url = en4.core.baseUrl+'company/category/leveltwocategories';
	    var selection_category_id = this.get("value");
	    
	    var request= new Request.JSON({
			url: url,
			method: 'GET',
			data: {"category_id":selection_category_id},
			 onSuccess: function( response ) 
			   {
			   		if(response.posts){		   			
				   		document.getElementById("city_id").disabled = false;
		    			document.getElementById("city_id").style.display = "block";   
			            document.getElementById("city_id-label").style.display = "block";
			            $$('#city_id')[0].innerHTML = response.posts;
			   		}
				    
	    	   }, onFailure: function(){
			   	 console.log('failed');
				}
			  });
			request.send();
	}); 
//}
	
	document.id('industry_id').addEvent('change',function() {
		document.getElementById("sector_id").disabled = true;
	    document.getElementById("sector_id").style.display = "none";   
		document.getElementById("sector_id-label").style.display = "none";

		// making a ajax call to get subcategories
	    //var url = en4.core.baseUrl+'ipimportcsv/index/articlecategoriesleveltwo';
		var url = en4.core.baseUrl+'company/category/sectors';
	    var selection_category_id = this.get("value");
	    
	    var request= new Request.JSON({
			url: url,
			method: 'GET',
			data: {"industry_id":selection_category_id},
			 onSuccess: function( response ) 
			   {
			   		if(response.posts){		   			
				   		document.getElementById("sector_id").disabled = false;
		    			document.getElementById("sector_id").style.display = "block";   
			            document.getElementById("sector_id-label").style.display = "block";
			            $$('#sector_id')[0].innerHTML = response.posts;
			   		}
				    
	    	   }, onFailure: function(){
			   	 console.log('failed');
				}
			  });
			request.send();
	}); 
	
	
	
	
	
	
	
	
	
	
	


var uploadFileCounter = 0;
function CreateFileUploadButton(){
    
    if(uploadFileCounter < 5){
	    var div = document.createElement('DIV');
	    div.innerHTML = '<input id="article_file-' + uploadFileCounter + '" name = "article_file[]" class="custom-file-input" type="file" />' +
	                     '<input class="RemoveUploadedFile" id="RemoveUploadedFile' + uploadFileCounter + '" type="button" ' + 'value="Remove" onclick = "RemoveFileUploadButton(this)" />';
	    document.getElementById("targetFileUpload_div").appendChild(div);  
	    uploadFileCounter++;
    }
    else{
    	alert("You can upload upto five files only.");
    }
}

function RemoveFileUploadButton(div)
{
     document.getElementById("targetFileUpload_div").removeChild(div.parentNode);
     uploadFileCounter--;
}