$(window).addEvent('domready', function() {
	new Accordion($$('span.toggle_comments'),
		$$('div.task_comments'), {
			display: -1,
			alwaysHide: true,
			onActive: function(toggler, element) {
				var img = $(toggler).getElement('img');
				img.src = img.src.replace(/folPlus\.gif/, 'folMinus.gif');
			},
			onBackground: function(toggler, element) {
				var img = $(toggler).getElement('img');
				img.src = img.src.replace(/folMinus\.gif/, 'folPlus.gif');
			}
		});
});