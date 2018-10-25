		$(function(){
			$metaTitle={
				min:5,
				max:60
			};
			$metaKeywords={
				min:5,
				max:256
			};
			$metaDescription={
				min:10,
				max:160
			};


			$('body').on('keyup', '.meta_title', function(){
				characterToolTip($(this), $metaTitle.min, $metaTitle.max)
			}).on('keyup', '.meta_keywords', function(){
				characterToolTip($(this), $metaKeywords.min, $metaKeywords.max)
			}).on('keyup', '.meta_description', function(){
				characterToolTip($(this), $metaDescription.min, $metaDescription.max)
			});


			$( '.meta_title').each(function() {
				characterToolTip($(this), $metaTitle.min, $metaTitle.max)
			});

			$( '.meta_keywords').each(function() {
				characterToolTip($(this), $metaKeywords.min, $metaKeywords.max)
			});

			$( '.meta_description').each(function() {
				characterToolTip($(this), $metaDescription.min, $metaDescription.max)
			});

			function characterToolTip(obj, min, max){
				var dd, left, color, count;
				count = obj.val().length;
				color = (count <= max && count >= min)?'#6CB76C':'#E87A7A'; 
				left = max-count;

				obj.attr('data-original-title',((left>0)?'Left: ':'Over: ')+(left));
				obj.tooltip({trigger:'manual'}).tooltip('show');

				dd = obj.next(); 
				dd.find('.tooltip-inner')[0].setAttribute('style','background-color:'+color+';padding:0 2px');
				dd[0].setAttribute('style','right:15px;margin-top:12px;top:-17px;font-size:10px')
				dd.find('.tooltip-arrow')[0].style.display = 'none';
			}
		});