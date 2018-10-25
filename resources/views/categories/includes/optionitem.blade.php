{{--

<option>{{$category['slug']}}</option>

<optgroup label={{$category['slug']}}>


		

			@if(isset($category['all_children']))

			@foreach($category['all_children'] as $category)
			@include('categories.includes.optionitem', ['categories'=>$category['children']]) 
			@endforeach

			@elseif(isset($category['children']))

			@foreach($category['children'] as $category) 
			@include('categories.includes.optionitem', ['categories'=>isset($category['children']) ? $category['children'] : [] ])
			@endforeach

			@endif


</optgroup>

--}}