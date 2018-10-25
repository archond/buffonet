<script type="text/javascript">
	$(document).ready(function(){
		
		$('body').on('change', '.myselect', function(){

			var changedElement = $(this); 
			changedElement.nextAll().each(function(){ 
				this.remove();
			});
			var id = changedElement.val();
			var formGroupElement = changedElement.closest('.form-group'); 

			var url = '/<?php echo e($selectedLanguage['abbr']); ?>/category/'+id+'/get-children';

			$.ajax({
				method: "GET",
				dataType: "json",
				url: url,
				success: function(data){
					console.log(data);
					var options = '';
					
					$.each( data, function( key, value ) {

						options = options+'<option value='+value.category_id+'>'+value.name+'</option>';
					});

					if(data.length >0){  
						options = '<option value='+id+'>-</option>'+options;
					}


					if(!options){
						return false;
					}
					var divOptions = options;
					newElement = changedElement.clone();


					newElement.find('option').remove(); 
					newElement = newElement.append(divOptions); 
//					console.log(newElement[0]);
					$( newElement[0] ).insertAfter( changedElement );


				}
			});
		});

	});

</script>
